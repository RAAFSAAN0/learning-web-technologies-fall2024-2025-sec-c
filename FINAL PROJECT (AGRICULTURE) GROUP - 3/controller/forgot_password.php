<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $recent_password = $_POST['recent_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    $consumerData = fetchConsumerByEmail($email);
    if ($consumerData)
    
    
    {
        if ($recent_password === $consumerData['password']) 
        
        
        
        {
            if ($new_password === $confirm_new_password) {
                $conn = getConnection();
                $sql = "UPDATE Consumer SET password = ? WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $new_password, $email);

                if ($stmt->execute()) {
                    echo "Password has been updated successfully.";
                } else {
                    echo "Error updating password.";
                }

                $stmt->close();
                $conn->close();
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
?>
