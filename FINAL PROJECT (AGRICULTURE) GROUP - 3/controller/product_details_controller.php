<?php
session_start();
require_once('../model/database.php');
include('../view/navbar.php');


if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'Consumer') {
    header('Location: ../view/login.html');
    exit();
}


$crop_details = null;
$crop_reviews = [];
 

//here i am receiving the crop details send by ajax from buy_product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['crop_id'] = $_POST['crop_id'];
    $_SESSION['crop_name'] = $_POST['crop_name'];
    $_SESSION['description'] = $_POST['description'];
    $_SESSION['price'] = $_POST['price'];
    $_SESSION['image'] = $_POST['image'];
    
  
    if (isset($_POST['available_quantity'])) {
        $_SESSION['available_quantity'] = $_POST['available_quantity']; // Add available_quantity to session
    }
}

if (isset($_SESSION['crop_id'])) {
    
    $crop_details = [
        'crop_id' => $_SESSION['crop_id'],
        'crop_name' => $_SESSION['crop_name'],
        'description' => $_SESSION['description'],
        'price' => $_SESSION['price'],
        'image_path' => str_replace("C:/xampp/htdocs/", "/", $_SESSION['image']),
        'available_quantity' => $_SESSION['available_quantity'] ?? 0, 
    ];
    
    $crop_details['image_path'] = str_replace("\\", "/", $crop_details['image_path']);

    // Fetch crop details from the database
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'agriculture');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $crop_id = $_SESSION['crop_id'];
    $query = "SELECT * FROM crop WHERE crop_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Query preparation failed: ' . $conn->error);
    }

    $stmt->bind_param("i", $crop_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $crop_details = $result->fetch_assoc();
        $crop_details['image_path'] = str_replace("C:/xampp/htdocs/", "/", $crop_details['image']);
        $crop_details['image_path'] = str_replace("\\", "/", $crop_details['image_path']);

        // Ensure the available_quantity is stored if not already set
        if (!isset($_SESSION['available_quantity'])) {
            $_SESSION['available_quantity'] = $crop_details['available_quantity'];
        }
    } else {
        $crop_details = null;
    }

    // Fetch reviews for the crop_id
    $query_reviews = "
        SELECT r.id, r.crop_id, r.user_id, r.user_type, r.review_text, r.review_date, 
               CONCAT(c.first_name, ' ', c.last_name) AS user_name
        FROM crop_review r
        JOIN consumer c ON r.user_id = c.id
        WHERE r.crop_id = ?
        ORDER BY r.review_date DESC";

    $stmt_reviews = $conn->prepare($query_reviews);

    if ($stmt_reviews === false) {
        die('Query preparation for reviews failed: ' . $conn->error);
    }

    $stmt_reviews->bind_param("i", $crop_id);
    $stmt_reviews->execute();
    $result_reviews = $stmt_reviews->get_result();

    if ($result_reviews->num_rows > 0) {
        while ($review = $result_reviews->fetch_assoc()) {
            $crop_reviews[] = $review;
        }
    }

    $conn->close();
} else {
    $crop_details = null;
    $crop_reviews = [];
}

require_once('../view/product_details.php'); // Pass the updated data to the view
?>
