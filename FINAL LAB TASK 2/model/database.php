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
    return $result->num_rows === 0;  // Return true if no result (email is unique)
}

// Function to add a new consumer to the database
function addConsumer($first_name, $last_name, $email, $mobile, $password, $country, $address, $dob, $role) {
    $conn = getConnection();

    $sql = "INSERT INTO consumer (first_name, last_name, email, mobile, password, country, address, dob, role, profile_image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)";

    $stmt = $conn->prepare($sql);


    $stmt->bind_param("sssssssss", $first_name, $last_name, $email, $mobile, $password, $country, $address, $dob, $role);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}


function getConsumerNameById($userId) {
    $conn = getConnection(); // Get the database connection

    // Prepare and execute the SQL query
    $sql = "SELECT first_name, last_name FROM consumer WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing the SQL statement.");
    }

    $stmt->bind_param("i", $userId);  

    $stmt->execute();  
    $result = $stmt->get_result();  

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();  
    } else {
        
        return false;  
    }

    $stmt->close(); 
    $conn->close(); 
}






// Function to add a new farmer to the database
function addFarmer($first_name, $last_name, $email, $mobile, $password, $country, $address, $dob) {
    $conn = getConnection();
    $sql = "INSERT INTO Farmer (first_name, last_name, email, mobile, password, country, address, dob) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $mobile, $password, $country, $address, $dob);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

function addStudent($first_name, $last_name, $email, $mobile, $password, $country, $address, $dob, $role) {
    $conn = getConnection();
    $sql = "INSERT INTO student (first_name, last_name, email, mobile, password, country, address, dob, role, profile_image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $null = NULL; // Pass NULL for the profile_image
    $stmt->bind_param("ssssssssss", $first_name, $last_name, $email, $mobile, $password, $country, $address, $dob, $role, $null);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}







function authenticateUser($email, $password) {
    $conn = getConnection();  // Ensure database connection is set up

    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM farmer WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error in farmer query: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // If farmer is found
    if ($result->num_rows > 0) {
        return 'Farmer';  
    }

    $sql = "SELECT role FROM consumer WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Error in consumer query: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row is returned for consumer
    if ($result->num_rows > 0) {
        return 'Consumer'; 
    }

    // Check the 'student' table for matching email and password
    $sql = "SELECT role FROM student WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Error in student query: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row is returned for student
    if ($result->num_rows > 0) {
        return 'Student';  // Return Student role if credentials are valid
    }

    // If no matching user found in any table
    return false;
}



// Function to fetch all consumers' data
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
// Function to get user ID by email and role (Consumer or Farmer)
function getUserIdByEmail($email, $role) {
    $conn = getConnection();  // Ensure database connection is set up

    // Query based on the user's role
    if ($role == 'Consumer') {
        $sql = "SELECT id FROM consumer WHERE email = ?";
    } elseif ($role == 'Student') {
        $sql = "SELECT id FROM student WHERE email = ?";
    } elseif ($role == 'Farmer') {
        $sql = "SELECT id FROM farmer WHERE email = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        return $user['id'];
    }

    return false;  // If no user found
}



// Function to fetch a specific consumer's data by email (current logged-in user)
function fetchConsumerByEmail($email) {
    $conn = getConnection(); // Assuming getConnection() is your function to connect to the DB
    $sql = "SELECT * FROM Consumer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $consumer = $result->fetch_assoc();

    // Check if the consumer data exists and return it
    if ($consumer) {
        $stmt->close();
        $conn->close();
        return $consumer;
    } else {
        // Handle case where no consumer is found with this email
        $stmt->close();
        $conn->close();
        return null;
    }
}


// Function to delete a consumer from the database
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
function updatePassword($email, $new_password) {
    $conn = getConnection(); // Assuming this function establishes a database connection
    $sql = "UPDATE Consumer SET password = ? WHERE email = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_password, $email);
    
    if ($stmt->execute()) {
        // Return true if update is successful
        return true;
    } else {
        // Return false if there's an error in updating
        return false;
    }

    $stmt->close();
    $conn->close();
}

// Function to update consumer details
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






// Function to confirm a purchase
function confirmPurchase($userId, $productId, $quantity, $totalPrice) {
    $conn = getConnection();
    $sql = "INSERT INTO purchases (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid", $userId, $productId, $quantity, $totalPrice);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result; // Return true if purchase confirmation succeeded
}

// Function to fetch user details for payment processing
function fetchUserDetailsForPayment($userId) {
    $conn = getConnection();
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $userDetails = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $userDetails; // Return user details as an associative array
}

// Function to handle payment transactions
function processPayment($userId, $amount, $paymentMethod) {
    $conn = getConnection();
    $sql = "INSERT INTO payments (user_id, amount, payment_method) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ids", $userId, $amount, $paymentMethod);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result; // Return true if payment processing succeeded
}

function fetchCropName($crop_id) {
    $conn = getConnection();
    $sql = "SELECT crop_name FROM crop WHERE crop_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $crop_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $crop_name = null;
    if ($row = $result->fetch_assoc()) {
        $crop_name = $row['crop_name'];
    }

    $stmt->close();
    $conn->close();
    return $crop_name;
}



