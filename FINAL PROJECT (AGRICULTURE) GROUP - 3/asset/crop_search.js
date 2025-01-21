// File: asset/crop_search.js
document.addEventListener('DOMContentLoaded', function () {//wait until initial html fully loaded and parsed
    const searchBox = document.getElementById('searchBox');//storing the reference of html element with id
    const cropContainer = document.getElementById('cropContainer');

    searchBox.addEventListener('input', function ()
    
    
    {
        const query = searchBox.value.trim();

        fetch(`../controller/crop_controller.php?search=${encodeURIComponent(query)}`)//A built-in function that encodes special characters (e.g., spaces, ?, &) in a URL.
            
        
        
        .then(response => response.json())
            .then(crops => {
                cropContainer.innerHTML = '';//getting all the html content from cropcontainer

                if (crops.length > 0) {
                    crops.forEach(crop => 
                        
                        {
                        const cropItem = document.createElement('div');//creating dom element dynamically
                        
                        
                        cropItem.className = 'crop-item';
                        // cropItem.style.border = '1px solid #ddd';
                        // cropItem.style.padding = '10px';
                        // cropItem.style.width = '300px';
                        // cropItem.style.textAlign = 'center';

                        cropItem.innerHTML = `
                            <img src="${crop.image}" alt="${crop.crop_name}" width="100%" height="280">
                            <h2>${crop.crop_name}</h2>
                            <p>${crop.description}</p>
                            <p><strong>Price:</strong> $${parseFloat(crop.price).toFixed(2)} per kg</p>
                            <form action="product_details.php" method="POST">
                                <input type="hidden" name="crop_id" value="${crop.crop_id}">
                                <input type="hidden" name="crop_name" value="${crop.crop_name}">
                                <input type="hidden" name="description" value="${crop.description}">
                                <input type="hidden" name="price" value="${crop.price}">
                                <input type="hidden" name="image" value="${crop.image}">
                                <button type="submit">View Details</button>
                            </form>
                        `;

                        cropContainer.appendChild(cropItem);// A built-in DOM method that appends cropItem (the newly created crop block) to cropContainer.
                    });
                } else {
                    cropContainer.innerHTML = '<p>No crops found.</p>';
                }
            })


            .catch(error => console.error('Error fetching crops:', error));
    });
});
