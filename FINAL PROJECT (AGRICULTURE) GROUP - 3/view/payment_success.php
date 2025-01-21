<?php
session_start();


//include('../view/navbar.php');


if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'Consumer') {
    header('Location: ../view/login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
</head>
<body>
    <h1>Payment Successful!</h1>
    <p>Your purchase has been successfully processed. Thank you for your order!</p>
    <a href="buy_product.php">Back to Crop List</a>
</body>
</html>
