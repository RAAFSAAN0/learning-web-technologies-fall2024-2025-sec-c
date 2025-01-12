<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Login</title>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <?php
    if (isset($_GET['error'])) {
        echo "<p class='error'>Invalid username or password.</p>";
    }
    ?>

    <form action="../controller/login_check.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />

        <button type="submit">Login</button>

        <a href="add_employee_view.php">Registration</a>
    </form>
</div>



</body>
</html>
