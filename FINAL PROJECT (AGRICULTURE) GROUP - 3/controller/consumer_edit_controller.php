<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'Consumer') {
    header('Location: ../view/login.html');
    exit();
}

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
        
        if (getimagesize($_FILES['profile_image']['tmp_name']) !== false) 
        
        {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                $profile_image = $fileName;
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Please upload a valid image file.";
        }
    }



    if (updateConsumerProfile($id, $first_name, $last_name, $mobile, $country, $address, $dob, $profile_image)) {
        echo "<script>alert('Profile updated successfully!');</script>";
        
        echo "<script>window.location.href = 'consumer_view.php';</script>";
        exit();
    } 
    
    else 
    
    {
        echo "<script>alert('Error updating profile.');</script>";
    }
}
?>
