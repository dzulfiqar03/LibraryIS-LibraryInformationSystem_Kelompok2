<?php

namespace App\Http\Controllers;

use App\Services\FineService;
use App\Models\FinePayment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FineController extends Controller
{
    protected $fineService;

    public function __construct(FineService $fineService)
    {
        $this->fineService = $fineService;
    }

    public function getMemberFines(Request $request, $memberId): JsonResponse
    {
        try {
            $fines = $this->fineService->getMemberFines($memberId);
            $totalFine = $this->fineService->getMemberTotalFine($memberId);

            return response()->json([
                'success' => true,
                'data' => [
                    'fines' => $fines,
                    'total_unpaid_fine' => $totalFine
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get member fines: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createFine(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'id_transaction' => 'required|string|exists:transactions,id'
            ]);

            $finePayment = $this->fineService->createFinePayment($request->id_transaction);

            return response()->json([
                'success' => true,
                'message' => 'Fine created successfully',
                'data' => $finePayment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create fine: ' . $e->getMessage()
            ], 500);
        }
    }

    public function payFine(Request $request, $fineId): JsonResponse
    {
        try {
            $request->validate([
                'payment_method' => 'required|string|in:cash,transfer,credit_card'
            ]);

            $finePayment = $this->fineService->payFine($fineId, $request->payment_method);

            return response()->json([
                'success' => true,
                'message' => 'Fine paid successfully',
                'data' => $finePayment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to pay fine: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllUnpaidFines(): JsonResponse
    {
        try {
            $fines = $this->fineService->getAllUnpaidFines();

            return response()->json([
                'success' => true,
                'data' => $fines
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get unpaid fines: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getFineDetails($fineId): JsonResponse
    {
        try {
            $fine = FinePayment::with('transaction')->find($fineId);

            if (!$fine) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fine not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $fine
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get fine details: ' . $e->getMessage()
            ], 500);
        }
    }
}
