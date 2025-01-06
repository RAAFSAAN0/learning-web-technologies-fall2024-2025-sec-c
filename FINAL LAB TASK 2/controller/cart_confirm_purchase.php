<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate POST data
    $crop_id = $_POST['crop_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    $total_price = $_POST['total_price'] ?? null;

    if (!$crop_id || !$quantity || !$total_price) {
        die("Error: Missing or invalid purchase details.");
    }

    // Fetch crop name from database using the function in database.php
    $crop_name = fetchCropNameById($crop_id);

    if (!$crop_name) {
        die("Error: Crop not found.");
    }

    // Save purchase details in the session
    $_SESSION['purchase'] = [
        'crop_id' => $crop_id,
        'quantity' => $quantity,
        'total_price' => $total_price,
        'crop_name' => $crop_name, // Adding crop name to session data
    ];

    // Redirect to confirm purchase page
    header('Location: ../view/confirm_purchase.php');
    exit;
}
?>
