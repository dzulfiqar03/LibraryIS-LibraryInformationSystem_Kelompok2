<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        // TODO: Fetch dashboard data from backend API
        $data = [
            'currentlyBorrowed' => 3,
            'outstandingFines' => 5.00,
            'activeReservations' => 2,
            'membershipStatus' => 'Active',
            'membershipExpiry' => '2025-12-31',
            'borrowings' => [],
            'recommendations' => [],
        ];

        return view('member/dashboard', $data);
    }
}
