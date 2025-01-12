<?php
require_once('../model/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $employer_name = $_POST['employer_name'];
    $company_name = $_POST['company_name'];
    $contact_no = $_POST['contact_no'];
    $username = $_POST['username'];
    $password = $_POST['password'];


    $conn = getConnection();


    $stmt = $conn->prepare("INSERT INTO employees (employer_name, company_name, contact_no, username, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $employer_name, $company_name, $contact_no, $username, $password);


    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Employee added successfully.']); 
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]); 
    }

    $stmt->close();
    $conn->close();
}
?>
