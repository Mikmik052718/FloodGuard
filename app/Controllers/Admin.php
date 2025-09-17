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
            return redirect()->to('/auth/login');
        }

        // Load the admin dashboard view (admin_dashboard.php)
        return view('admin/admin_dashboard');  // Reference to your admin_dashboard.php file in the 'admin' folder under 'Views'
    }

    // Display all posts (only for admins)
    public function posts()
    {
        // Check if the user is an admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
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
            return redirect()->to('/auth/login');
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
            return redirect()->to('/auth/login');
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
            return redirect()->to('/auth/login');
        }

        $model = new PostModel();
        $model->update($id, [
            'author_name' => $this->request->getPost('author_name'),
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
        ]);
        return redirect()->to('/admin/posts');
    }
}