// Fetch the email of the user based on their ID
function fetchUserEmail($user_id) {
    $conn = getConnection();
    $sql = "SELECT email FROM consumer WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $email = null;
    if ($row = $result->fetch_assoc()) {
        $email = $row['email'];
    }

    $stmt->close();
    $conn->close();
    return $email;
}


// Function to add/update item in the cart
function addToCart($user_id, $crop_id, $quantity) {
    $conn = getConnection();
    
    $sql = "SELECT price, available_quantity FROM crop WHERE crop_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $crop_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $price_per_kg = $row['price'];
        $available_quantity = $row['available_quantity'];

        if ($quantity > $available_quantity) {
            return ["error" => "Quantity exceeds available stock."];
        }

        $total_price = $quantity * $price_per_kg;

        $sql = "INSERT INTO cart (user_id, crop_id, quantity, price_per_kg, total_price) 
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity), 
                                        total_price = total_price + VALUES(total_price)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiidd", $user_id, $crop_id, $quantity, $price_per_kg, $total_price);
        $stmt->execute();

        return ["success" => "Item added to cart successfully!"];
    } else {
        return ["error" => "Crop not found."];
    }

    $stmt->close();
    $conn->close();
}

function fetchCropNameById($crop_id) {
    $conn = getConnection();
    
    $sql = "SELECT crop_name FROM crop WHERE crop_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $crop_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['crop_name'];
    }
    
    return null; 
}

// Function to fetch cart items by user_id
function fetchCartItemsByUserId($user_id) {
    $conn = getConnection(); 
    
    $sql = "SELECT c.cart_id, cr.crop_name, c.crop_id, c.quantity, c.price_per_kg, c.total_price, cr.available_quantity
            FROM cart c
            JOIN crop cr ON c.crop_id = cr.crop_id
            WHERE c.user_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cart_items = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cart_items[] = $row;
        }
    }
    
    $stmt->close();
    $conn->close();
    
    return $cart_items;
}



// Function to get the consumer account balance
function getConsumerBalance($consumer_id) {
    $conn = getConnection(); 
    
    $sql = "SELECT balance FROM consumer_account WHERE consumer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $consumer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $balance = $row['balance'];
    } else {
        $balance = 0; 
    }
    
    $stmt->close();
    $conn->close();
    
    return $balance; // Return the balance
}

// Function to check if the consumer account exists
function checkConsumerAccountExists($consumer_id) {
    $conn = getConnection(); 
    
    $sql = "SELECT * FROM consumer_account WHERE consumer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $consumer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $exists = $result->num_rows > 0;
    
    $stmt->close();
    $conn->close();
    
    return $exists; 
}

// Function to update the consumer account balance
function updateConsumerBalance($consumer_id, $deposit_amount) {
    $conn = getConnection();
    
    $sql = "UPDATE consumer_account SET balance = balance + ? WHERE consumer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $deposit_amount, $consumer_id);
    $stmt->execute();
    
    $stmt->close();
    $conn->close();
}

// Function to create a new consumer account
function createConsumerAccount($consumer_id, $deposit_amount) {
    $conn = getConnection(); 
    
    $sql = "INSERT INTO consumer_account (consumer_id, balance) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $consumer_id, $deposit_amount);
    $stmt->execute();
    
    $stmt->close();
    $conn->close();
}




// Function to update consumer profile
function updateConsumerProfile($id, $first_name, $last_name, $mobile, $country, $address, $dob, $profile_image) {
    $conn = getConnection(); // Get the database connection
    
    $sql = "UPDATE Consumer SET first_name = ?, last_name = ?, mobile = ?, country = ?, address = ?, dob = ?, profile_image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $first_name, $last_name, $mobile, $country, $address, $dob, $profile_image, $id);
    
    $result = $stmt->execute();
    
    $stmt->close();
    $conn->close();
    
    return $result; 
}

if (!function_exists('isEmailUnique')) {
    function isEmailUnique($email) {
        $conn = getConnection();
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        $conn->close();
        return $count == 0;
    }
}


if (!function_exists('isMobileUnique')) {
    function isMobileUnique($mobile) {
        $conn = getConnection();
        
        if ($conn === false) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "SELECT COUNT(*) FROM consumer WHERE mobile = ? 
                UNION 
                SELECT COUNT(*) FROM farmer WHERE mobile = ? 
                UNION 
                SELECT COUNT(*) FROM student WHERE mobile = ?";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            die("Error preparing the query: " . $conn->error);
        }
        
        $stmt->bind_param("sss", $mobile, $mobile, $mobile);
        $stmt->execute();
        
        $stmt->bind_result($count);
        $stmt->fetch();
        
        $stmt->close();
        $conn->close();
        
        return $count == 0;
    }
}




if (!function_exists('validateDob')) {
    function validateDob($dob) {
        $dobDate = strtotime($dob);
        $today = time();
        return $dobDate <= $today;
    }
}




?>
