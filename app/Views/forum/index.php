<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forum</title>
   <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
  <!-- <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-icon.css'); ?>"> -->
  <link rel="stylesheet" href="<?= base_url('assets/css/newsfeed.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/Logo.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/header.css'); ?>">
</head>
<body>
<header>
  <a href="<?= site_url('home') ?>" class="logo">
                       
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke-width="3">
                       
    <path d="M20 40a12 12 0 0 1 0-24 14 14 0 0 1 28 4h2a10 10 0 0 1 0 20H20z" fill="none"/>
                      
    <line x1="24" y1="44" x2="20" y2="54"/>
    <line x1="32" y1="44" x2="28" y2="54"/>
    <line x1="40" y1="44" x2="36" y2="54"/>
                       
    <path d="M16 58q4 4 8 0t8 0 8 0 8 0" fill="none"/>
    </svg>

    <div class="divider"></div>

    <div class="logo-text">AlertoMarikeno</div>
  </a>
    <div class="nav-links">
      <?php if (session()->get('logged_in')): ?>
        <span>
          Logged in as <a href="#" onclick="openProfileModal()" style="text-decoration: none; color: inherit;"><strong><?= esc(session()->get('username')) ?></strong></a> |
          <a href="<?= site_url('auth/logout') ?>" class="logout-link">Logout</a>
        </span>
      <?php endif; ?>
    </div>
</header>

  <div class="container">
    <div class="top-bar">
      <h2>Latest Posts</h2>
      <div>
        <?php if (session()->get('logged_in')): ?>
          <a href="<?= site_url('forum/create') ?>" class="btn">+ New Post</a>
        <?php else: ?>
          <a href="<?= site_url('auth/uslogin') ?>" class="btn">Login to Post</a>
        <?php endif; ?>
      </div>
    </div>

    <?php foreach ($posts as $post): ?>
      <div class="post-card">
        <div class="post-header">
          <div class="author-info">
            <strong><?= esc($post['author_name']) ?></strong>
            <span><?= $post['created_at'] ?></span>
          </div>
        </div>

        <div class="post-title"><?= esc($post['title']) ?></div>
        <div class="post-content"><?= $post['content'] ?></div>
        <?php if (!empty($post['image'])): ?>
          <div class="post-image">
            <img src="<?= base_url('uploads/' . esc($post['image'])) ?>" alt="Post Image" style="max-width: 100%; height: auto;">
          </div>
        <?php endif; ?>

        <div class="post-actions">
          <?php if (session()->get('logged_in') && session()->get('username') === $post['author_name']): ?>
            <a href="<?= site_url('forum/edit/' . $post['id']) ?>">Edit</a>
          <?php endif; ?>
          <a href="#">Like</a> | <a href="#">Comment</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Profile Modal -->
  <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?= site_url('auth/updateProfile') ?>" method="post">
          <div class="modal-body">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" value="<?= esc(session()->get('username')) ?>" required>
            </div>
            <div class="mb-3">
              <label for="new_password" class="form-label">New Password (leave blank to keep current)</label>
              <input type="password" class="form-control" id="new_password" name="new_password">
            </div>
            <div class="mb-3">
              <label for="confirm_password" class="form-label">Confirm New Password</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            </div>
            <div class="mb-3">
              <label class="form-label">Alert Email Enabled</label><br>
              <input type="radio" id="email_yes" name="alert_email_enabled" value="1" <?= session()->get('alert_email_enabled') ? 'checked' : '' ?>> <label for="email_yes">Yes</label>
              <input type="radio" id="email_no" name="alert_email_enabled" value="0" <?= !session()->get('alert_email_enabled') ? 'checked' : '' ?>> <label for="email_no">No</label>
            </div>
            <div class="mb-3">
              <label class="form-label">Alert Min Probability</label><br>
              <input type="radio" id="prob_50" name="alert_min_probability" value="50" <?= session()->get('alert_min_probability') == 50 ? 'checked' : '' ?>> <label for="prob_50">50</label>
              <input type="radio" id="prob_70" name="alert_min_probability" value="70" <?= session()->get('alert_min_probability') == 70 ? 'checked' : '' ?>> <label for="prob_70">70</label>
              <input type="radio" id="prob_100" name="alert_min_probability" value="100" <?= session()->get('alert_min_probability') == 100 ? 'checked' : '' ?>> <label for="prob_100">100</label>
            </div>
            <div class="mb-3">
              <label for="current_password" class="form-label">Current Password (required to confirm changes)</label>
              <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Confirm</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="<?= base_url('assets/javascript/bootstrap.bundle.min.js'); ?>"></script>
  <script>
    function openProfileModal() {
      var myModal = new bootstrap.Modal(document.getElementById('profileModal'));
      myModal.show();
    }
  </script>

</body>
</html>
