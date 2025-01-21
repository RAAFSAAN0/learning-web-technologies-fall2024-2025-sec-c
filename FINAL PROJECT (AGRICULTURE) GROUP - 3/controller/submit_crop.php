<?php
// Database connection
$conn = new mysqli('127.0.0.1', 'root', '', 'agriculture');

// Check connection
if ($conn->connect_error) {
    echo "Database connection failed: " . $conn->connect_error;
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $crop_name = htmlspecialchars(trim($_POST['crop_name']));
    $crop_quantity = htmlspecialchars(trim($_POST['crop_quantity']));
    $crop_description = htmlspecialchars(trim($_POST['crop_description']));

    // Server-side validation
    if (empty($crop_name) || empty($crop_quantity) || empty($crop_description)) {
        echo "All fields are required.";
        exit();
    }

    if (!is_numeric($crop_quantity) || $crop_quantity <= 0) {
        echo "Crop quantity must be a positive number.";
        exit();
    }

    // Insert data into the database
    $sql = "INSERT INTO crop_exchange (crop_name, crop_quantity, crop_description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $crop_name, $crop_quantity, $crop_description);

    if ($stmt->execute()) {
        echo "success"; // Return a simple success message
    } else {
        echo "Error: " . $stmt->error; // Return the error message
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
