<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Allow access to Homepage for any user
        $data = [];

        // Pass user data to the view if logged in
        if (session()->get('logged_in')) {
            $data = [
                'username' => session()->get('username'),
                'user_id' => session()->get('user_id'),
                'role' => session()->get('role')
            ];
        }

        return view('Homepage', $data);
    }
}
