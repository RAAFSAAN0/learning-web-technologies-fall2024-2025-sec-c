<?php
include('../view/navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../asset/consumer_settings.js"></script>

</head>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 20px;
    }

    h1 {

        margin-top: 50px;
        text-align: center;
        color: #333;
    }

    form {
        max-width: 400px;
        margin: 20px auto;
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="email"], input[type="password"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        display: block;
        width: 100%;
        background-color: #007BFF;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    #responseMessage {
        margin-top: 20px;
        text-align: center;
        color: #28a745;
    }
</style>

<body>
    <h1>Change Password</h1>
    <form id="changePasswordForm">
        <label for="email">Enter your email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="recent_password">Enter recent password:</label><br>
        <input type="password" id="recent_password" name="recent_password" required><br><br>

        <label for="new_password">Enter new password:</label><br>
        <input type="password" id="new_password" name="new_password" required><br><br>

        <label for="confirm_new_password">Confirm new password:</label><br>
        <input type="password" id="confirm_new_password" name="confirm_new_password" required><br><br>

        <button type="submit">Reset Password</button>
    </form>

    <div id="responseMessage"></div>

    
</body>
</html>
