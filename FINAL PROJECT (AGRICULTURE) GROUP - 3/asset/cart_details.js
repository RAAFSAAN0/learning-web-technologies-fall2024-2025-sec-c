
$(document).ready(function () {
    // Function to update available quantity in the database
    function updateAvailableQuantity(cropId, availableQuantity) 
    
    
    {
        $.ajax({
            url: '../controller/update_quantity.php',
            type: 'POST',
            data: {
                crop_id: cropId,
                available_quantity: availableQuantity
            },



            success: function (response) 
            
            {
                const result = JSON.parse(response);
                if (!result.success) 

                {
                    alert('Failed to update the quantity in the database: ' + result.message);
                }
            },
            error: function ()
            {
                alert('An error occurred while updating the database.');
            },
        });
    }

    // Handle increment and decrement quantity buttons
    $('.update-quantity').on('click', function () 
    
    {
        const cartId = $(this).data('cart-id');
        const cropId = $(this).data('crop-id');
        const availableQuantity = parseInt($('#available-quantity-' + cartId).text());
        let currentQuantity = parseInt($('#quantity-' + cartId).val());
        const change = $(this).data('change');

        if (change === 1 && currentQuantity < availableQuantity) {
            currentQuantity++;
        } else if (change === -1 && currentQuantity > 1) {
            currentQuantity--;
        }

        $('#quantity-' + cartId).val(currentQuantity);
        $('#available-quantity-' + cartId).text(availableQuantity - (change === 1 ? 1 : -1));

        // Send the updated quantity to the server
        updateAvailableQuantity(cropId, availableQuantity - (change === 1 ? 1 : -1));
    });
});
