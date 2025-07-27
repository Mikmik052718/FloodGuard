<!DOCTYPE html>
<html>
<head><title>Daily Weather + Flood Data</title></head>
<body>
    <h1>🌦️ Daily Weather & River Discharge (2024, Antipolo)</h1>

    <?php if ($weather && $flood): ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>Date</th>
                <th>Precipitation (mm)</th>
                <th>Rain (mm)</th>
                <th>Rain Hours</th>
                <th>Wind Gust Max (km/h)</th>
                <th>Weather Code</th>
                <th>River Discharge (m³/s)</th>
            </tr>
            <?php for ($i = 0; $i < count($weather['time']); $i++): ?>
                <tr>
                    <td><?= esc($weather['time'][$i]) ?></td>
                    <td><?= esc($weather['precipitation_sum'][$i]) ?></td>
                    <td><?= esc($weather['rain_sum'][$i]) ?></td>
                    <td><?= esc($weather['precipitation_hours'][$i]) ?></td>
                    <td><?= esc($weather['wind_gusts_10m_max'][$i]) ?></td>
                    <td><?= esc($weather['weather_code'][$i]) ?></td>
                    <td><?= esc($flood['river_discharge'][$i]) ?></td>
                </tr>
            <?php endfor; ?>
        </table>
    <?php else: ?>
        <p>⚠️ Weather or flood data is missing or failed to load.</p>
    <?php endif; ?>

    <br><a href="<?= site_url('/forum') ?>">⬅ Back to Forum</a>
</body>
</html>
