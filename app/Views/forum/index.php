<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forum</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/newsfeed.css'); ?>">
</head>
<body>
<header>
    <h1>
      <a href="<?= site_url('/home') ?>" class="site-title">Alerto Marikina</a>
    </h1>
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
      <h2>Latest Posts</h2>
      <a href="<?= site_url('forum/create') ?>" class="btn">+ New Post</a>
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

        <div class="post-actions">
          <?php if (session()->get('logged_in') && session()->get('username') === $post['author_name']): ?>
            <a href="<?= site_url('forum/edit/' . $post['id']) ?>">Edit</a>
          <?php endif; ?>
          <a href="#">Like</a> | <a href="#">Comment</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</body>
</html>
