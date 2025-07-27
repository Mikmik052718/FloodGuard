<?php
//un admin1 pw admin1 
namespace App\Controllers;
use App\Models\PostModel;

class Admin extends BaseController
{
    public function posts()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $model = new PostModel();
        $data['posts'] = $model->orderBy('created_at', 'DESC')->findAll();  
        return view('admin/posts', $data);
    }

    public function delete($id)
    {
        if (session()->get('role') === 'admin') {
            $model = new PostModel();
            $model->delete($id);
        }
        return redirect()->to('/admin/posts');
    }

                        public function edit($id)
                        {
                            $model = new PostModel();
                            $data['post'] = $model->find($id);
                            return view('admin/edit', $data);
                        }

                        public function update($id)
                        {
                            $model = new PostModel();
                            $model->update($id, [
                                'author_name' => $this->request->getPost('author_name'),
                                'title' => $this->request->getPost('title'),
                                'content' => $this->request->getPost('content'),
                            ]);
                            return redirect()->to('/admin/posts');
                        }
   
}