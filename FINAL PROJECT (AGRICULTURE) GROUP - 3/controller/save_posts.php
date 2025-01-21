<?php
session_start();
require_once '../model/database.php';

// Check if the farmer is logged in
if (!isset($_SESSION['email'])) {
    echo "User not logged in";
    exit();
}

$email = $_SESSION['email'];

$title = $_POST['title'];
$description = $_POST['description'];
$image = $_FILES['image'];

// Validate and upload image
$target_dir = "../asset/images/";
$target_file = $target_dir . basename($image['name']);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if the file is an actual image
if (getimagesize($image['tmp_name']) === false) {
    echo "File is not an image.";
    exit();
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    exit();
}

// Check file size
if ($image['size'] > 500000) {
    echo "Sorry, your file is too large.";
    exit();
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
    exit();
}

// Try to upload the file
if (move_uploaded_file($image['tmp_name'], $target_file)) {
    // Insert post into database
    $conn = getConnection();
    $sql = "INSERT INTO posts (title, description, image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $description, $target_file); // Image path is stored
    $stmt->execute();
    $stmt->close();
    echo "The post has been successfully uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}

$conn->close();
?>
