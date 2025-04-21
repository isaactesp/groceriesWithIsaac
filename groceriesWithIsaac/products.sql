-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-04-2025 a las 15:34:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `assignment1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(20) DEFAULT NULL,
  `unit_price` float(8,2) DEFAULT NULL,
  `unit_quantity` varchar(15) DEFAULT NULL,
  `in_stock` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `subtype` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `unit_price`, `unit_quantity`, `in_stock`, `type`, `subtype`) VALUES
(1, 'Margherita Pizza', 4.50, '500 gram', 40, 'frozen', 'pizza'),
(2, 'Pepperoni Pizza', 5.00, '450 gram', 40, 'frozen', 'pizza'),
(3, 'BBQ Chicken Pizza', 5.50, '480 gram', 40, 'frozen', 'pizza'),
(4, 'Vegetarian Pizza', 4.80, '500 gram', 40, 'frozen', 'pizza'),
(5, 'Frozen Salmon Fillet', 7.99, '400 gram', 40, 'frozen', 'fish'),
(6, 'Frozen Cod Fillets', 6.50, '500 gram', 40, 'frozen', 'fish'),
(7, 'Fish Fingers', 3.20, '250 gram', 40, 'frozen', 'fish'),
(8, 'Frozen Strawberries', 3.00, '300 gram', 40, 'frozen', 'fruit'),
(9, 'Frozen Mango Chunks', 3.50, '350 gram', 40, 'frozen', 'fruit'),
(10, 'Frozen Blueberries', 3.80, '300 gram', 40, 'frozen', 'fruit'),
(11, 'Fresh Apples', 3.20, '1kg', 40, 'fresh', 'fruit'),
(12, 'Fresh Bananas', 2.50, '1kg', 40, 'fresh', 'fruit'),
(13, 'Fresh Oranges', 3.00, '1kg', 40, 'fresh', 'fruit'),
(14, 'Fresh Grapes', 4.10, '500g', 40, 'fresh', 'fruit'),
(15, 'Fresh Chicken Breast', 7.50, '500g', 40, 'fresh', 'meat'),
(16, 'Fresh Beef Mince', 9.00, '500g', 40, 'fresh', 'meat'),
(17, 'Fresh Lamb Chops', 10.20, '400g', 40, 'fresh', 'meat'),
(18, 'Fresh Broccoli', 2.80, '400g', 40, 'fresh', 'vegetables'),
(19, 'Fresh Carrots', 2.20, '500g', 40, 'fresh', 'vegetables'),
(20, 'Fresh Spinach', 3.30, '300g', 40, 'fresh', 'vegetables'),
(21, 'Dishwashing Liquid', 3.50, '750ml', 40, 'home', 'cleaning'),
(22, 'Glass Cleaner Spray', 4.00, '500ml', 40, 'home', 'cleaning'),
(23, 'Laundry Detergent', 8.50, '2L', 39, 'home', 'cleaning'),
(24, 'Toilet Cleaner', 3.80, '500ml', 40, 'home', 'cleaning'),
(25, 'All purpose Cleaner', 5.20, '1L', 40, 'home', 'cleaning'),
(26, 'Floor Cleaner', 6.30, '1.5L', 40, 'home', 'cleaning'),
(27, 'Non-stick Frying Pan', 20.00, '1 unit', 40, 'home', 'cooking'),
(28, 'Wooden Spoon Set', 8.99, '5 units', 38, 'home', 'cooking'),
(29, 'Cutting Board', 10.00, '1 unit', 40, 'home', 'cooking'),
(30, 'Measuring Cups', 6.50, '1 set', 40, 'home', 'cooking'),
(31, 'Spatula', 3.00, '1 unit', 40, 'home', 'cooking'),
(32, 'Baking Tray', 7.25, '1 unit', 40, 'home', 'cooking'),
(33, 'Olive Oil Extra Virg', 6.90, '750ml', 40, 'diet', 'mediterranean'),
(34, 'Pita Bread', 3.50, '6 pieces', 40, 'diet', 'mediterranean'),
(35, 'Canned Chickpeas', 1.80, '400g', 40, 'diet', 'mediterranean'),
(36, 'Feta Cheese', 4.20, '200g', 40, 'diet', 'mediterranean'),
(37, 'Sushi Rice', 5.00, '1kg', 40, 'diet', 'asian'),
(38, 'Tofu Blocks', 2.99, '300g', 40, 'diet', 'asian'),
(39, 'Miso Paste', 4.75, '400g', 40, 'diet', 'asian'),
(40, 'Turkey Breast Slices', 6.30, '150g', 40, 'diet', 'american'),
(41, 'Peanut Butter', 4.10, '500g', 40, 'diet', 'american'),
(42, 'Sweet Potato Fries', 3.80, '450g', 40, 'diet', 'american');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
