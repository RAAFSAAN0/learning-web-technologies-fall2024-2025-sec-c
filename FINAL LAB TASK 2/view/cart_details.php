<?php
$cart_items = include('../controller/cart_details_controller.php'); // Including the controller to fetch data

//


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
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
            <tr>
                <td><?= htmlspecialchars($item['crop_name']) ?></td>
                <td><?= htmlspecialchars($item['quantity']) ?></td>
                <td>$<?= htmlspecialchars(number_format($item['price_per_kg'], 2)) ?></td>
                <td>$<?= htmlspecialchars(number_format($item['total_price'], 2)) ?></td>
                <td><?= htmlspecialchars($item['available_quantity']) ?> kg</td>
                <td>
                    <!-- Update Form -->
                    <form action='../controller/edit_cart.php' method='POST' style='display: inline;'>
                        <input type='hidden' name='cart_id' value='<?= htmlspecialchars($item['cart_id']) ?>'>
                        <input type='hidden' name='crop_id' value='<?= htmlspecialchars($item['crop_id']) ?>'>
                        <input type='hidden' name='available_quantity' value='<?= htmlspecialchars($item['available_quantity']) ?>'>
                        <div style='display: flex; align-items: center; gap: 5px;'>
                            <button type='button' onclick='updateQuantity(this, -1, <?= htmlspecialchars($item['available_quantity']) ?>)'>-</button>
                            <input type='number' name='quantity' value='<?= htmlspecialchars($item['quantity']) ?>' min='1' max='<?= htmlspecialchars($item['available_quantity']) ?>' readonly style='width: 50px; text-align: center;'>
                            <button type='button' onclick='updateQuantity(this, 1, <?= htmlspecialchars($item['available_quantity']) ?>)'>+</button>
                            <button type='submit' style='margin-left: 10px;'>Update</button>
                        </div>
                    </form>
                    <!-- Delete Form -->
                    <form action='../controller/delete_cart.php' method='POST' style='display: inline;'>
                        <input type='hidden' name='cart_id' value='<?= htmlspecialchars($item['cart_id']) ?>'>
                        <button type='submit' style='margin-left: 10px; background-color: red; color: white;'>Delete</button>
                    </form>
                    <!-- Buy Form -->
                    <form action='../controller/cart_confirm_purchase.php' method='POST' style='display: inline;'>
                        <input type='hidden' name='cart_id' value='<?= htmlspecialchars($item['cart_id']) ?>'>
                        <input type='hidden' name='crop_id' value='<?= htmlspecialchars($item['crop_id']) ?>'>
                        <input type='hidden' name='quantity' value='<?= htmlspecialchars($item['quantity']) ?>'>
                        <input type='hidden' name='total_price' value='<?= htmlspecialchars($item['total_price']) ?>'>
                        <button type='submit' style='margin-left: 10px; background-color: green; color: white;'>Buy</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p style='text-align: center;'>Your cart is empty.</p>
<?php endif; ?>

<script>
    function updateQuantity(button, change, maxQuantity) {
        const inputField = button.parentNode.querySelector('input[name="quantity"]');
        const currentValue = parseInt(inputField.value);
        const newValue = currentValue + change;

        if (newValue >= 1 && newValue <= maxQuantity) {
            inputField.value = newValue;
        } else {
            alert('Invalid quantity! Please stay within the available range.');
        }
    }
</script>

</body>
</html>
