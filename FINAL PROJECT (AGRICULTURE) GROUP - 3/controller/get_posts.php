<?php
require '../model/database.php';

$response = ['success' => false, 'posts' => []];

$conn = getConnection();
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $posts = [];
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    $response['success'] = true;
    $response['posts'] = $posts;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
