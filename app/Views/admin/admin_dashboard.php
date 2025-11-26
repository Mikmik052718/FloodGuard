<?php 
// app/Views/admin/admin_dashboard.php
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap & Icons -->
<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
    min-height: 100vh;
    color: #f1f1f1;
}

/* Sidebar */
.sidebar {
    background: #121212;
    color: white;
    height: 100%;
    padding-top: 2rem;
    box-shadow: 2px 0 10px rgba(0,0,0,0.5);
}

.sidebar h4 { font-weight: 600; }

.nav-link {
    color: rgba(255,255,255,0.8);
    margin: 0.3rem 0;
    transition: all 0.3s ease;
    font-weight: 500;
}

.nav-link:hover, .nav-link.active {
    background-color: #203a43;
    border-radius: 8px;
    color: #fff;
}

.nav-link i { font-size: 1.2rem; }

.btn-logout {
    margin-top: 3rem;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-logout:hover {
    background-color: #ff4b5c;
    color: white;
    border-color: #ff4b5c;
}

/* Main Content */
main {
    padding: 2rem 1.5rem;
}

.hero-section {
    background: #121212;
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    backdrop-filter: blur(4px);
}

/* Featured Cards */
.featured-section .custom-block {
    background: rgba(255,255,255,0.15);
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    padding: 1.8rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
    color: #fff;
    backdrop-filter: blur(4px);
}

.featured-section .custom-block:hover {
    transform: translateY(-7px);
    box-shadow: 0 18px 35px rgba(0,0,0,0.45);
}

.custom-block h5 { font-weight: 700; font-size: 1.25rem; }
.custom-block p { color: #e0e0e0; }

.custom-block img {
    width: 70px;
    position: absolute;
    bottom: 10px;
    right: 10px;
    opacity: 0.2;
}

.badge {
    font-size: 0.9rem;
    font-weight: 500;
    padding: 0.5em 0.7em;
    border-radius: 10px;
}

.bg-primary-badge { background-color: rgba(32,58,67,0.8); color: white; }
.bg-secondary-badge { background-color: rgba(44,83,100,0.8); color: white; }

/* Responsive adjustments */
@media (max-width: 767px) {
    main { padding: 1rem; }
    .col-md-4 { flex: 0 0 100%; max-width: 100%; } /* stack cards */
}
</style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Desktop Sidebar -->
<nav class="col-md-2 d-none d-md-block sidebar text-white position-fixed" style="top: 0; left: 0; height: 100vh; padding-top: 2rem; background: #121212; box-shadow: 2px 0 10px rgba(0,0,0,0.5);">
    <div class="text-center mb-5">
        <h4><i class="bi bi-speedometer2 me-2"></i>Admin</h4>
    </div>
    <ul class="nav flex-column text-center">
        <li class="nav-item">
            <a class="nav-link active" href="<?= site_url('admin/admin_dashboard') ?>"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('admin/users') ?>"><i class="bi bi-people-fill me-2"></i> Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('admin/posts') ?>"><i class="bi bi-card-text me-2"></i> Posts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('email') ?>"><i class="bi bi-envelope-fill me-2"></i> Email</a>
        </li>
        <li class="nav-item mt-5">
            <a class="btn btn-outline-light btn-logout w-75" href="<?= site_url('auth/logout') ?>">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>
    </ul>
</nav>


    
        <!-- Mobile Sidebar -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header" style="background: #121212; color: white;">
            <h5 class="offcanvas-title"><i class="bi bi-speedometer2 me-2"></i>Admin</h5>
            <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0" style="background: #121212;">
            <ul class="nav flex-column text-center">
                <li class="nav-item"><a class="nav-link text-white" href="#">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="<?= site_url('admin/users') ?>">Users</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="<?= site_url('admin/posts') ?>">Posts</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="<?= site_url('email') ?>">Email</a></li>
                <li class="nav-item mt-3">
                    <a class="btn btn-outline-light w-100" href="<?= site_url('auth/logout') ?>">Logout</a>
                </li>
            </ul>
        </div>
    </div>


        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-4">
            <!-- Mobile Toggle Button -->
            <button class="btn btn-dark d-md-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list"></i> Menu
            </button>

            <section class="hero-section">
                <h1><i class="bi bi-speedometer2 me-2"></i>Welcome, Admin</h1>
                <p>Monitor and manage the flood prediction platform.</p>
            </section>

            <section class="featured-section">
                <div class="container">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <a href="<?= site_url('admin/users') ?>" class="text-decoration-none">
                                <div class="custom-block">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div><h5><i class="bi bi-people-fill me-2"></i>Users</h5><p>Manage user accounts and access rights.</p></div>
                                        <span class="badge bg-primary-badge"><?= $userCount ?? 0 ?></span>
                                    </div>
                        
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= site_url('admin/posts') ?>" class="text-decoration-none">
                                <div class="custom-block">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div><h5><i class="bi bi-card-text me-2"></i>Posts</h5><p>Review and moderate news feed posts.</p></div>
                                        <span class="badge bg-secondary-badge"><?= $postCount ?? 0 ?></span>
                                    </div>
                                    
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= site_url('email') ?>" class="text-decoration-none">
                                <div class="custom-block">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div><h5><i class="bi bi-envelope-fill me-2"></i>Notify</h5><p>Notify users.</p></div>
                                        <span class="badge bg-primary-badge">Send</span>
                                    </div>
                                    
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
