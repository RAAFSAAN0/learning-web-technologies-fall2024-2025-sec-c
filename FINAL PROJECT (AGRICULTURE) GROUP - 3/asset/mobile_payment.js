$(document).ready(function () {
    $("#paymentForm").submit(function (event) 
    
    
    {
        event.preventDefault(); 

        const formData = 
        
        {
            crop_id: $("#crop_id").val(),
            quantity: $("#quantity").val(),
            total_price: $("#total_price").val(),
            bank_account: $("#bank_account").val(),
            payment_type: $("#payment_type").val()
        };

        $.ajax({



            url: "../controller/retails_payment_controller.php",
            method: "POST",
            data: JSON.stringify(formData),
            contentType: "application/json",

            success: function (response) 
            
            
            {


                console.log("Response from server:", response);
                try 
                
                {
                    if (response && response.success) 
                    
                    {
                        alert("Payment successful!");
                        window.location.href = "#"; 
                    } 
                    else 
                    
                    {
                        const error_message = response.error_message || "An unknown error occurred.";
                        alert("Error: " + error_message);
                    }
                } 
                
                catch (e) 
                {
                    console.error("Error parsing the response:", e);
                    alert("Unexpected error occurred. Check the console for details.");
                }
            },


            error: function (xhr, status, error) 
            
            {
                console.error("AJAX Error:", error); 
                alert("An unexpected error occurred. Status: " + status + " Error: " + error);
            }
        });
    });
});