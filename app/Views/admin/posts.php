<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Forum Posts</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/newsfeed.css'); ?>">
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
      <h2>Forum Posts</h2>
      <a href="<?= site_url('/admin/admin_dashboard') ?>" class="btn">Back to Dashboard</a>
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
        <div class="post-content"><?= esc($post['content']) ?></div>
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
