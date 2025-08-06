<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_login.css'); ?>">
</head>
<body>
    <div class="logo">FloodPredict Admin</div>
    <div class="container">
        <div class="left-section">
            <h2>Admin Login</h2>
            <p style="text-align:center; margin-bottom: 15px; color: #666">Only authorized users can access</p>

            <?php if (!empty($error)): ?>
                <p style="color:red; text-align: center;"><?= $error ?></p>
            <?php endif; ?>

            <form onsubmit="window.location.href='<?= site_url('Status/admin_dashboard') ?>'; return false;">
                <input type="text" name="username" placeholder="Admin Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn-login">Sign In</button>
            </form>

            <!--<form method="post" action="<?= site_url('Status/admin_login') ?>">
                <input type="text" name="username" placeholder="Admin Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn-login">Sign In</button>
            </form> -->
        </div>
        <div class="right-section">
            <h3>Admin Panel</h3>
            <p>Manage flood prediction data, users, and settings.</p>
        </div>
    </div>
</body>
</html>
