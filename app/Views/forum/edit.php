<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
<link rel="stylesheet" href="<?= base_url('assets/css/create.css'); ?>">
</head>
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
