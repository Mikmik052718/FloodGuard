<?php

namespace App\Controllers;

use CodeIgniter\HTTP\CURLRequest;
use App\Models\UserLocationModel;

class FloodPredictor extends BaseController
{
//091325

    private function getPythonExe()
    {
        // for production env
        if (PHP_OS_FAMILY === 'Linux' || getenv('DOCKER_CONTAINER') === 'true') {
            return '/opt/venv/bin/python3';
        }

        // dev env
        $possiblePaths = [
            'D:/Anaconda/python.exe',                    // Anaconda
            'C:\\Users\\Mikmik\\AppData\\Local\\Programs\\Python\\Python313\\python.exe', // Mikmik Python
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

    public function index()
    {
        return view('flood/predict_page');
    }

    // New method for hazard maps with session support
    public function hazardMaps()
    {
        // Page loads immediately, map is displayed
        return view('flood/hazard_maps');
    }

 public function predictAjax()
    {
        $lat = 14.657293;
        $lon = 121.11524;
        $start = date('Y-m-d', strtotime('-2 days'));
        $end   = date('Y-m-d', strtotime('+2 days'));

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
            return $this->response->setJSON(['status'=>'error','message'=>$err]);
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
              'temp_max'        => $batch[$i]['temperature_2m_max (?C)'],
              'temp_min'        => $batch[$i]['temperature_2m_min (?C)'],
              'river_discharge' => $batch[$i]['river_discharge (m?/s)'],
            ];
        }

        return $this->response->setJSON(['status'=>'success','days'=>$days]);
    }

/*
   public function predict() //daily
{
    $lat = 14.657293;
    $lon = 121.11524;
    $start = date('Y-m-d', strtotime('-2 days'));
    $end   = date('Y-m-d', strtotime('+2 days'));

    // daily weather + discharge
    $wxURL = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}"
           . "&daily=weather_code,precipitation_sum,rain_sum,precipitation_hours,"
           . "temperature_2m_max,temperature_2m_min,sunshine_duration,wind_speed_10m_max,"
           . "wind_gusts_10m_max,shortwave_radiation_sum&timezone=auto"
           . "&start_date={$start}&end_date={$end}";
    $rvURL = "https://flood-api.open-meteo.com/v1/flood?latitude={$lat}&longitude={$lon}"
           . "&daily=river_discharge&timezone=auto"
           . "&start_date={$start}&end_date={$end}";

    $cli = \Config\Services::curlrequest();
    $wx  = json_decode($cli->get($wxURL)->getBody(), true)['daily'];
    $rv  = json_decode($cli->get($rvURL)->getBody(), true)['daily'];

    // --- build 5 payloads ---
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

    // --- single Python call ---
    $cmd = 'D:/Anaconda/python.exe ../python/predict.py';
    $pipes = [];
    $proc = proc_open($cmd, [0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']], $pipes);
    fwrite($pipes[0], json_encode($batch)); fclose($pipes[0]);
    $out = stream_get_contents($pipes[1]);    fclose($pipes[1]);
    $err = stream_get_contents($pipes[2]);    fclose($pipes[2]);
    proc_close($proc);

    if ($err) { return $this->response->setJSON(['error'=>$err]); }

    $preds = json_decode($out, true);  // array[5]

    // merge the weather + predictions for the view
    $days = [];
    foreach ($wx['time'] as $i=>$date) {
        $days[] = [
          'date'            => $date,
          'probability'     => $preds[$i]['probability'],
          'prediction'      => $preds[$i]['prediction'],
          'weather_code'    => $batch[$i]['weather_code (wmo code)'],
          'rain_sum'        => $batch[$i]['rain_sum (mm)'],
          'temp_max'        => $batch[$i]['temperature_2m_max (?C)'],
          'temp_min'        => $batch[$i]['temperature_2m_min (?C)'],
          'river_discharge' => $batch[$i]['river_discharge (m?/s)'],
        ];
    }

    return view('flood/predict_result', ['days' => $days]);
}
*/
public function riverStatus()
{
    return view('flood/riverstatus');
}

//hourly, site first before data
    public function hourly()
    {
        return view('flood/predict_result_hourly');
    }

    
     public function predict_hourly_ajax()
    {
        $lat = 14.657293;
        $lon = 121.11524;
        $start = date('Y-m-d', strtotime('-1 day'));
        $end   = date('Y-m-d', strtotime('+1 day'));

        // TestFlood-style parameters with detailed soil moisture layers
        $hourly_params = [
            'weather_code',
            'rain',
            'temperature_2m',
            'soil_moisture_0_to_1cm',
            'soil_moisture_1_to_3cm',
            'soil_moisture_3_to_9cm',
            'soil_moisture_9_to_27cm',
            'soil_moisture_27_to_81cm',
            'wind_gusts_10m'
        ];
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
                'datetime'                           => $dt,
                'precipitation (mm)'                 => $wx['rain'][$i] ?? 0,
                'soil_moisture_0_1cm (m³/m³)'        => $wx['soil_moisture_0_to_1cm'][$i] ?? 0,
                'soil_moisture_1_3cm (m³/m³)'        => $wx['soil_moisture_1_to_3cm'][$i] ?? 0,
                'soil_moisture_3_9cm (m³/m³)'        => $wx['soil_moisture_3_to_9cm'][$i] ?? 0,
                'soil_moisture_9_27cm (m³/m³)'       => $wx['soil_moisture_9_to_27cm'][$i] ?? 0,
                'soil_moisture_27_81cm (m³/m³)'      => $wx['soil_moisture_27_to_81cm'][$i] ?? 0,
                'wind_gusts_10m (km/h)'              => $wx['wind_gusts_10m'][$i] ?? 0,
                'weather_code (wmo code)'            => $wx['weather_code'][$i] ?? 0,
                'temp (°C)'                          => $wx['temperature_2m'][$i] ?? 0,
                'river_discharge (m³/s)'             => $discharge_by_date[$date_only] ?? 0,
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
            return $this->response->setJSON(['error' => $err]);
        }

        $preds = json_decode($out, true);
        $hours = [];
        foreach ($batch as $i => $row) {
            $hours[] = [
                'datetime'      => $row['datetime'],
                'probability'   => $preds[$i]['probability'],
                'prediction'    => $preds[$i]['prediction'],
                'weather_code'  => $row['weather_code (wmo code)'],
                'rain'          => $row['precipitation (mm)'],
                'temp'          => $row['temp (°C)'],
                'discharge'     => $row['river_discharge (m³/s)'],
                'wind_gusts'    => $row['wind_gusts_10m (km/h)'],
            ];
        }

        return $this->response->setJSON(['hours' => $hours]);
    }

    // Save user location
    public function saveUserLocation()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not logged in'
            ]);
        }

        $lat = $this->request->getPost('lat');
        $lon = $this->request->getPost('lon');
        $hazardLevel = $this->request->getPost('hazard_level');
        $userId = session()->get('user_id');

        if (!$lat || !$lon) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Latitude and longitude are required'
            ]);
        }

        $locationModel = new UserLocationModel();
        $result = $locationModel->updateOrCreateUserLocation($userId, $lat, $lon, $hazardLevel);

        if ($result) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Location saved successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to save location'
            ]);
        }
    }

    // Get user's saved location
    public function getUserLocation()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not logged in'
            ]);
        }

        $userId = session()->get('user_id');
        $locationModel = new UserLocationModel();
        $location = $locationModel->getUserLocation($userId);

        if ($location) {
            return $this->response->setJSON([
                'status' => 'success',
                'location' => $location
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No saved location found'
            ]);
        }
    }
}    

