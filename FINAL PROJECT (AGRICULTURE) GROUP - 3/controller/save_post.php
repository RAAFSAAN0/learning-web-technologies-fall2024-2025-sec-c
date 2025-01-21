<?php
require '../model/database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $imageName = time() . '_' . basename($image['name']);
        $uploadDir = '../asset/images/';
        $uploadPath = $uploadDir . $imageName;

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            $imagePath = 'asset/images/' . $imageName;

            // Save to database
            $conn = getConnection();
            $sql = "INSERT INTO posts (title, description, image_path) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $title, $description, $imagePath);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Post uploaded successfully!';
            } else {
                $response['message'] = 'Failed to save post to database.';
            }
            $stmt->close();
            $conn->close();
        } else {
            $response['message'] = 'Failed to upload image.';
        }
    } else {
        $response['message'] = 'Image upload error.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

header('Content-Type: application/json');
echo json_encode($response);
