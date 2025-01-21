$(document).ready(function () {//built in jquery
    $(".product-form").on("submit", function (e) {
        e.preventDefault();//this is for Prevent the default form submission

        const formData = {
            crop_id: $(this).data("crop-id"),
            crop_name: $(this).data("crop-name"),
            description: $(this).data("description"),
            price: $(this).data("price"),
            image: $(this).data("image"),
        };



 $.ajax(//built in jquery function
    {
            type: "POST",
            url: "../view/product_details.php",
            data: formData,
            success: function (response) 
            {
                window.location.href = "product_details.php";
            },
            error: function () {
                alert("There was an error submitting the form.");
            },
        });
    });
});
