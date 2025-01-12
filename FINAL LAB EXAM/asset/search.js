function searchEmployees() {
    var searchQuery = $('#search').val(); 

  
    $.ajax({
        url: '../controller/search_controller.php', 
        method: 'GET',
        data: { query: searchQuery }, 
        success: function(response) 
        {
            $('#employee-table').html(response);
        }
    });
}
