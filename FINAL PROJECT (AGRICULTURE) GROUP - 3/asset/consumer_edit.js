function validateForm() {
    var dob = document.forms["editProfileForm"]["dob"].value;
    var today = new Date().toISOString().split('T')[0];

    if (dob > today) {
        alert("Date of Birth cannot be in the future.");
        return false;
    }

    return true;
}