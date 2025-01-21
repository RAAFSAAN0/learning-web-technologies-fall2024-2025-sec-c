<?php
require_once('../db/connection.php'); 

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];
    $new_quantity = $_POST['new_quantity'];
    $new_available_quantity = $_POST['new_available_quantity'];
    $crop_id = $_POST['crop_id'];

    try {
        $pdo->beginTransaction();

        $updateCartQuery = "UPDATE cart SET quantity = :new_quantity WHERE cart_id = :cart_id";
        $stmt = $pdo->prepare($updateCartQuery);
        $stmt->execute([
            ':new_quantity' => $new_quantity,
            ':cart_id' => $cart_id,
        ]);

        $updateCropQuery = "UPDATE crops SET available_quantity = :new_available_quantity WHERE crop_id = :crop_id";
        $stmt = $pdo->prepare($updateCropQuery);
        $stmt->execute([
            ':new_available_quantity' => $new_available_quantity,
            ':crop_id' => $crop_id,
        ]);

        $pdo->commit();
        $response['success'] = true;
        $response['message'] = 'Cart and available quantity updated successfully.';
    } 
    
    
    
    catch (Exception $e) 
    
    {
        $pdo->rollBack();
        $response['success'] = false;
        $response['message'] = 'Error: ' . $e->getMessage();
    }
}

echo json_encode($response);
