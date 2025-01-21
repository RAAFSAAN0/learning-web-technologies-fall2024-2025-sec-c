document.getElementById('submit-btn').addEventListener('click', function () {
    
    
    
  
    const formData = {
        first_name: document.getElementById('firstname').value,
        last_name: document.getElementById('lastname').value,
        email: document.getElementById('email').value,
        mobile: document.getElementById('mobile').value,
        password: document.getElementById('password').value,
        retype_password: document.getElementById('repassword').value,
        role: document.querySelector('input[name="role"]:checked')?.value,
        country: document.getElementById('country').value,
        address: document.getElementById('address').value,
        dob: document.getElementById('dob').value
    };

  
    if (!validateEmail(formData.email)) {
        alert("Invalid email address.");
        return;
    }


    fetch('../controller/registrationcheck.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },


        body: JSON.stringify(formData)
    })
    .then(response => response.json())


    
    .then(responseData => {
        if (responseData.success) {
            alert("Registration successful!");
            window.location.href = "../view/login.html";
        } else {
            alert(responseData.error || "Registration failed!");
        }
    })



    .catch(error => {
        console.error("Error during registration:", error);
        alert("An unexpected error occurred. Please try again.");
    });
});

//this is Password validation
const passwordField = document.getElementById('password');
passwordField.addEventListener('input', function () {
    const password = passwordField.value;
    const passwordMessage = document.getElementById('password-message');
    if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{4,}$/.test(password)) 
    
    {
        passwordMessage.textContent = "Valid password!";
    } else {
        passwordMessage.textContent = "Password must have at least 4 characters, including uppercase, lowercase, and a number.";
    }
});

// this part is for Password confirmation validation
const repasswordField = document.getElementById('repassword');
repasswordField.addEventListener('input', function () {
    const repasswordMessage = document.getElementById('repassword-message');
    if (passwordField.value === repasswordField.value)
        
        {
        repasswordMessage.textContent = "Passwords match!";
    } else {
        repasswordMessage.textContent = "Passwords do not match!";
    }
});

//this par is for email validation
const emailField = document.getElementById('email');
emailField.addEventListener('input', function () {
    const emailMessage = document.getElementById('email-message');
    if (validateEmail(emailField.value)) {
        emailMessage.textContent = "Valid email!";
    } else {
        emailMessage.textContent = "Invalid email format!";
    }
});

// email validation function
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
