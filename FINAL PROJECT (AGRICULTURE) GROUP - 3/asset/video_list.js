$(document).ready(function () 


{
            $('#searchInput').on('input', function () {
                let searchValue = $(this).val();
                $.ajax(
                    
                    {
                    url: '../controller/video_list_controller.php',
                    type: 'POST',
                    data: { search: searchValue },
                    success: function (data) {
                        $('#videoList').html(data);
                    },
                    error: function () {
                        alert('Error fetching data.');
                    }
                });
            });
        });
