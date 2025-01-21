<?php
// Include the controller to get crop details and crop reviews
require_once('../controller/product_details_controller.php');

// Fetch crop reviews from the database
$crop_reviews = $crop_reviews ?? [];

// If crop details are fetched, continue; else show error message
$crop_details = $crop_details ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Details</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../asset/product_details.js"></script> <!-- Link to the external JS file -->
</head>
<body>
    <h1 style="text-align: center; margin-top: 20px;">Crop Details</h1>

    <div style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
        <?php if ($crop_details): ?>
            <div style="text-align: center;">
                <img src="<?= htmlspecialchars($crop_details['image_path']) ?>" 
                     alt="<?= htmlspecialchars($crop_details['crop_name']) ?>" 
                     style="width: 100%; max-width: 300px; height: auto; border-radius: 8px; margin-bottom: 20px;">
            </div>
            <h2 style="text-align: center; color: #333;"><?= htmlspecialchars($crop_details['crop_name']) ?></h2>
            <p><strong>Description:</strong> <?= htmlspecialchars($crop_details['description']) ?></p>
            <p><strong>Price:</strong> $<?= htmlspecialchars(number_format($crop_details['price'], 2)) ?> per kg</p>
            <p>Available Quantity: <span id="available_quantity"><?= htmlspecialchars($crop_details['available_quantity']) ?></span></p>
            <input type="hidden" id="crop_id" value="<?= htmlspecialchars($crop_details['crop_id']) ?>">

            <!-- Quantity control -->
            <div style="text-align: center; margin-top: 20px;">
                <label for="quantity">Quantity:</label>
                <button type="button" id="decrement_quantity">-</button>
                <input type="number" id="quantity" value="1" min="1" max="<?= htmlspecialchars($crop_details['available_quantity']) ?>" 
                       style="width: 60px; text-align: center; margin: 0 10px;" readonly>
                <button type="button" id="increment_quantity">+</button>
            </div>

            <!-- Total Price Display -->
            <p style="text-align: center;"><strong>Total Price: $<span id="totalPrice" data-price="<?= htmlspecialchars($crop_details['price']) ?>">
                <?= htmlspecialchars(number_format($crop_details['price'], 2)) ?>
            </span></strong></p>

            <div style="text-align: center; margin-top: 20px;">
                <!-- Add to Cart Button -->
                <button type="button" id="addToCartBtn" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button>

                <!-- Buy Now Button -->
                <button type="button" id="buyNowBtn" style="padding: 10px 20px; margin-top: 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Buy Now</button>
            </div>

            

            <!-- Reviews Section -->
            <div style="margin-top: 30px; background-color: #f1f1f1; padding: 20px; border-radius: 8px;">
            <h4>Add a Review</h4>
            <textarea id="review_text" rows="4" cols="50" placeholder="Write your review here..." required style="width: 100%; padding: 10px; border-radius: 5px;"></textarea><br><br>
            <button id="submitReviewBtn" style="padding: 10px 20px; background-color: #17a2b8; color: white; border: none; border-radius: 5px; cursor: pointer;">Submit Review</button>
        </div>
                <h3>Customer Reviews</h3>
                <div id="reviews-list" style="margin-bottom: 20px;">
                    <?php if (!empty($crop_reviews)): ?>
                        <?php foreach ($crop_reviews as $review): ?>
                            <div style="margin-bottom: 10px; padding: 10px; border-bottom: 1px solid #ddd;">
                                <strong><?= htmlspecialchars($review['user_name']) ?></strong>
                                <p><?= htmlspecialchars($review['review_text']) ?></p>
                                <small style="color: #888;"><?= htmlspecialchars($review['review_date']) ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No reviews yet. Be the first to review!</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Add Review Form -->
            

        <!-- Back to List Button -->
        <div style="text-align: center; margin-top: 20px;">
            <a href="buy_product.php" style="text-decoration: none; padding: 10px 20px; background-color: #6c757d; color: white; border-radius: 5px;">Back to List</a>
        </div>

        <?php else: ?>
            <p style="color: red; text-align: center;">Crop details are not available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
