<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/darkheader.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/Logo.css'); ?>">

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            justify-content: center;
            align-items: flex-start;
            font-family: 'Montserrat', sans-serif;
            color: black;
        }

        .edit-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            border: 1px solid rgba(0,0,0,0.1);
            margin: 30px auto;
            max-width: 800px;
            width: 90%;
        }

        label {
            font-weight: 600;
            font-size: 14px;
            color: #000;
        }

        input[type="text"],
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            margin-top: 6px;
            border: 1px solid #bbb;
            border-radius: 8px;
            font-size: 14px;
            color: #000;
            background: #fdfdfd;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #2a9d8f;
            outline: none;
            box-shadow: 0 0 4px rgba(42,157,143,0.4);
        }

        textarea {
            resize: vertical;
        }

        .btn-submit {
            background: #2a9d8f;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            transition: 0.2s ease-in-out;
        }

        .btn-submit:hover {
            background: #21867a;
        }

        /* BACK BUTTON – inside card */
        .btn-back {
            background: #1d3557;
            color: #fff !important;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            transition: 0.2s ease-in-out;
        }

        .btn-back:hover {
            background: #457b9d;
        }

        /* Flex row for buttons */
        .btn-row {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
        }

        /* TOP BAR (title centered) */
        .top-bar {
            text-align: center;
            padding: 20px;
        }

        .top-bar h2 {
            margin: 0 auto;
            font-size: 24px;
            color: #fff;
        }
    </style>
</head>

<header>
    <a href="<?= site_url('/admin/admin_dashboard') ?>" class="logo">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke-width="3">
            <path d="M20 40a12 12 0 0 1 0-24 14 14 0 0 1 28 4h2a10 10 0 0 1 0 20H20z" fill="none"/>
            <line x1="24" y1="44" x2="20" y2="54"/>
            <line x1="32" y1="44" x2="28" y2="54"/>
            <line x1="40" y1="44" x2="36" y2="54"/>
            <path d="M16 58q4 4 8 0t8 0 8 0 8 0" fill="none"/>
        </svg>

        <div class="divider"></div>
        <div class="logo-text">Admin Dashboard</div>
    </a>

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

    <!-- Centered Title -->
    <div class="top-bar">
        <h2>Edit Post</h2>
    </div>

    <div class="container">

        <!-- EDIT CARD -->
        <div class="edit-card">
            <form method="post" action="<?= site_url('admin/update/' . $post['id']) ?>">

                <label>Name</label>
                <input type="text" name="author_name" value="<?= esc($post['author_name']) ?>" required>

                <br><br>

                <label>Title</label>
                <input type="text" name="title" value="<?= esc($post['title']) ?>" required>

                <br><br>

                <label>Content</label>
                <textarea name="content" rows="6" required><?= esc($post['content']) ?></textarea>

                <!-- BUTTON ROW -->
                <div class="btn-row">
                    <a href="<?= site_url('admin/posts') ?>" class="btn-back">Back</a>
                    <button type="submit" class="btn-submit">Update Post</button>
                </div>

            </form>
        </div>

    </div>

</body>
</html>
