<?php
session_start();
require_once('../model/database.php');

// Check if the user is logged in and is a Consumer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Consumer') {
    echo "Please log in to view your account.";
    exit;
}

$consumer_id = $_SESSION['user_id']; // Use the general user_id for Consumers

// Get the balance from the database using the function
$balance = getConsumerBalance($consumer_id);

// Handle Deposit Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deposit_amount = floatval($_POST['deposit_amount']);
    
    if ($deposit_amount > 0) {
        // Check if the account already exists
        if (checkConsumerAccountExists($consumer_id)) {
            // Update existing account balance
            updateConsumerBalance($consumer_id, $deposit_amount);
        } else {
            // Create a new account with the deposited amount
            createConsumerAccount($consumer_id, $deposit_amount);
        }

        // Update the balance locally and set the session message
        $balance += $deposit_amount;
        $_SESSION['message'] = "Amount deposited successfully.";
    } else {
        $_SESSION['message'] = "Invalid deposit amount.";
    }
}

// Pass the balance to the view
include('../view/consumer_account_view.php');
?>
