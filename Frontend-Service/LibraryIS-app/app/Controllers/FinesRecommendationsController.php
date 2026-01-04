<?php

namespace App\Controllers;

use App\Services\FineService;
use App\Services\RecommendationService;
use App\Services\BookService;
use CodeIgniter\Controller;

class FinesRecommendationsController extends Controller
{
    protected $fineService;
    protected $recommendationService;
    protected $bookService;

    public function __construct()
    {
        $this->fineService = new FineService();
        $this->recommendationService = new RecommendationService();
        $this->bookService = new BookService();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $memberId = session()->get('user.id') ?? session()->get('member_data.id');
        
        try {
            // Get member's fines
            $finesResponse = $this->fineService->getMemberFines($memberId);
            $fines = $finesResponse['success'] ? $finesResponse['data'] : ['fines' => [], 'total_unpaid_fine' => 0];

            // Get member's recommendations
            $recommendationsResponse = $this->recommendationService->getMemberRecommendations($memberId);
            $recommendations = $recommendationsResponse['success'] ? $recommendationsResponse['data'] : [];

            // Get book details for recommendations
            $recommendationsWithBooks = [];
            foreach ($recommendations as $recommendation) {
                try {
                    $bookResponse = $this->bookService->getBook($recommendation['id_book']);
                    if ($bookResponse['success']) {
                        $recommendation['book'] = $bookResponse['data'];
                        $recommendationsWithBooks[] = $recommendation;
                    }
                } catch (\Exception $e) {
                    // Skip if book not found
                    continue;
                }
            }

            $data = [
                'title' => 'Denda & Rekomendasi',
                'fines' => $fines,
                'recommendations' => $recommendationsWithBooks,
                'memberId' => $memberId
            ];

            return view('fines_recommendations/index', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Error loading fines and recommendations: ' . $e->getMessage());
            return view('fines_recommendations/index', [
                'title' => 'Denda & Rekomendasi',
                'error' => 'Gagal memuat data: ' . $e->getMessage(),
                'fines' => ['fines' => [], 'total_unpaid_fine' => 0],
                'recommendations' => [],
                'memberId' => $memberId
            ]);
        }
    }

    public function payFine()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $fineId = $this->request->getPost('fine_id');
        $paymentMethod = $this->request->getPost('payment_method', FILTER_SANITIZE_STRING) ?? 'cash';

        try {
            $response = $this->fineService->payFine($fineId, $paymentMethod);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Denda berhasil dibayar!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal membayar denda: ' . $e->getMessage()
            ]);
        }
    }

    public function generateRecommendations()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $memberId = session()->get('user.id') ?? session()->get('member_data.id');

        try {
            $response = $this->recommendationService->generateRecommendations($memberId);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Rekomendasi berhasil dibuat!',
                'data' => $response['data'] ?? []
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal membuat rekomendasi: ' . $e->getMessage()
            ]);
        }
    }

    public function markRecommendationViewed()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $recommendationId = $this->request->getPost('recommendation_id');

        try {
            $response = $this->recommendationService->markAsViewed($recommendationId);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Rekomendasi ditandai sebagai dilihat'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menandai rekomendasi: ' . $e->getMessage()
            ]);
        }
    }
}