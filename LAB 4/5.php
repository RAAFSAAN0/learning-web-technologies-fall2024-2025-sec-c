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
                <input type="checkbox" name="degree" value="ssc">ssc
                <input type="checkbox" name="degree" value="hsc">Hsc
                <input type="checkbox" name="degree" value="bsc">BSc
                <input type="checkbox" name="degree" value="msc">MSc

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
    if(!isset($_REQUEST['degree'] ))
    {
        echo"no degree is selected";
    }

    else
    {
        echo "selected degreeis: ".$_REQUEST['degree'];
    }

}


?>












    
</body>
</html>