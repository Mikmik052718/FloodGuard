<?php

namespace App\Models;

use CodeIgniter\Model;

class UserLocationModel extends Model
{
    protected $table = 'user_locations';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'lat',
        'lon',
        'hazard_level',
        'last_checked_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'last_checked_at';
    protected $updatedField = 'last_checked_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|integer',
        'lat' => 'required|decimal',
        'lon' => 'required|decimal',
        'hazard_level' => 'permit_empty|in_list[RED,ORANGE,YELLOW,GREEN]'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required',
            'integer' => 'User ID must be an integer'
        ],
        'lat' => [
            'required' => 'Latitude is required',
            'decimal' => 'Latitude must be a valid decimal number'
        ],
        'lon' => [
            'required' => 'Longitude is required',
            'decimal' => 'Longitude must be a valid decimal number'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Custom methods
    public function getUserLocation($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('last_checked_at', 'DESC')
                    ->first();
    }

    public function updateOrCreateUserLocation($userId, $lat, $lon, $hazardLevel = null)
    {
        $existingLocation = $this->getUserLocation($userId);
        
        $data = [
            'user_id' => $userId,
            'lat' => $lat,
            'lon' => $lon,
            'hazard_level' => $hazardLevel,
            'last_checked_at' => date('Y-m-d H:i:s')
        ];

        if ($existingLocation) {
            return $this->update($existingLocation['id'], $data);
        } else {
            return $this->insert($data);
        }
    }
}
