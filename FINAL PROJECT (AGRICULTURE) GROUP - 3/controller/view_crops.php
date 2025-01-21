<?php
header('Content-Type: application/json');

$conn = new mysqli('127.0.0.1', 'root', '', 'agriculture');

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

$sql = "SELECT id, crop_name, crop_quantity, crop_description, created_at FROM crop_exchange ORDER BY created_at DESC";
$result = $conn->query($sql);

$crops = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $crops[] = $row;
    }
}

$conn->close();


echo json_encode($crops);
?>
