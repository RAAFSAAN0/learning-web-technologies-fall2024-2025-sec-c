<?php
function getConnection() {
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'company');
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    return $conn;
}


function getAllEmployees($conn) {
    $sql = "SELECT id, employer_name, company_name, contact_no, username, password FROM employees";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $employees = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
    }
    return $employees;
}

function addEmployees($conn)
{
    $sql = "INSERT INTO employees (employer_name, company_name, contact_no, username, password) VALUES (?, ?, ?, ?, ?)";
    $result =  $conn->query($sql);
    
    if(!result)
    {
        die("Query failed: " . $conn->error);
    }

}
?>
