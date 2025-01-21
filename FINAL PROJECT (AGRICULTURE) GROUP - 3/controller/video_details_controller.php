<?php
session_start();
require_once('../model/database.php'); 

if (isset($_POST['submit_comment']) && isset($_SESSION['user_id'])) {
    $videoId = $_SESSION['video_id'];
    $userId = $_SESSION['user_id'];
    $commentText = $_POST['comment_text'];
    $userType = $_SESSION['role'];

    insertComment($videoId, $userId, $userType, $commentText);

    $comment = fetchLatestComment($videoId);

    if ($comment)
    
    
    {
        echo json_encode([ 
            'status' => 'success',
            'comment_text' => htmlspecialchars($comment['comment_text']),
            'comment_date' => date("F j, Y, g:i a", strtotime($comment['comment_date'])),
            'first_name' => htmlspecialchars($comment['first_name']),
            'last_name' => htmlspecialchars($comment['last_name']),
        ]);
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit();
}
?>