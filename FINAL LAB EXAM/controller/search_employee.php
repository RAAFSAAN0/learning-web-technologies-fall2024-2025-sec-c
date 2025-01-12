<?php
require_once('../model/db.php'); 


if (isset($_GET['search'])) {
    $searchQuery = "%" . $_GET['search'] . "%";

    $conn = getConnection();

  
    $sql = "SELECT id, employer_name, company_name, contact_no, username, password FROM employees WHERE employer_name LIKE ? OR company_name LIKE ?";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
       
        die(json_encode(["error" => "Error preparing SQL query"]));
    }

   
    $stmt->bind_param("ss", $searchQuery, $searchQuery);

  
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $employees = [];

      
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }

   
        echo json_encode($employees);
    } else {
        echo json_encode(["error" => "Error executing query"]); 
    }

    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "No search query provided"]); 
}
?>
