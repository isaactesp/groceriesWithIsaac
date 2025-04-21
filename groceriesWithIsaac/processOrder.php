<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "assignment1");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}



// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    echo "<script>alert('Your cart is empty. Redirecting to the cart page.'); window.location.replace('cart.php');</script>";
    exit;
}

// Process the order
$cart_items = $_SESSION['cart'];
foreach ($cart_items as $product_id) {
    $quantity = $_SESSION['cart_quantities'][$product_id]; // Default to 1 if quantity is not set

    // Check if the product has enough stock
    $stock_query = "SELECT in_stock, product_name FROM products WHERE product_id = $product_id";
    $stock_result = mysqli_query($conn, $stock_query);
    $stock_row = mysqli_fetch_assoc($stock_result);

    $stock_available = (int)$stock_row['in_stock'];
    $quantity_requested = (int)$quantity;
    if ($stock_available < $quantity_requested) {
        $product_name = htmlspecialchars($stock_row['product_name']); // Escape the product name for safety
        
        // Set a session flag to indicate a stock issue
        $_SESSION['stock_issue'] = true;
        
        echo "<script>alert('Not enough stock for product: $product_name. Redirecting to the cart page.'); window.location.replace('cart.php');</script>";
        exit;
    }

    // Update the stock
    $update_query = "UPDATE products SET in_stock = in_stock - $quantity WHERE product_id = $product_id";
    mysqli_query($conn, $update_query);
}

// Redirect to the confirmation page
$email = htmlspecialchars($_POST['email'] ?? ''); // Get the email from the form 
header("Location: confirmationOrder.php?email=" . urlencode($email));
exit;
?>