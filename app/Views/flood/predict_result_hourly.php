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
    </style>
</head>
<body>
<h2> Hourly Flood Prediction</h2>

<table>
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
  <?php foreach ($hours as $h): ?>
    <tr class="<?= $h['prediction']==='FLOOD'?'flood':'no-flood' ?>">
      <td><?= esc($h['datetime']) ?></td>
      <td><?= number_format($h['probability']*100,2) ?></td>
      <td><?= esc($h['prediction']) ?></td>
      <td><?= esc($h['weather_code']) ?></td>
      <td><?= esc($h['rain']) ?></td>
      <td><?= esc($h['temp']) ?></td>
      <td><?= esc($h['soil_0_7']) ?></td>
      <td><?= esc($h['discharge']) ?></td>
      <td><?= esc($h['wind_gusts']) ?></td>
    </tr>
  <?php endforeach; ?>
</table>

</body>
</html>
