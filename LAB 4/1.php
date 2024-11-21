<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <table>
        <form method="POST" action="">
            <tr>
                <td colspan="2">
                    <fieldset>
                        <legend>Name</legend>
                        <input type="text" name="username" value="">
                        <hr>
                        <input type="submit" name="submit" value="submit">
                    </fieldset>
                </td>
            </tr>
        </form>
    </table>
</body>
</html>


<?php

if (isset($_POST['submit']))
 {
    $name = trim($_POST['username']); 

  
    if (empty($name)) {
        echo "The name field is empty.";
    } 
  
    else if (strlen($name) <= 2) 
    {
        echo "The field should contain at least 2 characters.";
    }
    
    else if (!preg_match('/^[a-zA-Z]/', $name)) 
    {
        echo "The name must start with a letter.";
    }

    else {
        $valid = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.-";
        $isValid = true;

        
        for ($i = 0; $i < strlen($name); $i++) {
            if (strpos($valid, $name[$i]) === false)
            {
                echo "The name contains invalid characters.";
                $isValid = false;
                break; 
            }
        }

      
        if ($isValid) 
        {
            echo "The name is valid: $name";
        }
    }

   //completion checkpoint to github
}



   
    

   




?>


