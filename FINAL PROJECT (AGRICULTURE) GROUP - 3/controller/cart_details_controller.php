<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');

if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to view your cart.");
}

$user_id = $_SESSION['user_id'];

$cart_items = fetchCartItemsByUserId($user_id);

return $cart_items;
?>
