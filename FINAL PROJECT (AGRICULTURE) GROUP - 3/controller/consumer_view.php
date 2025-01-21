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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image']))


{
    $targetDir = "../asset/images/";
    $fileName = "profile_" . uniqid() . "." . pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
    $targetFile = $targetDir . $fileName;

    if (getimagesize($_FILES['profile_image']['tmp_name']) !== false) {
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
            if (updateProfileImage($id, $fileName)) {
                $consumerData = fetchConsumerByEmail($_SESSION['email']);
                $profile_image = $consumerData['profile_image'];
                echo "Profile image updated successfully.";
            } else {
                echo "Failed to update profile image in database.";
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Please upload a valid image file.";
    }
}

include '../view/consumer_profile.php';
?>
