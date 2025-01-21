<?php
session_start();
require_once('../model/database.php');
include('navbar.php');

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
    $payment_type = "Mobile Banking"; // Ensure payment_type is set

    // Fetch crop details
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'agriculture');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $stmt = $conn->prepare("SELECT crop_name FROM crop WHERE crop_id = ?");
    $stmt->bind_param("i", $crop_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $crop = $result->fetch_assoc();
    $crop_name = $crop['crop_name'] ?? "Unknown";
    $conn->close();
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
    <script src="../asset/mobile_payment.js"></script>

    
</head>
<body>
    <h1><?php echo ucfirst($payment_type); ?> Payment</h1>
    <p><strong>Crop Name:</strong> <?php echo htmlspecialchars($crop_name); ?></p>
    <p><strong>Quantity:</strong> <?php echo htmlspecialchars($quantity); ?> kg</p>
    <p><strong>Total Price:</strong> $<?php echo htmlspecialchars(number_format($total_price, 2)); ?></p>

    <form id="paymentForm">
        <input type="hidden" id="crop_id" value="<?php echo htmlspecialchars($crop_id); ?>">
        <input type="hidden" id="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
        <input type="hidden" id="total_price" value="<?php echo htmlspecialchars($total_price); ?>">
        <input type="hidden" id="payment_type" value="<?php echo htmlspecialchars($payment_type); ?>">

        <label for="bank_account">Mobile Banking Account Number:</label>
        <input type="text" id="bank_account" name="bank_account" pattern="\d{11,}" minlength="8" maxlength="15" required placeholder="Enter mobile baking number">
        <button type="submit">Confirm Payment</button>
    </form>
</body>
</html>
