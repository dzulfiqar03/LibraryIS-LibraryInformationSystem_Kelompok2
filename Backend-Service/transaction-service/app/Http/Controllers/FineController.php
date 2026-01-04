<?php

namespace App\Http\Controllers;

use App\Http\Requests\FineRequest;
use App\Services\FineService;
use App\Models\FinePayment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use function PHPUnit\Framework\isEmpty;

class FineController extends Controller
{
    protected $fineService;

    public function __construct(FineService $fineService)
    {
        $this->fineService = $fineService;
    }

    public function getAllFine()
    {
        $transaction = Transaction::with(['transaction_details', 'fine_payment'])
            ->whereHas('fine_payment')
            ->get();
        return [
            'fineList' => $transaction
        ];
    }

    public function getMemberFines(Request $request, $memberId): JsonResponse
    {
        try {
            $fines = $this->fineService->getMemberFines($memberId);
            $totalFine = $this->fineService->getMemberTotalFine($memberId);

            if (isEmpty($fines) && $totalFine == 0) {
                return response()->json([
                    'success' => True,
                    'message' => "Member Not Have Fine",
                ]);
            } elseif (isEmpty($fines) && $totalFine > 0) {
                return response()->json([
                    'success' => True,
                    'message' => "Member Success Found",
                    'data' => [
                        'fines' => "Member ini belum memiliki denda overdue",
                        'total_unpaid_fine' => $totalFine
                    ]
                ]);
            }
            return response()->json([
                'success' => True,
                'message' => "Member Success Found",
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

    public function createFine(FineRequest $request): JsonResponse
    {
        try {
            $finePayment = $this->fineService->createFinePayment($request->validated()['id_transaction']);

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
            if (isEmpty($fines)) {
                return response()->json([
                    'success' => "Data Member belum bayar belum ada",
                ]);
            }
            return response()->json([
                'success' => "Data Member belum bayar ditemukan",
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
