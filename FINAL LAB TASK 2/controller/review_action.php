<?php
session_start();
include('../view/navbar.php');
require_once('../model/database.php');  // Assuming you have a database connection function

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location:../view/login.html");
    exit();
}

// Check if the form is submitted
if (isset($_POST['review_text']) && isset($_POST['crop_id'])) {
    // Get the form inputs
    $userId = $_SESSION['user_id'];
    $reviewText = $_POST['review_text'];
    $cropId = $_POST['crop_id'];
    $userType = $_SESSION['role'];  // Assuming role is stored in session (Consumer, Farmer, etc.)

    // Create a connection to the database
    $conn = getConnection();

    // Check if the connection was successful
    if ($conn === false) {
        die("Error: Could not connect to the database.");
    }

    // Prepare the SQL query to insert the review (corrected table name)
    $sql = "INSERT INTO crop_review (crop_id, user_id, user_type, review_text) 
            VALUES (?, ?, ?, ?)";
    
    // Attempt to prepare the SQL statement
    $stmt = $conn->prepare($sql);
    
    // Check if the query preparation was successful
    if ($stmt === false) {
        die("Error: Failed to prepare SQL query. " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("iiss", $cropId, $userId, $userType, $reviewText);
    
    if ($stmt->execute()) {
        // Redirect back to the crop details page with a success message
        header("Location:../view/product_details.php?id=" . $cropId);
        exit();
    } else {
        // Handle error during execution
        die("Error: Unable to execute the query. " . $stmt->error);
    }

    // Close the connection
    $stmt->close();
    $conn->close();
} else {
    // If form data is missing, redirect to the product details page with an error
    header("Location:../view/product_details.php?id=" . $_POST['crop_id']);
    exit();
}
?>
