<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table {
            border: 0px solid black;
            border-collapse: collapse;
        }
        td, th {
            border: 0px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <table>
    <form method="POST" action="">
        <tr>
            <td>Blood Group</td>
            <td>
                &nbsp;&nbsp;<select name="blood_group" style="width: 70%; height:30px">
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>
                <hr style="width:190%;text-align:left;margin-left:0">
                <input type="submit" name="submit" value="Submit">
            </td>
        </tr>
    </form>
    </table>
    </body>
    </html>
    <?php
    if (isset($_POST['submit'])) 
    {
        if (!isset($_POST['blood_group'])) 
        {
            echo "The blood group is not selected.";
        } 
        else 
        {
            echo "The selected blood group is: " . $_POST['blood_group'];
        }
    }
    ?>

