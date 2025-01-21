<?php
session_start();
header('Content-Type: application/json');
require '../model/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $email = $_SESSION['email'] ?? ''; // Assuming email is stored in the session
    $target_dir = "../asset/videos/";

    if (!$title || !$description || !$email) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    // Ensure the upload directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file = $_FILES['video'] ?? null;
    if (!$file) {
        echo json_encode(['success' => false, 'message' => 'No video file uploaded.']);
        exit();
    }

    $file_name = basename($file['name']);
    $target_file = $target_dir . time() . "_" . $file_name;

    // Check file size (limit to 100MB)
    if ($file['size'] > 100 * 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'File size exceeds 100MB limit.']);
        exit();
    }

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        $conn = getConnection();
        $sql = "INSERT INTO video (email, title, description, video_path, upload_date) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $email, $title, $description, $target_file);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Video uploaded successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading the file.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
