<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Ensure purchase details exist in the session
if (isset($_SESSION['purchase'])) {
    $purchase = $_SESSION['purchase'];

    $crop_id = $purchase['crop_id'];
    $quantity = $purchase['quantity'];
    $total_price = $purchase['total_price'];

    // Fetch crop details
    $crop_name = fetchCropName($crop_id);
    if (!$crop_name) {
        echo "Invalid crop details.";
        exit;
    }
} else {
    echo "No purchase details found.";
    exit;
}

// Handle payment selection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['payment_type'])) {
        $payment_type = $_POST['payment_type'];

        // Save payment type in session for the next step
        $_SESSION['purchase']['payment_type'] = $payment_type;

        // Redirect to the payment page
        header('Location: payment.php');
        exit;
    }
}

// Data to send to the view
return [
    'crop_name' => $crop_name,
    'quantity' => $quantity,
    'total_price' => $total_price
];
?>
