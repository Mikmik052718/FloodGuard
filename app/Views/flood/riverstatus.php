<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="300"> <!-- Refresh every 5 minutes -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Water Levels at Sto Nino</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
      color: #333;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1 {
      color: #007BFF;
    }
    .level {
      font-size: 1.2em;
      margin: 10px 0;
    }
    .footer {
      font-size: 0.9em;
      color: #888;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Water Levels at Sto Nino</h1>

    <?php
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

    // Decode JSON
    $data = json_decode($response, true);

    // Search for Sto Nino
    $targetStation = null;
    foreach ($data as $station) {
        if (strtolower(trim($station["obsnm"])) === "sto nino") {
            $targetStation = $station;
            break;
        }
    }

    // Output levels
    if ($targetStation && !empty($targetStation["wl"])) {
        echo "<div class='level'>Current: " . $targetStation["wl"] . " m</div>";
        echo "<div class='level'>-30 min: " . $targetStation["wl30m"] . " m</div>";
        echo "<div class='level'>-1 hr: " . $targetStation["wl1h"] . " m</div>";
        echo "<div class='level'>-2 hr: " . $targetStation["wl2h"] . " m</div>";
        echo "<div class='level'>Alert Level: " . $targetStation["alertwl"] . " m</div>";
        echo "<div class='level'>Alarm Level: " . $targetStation["alarmwl"] . " m</div>";
        echo "<div class='level'>Critical Level: " . $targetStation["criticalwl"] . " m</div>";
    } else {
        echo "<p>No recent data found for Sto Nino. ):</p>";
    }
    ?>

    <div class="footer" id="last-updated">Last updated: <span></span></div>
  </div>

  <script>
    const now = new Date();
    const options = {
      year: 'numeric', month: 'long', day: 'numeric',
      hour: 'numeric', minute: '2-digit',
      hour12: true,
    };
    document.querySelector('#last-updated span').textContent = now.toLocaleString('en-US', options);
  </script>
</body>
</html>
