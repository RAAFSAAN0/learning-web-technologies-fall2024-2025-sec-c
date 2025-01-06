<?php
session_start();
include('../view/navbar.php');
require_once('../model/database.php');

$conn = mysqli_connect('127.0.0.1', 'root', '', 'agriculture');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to modify your cart.");
}


$cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;


$stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ? AND user_id = ?");
$stmt->bind_param("ii", $cart_id, $_SESSION['user_id']);
if ($stmt->execute()) {
    echo "Item removed from the cart.";
} else {
    echo "Error: Could not delete the item.";
}

echo "<a href=\"http://127.0.0.1/agri20/view/cart_details.php\">Back</a>";

$stmt->close();
$conn->close();
?>
