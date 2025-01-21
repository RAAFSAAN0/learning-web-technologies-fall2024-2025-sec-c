<?php
session_start();
require_once('../model/database.php');


if (!isset($_SESSION['user_id']))
{
    echo json_encode(['message' => 'You are not logged in.']);
    exit;
}


if (isset($_SESSION['purchase'])) 
{
    $purchase = $_SESSION['purchase'];

    $crop_id = $purchase['crop_id'];
    $quantity = $purchase['quantity'];
    $total_price = $purchase['total_price'];


    $crop_name = fetchCropName($crop_id);
    if (!$crop_name) {
        echo json_encode(['message' => 'Invalid crop details.']);
        exit;
    }



    $_SESSION['purchase']['crop_name'] = $crop_name;
} 
else 

{
    echo json_encode(['message' => 'No purchase details found.']);
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if (isset($_POST['payment_type'])) {
        $payment_type = $_POST['payment_type'];

        $_SESSION['purchase']['payment_type'] = $payment_type;
        $redirectUrl = $payment_type === 'retail' ? 'retails_payment.php' : 'mobile_payment.php';

        echo json_encode(['redirect' => $redirectUrl]);
        exit;
    } 
    
    else 
    
    {
        echo json_encode(['message' => 'Payment type is required.']);
        exit;
    }
}

return [
    'crop_name' => $crop_name,
    'quantity' => $quantity,
    'total_price' => $total_price
];
?>
