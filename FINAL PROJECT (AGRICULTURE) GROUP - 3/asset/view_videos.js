document.addEventListener("DOMContentLoaded", function () {
    const videoList = document.getElementById("video-list");

    // Fetch videos from the server
    function fetchVideos() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../controller/view_videos.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    displayVideos(response.videos);
                } else {
                    videoList.innerHTML = `<p>${response.message}</p>`;
                }
            } else {
                videoList.innerHTML = "<p>Failed to load videos.</p>";
            }
        };
        xhr.send();
    }

    // Display videos in the DOM
    function displayVideos(videos) {
        if (videos.length === 0) {
            videoList.innerHTML = "<p>No videos found.</p>";
            return;
        }

        let html = "";
        videos.forEach(function (video) {
            html += `
                <div class="video-container">
                    <h3>${video.title}</h3>
                    <p>${video.description}</p>
                    <video controls>
                        <source src="${video.video_path}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p>Uploaded on: ${video.upload_date}</p>
                    <button onclick="deleteVideo(${video.id})">Delete</button>
                </div>
            `;
        });
        videoList.innerHTML = html;
    }

    // Delete video
    window.deleteVideo = function (videoId) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../controller/view_videos.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    fetchVideos(); // Refresh the video list
                } else {
                    alert(response.message);
                }
            } else {
                alert("Failed to delete the video.");
            }
        };
        xhr.send("action=delete&video_id=" + videoId);
    };

    // Initial fetch of videos
    fetchVideos();
});
