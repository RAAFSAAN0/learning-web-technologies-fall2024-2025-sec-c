

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <h2>Change Password</h2>
    <form method="POST" action="changepassword.php"> 
        <label for="currentPassword">Current Password: </label><br>
        <input type="password" name="currentPassword" value="<?= htmlspecialchars($currentPassword) ?>" required><br><br>

        <label for="newPassword">New Password:</label><br>
        <input type="password" name="newPassword" required><br><br>

        <label for="rePassword">Confirm New Password:</label><br>
        <input type="password" name="rePassword" required><br><br>

        <button type="submit">Change Password</button>
    </form>
</body>
</html>

<?php
session_start();  

$currentPassword = isset($_SESSION['logindata']['password']) ? $_SESSION['logindata']['password'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['rePassword'])) {
        
        $currentPasswordPost = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $rePassword = $_POST['rePassword'];

        if ($newPassword !== $rePassword) {
            echo "The new password and confirmation password do not match.";
            exit();
        }

        $users = file('usersinformation.txt');
        $passwordUpdated = false;
        $updatedUserInfo = [];

        foreach ($users as $line) {
            $line = trim($line);

            if (strpos($line, " = ") !== false) {
                list($key, $value) = explode(" = ", $line);

                if ($key == 'password' && trim($value) == $currentPasswordPost) {
                    $updatedUserInfo[] = "password = $newPassword";  
                    $passwordUpdated = true;
                } else {
                    $updatedUserInfo[] = "$key = $value";
                }
            }
        }

        
        if ($passwordUpdated) {
            file_put_contents('usersinformation.txt', implode("\n", $updatedUserInfo));
            echo "Password changed successfully!";
        } else {
            echo "Incorrect current password or failed update.";
        }
    } else {
        echo "Please provide all required fields.";
    }
}
?>
