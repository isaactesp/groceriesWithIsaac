// Function to add an item to the cart using AJAX
function addToCart(event) {
    const button = event.target;
    const productId = button.getAttribute('data-id');

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'cartHandler.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    console.log('Server Response:', response); // Debugging log
                    if (response.status === 'success') {
                        alert('Product added to cart!');
                    } else {
                        alert(response.message || xhr.statusText);
                    }
                } catch (error) {
                    console.error('Error parsing JSON response:', error);
                    alert('An error occurred while processing your request.');
                }
            } else {
                console.error('Request failed with status:', xhr.status);
                alert('Failed to communicate with the server. Please try again.');
            }
        }
    };

    const formData = `action=add&product_id=${encodeURIComponent(productId)}`;
    xhr.send(formData);
}

// Function to attach event listeners to "Add to Cart" buttons
function attachAddToCartListeners() {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.removeEventListener('click', addToCart); // Remove any existing listener to avoid duplicates
        button.addEventListener('click', addToCart);
    });
}

// Attach event listeners to "Add to Cart" buttons on page load
attachAddToCartListeners();

// Reattach event listeners after products are dynamically loaded
document.addEventListener('productsLoaded', () => {
    attachAddToCartListeners();
});