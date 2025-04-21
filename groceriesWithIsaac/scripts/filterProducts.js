function filterProducts(filter) {
    /* This function handles filtering products dynamically based on the provided filter.
    It sends an AJAX request to `fetchProducts.php` with the filter parameters and updates 
    the product grid on the webpage with the filtered results. Filters can be type or subtype, 
    depending on the provided filter string. Additionally, it updates the <h1> title 
    dynamically to reflect the current filter
    */
        const xhttp = new XMLHttpRequest();
        xhttp.open("GET", `fetchProducts.php?${filter}`, true);
    
        xhttp.onload = function () {
            if (xhttp.status === 200 && xhttp.readyState === 4) {
                document.getElementById("product-container").innerHTML = xhttp.responseText;
    
                // Update the H1 title dynamically
                const params = new URLSearchParams(filter);
                const type = params.get('type');
                const subtype = params.get('subtype');
                const h1elem = document.querySelector('h1');
    
                if (type && subtype) {
                    h1elem.textContent = `${type} > ${subtype}`;
                } else if (type) {
                    h1elem.textContent = `${type}`;
                }
    
                // Dispatch a custom event to notify that products have been loaded
                const event = new Event('productsLoaded');
                document.dispatchEvent(event);
            } else {
                console.error('Failed to fetch products.');
            }
        };
    
        xhttp.onerror = function () {
            console.error('An error occurred during the AJAX request.');
        };
    
        xhttp.send();
    }