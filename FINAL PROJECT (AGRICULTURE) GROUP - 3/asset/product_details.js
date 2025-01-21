$(document).ready(function () 


{
    const basePrice = parseFloat($('#totalPrice').data('price'));
    let availableQuantity = parseInt($('#available_quantity').text());
    let currentQuantity = parseInt($('#quantity').val());
    const cropId = $('#crop_id').val(); // Fetch crop ID from the hidden field

    function updateTotalPrice() 
    
    
    {
        const totalPrice = (basePrice * currentQuantity).toFixed(2);
        $('#totalPrice').text(totalPrice);
    }

    $('#increment_quantity').on('click', function () {
        if (currentQuantity < availableQuantity) {
            currentQuantity++;
            $('#quantity').val(currentQuantity);
            availableQuantity--;
            $('#available_quantity').text(availableQuantity);
            updateTotalPrice();
        } else 
        
        
        {
            alert('Cannot exceed available quantity!');
        }
    });

   
    $('#decrement_quantity').on('click', function () 
    
    {
        if (currentQuantity > 1) 
            
        {
            currentQuantity--;
            $('#quantity').val(currentQuantity);
            availableQuantity++;
            $('#available_quantity').text(availableQuantity);
            updateTotalPrice();
        } 
        
        else 
        
        {
            alert('Quantity cannot be less than 1!');
        }
    });

   
    $('#addToCartBtn').on('click', function () 
    
    {
        const quantityToAdd = currentQuantity;

        $.ajax({
            url: '../controller/cart_action.php',
            type: 'POST',
            data: {
                crop_id: cropId,
                quantity: quantityToAdd
            },
            success: function (response) 
            
            
            {
                const result = JSON.parse(response);
                if (result.success) 
                {
                    alert('Item added to cart successfully!');
                } else 
                
                {
                    alert(result.error);
                }
            },
            error: function () 
            
            {
                alert('An error occurred while adding the item to the cart.');
            }
        });
    });

   
    $('#buyNowBtn').on('click', function () {
        const quantityToBuy = currentQuantity;
        const totalPriceToBuy = (basePrice * currentQuantity).toFixed(2);

        $.ajax({
            url: '../view/product_purchase.php',
            type: 'POST',
            data: {
                crop_id: cropId,
                quantity: quantityToBuy,
                total_price: totalPriceToBuy
            },
            success: function (response) 
            
            {
                const result = JSON.parse(response);
                if (result.success) 
                    
                    
                    {
                    window.location.href = 'confirm_purchase.php';
                } else {
                    alert('An error occurred while processing the purchase.');
                }
            },
            error: function () 
            
            {
                alert('An error occurred while processing the purchase.');
            }
        });
    });

     // Submit Review with AJAX
     $('#submitReviewBtn').on('click', function () {
        const reviewText = $('#review_text').val().trim();
        if (reviewText === '') 
            {
            alert('Review text cannot be empty!');
            return;
        }

        $.ajax({
            url: '../controller/review_action.php',
            type: 'POST',
            data: {
                crop_id: cropId,
                review_text: reviewText
            },
            success: function (response) 
            
            
            {
                const result = JSON.parse(response);
                if (result.success) {
                   
                    $('#reviews-list').prepend(`
                        <div style="margin-bottom: 10px; padding: 10px; border-bottom: 1px solid #ddd;">
                            <strong>You</strong>
                            <p>${reviewText}</p>
                        </div>
                    `);
                    $('#review_text').val('');  
                } else {
                    alert('An error occurred while submitting your review.');
                }
            },
            error: function () 
            
            {
                alert('An error occurred while submitting your review.');
            }
        });
    });

    updateTotalPrice();
});
