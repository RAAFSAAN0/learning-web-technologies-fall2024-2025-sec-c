<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');

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

// Initialize response data
$response = [
    'error_message' => '',
    'crop_id' => '',
    'quantity' => '',
    'total_price' => 0
];

// Get purchase details from POST
if (isset($_POST['crop_id'], $_POST['quantity'], $_POST['total_price'], $_POST['bank_account'])) {
    $crop_id = $_POST['crop_id'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $bank_account = $_POST['bank_account'];

    // Validate bank account number
    if (!preg_match("/^\d{8,}$/", $bank_account)) {
        $response['error_message'] = "Bank account number must be at least 8 digits.";
    }

    // Proceed if no error message is set
    if (!$response['error_message']) {
        // Get logged-in user details
        $user_id = $_SESSION['user_id'];

        // Fetch the user's account balance
        $stmt = $conn->prepare("SELECT balance FROM consumer_account WHERE consumer_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $account = $result->fetch_assoc();
        $balance = $account['balance'];

        // Check if the user has sufficient funds
        if ($balance < $total_price) {
            $response['error_message'] = "Insufficient funds. Please check your balance.";
        }

        // Proceed with payment if no error
        if (!$response['error_message']) {
            $payment_type = "Retail Banking"; // Update to match the enum value

            // Insert purchase details
            $stmt = $conn->prepare("INSERT INTO consumer_purchase (user_id, crop_id, amount_bought, purchase_date, transaction_type) VALUES (?, ?, ?, NOW(), ?)");
            $stmt->bind_param("iiis", $user_id, $crop_id, $total_price, $payment_type); // Bind total_price instead of quantity

            if ($stmt->execute()) {
                // Deduct the amount from the user's balance
                $stmt = $conn->prepare("UPDATE consumer_account SET balance = balance - ? WHERE consumer_id = ?");
                $stmt->bind_param("di", $total_price, $user_id);
                if ($stmt->execute()) {
                    // Redirect on successful payment
                    header('Location: payment_success.php');
                    exit;
                } else {
                    $response['error_message'] = "Error: Failed to update account balance.";
                }
            } else {
                $response['error_message'] = "Error: Failed to insert purchase details.";
            }
        }
    }
}

// Populate response data for view
$response['crop_id'] = $crop_id;
$response['quantity'] = $quantity;
$response['total_price'] = $total_price;

// Close connection
$conn->close();

return $response;
?>
