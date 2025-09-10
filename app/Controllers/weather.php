<?php


public function weather()
{
    helper('url'); // Just in case

    $client = \Config\Services::curlrequest();

    $url = 'https://api.open-meteo.com/v1/forecast?latitude=14.6481&longitude=121.1133&current=temperature_2m,wind_speed_10m&hourly=temperature_2m,relative_humidity_2m,wind_speed_10m';

    $response = $client->get($url);
    $body = json_decode($response->getBody(), true);

    $data['current'] = $body['current'] ?? null;
    $data['hourly'] = $body['hourly'] ?? null;

    return view('forum/weather', $data);
}
