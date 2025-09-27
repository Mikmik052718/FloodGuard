<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'email',
        'email_verified_at',
        'password',
        'role',
        'created_at',
        'updated_at',
        'is_active',
        'alert_email_enabled',
        'alert_min_probability',
        'alert_restrict_to_red',
        'last_login_at',
        'google_id',
        'google_name',
        'google_picture'
    ];
    protected $useTimestamps = false;

    public function findByGoogleId($googleId)
    {
        return $this->where('google_id', $googleId)->first();
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}
