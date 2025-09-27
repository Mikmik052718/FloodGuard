<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // Login page
    public function adlogin()
    {
        return view('auth/adlogin');
    }

    public function uslogin()
    {
        return view('auth/uslogin');
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
            } elseif ($user['role'] === 'user') {
                return redirect()->to('/forum');
            } else {
                return redirect()->to('/landing');  // Redirect to the forum for non-admin users
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
        return redirect()->to('/auth/uslogin');
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
        $alert_email_enabled = $this->request->getPost('alert_email_enabled') ?? 1; // Default to 1 if not set

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
            'role' => 'user',  // Default role is 'user'
            'alert_email_enabled' => $alert_email_enabled
        ]);

        return redirect()->to('auth/uslogin')->with('success', 'Registration successful! You can now login.');
    }

    // Google OAuth Login
    public function googleLogin()
    {
        $googleConfig = config('Google');

        $client = new \Google_Client();
        $client->setClientId($googleConfig->clientId);
        $client->setClientSecret($googleConfig->clientSecret);
        $client->setRedirectUri($googleConfig->redirectUri);
        $client->addScope($googleConfig->scopes);

        // Generate and store state for CSRF protection
        $state = bin2hex(random_bytes(16));
        session()->set('oauth_state', $state);
        $client->setState($state);

        // Get authorization URL
        $authUrl = $client->createAuthUrl();

        return redirect()->to($authUrl);
    }

    // Google OAuth Callback
    public function googleCallback()
    {
        $googleConfig = config('Google');
        $model = new UserModel();

        // Verify state parameter for CSRF protection
        $state = $this->request->getGet('state');
        if ($state !== session()->get('oauth_state')) {
            return redirect()->to('/auth/uslogin')->with('error', 'Invalid OAuth state');
        }

        // Check for error
        if ($this->request->getGet('error')) {
            return redirect()->to('/auth/uslogin')->with('error', 'Google login failed');
        }

        // Get authorization code
        $code = $this->request->getGet('code');
        if (!$code) {
            return redirect()->to('/auth/uslogin')->with('error', 'Authorization code missing');
        }

        try {
            // Exchange code for access token
            $client = new \Google_Client();
            $client->setClientId($googleConfig->clientId);
            $client->setClientSecret($googleConfig->clientSecret);
            $client->setRedirectUri($googleConfig->redirectUri);

            $token = $client->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                return redirect()->to('/auth/uslogin')->with('error', 'Failed to get access token');
            }

            $client->setAccessToken($token);

            // Get user info from Google
            $oauth2 = new \Google_Service_Oauth2($client);
            $googleUser = $oauth2->userinfo->get();

            // Check if user already exists by Google ID
            $existingUser = $model->findByGoogleId($googleUser->id);

            if ($existingUser) {
                // User exists, log them in
                $user = $existingUser;
            } else {
                // Check if user exists by email
                $existingUserByEmail = $model->findByEmail($googleUser->email);

                if ($existingUserByEmail) {
                    // Link Google account to existing user
                    $model->update($existingUserByEmail['id'], [
                        'google_id' => $googleUser->id,
                        'google_name' => $googleUser->name,
                        'google_picture' => $googleUser->picture
                    ]);
                    $user = $model->find($existingUserByEmail['id']);
                } else {
                    // Create new user
                    $userData = [
                        'username' => $this->generateUniqueUsername($googleUser->email),
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'google_name' => $googleUser->name,
                        'google_picture' => $googleUser->picture,
                        'role' => 'user'
                    ];

                    $model->save($userData);
                    $user = $model->findByGoogleId($googleUser->id);
                }
            }

            // Set session data
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'],
                'google_id' => $user['google_id'],
                'google_name' => $user['google_name'],
                'google_picture' => $user['google_picture'],
                'logged_in' => true,
            ]);

            // Clear OAuth state
            session()->remove('oauth_state');

            // Redirect based on role
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/admin_dashboard');
            } else {
                return redirect()->to('/forum');
            }

        } catch (\Exception $e) {
            log_message('error', 'Google OAuth error: ' . $e->getMessage());
            return redirect()->to('/auth/uslogin')->with('error', 'Google login failed');
        }
    }

    // Update user profile
    public function updateProfile()
    {
        $session = session();
        $model = new UserModel();

        $userId = $session->get('user_id');
        $user = $model->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Verify current password if not Google user
        if (empty($user['google_id'])) {
            $currentPassword = $this->request->getPost('current_password');
            if (!password_verify($currentPassword, $user['password'])) {
                return redirect()->back()->with('error', 'Current password is incorrect');
            }
        }

        $username = $this->request->getPost('username');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');
        $alertEmailEnabled = $this->request->getPost('alert_email_enabled');
        $alertMinProbability = $this->request->getPost('alert_min_probability');

        // Check username uniqueness if changed
        if ($username !== $user['username']) {
            if ($model->where('username', $username)->where('id !=', $userId)->first()) {
                return redirect()->back()->with('error', 'Username already exists');
            }
        }

        // Validate new password
        if (!empty($newPassword)) {
            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->with('error', 'New passwords do not match');
            }
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        } else {
            $hashedPassword = $user['password'];
        }

        // Update user
        $updateData = [
            'username' => $username,
            'password' => $hashedPassword,
            'alert_email_enabled' => $alertEmailEnabled,
            'alert_min_probability' => $alertMinProbability
        ];

        $model->update($userId, $updateData);

        // Update session
        $session->set([
            'username' => $username,
            'alert_email_enabled' => $alertEmailEnabled,
            'alert_min_probability' => $alertMinProbability
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    // Generate unique username from email
    private function generateUniqueUsername(string $email): string
    {
        $baseUsername = explode('@', $email)[0];
        $username = $baseUsername;
        $counter = 1;

        $model = new UserModel();
        while ($model->where('username', $username)->first()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
