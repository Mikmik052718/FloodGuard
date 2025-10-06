<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - User Management</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/newsfeed.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin_dashboard.css'); ?>">
  <style>
    /* Responsive table styles */
    .table-container {
      width: 100%;
      overflow-x: auto;
      margin-top: 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      border-radius: 8px;
    }
    
    .users-table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fff;
    }
    
    .users-table th, 
    .users-table td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #e0e0e0;
    }
    
    .users-table th {
      background-color: #f5f5f5;
      font-weight: bold;
      color: #333;
      position: sticky;
      top: 0;
    }
    
    .users-table tr:hover {
      background-color: #f9f9f9;
    }
    
    .users-table .true-value {
      color: #2ecc71;
      font-weight: bold;
    }
    
    .users-table .false-value {
      color: #e74c3c;
    }
    
    /* Make the table container scrollable vertically with fixed height */
    .table-container {
      max-height: 600px;
      overflow-y: auto;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .container {
        width: 95%;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>
      <a href="<?= site_url('/admin/admin_dashboard') ?>" class="site-title">Admin Dashboard</a>
    </h1>
    <div class="nav-links">
      <span>
        Logged in as <strong><?= esc(session()->get('username')) ?></strong> |
        <a href="<?= site_url('auth/logout') ?>" class="logout-link">Logout</a>
      </span>
    </div>
  </header>

  <div class="container">
    <div class="top-bar">
      <h2>User Management</h2>
      <a href="<?= site_url('/admin/admin_dashboard') ?>" class="btn">Back to Dashboard</a>
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
