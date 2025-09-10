<?php
$ch = curl_init("https://api.open-meteo.com/v1/forecast?latitude=14.657293&longitude=121.11524&hourly=weather_code,rain,temperature_2m&timezone=auto&start_date=2025-08-24&end_date=2025-08-25");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);

if ($output === false) {
    echo 'cURL Error: ' . curl_error($ch);
} else {
    echo 'Success: ' . substr($output, 0, 200); // first 200 chars
}
curl_close($ch);
