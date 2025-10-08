<!DOCTYPE html>
<html>
<head>
<title>Flood Prediction</title>
<meta http-equiv="refresh" content="1800">
    <link rel="stylesheet" href="<?= base_url('assets/css/Logo.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/header.css') ?>" />
<style>
  body {text-align: center; }
  #loading { font-size: 18px; margin-top: 20px; }
  table { border-collapse: collapse; margin: 20px auto; }
  th, td { border: 1px solid #ccc; padding: 6px 10px; }
  .flood { background: #ffe5e5; color: #b30000; }
  .no-flood { background: #e6f7ff; color: #0077b6; }
  .user-info {
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      border-left: 4px solid #007bff;
  }
  .user-info h4 {
      margin: 0 0 10px 0;
      color: #007bff;
  }
  .force-reload:hover {
      background-color: #b02a37 !important;
      transform: scale(1.05);
      transition: all 0.2s ease;
  }

  /* Styles for Probability and Prediction columns */
  .probability {
      background-color: #ccffcc; /* light green */
      color: #006600;            /* dark green text */
      font-weight: bold;
  }

  .prediction {
      background-color: #ffffcc; /* light yellow */
      color: #333300;            /* dark text */
      font-weight: bold;
  }
</style>
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

<!-- Session Check and User Info -->

<?php
$back_url = session()->get('logged_in') ? site_url('/home') : site_url('/home');
$is_admin = session()->get('role') === 'admin';
?>
<div style="text-align: center; margin: 20px 0;">
    <a href="<?= $back_url ?>" style="display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">Home</a>
    <?php if ($is_admin): ?>
        <button onclick="forceReload()" class="force-reload" style="display: inline-block; margin-left: 10px; padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">Force Reload</button>
    <?php endif; ?>
</div>

<h2> 5-Day Flood Outlook</h2>

<div id="loading"> Fetching prediction data...</div>
<div id="results" style="display:none;"></div>

<script>
const cacheKey = 'daily_predictions';

window.forceReload = function() {
    localStorage.removeItem(cacheKey);
    location.reload();
};

document.addEventListener("DOMContentLoaded", function () {
    const cacheExpiry = 30 * 60 * 1000; // 30 minutes in milliseconds

    // Check if cached data exists and is not expired
    const cached = localStorage.getItem(cacheKey);
    if (cached) {
        const parsed = JSON.parse(cached);
        if (Date.now() - parsed.timestamp < cacheExpiry) {
            displayData(parsed.data);
            return;
        }
    }

    // Fetch new data
    fetch("<?= site_url('flood/predict-ajax') ?>")
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            // Cache the data
            localStorage.setItem(cacheKey, JSON.stringify({
                data: data,
                timestamp: Date.now()
            }));
            displayData(data);
        } else {
            document.getElementById('loading').innerHTML = "❌ Failed: " + data.message;
        }
    })
    .catch(err => {
        document.getElementById('loading').innerHTML = "❌ Error: " + err.message;
    });

    function displayData(data) {
        let html = `<table><tr>
            <th>Date</th><th>Prob %</th><th>Prediction</th>
            <th>W-code</th><th>Rain mm</th><th>Tmp Max °C</th><th>Tmp Min °C</th><th>Discharge m³/s</th>
        </tr>`;
        data.days.forEach(d => {
            html += `<tr class="${d.prediction==='FLOOD'?'flood':'no-flood'}">
                <td>${d.date}</td>
                <td class="probability">${(d.probability*10000).toFixed(2)}</td>
                <td class="prediction">${d.prediction}</td>
                <td>${d.weather_code}</td>
                <td>${d.rain_sum}</td>
                <td>${d.temp_max}</td>
                <td>${d.temp_min}</td>
                <td>${d.river_discharge}</td>
            </tr>`;
        });
        html += `</table>`;
        document.getElementById('loading').style.display = 'none';
        document.getElementById('results').innerHTML = html;
        document.getElementById('results').style.display = 'block';
    }
});
</script>

</body>
</html>
