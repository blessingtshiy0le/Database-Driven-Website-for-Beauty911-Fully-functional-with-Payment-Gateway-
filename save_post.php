<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = $_POST['date']; // Added to capture date
    $author = $_POST['author']; // Added to capture author

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    } else {
        echo "No file was uploaded or there was an error.";
        exit;
    }

    // Prepare post data
    $new_post = [
        'title' => $title,
        'image' => $image,
        'content' => $content,
        'date' => $date, // Include date
        'author' => $author // Include author
    ];

    // Load existing posts
    $posts = json_decode(file_get_contents('posts.json'), true);

    // Append new post to posts array
    $posts[] = $new_post;

    // Save updated posts array back to JSON file
    file_put_contents('posts.json', json_encode($posts, JSON_PRETTY_PRINT));

    // Redirect to add_post.php after successful post addition
    header('Location: add_post.php');
    exit;
}
?>
