<?php

session_start();
require_once('../model/database.php'); // Assuming this file contains necessary database functions

include('../view/navbar.php');
if (!isset($_SESSION['video_id'])) {
    die("No video selected!");
}

$videoId = $_SESSION['video_id'];
$conn = getConnection();

// Fetch video details
$sql = "SELECT v.id, v.title, v.description, v.video_path, v.upload_date, v.likes, v.dislikes, f.first_name, f.last_name 
        FROM video v
        JOIN farmer f ON v.email = f.email
        WHERE v.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $videoId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Video not found!");
}

$video = $result->fetch_assoc();

// Fetch comments
$sql_comments = "SELECT c.comment_text, c.comment_date, u.first_name, u.last_name 
                 FROM video_comments c
                 JOIN consumer u ON c.user_id = u.id
                 WHERE c.video_id = ?
                 ORDER BY c.comment_date DESC";
$stmt_comments = $conn->prepare($sql_comments);
$stmt_comments->bind_param("i", $videoId);
$stmt_comments->execute();
$comments = $stmt_comments->get_result();

// Handle like action
if (isset($_POST['like'])) {
    $sql_like = "UPDATE video SET likes = likes + 1 WHERE id = ?";
    $stmt_like = $conn->prepare($sql_like);
    $stmt_like->bind_param("i", $videoId);
    $stmt_like->execute();
    header("Location: video_details.php");
    exit();
}

// Handle dislike action
if (isset($_POST['dislike'])) {
    $sql_dislike = "UPDATE video SET dislikes = dislikes + 1 WHERE id = ?";
    $stmt_dislike = $conn->prepare($sql_dislike);
    $stmt_dislike->bind_param("i", $videoId);
    $stmt_dislike->execute();
    header("Location: video_details.php");
    exit();
}

// Handle comment submission
if (isset($_POST['submit_comment']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $commentText = $_POST['comment_text'];
    $userType = $_SESSION['role']; 

    $sql_insert_comment = "INSERT INTO video_comments (video_id, user_id, user_type, comment_text) 
                           VALUES (?, ?, ?, ?)";
    $stmt_insert_comment = $conn->prepare($sql_insert_comment);
    $stmt_insert_comment->bind_param("iiss", $videoId, $userId, $userType, $commentText);
    $stmt_insert_comment->execute();
    $stmt_insert_comment->close();

    header("Location: video_details.php");
    exit();
}

$conn->close();

