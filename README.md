# 🛒 GroceriesWithIsaac

A dynamic e-commerce web application for a grocery store built with **PHP**, **JavaScript**, **HTML**, and **CSS**.

---

## 📋 Overview

The **GroceriesWithIsaac** project allows users to:

- Browse products
- Filter by categories and subcategories
- Search for items
- Add products to a cart
- Submit orders with delivery details

Back-end logic is handled using PHP, while JavaScript provides dynamic interaction. The UI is styled using modern CSS.

---

## 📁 Project Structure

### 📂 PHP Files

- **`index.php`**  
  Main entry point. Displays navigation, search bar, and product grid. Supports dynamic filters by category and subcategory.

- **`fetchProducts.php`**  
  Handles AJAX requests to retrieve products from the database with filters for type, subtype, and search terms.

- **`cartHandler.php`**  
  Manages cart actions (add/remove/view). Validates stock and returns JSON responses for real-time cart updates.

- **`cart.php`**  
  Displays cart contents. Allows quantity updates, item removal, and shows total price. Includes a “Place Order” button.

- **`delivery.php`**  
  Contains a delivery form. Validates cart stock before submission. Disables “Submit Order” if stock is insufficient.

- **`processOrder.php`**  
  Processes submitted orders, updates stock in the DB, and clears the cart. Redirects to confirmation or back to cart on failure.

- **`confirmationOrder.php`**  
  Displays order confirmation. Optionally sends a confirmation email. Includes a return-to-home link.

---

### 📂 scripts/ (JavaScript)

- **`filterProducts.js`**  
  Filters products based on category/subcategory via AJAX. Updates the product grid and `<h1>` title dynamically.

- **`searchProducts.js`**  
  Handles product search logic and dynamically updates results and the page heading.

- **`cart.js`**  
  Manages cart actions and attaches events to “Add to Cart” buttons. Supports dynamic loading of new products.

---

### 📂 styles/ (CSS)

- **`styleindex.css`**  
  Styles main UI: navigation, search bar, product grid. Includes responsive layout and hover effects.

- **`stylecart.css`**  
  Styles the cart page with product lists, total display, and action buttons.

- **`styledelivery.css`**  
  Styles the delivery form with validation feedback and button states.

- **`styleconfirmation.css`**  
  Styles the order confirmation message and return navigation.

---

## 🎨 Fonts and Colors

### Fonts
- **Primary Font:** *Special Gothic Expanded One* (Google Fonts)

### Colors
- **Green Palette**  
  - `#388e3c` — Primary button/navigation green  
  - `#2e7d32` — Hover green  
  - `#81c784` — Background/light green

- **Greys**  
  - `#b0b0b0` — Disabled buttons  
  - `#888888` — Placeholder text

- **White**  
  - For clean background and text contrast

---

### 📂 images/ (Pictures for every product in the database)

## 🚀 How to Run the Project

### 1. Set Up the Database

- Create a MySQL DB named `assignment1`
- Import your tables (e.g., `products`)

### 2. Configure Environment

- Place project files in `htdocs` under your XAMPP folder
- Start **Apache** and **MySQL** from XAMPP

### 3. Access the Web App

- Open your browser and go to:  
  `http://localhost/labsToBeUsed/assignment1/index.php`

### 4. Explore Features

- Browse products
- Use filters and search
- Add to cart, place orders

---

## ⚠️ Notes

- Ensure database connection credentials match your local setup.
- Email functionality in `confirmationOrder.php` is commented out. To enable it, configure a working mail server.

---
