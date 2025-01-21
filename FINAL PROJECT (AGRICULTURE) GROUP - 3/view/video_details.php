<?php
session_start();
require_once('../model/database.php'); // Assuming this file contains necessary database functions

include('../view/navbar.php');
if (!isset($_SESSION['video_id'])) {
    die("No video selected!");
}

$videoId = $_SESSION['video_id'];

// Fetch video details
$video = fetchVideoDetails($videoId);
if (!$video) {
    die("Video not found!");
}

// Fetch comments
$comments = fetchVideoComments($videoId);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Details</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../asset/video_comment.js"></script>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color:rgb(255, 241, 241);
        color: #333;
        line-height: 1.6;
    }

    h2, h4 {
        text-align: center;
        color: #444;
    }

    h3
    {
        text-align: left;
        padding: 5px 15px;
    }

    video {
        display: block;
        margin: 20px auto;
        border: 2px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    p {
        padding: 5px 15px;
    }

    form {
        width: 80%;
        margin: 0 auto 20px;
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    textarea {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    button {
        background-color: #007BFF;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #0056b3;
    }
    #comments-list {
        width: 80%;
        margin: 20px auto;
        background-color: #fff;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .comment-item {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }
    .comment-item:last-child {
        border-bottom: none;
    }

    .comment-item p {
        margin: 5px 0;
    }

    a {
        color: #007BFF;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    hr {
        border: none;
        border-top: 1px solid #ddd;
        margin: 20px auto;
        width: 80%;
    }
</style>

<body>
    <h2>Video Details</h2>

    <!-- Video Information -->
    <h3><?php echo htmlspecialchars($video['title']); ?></h3>
    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($video['description'])); ?></p>
    <p><strong>Uploaded by:</strong> <?php echo ($video['first_name']) . ' ' . ($video['last_name']); ?></p>
    <p><strong>Upload Date:</strong> <?php echo date("F j, Y, g:i a", strtotime($video['upload_date'])); ?></p>

    <!-- Video Preview -->
    <video width="640" height="360" controls>
        <source src="<?php echo htmlspecialchars('http://localhost/NEW/merged/asset/videos/' . basename($video['video_path'])); ?>" type="video/mp4">
    </video>

    <hr>

    <!-- Comments Section -->
    <h4>Add a Comment</h4>
    <?php if (isset($_SESSION['email'])): ?>
        <form id="comment-form" method="POST" action="#">
            <textarea name="comment_text" rows="4" cols="50" required placeholder="Write your comment here..."></textarea><br>
            <button type="submit" name="submit_comment">Submit Comment</button>
        </form>

        <h4>Comments</h4>
        <div id="comments-list">
            <?php while ($comment = $comments->fetch_assoc()): ?>
                <div class="comment-item" style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
                    <p><strong><?php echo htmlspecialchars($comment['first_name']) . ' ' . htmlspecialchars($comment['last_name']); ?>:</strong> <?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                    <p><small>Posted on: <?php echo date("F j, Y, g:i a", strtotime($comment['comment_date'])); ?></small></p>
                </div>
            <?php endwhile; ?>
        </div>

    <?php else: ?>
        <p><a href="login.html">Login</a> to leave a comment.</p>
    <?php endif; ?>

</body>
</html>
