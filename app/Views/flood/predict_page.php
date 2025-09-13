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
</style>
</head>
<body>

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
