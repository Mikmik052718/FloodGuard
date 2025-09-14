<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['username', 'password', 'email', 'role', 'google_id', 'google_name', 'google_picture'];
    protected $useTimestamps = true;

    /**
     * Find user by Google ID
     */
    public function findByGoogleId(string $googleId)
    {
        return $this->where('google_id', $googleId)->first();
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }
}
