<?php

// include('navbar.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop List</title>
</head>
<body>
    <h1>Available Crops</h1>
    <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        <?php
        session_start();
        require_once('../controller/crop_controller.php'); 

        $crops = getCrops();

       
        if (count($crops) > 0) {
         
            foreach ($crops as $row) {
                echo '<div style="border: 1px solid #ddd; padding: 10px; width: 300px; text-align: center;">';
                echo '  <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['crop_name']) . '" width="100%" height="280">';
                echo '  <h2>' . htmlspecialchars($row['crop_name']) . '</h2>';
                echo '  <p>' . htmlspecialchars($row['description']) . '</p>';
                echo '  <p><strong>Price:</strong> $' . htmlspecialchars(number_format($row['price'], 2)) . ' per kg</p>';
                echo '  <form action="product_details.php" method="POST">';
                echo '      <input type="hidden" name="crop_id" value="' . $row['crop_id'] . '">';
                echo '      <input type="hidden" name="crop_name" value="' . htmlspecialchars($row['crop_name']) . '">';
                echo '      <input type="hidden" name="description" value="' . htmlspecialchars($row['description']) . '">';
                echo '      <input type="hidden" name="price" value="' . htmlspecialchars($row['price']) . '">';
                echo '      <input type="hidden" name="image" value="' . htmlspecialchars($row['image']) . '">';
                echo '      <button type="submit">View Details</button>';
                echo '  </form>';
                echo '</div>';
            }
        } else {
            echo '<p>No crops available.</p>';
        }
        ?>
    </div>
</body>
</html>
