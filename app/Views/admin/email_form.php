<?php
// app/Views/admin/email_form.php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Email Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-icons.css') ?>">

    <!-- Custom Admin Dashboard CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css') ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-dark sidebar text-white" style="height: 100vh; padding-top: 30px;">
            <div class="text-center mb-4">
                <h4><i class="bi bi-speedometer2"></i> Admin</h4>
            </div>
            <ul class="nav flex-column text-center">
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= site_url('admin/admin_dashboard') ?>"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= site_url('admin/users') ?>"><i class="bi bi-people-fill me-2"></i> Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= site_url('admin/posts') ?>"><i class="bi bi-card-text me-2"></i> Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white active" href="<?= site_url('email') ?>"><i class="bi bi-envelope-fill me-2"></i> Email</a>
                </li>
                <li class="nav-item mt-5">
                    <a class="btn btn-outline-light w-75" href="<?= site_url('auth/logout') ?>">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-4">
            <section class="hero-section">
                <h1><i class="bi bi-envelope-fill me-2"></i>Email Users</h1>
                <p>Send emails to users from the admin panel.</p>
            </section>

            <section class="featured-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="custom-block">
                                <h5><i class="bi bi-envelope-fill me-2"></i>Send Email</h5>
                                <form action="<?= site_url('email/send') ?>" method="post" class="mt-3">
                                    <div class="mb-3">
                                        <label for="user_id" class="form-label">Select User:</label>
                                        <select name="user_id" class="form-select" required>
                                            <option value="all">-- Send to All Users --</option>
                                            <?php foreach ($users as $user): ?>
                                                <option value="<?= $user['id'] ?>"><?= esc($user['username']) ?> (<?= esc($user['email']) ?>)</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Subject (Heading):</label>
                                        <input type="text" id="subject" name="subject" class="form-control" required placeholder="Enter email subject">
                                    </div>

                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message:</label>
                                        <textarea id="message" name="message" class="form-control" rows="4" required placeholder="Enter your message here"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Send Email</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

<!-- JS -->
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
