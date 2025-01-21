$(document).ready(function () {
    // Listen for keyup events on the search input
    $('#searchInput').on('keyup', function () {
        const searchQuery = $(this).val();
        fetchVideos(searchQuery);
    });

    // Function to fetch videos via AJAX (using POST method)
    function fetchVideos(search = '') {
        $.ajax({
            url: '../controller/video_list_controller.php',
            type: 'POST', 
            data: { search: search }, 
            success: function (response) {
                $('#videoList').html(response);
            },
            error: function () {
                alert('An error occurred while fetching videos.');
            }
        });
    }
});
