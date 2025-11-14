<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    // Admin Dashboard
    public function dashboard()
    {
        // Ensure the user is an admin before accessing the dashboard
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/adlogin');
        }

        // Get counts
        $userModel = new UserModel();
        $postModel = new PostModel();
        $data['userCount'] = $userModel->countAll();
        $data['postCount'] = $postModel->countAll();

        // Load the admin dashboard view (admin_dashboard.php)
        return view('admin/admin_dashboard', $data);  // Reference to your admin_dashboard.php file in the 'admin' folder under 'Views'
    }

    // Display all posts (only for admins)
    public function posts()
    {
        // Check if the user is an admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/adlogin');
        }

        $model = new PostModel();
        $data['posts'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('admin/posts', $data);
    }
    
    // Display all users (only for admins)
    public function users()
    {
        // Check if the user is an admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/adlogin');
        }

        $model = new UserModel();
        $data['users'] = $model->orderBy('id', 'ASC')->findAll();
        return view('admin/users', $data);
    }

    // Delete a post by ID
    public function delete($id)
    {
        // Ensure the user is an admin before allowing deletion
        if (session()->get('role') === 'admin') {
            $model = new PostModel();
            $model->delete($id);
        }
        return redirect()->to('/admin/posts');
    }

    // Show edit form for a post
    public function edit($id)
    {
        // Ensure the user is an admin before allowing access to the edit page
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/adlogin');
        }

        $model = new PostModel();
        $data['post'] = $model->find($id);
        return view('admin/edit', $data);
    }

    // Update a post after editing
    public function update($id)
    {
        // Ensure the user is an admin before allowing the update
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/adlogin');
        }

        $model = new PostModel();
        $model->update($id, [
            'author_name' => $this->request->getPost('author_name'),
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
        ]);
        return redirect()->to('/admin/posts');
    }

    // Force create an update post
    public function forcePost()
    {
        // Ensure the user is an admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/adlogin');
        }

        date_default_timezone_set('Asia/Manila');

        // Fetch data
        $hourlyData = $this->getHourlyData();
        $dailyData = $this->getDailyData();
        $riverData = $this->getRiverData();

        // Format content
        $content = $this->formatContent($hourlyData, $dailyData, $riverData);

        // Create post
        $postModel = new PostModel();
        $postModel->insert([
            'author_name' => 'Admin',
            'title' => 'Updates As of ' . date('Y-m-d H:i:s'),
            'content' => $content,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/posts')->with('success', 'Update post created successfully.');
    }

private function getPythonExe()
    {
        // Check if we're on a Linux/Docker environment (production)
        if (PHP_OS_FAMILY === 'Linux' || getenv('DOCKER_CONTAINER') === 'true') {
            return '/opt/venv/bin/python3';
        }

        // Local development environment - check multiple possible Python paths
        $possiblePaths = [
            'D:/Anaconda/python.exe',                    // Anaconda
            'C:\\Users\\Mikmik\\AppData\\Local\\Programs\\Python\\Python313\\python.exe', // Mikmik's Python
            'C:\\Python313\\python.exe',                // Standard Python install
            'python.exe'                                // System PATH Python
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        // Fallback to system python
        return 'python';
    }

    private function getScriptPath($script)
    {
        return dirname(__DIR__, 2) . '/python/' . $script;
    }

    private function getHourlyData()
    {
        $lat = 14.657293;
        $lon = 121.11524;
        $start = date('Y-m-d', strtotime('-1 day'));
        $end   = date('Y-m-d', strtotime('+1 day'));

        $hourly_params = ['weather_code','rain','temperature_2m','soil_moisture_0_to_7cm','wind_gusts_10m'];
        $hourly_list = implode(',', $hourly_params);

        $wxURL = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&hourly={$hourly_list}&timezone=auto&start_date={$start}&end_date={$end}";
        $rvURL = "https://flood-api.open-meteo.com/v1/flood?latitude={$lat}&longitude={$lon}&daily=river_discharge&timezone=auto&start_date={$start}&end_date={$end}";

        $cli = \Config\Services::curlrequest();
        $wx = json_decode($cli->get($wxURL)->getBody(), true)['hourly'];
        $rv_daily = json_decode($cli->get($rvURL)->getBody(), true)['daily'];

        $discharge_by_date = [];
        foreach ($rv_daily['time'] as $i => $date) {
            $discharge_by_date[$date] = $rv_daily['river_discharge'][$i] ?? 0;
        }

        $batch = [];
        $count = count($wx['time']);
        for ($i = 0; $i < $count; $i++) {
            $dt = $wx['time'][$i];
            $date_only = substr($dt, 0, 10);
            $hour_only = (int) substr($dt, 11, 2);

            if ($hour_only % 3 !== 0) continue;

            $batch[] = [
                'datetime'                        => $dt,
                'weather_code (wmo code)'         => $wx['weather_code'][$i] ?? 0,
                'rain (mm)'                       => $wx['rain'][$i] ?? 0,
                'temp (?C)'                       => $wx['temperature_2m'][$i] ?? 0,
                'soil_moisture_0_to_7cm (m?/m?)'  => $wx['soil_moisture_0_to_7cm'][$i] ?? 0,
                'river_discharge (m?/s)'          => $discharge_by_date[$date_only] ?? 0,
                'wind_gusts_10m (km/h)'           => $wx['wind_gusts_10m'][$i] ?? 0,
            ];
        }
        $cmd = $this->getPythonExe() . ' ' . $this->getScriptPath('predict_hourly.py');
        $pipes = [];
        $proc = proc_open($cmd, [0 => ['pipe','r'], 1 => ['pipe','w'], 2 => ['pipe','w']], $pipes);

        fwrite($pipes[0], json_encode($batch));
        fclose($pipes[0]);

        $out = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $err = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        proc_close($proc);

        if ($err) {
            return [];
        }

        $preds = json_decode($out, true);
        $hours = [];
        foreach ($batch as $i => $row) {
            $hours[] = [
                'datetime'   => $row['datetime'],
                'probability'=> $preds[$i]['probability'],
                'prediction' => $preds[$i]['prediction'],
                'weather_code'=> $row['weather_code (wmo code)'],
                'rain'       => $row['rain (mm)'],
                'temp'       => $row['temp (?C)'],
                'soil_0_7'   => $row['soil_moisture_0_to_7cm (m?/m?)'],
                'discharge'  => $row['river_discharge (m?/s)'],
                'wind_gusts' => $row['wind_gusts_10m (km/h)'],
            ];
        }

        // Get next 3 windows
        $now = time();
        $nextWindows = [];
        foreach ($hours as $hour) {
            $dt = strtotime($hour['datetime']);
            if ($dt > $now && count($nextWindows) < 3) {
                $nextWindows[] = $hour;
            }
        }
        return $nextWindows;
    }

    private function getDailyData()
    {
        $lat = 14.657293;
        $lon = 121.11524;
        $start = date('Y-m-d', strtotime('-1 day'));
        $end   = date('Y-m-d', strtotime('+1 day'));

        // Get weather and discharge
        $cli = \Config\Services::curlrequest();
        $wxURL = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}"
               . "&daily=weather_code,precipitation_sum,rain_sum,precipitation_hours,"
               . "temperature_2m_max,temperature_2m_min,sunshine_duration,wind_speed_10m_max,"
               . "wind_gusts_10m_max,shortwave_radiation_sum&timezone=auto"
               . "&start_date={$start}&end_date={$end}";
        $rvURL = "https://flood-api.open-meteo.com/v1/flood?latitude={$lat}&longitude={$lon}"
               . "&daily=river_discharge&timezone=auto"
               . "&start_date={$start}&end_date={$end}";

        $wx  = json_decode($cli->get($wxURL)->getBody(), true)['daily'];
        $rv  = json_decode($cli->get($rvURL)->getBody(), true)['daily'];

        $batch = [];
        for ($i = 0; $i < count($wx['time']); $i++) {
            $batch[] = [
                'latitude' => $lat,
                'longitude'=> $lon,
                'elevation'=> 19,
                'weather_code (wmo code)'        => $wx['weather_code'][$i]        ?? 0,
                'rain_sum (mm)'                  => $wx['rain_sum'][$i]            ?? 0,
                'precipitation_sum (mm)'         => $wx['precipitation_sum'][$i]   ?? 0,
                'precipitation_hours (h)'        => $wx['precipitation_hours'][$i] ?? 0,
                'temperature_2m_max (?C)'        => $wx['temperature_2m_max'][$i]  ?? 0,
                'temperature_2m_min (?C)'        => $wx['temperature_2m_min'][$i]  ?? 0,
                'sunshine_duration (s)'          => $wx['sunshine_duration'][$i]   ?? 0,
                'wind_speed_10m_max (km/h)'      => $wx['wind_speed_10m_max'][$i]  ?? 0,
                'wind_gusts_10m_max (km/h)'      => $wx['wind_gusts_10m_max'][$i]  ?? 0,
                'shortwave_radiation_sum (MJ/m?)'=> $wx['shortwave_radiation_sum'][$i] ?? 0,
                'river_discharge (m?/s)'         => $rv['river_discharge'][$i]     ?? 0,
            ];
        }

        // Call Python model
        $cmd = $this->getPythonExe() . ' ' . $this->getScriptPath('predict.py');
        $pipes = [];
        $proc = proc_open($cmd, [0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']], $pipes);
        fwrite($pipes[0], json_encode($batch)); fclose($pipes[0]);
        $out = stream_get_contents($pipes[1]);    fclose($pipes[1]);
        $err = stream_get_contents($pipes[2]);    fclose($pipes[2]);
        proc_close($proc);

        if ($err) {
            return [];
        }

        $preds = json_decode($out, true);
        $days = [];
        foreach ($wx['time'] as $i=>$date) {
            $days[] = [
              'date'            => $date,
              'probability'     => $preds[$i]['probability'],
              'prediction'      => $preds[$i]['prediction'],
              'weather_code'    => $batch[$i]['weather_code (wmo code)'],
              'rain_sum'        => $batch[$i]['rain_sum (mm)'],
              'river_discharge' => $batch[$i]['river_discharge (m?/s)'],
            ];
        }

        // Take today and tomorrow
        return array_slice($days, 1, 2);
    }

    private function getRiverData()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://pasig-marikina-tullahanffws.pagasa.dost.gov.ph/water/table_list.do",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
                "X-Requested-With: XMLHttpRequest"
            ],
            CURLOPT_POSTFIELDS => "isajax=true"
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
        $targetStation = null;
        foreach ($data as $station) {
            if (strtolower(trim($station["obsnm"])) === "sto nino") {
                $targetStation = $station;
                break;
            }
        }
        if ($targetStation && !empty($targetStation["wl"])) {
            return [
                'current' => $targetStation["wl"],
                'minus30' => $targetStation["wl30m"]
            ];
        }
        return null;
    }

    private function formatContent($hourly, $daily, $river)
    {
        $content = "<h3>Hourly Probability</h3>";
        if ($hourly) {
            $content .= "<table border='1'><tr><th>Datetime</th><th>Prob %</th><th>Prediction</th><th>Rain mm</th><th>Temp °C</th><th>Discharge m³/s</th></tr>";
            foreach ($hourly as $h) {
                $content .= "<tr><td>{$h['datetime']}</td><td>" . number_format($h['probability']*10000, 4) . "</td><td>{$h['prediction']}</td><td>{$h['rain']}</td><td>{$h['temp']}</td><td>{$h['discharge']}</td></tr>";
            }
            $content .= "</table>";
        } else {
            $content .= "(cant fetch data)";
        }

        $content .= "<h3>Daily Probability</h3>";
        if ($daily) {
            $content .= "<table border='1'><tr><th>Date</th><th>Prob %</th><th>Prediction</th><th>Rain mm</th><th>Discharge m³/s</th></tr>";
            foreach ($daily as $d) {
                $content .= "<tr><td>{$d['date']}</td><td>" . number_format($d['probability']*1000, 2) . "</td><td>{$d['prediction']}</td><td>{$d['rain_sum']}</td><td>{$d['river_discharge']}</td></tr>";
            }
            $content .= "</table>";
        } else {
            $content .= "(cant fetch data)";
        }

        $content .= "<h3>Water Level</h3>";
        if ($river) {
            $content .= "<p>Current: {$river['current']} m</p><p>-30 min: {$river['minus30']} m</p>";
        } else {
            $content .= "(cant fetch data)";
        }

        return $content;
    }
}
