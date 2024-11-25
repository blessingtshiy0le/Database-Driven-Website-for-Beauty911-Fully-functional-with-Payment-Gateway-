<?php
// Load existing posts
$posts = json_decode(file_get_contents('posts.json'), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add and Manage Blog Posts</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fee3ec;
        }

        .container {
            max-width: 800px;
            margin: 2em auto;
            padding: 1em;
            background-color: #fff;
            border: 1px solid #000;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #000;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 0.5em 0 0.2em;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            padding: 0.5em;
            font-size: 1em;
            border: 1px solid #000;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
            border: 1px solid #000;
        }

        input[type="submit"] {
            margin-top: 1em;
            padding: 0.7em;
            font-size: 1em;
            border: 1px solid #000;
            background-color: #fee3ec;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #fee3ec;
            border: 1px solid #000;
        }

        /* Adjust image styling */
        .blog-post img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 1em; /* Add some space between posts */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Blog Post</h1>
        <form action="save_post.php" method="post" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>

            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <label for="content">Content</label>
            <textarea id="content" name="content" rows="10" required></textarea>

            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>

            <label for="author">Author</label>
            <input type="text" id="author" name="author" required>

            <input type="submit" value="Add Post">
        </form>

        <!-- Display existing posts with delete buttons -->
        <?php
        if (!empty($posts)) {
            echo '<hr>';
            echo '<h2>Existing Blog Posts</h2>';
            foreach ($posts as $key => $post) {
                echo '<div class="blog-post">';
                echo '<img src="' . $post['image'] . '" alt="' . $post['title'] . '">';
                echo '<h2>' . $post['title'] . '</h2>';
                echo '<p>' . nl2br($post['content']) . '</p>'; // Preserve line breaks
                // Display date and author
                echo '<p class="blog-meta">Posted on ' . $post['date'] . ' by ' . $post['author'] . '</p>';
                // Delete form
                echo '<form action="delete_post.php" method="post">';
                echo '<input type="hidden" name="post_id" value="' . $key . '">';
                echo '<input type="submit" value="Delete" class="delete-btn">';
                echo '</form>';
                echo '</div>';
            }
        }
        ?>
    </div>
</body>
</html>
