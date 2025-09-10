<!DOCTYPE html>
<html>
<head><title>Admin View</title></head>
<body>
<h1>Admin Panel - Forum Posts</h1>
<p>Welcome, <?= session()->get('username') ?> | <a href="<?= site_url('auth/logout') ?>">Logout</a></p>
<hr>

<?php foreach ($posts as $post): ?>
    <h3><?= esc($post['title']) ?></h3>
    <p><strong><?= esc($post['author_name']) ?></strong> @ <?= $post['created_at'] ?></p>
    <p><?= esc($post['content']) ?></p>
    
    <a href="<?= site_url('admin/edit/' . $post['id']) ?>">Edit</a> | 
    <a href="<?= site_url('admin/delete/' . $post['id']) ?>" onclick="return confirm('Delete this post?')">Delete</a>
    <hr>
<?php endforeach; ?>

</body>
</html>
