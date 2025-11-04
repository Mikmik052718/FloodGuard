<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class SmsController extends Controller
{
    private $textbeeApiKey = '35ab4c13-2fa6-4bc2-bf22-f48e766086c3';
    private $textbeeDeviceId = '6903260412fbef4cf6b2b21b';

    public function index()
    {
        // Placeholder for SMS testing
        return "SMS Gateway Ready with TextBee";
    }

    // Send manual water level alert via SMS using TextBee
    public function sendWaterAlertManual()
    {
        $request = service('request');
        $alertLevel = $request->getPost('alert_level');
        $customMessage = $request->getPost('custom_message');

        if (!in_array($alertLevel, ['alert', 'alarm', 'critical'])) {
            return redirect()->back()->with('error', 'Invalid alert level.');
        }

        // Get users with SMS alerts enabled
        $userModel = new UserModel();
        $users = $userModel->where('alert_sms_enabled', 1)->where('phone !=', '')->findAll();

        // Commented out queue model since switching to direct sending
        // $smsQueueModel = new \App\Models\SmsQueueModel();
        $results = [];
        $sentCount = 0;

        foreach ($users as $user) {
            $message = "Hello {$user['username']},\n\n";
            $message .= "This is a manual alert from the admin regarding water levels.\n";
            $message .= "Alert Level: " . ucfirst($alertLevel) . "\n";
            if (!empty($customMessage)) {
                $message .= "Additional Message: " . $customMessage . "\n\n";
            } else {
                $message .= "\n";
            }
            $message .= "Please take necessary precautions.\n\n";
            $message .= "Regards,\nAlertoMarikeno Admin Team";

            try {
                // Send SMS directly via TextBee API
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.textbee.dev/api/v1/gateway/devices/{$this->textbeeDeviceId}/send-sms");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'x-api-key: ' . $this->textbeeApiKey,
                    'Content-Type: application/json'
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                    'recipients' => [$user['phone']], // Must be in +63 format
                    'message' => $message
                ]));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                $result = json_decode($response, true);
                if ($httpCode == 200 && isset($result['data']['status']) && $result['data']['status'] == 'PENDING') {
                    $status = '✅ Sent (Pending)';
                    $sentCount++;
                } else {
                    $status = '❌ Failed: ' . ($result['message'] ?? 'Unknown error');
                    log_message('error', 'TextBee SMS Failed for ' . $user['phone'] . ': ' . $response);
                }
            } catch (\Exception $e) {
                $status = '❌ Error: ' . $e->getMessage();
                log_message('error', 'TextBee Exception for ' . $user['phone'] . ': ' . $e->getMessage());
            }

            $results[] = ['phone' => $user['phone'], 'status' => $status];
        }

        // Set flashdata for popup
        session()->setFlashdata('sms_alert_results', $results);
        session()->setFlashdata('sms_alert_sent_count', $sentCount);

        return redirect()->to(site_url('email'));
    }

    // API endpoint for SMS gateway (kept for compatibility, but not used with TextBee)
    public function gateway()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Commented out since not using queue
            // $smsQueueModel = new \App\Models\SmsQueueModel();
            // $pendingSms = $smsQueueModel->where('status', 'pending')->findAll();
            $reminders = []; // Empty for now
            echo json_encode($reminders);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Commented out since not using queue
            // Receive webhook (not applicable for TextBee)
            echo json_encode(['status' => 'not implemented']);
            exit;
        }

        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
    }
}
