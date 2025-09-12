<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class LandingPageController extends Controller
{
    public function landing()
    {
        return view('landingpage');  // Assuming the view is named 'landing.php'
    }
}
