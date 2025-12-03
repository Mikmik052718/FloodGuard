<?php
/**
 * Timezone Diagnostic Tool
 * Check current timezone settings
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Timezone Check</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .info { background: #e3f2fd; padding: 15px; margin: 10px 0; border-left: 4px solid #2196F3; }
        .success { background: #e8f5e9; border-left-color: #4CAF50; }
        .error { background: #ffebee; border-left-color: #f44336; }
        h1 { color: #333; }
        h2 { color: #666; margin-top: 30px; }
        code { background: #f5f5f5; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>🕐 Timezone Diagnostic Tool</h1>
    
    <h2>PHP Timezone Settings</h2>
    <div class="info">
        <strong>date_default_timezone_get():</strong> <?= date_default_timezone_get() ?>
    </div>
    <div class="info">
        <strong>ini_get('date.timezone'):</strong> <?= ini_get('date.timezone') ?: 'Not set' ?>
    </div>
    <div class="info">
        <strong>Current PHP time:</strong> <?= date('Y-m-d H:i:s') ?>
    </div>
    <div class="info">
        <strong>Current PHP time (Asia/Manila):</strong> 
        <?php
        $manila = new DateTimeZone('Asia/Manila');
        $now = new DateTime('now', $manila);
        echo $now->format('Y-m-d H:i:s');
        ?>
    </div>
    
    <h2>System Timezone</h2>
    <div class="info">
        <strong>TZ Environment Variable:</strong> <?= getenv('TZ') ?: 'Not set' ?>
    </div>
    <div class="info">
        <strong>System date command:</strong>
        <pre><?= shell_exec('date') ?></pre>
    </div>
    <div class="info">
        <strong>/etc/timezone:</strong>
        <pre><?= file_exists('/etc/timezone') ? file_get_contents('/etc/timezone') : 'File not found' ?></pre>
    </div>
    
    <h2>Database Timezone</h2>
    <?php
    try {
        $host = getenv('database.default.hostname') ?: 'localhost';
        $user = getenv('database.default.username') ?: 'root';
        $pass = getenv('database.default.password') ?: '';
        $db = getenv('database.default.database') ?: 'floodguard';
        $port = getenv('database.default.port') ?: 3306;
        
        $conn = new mysqli($host, $user, $pass, $db, $port);
        
        if ($conn->connect_error) {
            echo '<div class="error">Database connection failed: ' . $conn->connect_error . '</div>';
        } else {
            $result = $conn->query("SELECT NOW() as db_time, @@system_time_zone as system_tz, @@global.time_zone as global_tz, @@session.time_zone as session_tz");
            if ($result) {
                $row = $result->fetch_assoc();
                echo '<div class="info"><strong>Database NOW():</strong> ' . $row['db_time'] . '</div>';
                echo '<div class="info"><strong>System timezone:</strong> ' . $row['system_tz'] . '</div>';
                echo '<div class="info"><strong>Global timezone:</strong> ' . $row['global_tz'] . '</div>';
                echo '<div class="info"><strong>Session timezone:</strong> ' . $row['session_tz'] . '</div>';
            }
            $conn->close();
        }
    } catch (Exception $e) {
        echo '<div class="error">Error: ' . $e->getMessage() . '</div>';
    }
    ?>
    
    <h2>CodeIgniter App Config</h2>
    <?php
    if (file_exists(__DIR__ . '/../app/Config/App.php')) {
        $content = file_get_contents(__DIR__ . '/../app/Config/App.php');
        if (preg_match('/public string \$appTimezone = \'([^\']+)\';/', $content, $matches)) {
            $appTz = $matches[1];
            if ($appTz === 'Asia/Manila') {
                echo '<div class="success"><strong>App Config Timezone:</strong> ' . $appTz . ' ✅</div>';
            } else {
                echo '<div class="error"><strong>App Config Timezone:</strong> ' . $appTz . ' ❌ (Should be Asia/Manila)</div>';
            }
        }
    }
    ?>
    
    <h2>Recommendations</h2>
    <div class="info">
        <?php
        $phpTz = date_default_timezone_get();
        $sysTz = getenv('TZ');
        
        if ($phpTz !== 'Asia/Manila') {
            echo '<p>❌ PHP timezone is not set to Asia/Manila. Add this to your php.ini or set in code:</p>';
            echo '<code>date_default_timezone_set("Asia/Manila");</code>';
        } else {
            echo '<p>✅ PHP timezone is correctly set to Asia/Manila</p>';
        }
        
        if ($sysTz !== 'Asia/Manila') {
            echo '<p>❌ System TZ environment variable is not set. This means the Docker container needs to be rebuilt with the updated Dockerfile.</p>';
            echo '<p><strong>Action needed:</strong> Rebuild and redeploy your Docker container.</p>';
        } else {
            echo '<p>✅ System timezone is correctly set to Asia/Manila</p>';
        }
        ?>
    </div>
    
    <div class="error" style="margin-top: 30px;">
        <strong>⚠️ SECURITY WARNING:</strong> Delete this file after testing!<br>
        <code>rm public/timezone_check.php</code>
    </div>
</body>
</html>
