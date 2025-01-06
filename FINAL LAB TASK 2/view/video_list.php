<?php
// Include the controller to fetch required data
extract(include('../controller/video_list_controller.php'));

// Include the navbar
//include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video List</title>
    <link rel="stylesheet" href="../asset/navbar.css">
</head>
<body>
    <h2>Video List</h2>
    <form method="GET" action="video_list.php">
        <input type="text" name="search" placeholder="Search by title or uploader" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div style='border: 1px solid #ddd; margin-bottom: 20px; padding: 10px;'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p><strong>Uploaded by:</strong> " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</p>";

            // Video preview
            $videoURL = "http://localhost/agri20/asset/video/" . basename($row['video_path']);
            echo "<video width='320' height='240' controls>
                    <source src='" . htmlspecialchars($videoURL) . "' type='video/mp4'>
                    Your browser does not support the video tag.
                  </video>";

            // Set session and redirect to video_details.php
            echo "<form method='POST' action='video_list.php'>
                    <input type='hidden' name='video_id' value='" . htmlspecialchars($row['id']) . "'>
                    <button type='submit'>View Details</button>
                  </form>";
            echo "</div>";
        }
    } else {
        echo "<p>No videos found.</p>";
    }

    // Close the result object to free resources
    $result->close();
    ?>
</body>
</html>
