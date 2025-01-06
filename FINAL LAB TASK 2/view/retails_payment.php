

<?php
$response = include('../controller/retails_payment_controller.php');  // Include the controller to fetch data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Bank Payment</title>
</head>
<body>
    <h1>Retail Bank Payment</h1>

    <?php if (!empty($response['error_message'])) { echo '<p style="color: red;">' . $response['error_message'] . '</p>'; } ?>

    <p><strong>Total Amount:</strong> $<?php echo number_format($response['total_price'], 2); ?></p>

    <form action="retail_payment.php" method="POST">
        <!-- Hidden Fields -->
        <input type="hidden" name="crop_id" value="<?php echo htmlspecialchars($response['crop_id']); ?>">
        <input type="hidden" name="quantity" value="<?php echo htmlspecialchars($response['quantity']); ?>">
        <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($response['total_price']); ?>">

        <label for="bank_account">Bank Account Number (at least 8 digits):</label>
        <input type="text" name="bank_account" pattern="\d{8,}" required minlength="8" maxlength="15" placeholder="Enter bank account number"><br>

        <button type="submit">Confirm Payment</button>
    </form>
</body>
</html>
