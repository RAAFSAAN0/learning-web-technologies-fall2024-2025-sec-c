document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("cropForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        const xhr = new XMLHttpRequest(); // Create an AJAX request
        xhr.open("POST", "../controller/submit_crop.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Prepare form data in URL-encoded format
        const cropName = document.getElementById("crop_name").value.trim();
        const cropQuantity = document.getElementById("crop_quantity").value.trim();
        const cropDescription = document.getElementById("crop_description").value.trim();

        const params = `crop_name=${encodeURIComponent(cropName)}&crop_quantity=${encodeURIComponent(cropQuantity)}&crop_description=${encodeURIComponent(cropDescription)}`;

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = xhr.responseText.trim(); // Get server response
                if (response === "success") {
                    alert("Crop post submitted successfully!");
        
                } else {
                    alert(response); // Show server error message
                }
            } else {
                alert("An error occurred while processing your request.");
            }
        };

        xhr.send(params); // Send the AJAX request
    });
});
