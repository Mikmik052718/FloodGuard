<!DOCTYPE html>
<html>
<head><title>Forum</title></head>
<body>

    <h1>Forum Posts</h1>

    <?php if (session()->get('logged_in')): ?>
        <p>
            Logged in as <strong><?= esc(session()->get('username')) ?></strong> | 
            <a href="<?= site_url('auth/logout') ?>">Logout</a>
        </p>
    <?php endif; ?>

    <a href="<?= site_url('forum/create') ?>">Create New Post</a>
    <hr>

    <?php foreach ($posts as $post): ?>
        <h3><?= esc($post['title']) ?></h3>
        <p><strong><?= esc($post['author_name']) ?></strong> @ <?= $post['created_at'] ?></p>
        <p><?= esc($post['content']) ?></p>

        <?php if (session()->get('logged_in') && session()->get('username') === $post['author_name']): ?>
            <a href="<?= site_url('forum/edit/' . $post['id']) ?>">Edit</a>
        <?php endif; ?>

        <hr>
    <?php endforeach; ?>

</body>
</html>
