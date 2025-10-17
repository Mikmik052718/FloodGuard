<?php

namespace App\Controllers;

use CodeIgniter\HTTP\CURLRequest;

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

    public function getWeatherData()
    {
        $lat = 14.657293;
        $lon = 121.11524;
        $today = date('Y-m-d');

        $wxURL = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}"
               . "&daily=weather_code,temperature_2m_max,temperature_2m_min,precipitation_sum,precipitation_hours&timezone=auto"
               . "&start_date={$today}&end_date={$today}";

        $cli = \Config\Services::curlrequest();
        $wx = json_decode($cli->get($wxURL)->getBody(), true)['daily'];

        // Fetch hourly for precipitation probability
        $hourlyURL = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&hourly=precipitation_probability&timezone=auto&start_date={$today}&end_date={$today}";
        $hourly = json_decode($cli->get($hourlyURL)->getBody(), true)['hourly'];
        $precipitation_probability = !empty($hourly['precipitation_probability']) ? max($hourly['precipitation_probability']) * 10000 : 0;

        $data = [
            'weather_code' => $wx['weather_code'][0] ?? 0,
            'temperature_2m_max' => $wx['temperature_2m_max'][0] ?? 0,
            'temperature_2m_min' => $wx['temperature_2m_min'][0] ?? 0,
            'precipitation_sum' => $wx['precipitation_sum'][0] ?? 0,
            'precipitation_hours' => $wx['precipitation_hours'][0] ?? 0,
            'precipitation_probability' => $precipitation_probability,
        ];

        return $this->response->setJSON($data);
    }
}
