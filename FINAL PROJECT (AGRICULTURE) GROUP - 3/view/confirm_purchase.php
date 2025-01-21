<?php
$data = include('../controller/confirm_purchase_controller.php');
include('../view/navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Purchase</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../asset/confirm_purchase.js"></script>
</head>
<body>
    <h1>Confirm Your Purchase</h1>
    <p><strong>Crop Name:</strong> <?php echo htmlspecialchars($data['crop_name']); ?></p>
    <p><strong>Quantity:</strong> <?php echo htmlspecialchars($data['quantity']); ?> kg</p>
    <p><strong>Total Price:</strong> $<?php echo htmlspecialchars(number_format((float)$data['total_price'], 2)); ?></p>

    <!-- Payment options form -->
    <form id="paymentForm">
        <label>
            <input type="radio" name="payment_type" value="retail" required> Retail Bank
        </label>
        <br>
        <label>
            <input type="radio" name="payment_type" value="mobile" required> Mobile Bank
        </label>
        <br>
        <button type="submit">Proceed to Payment</button>
    </form>

    <div id="responseMessage" style="margin-top: 20px; color: red;"></div>
</body>
</html>
