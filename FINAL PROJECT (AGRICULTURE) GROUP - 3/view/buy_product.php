<?php
 include('../view/navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="../asset/crop_search.js" defer></script> 
    <script src="../asset/buy_product.js" defer></script> 
</head>
<body>
    <h1>Available Crops</h1>

    <!-- Search Box -->
    <div style="text-align: center; margin-bottom: 20px;">
        <input type="text" id="searchBox" placeholder="Search for crops..." style="width: 300px; padding: 10px; border: 1px solid #ddd;">
    </div>

    <div id="cropContainer" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        <?php
        session_start();
        require_once('../controller/crop_controller.php');

        $crops = getCrops();

        if (count($crops) > 0) {
            foreach ($crops as $row) {
                echo '<div class="crop-item" style="border: 1px solid #ddd; padding: 10px; width: 300px; text-align: center;">';
                echo '  <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['crop_name']) . '" width="100%" height="280">';
                echo '  <h2>' . htmlspecialchars($row['crop_name']) . '</h2>';
                echo '  <p>' . htmlspecialchars($row['description']) . '</p>';
                echo '  <p><strong>Price:</strong> $' . htmlspecialchars(number_format($row['price'], 2)) . ' per kg</p>';
                echo '  <form class="product-form" data-crop-id="' . $row['crop_id'] . '" data-crop-name="' . htmlspecialchars($row['crop_name']) . '" data-description="' . htmlspecialchars($row['description']) . '" data-price="' . htmlspecialchars($row['price']) . '" data-image="' . htmlspecialchars($row['image']) . '">';
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
