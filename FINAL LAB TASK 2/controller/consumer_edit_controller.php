<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');

// Check if the user is logged in as a Consumer
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'Consumer') {
    header('Location: ../view/login.html');
    exit();
}

// Fetch consumer data using the function
$consumerData = fetchConsumerByEmail($_SESSION['email']);
$id = $consumerData['id'];
$first_name = $consumerData['first_name'];
$last_name = $consumerData['last_name'];
$email = $consumerData['email'];
$mobile = $consumerData['mobile'];
$country = $consumerData['country'];
$address = $consumerData['address'];
$dob = $consumerData['dob'];
$profile_image = $consumerData['profile_image'];

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $country = $_POST['country'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../uploads/images/";
        $fileName = "profile_" . uniqid() . "." . pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $targetFile = $targetDir . $fileName;
        
        if (getimagesize($_FILES['profile_image']['tmp_name']) !== false) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $profile_image = $fileName;
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Please upload a valid image file.";
        }
    }

    // Update the profile data using the function
    if (updateConsumerProfile($id, $first_name, $last_name, $mobile, $country, $address, $dob, $profile_image)) {
        // Optionally redirect to the profile view page after successful update
        header('Location: consumer_view.php');
        exit();
    } else {
        echo "Error updating profile.";
    }
}

// Include the view for profile editing
include('../view/consumer_edit_view.php');
?>
