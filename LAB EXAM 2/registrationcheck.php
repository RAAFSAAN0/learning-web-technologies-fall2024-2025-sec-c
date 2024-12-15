<?php
session_start();

if (isset($_POST['signup'])) {
    // Get form data
    $id = $_POST['id'];
    $password = $_POST['formpassword'];
    $cpassword = $_POST['cpassword'];
    $name = $_POST['name'];
    $usertype = isset($_POST['usertype']) ? $_POST['usertype'] : '';

    // Validate form data
    if (empty($id) || empty($password) || empty($cpassword) || empty($name) || empty($usertype)) {
        echo "All fields are required.";
        exit();
    }

    if ($password !== $cpassword) {
        echo "Passwords do not match.";
        exit();
    }

    $file = fopen('usersinformation.txt', 'a');
    if ($file) {
        fwrite($file,"id = $id\npassword = $password\n name = $name\n user = $usertype\n");
        fclose($file);
        echo "Registration successful! <a href='signin.html'>Go to Sign In</a>";
    } else {
        echo "Error saving user data. Please try again later.";
    }

    $_SESSION['form_data']=[

        'name'=>$name,
        'id'=> $id,
        'formpassword'=> $password,
        'confirmpassword'=>$cpassword,
        'usertype'=>$usertype

        
    ];

    header('location:login.html');
}
?>
