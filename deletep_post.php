<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming $_POST['post_id'] is set and sanitized elsewhere in your code
    $post_id = $_POST['post_id'];
    
    // Load existing posts
    $posts = json_decode(file_get_contents('posts.json'), true);
    
    // Check if post exists
    if (isset($posts[$post_id])) {
        // Remove the post
        unset($posts[$post_id]);
        
        // Save updated posts back to JSON file
        file_put_contents('posts.json', json_encode($posts));
        
        // Redirect back to edit_promotions.php after deletion
        header('Location: edit_promotions.php');
        exit;
    } else {
        // Handle case where post doesn't exist
        echo 'Post not found.';
        // You might consider adding a link or button to go back to edit_promotions.php
        // or handle this scenario as per your application flow.
    }
} else {
    // Redirect if accessed directly without POST method
    header('Location: edit_promotions.php');
    exit;
}
?>
