<?php
session_start();
require '../model/database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['video_id'])) 



{
    $_SESSION['video_id'] = $_POST['video_id'];
    header('Location: video_details.php');
    exit();
}

$search = isset($_POST['search']) ? $_POST['search'] : '';

$result = fetchVideosBySearch($search);

if (isset($_POST['search'])) 


{
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) 
        
        
        
        {
            echo "<div style='border: 1px solid #ddd; margin-bottom: 20px; padding: 10px;'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p><strong>Uploaded by:</strong> " . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</p>";

            $videoURL = "http://localhost/NEW/merged/asset/videos/" . basename($row['video_path']);
            echo "<video width='320' height='240' controls>
                    <source src='" . htmlspecialchars($videoURL) . "' type='video/mp4'>
                    Your browser does not support the video tag.
                  </video>";

            echo "<form method='POST' action='video_list.php'>
                    <input type='hidden' name='video_id' value='" . htmlspecialchars($row['id']) . "'>
                    <button type='submit'>View Details</button>
                  </form>";
            echo "</div>";
        }
    } else {
        echo "<p>No videos found.</p>";
    }
    exit();
}


return [
    'result' => $result,
    'search' => $search
];
