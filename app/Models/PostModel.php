<?php

namespace App\Models;
use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['author_name', 'title', 'content', 'created_at'];
    protected $useTimestamps = false;
}
