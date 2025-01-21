<?php
header('Content-Type: application/json');
// ini_set('display_errors', 0); //so that the customer cannot see the internel error
// error_reporting(0);

require_once('../model/database.php');

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($data['first_name']);
    $last_name = trim($data['last_name']);
    $email = trim($data['email']);
    $mobile = trim($data['mobile']);
    $password = trim($data['password']);
    $retype_password = trim($data['retype_password']);
    $role = trim($data['role']);
    $country = trim($data['country']);
    $address = trim($data['address']);
    $dob = trim($data['dob']);

    if (empty($first_name) || empty($last_name) || empty($email) ||
        empty($mobile) || empty($password) || empty($retype_password) ||
        empty($role) || empty($country) || empty($address) || empty($dob))
        
    {
        echo json_encode(['success' => false, 'error' => 'All fields are required!']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    
    {
        echo json_encode(['success' => false, 'error' => 'Invalid email format!']);
        exit;
    }

    if (!isEmailUnique($email)) {
        echo json_encode(['success' => false, 'error' => 'Email is already registered.']);
        exit;
    }

    if ($password !== $retype_password) {
        echo json_encode(['success' => false, 'error' => 'Passwords do not match!']);
        exit;
    }

    
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{4,}$/', $password)) {
        echo json_encode(['success' => false, 'error' => 'Password must be at least 4 characters long, and contain at least one uppercase letter, one lowercase letter, and one number.']);
        exit;
    }

    if (strlen($mobile) < 11)
    
    {
        echo json_encode(['success' => false, 'error' => 'Mobile number must be 11 digits long.']);
        exit;
    }

    if (strtotime($dob) > time()) {
        echo json_encode(['success' => false, 'error' => 'Date of birth cannot be in the future.']);
        exit;
    }

    $status = false;
    if ($role == 'Consumer') 
    
    
    {
        $status = addConsumer($first_name, $last_name, $email, $mobile, $password, $country, $address, $dob, $role);
    } elseif ($role == 'Farmer') {
        $status = addFarmer($first_name, $last_name, $email, $mobile, $password, $country, $address, $dob, $role);
    } elseif ($role == 'Student') {
        $status = addStudent($first_name, $last_name, $email, $mobile, $password, $country, $address, $dob, $role);
    }

    if ($status) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Registration failed. Please try again.']);
    }
    exit;
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
    exit;
}
?>
