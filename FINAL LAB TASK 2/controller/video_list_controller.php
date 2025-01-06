<?php
session_start();
require '../model/database.php';
include('../view/navbar.php');

// Initialize database connection
$conn = new mysqli('localhost', 'root', '', 'agriculture'); // Replace with your database name

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Handle "View Details" action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['video_id'])) {
    $_SESSION['video_id'] = $_POST['video_id'];
    header('Location: video_details.php');
    exit();
}

// Fetch videos based on search input
$sql = "SELECT v.id, v.title, f.first_name, f.last_name, v.video_path
        FROM video v
        JOIN farmer f ON v.email = f.email
        WHERE v.title LIKE ? OR f.first_name LIKE ? OR f.last_name LIKE ?";
$stmt = $conn->prepare($sql);
$searchParam = '%' . $search . '%';
$stmt->bind_param('sss', $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

// Export variables for use in the view
return [
    'result' => $result,
    'search' => $search
];
