
<?php include('../controller/video_details_controller.php'); ?>
<?//php include('navbar.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Details</title>
</head>
<body>
    <h2>Video Details</h2>

    <!-- Video Information -->
    <h3><?php echo htmlspecialchars($video['title']); ?></h3>
    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($video['description'])); ?></p>
    <p><strong>Uploaded by:</strong> <?php echo htmlspecialchars($video['first_name']) . ' ' . htmlspecialchars($video['last_name']); ?></p>
    <p><strong>Upload Date:</strong> <?php echo date("F j, Y, g:i a", strtotime($video['upload_date'])); ?></p>
    <p><strong>Likes:</strong> <?php echo $video['likes']; ?> | <strong>Dislikes:</strong> <?php echo $video['dislikes']; ?></p>

    <!-- Video Preview -->
    <video width="640" height="360" controls>
        <source src="<?php echo htmlspecialchars('http://localhost/agri20/asset/video/' . basename($video['video_path'])); ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Like / Dislike Buttons -->
    <form method="POST">
        <button type="submit" name="like">Like</button>
        <button type="submit" name="dislike">Dislike</button>
    </form>

    <hr>

    <!-- Comments Section -->
    <h4>Comments</h4>
    <?php if ($comments->num_rows > 0): ?>
        <?php while ($comment = $comments->fetch_assoc()): ?>
            <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
                <p><strong><?php echo htmlspecialchars($comment['first_name']) . ' ' . htmlspecialchars($comment['last_name']); ?>:</strong> <?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                <p><small>Posted on: <?php echo date("F j, Y, g:i a", strtotime($comment['comment_date'])); ?></small></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No comments yet.</p>
    <?php endif; ?>

    <!-- Comment Form -->
    <h4>Add a Comment</h4>
    <?php if (isset($_SESSION['email'])): ?>
        <form method="POST">
            <textarea name="comment_text" rows="4" cols="50" required placeholder="Write your comment here..."></textarea><br>
            <button type="submit" name="submit_comment">Submit Comment</button>
        </form>
    <?php else: ?>
        <p><a href="login.html">Login</a> to leave a comment.</p>
    <?php endif; ?>
</body>
</html>
