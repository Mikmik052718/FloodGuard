<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Login • FloodPredict</title>

    <!-- Point this to wherever you placed the CSS file -->
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_login.css') ?>">
</head>
<body>

    <!-- Top-left brand -->
    <div class="logo">FloodPredict Admin</div>

    <div class="container">
        <!-- LEFT: form -->
        <section class="left-section">
            <h2>Admin Login</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <p class="error"><?= esc(session()->getFlashdata('error')) ?></p>
            <?php endif; ?>

            <form method="post" action="<?= site_url('auth/attemptLogin') ?>">
                <?= csrf_field() ?> <!-- CodeIgniter 4 CSRF, safe to keep even if disabled -->

                <input
                    type="text"
                    name="username"
                    placeholder="Admin Username"
                    autocomplete="username"
                    required
                />

                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    autocomplete="current-password"
                    required
                />

                <button class="btn-login" type="submit">Sign In</button>
            </form>

            <!-- small links under the form -->
            <div class="link-actions">
                <a href="<?= site_url('auth/register') ?>" class="action-chip">Create an account</a>
                <a href="<?= site_url('flood/predict') ?>" class="action-chip">Flood Prediction</a>
                <a href="<?= site_url('flood/river-status') ?>" class="action-chip">River Status</a>
            </div>

        </section>

        <!-- RIGHT: panel blurb -->
        <section class="right-section">
            <h3>Admin Panel</h3>
            <p>Manage flood prediction data, users, and settings.</p>
        </section>
    </div>

</body>
</html>
