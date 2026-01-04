<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;

class SettingsApiController extends \CodeIgniter\Controller
{
    use ResponseTrait;

    /**
     * Update user settings
     */
    public function update()
    {
        try {
            $input = $this->request->getJSON();
            
            // Get current user from session
            $user = session('user');
            if (!$user) {
                return $this->failUnauthorized('User not authenticated');
            }

            // Store settings in session
            $settings = [
                'email_notifications' => $input->email_notifications ?? true,
                'reminder_notifications' => $input->reminder_notifications ?? true,
                'new_books_notifications' => $input->new_books_notifications ?? false,
                'newsletter' => $input->newsletter ?? false,
                'public_profile' => $input->public_profile ?? true,
                'show_history' => $input->show_history ?? false,
                'allow_messages' => $input->allow_messages ?? true,
                'dark_mode' => $input->dark_mode ?? false,
                'books_per_page' => $input->books_per_page ?? '20',
                'default_view' => $input->default_view ?? 'grid'
            ];

            // In production, save to database
            // For now, store in session
            session()->set('user_settings', $settings);

            return $this->respond([
                'success' => true,
                'message' => 'Settings updated successfully',
                'settings' => $settings
            ]);
        } catch (\Exception $e) {
            return $this->fail([
                'success' => false,
                'message' => 'Error updating settings: ' . $e->getMessage()
            ]);
        }
    }
}
