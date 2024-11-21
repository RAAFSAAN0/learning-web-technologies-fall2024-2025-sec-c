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
                <input type="checkbox" name="ssc" value="ssc">ssc
                <input type="checkbox" name="hsc" value="hsc">Hsc
                <input type="checkbox" name="bsc" value="bsc">BSc
                <input type="checkbox" name="msc" value="msc">MSc

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

$get_length = count($_POST);

if($get_length <= 2){
    echo "At least two degrees must be selected";
}
else
{
    echo "OK";
}

?>











    
