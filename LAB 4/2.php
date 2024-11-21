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
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);

    if (empty($email)) {
        echo "The email field is empty.";
    } else {
        if (isValidEmail($email)) {
            echo "The email is invalid.";
        } else {
            echo "The email is valid!";
        }
    }
}

function isValidEmail($email) {
    
    $validChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.-0123456789@";
    for ($i = 0; $i < strlen($email); $i++) {
        if (strpos($validChars, $email[$i]) === false) {
            echo "The email contains invalid characters.<br>";
            return false;
        }
    }


    return true;
}
?>

