<?php

include('navbar.php');


if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'Consumer') {
    header('Location: ../view/login.html');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Consumer Profile</title>
</head>
<body>
    <h1>Edit Consumer Profile</h1>

    <form action="../controller/consumer_edit_controller.php" method="POST" enctype="multipart/form-data">
        <label for="first_name">First Name:</label><br>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly><br><br>

        <label for="mobile">Mobile:</label><br>
        <input type="text" name="mobile" value="<?php echo htmlspecialchars($mobile); ?>" required><br><br>

        <label for="country">Country:</label><br>
        <input type="text" name="country" value="<?php echo htmlspecialchars($country); ?>" required><br><br>

        <label for="address">Address:</label><br>
        <textarea name="address" required><?php echo htmlspecialchars($address); ?></textarea><br><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required><br><br>

        <label for="profile_image">Profile Image:</label><br>
        <input type="file" name="profile_image"><br><br>

        <button type="submit">Update Profile</button>
    </form>

    <a href="consumer_edit_view.php">Back to Profile</a>
</body>
</html>
