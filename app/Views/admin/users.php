<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - User Management</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/newsfeed.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin/darkheader.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/Logo.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin/usertable.css'); ?>">
</head>
<header>
    <a href="<?= site_url('/admin/admin_dashboard') ?>" class="logo">
                       
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke-width="3">
                       
                        <path d="M20 40a12 12 0 0 1 0-24 14 14 0 0 1 28 4h2a10 10 0 0 1 0 20H20z" fill="none"/>
                      
                        <line x1="24" y1="44" x2="20" y2="54"/>
                        <line x1="32" y1="44" x2="28" y2="54"/>
                        <line x1="40" y1="44" x2="36" y2="54"/>
                       
                        <path d="M16 58q4 4 8 0t8 0 8 0 8 0" fill="none"/>
                        </svg>

                        <div class="divider"></div>

                        <div class="logo-text">Admin Dashboard</div>
                    </a>
    <div class="nav-links">
      <?php if (session()->get('logged_in')): ?>
        <span>
          Logged in as <strong><?= esc(session()->get('username')) ?></strong> | 
          <a href="<?= site_url('auth/logout') ?>" class="logout-link">Logout</a>
        </span>
      <?php endif; ?>
    </div>
  </header>
<body>
  <div class="container">
    <div class="top-bar">
      <h2>User Management</h2>
    </div>

    <div class="table-container">
      <table class="users-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Alert Email</th>
            <th>Alert Min Probability</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= esc($user['id']) ?></td>
              <td><?= esc($user['username']) ?></td>
              <td><?= esc($user['email']) ?></td>
              <td><?= esc($user['role']) ?></td>
              <td><?= date('Y-m-d H:i', strtotime($user['created_at'])) ?></td>
              <td><?= date('Y-m-d H:i', strtotime($user['updated_at'])) ?></td>
              <td class="<?= $user['alert_email_enabled'] ? 'true-value' : 'false-value' ?>">
                <?= $user['alert_email_enabled'] ? 'Enabled' : 'Disabled' ?>
              </td>
              <td><?= $user['alert_min_probability'] ?? 'N/A' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
