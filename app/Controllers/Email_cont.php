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
            return " Email sent successfully!";
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
        // Ensure the user is an admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

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

    public function sendWaterAlerts()
    {
        // Custom water level thresholds 
        $customAlertLevel = 12.5;    
        $customAlarmLevel = 16.0;    
        $customCriticalLevel = 17.0; 
        $useCustomLevels = false;    // Set to true to use custom levels instead of API levels

        // Fetch water level data
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

        // Find Sto Nino station
        $targetStation = null;
        foreach ($data as $station) {
            if (strtolower(trim($station["obsnm"])) === "sto nino") {
                $targetStation = $station;
                break;
            }
        }

        if (!$targetStation || empty($targetStation["wl"])) {
            return "No water level data available.";
        }

        $currentLevel = (float) $targetStation["wl"];

        // Use custom levels if enabled, otherwise use API levels
        if ($useCustomLevels) {
            $alertLevel = $customAlertLevel;
            $alarmLevel = $customAlarmLevel;
            $criticalLevel = $customCriticalLevel;
        } else {
            $alertLevel = (float) $targetStation["alertwl"];
            $alarmLevel = (float) $targetStation["alarmwl"];
            $criticalLevel = (float) $targetStation["criticalwl"];
        }

        // Determine current alert status
        $alertStatus = 'none';
        if ($currentLevel >= $criticalLevel) {
            $alertStatus = 'critical';
        } elseif ($currentLevel >= $alarmLevel) {
            $alertStatus = 'alarm';
        } elseif ($currentLevel >= $alertLevel) {
            $alertStatus = 'alert';
        }

        if ($alertStatus === 'none') {
            return "Water level is normal. No alerts sent.";
        }

        // Get users with email alerts enabled
        $userModel = new UserModel();
        $users = $userModel->where('alert_email_enabled', 1)->where('email !=', '')->findAll();

        $email = \Config\Services::email();
        $today = date('Y-m-d');
        $sentCount = 0;

        foreach ($users as $user) {
            // Check if already sent today for this level
            $lastDate = $user['last_water_alert_date'] ?? null;
            $lastLevel = $user['last_water_alert_level'] ?? null;

            if ($lastDate === $today && $lastLevel === $alertStatus) {
                continue; // Already sent
            }

            // Send email
            $email->setFrom(env('email.from'), env('email.fromName'));
            $email->setTo($user['email']);
            $email->setSubject("Water Level Alert: " . ucfirst($alertStatus) . " Level Reached");

            $message = "Hello {$user['username']},<br><br>";
            $message .= "The water level at Sto Nino has reached <strong>" . ucfirst($alertStatus) . "</strong> level.<br>";
            $message .= "Current water level: {$currentLevel} m<br>";
            $message .= "Alert level: {$alertLevel} m<br>";
            $message .= "Alarm level: {$alarmLevel} m<br>";
            $message .= "Critical level: {$criticalLevel} m<br><br>";
            $message .= "Please take necessary precautions.<br><br>";
            $message .= "Regards,<br>AlertoMarikeno Team";

            $email->setMessage($message);

            if ($email->send()) {
                // Update user record
                $userModel->update($user['id'], [
                    'last_water_alert_date' => $today,
                    'last_water_alert_level' => $alertStatus
                ]);
                $sentCount++;
                echo "Alert sent to {$user['email']}<br>";
            } else {
                echo "Failed to send alert to {$user['email']}<br>";
            }
        }

        return "Alerts sent to {$sentCount} users.";
    }

    // Send manual water level alert from admin
    public function sendWaterAlertManual()
    {
        $request = service('request');
        $alertLevel = $request->getPost('alert_level');
        $customMessage = $request->getPost('custom_message');

        if (!in_array($alertLevel, ['alert', 'alarm', 'critical'])) {
            return redirect()->back()->with('error', 'Invalid alert level.');
        }

        // Get users with email alerts enabled
        $userModel = new UserModel();
        $users = $userModel->where('alert_email_enabled', 1)->where('email !=', '')->findAll();

        $email = \Config\Services::email();
        $today = date('Y-m-d');
        $results = [];
        $sentCount = 0;

        foreach ($users as $user) {
            // Send email
            $email->setFrom(env('email.from'), env('email.fromName'));
            $email->setTo($user['email']);
            $email->setSubject("Manual Water Level Alert: " . ucfirst($alertLevel) . " Level");

            $message = "Hello {$user['username']},<br><br>";
            $message .= "This is a manual alert from the admin regarding water levels.<br>";
            $message .= "Alert Level: <strong>" . ucfirst($alertLevel) . "</strong><br>";
            if (!empty($customMessage)) {
                $message .= "Additional Message: " . nl2br(esc($customMessage)) . "<br><br>";
            } else {
                $message .= "<br>";
            }
            $message .= "Please take necessary precautions.<br><br>";
            $message .= "Regards,<br>AlertoMarikeno Admin Team";

            $email->setMessage($message);

            if ($email->send()) {
                // Update user record to prevent auto alerts for this level today
                $userModel->update($user['id'], [
                    'last_water_alert_date' => $today,
                    'last_water_alert_level' => $alertLevel
                ]);
                $sentCount++;
                $results[] = ['email' => $user['email'], 'status' => '✅ Sent'];
            } else {
                $results[] = ['email' => $user['email'], 'status' => '❌ Failed'];
            }
        }

        // Set flashdata for popup
        session()->setFlashdata('alert_results', $results);
        session()->setFlashdata('alert_sent_count', $sentCount);

        return redirect()->to(site_url('email'));
    }

}
