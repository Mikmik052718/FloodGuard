<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - AlertoMarikeno</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/register.css') ?>">  <!-- Add your CSS file link -->
</head>w
<body>

<!-- Home button -->
<a href="#" class="home-button">Home</a>

<div class="container">
    <!-- Left section (Form) -->
    <div class="left-section">
        <!-- Logo -->
        <div class="logo">
            <span class="logo-text">AlertoMarikeno</span>
        </div>
        
        <h3>Create Your Account</h3>

        <?php if (isset($validation)): ?>
            <div style="color:red;">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <p style="color:red"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <p style="color:green"><?= session()->getFlashdata('success') ?></p>
        <?php endif; ?>

        <form method="post" action="<?= site_url('registration/register') ?>">
            <?= csrf_field() ?>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>

            <!-- Dropdown for Barangay Selection -->
            <label for="barangay">Select Barangay:</label>
            <select name="barangay" id="barangay" required>
                <option value="">Select Barangay</option>
                <option value="Barangka">Barangka</option>
                <option value="Calumpang">Calumpang</option>
                <option value="Concepcion I">Concepcion I (Uno)</option>
                <option value="Concepcion II">Concepcion II (Dos)</option>
                <option value="Fortune">Fortune</option>
                <option value="Industrial Valley Complex">Industrial Valley Complex</option>
                <option value="Jesus Dela Peña">Jesus Dela Peña</option>
                <option value="Malanday">Malanday</option>
                <option value="San Roque">San Roque</option>
                <option value="Santa Elena">Santa Elena</option>
                <option value="Santo Niño">Santo Niño</option>
                <option value="Tañong">Tañong</option>
                <option value="Tumana">Tumana</option>
                <option value="Marikina Heights">Marikina Heights</option>
                <option value="Nangka">Nangka</option>
                <option value="Parang">Parang</option>
            </select>
            
            <button type="submit" class="btn-register">Register</button>
        </form>

        <div class="or-divider">OR</div>

        <p>Already have an account? <a href="<?= site_url('auth/login') ?>">Login here</a></p>

    </div>

    <!-- Right section (Welcome message & social login) -->
    <div class="right-section">
        <h2>Welcome Back!</h2>
        <p>Already have an account? Sign in and continue your journey!</p>
        <button class="btn-signin">Sign In</button>
    </div>
</div>

</body>
</html>
