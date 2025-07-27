<!DOCTYPE html>
<html>
<head><title>Create Post</title></head>
<body>
    <h1>Create a New Post</h1>

    <form method="post" action="<?= site_url('forum/store') ?>"> 

        <?php if (session()->get('logged_in')): ?>
            <input type="hidden" name="author_name" value="<?= esc(session()->get('username')) ?>">
            <p><strong>Posting as: <?= esc(session()->get('username')) ?></strong></p>
        <?php else: ?>
            <label>Your Name:</label><br>
            <input type="text" name="author_name" required><br><br>
        <?php endif; ?>

        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" rows="5" required></textarea><br><br>

        <button type="submit">Post</button>
    </form>

    <br>
    <a href="<?= site_url('forum') ?>">Back to Posts</a>
</body>
</html>
