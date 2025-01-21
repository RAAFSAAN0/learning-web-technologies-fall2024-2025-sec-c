<?php
session_start();
require_once('../model/database.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in.']);
    exit;
}

$crop_id = isset($_POST['crop_id']) ? intval($_POST['crop_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
$total_price = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;

if ($crop_id > 0 && $quantity > 0 && $total_price > 0) {
    $_SESSION['purchase'] = [
        'crop_id' => $crop_id,
        'quantity' => $quantity,
        'total_price' => $total_price
    ];

    // Send success response
    echo json_encode(['success' => true]);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}
?>
