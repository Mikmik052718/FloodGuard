<!DOCTYPE html>
<html>
<head><title>Edit Post</title></head>
<body>
    <h1>Edit Post</h1>
    <form method="post" action="<?= site_url('forum/update/' . $post['id']) ?>">
        <label>Your Name:</label><br>
        <input type="text" name="author_name" value="<?= esc($post['author_name']) ?>" required><br><br>

        <label>Title:</label><br>
        <input type="text" name="title" value="<?= esc($post['title']) ?>" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" rows="5" required><?= esc($post['content']) ?></textarea><br><br>

        <button type="submit">Update</button>
    </form>
    <br>
    <a href="<?= site_url('forum') ?>">Back to Posts</a>
</body>
</html>
