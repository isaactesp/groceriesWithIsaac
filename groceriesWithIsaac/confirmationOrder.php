<?php
session_start();

// Clear the cart
$_SESSION['cart'] = [];
$_SESSION['cart_quantities'] = [];

$email = htmlspecialchars($_GET['email'] ?? '');

// Send a confirmation email, I leave it commented out for now
/*if (!empty($email)) {
    $subject = "Order Confirmation";
    $message = "Thank you for your order! Your order has been successfully placed.";
    $headers = "From: no-reply@example.com\r\n"; // Replace with your sender email address

    if (mail($email, $subject, $message, $headers)) {
        $email_status = "A confirmation email has been sent to: <strong>" . htmlspecialchars($email) . "</strong>";
    } else {
        $email_status = "Failed to send a confirmation email to: <strong>" . htmlspecialchars($email) . "</strong>";
    }
} else {
    $email_status = "No email address provided.";
}*/

// Display the confirmation message
?>
<!doctype html>
<html>
<head>
    <title>Order Confirmation</title>
    <link rel="stylesheet" type="text/css" href="styles/styleconfirmation.css">
</head>
<body>
    <h1>Thank you for your order!</h1>
    <p>Your order has been successfully placed.</p>
    <p><?php echo "Sending confirmation email to: " . htmlspecialchars($email); ?></p>
    <a href="index.php" class="return-home">Return to see all products</a>
</body>
</html>