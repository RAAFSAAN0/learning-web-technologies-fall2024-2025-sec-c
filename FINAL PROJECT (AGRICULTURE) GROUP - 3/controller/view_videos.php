<?php
session_start();
require '../model/database.php';

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

$email = $_SESSION['email'];
$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'delete' && isset($_POST['video_id'])) {
        $video_id = intval($_POST['video_id']);
        $sql = "SELECT video_path FROM video WHERE id = ? AND email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $video_id, $email);
        $stmt->execute();
        $stmt->bind_result($video_path);

        if ($stmt->fetch() && file_exists($video_path)) {
            unlink($video_path); // Delete video file
            $stmt->close();

            $delete_sql = "DELETE FROM video WHERE id = ? AND email = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("is", $video_id, $email);
            $delete_stmt->execute();

            echo json_encode(['success' => true, 'message' => 'Video deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Video not found or permission denied.']);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM video WHERE email = ? ORDER BY upload_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $videos = [];
    while ($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }

    echo json_encode(['success' => true, 'videos' => $videos]);
}

$conn->close();
?>
