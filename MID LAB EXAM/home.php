<?php

session_start();

echo"<h1>Welcome to the home page</h1><br>";

echo "<h2>Here are the informations of the form </h2><br> ";



echo "USERNAME: ".$_SESSION['form_data']['username']."<br>";
echo "EMAIL: ".$_SESSION['form_data']['email']."<br>";
echo "PASSWORD: ".$_SESSION['form_data']['formpassword']."<br>";
echo "DATE OF BIRTH: " . $_SESSION['form_data']['dob']['day'] . "/" . $_SESSION['form_data']['dob']['month'] . "/" . $_SESSION['form_data']['dob']['year'];


?>
<html>

    <body>

    <br><br>
        <a href="logout.php" name="logout">LOGOUT
    </body>
</html>