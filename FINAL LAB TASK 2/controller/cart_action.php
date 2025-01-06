<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');


if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to add items to the cart.");
}


$user_id = $_SESSION['user_id'];


$crop_id = isset($_POST['crop_id']) ? intval($_POST['crop_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

$response = addToCart($user_id, $crop_id, $quantity);


if (isset($response['success'])) {
    echo $response['success'];
} else {
    echo $response['error'];
}
?>
