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

        if (!in_array($alertLevel, ['warning', 'alert', 'alarm', 'critical'])) {
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
                    'recipients' => [$user['phone']], // +63 format
                    'message' => $message
                ]));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                $result = json_decode($response, true);
                log_message('info', 'TextBee API Response for ' . $user['phone'] . ': HTTP ' . $httpCode . ', Response: ' . $response);
                if ($httpCode == 200 && isset($result['data']['status']) && $result['data']['status'] == 'PENDING') {
                    $status = '✅ Sent (Pending)';
                    $sentCount++;
                } else {
                    $status = '❌ Failed: ' . ($result['message'] ?? 'Unknown error');
                    log_message('error', 'TextBee SMS Failed for ' . $user['phone'] . ': HTTP ' . $httpCode . ', Response: ' . $response);
                }
            } catch (\Exception $e) {
                $status = '❌ Error: ' . $e->getMessage();
                log_message('error', 'TextBee Exception for ' . $user['phone'] . ': ' . $e->getMessage());
            }

            $results[] = ['username' => $user['username'], 'phone' => $user['phone'], 'status' => $status];
        }

        // Set flashdata for popup only if SMS were sent
        if ($sentCount > 0) {
            session()->setFlashdata('sms_alert_results', $results);
            session()->setFlashdata('sms_alert_sent_count', $sentCount);
} else {
    session()->setFlashdata('sms_queued', 'SMS Message Alert Warning Queued and will be sent to registered users');
}

        return redirect()->to(site_url('email'));
    }

    // automated sms
    public function sendWaterAlertsSMS()
    {
        // Custom water level thresholds
        $customAlertLevel = 14.5;
        $customAlarmLevel = 15.5;
        $customCriticalLevel = 16.5;
        $useCustomLevels = true;    // use true for custom levels in moments of preparedness

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
        } elseif ($currentLevel >= 13.50) {
            $alertStatus = 'warning';
        }

        if ($alertStatus === 'none') {
            return "Water level is normal. No SMS alerts sent.";
        }

        // Get users with SMS alerts enabled
        $userModel = new UserModel();
        $users = $userModel->where('alert_sms_enabled', 1)->where('phone !=', '')->findAll();

        $today = date('Y-m-d');
        $sentCount = 0;

        foreach ($users as $user) {
            // Check if already sent today for this level
            $lastDate = $user['last_water_alert_date'] ?? null;
            $lastLevel = $user['last_water_alert_level'] ?? null;

            if ($lastDate === $today && $lastLevel === $alertStatus) {
                continue; // Already sent
            }

            // Prepare SMS message
            $message = "Hello {$user['username']},\n\n";
            $message .= "The water level at Sto Nino has reached " . ucfirst($alertStatus) . " level.\n";
            $message .= "Current water level: {$currentLevel} m\n";
            $message .= "Alert level: {$alertLevel} m\n";
            $message .= "Alarm level: {$alarmLevel} m\n";
            $message .= "Critical level: {$criticalLevel} m\n\n";
            $message .= $this->getAlertMessage($alertStatus);
            $message .= "Regards,\nAlertoMarikeno Team";

            try {
                // Send SMS via TextBee API
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
                    // Update user record
                    $userModel->update($user['id'], [
                        'last_water_alert_date' => $today,
                        'last_water_alert_level' => $alertStatus
                    ]);
                    $sentCount++;
                    echo "SMS alert sent to {$user['phone']}<br>";
                } else {
                    echo "Failed to send SMS alert to {$user['phone']}: HTTP {$httpCode}, Response: " . json_encode($result) . "<br>";
                    log_message('error', 'TextBee SMS Failed for ' . $user['phone'] . ': HTTP ' . $httpCode . ', Response: ' . $response);
                }
            } catch (\Exception $e) {
                echo "Error sending SMS to {$user['phone']}: " . $e->getMessage() . "<br>";
                log_message('error', 'TextBee Exception for ' . $user['phone'] . ': ' . $e->getMessage());
            }
        }

        return "SMS alerts sent to {$sentCount} users.";
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

    // Helper method to get alert messages
    private function getAlertMessage($alertLevel)
    {
        switch ($alertLevel) {
            case 'warning':
                return "This is a warning for possible hazard as the water level has reached level 13.50\n\n";
            case 'alert':
                return "Please take necessary precautions.\n\n";
            case 'alarm':
                return "Please take immediate precautions and prepare for evacuation if necessary.\n\n";
            case 'critical':
                return "CRITICAL LEVEL: Immediate evacuation may be required. Please follow local authorities' instructions.\n\n";
            default:
                return "Please take necessary precautions.\n\n";
        }
    }
}
