<?php
session_start();
require_once('../model/database.php');
include('navbar.php');
$crop_name = isset($_SESSION['purchase']['crop_name']) ? $_SESSION['purchase']['crop_name'] : 'Unknown Crop';

// Use $crop_name for displaying on the page


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User is not logged in.";
    exit;
}

// Retrieve purchase details from session
if (isset($_SESSION['purchase'])) {
    $purchase = $_SESSION['purchase'];
    $crop_id = $purchase['crop_id'];
    $quantity = $purchase['quantity'];
    $total_price = $purchase['total_price'];
    $payment_type = "Retail Banking"; // Ensure payment_type is set
    $crop_name = htmlspecialchars($purchase['crop_name']); // Assuming you have crop_name in session
} else {
    echo "No purchase details found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($payment_type); ?> Payment</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../asset/retail_payment.js"></script>
</head>

<style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin-top: 60px;
            padding: 0;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        p {
            margin: 10px 0;
        }
        form {
            background: #fff;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 400px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
<body>
    <h1><?php echo ucfirst($payment_type); ?> Payment</h1>
    <p><strong>Crop Name:</strong> <?php echo htmlspecialchars($crop_name) ?></p>
    <p><strong>Quantity:</strong> <?php echo htmlspecialchars($quantity); ?> kg</p>
    <p><strong>Total Price:</strong> $<?php echo htmlspecialchars(number_format($total_price, 2)); ?></p>

    <form id="paymentForm">
        <input type="hidden" id="crop_id" value="<?php echo htmlspecialchars($crop_id); ?>">
        <input type="hidden" id="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
        <input type="hidden" id="total_price" value="<?php echo htmlspecialchars($total_price); ?>">
        <input type="hidden" id="payment_type" value="<?php echo htmlspecialchars($payment_type); ?>">

        <label for="bank_account">Bank Account Number:</label>
        <input type="text" id="bank_account" name="bank_account" pattern="\d{8,}" minlength="8" maxlength="15" required placeholder="Enter bank account number">
        <button type="submit">Confirm Payment</button>
    </form>
</body>
</html>
