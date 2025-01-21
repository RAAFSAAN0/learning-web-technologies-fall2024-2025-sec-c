<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumer Profile</title>
    <link rel="stylesheet" href="../asset/consumer_view.css">
</head>
<body>
    <h1>Consumer Profile</h1>
    <p>Welcome, <?php echo htmlspecialchars($first_name . " " . $last_name); ?>!</p>

   
<img src="../asset/images/<?php echo $profile_image ? $profile_image : 'default.jpg'; ?>" alt="Profile Picture" width="150" height="150">

<form action="consumer_view.php" method="POST" enctype="multipart/form-data">
    <label for="profile_image">
        <?php echo $profile_image ? 'Change Profile Photo:' : 'Upload a New Profile Image:'; ?>
    </label><br>
    <input type="file" name="profile_image" accept="image/*" required><br><br>
    <button type="submit"><?php echo $profile_image ? 'Change Image' : 'Upload Image'; ?></button>
</form>

    <h2>Profile Details</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($first_name . " " . $last_name); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Mobile:</strong> <?php echo htmlspecialchars($mobile); ?></p>
    <p><strong>Country:</strong> <?php echo htmlspecialchars($country); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($dob); ?></p>

    <a href="consumer_edit.php"><button>Edit Profile</button></a>
    <a href="logout.php">Logout</a>
</body>
</html>
