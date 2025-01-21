<?php
// Include the controller for initial load data
extract(include('../controller/video_list_controller.php'));
include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../asset/video_list.js"></script>

    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
    }

    h2 {
        text-align: center;
        margin: 20px 0;
        color: #333;
    }

    #searchForm {
        width: 80%;
        max-width: 600px;
        margin: 0 auto 20px;
    
        justify-content: center;
    }

    #searchInput {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    #videoList {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .video-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
       
        flex-direction: column;
        text-align: center;
    }

    .video-card video {
        width: 100%;
        aspect-ratio: 16/9; 
        
    }

    .video-details {
        padding: 10px 10px 5px;
        font-size: 12px; /* Reduce text size */
        color: #333;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .video-title {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .video-uploader {
        color: #777;
        margin-bottom: 10px;
    }

    .view-details-form button {
        padding: 6px 10px;
        font-size: 12px; /* Reduce button size */
        border: none;
        border-radius: 5px;
        background-color: #0073e6;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .view-details-form button:hover {
        background-color: #005bb5;
    }
</style>


</head>
<body>
    <h2>Video List</h2>
    <form id="searchForm">
        <input type="text" id="searchInput" name="search" placeholder="Search by title or uploader" value="<?php echo htmlspecialchars($search); ?>">
    </form>

    <div id="videoList">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='video-card'>";
                echo "<video controls>
                        <source src='http://localhost/NEW/merged/asset/videos/" . basename($row['video_path']) . "' type='video/mp4'>
                        Your browser does not support the video tag.
                      </video>";
                echo "<div class='video-details'>";
                echo "<div class='video-title'>" . htmlspecialchars($row['title']) . "</div>";
                echo "<div class='video-uploader'><strong>Uploaded by:</strong> " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</div>";
                echo "<form class='view-details-form' method='POST' action='video_list.php'>
                        <input type='hidden' name='video_id' value='" . htmlspecialchars($row['id']) . "'>
                        <button type='submit'>View Details</button>
                      </form>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No videos found.</p>";
        }

        $result->close();
        ?>
    </div>

    
</body>
</html>

