<!DOCTYPE html>
<html lang="en">
<head>
    <table>
        <form method="POST" action="">
            <tr>
                <fieldset style="width: 20%;">
                    <legend>Date of Birth</legend>
                    <input type="text" name="dd" style="width: 20%;"> dd
                    <input type="text" name="mm" style="width: 20%;"> mm
                    <input type="text" name="yy" style="width: 20%;"> yy
                    <br>
                    <br>
                    <input type="submit" name="submit" value="">
                </fieldset>
            </tr>
        </form>
    </table>
</head>

<?php

if (isset($_POST['submit'])) 

{  
    $day_var = $_POST['dd'];
    $month_var = $_POST['mm'];
    $year_var = $_POST['yy'];

    function check_day($day_var)
    {
        for ($i = 1; $i <= 31; $i++) {
            if ($day_var == $i) {
                return true;
            }
        }
        return false;
    }

    function check_month($month_var)
    {
        for ($i = 1; $i <= 12; $i++) {
            if ($month_var == $i) {
                return true;
            }
        }
        return false;
    }

    function check_year($year_var)
    {
        for ($i = 1953; $i <= 1998; $i++) {
            if ($year_var == $i) {
                return true;
            }
        }
        return false;
    }

    if (empty($day_var) || empty($month_var) || empty($year_var)) 
    {
        echo "Date of Birth cannot be empty";
    } 
    else if (!check_day($day_var)) 
    {
        echo "Day must be between 1 - 31<";
    } 
    else if (!check_month($month_var)) 
    {
        echo "Month must be between 1 - 12";
    } 
    else if (!check_year($year_var)) 
    {
        echo "Year must be between 1953 - 1998";
    } 
    else 
    {
        echo "Date of Birth: {$day_var} / {$month_var} / {$year_var}";
    }
    //completion checkpoint to github
}

?>
