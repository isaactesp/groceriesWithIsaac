function searchProducts(event) {
    /* This function handles the search functionality based on the input of the user.*/
        // Prevent the submission by default
        event.preventDefault();
    
        const searchQuery = document.getElementById('searchInput').value.trim();
        if (searchQuery === '') {
            alert('Please enter a search term.');
            return;
        }
    
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `fetchProducts.php?search=${encodeURIComponent(searchQuery)}`, true);
    
        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('product-container').innerHTML = xhr.responseText;
                
                // Update the <h1> element dynamically
                const h1elem = document.querySelector('h1');
                h1elem.textContent = `Results for the search "${searchQuery}"`;
    
                // Dispatch a custom event to notify that products have been loaded
                const event = new Event('productsLoaded');
                document.dispatchEvent(event);
            } else {
                console.error('Failed to fetch products.');
            }
        };
    
        xhr.onerror = function () {
            console.error('An error occurred during the AJAX request.');
        };
    
        xhr.send();
    }
    // Function to attach event listeners to the search form
    document.getElementById('searchForm').addEventListener('submit', searchProducts);