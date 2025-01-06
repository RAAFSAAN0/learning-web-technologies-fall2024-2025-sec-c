<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h1>Change Password</h1>
    <form action="../controller/forgot_password.php" method="POST">
        <label for="email">Enter your email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="recent_password">Enter recent password:</label><br>
        <input type="password" name="recent_password" required><br><br>

        <label for="new_password">Enter new password:</label><br>
        <input type="password" name="new_password" required><br><br>

        <label for="confirm_new_password">Confirm new password:</label><br>
        <input type="password" name="confirm_new_password" required><br><br>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
