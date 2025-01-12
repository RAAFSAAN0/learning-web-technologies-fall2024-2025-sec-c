<?php
require_once('../model/db.php');

$conn = getConnection();

function getEmployeeById($id) {
    global $conn;
    $query = "SELECT * FROM employees WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing the SQL query: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $employer_name = $_POST['employer_name'];
    $company_name = $_POST['company_name'];
    $contact_no = $_POST['contact_no'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "UPDATE employees SET employer_name = ?, company_name = ?, contact_no = ?, username = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing the SQL query: " . $conn->error);
    }

    $stmt->bind_param("sssssi", $employer_name, $company_name, $contact_no, $username, $password, $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error updating employee data.";
    }
}
?>
