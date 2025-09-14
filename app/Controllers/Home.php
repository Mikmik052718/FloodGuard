<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Check if user has an active session and is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Please login to access this page');
        }

        // Optional: Check if user has the correct role (user or admin)
        $userRole = session()->get('role');
        if (!in_array($userRole, ['user', 'admin'])) {
            return redirect()->to('/auth/login')->with('error', 'Invalid user role');
        }

        // Pass user data to the view if needed
        $data = [
            'username' => session()->get('username'),
            'user_id' => session()->get('user_id'),
            'role' => session()->get('role')
        ];

        return view('Homepage', $data);
    }
}
