
        $(document).ready(function () {
            $('#changePasswordForm').on('submit', function (e)
            
            {
                e.preventDefault(); //Prevent the form from submitting the traditional way.

                let email = $('#email').val();
                let recent_password = $('#recent_password').val();
                let new_password = $('#new_password').val();
                let confirm_new_password = $('#confirm_new_password').val();

                
                if (new_password !== confirm_new_password) 
                
                {
                    $('#responseMessage').text('New passwords do not match!');
                    return;
                }

                // Send AJAX request
                $.ajax({
                    url: '../controller/consumer_settings.php',  
                    type: 'POST',
                    dataType: 'json',
                    data: 
                    {
                        email: email,
                        recent_password: recent_password,
                        new_password: new_password
                    },

                    success: function (response) 
                    
                    {
                        
                        if (response.success) 
                        
                        {
                            $('#responseMessage').text('Password has been updated successfully.');
                        } 
                        
                        else 
                        {
                            $('#responseMessage').text(response.message);
                        }
                    },
                    error: function () 
                    
                    {
                        $('#responseMessage').text('An error occurred while processing your request.');
                    }
                });
            });
        });
  