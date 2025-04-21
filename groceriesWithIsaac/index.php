
<!doctype html>
<?php
session_start();
?>
<html>
<head>
    <title>GroceriesWithIsaac</title>
    <link rel="stylesheet" type="text/css" href="styles/styleindex.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="left-section">
            <div class="logo">
                <a href="index.php">
                    <img src="images/logo.png" alt="GroceriesWithIsaacLogo">
                </a>
            </div>
            <div class="subnav">
                <button class="subnavbtn" onclick="filterProducts('type=Fresh')">Fresh Food<i></i></button>
                <div class="subnav-content">
                    <button onclick="filterProducts('type=Fresh&subtype=Fruit')">Fruit</button>
                    <button onclick="filterProducts('type=Fresh&subtype=Meat')">Meat</button>
                    <button onclick="filterProducts('type=Fresh&subtype=Vegetables')">Vegetables</button>
                </div>
            </div>
            <div class="subnav">
                <button class="subnavbtn" onclick="filterProducts('type=Frozen')">Frozen Food<i class="fa fa-caret-down"></i></button>
                <div class="subnav-content">
                    <button onclick="filterProducts('type=Frozen&subtype=Fruit')">Frozen Fruit</button>
                    <button onclick="filterProducts('type=Frozen&subtype=Fish')">Fish</button>
                    <button onclick="filterProducts('type=Frozen&subtype=Pizza')">Pizza</button>
                </div>
            </div>
            <div class="subnav">
                <button class="subnavbtn" onclick="filterProducts('type=Diet')">Diet<i class="fa fa-caret-down"></i></button>
                <div class="subnav-content">
                    <button onclick="filterProducts('type=Diet&subtype=Mediterranean')">Mediterranean</button>
                    <button onclick="filterProducts('type=Diet&subtype=Asian')">Asian</button>
                    <button onclick="filterProducts('type=Diet&subtype=American')">American</button>
                </div>
            </div>
            <div class="subnav">
                <button class="subnavbtn" onclick="filterProducts('type=Home')">Home<i class="fa fa-caret-down"></i></button>
                <div class="subnav-content">
                    <button onclick="filterProducts('type=Home&subtype=Cleaning')">Cleaning</button>
                    <button onclick="filterProducts('type=Home&subtype=Cooking')">Cooking</button>
                </div>
            </div>
            <div class="search-bar">
                <form onsubmit="searchProducts(event)">
                    <input type="text" id="searchInput" placeholder="Search products...">
                    <input type="submit" value="Search">
                </form>
            </div>
        </div>

        <div class="cart">
            <a href="cart.php">
                <button class="subnavbtN" onclick="toggleCart()">
                    <img src="images/cart.png" alt="Cart" class="cart-icon">
                </button>
            </a>
        </div>
    </nav>

    <!-- Product Grid -->
    <h1>Products</h1>
    <div id="product-container" class="product-container">
        <?php
    
        // Connect to the database
        $conn = mysqli_connect("localhost", "root", "", "assignment1");

        if (!$conn) {
            die("Could not connect to MySQL: ");
        }

        // Default query to show all products(no filters applied)
        $query_string = "SELECT * FROM products";
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
    </div>

    <script src="scripts/filterProducts.js"></script>
    <script src="scripts/searchProducts.js"></script>
    <script src="scripts/cart.js"></script>
</body>
</html>