<?php
header("Content-Type: application/json");
session_start();

$conn = mysqli_connect('127.0.0.1', 'root', '', 'agriculture');
if (!$conn) {
    echo json_encode(['success' => false, 'error_message' => 'Database connection failed.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 




{
    $data = json_decode(file_get_contents("php://input"), true);
    error_log("Received data: " . print_r($data, true)); 

    $crop_id = $data['crop_id'] ?? null;
    $quantity = $data['quantity'] ?? null;
    $total_price = $data['total_price'] ?? null;
    $bank_account = $data['bank_account'] ?? null;
    $payment_type = $data['payment_type'] ?? 'Retail';


    if (!$crop_id || !$quantity || !$total_price || !$bank_account) 
    
    
    {
        echo json_encode(['success' => false, 'error_message' => 'Invalid request data.']);
        exit;
    }

    if (!preg_match("/^\d{8,15}$/", $bank_account)) 
    
    
    
    {
        echo json_encode(['success' => false, 'error_message' => 'Invalid bank account number.']);
        exit;
    }

    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        echo json_encode(['success' => false, 'error_message' => 'User not logged in.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT balance FROM consumer_account WHERE consumer_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $account = $result->fetch_assoc();

    if (!$account || $account['balance'] < $total_price) 
    
    
    {
        echo json_encode(['success' => false, 'error_message' => 'Insufficient funds.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO consumer_purchase (user_id, crop_id, amount_bought, purchase_date, transaction_type) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->bind_param("iiis", $user_id, $crop_id, $quantity, $payment_type);

    if ($stmt->execute()) {
        $stmt = $conn->prepare("UPDATE consumer_account SET balance = balance - ? WHERE consumer_id = ?");
        $stmt->bind_param("di", $total_price, $user_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error_message' => 'Failed to update balance.']);
        }
    } else {
        echo json_encode(['success' => false, 'error_message' => 'Failed to record purchase.']);
    }
}

$conn->close();
?>
