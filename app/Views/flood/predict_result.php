<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <title>Flood Prediction Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .result {
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .flood {
            background-color: #ffe5e5;
            color: #b30000;
        }
        .no-flood {
            background-color: #e6f7ff;
            color: #0077b6;
        }
        .info {
            margin-top: 20px;
            font-size: 14px;
            text-align: left;
        }
    </style>
</head>
<body>
<h2 style="text-align:center;">🌦️ 5‑Day Flood Outlook</h2>

<table style="border-collapse:collapse;margin:auto;">
  <tr>
    <th>Date</th>
    <th>Prob&nbsp;%</th>
    <th>Prediction</th>
    <th>W‑code</th>
    <th>Rain&nbsp;mm</th>
    <th>Tmp Max °C</th>
    <th>Tmp Min °C</th>
    <th>Discharge m³/s</th>
  </tr>
  <?php foreach ($days as $d): ?>
    <tr class="<?= $d['prediction']==='FLOOD'?'flood':'no-flood' ?>">
      <td><?= esc($d['date']) ?></td>
      <td><?= number_format($d['probability']*100,2) ?></td>
      <td><?= esc($d['prediction']) ?></td>
      <td><?= esc($d['weather_code']) ?></td>
      <td><?= esc($d['rain_sum']) ?></td>
      <td><?= esc($d['temp_max']) ?></td>
      <td><?= esc($d['temp_min']) ?></td>
      <td><?= esc($d['river_discharge']) ?></td>
    </tr>
  <?php endforeach; ?>
</table>


    <hr>
<h3 style="text-align:center;">Flood Hazard Map</h3>
<div id="map" style="height: 400px; margin-top: 20px;"></div>

<div style="text-align:center; margin-top:10px;">
  <button onclick="locateMe()">📍 Identify My Location</button>
</div>


<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([14.65, 121.1], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 15
    }).addTo(map);

fetch("<?= base_url('flood_zones_simplified.geojson') ?>")
  .then(res => res.json())
  .then(data => {
    console.log("GeoJSON loaded:", data);
    L.geoJSON(data, {
      style: function (feature) {
        const level = feature.properties.Flood_Hazard_Level;
        return {
          color: "#151515", // border color
          weight: 0.3, // thicker border
          fillColor: level === 1 ? "#00ff00" : level === 2 ? "#ffff00" : "#ff0000",
          fillOpacity: 0.5
        };
      },
      onEachFeature: function (feature, layer) {
        layer.bindPopup("Flood Hazard Level: " + feature.properties.Flood_Hazard_Level);
      }
    }).addTo(map);
  });

function locateMe() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;

        var marker = L.marker([lat, lon]).addTo(map);
        marker.bindPopup("📍 You are here!").openPopup();

        map.setView([lat, lon], 15);
      },
      function (error) {
        alert("Geolocation failed: " + error.message);
      }
    );
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}


</script>
<div style="text-align:center; margin-top: 10px;">
  <strong>Flood Risk Legend:</strong><br>
  <span style="color:#00cc00;">■ Low</span>
  <span style="color:#ffcc00;">■ Medium</span>
  <span style="color:#ff3300;">■ High</span>
</div>

</body>
</html>
