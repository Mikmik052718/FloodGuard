<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - AlertoMarikeno</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/reg.css') ?>">  <!-- Add your CSS file link -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertRadios = document.querySelectorAll('input[name="alert_method"]');
            const probabilitySection = document.getElementById('probabilitySection');
            const alertMinProbability = document.getElementById('alert_min_probability');
            const emailField = document.getElementById('emailField');
            const phoneField = document.getElementById('phoneField');
            const emailInput = document.querySelector('input[name="email"]');
            const phoneInput = document.querySelector('input[name="phone"]');

            function updateForm() {
                const selectedValue = document.querySelector('input[name="alert_method"]:checked').value;

                if (selectedValue === 'no') {
                    probabilitySection.style.display = 'none';
                    alertMinProbability.disabled = true;
                    emailField.style.display = 'none';
                    phoneField.style.display = 'none';
                    emailInput.required = false;
                    phoneInput.required = false;
                } else {
                    probabilitySection.style.display = 'block';
                    alertMinProbability.disabled = false;

                    if (selectedValue === 'email') {
                        emailField.style.display = 'block';
                        phoneField.style.display = 'none';
                        emailInput.required = true;
                        phoneInput.required = false;
                    } else if (selectedValue === 'mobile') {
                        emailField.style.display = 'none';
                        phoneField.style.display = 'block';
                        emailInput.required = false;
                        phoneInput.required = true;
                    } else if (selectedValue === 'both') {
                        emailField.style.display = 'block';
                        phoneField.style.display = 'block';
                        emailInput.required = true;
                        phoneInput.required = true;
                    }
                }
            }

            alertRadios.forEach(radio => {
                radio.addEventListener('change', updateForm);
            });

            // Initial call to set the form state
            updateForm();
        });
    </script>
</head>
<body>

<!-- Home button -->
<a href="<?= site_url('/') ?>" class="home-button">Home</a>

<div class="container">
    <!-- Left section (Form) -->
    <div class="left-section">
        <!-- Logo -->
        <div class="logo">AlertoMarikeno User Register<i class="fa fa-user-circle" aria-hidden="true"></i></div>
        <h3>Create Your Account</h3>
<br>
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

        <!-- Registration Form -->
        <form method="post" action="<?= site_url('auth/register') ?>" id="registrationForm">
            <?= csrf_field() ?> <!-- CSRF protection -->

            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>

            <label class="radio-label">Enable Alerts:</label>
            <div class="radio-group">
                <label class="custom-radio">
                    <input type="radio" name="alert_method" value="no" checked>
                    <span class="radio-mark"></span>
                    No
                </label>
                <label class="custom-radio">
                    <input type="radio" name="alert_method" value="mobile">
                    <span class="radio-mark"></span>
                    Mobile Number
                </label>
                <label class="custom-radio">
                    <input type="radio" name="alert_method" value="email">
                    <span class="radio-mark"></span>
                    Email
                </label>
                <label class="custom-radio">
                    <input type="radio" name="alert_method" value="both">
                    <span class="radio-mark"></span>
                    Both
                </label>
            </div>

            <div id="probabilitySection" style="display: none;">
                <p class="note">This part determines which probability percentage will the system notify you</p>
                <label for="alert_min_probability">Minimum Alert Probability:</label>
                <select name="alert_min_probability" id="alert_min_probability" disabled>
                    <option value="25">25%</option>
                    <option value="50" selected>50%</option>
                    <option value="70">70%</option>
                </select>
            </div>

            <div id="contactFields">
                <div id="emailField" style="display: none;">
                    <input type="email" name="email" placeholder="Email Address">
                </div>
                <div id="phoneField" style="display: none;">
                    <input type="tel" name="phone" placeholder="Phone Number">
                </div>
            </div>

            <button type="submit" class="btn-register" id="registerBtn">Register</button>
        </form>

        <script>
            document.getElementById('registrationForm').addEventListener('submit', function(e) {
                const selectedMethod = document.querySelector('input[name="alert_method"]:checked').value;
                const emailInput = document.querySelector('input[name="email"]');
                const phoneInput = document.querySelector('input[name="phone"]');

                let isValid = true;
                let errorMessage = '';

                if (selectedMethod === 'email' || selectedMethod === 'both') {
                    if (!emailInput.value.trim()) {
                        isValid = false;
                        errorMessage = 'Please enter your email address.';
                        emailInput.focus();
                    }
                }

                if (selectedMethod === 'mobile' || selectedMethod === 'both') {
                    if (!phoneInput.value.trim()) {
                        isValid = false;
                        if (errorMessage) {
                            errorMessage += ' Please enter your phone number.';
                        } else {
                            errorMessage = 'Please enter your phone number.';
                        }
                        if (!emailInput.value.trim()) phoneInput.focus();
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    alert(errorMessage);
                }
            });
        </script>


        <!-- Custom Buttons -->
         <div class="link-actions">
                <a href="<?= site_url('auth/uslogin') ?>" class="action-chip">Back To Login</a>
                <a href="<?= site_url('flood/predict') ?>" class="action-chip">Flood Prediction</a>
                <a href="<?= site_url('flood/river-status') ?>" class="action-chip">River Status</a>
        </div>
    </div>

    <!-- Right section (Welcome message & social login) -->
    <div class="right-section">
        <h2>Welcome!</h2>
        <p>Already have an account? Sign in and continue your journey!</p>
        <br>
        <a href="<?= site_url('auth/uslogin') ?>" class="btn-signin">Sign In</a>
        <div class="google-login">
                        <p style="text-align: center; margin: 5px 0; color: #666;">or</p>
                        <a href="<?= site_url('auth/google') ?>" class="btn-google">
                            <svg width="18" height="18" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Continue with Google
                        </a>
                    </div>
        
    </div>
</div>

</body>
</html>
