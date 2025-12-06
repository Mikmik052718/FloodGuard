<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - User Management</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/newsfeed.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin/darkheader.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/Logo.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin/usertable.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
  <style>
    .action-buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
    }
    .btn-edit {
      background-color: #007bff;
      color: white;
      padding: 5px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }
    .btn-edit:hover {
      background-color: #0056b3;
    }
    .btn-delete {
      background-color: #dc3545;
      color: white;
      padding: 5px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }
    .btn-delete:hover {
      background-color: #c82333;
    }
  </style>
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
            <th>Actions</th>
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
              <td>
                <div class="action-buttons">
                  <button class="btn-edit" onclick="openEditModal(<?= $user['id'] ?>)">Edit</button>
                  <button class="btn-delete" onclick="confirmDelete(<?= $user['id'] ?>, '<?= esc($user['username']) ?>')">Delete</button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Edit User Modal -->
  <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editUserForm" method="post">
          <div class="modal-body">
            <input type="hidden" id="edit_user_id" name="user_id">
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="edit_username" class="form-label">Username <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="edit_username" name="username" required>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="edit_password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="edit_password" name="password" placeholder="Leave blank to keep current">
                  <small class="text-muted">Leave blank to keep current password</small>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="edit_email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="edit_email" name="email">
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="edit_phone" class="form-label">Phone</label>
                  <input type="text" class="form-control" id="edit_phone" name="phone" placeholder="+63">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="edit_role" class="form-label">Role</label>
                  <select class="form-control" id="edit_role" name="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                  </select>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="edit_is_active" class="form-label">Account Status</label>
                  <select class="form-control" id="edit_is_active" name="is_active">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>
              </div>
            </div>
            
            <hr>
            <h6>Alert Settings</h6>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Alert Email Enabled</label><br>
                  <input type="radio" id="edit_email_yes" name="alert_email_enabled" value="1"> <label for="edit_email_yes">Yes</label>
                  <input type="radio" id="edit_email_no" name="alert_email_enabled" value="0"> <label for="edit_email_no">No</label>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Alert SMS Enabled</label><br>
                  <input type="radio" id="edit_sms_yes" name="alert_sms_enabled" value="1"> <label for="edit_sms_yes">Yes</label>
                  <input type="radio" id="edit_sms_no" name="alert_sms_enabled" value="0"> <label for="edit_sms_no">No</label>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Alert Min Probability</label><br>
                  <input type="radio" id="edit_prob_50" name="alert_min_probability" value="50"> <label for="edit_prob_50">50</label>
                  <input type="radio" id="edit_prob_70" name="alert_min_probability" value="70"> <label for="edit_prob_70">70</label>
                  <input type="radio" id="edit_prob_100" name="alert_min_probability" value="100"> <label for="edit_prob_100">100</label>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Restrict Alerts to Red Zone</label><br>
                  <input type="radio" id="edit_restrict_yes" name="alert_restrict_to_red" value="1"> <label for="edit_restrict_yes">Yes</label>
                  <input type="radio" id="edit_restrict_no" name="alert_restrict_to_red" value="0"> <label for="edit_restrict_no">No</label>
                </div>
              </div>
            </div>
            
            <hr>
            <h6>Google OAuth Info (Read-only)</h6>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="edit_google_id" class="form-label">Google ID</label>
                  <input type="text" class="form-control" id="edit_google_id" readonly>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="edit_google_name" class="form-label">Google Name</label>
                  <input type="text" class="form-control" id="edit_google_name" readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="<?= base_url('assets/javascript/bootstrap.bundle.min.js'); ?>"></script>
  <script>
    function openEditModal(userId) {
      // Fetch full user data via AJAX
      fetch('<?= site_url('admin/users/get/') ?>' + userId)
        .then(response => response.json())
        .then(user => {
          document.getElementById('edit_user_id').value = user.id;
          document.getElementById('edit_username').value = user.username || '';
          document.getElementById('edit_email').value = user.email || '';
          document.getElementById('edit_phone').value = user.phone || '';
          document.getElementById('edit_role').value = user.role || 'user';
          document.getElementById('edit_is_active').value = user.is_active || 1;
          
          // Clear password field
          document.getElementById('edit_password').value = '';
          
          // Alert Email Enabled
          if (user.alert_email_enabled == 1) {
            document.getElementById('edit_email_yes').checked = true;
          } else {
            document.getElementById('edit_email_no').checked = true;
          }
          
          // Alert SMS Enabled
          if (user.alert_sms_enabled == 1) {
            document.getElementById('edit_sms_yes').checked = true;
          } else {
            document.getElementById('edit_sms_no').checked = true;
          }
          
          // Alert Min Probability
          if (user.alert_min_probability == 50) {
            document.getElementById('edit_prob_50').checked = true;
          } else if (user.alert_min_probability == 70) {
            document.getElementById('edit_prob_70').checked = true;
          } else {
            document.getElementById('edit_prob_100').checked = true;
          }
          
          // Alert Restrict to Red
          if (user.alert_restrict_to_red == 1) {
            document.getElementById('edit_restrict_yes').checked = true;
          } else {
            document.getElementById('edit_restrict_no').checked = true;
          }
          
          // Google OAuth (read-only)
          document.getElementById('edit_google_id').value = user.google_id || '';
          document.getElementById('edit_google_name').value = user.google_name || '';
          
          // Set form action
          document.getElementById('editUserForm').action = '<?= site_url('admin/users/update/') ?>' + user.id;
          
          // Show modal
          var myModal = new bootstrap.Modal(document.getElementById('editUserModal'));
          myModal.show();
        })
        .catch(error => {
          console.error('Error fetching user data:', error);
          alert('Error loading user data. Please try again.');
        });
    }
    
    function confirmDelete(id, username) {
      if (confirm('Are you sure you want to delete user "' + username + '"? This action cannot be undone.')) {
        window.location.href = '<?= site_url('admin/users/delete/') ?>' + id;
      }
    }
  </script>
</body>
</html>
