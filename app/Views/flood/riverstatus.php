<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="300"> <!-- Refresh every 5 minutes -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Water Levels at Sto Nino</title>
<link rel="stylesheet" href="<?= base_url('assets/css/Logo.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/css/header.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/css/riverstatus.css') ?>" />
</head>
<header>
    <a href="<?= site_url('home') ?>" class="logo">
                       
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke-width="3">
                       
                        <path d="M20 40a12 12 0 0 1 0-24 14 14 0 0 1 28 4h2a10 10 0 0 1 0 20H20z" fill="none"/>
                      
                        <line x1="24" y1="44" x2="20" y2="54"/>
                        <line x1="32" y1="44" x2="28" y2="54"/>
                        <line x1="40" y1="44" x2="36" y2="54"/>
                       
                        <path d="M16 58q4 4 8 0t8 0 8 0 8 0" fill="none"/>
                        </svg>

                        <div class="divider"></div>

                        <div class="logo-text">AlertoMarikeno</div>
                    </a>
    <div class="nav-links">
      <?php if (session()->get('logged_in')): ?>
        <span>
          Logged in as <strong><?= esc(session()->get('username')) ?></strong> | 
          <a href="<?= site_url('auth/logout') ?>" class="logout-link">Logout</a>
        </span>
      <?php endif; ?>
    </div>
  </header>
<body>
  
  <div class="container">
    <h1>Sto Nino Water Level</h1>

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

    // For testing API failure, uncomment the next line:
     $response = false; // Simulate API failure

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

    // Output levels (always show, even if API fails)
    echo "<div class='level'>Current: " . ($targetStation["wl"] ?? "N/A") . " m</div>";
    echo "<div class='level'>-30 min: " . ($targetStation["wl30m"] ?? "N/A") . " m</div>";
    echo "<div class='level'>-1 hr: " . ($targetStation["wl1h"] ?? "N/A") . " m</div>";
    echo "<div class='level'>-2 hr: " . ($targetStation["wl2h"] ?? "N/A") . " m</div>";
    //echo "<div class='level'>-3 hr: " . ($targetStation["wl3h"] ?? "N/A") . " m</div>";
    //echo "<div class='level'>-12 hr: " . ($targetStation["wl12h"] ?? "N/A") . " m</div>";
    echo "<div class='level'>Alert Level: " . ($targetStation["alertwl"] ?? "N/A") . " m</div>";
    echo "<div class='level'>Alarm Level: " . ($targetStation["alarmwl"] ?? "N/A") . " m</div>";
    echo "<div class='level'>Critical Level: " . ($targetStation["criticalwl"] ?? "N/A") . " m</div>";
    ?>

    <div class="footer" id="last-updated">Last updated: <span></span></div>

    <div class="navigation">
      <a href="<?= site_url('flood/hazard-maps') ?>" class="btn">Hazard Maps</a>
      <a href="<?= site_url('flood/daily') ?>" class="btn">Daily Predictions</a>
      <a href="<?= site_url('flood/hourly') ?>" class="btn">3 Hour Predictions</a>
    </div>
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
