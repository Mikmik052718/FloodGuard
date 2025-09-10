<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // Login page
    public function login()
    {
        return view('auth/login');
    }

    // Attempt login
    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Check if the user exists in the database
        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Set session data
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'logged_in' => true,
            ]);

            // Redirect to the admin dashboard if the user is an admin
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/admin_dashboard');  // Redirect to admin dashboard route
            } else {
                return redirect()->to('/forum');  // Redirect to the forum for non-admin users
            }
        } else {
            // Invalid login credentials
            return redirect()->back()->with('error', 'Invalid login');
        }
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }

    // Registration page
    public function register()
    {
        return view('auth/registration');
    }

    // Handle registration
    public function handleRegister()
    {
        $session = session();
        $model = new UserModel();

        // Get data from the form
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirm = $this->request->getPost('confirm_password');

        // Basic validation
        if ($password !== $confirm) {
            return redirect()->back()->withInput()->with('error', 'Passwords do not match.');
        }

        // Check if username already exists
        if ($model->where('username', $username)->first()) {
            return redirect()->back()->withInput()->with('error', 'Username already exists.');
        }

        // Check if email is already registered
        if ($model->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email already registered.');
        }

        // Save new user data to the database
        $model->save([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user'  // Default role is 'user'
        ]);

        return redirect()->to('auth/login')->with('success', 'Registration successful! You can now login.');
    }
}
