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
<nav class="col-md-2 d-none d-md-block sidebar text-white">
    <div class="text-center mb-5">
        <h4><i class="bi bi-speedometer2 me-2"></i>Admin</h4>
    </div>
    <ul class="nav flex-column text-center">
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('admin/admin_dashboard') ?>"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('admin/users') ?>"><i class="bi bi-people-fill me-2"></i> Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url('admin/posts') ?>"><i class="bi bi-card-text me-2"></i> Posts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="<?= site_url('email') ?>"><i class="bi bi-envelope-fill me-2"></i> Email</a>
        </li>
        <li class="nav-item mt-5">
            <a class="btn btn-outline-light w-75 btn-logout" href="<?= site_url('auth/logout') ?>">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>
    </ul>
</nav>

<!-- CSS for the Sidebar -->
<style>
.sidebar {
    background: #0a1015; /* dark sidebar */
    color: white;
    height: 100vh;
    padding-top: 2rem;
    box-shadow: 2px 0 10px rgba(0,0,0,0.5);
}

.sidebar h4 {
    font-weight: 600;
}

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

.nav-link i {
    font-size: 1.2rem;
}

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
</style>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-4">
            <section class="hero-section">
                <h1><i class="bi bi-envelope-fill me-2"></i>Email Users</h1>
                <p>Send emails to users from the admin panel.</p>
            </section>

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('sms_queued')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('sms_queued') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('alert_results')): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var alertModal = new bootstrap.Modal(document.getElementById('alertResultsModal'));
                        alertModal.show();
                    });
                </script>
            <?php endif; ?>

            <?php if (session()->getFlashdata('sms_alert_results')): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var smsAlertModal = new bootstrap.Modal(document.getElementById('smsAlertResultsModal'));
                        smsAlertModal.show();
                    });
                </script>
            <?php endif; ?>

            <section class="featured-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
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

                                <div class="col-md-6">
                                    <div class="custom-block">
                                        <h5><i class="bi bi-exclamation-triangle-fill me-2"></i>Send Water Level Alert</h5>
                                        <p>Send a manual water level alert to users with email alerts enabled, regardless of current water levels.</p>
                                        <form action="<?= site_url('email/send-water-alert') ?>" method="post" class="mt-3">
                                            <div class="mb-3">
                                                <label for="alert_level" class="form-label">Alert Level:</label>
                                                <select name="alert_level" class="form-select" required>
                                                    <option value="warning">Warning</option>
                                                    <option value="alert">Alert</option>
                                                    <option value="alarm">Alarm</option>
                                                    <option value="critical">Critical</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="custom_message" class="form-label">Custom Message (Optional):</label>
                                                <textarea id="custom_message" name="custom_message" class="form-control" rows="3" placeholder="Add any additional message..."></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-warning">Send Water Alert</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="custom-block">
                                        <h5><i class="bi bi-chat-dots-fill me-2"></i>Send SMS Water Level Alert</h5>
                                        <p>Send a manual water level alert via SMS to users with SMS alerts enabled.</p>
                                        <form action="<?= site_url('sms/send-water-alert') ?>" method="post" class="mt-3">
                                            <div class="mb-3">
                                                <label for="sms_alert_level" class="form-label">Alert Level:</label>
                                                <select name="alert_level" class="form-select" required>
                                                    <option value="warning">Warning</option>
                                                    <option value="alert">Alert</option>
                                                    <option value="alarm">Alarm</option>
                                                    <option value="critical">Critical</option>
                                                </select>
                                            </div>


                                            <button type="submit" class="btn btn-info">Send SMS Alert</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

<!-- Alert Results Modal -->
<div class="modal fade" id="alertResultsModal" tabindex="-1" aria-labelledby="alertResultsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertResultsModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Water Alert Results</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Manual water level alerts have been sent to users with email notifications enabled.</p>
                <p><strong>Total Sent: <?= session()->getFlashdata('alert_sent_count') ?? 0 ?></strong></p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $results = session()->getFlashdata('alert_results');
                        if ($results):
                            foreach ($results as $row):
                        ?>
                            <tr>
                                <td><?= esc($row['email']) ?></td>
                                <td><?= $row['status'] ?></td>
                            </tr>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- SMS Alert Results Modal -->
<div class="modal fade" id="smsAlertResultsModal" tabindex="-1" aria-labelledby="smsAlertResultsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smsAlertResultsModalLabel"><i class="bi bi-chat-dots-fill me-2"></i>SMS Water Alert Results</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Manual water level alerts have been sent via SMS to users with SMS notifications enabled.</p>
                <p><strong>Total Sent: <?= session()->getFlashdata('sms_alert_sent_count') ?? 0 ?></strong></p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Phone</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $smsResults = session()->getFlashdata('sms_alert_results');
                        if ($smsResults):
                            foreach ($smsResults as $row):
                        ?>
                            <tr>
                                <td><?= esc($row['phone']) ?></td>
                                <td><?= $row['status'] ?></td>
                            </tr>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
