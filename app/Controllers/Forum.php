<?php

namespace App\Controllers;
use App\Models\PostModel;

class Forum extends BaseController
{
    public function index()
    {
        $model = new PostModel();
        $data['posts'] = $model->orderBy('created_at', 'DESC')->limit(15)->findAll();
        $data['total_posts'] = $model->countAll();
        return view('forum/index', $data);
    }

    public function create()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/forum')->with('error', 'You must be logged in to create a post.');
        }
        return view('forum/create');
    }

 public function store()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/forum')->with('error', 'You must be logged in to create a post.');
    }

    // Set timezone to Asia/Manila to match AutoPost behavior
    date_default_timezone_set('Asia/Manila');

    $model = new PostModel();

    $authorName = session()->get('username');

    $title = $this->request->getPost('title');
    $content = $this->request->getPost('content');

    $badWords = ['gago', 'puta', 'tangina','kupal', 'hayop', 'putangina', 'putanginamo'];

    // Function to censor bad words
    function censorText($text, $badWords) {
        $text = strtolower($text);
        foreach ($badWords as $word) {
            $pattern = '/\b' . preg_quote(strtolower($word), '/') . '\b/ui';
            $replacement = str_repeat('*', strlen($word));
            $text = preg_replace($pattern, $replacement, $text);
        }
        return $text;
    }

    $censoredTitle = censorText($title, $badWords);
    $censoredContent = censorText($content, $badWords);

    $data = [
        'author_name' => $authorName,
        'title'       => $censoredTitle,
        'content'     => $censoredContent,
        'created_at'  => date('Y-m-d H:i:s'), // Explicitly set timestamp with Asia/Manila timezone
    ];

    // Handle image upload
    $image = $this->request->getFile('image');
    if ($image && $image->isValid() && !$image->hasMoved()) {
        // Check if content is empty when image is uploaded
        if (empty(trim($this->request->getPost('content')))) {
            return redirect()->back()->withInput()->with('error', 'A caption is required when uploading a photo.');
        }
        $newName = $image->getRandomName();
        $image->move(FCPATH . 'uploads', $newName);
        $data['image'] = $newName;
    }

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
                        $post = $model->find($id);

                        $data = [
                            'title'       => $this->request->getPost('title'),
                            'content'     => $this->request->getPost('content'),
                        ];

                        // Handle image upload
                        $image = $this->request->getFile('image');
                        if ($image && $image->isValid() && !$image->hasMoved()) {
                            // Delete old image if exists
                            if (!empty($post['image']) && file_exists(FCPATH . 'uploads/' . $post['image'])) {
                                unlink(FCPATH . 'uploads/' . $post['image']);
                            }
                            $newName = $image->getRandomName();
                            $image->move(FCPATH . 'uploads', $newName);
                            $data['image'] = $newName;
                        }

                        $model->update($id, $data);
                        return redirect()->to('/forum');
                    }

    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/forum')->with('error', 'You must be logged in to delete a post.');
        }

        $model = new PostModel();
        $post = $model->find($id);

        if (!$post) {
            return redirect()->to('/forum')->with('error', 'Post not found.');
        }

        if (session()->get('username') !== $post['author_name']) {
            return redirect()->to('/forum')->with('error', 'Unauthorized');
        }

        // Delete associated image if exists
        if (!empty($post['image']) && file_exists(FCPATH . 'uploads/' . $post['image'])) {
            unlink(FCPATH . 'uploads/' . $post['image']);
        }

        $model->delete($id);
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

public function loadMorePosts()
{
    $offset = $this->request->getGet('offset') ?? 0;
    $limit = 15;
    $page = intval($offset / $limit) + 1;

    $model = new PostModel();
    $posts = $model->orderBy('created_at', 'DESC')->paginate($limit, 'default', $page);

    return $this->response->setJSON($posts);
}



}
