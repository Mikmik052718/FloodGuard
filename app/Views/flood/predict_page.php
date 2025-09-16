<!DOCTYPE html>
<html>
<head>
<title>Flood Prediction</title>
<style>
  body { font-family: Arial, sans-serif; margin: 30px; text-align: center; }
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

<h2>🌦️ 5-Day Flood Outlook</h2>

<div id="loading">⏳ Fetching prediction data...</div>
<div id="results" style="display:none;"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch("<?= site_url('flood/predict-ajax') ?>")
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            let html = `<table><tr>
                <th>Date</th><th>Prob %</th><th>Prediction</th>
                <th>W-code</th><th>Rain mm</th><th>Tmp Max °C</th><th>Tmp Min °C</th><th>Discharge m³/s</th>
            </tr>`;
            data.days.forEach(d => {
                html += `<tr class="${d.prediction==='FLOOD'?'flood':'no-flood'}">
                    <td>${d.date}</td>
                    <td>${(d.probability*100).toFixed(2)}</td>
                    <td>${d.prediction}</td>
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
        } else {
            document.getElementById('loading').innerHTML = "❌ Failed: " + data.message;
        }
    })
    .catch(err => {
        document.getElementById('loading').innerHTML = "❌ Error: " + err.message;
    });
});
</script>

</body>
</html>
