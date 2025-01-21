document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("farmer-profile-form");
    const editButton = document.getElementById("edit-button");
    const saveButton = document.getElementById("save-button");

    // Fetch profile data
    function fetchProfile() {
        fetch("../controller/get_farmer_profile.php")
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    const farmer = data.farmer;
                    document.getElementById("first_name").value = farmer.first_name;
                    document.getElementById("last_name").value = farmer.last_name;
                    document.getElementById("email").value = farmer.email;
                    document.getElementById("mobile").value = farmer.mobile;
                    document.getElementById("country").value = farmer.country;
                    document.getElementById("address").value = farmer.address;
                    document.getElementById("dob").value = farmer.dob;
                } else {
                    alert(data.message);
                }
            })
            .catch(() => alert("Failed to fetch profile data."));
    }

    // Enable edit mode
    editButton.addEventListener("click", function () {
        form.querySelectorAll("input").forEach((input) => input.removeAttribute("readonly"));
        editButton.style.display = "none";
        saveButton.style.display = "inline";
    });

    // Save changes
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        fetch("../controller/get_farmer_profile.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(() => alert("Failed to update profile."));
    });

    // Initialize profile data
    fetchProfile();
});
