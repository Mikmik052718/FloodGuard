<?php

namespace App\Controllers;
use App\Models\PostModel;

class Forum extends BaseController
{
    public function index()
    {
        $model = new PostModel();
        $data['posts'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('forum/index', $data);
    }

    public function create()
    {
        return view('forum/create');
    }

 public function store()
{
    $model = new PostModel();

    $authorName = session()->get('logged_in') 
        ? session()->get('username') 
        : $this->request->getPost('author_name');

    $data = [
        'author_name' => $authorName,
        'title'       => $this->request->getPost('title'),
        'content'     => $this->request->getPost('content'),
    ];

    $model->insert($data);
    return redirect()->to('/forum');
}


public function edit($id)
{
    $model = new PostModel();
    $post = $model->find($id);

//exclusive editing
    if (!session()->get('logged_in') || session()->get('username') !== $post['author_name']) {
        return redirect()->to('/forum')->with('error', 'Unauthorized');
    }

    return view('forum/edit', ['post' => $post]);
}


                    public function update($id)
                    {
                        $model = new PostModel();
                        $model->update($id, [
                            'author_name' => $this->request->getPost('author_name'),
                            'title'       => $this->request->getPost('title'),
                            'content'     => $this->request->getPost('content'),
                        ]);
                        return redirect()->to('/forum');
                    }
 
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
    
public function weatherDaily()
{
    helper('url');
    $client = \Config\Services::curlrequest();

    // Daily weather data
    $weatherUrl = 'https://archive-api.open-meteo.com/v1/archive?latitude=14.6481&longitude=121.1133&start_date=2024-01-01&end_date=2024-12-31&daily=weather_code,precipitation_sum,rain_sum,precipitation_hours,wind_gusts_10m_max&timezone=auto';

    // River discharge flood data
    $floodUrl = 'https://flood-api.open-meteo.com/v1/flood?latitude=14.6481&longitude=121.1133&daily=river_discharge&timezone=auto&start_date=2024-01-01&end_date=2024-12-31';

    $weatherResponse = $client->get($weatherUrl);
    $floodResponse = $client->get($floodUrl);

    $weatherData = json_decode($weatherResponse->getBody(), true);
    $floodData = json_decode($floodResponse->getBody(), true);

    $data['weather'] = $weatherData['daily'] ?? null;
    $data['flood'] = $floodData['daily'] ?? null;

    return view('forum/weather_daily', $data);
}



}
