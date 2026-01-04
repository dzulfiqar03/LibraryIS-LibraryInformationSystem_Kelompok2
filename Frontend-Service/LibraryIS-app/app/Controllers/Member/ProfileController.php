<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    public function index()
    {
        // TODO: Fetch user profile from backend API
        $data = [
            'user' => session()->get('user'),
        ];

        return view('member/profile', $data);
    }

    public function update()
    {
        // TODO: Validate and update profile via backend API
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'permit_empty',
            'address' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // TODO: Call backend API to update profile
        session()->set('success', 'Profile updated successfully');
        return redirect()->to('/member/profile');
    }

    public function settings()
    {
        // TODO: Fetch user settings from backend API
        $data = [
            'user' => session()->get('user'),
            'settings' => [],
        ];

        return view('member/settings', $data);
    }

    public function updateSettings()
    {
        // TODO: Call backend API to update settings
        session()->set('success', 'Settings updated successfully');
        return redirect()->to('/member/settings');
    }
}
