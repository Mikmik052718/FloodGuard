<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Forum Posts</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/admin/adminfeed.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin/darkheader.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/Logo.css'); ?>">
</head>
<body>
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

  <div class="container">
    <div class="top-bar">
      <h2>Forum Posts</h2>
      <div>
        <a href="<?= site_url('/admin/force-post') ?>" onclick="return confirm('Are you sure you want to create an update post now?')" class="btn" style="background-color: #28a745; margin-left: 10px;">Update Now</a>
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
          <a href="<?= site_url('admin/edit/' . $post['id']) ?>">Edit</a> |
          <a href="<?= site_url('admin/delete/' . $post['id']) ?>" onclick="return confirm('Delete this post?')">Delete</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</body>
</html>
