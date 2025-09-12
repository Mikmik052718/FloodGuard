<?php

namespace App\Controllers;
use App\Models\UserModel; 
use CodeIgniter\Controller;

class Email_cont extends Controller
{
    public function index()
    {
        $email = \Config\Services::email();

        $email->setTo('2022-00642@sanbeda.edu.ph'); // palitan ng test email mo
        $email->setSubject('TESTING ALERT');
        $email->setMessage('<h2>Hello!</h2><p>hello gcash my location.</p>');

        if ($email->send()) {
            return "✅ Email sent successfully!";
        } else {
            return $email->printDebugger(['headers', 'subject', 'body']);
        }
    }

    //send to all users
    public function sendToUsers()
    {
        $userModel = new UserModel();
        $users = $userModel->where('email !=', '')->findAll(); // only users with email

        $email = \Config\Services::email();

        foreach ($users as $user) {
            $email->setFrom(env('email.from'), env('email.fromName'));
            $email->setTo($user['email']);
            $email->setSubject('Alert Test');
            $email->setMessage("Hello {$user['username']},<br><br>This is a test alert from our system.");

            if ($email->send()) {
                echo "Email sent to {$user['email']}<br>";
            } else {
                echo "Failed to send to {$user['email']}<br>";
                echo $email->printDebugger(['headers']);
            }
        }
    }    

    public function form()
    {
        $userModel = new UserModel();
        $users = $userModel->select('id, username, email')->findAll();

        return view('admin/email_form', ['users' => $users]);
    }

    // Handle form submission
public function sendEmail()
{
    $request = service('request');
    $userId = $request->getPost('user_id'); 
    $subject = $request->getPost('subject');
    $message = $request->getPost('message');

    $userModel = new UserModel();
    $email = \Config\Services::email();
    $results = [];

    if (empty($subject) || empty($message)) {
        return "Subject and message cannot be empty.";
    }

    if ($userId === 'all') {
        // Send to all users
        $users = $userModel->where('email !=', '')->findAll();
        foreach ($users as $user) {
            $email->setFrom(env('email.from'), env('email.fromName'));
            $email->setTo($user['email']);
            $email->setSubject($subject);
            $email->setMessage("Hello {$user['username']},<br><br>" . nl2br(esc($message)));

            $status = $email->send() ? '✅ Sent' : '❌ Failed';
            $results[] = ['email' => $user['email'], 'status' => $status];
        }
    } else {
        // Send to one user
        $user = $userModel->find($userId);
        if ($user && !empty($user['email'])) {
            $email->setFrom(env('email.from'), env('email.fromName'));
            $email->setTo($user['email']);
            $email->setSubject($subject);
            $email->setMessage("Hello {$user['username']},<br><br>" . nl2br(esc($message)));

            $status = $email->send() ? '✅ Sent' : '❌ Failed';
            $results[] = ['email' => $user['email'], 'status' => $status];
        }
    }

    return view('admin/email_result', ['results' => $results]);
}

}
