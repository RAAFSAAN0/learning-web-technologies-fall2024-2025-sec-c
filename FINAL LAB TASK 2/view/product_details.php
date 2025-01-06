<?php
// Include the controller to get crop details and crop reviews
require_once('../controller/product_details_controller.php');

//include('navbar.php');


// Fetch crop reviews from the database
$crop_reviews = $crop_reviews ?? [];

// If crop details are fetched, continue, else show error message
$crop_details = $crop_details ?? null;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Details</title>
</head>
<body>
    <h1 style="text-align: center; margin-top: 20px;">Crop Details</h1>
    <div style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
        <?php if ($crop_details): ?>
            <div style="text-align: center;">
                <img src="<?= htmlspecialchars($crop_details['image_path']) ?>" alt="<?= htmlspecialchars($crop_details['crop_name']) ?>" style="width: 100%; max-width: 300px; height: auto; border-radius: 8px; margin-bottom: 20px;">
            </div>
            <h2 style="text-align: center; color: #333;"><?= htmlspecialchars($crop_details['crop_name']) ?></h2>
            <p><strong>Description:</strong> <?= htmlspecialchars($crop_details['description']) ?></p>
            <p><strong>Price:</strong> $<?= htmlspecialchars(number_format($crop_details['price'], 2)) ?> per kg</p>

            <!-- Add Quantity and Price Calculation -->
            <div style="text-align: center; margin-top: 20px;">
                <form action="../controller/cart_action.php" method="POST" style="display: inline;">
                    <input type="hidden" name="crop_id" value="<?= htmlspecialchars($crop_details['crop_id']) ?>">
                    <input type="hidden" name="action" value="add_to_cart">

                    <!-- Quantity control -->
                    <div style="margin-bottom: 15px;">
                        <label for="quantity">Quantity:</label>
                        <button type="button" onclick="updateQuantity(-1)">-</button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="100" style="width: 60px; text-align: center; margin: 0 10px;" readonly>
                        <button type="button" onclick="updateQuantity(1)">+</button>
                    </div>

                    <!-- Total Price display -->
                    <div>
                        <p><strong>Total Price: $<span id="totalPrice"><?= htmlspecialchars(number_format($crop_details['price'], 2)) ?></span></strong></p>
                    </div>

                    <!-- Add to Cart Button -->
                    <button type="submit" style="padding: 10px 20px; margin-top: 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button>
                </form>

                <!-- Buy Now Button -->
                <form action="product_purchase.php" method="POST" style="display: inline;">
                    <input type="hidden" name="crop_id" value="<?= htmlspecialchars($crop_details['crop_id']) ?>">
                    <input type="hidden" name="quantity" id="buy_quantity" value="1">
                    <input type="hidden" name="total_price" id="buy_total_price" value="<?= htmlspecialchars($crop_details['price']) ?>">
                    <button type="submit" style="padding: 10px 20px; margin-top: 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Buy Now</button>
                </form>
            </div>

            <!-- Back to List Button -->
            <div style="text-align: center; margin-top: 20px;">
                <a href="buy_product.php" style="text-decoration: none; padding: 10px 20px; background-color: #6c757d; color: white; border-radius: 5px;">Back to List</a>
            </div>

            <!-- Crop Reviews Section -->
            <hr>
            <h3 style="text-align: center;">Reviews for <?= htmlspecialchars($crop_details['crop_name']) ?></h3>
            <div>
                <?php if (count($crop_reviews) > 0): ?>
                    <?php foreach ($crop_reviews as $review): ?>
                        <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
                            <p><strong><?= htmlspecialchars($review['user_type']) ?>: <?= htmlspecialchars($review['user_name']) ?></strong></p>
                            <p><?= nl2br(htmlspecialchars($review['review_text'])) ?></p>
                            <p><small>Reviewed on: <?= date("F j, Y, g:i a", strtotime($review['review_date'])) ?></small></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews yet.</p>
                <?php endif; ?>

                <!-- Review Form -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <h4>Add a Review</h4>
                    <form method="POST" action="../controller/review_action.php">
                        <textarea name="review_text" rows="4" cols="50" required placeholder="Write your review here..."></textarea><br>
                        <input type="hidden" name="crop_id" value="<?= htmlspecialchars($crop_details['crop_id']) ?>">
                        <button type="submit" style="padding: 10px 20px; margin-top: 10px; background-color: #28a745; color: white; border: none; border-radius: 5px;">Submit Review</button>
                    </form>
                <?php else: ?>
                    <p><a href="login.html">Login</a> to leave a review.</p>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <p style="color: red; text-align: center;">Crop details are not available.</p>
        <?php endif; ?>
    </div>

    <script>
        function updateQuantity(change) {
            var quantityInput = document.getElementById('quantity');
            var currentQuantity = parseInt(quantityInput.value);
            var maxQuantity = parseInt(quantityInput.getAttribute('max'));

            if (change === -1 && currentQuantity > 1) {
                quantityInput.value = currentQuantity - 1;
            } else if (change === 1 && currentQuantity < maxQuantity) {
                quantityInput.value = currentQuantity + 1;
            }

            updateTotalPrice();
        }

        function updateTotalPrice() {
            var pricePerKg = <?= htmlspecialchars($crop_details['price']) ?>;
            var quantity = parseInt(document.getElementById('quantity').value);
            var totalPrice = pricePerKg * quantity;
            document.getElementById('totalPrice').innerText = totalPrice.toFixed(2);

            document.getElementById('buy_quantity').value = quantity;
            document.getElementById('buy_total_price').value = totalPrice.toFixed(2);
        }
    </script>
</body>
</html>
