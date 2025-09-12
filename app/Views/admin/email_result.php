<!DOCTYPE html>
<html>
<head>
    <title>Email Results</title>
</head>
<body>
    <h2>📊 Email Sending Results</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Email</th>
            <th>Status</th>
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= esc($row['email']) ?></td>
                <td><?= $row['status'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="<?= site_url('email') ?>">⬅ Back</a>
</body>
</html>
