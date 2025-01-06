<?php
session_start();
require_once('../model/database.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get the crop_id, quantity, and total price
$crop_id = isset($_POST['crop_id']) ? intval($_POST['crop_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
$total_price = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;

if ($crop_id > 0 && $quantity > 0 && $total_price > 0) {
    $_SESSION['purchase'] = [
        'crop_id' => $crop_id,
        'quantity' => $quantity,
        'total_price' => $total_price
    ];

    header('Location: confirm_purchase.php');
    exit;
} else {
    echo "Invalid input.";
}
?>
