<?php

session_start();
if (isset($_REQUEST['submitlogin'])) {

   
    $loginname = $_REQUEST['loginname'];
    $password = $_REQUEST['password'];

    
    if ($loginname == null || $password == null) {
        echo "The field cannot be empty";
    } else {
        //echo "Successful";

        if($_SESSION['form_data']['username']==$loginname && $_SESSION['form_data']['formpassword']==$password)
        {
            echo " the login name matched with the form";

            header('location: home.php');
        }

        else
        {
            echo "the login name or password does not match with the form";


            
        }




    }



}
?>
