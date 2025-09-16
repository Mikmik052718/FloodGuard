<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
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
        <form method="post" action="<?= site_url('forum/store') ?>" class="form-card"> 
           

            <h1>Create a New Post</h1>
            <label>Title:</label>
            <input type="text" name="title" class="input-field" required>

            <label>Content:</label>
            <textarea name="content" rows="5" class="textarea-field" required></textarea>

            <div class="form-actions">
                <button type="submit">Post</button>
                <a href="<?= site_url('forum') ?>" class="btn-cancel">Back to Posts</a>
            </div>
        </form>
    </div>
</body>

</html>
