<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
<link rel="stylesheet" href="<?= base_url('assets/css/addpost.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/Logo.css') ?>" />
<link rel="stylesheet" href="<?= base_url('assets/css/header.css') ?>" />
</head>
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
<body>
    <div class="form-container">
        <form method="post" action="<?= site_url('forum/update/' . $post['id']) ?>" enctype="multipart/form-data" class="form-card">


            <h1>Edit Post</h1>
            <label>Title:</label>
            <input type="text" name="title" value="<?= esc($post['title']) ?>" class="input-field" required>

            <label>Content:</label>
            <textarea name="content" rows="5" class="textarea-field" required><?= esc($post['content']) ?></textarea>

            <label>Current Image:</label>
            <?php if (!empty($post['image'])): ?>
                <div class="current-image">
                    <img src="<?= base_url('uploads/' . esc($post['image'])) ?>" alt="Current Image" style="max-width: 200px; height: auto;">
                </div>
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>

            <label>New Image (optional, replaces current):</label>
            <input type="file" name="image" accept="image/*" class="input-field">

            <div class="form-actions">
                <button type="submit">Update</button>
                <a href="<?= site_url('forum') ?>" class="btn-cancel">Back to Posts</a>
            </div>
        </form>
    </div>
</body>

</html>
