<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "assignment1");

if (!$conn) {
    die("Could not connect to MySQL: " . mysqli_connect_error());
}

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    echo "<script>alert('Your cart is empty. Redirecting to the cart page.'); window.location.href = 'cart.php';</script>";
    exit;
}

// Check the availability of items in the cart
$cart_items = $_SESSION['cart'];
$cart_ids = implode(',', array_map('intval', $cart_items)); // Ensure IDs are integers
$query = "SELECT product_id, product_name, in_stock FROM products WHERE product_id IN ($cart_ids)";
$result = mysqli_query($conn, $query);

$unavailable_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['in_stock'] == 0) {
        $unavailable_items[] = $row['product_name'];
    }
}

// If there are unavailable items, notify the user and redirect to the cart
if (!empty($unavailable_items)) {
    $unavailable_list = implode(', ', $unavailable_items);
    echo "<script>alert('The following items are no longer available: $unavailable_list. Redirecting to the cart page.'); window.location.href = 'cart.php';</script>";
    exit;
}

// Check if there was a stock issue
$disable_submit = isset($_SESSION['stock_issue']) && $_SESSION['stock_issue'] === true;
if ($disable_submit) {
    unset($_SESSION['stock_issue']); // Clear the flag after checking
}
?>
<!doctype html>
<html>
<head>
    <title>Delivery Details</title>
    <link rel="stylesheet" type="text/css" href="styles/styledelivery.css">
</head>
<body>
    <div class="logo" id="logo">
        <a href="index.php">
            <img src="images/logo.png" alt="GroceriesWithIsaacLogo">
        </a>
    </div>

    <h1>Delivery Details</h1>

    <form method="post" action="processOrder.php">
        <h2>Personal details</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" pattern="[A-Za-z\s\-]{2,}" title="Only letters/spaces/hyphens allowed, must contain at least 2 characters" required>

        <label for="lastname">Last name:</label>
        <input type="text" id="lastname" name="lastname" pattern="[A-Za-z\s\-]{2,}" title="Only letters/spaces/hyphens allowed, must contain at least 2 characters" required>

        <label for="mobile">Mobile Number:</label>
        <input type="tel" id="mobile" name="mobile" pattern="0[0-9]{9}" title="Must be an australian phone number, so started with 0 and 9 digits afterwards" required>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" pattern="^[^@]+@(gmail\.com|student\.uts\.edu\.au)$" title="Must be @gmail.com or @student.uts.edu.au" required>

        <h2>Address</h2>
        <label for="street">Street:</label>
        <input type="text" id="street" name="street" pattern="[A-Za-z0-9\s\-]{2,}" title="Only alphanumeric/spaces/hyphens allowed, must contain 2 characters at least" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" pattern="[A-Za-z]{2,}" title="City/Suburb must contain only letters and be at least 2 characters long." required>

        <label for="suburb">Suburb (Postal Code):</label>
        <input type="text" id="suburb" name="suburb" pattern="\d{4}" title="Suburb must be a 4-digit number." required>

        <label for="territory">Territory:</label>
        <select id="territory" name="territory" required>
            <option value="NSW">NSW</option>
            <option value="VIC">VIC</option>
            <option value="QLD">QLD</option>
            <option value="WA">WA</option>
            <option value="SA">SA</option>
            <option value="TAS">TAS</option>
            <option value="ACT">ACT</option>
            <option value="NT">NT</option>
            <option value="Others">Others</option>
        </select>

        <button type="submit" 
                class="submit-order <?php echo $disable_submit ? 'disabled' : ''; ?>" 
                id="submit-order" 
                <?php echo $disable_submit ? 'disabled' : ''; ?>>
            Submit Order
        </button>
    </form>

    <a href="cart.php" class="back-to-cart">Back to Cart</a>

    <script>
        // Check the stock issue state and disable the button if necessary
        const stockIssue = document.getElementById('stock-issue').value === 'true';
        if (stockIssue) {
            const submitButton = document.getElementById('submit-order');
            submitButton.classList.add('disabled');
            submitButton.disabled = true;
        }
    </script>

 
</body>
</html>