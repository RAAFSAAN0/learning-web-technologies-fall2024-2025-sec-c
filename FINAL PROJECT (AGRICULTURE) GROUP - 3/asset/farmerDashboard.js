document.addEventListener("DOMContentLoaded", function () {
    const postForm = document.getElementById("postForm");
    const postsContainer = document.getElementById("postsContainer");

    // Fetch and display posts
    function fetchPosts() {
        fetch("../controller/get_posts.php")
            .then((response) => response.json())
            .then((data) => {
                postsContainer.innerHTML = "";
                if (data.success) {
                    data.posts.forEach((post) => {
                        const postDiv = document.createElement("div");
                        postDiv.classList.add("post");
                        postDiv.innerHTML = `
                            <h3>${post.title}</h3>
                            <p>${post.description}</p>
                            <img src="../${post.image_path}" alt="Post Image" style="width: 100%; max-width: 300px;">
                            <small>Posted on: ${post.created_at}</small>
                            <br>
                            <button class="delete-post" data-id="${post.id}">Delete</button>
                        `;
                        postsContainer.appendChild(postDiv);
                    });

                    // Add event listeners for delete buttons
                    document.querySelectorAll(".delete-post").forEach((button) => {
                        button.addEventListener("click", function () {
                            const postId = this.getAttribute("data-id");
                            deletePost(postId);
                        });
                    });
                } else {
                    postsContainer.innerHTML = `<p>No posts available.</p>`;
                }
            })
            .catch((error) => {
                console.error("Error fetching posts:", error);
            });
    }

    // Handle form submission
    postForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(postForm);

        fetch("../controller/save_post.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    postForm.reset();
                    fetchPosts();
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => {
                console.error("Error submitting post:", error);
            });
    });

    // Delete a post
    function deletePost(postId) {
        if (confirm("Are you sure you want to delete this post?")) {
            fetch("../controller/delete_post.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `post_id=${postId}`,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert(data.message);
                        fetchPosts();
                    } else {
                        alert(data.message);
                    }
                })
                .catch((error) => {
                    console.error("Error deleting post:", error);
                });
        }
    }

    // Initial fetch of posts
    fetchPosts();
});
