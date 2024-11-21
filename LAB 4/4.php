<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<table>
<form method="POST" action="">
<tr>
    <td colspan="2">
        <fieldset>
            <legend>Email</legend>
                <input type="radio" name="gender" value="male">male
                <input type="radio" name="gender" value="female">female
                <input type="radio" name="gender" value="others">others
                <hr>
                <input type="submit" name="submit" value="Submit">
        </fieldset>
            </td>
            </tr>



</form>

</table>

<?php

if (isset($_POST['submit']))
{
    if(!isset($_REQUEST['gender']))
    {
        echo"no gender is selected";
    }

    else
    {
        echo "selected gender is: ".$_REQUEST['gender'];
    }

}


?>












    
</body>
</html>