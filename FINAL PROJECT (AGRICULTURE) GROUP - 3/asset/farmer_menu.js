document.addEventListener("DOMContentLoaded", function () {
    const menuLinks = document.querySelectorAll("#menu-links a");
    const contentContainer = document.getElementById("content-container");

    // Function to load content
    function loadPage(page) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", page, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                contentContainer.innerHTML = xhr.responseText;
            } else {
                contentContainer.innerHTML = `<p>Unable to load page. Please try again later.</p>`;
            }
        };
        xhr.send();
    }

    // Add click event to menu links
    menuLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior
            const page = this.getAttribute("data-page");
            loadPage(page); // Load the clicked page
        });
    });

    // Load the first page by default
    if (menuLinks.length > 0) {
        loadPage(menuLinks[0].getAttribute("data-page"));
    }
});
