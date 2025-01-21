document.addEventListener("DOMContentLoaded", () => {
    const cropTableBody = document.querySelector("#cropTable tbody");

    // Fetch crop data from the server
    fetch("../controller/view_crops.php")
        .then(response => response.json())
        .then(data => {
            cropTableBody.innerHTML = ""; // Clear any existing rows

            if (data.length > 0) {
                let tableContent = "";
                // Loop through the JSON data to create table rows
                data.forEach(crop => {
                    tableContent += `
                        <tr id="crop_${crop.id}">
                            <td>${crop.id}</td>
                            <td>${crop.crop_name}</td>
                            <td>${crop.crop_quantity}</td>
                            <td>${crop.crop_description}</td>
                            <td>${crop.created_at}</td>
                            <td>
                                <button class="delete-btn" data-id="${crop.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                cropTableBody.innerHTML = tableContent; // Add the rows to the table

                // Add event listener to all delete buttons
                document.querySelectorAll(".delete-btn").forEach(button => {
                    button.addEventListener("click", handleDelete);
                });
            } else {
                cropTableBody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center;">No posts available</td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error("Error fetching crop data:", error);
            cropTableBody.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align: center;">Failed to load data</td>
                </tr>
            `;
        });
});

// Handle delete action
function handleDelete(event) {
    const cropId = event.target.getAttribute('data-id');

    if (confirm("Are you sure you want to delete this crop post?")) {
        // Make AJAX request to delete the crop
        fetch("../controller/delete_crop_post.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id: cropId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the deleted row from the table
                const row = document.querySelector(`#crop_${cropId}`);
                row.remove();
            } else {
                alert("Failed to delete the post.");
            }
        })
        .catch(error => {
            console.error("Error deleting crop:", error);
            alert("An error occurred while deleting the post.");
        });
    }
}
