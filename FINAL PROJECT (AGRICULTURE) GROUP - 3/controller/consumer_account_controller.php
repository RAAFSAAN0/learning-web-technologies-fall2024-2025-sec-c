<?php
session_start();
require_once('../model/database.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Consumer') {
    echo "Please log in to view your account.";
    exit;
}

$consumer_id = $_SESSION['user_id']; 

$balance = getConsumerBalance($consumer_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') 


{
    $deposit_amount = floatval($_POST['deposit_amount']);
    
    if ($deposit_amount > 0) {
        if (checkConsumerAccountExists($consumer_id)) {
            updateConsumerBalance($consumer_id, $deposit_amount);
        } else 
        
        {
            createConsumerAccount($consumer_id, $deposit_amount);
        }

        $balance += $deposit_amount;
        $_SESSION['message'] = "Amount deposited successfully.";
    } else {
        $_SESSION['message'] = "Invalid deposit amount.";
    }
}




include('../view/consumer_account_view.php');
?>
