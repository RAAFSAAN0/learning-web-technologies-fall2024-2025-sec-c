<?php
$cart_items = include('../controller/cart_details_controller.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../asset/edit_cart.js" defer></script>
    <script src="../asset/delete_cart.js" defer></script>
    <script src="../asset/cart_details.js" defer></script>
</head>
<body>

<?php if (count($cart_items) > 0): ?>
    <h1>Your Cart</h1>
    <table border="1" cellpadding="10" style="width: 80%; margin: auto;">
        <tr>
            <th>Crop Name</th>
            <th>Quantity</th>
            <th>Price Per Kg</th>
            <th>Total Price</th>
            <th>Available Quantity</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($cart_items as $item): ?>
            <tr id="cart-item-<?= htmlspecialchars($item['cart_id']) ?>">
                <td><?= htmlspecialchars($item['crop_name']) ?></td>
                <td>
                    <input type="number" id="quantity-<?= htmlspecialchars($item['cart_id']) ?>" value="<?= htmlspecialchars($item['quantity']) ?>" min="1" max="<?= htmlspecialchars($item['available_quantity']) ?>" style="width: 50px; text-align: center;">
                </td>
                <td>$<?= htmlspecialchars(number_format($item['price_per_kg'], 2)) ?></td>
                <td id="total-price-<?= htmlspecialchars($item['cart_id']) ?>">$<?= htmlspecialchars(number_format($item['total_price'], 2)) ?></td>
                <td><span id="available-quantity-<?= htmlspecialchars($item['cart_id']) ?>"><?= htmlspecialchars($item['available_quantity']) ?></span> kg</td>
                <td>
                    <button type="button" class="update-quantity" data-cart-id="<?= htmlspecialchars($item['cart_id']) ?>" data-crop-id="<?= htmlspecialchars($item['crop_id']) ?>" data-available-quantity="<?= htmlspecialchars($item['available_quantity']) ?>" data-change="-1">-</button>
                    <button type="button" class="update-quantity" data-cart-id="<?= htmlspecialchars($item['cart_id']) ?>" data-crop-id="<?= htmlspecialchars($item['crop_id']) ?>" data-available-quantity="<?= htmlspecialchars($item['available_quantity']) ?>" data-change="1">+</button>
                    <form action="../controller/cart_confirm_purchase.php" method="POST" style="display: inline;">
                        <input type="hidden" name="cart_id" value="<?= htmlspecialchars($item['cart_id']) ?>">
                        <input type="hidden" name="crop_id" value="<?= htmlspecialchars($item['crop_id']) ?>">
                        <input type="hidden" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>">
                        <input type="hidden" name="total_price" value="<?= htmlspecialchars($item['total_price']) ?>" id="total-price-input-<?= htmlspecialchars($item['cart_id']) ?>">
                        <button type="submit" style="background-color: green; color: white;">Buy</button>
                    </form>

                    <!-- Delete Button -->
                    <button type="button" class="delete-btn" data-cart-id="<?= htmlspecialchars($item['cart_id']) ?>" style='background-color: red; color: white;'>Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>

<div id="message" style="text-align: center; margin-top: 20px;"></div>



</body>
</html>
