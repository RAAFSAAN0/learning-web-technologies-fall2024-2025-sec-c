<?php
// session_start();
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>

<table border=1>
<tr>
    <td colspan="2"> Profile</td>

</tr>

<tr>
    <td>ID</td>
    <td><?php session_start(); echo ($_SESSION['form_data']['id']); ?></td>
</tr>

<tr>
    <td>NAME</td>
    <td><?php ; echo ($_SESSION['form_data']['name']); ?></td>
</tr>
<tr>
    <td>USER TYPE</td>
    <td><?php ; echo ($_SESSION['form_data']['usertype']); ?></td>
</tr>

</table>






<!--         
    <h2>Your Profile</h2>
    <p>Username: <?php //echo $_SESSION['username']; ?></p>
    <p>Role: <?php //echo $_SESSION['role']; ?></p>
    <p><a href="logout.php">Logout</a></p> -->
</body>
</html>
