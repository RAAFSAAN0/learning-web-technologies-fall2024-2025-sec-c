<?php
require_once '../model/database.php'; // Replace with the correct path to your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $recent_password = $_POST['recent_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Ensure new passwords match
    if ($new_password !== $confirm_new_password) {
        echo "New password and confirm password do not match.";
        exit;
    }

    // Function to check user credentials in a specific table
    function verifyAndChangePassword($table, $email, $recent_password, $new_password) {
        $conn = getConnection();
        $sql = "SELECT * FROM $table WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $recent_password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found; update password
            $updateSql = "UPDATE $table SET password = ? WHERE email = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ss", $new_password, $email);
            if ($updateStmt->execute()) {
                return true;
            } else {
                return false; // Update failed
            }
        }

        $stmt->close();
        $conn->close();
        return false; // User not found
    }

    // Check each table for the email
    $tables = ['Farmer', 'Student', 'Consumer'];
    $passwordChanged = false;

    foreach ($tables as $table) {
        if (verifyAndChangePassword($table, $email, $recent_password, $new_password)) {
            $passwordChanged = true;
            echo "Password updated successfully for $table.";
            break;
        }
    }

    if (!$passwordChanged) {
        echo "Invalid email or recent password.";
    }
}
?>
