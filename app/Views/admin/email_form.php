<!DOCTYPE html>
<html>
<head>
    <title>Email Users</title>
</head>
<body>
    <h2>📧 Send Email</h2>
    <form action="<?= site_url('email/send') ?>" method="post">
        <label>Select User:</label>
        <select name="user_id" required>
            <option value="all">-- Send to All Users --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>"><?= esc($user['username']) ?> (<?= esc($user['email']) ?>)</option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="subject">Subject (Heading):</label><br>
        <input type="text" id="subject" name="subject" required placeholder="Enter email subject" style="width: 300px;">
        <br><br>

        <label for="message">Message:</label><br>
        <textarea id="message" name="message" rows="6" cols="50" required placeholder="Enter your message here"></textarea>
        <br><br>

        <button type="submit">Send Email</button>
    </form>
</body>
</html>
