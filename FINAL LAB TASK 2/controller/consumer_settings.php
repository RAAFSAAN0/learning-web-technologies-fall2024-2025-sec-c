<?php
session_start();
require_once('../model/database.php'); 
include('../view/navbar.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loggedInEmail = $_SESSION['email'];

   
    $email = $_POST['email'];
    $recent_password = $_POST['recent_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if ($email !== $loggedInEmail) {
        echo "Incorrect email. You can only change the password for the logged-in account.";
    } else {
        $consumerData = fetchConsumerByEmail($email); // Assuming this function fetches consumer data by email
        if ($consumerData) {
            if ($recent_password === $consumerData['password']) {
                if ($new_password === $confirm_new_password) {
                    if (updatePassword($email, $new_password)) {
                        echo "Password has been updated successfully.";
                    } else {
                        echo "Error updating password.";
                    }
                } else {
                    echo "New passwords do not match.";
                }
            } else {
                echo "Recent password is incorrect.";
            }
        } else {
            echo "No account found with that email.";
        }
    }
}
?>
