<?php
 
function getConnection() {
    $conn = mysqli_connect('127.0.0.1', 'root', '', 'agriculture');
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function isEmailUnique($email) {
    $conn = getConnection();
    

    $sql = "SELECT email FROM Farmer WHERE email = ? UNION SELECT email FROM Consumer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();
    $conn->close();

    return $result->num_rows === 0; 
}

 
function addConsumer($first_name, $last_name, $email, $mobile, $password) {
    $conn = getConnection();

    
    $sql = "INSERT INTO Consumer (first_name, last_name, email, mobile, password) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $mobile, $password);
    
    $result = $stmt->execute();
    
    $stmt->close();
    $conn->close();

    return $result; // Return whether the insert was successful
}


function addFarmer($first_name, $last_name, $email, $mobile, $password) {
    $conn = getConnection();

  
    $sql = "INSERT INTO Farmer (first_name, last_name, email, mobile, password) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $mobile, $password);
    
    $result = $stmt->execute();
    
    $stmt->close();
    $conn->close();

    return $result;
}


function authenticateUser($email, $password) {
    $conn = getConnection(); // Establish database connection

    // Query to get the password from the Consumer table
    $sql = "SELECT password FROM Consumer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $stmt->bind_result($storedPassword);

    // If a result is found, compare the passwords
    if ($stmt->fetch()) {
       
        if ($password === $storedPassword) {
            
            return 'Consumer';  
        }
    }

    // Query for Farmer table as well
    $sql2 = "SELECT password FROM Farmer WHERE email = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("s", $email);
    $stmt2->execute();
    $stmt2->bind_result($storedPassword2);

    if ($stmt2->fetch()) {
        if ($password === $storedPassword2) {
            return 'Farmer';  
        }
    }

    
    $stmt->close();
    $stmt2->close();
    $conn->close();

    return false; 
}


function fetchAllConsumers() {
    $conn = getConnection();
    $sql = "SELECT id, first_name, last_name, email, mobile FROM Consumer";
    $result = $conn->query($sql);

    $consumers = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $consumers[] = $row;
        }
    }
    $conn->close();
    return $consumers;
}


function deleteConsumer($id) {
    $conn = getConnection();
    $sql = "DELETE FROM Consumer WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}


function updateConsumer($id, $first_name, $last_name, $email, $mobile) {
    $conn = getConnection();
    $sql = "UPDATE Consumer SET first_name = ?, last_name = ?, email = ?, mobile = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $mobile, $id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}
?>
