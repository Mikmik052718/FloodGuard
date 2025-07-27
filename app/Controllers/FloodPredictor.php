<?php

namespace App\Controllers;

use CodeIgniter\HTTP\CURLRequest;

class FloodPredictor extends BaseController
{
   public function predict()
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

public function riverStatus()
{
    return view('flood/riverstatus');
}

}
