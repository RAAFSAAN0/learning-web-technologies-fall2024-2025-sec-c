<?php
session_start();
require_once('../model/database.php');

include('navbar.php');

//include('../view/navbar.php');


// Create connection
$conn = mysqli_connect('127.0.0.1', 'root', '', 'agriculture');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
    $payment_type = $purchase['payment_type'];

    // Fetch crop details
    $stmt = $conn->prepare("SELECT crop_name FROM crop WHERE crop_id = ?");
    $stmt->bind_param("i", $crop_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $crop = $result->fetch_assoc();
    $crop_name = $crop['crop_name'];
} else {
    echo "No purchase details found.";
    exit;
}

// Optionally fetch user details (not used currently)
$stmt = $conn->prepare("SELECT email FROM consumer WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_email = $user['email']; // Not used but available if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($payment_type); ?> Payment</title>
</head>
<body>
    <h1><?php echo ucfirst($payment_type); ?> Payment</h1>

    <p><strong>Crop Name:</strong> <?php echo htmlspecialchars($crop_name); ?></p>
    <p><strong>Quantity:</strong> <?php echo htmlspecialchars($quantity); ?> kg</p>
    <p><strong>Total Price:</strong> $<?php echo htmlspecialchars(number_format($total_price, 2)); ?></p>

    <?php if ($payment_type === 'retail'): ?>
        <form action="retails_payment.php" method="POST">
            <!-- Hidden Fields -->
            <input type="hidden" name="crop_id" value="<?php echo htmlspecialchars($crop_id); ?>">
            <input type="hidden" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
            <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($total_price); ?>">

            <label for="bank_account">Bank Account Number (at least 8 digits):</label>
            <input type="text" name="bank_account" pattern="\d{8,}" required minlength="8" maxlength="15" placeholder="Enter bank account number"><br>

            <button type="submit">Confirm Payment</button>
        </form>
    <?php else: ?>
        <!-- Handle other payment methods like Mobile Bank -->
        <p>Mobile Bank Payment coming soon!</p>
    <?php endif; ?>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
