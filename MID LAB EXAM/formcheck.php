<?php


session_start();

if(isset($_REQUEST['submit']))
{

    $name=$_REQUEST['username'];
    $email=$_REQUEST['email'];
    $password=$_REQUEST['formpassword'];
   
    $date=$_REQUEST['dd'];
    $month=$_REQUEST['mm'];
    $year=$_REQUEST['yy'];


    if (empty($name) || empty($email)|| empty($date) || empty($month) || empty($year)) {
        echo "All fields are required.";
    }

    else
    {
        echo "successfull";

        $_SESSION['form_data']=[

            'username' => $name,
            'email'=> $email,
            'formpassword'=> $password,
            'dob' => 
            [
                'day' => $date,
                'month' => $month,
                'year' => $year
            ]
        ];

        header('location: login.html');

      
    }


}










?>