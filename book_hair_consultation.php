<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beauty Blog</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #ff6f61;
            color: #fff;
            padding: 1em 0;
            text-align: center;
        }

        header .logo {
            font-size: 2em;
            font-weight: bold;
        }

        header nav ul {
            list-style: none;
            padding: 0;
        }

        header nav ul li {
            display: inline;
            margin: 0 10px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2em;
        }

        .blog-post {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 1em 0;
            max-width: 800px;
            padding: 1em;
            width: 100%;
        }

        .blog-post img {
            border-radius: 5px;
            max-width: 100%;
            height: auto;
        }

        .blog-post h2 {
            color: #ff6f61;
            margin-top: 0.5em;
        }

        .blog-post p {
            color: #333;
            line-height: 1.6;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Beauty Blog</div>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        $posts = json_decode(file_get_contents('posts.json'), true);
        foreach ($posts as $post) {
            echo '<section class="blog-post">';
            echo '<img src="' . $post['image'] . '" alt="' . $post['title'] . '">';
            echo '<h2>' . $post['title'] . '</h2>';
            echo '<p>' . $post['content'] . '</p>';
            echo '</section>';
        }
        ?>
    </main>
    <footer>
        <p>&copy; 2024 Beauty Blog. All rights reserved.</p>
    </footer>
</body>
</html>
