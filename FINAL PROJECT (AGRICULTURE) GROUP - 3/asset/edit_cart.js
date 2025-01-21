$(document).ready(function () {
    
    $('.update-quantity').click(function () 
    
    {
        var button = $(this);
        var cartId = button.data('cart-id');
        var cropId = button.data('crop-id');
        var availableQuantity = button.data('available-quantity');
        var quantityInput = $('#quantity-' + cartId);
        var currentQuantity = parseInt(quantityInput.val(), 10);
        var change = button.data('change');
        var newQuantity = currentQuantity + change;

        
        if (newQuantity < 1) 
            
        {
        
            return;
        } 
        
        else if (newQuantity > availableQuantity) 
            
            
        {
            
            $('#message').text('Quantity exceeds available stock.');
            return;
        }

      
        quantityInput.val(newQuantity);

       
        $.ajax({


            url: '../controller/edit_cart.php',
            type: 'POST',
            dataType: 'json',
            data: 
            {
                cart_id: cartId,
                crop_id: cropId,
                quantity: newQuantity
            },
            success: function (response) 
            
            {
                if (response.success) 
                    
                {
                    
                    $('#total-price-' + cartId).text('$' + response.total_price.toFixed(2));

                    $('#total-price-input-' + cartId).val(response.total_price.toFixed(2));

                    
                    $('#message').text('Cart updated successfully!');
                } 
                else 
                
                {

                    $('#message').text(response.error);
                }
            },
            error: function () 
            {
                $('#message').text('An error occurred while updating the cart.');
            }
        });
    });


    $('form').submit(function () 
    
    {
        
        var cartId = $(this).find('input[name="cart_id"]').val();

        
        var updatedPrice = $('#total-price-' + cartId).text().replace('$', '');

        
        var updatedQuantity = $('#quantity-' + cartId).val();

        
        $(this).find('input[name="total_price"]').val(updatedPrice);
        $(this).find('input[name="quantity"]').val(updatedQuantity);
    });
});
