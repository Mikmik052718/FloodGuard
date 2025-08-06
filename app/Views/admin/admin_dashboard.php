<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-icons.css') ?>">
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
                    <a class="nav-link text-white" href="#"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#"><i class="bi bi-people-fill me-2"></i> Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#"><i class="bi bi-card-text me-2"></i> Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#"><i class="bi bi-bar-chart-fill me-2"></i> Reports</a>
                </li>
                <li class="nav-item mt-5">
                    <a class="btn btn-outline-light w-75" href="<?= site_url('status/admin_login') ?>">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main -->
        <main class="col-md-10 ms-sm-auto px-4">
            <section class="hero-section">
                <h1><i class="bi bi-speedometer2 me-2"></i>Welcome, Admin</h1>
                <p>Monitor and manage the flood prediction platform.</p>
            </section>

            <section class="featured-section">
                <div class="container">
                    <div class="row g-4">
                        <!-- USERS CARD -->
                        <div class="col-md-4">
                            <div class="custom-block">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5><i class="bi bi-people-fill me-2"></i>Users</h5>
                                        <p>Manage user accounts and access rights.</p>
                                    </div>
                                    <span class="badge bg-primary-badge">42</span>
                                </div>
                                <img src="<?= base_url('assets/images/users.png') ?>" class="custom-block-image" alt="Users">
                            </div>
                        </div>

                        <!-- POSTS CARD -->
                        <div class="col-md-4">
                            <div class="custom-block">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5><i class="bi bi-card-text me-2"></i>Posts</h5>
                                        <p>Review and moderate news feed posts.</p>
                                    </div>
                                    <span class="badge bg-secondary-badge">128</span>
                                </div>
                                <img src="<?= base_url('assets/images/posts.png') ?>" class="custom-block-image" alt="Posts">
                            </div>
                        </div>

                        <!-- REPORTS CARD -->
                        <div class="col-md-4">
                            <div class="custom-block">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5><i class="bi bi-bar-chart-fill me-2"></i>Reports</h5>
                                        <p>View system logs and flood alerts.</p>
                                    </div>
                                    <span class="badge bg-accent-badge">10</span>
                                </div>
                                <img src="<?= base_url('assets/images/report.png') ?>" class="custom-block-image" alt="Reports">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

<!-- JS --
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
