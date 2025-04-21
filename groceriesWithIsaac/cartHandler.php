<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
    $_SESSION['cart_quantities'] = [];
}

// Set the response header to JSON
header('Content-Type: application/json');

$action = $_POST['action'] ?? ($_GET['action'] ?? '');

$conn = mysqli_connect("localhost", "root", "", "assignment1");

if (!$conn) {
    die("Could not connect to MySQL: " . mysqli_connect_error());
}

if ($action === 'add') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)($_POST['quantity'] ?? 1); // Default to 1 if quantity is not provided

    // Ensure the quantity is at least 1
    if ($quantity < 1) {
        $quantity = 1;
    }

    // Check stock availability
    $stock_query = "SELECT in_stock, product_name FROM products WHERE product_id = $product_id";
    $stock_result = mysqli_query($conn, $stock_query);
    $stock_row = mysqli_fetch_assoc($stock_result);

    if ($stock_row['in_stock'] < $quantity) {
        $available_quantity = $stock_row['in_stock'];
        $product_name = $stock_row['product_name'];
        echo json_encode([
            'status' => 'error',
            'message' => "Not enough units of the item in stock."
        ]);
        exit;
    }

    // Add the product to the cart
    if (!in_array($product_id, $_SESSION['cart'], true)) {
        $_SESSION['cart'][] = $product_id;
    }
    $_SESSION['cart_quantities'][$product_id] = ($_SESSION['cart_quantities'][$product_id] ?? 0) + $quantity;

    echo json_encode(['status' => 'success', 'message' => 'Product added to cart!']);
    exit;

} elseif ($action === 'remove') {
    $product_id = $_POST['product_id']; // Use product_id instead of index
    $key = array_search($product_id, $_SESSION['cart']); // Find the key of the product in the cart
    if ($key !== false) {
        unset($_SESSION['cart'][$key]); // Remove the product from the cart
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
        unset($_SESSION['cart_quantities'][$product_id]); // Remove the quantity entry
        echo "<script>alert('Product removed from cart!'); window.history.back();</script>";
    } else {
        echo "<script>alert('Product not found in cart!'); window.history.back();</script>";
    }
} elseif ($action === 'view') {
    $cart_items = [];
    if (!empty($_SESSION['cart'])) {
        $ids = implode(',', array_map('intval', $_SESSION['cart']));
        $query = "SELECT product_id, product_name, unit_price, unit_quantity, in_stock FROM products WHERE product_id IN ($ids)";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $cart_items[] = $row;
        }
    }
    echo json_encode($cart_items);
}

mysqli_close($conn);
?>