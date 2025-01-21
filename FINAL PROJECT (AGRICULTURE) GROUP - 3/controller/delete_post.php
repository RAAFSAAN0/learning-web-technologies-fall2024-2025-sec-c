<?php
require '../model/database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];

    $conn = getConnection();
    
    $sql = "SELECT image_path FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) 
    
    {
        $row = $result->fetch_assoc();
        $imagePath = '../' . $row['image_path'];

        $deleteSql = "DELETE FROM posts WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $postId);

        if ($deleteStmt->execute()) 
        
        
        {
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $response['success'] = true;
            $response['message'] = 'Post deleted successfully.';
        } else {
            $response['message'] = 'Failed to delete the post.';
        }

        $deleteStmt->close();
    } else 
    
    
    {
        $response['message'] = 'Post not found.';
    }

    $stmt->close();
    $conn->close();
} else {
    $response['message'] = 'Invalid request method.';
}

header('Content-Type: application/json');
echo json_encode($response);
