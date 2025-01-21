<?php
session_start();
require_once('../model/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_text'], $_POST['crop_id'], $_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $reviewText = trim($_POST['review_text']);
    $cropId = intval($_POST['crop_id']);
    $userName = "Anonymous";

    if (empty($reviewText)) 
    
    
    {
        echo json_encode(['success' => false, 'message' => 'Review text cannot be empty.']);
        exit();
    }

    $result = insertCropReview($cropId, $userId, $reviewText);

    if ($result['success']) {
        echo json_encode([
            'success' => true,
            'user_name' => $userName,
            'review_text' => htmlspecialchars($reviewText),
        ]);
    } 
    
    
    else 
    
    
    {
        echo json_encode(['success' => false, 'message' => $result['message']]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid form data.']);
}
?>
