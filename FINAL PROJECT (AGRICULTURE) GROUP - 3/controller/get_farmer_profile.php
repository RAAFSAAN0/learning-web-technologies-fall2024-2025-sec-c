<?php
session_start();
require_once '../model/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET')



{
    if (!isset($_SESSION['email'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit();
    }

    $email = $_SESSION['email'];
    $conn = getConnection();
    $sql = "SELECT first_name, last_name, email, mobile, country, address, dob FROM Farmer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $farmer = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if ($farmer) {
        echo json_encode(['success' => true, 'farmer' => $farmer]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Farmer not found']);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 


{
    if (!isset($_SESSION['email'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit();
    }

    $email = $_SESSION['email'];
    $data = json_decode(file_get_contents('php://input'), true);

    $conn = getConnection();
    $sql = "UPDATE Farmer SET first_name = ?, last_name = ?, mobile = ?, country = ?, address = ?, dob = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssss",
        $data['first_name'],
        $data['last_name'],
        $data['mobile'],
        $data['country'],
        $data['address'],
        $data['dob'],
        $email
    );

    if ($stmt->execute()) 
    
    
    {
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
