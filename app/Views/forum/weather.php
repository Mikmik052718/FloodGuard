<!DOCTYPE html>
<html>
<head>
    <title>Weather Forecast</title>
</head>
<body>
    <h1>📍 Weather in Marikina</h1>

    <?php if ($current): ?>
        <h2>🌤️ Current Conditions</h2>
        <p>Time: <?= esc($current['time']) ?></p>
        <p>Temperature: <?= esc($current['temperature_2m']) ?> °C</p>
        <p>Wind Speed: <?= esc($current['wind_speed_10m']) ?> km/h</p>
    <?php else: ?>
        <p>❌ Failed to load current weather.</p>
    <?php endif; ?>

    <hr>

    <?php if ($hourly): ?>
        <h2>⏱️ Hourly Forecast (next 6 hours)</h2>
        <table border="1" cellpadding="5">
            <tr>
                <th>Time</th>
                <th>Temp (°C)</th>
                <th>Humidity (%)</th>
                <th>Wind Speed (km/h)</th>
            </tr>
            <?php for ($i = 0; $i < 6; $i++): ?>
                <tr>
                    <td><?= esc($hourly['time'][$i]) ?></td>
                    <td><?= esc($hourly['temperature_2m'][$i]) ?></td>
                    <td><?= esc($hourly['relative_humidity_2m'][$i]) ?></td>
                    <td><?= esc($hourly['wind_speed_10m'][$i]) ?></td>
                </tr>
            <?php endfor; ?>
        </table>
    <?php else: ?>
        <p>❌ No hourly forecast available.</p>
    <?php endif; ?>

    <br><a href="<?= site_url('/forum') ?>">⬅ Back to Forum</a>
</body>
</html>
