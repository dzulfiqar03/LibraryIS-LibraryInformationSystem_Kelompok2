<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    /**
     * Show admin dashboard
     */
    public function index(): ResponseInterface
    {
        return $this->response->setBody(
            view('admin/dashboard', [
                'user' => session()->get('user')
            ])
        );
    }
}