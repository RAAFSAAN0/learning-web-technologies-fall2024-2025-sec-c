$(document).ready(function () {
    $('#paymentForm').on('submit', function (e) {
        e.preventDefault(); //Prevent the default form submission

        // Send an AJAX POST request
        $.ajax({
            url: '../controller/confirm_purchase_controller.php',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),//input values into url encodded string for safe passaging
            success: function (response) {
                if (response.redirect)
                    
                    
                {
                
                    window.location.href = response.redirect;
                }
                else if (response.message) 
                {
                  
                    $('#responseMessage').text(response.message);
                }
            },
            
            error: function (xhr, status, error) 
            
            {
                $('#responseMessage').text('Error: ' + error);
            }
        });
    });
});
