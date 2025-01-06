document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("#registration-form");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form submission for validation

        // Get form field values
        const firstName = document.getElementById("firstname").value.trim();
        const lastName = document.getElementById("lastname").value.trim();
        const email = document.getElementById("email").value.trim();
        const mobile = document.getElementById("mobile").value.trim();
        const password = document.getElementById("password").value.trim();
        const retypePassword = document.getElementById("repassword").value.trim();
        const role = document.querySelector("input[name='role']:checked"); // Ensuring role is selected
        const country = document.getElementById("country").value.trim();
        const address = document.getElementById("address").value.trim();
        const dob = document.getElementById("dob").value.trim();

        let errors = [];

        // Validate each field
        if (!firstName || !lastName || !email || !mobile || !password || !retypePassword || !role || !country || !address || !dob) {
            errors.push("All fields are required!");
        }

        if (password !== retypePassword) {
            errors.push("Passwords do not match!");
        }

        if (mobile.length < 11) {
            errors.push("Mobile number must be at least 11 digits long.");
        }

        if (new Date(dob) > new Date()) {
            errors.push("Date of birth cannot be greater than today's date.");
        }

        const emailRegex = /\S+@\S+\.\S+/;
        if (email && !emailRegex.test(email)) {
            errors.push("Enter a valid email address.");
        }

        if (errors.length > 0) {
            alert(errors.join("\n"));
            return;  // Prevent form submission
        }

        form.submit(); 
    });
});
