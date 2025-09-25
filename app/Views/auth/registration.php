<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - AlertoMarikeno</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/register.css') ?>">  <!-- Add your CSS file link -->
</head>
<body>

<!-- Home button -->
<a href="<?= site_url('/landing') ?>" class="home-button">Home</a>

<div class="container">
    <!-- Left section (Form) -->
    <div class="left-section">
        <!-- Logo -->
        <div class="logo">
            <span class="logo-text">AlertoMarikeno</span>
        </div>
        
        <h3>Create Your Account</h3>

        <!-- Validation Errors (If any) -->
        <?php if (isset($validation)): ?>
            <div style="color:red;">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <p style="color:red"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <p style="color:green"><?= session()->getFlashdata('success') ?></p>
        <?php endif; ?>

        <!-- Registration Form -->
        <form method="post" action="<?= site_url('auth/register') ?>">
            <?= csrf_field() ?> <!-- CSRF protection -->

            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>

            <label>Enable Alert Emails:</label><br>
            <input type="radio" name="alert_email_enabled" value="1" checked> Yes<br>
            <input type="radio" name="alert_email_enabled" value="0"> No<br>

            <button type="submit" class="btn-register">Register</button>
        </form>


        <!-- Custom Buttons -->
        <div class="link-actions">
                <a href="<?= site_url('auth/login') ?>" class="action-chip">back to login</a>
                <a href="<?= site_url('flood/predict') ?>" class="action-chip">Flood Prediction</a>
                <a href="<?= site_url('flood/river-status') ?>" class="action-chip">River Status</a>
        </div>
    </div>

    <!-- Right section (Welcome message & social login) -->
    <div class="right-section">
        <h2>Welcome Back!</h2>
        <p>Already have an account? Sign in and continue your journey!</p>
        <a href="<?= site_url('auth/login') ?>" class="btn-signin">Sign In</a>
    </div>
</div>

</body>
</html>

<!-- PUTANGINANG GITHUB YAN -->