<?php
session_start();
require_once('../model/database.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'You must be logged in to add items to the cart.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$crop_id = isset($_POST['crop_id']) ? intval($_POST['crop_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;


$response = addToCart($user_id, $crop_id, $quantity);

if ($response['success']) {
    echo json_encode(['success' => 'Item added to cart successfully!']);
} else {
    echo json_encode(['error' => 'Unable to add item to cart. Please try again.']);
}
?>
