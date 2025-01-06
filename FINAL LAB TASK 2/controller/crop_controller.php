<?php
include('../view/navbar.php');
// File: controller/CropController.php
function getCrops() {
    // Database connection
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'agriculture');
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT crop_id, crop_name, description, price, image FROM crop";
    $result = $conn->query($sql);
    
    $crops = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['image'] = str_replace("C:/xampp/htdocs/", "/", $row['image']); // Adjust path
            $row['image'] = str_replace("\\", "/", $row['image']); // Handle Windows paths
            $crops[] = $row;
        }
    }

    // Close connection
    $conn->close();
    
    return $crops;
}
