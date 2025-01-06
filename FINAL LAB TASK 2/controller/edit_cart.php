<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');



// Connect to the database
$conn = mysqli_connect('127.0.0.1', 'root', '', 'agriculture');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: You must be logged in to edit your cart.");
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Get POST data
$cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
$crop_id = isset($_POST['crop_id']) ? intval($_POST['crop_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
$available_quantity = isset($_POST['available_quantity']) ? intval($_POST['available_quantity']) : 0;

if ($quantity > $available_quantity) {
    echo "Error: Quantity exceeds available stock.";
    exit;
}

// Fetch the crop price
$stmt = $conn->prepare("SELECT price FROM crop WHERE crop_id = ?");
$stmt->bind_param("i", $crop_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $price_per_kg = $row['price'];
    $total_price = $quantity * $price_per_kg;

    // Update the cart
    $stmt = $conn->prepare("UPDATE cart SET quantity = ?, total_price = ? WHERE cart_id = ? AND user_id = ?");
    $stmt->bind_param("idii", $quantity, $total_price, $cart_id, $user_id);
    $stmt->execute();

    echo "Cart updated successfully!";
} else {
    echo "Error: Crop not found.";
}

echo "<a href=\"http://127.0.0.1/agri20/view/cart_details.php\">Back</a>";


$stmt->close();
$conn->close();
?>
