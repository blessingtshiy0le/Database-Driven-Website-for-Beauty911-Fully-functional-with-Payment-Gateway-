<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    
    // Load existing posts
    $posts = json_decode(file_get_contents('posts.json'), true);
    
    // Check if post exists
    if (isset($posts[$post_id])) {
        // Remove the post
        unset($posts[$post_id]);
        
        // Save updated posts back to JSON file
        file_put_contents('posts.json', json_encode($posts, JSON_PRETTY_PRINT));
        
        // Redirect back to add_post.php after deletion
        header('Location: add_post.php');
        exit;
    } else {
        // Handle case where post doesn't exist
        echo 'Post not found.';
    }
} else {
    // Redirect if accessed directly without POST method
    header('Location: add_post.php');
    exit;
}
?>
