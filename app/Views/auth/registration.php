<!DOCTYPE html>
<html>
<head>
    <title>User Registration - FloodGuard</title>
</head>
<body>
    <h1>Register</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color:green"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <form method="post" action="<?= site_url('auth/register') ?>">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirm Password:</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">Register</button>
    </form>

    <br>
    <a href="<?= site_url('auth/login') ?>">Back to Login</a>

    <a href="<?= site_url('flood/predict') ?>">Go to Flood Prediction Page</a><br>
<a href="<?= site_url('flood/river-status') ?>">View River Status</a>
</body>
</html>
