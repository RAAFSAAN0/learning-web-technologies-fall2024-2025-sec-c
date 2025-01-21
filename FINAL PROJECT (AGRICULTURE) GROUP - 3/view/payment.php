<?php
session_start();
require_once('../model/database.php');

include('navbar.php');

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
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            height: 10%;
            background-color: #4CAF50;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
       

        .details p {
            font-size: 18px;
            margin: 10px 0;
            line-height: 1.5;
        }

        .details strong {
            color: #333;
        }

        form {
            margin-top: 20px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .payment-message {
            font-size: 18px;
            margin-top: 20px;
            color: #888;
        }
        header h2 {
    margin-top: 50px; /* Adds space above the header to lower it */
}
    </style>
</head>
<body>

<header>
    <h2>Payment Processing</h2>
</header>

<div class="container">
    <h1><?php echo ucfirst($payment_type); ?> Payment</h1>

    <div class="details">
        <p><strong>Crop Name:</strong> <?php echo htmlspecialchars($crop_name); ?></p>
        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($quantity); ?> kg</p>
        <p><strong>Total Price:</strong> $<?php echo htmlspecialchars(number_format($total_price, 2)); ?></p>
    </div>

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
        <p class="payment-message">Mobile Bank Payment coming soon!</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
