<?php

session_start();
if (isset($_REQUEST['submitlogin'])) {

   
    $userid = $_REQUEST['userid'];
    $password = $_REQUEST['password'];

    
    if ($userid == null || $password == null) {
        echo "The field cannot be empty";
    } else {
        //echo "Successful";

        if($_SESSION['form_data']['id']==$userid && $_SESSION['form_data']['formpassword']==$password)
        {
            echo " the login name matched with the form";

            $_SESSION['logindata']=[

                'userid'=>$userid,
                'password'=> $password    
                
            ];
        
            if($_SESSION['form_data']['usertype'] =='admin')
            {
                header('location:admin.php');

            }
            else
            {
                header('location:user.php');
            }

            
        }

        else
        {
            echo "the login name or password does not match with the form";


            
        }




    }



}
?>