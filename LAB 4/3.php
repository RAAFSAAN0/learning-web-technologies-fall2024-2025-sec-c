<!DOCTYPE html>
<html lang="en">
<head>
  
        
  



    <table >
    <form method="POST" action="">
        <tr>
            <fieldset style="width: 20%;">
                <legend>Date of Birth</legend>
             
               
                    <input type="text" name= "dd" style="width: 20%;"> dd
                    <input type="text" name= "mm"style="width: 20%;"> mm
                    <input type="text" name= "yy" style="width: 20%;"> yy
                    <br>
                    <br>
                    <input type="submit" name="submit" value="">
                    
                        
                    

                
            </fieldset>
        </tr>

        
           
           
    

      


</form>
    </table>

</head>


<?php
if (isset($_POST['submit'])) {
    $day = trim($_REQUEST['dd']);
    $month = trim($_REQUEST['mm']);
    $year = trim($_REQUEST['yy']);

    if (empty($day) || empty($month) || empty($year)) {
        echo "The date fields cannot be empty.";
    }
    else 
    {
        if (!is_numeric($day) || !is_numeric($month) || !is_numeric($year)) {
            echo "The date must contain only numeric values.";
        }
         else 
          {
            if (isValidDate($day, $month, $year)) {
                echo "The date is valid.";
            } else {
                echo "The date is invalid.";
            }
         }
    }
}

function isValidDate($day, $month,$year) {
   
    if ($month < 1 || $month > 12) {
        return false;
    }

    if ($day < 1 || $day > 31) {
        return false;
    }

  
    return checkdate($month, $day,$year);
}
?>
