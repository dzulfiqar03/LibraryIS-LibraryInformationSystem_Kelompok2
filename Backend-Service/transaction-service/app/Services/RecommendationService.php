<?php

namespace App\Services;

use App\Models\Recommendation;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RecommendationService
{
    public function generateRecommendationsForMember($memberId)
    {
        // Clear old inactive recommendations
        Recommendation::where('id_member', $memberId)->delete();

        $recommendations = [];

        // Get member's transaction history
        $memberTransactions = Transaction::where('id_member', $memberId)
            ->whereNotNull('return_date')
            ->get();

        if ($memberTransactions->isEmpty()) {
            // For new members, recommend popular books
            $recommendations = array_merge($recommendations, $this->getPopularBooksRecommendations($memberId));
        } else {
            // Based on borrowing history
            $recommendations = array_merge($recommendations, $this->getSimilarBooksRecommendations($memberId, $memberTransactions));

            // Add some popular books too
            $popularRecommendations = $this->getPopularBooksRecommendations($memberId, 3);
            $recommendations = array_merge($recommendations, $popularRecommendations);
        }

        // Save recommendations to database
        foreach ($recommendations as $rec) {
            $this->saveRecommendation($memberId, $rec);
        }

        return $recommendations;
    }

    private function getSimilarBooksRecommendations($memberId, $memberTransactions, $limit = 5)
    {
        $recommendations = [];
        $borrowedBookIds = $memberTransactions->pluck('id_book')->toArray();

        // This is a simplified recommendation algorithm
        // In a real system, you might use more sophisticated algorithms

        // Find books borrowed by users who also borrowed similar books
        $similarUserTransactions = Transaction::whereIn('id_book', $borrowedBookIds)
            ->where('id_member', '!=', $memberId)
            ->whereNotNull('return_date')
            ->get()
            ->groupBy('id_member');

        $bookScores = [];

        foreach ($similarUserTransactions as $userTransactions) {
            foreach ($userTransactions as $transaction) {
                if (!in_array($transaction->id_book, $borrowedBookIds)) {
                    $bookId = $transaction->id_book;
                    $bookScores[$bookId] = ($bookScores[$bookId] ?? 0) + 1;
                }
            }
        }

        // Sort by score and take top recommendations
        arsort($bookScores);
        $topBooks = array_slice($bookScores, 0, $limit, true);

        foreach ($topBooks as $bookId => $score) {
            $recommendations[] = [
                'id_book' => $bookId,
                'type' => 'similar_users',
                'score' => min(10.0, $score * 2), // Cap at 10
                'reason' => 'Users with similar interests also borrowed this book'
            ];
        }

        return $recommendations;
    }

    private function getPopularBooksRecommendations($memberId, $limit = 5)
    {
        $recommendations = [];

        // Get most borrowed books in the last 3 months
        $popularBooks = Transaction::where('borrow_date', '>=', now()->subMonths(3))
            ->whereNotNull('return_date')
            ->selectRaw('id_book, COUNT(*) as borrow_count')
            ->groupBy('id_book')
            ->orderByDesc('borrow_count')
            ->limit($limit)
            ->get();

        foreach ($popularBooks as $book) {
            $score = min(10.0, $book->borrow_count * 0.5); // Scale score

            $recommendations[] = [
                'id_book' => $book->id_book,
                'type' => 'popular',
                'score' => $score,
                'reason' => "Popular choice - borrowed {$book->borrow_count} times recently"
            ];
        }

        return $recommendations;
    }

    private function saveRecommendation($memberId, $recommendation)
    {
        return Recommendation::create([
            'id' => Str::uuid(),
            'id_member' => $memberId,
            'id_book' => $recommendation['id_book'],
            'type' => $recommendation['type'],
            'score' => $recommendation['score'],
            'reason' => $recommendation['reason'],
            'is_active' => true,
            'recommended_at' => now()
        ]);
    }

    public function getMemberRecommendations($memberId, $limit = 10)
    {
        return Recommendation::forMember($memberId)
            ->active()
            ->highScore()
            ->limit($limit)
            ->get();
    }

    public function markRecommendationAsViewed($recommendationId)
    {
        $recommendation = Recommendation::find($recommendationId);
        if ($recommendation) {
            $recommendation->update(['is_active' => false]);
        }
        return $recommendation;
    }

    public function refreshRecommendations($memberId)
    {
        return $this->generateRecommendationsForMember($memberId);
    }
}
