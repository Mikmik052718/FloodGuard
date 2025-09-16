<!DOCTYPE html>
<html>
<head>
    <title>Hourly Flood Prediction</title>
    <meta http-equiv="refresh" content="1800">
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 40px;
}
.flood { background-color: #ffe5e5; color: #b30000; }
.no-flood { background-color: #e6f7ff; color: #0077b6; }
table { border-collapse: collapse; margin: auto; width: 95%; }
table th, table td { padding: 8px 12px; border: 1px solid #ccc; text-align: center; }
h2 { text-align: center; margin-bottom: 20px; }

/* ✅ New style for Probability column */
.probability {
    background-color: #ccffcc; /* light green */
    color: #006600;            /* dark green text */
    font-weight: bold;
}

/* ✅ New style for Prediction column */
.prediction {
    background-color: #ffffcc; /* light yellow */
    color: #333300;            /* dark text */
    font-weight: bold;
}
    </style>
    <style>
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
    </style>
</head>
<body>

<!-- Session Check and User Info -->
<?php if (session()->get('logged_in')): ?>
    <div class="user-info">
        <h4>👤 Welcome, <?= esc(session()->get('username')) ?>!</h4>
        <p><strong>User ID:</strong> <?= esc(session()->get('user_id')) ?></p>
        <p><strong>Role:</strong> <?= esc(session()->get('role')) ?></p>
        <p><strong>Session Active:</strong> ✅ Yes</p>
    </div>
<?php else: ?>
    <div class="user-info" style="border-left-color: #dc3545; background-color: #f8d7da;">
        <h4 style="color: #dc3545;">⚠️ No Active Session</h4>
        <p>You are viewing this page as a guest. <a href="<?= site_url('auth/uslogin') ?>">Login</a> to save your location and get personalized alerts.</p>
    </div>
<?php endif; ?>

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
document.addEventListener("DOMContentLoaded", function() {
    fetch("<?= site_url('flood/hourly/data') ?>")
      .then(res => res.json())
      .then(data => {
          const tbody = document.querySelector("#hourlyTable tbody");
          tbody.innerHTML = "";
          if (data.error) {
              tbody.innerHTML = `<tr><td colspan="9" style="color:red;text-align:center;">Error: ${data.error}</td></tr>`;
              return;
          }
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
      })
      .catch(err => {
          document.querySelector("#hourlyTable tbody").innerHTML = `<tr><td colspan="9" style="color:red;text-align:center;">Failed to load data.</td></tr>`;
          console.error(err);
      });
});
</script>

</body>
</html>