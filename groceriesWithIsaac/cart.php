<?php
session_start();

// Prevent caching of this page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$conn = mysqli_connect("localhost", "root", "", "assignment1");

if (!$conn) {
    die("Could not connect to MySQL: " . mysqli_connect_error());
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (!isset($_SESSION['cart_quantities'])) {
    $_SESSION['cart_quantities'] = [];
}

$product_id = 0; // Initialize product_id to avoid undefined variable notice

// Handle remove and update actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null; // Use null if product_id is not set
    $_SESSION['cart'] = array_map('intval', $_SESSION['cart']); // Ensure all IDs in the session are integers
 
    if ($_POST['action'] === 'remove' ) {
        // Remove the product from the cart
        $key = array_search($product_id, $_SESSION['cart'], true); // Use strict comparison
        if ($key !== false) {
            unset($_SESSION['cart'][$key]); // Remove the product
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
            unset($_SESSION['cart_quantities'][$product_id]); // Remove the quantity entry
            $message = "Product removed from cart!";
        } else {
            $message = "Product not found in cart!";
        }
    } elseif ($_POST['action'] === 'update') {
        // Update the quantity of the product in the cart
        $new_quantity = (int)$_POST['quantity'];
        if ($new_quantity > 0) {
            if (in_array($product_id, $_SESSION['cart'], true)) {
                $_SESSION['cart_quantities'][$product_id] = $new_quantity; // Update the quantity
                $message = "Quantity updated!";
            } else {
                $message = "Product not found in cart!";
            }
        } else {
            $message = "Invalid quantity!";
        }
    } elseif ($_POST['action'] === 'clear') {
        // Clear the entire cart
        $_SESSION['cart'] = [];
        $_SESSION['cart_quantities'] = [];
        $message = "Cart cleared!";
    }
}
$total_price=0; // Initialize totall price
// Fetch cart items
$cart_items = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_map('intval', $_SESSION['cart'])); // Ensure all IDs are integers
    $query = "SELECT product_id, product_name, unit_price, unit_quantity FROM products WHERE product_id IN ($ids)";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $row['quantity'] = $_SESSION['cart_quantities'][$row['product_id']];
        $row['total_price'] = $row['unit_price'] * $row['quantity']; // Calculate total price for the item
        $total_price += $row['total_price']; // Add to the total cart price
        $cart_items[] = $row;
    }
}

// Generate cart HTML
function generateCartHTML($cart_items) {
    if (empty($cart_items)) {
        return '<p>Your cart is empty.</p>';
    }

    $html = '';
    foreach ($cart_items as $item) {
        $html .= '<div class="product">';
        $html .= '<img src="images/' . strtolower(str_replace(' ', '_', $item['product_name'])) . '.png" alt="' . htmlspecialchars($item['product_name']) . '" class="product-image">';
        $html .= '<h3>' . htmlspecialchars($item['product_name']) . '</h3>';
        $html .= '<p>Price: $' . htmlspecialchars($item['unit_price']) . '</p>';
        $html .= '<p>Unit quantity: '.$item["unit_quantity"].'</p>';

        $html .= '<form method="post" action="cart.php">';
        $html .= '<input type="hidden" name="action" value="update">';
        $html .= '<input type="hidden" name="product_id" value="' . htmlspecialchars($item['product_id']) . '">';
        $html .= '<label for="quantity-' . htmlspecialchars($item['product_id']) . '">Quantity added:</label>';
        $html .= '<input type="number" id="quantity-' . htmlspecialchars($item['product_id']) . '" name="quantity" value="' . htmlspecialchars($item['quantity']) . '" min="1">';
        $html .= '<button type="submit" class="update-quantity">Update</button>';
        $html .= '</form>';
        
        $html .= '<form method="post" action="cart.php">';
        $html .= '<input type="hidden" name="action" value="remove">';
        $html .= '<input type="hidden" name="product_id" value="' . htmlspecialchars($item['product_id']) . '">';
        $html .= '<button type="submit" class="remove-from-cart">Remove</button>';
        $html .= '</form>';
        $html .= '</div>';
    }

    return $html;
}
$cartHTML = generateCartHTML($cart_items);
?>
<!doctype html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" type="text/css" href="styles/stylecart.css">

</head>
<body>
    
    <div class="header">
        <div class="logo">
            <a href="index.php">
                <img src="images/logo.png" alt="GroceriesWithIsaacLogo">
            </a>
        </div>
        <div class="cart-title">Your Cart</div>
    </div>

    <!-- Display the cart -->
    <div id="cart-container" class="cart-container">
        <?php echo $cartHTML; ?>
    </div>

    <!-- Display total price -->
    <div class="cart-total">
        Total Price: AU$<?php echo number_format($total_price, 2); ?>
    </div>

    <!-- Clear Cart Button -->
    <form method="post" action="cart.php">
        <input type="hidden" name="action" value="clear">
        <button type="submit" class="clear-cart">Clear Cart</button>
    </form>

    <!-- Place Order Button -->
    <form method="get" action="delivery.php">
        <button type="submit"  class="place-order 
                <?php echo !empty($cart_items) ? 'enabled' : ''; ?> 
                <?php echo empty($cart_items) ? 'disabled' : ''; ?>">
            Place Order
        </button>
    </form>

    <a href="index.php" class="back-to-products">Back to Products</a>
    <script src="scripts/preventBack.js"></script> <!-- Include the external JavaScript file -->
</body>
</html>