<?php

namespace App\Http\Controllers;

use App\Services\RecommendationService;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RecommendationController extends Controller
{
    protected $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function getMemberRecommendations(Request $request, $memberId): JsonResponse
    {
        try {
            $limit = $request->get('limit', 10);
            $recommendations = $this->recommendationService->getMemberRecommendations($memberId, $limit);

            return response()->json([
                'success' => true,
                'data' => $recommendations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get recommendations: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateRecommendations(Request $request, $memberId): JsonResponse
    {
        try {
            $recommendations = $this->recommendationService->generateRecommendationsForMember($memberId);

            return response()->json([
                'success' => true,
                'message' => 'Recommendations generated successfully',
                'data' => $recommendations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate recommendations: ' . $e->getMessage()
            ], 500);
        }
    }

    public function refreshRecommendations(Request $request, $memberId): JsonResponse
    {
        try {
            $recommendations = $this->recommendationService->refreshRecommendations($memberId);

            return response()->json([
                'success' => true,
                'message' => 'Recommendations refreshed successfully',
                'data' => $recommendations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to refresh recommendations: ' . $e->getMessage()
            ], 500);
        }
    }

    public function markAsViewed(Request $request, $recommendationId): JsonResponse
    {
        try {
            $recommendation = $this->recommendationService->markRecommendationAsViewed($recommendationId);

            if (!$recommendation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recommendation not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Recommendation marked as viewed',
                'data' => $recommendation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark recommendation as viewed: ' . $e->getMessage()
            ], 500);
        }
    }
}
