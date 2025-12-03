<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Alerts extends BaseController
{
    private function getPythonExe()
    {
        // Check if we're on a Linux/Docker environment (production)
        if (PHP_OS_FAMILY === 'Linux' || getenv('DOCKER_CONTAINER') === 'true') {
            return '/opt/venv/bin/python3';
        }

        // Local development environment - check multiple possible Python paths
        $possiblePaths = [
            'D:/Anaconda/python.exe',
            'C:\\Users\\Mikmik\\AppData\\Local\\Programs\\Python\\Python313\\python.exe',
            'C:\\Python313\\python.exe',
            'python.exe'
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return 'python';
    }

    private function getScriptPath($script)
    {
        return dirname(__DIR__, 2) . '/python/' . $script;
    }

    /**
     * Get tomorrow's flood prediction data
     * Returns: ['date' => string, 'probability' => float, 'prediction' => string, 'percent' => float]
     */
    private function getTomorrowPrediction()
    {
        $lat = 14.657293;
        $lon = 121.11524;
        $start = date('Y-m-d', strtotime('-2 days'));
        $end   = date('Y-m-d', strtotime('+2 days'));

        // Get weather and discharge data
        $cli = \Config\Services::curlrequest();
        $wxURL = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}"
               . "&daily=weather_code,precipitation_sum,rain_sum,precipitation_hours,"
               . "temperature_2m_max,temperature_2m_min,sunshine_duration,wind_speed_10m_max,"
               . "wind_gusts_10m_max,shortwave_radiation_sum&timezone=auto"
               . "&start_date={$start}&end_date={$end}";
        $rvURL = "https://flood-api.open-meteo.com/v1/flood?latitude={$lat}&longitude={$lon}"
               . "&daily=river_discharge&timezone=auto"
               . "&start_date={$start}&end_date={$end}";

        $wx  = json_decode($cli->get($wxURL)->getBody(), true)['daily'];
        $rv  = json_decode($cli->get($rvURL)->getBody(), true)['daily'];

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

        // Call Python model
        $cmd = $this->getPythonExe() . ' ' . $this->getScriptPath('predict.py');
        $pipes = [];
        $proc = proc_open($cmd, [0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']], $pipes);
        fwrite($pipes[0], json_encode($batch)); 
        fclose($pipes[0]);
        $out = stream_get_contents($pipes[1]);    
        fclose($pipes[1]);
        $err = stream_get_contents($pipes[2]);    
        fclose($pipes[2]);
        proc_close($proc);

        if ($err) {
            log_message('error', 'Python prediction error: ' . $err);
            return null;
        }

        $preds = json_decode($out, true);
        
        // Find tomorrow's index (today is usually index 2 in the -2 to +2 range)
        $tomorrowDate = date('Y-m-d', strtotime('+1 day'));
        $tomorrowIndex = null;
        
        foreach ($wx['time'] as $i => $date) {
            if ($date === $tomorrowDate) {
                $tomorrowIndex = $i;
                break;
            }
        }

        if ($tomorrowIndex === null) {
            log_message('error', 'Could not find tomorrow\'s date in prediction data');
            return null;
        }

        $probability = $preds[$tomorrowIndex]['probability'];
        $percent = $probability * 1000; // Match UI display format

        return [
            'date' => $tomorrowDate,
            'probability' => $probability,
            'prediction' => $preds[$tomorrowIndex]['prediction'],
            'percent' => $percent
        ];
    }

    /**
     * Test/Dry-run route - shows which users would be alerted without sending
     * Access via: /alerts/test-daily
     */
    public function testDaily()
    {
        date_default_timezone_set('Asia/Manila');
        
        echo "<h2>Daily Flood Alert Test (Dry Run)</h2>";
        echo "<p>Current time: " . date('Y-m-d H:i:s') . " (Asia/Manila)</p>";
        echo "<hr>";

        // Get tomorrow's prediction
        $tomorrow = $this->getTomorrowPrediction();
        
        if (!$tomorrow) {
            echo "<p style='color:red;'>❌ Failed to get prediction data</p>";
            return;
        }

        echo "<h3>Tomorrow's Prediction</h3>";
        echo "<ul>";
        echo "<li><strong>Date:</strong> {$tomorrow['date']}</li>";
        echo "<li><strong>Probability:</strong> {$tomorrow['percent']}%</li>";
        echo "<li><strong>Prediction:</strong> {$tomorrow['prediction']}</li>";
        echo "</ul>";
        echo "<hr>";

        // Get users who should be alerted
        $userModel = new UserModel();
        $today = date('Y-m-d');
        
        // Get all users with alerts enabled
        $allUsers = $userModel
            ->where('(alert_email_enabled = 1 OR alert_sms_enabled = 1)')
            ->findAll();

        echo "<h3>User Alert Analysis</h3>";
        echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
        echo "<tr style='background:#f0f0f0;'>";
        echo "<th>Username</th><th>Email</th><th>Phone</th><th>Threshold</th>";
        echo "<th>Email Enabled</th><th>SMS Enabled</th><th>Last Alert Date</th>";
        echo "<th>Would Alert?</th><th>Reason</th>";
        echo "</tr>";

        $alertCount = 0;
        $skipCount = 0;

        foreach ($allUsers as $user) {
            $threshold = $user['alert_min_probability'];
            $lastAlertDate = $user['last_flood_alert_date'] ?? null;
            
            $wouldAlert = false;
            $reason = '';

            // Check if threshold is met
            if ($tomorrow['percent'] >= $threshold) {
                // Check if already alerted today
                if ($lastAlertDate === $today) {
                    $reason = "Already alerted today";
                    $skipCount++;
                } else {
                    $wouldAlert = true;
                    $reason = "✅ Would send alert";
                    $alertCount++;
                }
            } else {
                $reason = "Threshold not met ({$tomorrow['percent']}% < {$threshold}%)";
                $skipCount++;
            }

            $rowColor = $wouldAlert ? '#e6ffe6' : '#fff';
            echo "<tr style='background:{$rowColor};'>";
            echo "<td>{$user['username']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "<td>{$user['phone']}</td>";
            echo "<td>{$threshold}%</td>";
            echo "<td>" . ($user['alert_email_enabled'] ? '✓' : '✗') . "</td>";
            echo "<td>" . ($user['alert_sms_enabled'] ? '✓' : '✗') . "</td>";
            echo "<td>" . ($lastAlertDate ?? 'Never') . "</td>";
            echo "<td>" . ($wouldAlert ? '✅ YES' : '❌ NO') . "</td>";
            echo "<td>{$reason}</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<hr>";
        echo "<h3>Summary</h3>";
        echo "<ul>";
        echo "<li><strong>Total users with alerts enabled:</strong> " . count($allUsers) . "</li>";
        echo "<li><strong>Would receive alerts:</strong> {$alertCount}</li>";
        echo "<li><strong>Would skip:</strong> {$skipCount}</li>";
        echo "</ul>";
    }

    /**
     * Send daily flood prediction alerts
     * Should be called by cron at 7 PM Manila time
     * Access via: /alerts/send-daily (or via cron/CLI)
     */
    public function sendDaily()
    {
        date_default_timezone_set('Asia/Manila');

        log_message('info', 'Starting daily flood prediction alerts at ' . date('Y-m-d H:i:s'));

        // Get tomorrow's prediction
        $tomorrow = $this->getTomorrowPrediction();

        if (!$tomorrow) {
            log_message('error', 'Failed to get tomorrow\'s prediction data');
            echo "Failed to get prediction data\n";
            return;
        }

        log_message('info', "Tomorrow's prediction: {$tomorrow['date']} - {$tomorrow['percent']}% - {$tomorrow['prediction']}");
        echo "DEBUG: Tomorrow's prediction: {$tomorrow['date']} - {$tomorrow['percent']}% - {$tomorrow['prediction']}\n";

        // Get users who should be alerted
        $userModel = new UserModel();
        $today = date('Y-m-d');

        // DEBUG: Log all users with alerts enabled
        $allUsersWithAlerts = $userModel
            ->where('(alert_email_enabled = 1 OR alert_sms_enabled = 1)')
            ->findAll();
        log_message('info', 'Users with alerts enabled: ' . count($allUsersWithAlerts));
        echo "DEBUG: Users with alerts enabled: " . count($allUsersWithAlerts) . "\n";
        foreach ($allUsersWithAlerts as $user) {
            log_message('info', "User {$user['username']}: threshold={$user['alert_min_probability']}, email={$user['alert_email_enabled']}, sms={$user['alert_sms_enabled']}");
            echo "DEBUG: User {$user['username']}: threshold={$user['alert_min_probability']}, email={$user['alert_email_enabled']}, sms={$user['alert_sms_enabled']}\n";
        }

        $users = $userModel
            ->where('(alert_email_enabled = 1 OR alert_sms_enabled = 1)')
            ->where('alert_min_probability <=', $tomorrow['percent'])
            ->findAll();

        log_message('info', 'Users meeting threshold criteria: ' . count($users));
        echo "DEBUG: Users meeting threshold criteria: " . count($users) . " (probability {$tomorrow['percent']}% must be >= user threshold)\n";

        $emailController = new \App\Controllers\Email_cont();
        $smsController = new \App\Controllers\SmsController();
        
        $sentEmail = 0;
        $sentSMS = 0;
        $skipped = 0;

        foreach ($users as $user) {
            // Check if already alerted today
            if ($user['last_flood_alert_date'] === $today) {
                $skipped++;
                log_message('info', "Skipping user {$user['username']} - already alerted today");
                continue;
            }

            // Send email if enabled
            if ($user['alert_email_enabled'] && !empty($user['email'])) {
                $emailResult = $emailController->sendFloodPredictionAlert($user, $tomorrow);
                if ($emailResult) {
                    $sentEmail++;
                    log_message('info', "Email alert sent to {$user['email']}");
                }
            }

            // Send SMS if enabled
            if ($user['alert_sms_enabled'] && !empty($user['phone'])) {
                $smsResult = $smsController->sendFloodPredictionAlertSMS($user, $tomorrow);
                if ($smsResult) {
                    $sentSMS++;
                    log_message('info', "SMS alert sent to {$user['phone']}");
                }
            }

            // Update user's last alert info
            $userModel->update($user['id'], [
                'last_flood_alert_date' => $today,
                'last_flood_alert_probability' => $tomorrow['probability']
            ]);
        }

        $summary = "Daily flood alerts completed: {$sentEmail} emails, {$sentSMS} SMS sent, {$skipped} skipped";
        log_message('info', $summary);
        echo $summary . "\n";
    }
}
