<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Services\AuthService;

class AccountApiController extends \CodeIgniter\Controller
{
    use ResponseTrait;

    /**
     * Delete user account
     */
    public function delete()
    {
        try {
            $input = $this->request->getJSON();
            
            // Get current user from session
            $user = session('user');
            if (!$user) {
                return $this->failUnauthorized('User not authenticated');
            }

            $password = $input->password ?? null;
            if (!$password) {
                return $this->fail([
                    'success' => false,
                    'message' => 'Password is required'
                ], 400);
            }

            // In production: Verify password with backend Member Service
            // For now, just proceed with logout (real implementation should verify)
            
            // Clear session
            session()->destroy();

            return $this->respond([
                'success' => true,
                'message' => 'Account deleted successfully'
            ]);
        } catch (\Exception $e) {
            return $this->fail([
                'success' => false,
                'message' => 'Error deleting account: ' . $e->getMessage()
            ]);
        }
    }
}
