<?php
require_once('../model/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from POST request
    $employer_name = $_POST['employer_name'];
    $company_name = $_POST['company_name'];
    $contact_no = $_POST['contact_no'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create a connection to the database
    $conn = getConnection();

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO employees (employer_name, company_name, contact_no, username, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $employer_name, $company_name, $contact_no, $username, $password);

    // Check if insertion was successful
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Employee added successfully.']); 
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]); 
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
