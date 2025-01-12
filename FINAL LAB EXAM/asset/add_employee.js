$(document).ready(function () {
    $('#edit-employee-form').on('submit', function (e) {
        e.preventDefault(); 

        var formData = $(this).serialize();

        $.ajax({
            url: '../controller/edit_employee_controller.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                window.location.href = 'show_user_view.php';
            },
            error: function() {
                alert('An error occurred while updating employee data.');
            }
        });
    });
});
