$(document).ready(function () {
    $('#edit-employee-form').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: '../controller/edit_employee_controller.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === 'success') {
                    window.location.href = '../view/show_employees_view.php';
                } else {
                    alert('Error updating employee data.');
                }
            },
            error: function() {
                alert('An error occurred while updating employee data.');
            }
        });
    });
});
