<!DOCTYPE html>
<html>
<head>
    <title>Hourly Flood Prediction</title>
    <meta http-equiv="refresh" content="1800">
    <link rel="stylesheet" href="<?= base_url('assets/css/Logo.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/header.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/predicthourly.css') ?>" />
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
    <?php if ($is_admin): ?>
        <button onclick="forceReload()" class="force-reload" style="display: inline-block; margin-left: 10px; padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">Force Reload</button>
    <?php endif; ?>
</div>

<h2> Hourly Flood Prediction</h2>

<table id="hourlyTable">
  <thead>
    <tr>
      <th>Datetime</th>
      <th>Prob&nbsp;%</th>
      <th>Prediction</th>
      <th>W-code</th>
      <th>Rain&nbsp;mm</th>
      <th>Temp&nbsp;°C</th>
      <th>Soil 0-7cm</th>
      <th>Discharge m³/s</th>
      <th>Wind Gusts km/h</th>
    </tr>
  </thead>
  <tbody>
    <tr><td colspan="9" style="text-align:center;">Loading predictions...</td></tr>
  </tbody>
</table>

<script>
const cacheKey = 'hourly_predictions';

window.forceReload = function() {
    localStorage.removeItem(cacheKey);
    location.reload();
};

document.addEventListener("DOMContentLoaded", function() {
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
    fetch("<?= site_url('flood/hourly/data') ?>")
      .then(res => res.json())
      .then(data => {
          if (data.error) {
              document.querySelector("#hourlyTable tbody").innerHTML = `<tr><td colspan="9" style="color:red;text-align:center;">Error: ${data.error}</td></tr>`;
              return;
          }
          // Cache the data
          localStorage.setItem(cacheKey, JSON.stringify({
              data: data,
              timestamp: Date.now()
          }));
          displayData(data);
      })
      .catch(err => {
          document.querySelector("#hourlyTable tbody").innerHTML = `<tr><td colspan="9" style="color:red;text-align:center;">Failed to load data.</td></tr>`;
          console.error(err);
      });

    function displayData(data) {
        const tbody = document.querySelector("#hourlyTable tbody");
        tbody.innerHTML = "";
        data.hours.forEach(h => {
            const row = document.createElement("tr");
            row.className = (h.prediction === "FLOOD") ? "flood" : "no-flood";
            row.innerHTML = `
              <td>${h.datetime}</td>
              <td class="probability">${(h.probability*100).toFixed(4)}</td>
              <td class="prediction">${h.prediction}</td>
              <td>${h.weather_code}</td>
              <td>${h.rain}</td>
              <td>${h.temp}</td>
              <td>${h.soil_0_7}</td>
              <td>${h.discharge}</td>
              <td>${h.wind_gusts}</td>`;
            tbody.appendChild(row);
        });
    }
});
</script>

</body>
</html>