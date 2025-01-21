<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function validatePassword() {
            var newPassword = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_new_password").value;

            
            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{5,}$/;

            if (!passwordRegex.test(newPassword)) {
                alert("Password must be at least 5 characters long, containing at least one uppercase letter, one lowercase letter, and one number.");
                return false;
            }

            if (newPassword !== confirmPassword) {
                alert("New password and confirm password do not match.");
                return false;
            }

            return true;
        }

        $(document).ready(function() {
            $("form").on("submit", function(e)
            
            
            
            {
                e.preventDefault();

                if (!validatePassword()) {
                    return;
                }

                var formData = {
                    email: $("#email").val(),
                    recent_password: $("#recent_password").val(),
                    new_password: $("#new_password").val(),
                    confirm_new_password: $("#confirm_new_password").val()
                };

                $.ajax({
                    url: "../controller/change_password_controller.php",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) 
                    
                    
                    
                    {
                        if (response.success) {
                            alert(response.message);
                             window.location.href = "../view/login.html"
                        } else {
                            alert(response.error);
                            
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + error);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <h1>Change Password</h1>
    <form method="POST">
        <label for="email">Enter your email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="recent_password">Enter recent password:</label><br>
        <input type="password" id="recent_password" name="recent_password" required><br><br>

        <label for="new_password">Enter new password:</label><br>
        <input type="password" id="new_password" name="new_password" required><br><br>

        <label for="confirm_new_password">Confirm new password:</label><br>
        <input type="password" id="confirm_new_password" name="confirm_new_password" required><br><br>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
