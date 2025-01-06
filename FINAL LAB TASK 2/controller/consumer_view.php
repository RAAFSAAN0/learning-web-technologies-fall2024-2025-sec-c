<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'Consumer') {
    header('Location: ../view/login.html');
    exit();
}

// Fetch the logged-in consumer's data
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

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $targetDir = "../asset/images/";
    $fileName = "profile_" . uniqid() . "." . pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
    $targetFile = $targetDir . $fileName;

    if (getimagesize($_FILES['profile_image']['tmp_name']) !== false) {
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
            $conn = getConnection();
            $sql = "UPDATE Consumer SET profile_image = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $fileName, $id);
            $stmt->execute();
            $stmt->close();
            $conn->close();

            // Refresh the consumer's data with the new profile image
            $consumerData = fetchConsumerByEmail($_SESSION['email']);
            $profile_image = $consumerData['profile_image'];
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Please upload a valid image file.";
    }
}

// Include the HTML file
include '../view/consumer_profile.php';
