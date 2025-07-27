<!DOCTYPE html>
<html>
<head><title>Login Page</title></head>
<body>
    <h1>Login</h1>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>
    <form method="post" action="<?= site_url('auth/attemptLogin') ?>">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
    <br>
    <a href="<?= site_url('auth/register') ?>">Don't have an account? Register here</a>

    <br>
<a href="<?= site_url('flood/predict') ?>">Go to Flood Prediction Page</a><br>
<a href="<?= site_url('flood/river-status') ?>">View River Status</a>

</body>
</html>
