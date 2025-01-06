<?php
session_start();
require_once('../model/database.php');  // Assuming this file contains necessary database functions
include('../view/navbar.php');
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "Email and Password cannot be empty!";
    } else {
        // Authenticate user by checking both Consumer and Student tables
        $role = authenticateUser($email, $password);

        if ($role) {
            $_SESSION['email'] = $email;  // Store email in session
            $_SESSION['role'] = $role;  // Store user role in session

            // Fetch user ID based on the role (Consumer or Farmer)
            $userId = getUserIdByEmail($email, $role);
            $_SESSION['user_id'] = $userId;  // Store user ID in session

            // Fetch user first and last name from the database (Consumer table)
            if ($role == "Consumer") {
                // Assuming the `getConsumerNameById` function retrieves first and last name based on the user ID
                $userDetails = getConsumerNameById($userId);

                if ($userDetails) {
                    $_SESSION['first_name'] = $userDetails['first_name'];  // Store first name in session
                    $_SESSION['last_name'] = $userDetails['last_name'];    // Store last name in session
                }
            }

            // Redirect based on user role
            if ($role == "Consumer") {
                header('location: ../view/consumerDashboard.php');
                exit();
            } elseif ($role == "Student") {
                header('location: ../view/studentDashboard.php');  // Redirect to Student Dashboard
                exit();
            } elseif ($role == "Farmer") {
                header('location: ../view/farmer_menu.php');
                exit();
            }
        } else {
            echo "Invalid Email or Password!";
        }
    }
} else {
    header('location: ../view/login.html');
    exit();
}
?>
