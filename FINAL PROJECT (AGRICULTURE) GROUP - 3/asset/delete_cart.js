$(document).ready(function() {
   
    $('.delete-btn').on('click', function() 
    
    
    {
        var cartId = $(this).data('cart-id');

        if (confirm('Are you sure you want to delete this item from your cart?')) 
            
            {
            $.ajax(
                
                
                {
                url: '../controller/delete_cart.php',
                type: 'POST',
                data: { cart_id: cartId },
                dataType: 'json', 

                success: function(response) 
                {
                    if (response.success)
                    {
                        
                        $('#cart-item-' + cartId).remove();
                        $('#message').html('<p style="color: green;">Item successfully removed from cart.</p>');
                    } else {
                        $('#message').html('<p style="color: red;">Error: ' + response.error + '</p>');
                    }
                },

                error: function() 
                
                {
                    $('#message').html('<p style="color: red;">An error occurred. Please try again.</p>');
                }
            });
        }
    });
});



























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
