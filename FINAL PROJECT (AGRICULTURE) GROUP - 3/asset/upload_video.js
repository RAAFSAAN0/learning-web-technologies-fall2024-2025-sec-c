document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("videoUploadForm");
    const responseMessage = document.getElementById("responseMessage");

    form.addEventListener("submit", (event) => {
        event.preventDefault(); // Prevent default form submission

        // Validate form inputs
        const title = document.getElementById("title").value.trim();
        const description = document.getElementById("description").value.trim();
        const video = document.getElementById("video").files[0];

        if (!title || !description || !video) {
            displayMessage("All fields are required.", "error");
            return;
        }

        // Check file size (limit to 100MB)
        if (video.size > 100 * 1024 * 1024) {
            displayMessage("File size exceeds 100MB limit.", "error");
            return;
        }

        // Create a FormData object to send form data
        const formData = new FormData();
        formData.append("title", title);
        formData.append("description", description);
        formData.append("video", video);

        // Send AJAX request
        fetch("../controller/process_video_upload.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayMessage(data.message, "success");
                form.reset(); // Clear the form
            } else {
                displayMessage(data.message, "error");
            }
        })
        .catch(error => {
            console.error("Error uploading video:", error);
            displayMessage("An error occurred while uploading the video.", "error");
        });
    });

    // Function to display messages
    function displayMessage(message, type) {
        responseMessage.textContent = message;
        responseMessage.className = type; // Add success/error class for styling
    }
});
