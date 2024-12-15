<?php
// session_start();
// if ($_SESSION['usertype'] != 'user') {
//     header("Location: login.html");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
</head>
<body>
    <h2>Welcome, User</h2>

    <p><a href="profile.php">Profile</a></p>

    <p><a href="viewusers.php">View Users</a></p>

    <p><a href="changepassword.php">Change Password</a></p>
    
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
