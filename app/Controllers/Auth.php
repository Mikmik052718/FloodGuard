<?php

namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

public function attemptLogin()
{
    $session = session();
    $model = new UserModel();

    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $user = $model->where('username', $username)->first();

    if ($user && password_verify($password, $user['password'])) {
        $session->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'logged_in' => true,
        ]);

                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin/posts');
                } else {
                    return redirect()->to('/forum');
                }
    } else {
        return redirect()->back()->with('error', 'Invalid login');
    }
}


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }

public function register()
{
    return view('auth/registration');
}

public function handleRegister()
{
    $session = session();
    $model = new UserModel();

    $username = $this->request->getPost('username');
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');
    $confirm = $this->request->getPost('confirm_password');

    // Basic validation
    if ($password !== $confirm) {
        return redirect()->back()->withInput()->with('error', 'Passwords do not match.');
    }

    if ($model->where('username', $username)->first()) {
        return redirect()->back()->withInput()->with('error', 'Username already exists.');
    }

    if ($model->where('email', $email)->first()) {
        return redirect()->back()->withInput()->with('error', 'Email already registered.');
    }

    $model->save([
        'username' => $username,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'user'  // default role
    ]);

    return redirect()->to('auth/login')->with('success', 'Registration successful! You can now login.');
}


}
