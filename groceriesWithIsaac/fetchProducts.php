<?php
session_start();
/* This file handles AJAX requests to fetch products from the database.
It applies filters based on the query string parameters and returns them as HTML
to be displaye on the webpage.
*/


// Database connection
$conn = mysqli_connect("localhost", "root", "", "assignment1");

if (!$conn) {
    die("Could not connect to MySQL: ");
}

// Get the filter from the query string
$filter = isset($_GET) ? $_GET : [];
$whereClauses = [];

if (isset($filter['type'])) {
    $whereClauses[] = "type='".mysqli_real_escape_string($conn,$filter['type'])."'";
}
if (isset($filter['subtype'])) {
    $whereClauses[] = "subtype='".mysqli_real_escape_string($conn,$filter['subtype'])."'";
}
if (isset($filter['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $filter['search']);
    if(strtolower($searchTerm) == 'food') {
        $whereClauses[] = "type='Fresh' or type='Frozen' or type='Diet'";
    }
    elseif(strtolower($searchTerm) == 'utensils') {
        $whereClauses[] = "type='Home'";
    } else {
        $whereClauses[] = "product_name LIKE '%$searchTerm%'";
    }
}

// Build the query
$query_string = "SELECT product_id, product_name, unit_price, unit_quantity, in_stock FROM products";
if (!empty($whereClauses)) {
    $query_string .= " WHERE " . implode(" AND ", $whereClauses);
}

$result = mysqli_query($conn, $query_string);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Generate the image file path
        $image_path = 'images/'.strtolower(str_replace(' ', '_', $row["product_name"])).'.png';
        
        $in_stock = $row['in_stock'];
        $button_class = $in_stock > 0 ? 'add-to-cart' : 'add-to-cart disabled';
        $button_disabled = $in_stock > 0 ? '' : 'disabled';

        echo '<div class="product">';
            echo '<img src="' . $image_path . '" alt="' . $row['product_name'] . '">';
            echo '<h3>' . $row['product_name'] . '</h3>';
            echo '<p>Unit quantity: ' . $row['unit_quantity'] . '</p>';
            echo '<p>Price: AU$' . $row['unit_price'] . '</p>';
            echo '<p>Status: ' . ($in_stock > 0 ? 'In Stock' : 'Out of Stock') . '</p>';
            echo '<button class="' . $button_class . '" ' . $button_disabled . ' data-id="' . $row['product_id'] . '">Add to Cart</button>';
        echo '</div>';
        }
} else {
    // No products with that filter in the shop's database 
    echo "<p>No products found.</p>";
}

mysqli_close($conn);
?>