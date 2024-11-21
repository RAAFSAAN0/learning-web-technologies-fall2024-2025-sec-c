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
                        <legend>Email</legend>
                        <input type="text" name="email" value="">
                        <hr>
                        <input type="submit" name="submit" value="Submit">
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
    $email_validation = $_REQUEST["email"];
    $validatecriteria1 = strpos($email_validation, ".com");
    $validatecriteria2 = strpos($email_validation, "@");
    if($validatecriteria1 == null || $validatecriteria1 < strlen($email_validation) - 4 || (strlen($email_validation) - $validatecriteria2) < 5){
        echo "This is not a valid email";
    } 
    else{
        echo "Your email is " . $email_validation . "";
    }
}

?>


