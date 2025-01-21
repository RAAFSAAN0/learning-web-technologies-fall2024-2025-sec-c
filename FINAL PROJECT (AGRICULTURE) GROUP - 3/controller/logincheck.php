<?php
session_start();
require_once('../model/database.php');

header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') 


{



    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['email']) && isset($data['password'])) 
    
    
    {
        $email = trim($data['email']);
        $password = trim($data['password']);

        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'error' => 'Email and Password are required.']);
            exit;
        }

        
        $role = authenticateUser($email, $password);

        if ($role)
        
        {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

           
            $userId = getUserIdByEmail($email, $role);
            $_SESSION['user_id'] = $userId;

            $redirectUrl = '';
            if ($role == "Consumer") {
                $redirectUrl = "../view/consumerDashboard.php";
            } elseif ($role == "Student") {
                $redirectUrl = "../view/studentDashboard.php";
            } elseif ($role == "Farmer") {
                $redirectUrl = "../view/farmer_menu.html";
            }

            echo json_encode(['success' => true, 'redirectUrl' => $redirectUrl]);
        } else 
        {
            echo json_encode(['success' => false, 'error' => 'Invalid Email or Password!']);
        }
    } 
    
    else
    
    {
        echo json_encode(['success' => false, 'error' => 'Missing email or password.']);
    }
} 
else 

{
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
