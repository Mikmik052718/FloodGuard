<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class Debug extends Controller
{
    public function index()
    {
        echo "<h2>Hello World! CI4 is running ✅</h2>";

        try {
            $db = Database::connect();
            $query = $db->query('SELECT NOW() AS current_time');
            $result = $query->getRow();

            echo "<p>✅ Database connected successfully!</p>";
            echo "<p>Current DB Time: " . $result->current_time . "</p>";
        } catch (\Throwable $e) {
            echo "<p style='color:red;'>❌ Database connection failed!</p>";
            echo "<pre>" . $e->getMessage() . "</pre>";
        }
    }
}
