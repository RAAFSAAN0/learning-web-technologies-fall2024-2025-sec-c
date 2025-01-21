<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $crop_id = $_POST['crop_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    $total_price = $_POST['total_price'] ?? null;

    if (!$crop_id || !$quantity || !$total_price)
    
    {
        die("Error: Missing or invalid purchase details.");
    }

   
    $crop_name = fetchCropNameById($crop_id);

    if (!$crop_name) {
        die("Error: Crop not found.");
    }

   
    $_SESSION['purchase'] = [
        'crop_id' => $crop_id,
        'quantity' => $quantity,
        'total_price' => $total_price,
        'crop_name' => $crop_name, 
    ];

    header('Location: ../view/confirm_purchase.php');
    exit;
}
?>
