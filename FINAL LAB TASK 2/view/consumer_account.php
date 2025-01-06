<?php
session_start();
require_once('../model/database.php');

include('navbar.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Consumer') {
    echo "Please log in to view your account.";
    exit;
}

$consumer_id = $_SESSION['user_id']; // Use the general user_id for Consumers

// Database connection
$conn = mysqli_connect('127.0.0.1', 'root', '', 'agriculture');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the account exists
$sql = "SELECT balance FROM consumer_account WHERE consumer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $consumer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $balance = $row['balance'];
} else {
    $balance = 0; // Default balance if no account exists
}

$stmt->close();

// Handle Deposit Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deposit_amount = floatval($_POST['deposit_amount']);
    if ($deposit_amount > 0) {
        // Check if an account already exists
        $account_check_sql = "SELECT * FROM consumer_account WHERE consumer_id = ?";
        $account_check_stmt = $conn->prepare($account_check_sql);
        $account_check_stmt->bind_param("i", $consumer_id);
        $account_check_stmt->execute();
        $account_exists = $account_check_stmt->get_result()->num_rows > 0;
        $account_check_stmt->close();

        if ($account_exists) {
            // Update existing account balance
            $update_sql = "UPDATE consumer_account SET balance = balance + ? WHERE consumer_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("di", $deposit_amount, $consumer_id);
            $update_stmt->execute();
            $update_stmt->close();
        } else {
            // Create a new account with the deposited amount
            $insert_sql = "INSERT INTO consumer_account (consumer_id, balance) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("id", $consumer_id, $deposit_amount);
            $insert_stmt->execute();
            $insert_stmt->close();
        }

        $balance += $deposit_amount; // Update balance locally
        echo "Amount deposited successfully.";
    } else {
        echo "Invalid deposit amount.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Balance</title>
</head>
<body>
    <h1>Account Balance</h1>
    <p><strong>Current Balance:</strong> $<?php echo number_format($balance, 2); ?></p>

    <h2>Deposit Amount</h2>
    <form method="POST">
        <label for="deposit_amount">Amount:</label>
        <input type="number" name="deposit_amount" id="deposit_amount" min="0.01" step="0.01" required>
        <button type="submit">Deposit</button>
    </form>
</body>
</html>
