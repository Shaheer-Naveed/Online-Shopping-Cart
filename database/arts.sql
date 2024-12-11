-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 12:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arts`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_category`
--

CREATE TABLE `add_category` (
  `Id` int(11) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `Status` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_category`
--

INSERT INTO `add_category` (`Id`, `Category`, `Status`) VALUES
(2, 'Greeting Cards', 'Active'),
(3, 'Gift Articles', 'Active'),
(4, 'Dolls', 'Active'),
(5, 'Office', 'Active'),
(6, 'Bags and Accessories', 'Active'),
(8, 'Beauty Products', 'Active'),
(9, 'Arts and Crafts Supplies', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `add_product`
--

CREATE TABLE `add_product` (
  `Id` int(11) NOT NULL,
  `Product_Code` int(50) NOT NULL,
  `Product_Name` varchar(225) NOT NULL,
  `Product_Category` int(11) NOT NULL,
  `Product_Sub_Category` int(11) NOT NULL,
  `Price` int(50) NOT NULL,
  `Warranty` varchar(225) NOT NULL,
  `Description` varchar(225) NOT NULL,
  `Product_Image` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_product`
--

INSERT INTO `add_product` (`Id`, `Product_Code`, `Product_Name`, `Product_Category`, `Product_Sub_Category`, `Price`, `Warranty`, `Description`, `Product_Image`) VALUES
(4, 5689231, 'Literature Art', 9, 10, 4999, 'No Warranty', ' The imagination of Tower of Pisa.', 'image/literature2.jpeg'),
(7, 5626927, 'Short Handle Bag', 6, 12, 599, 'No Warranty', ' Easy for carrying in hands.', 'image/bag1.jpeg'),
(8, 5662897, 'Long Handle Bag', 6, 12, 999, 'No Warranty', ' Easy for hanging while travelling.', 'image/bag2.jpeg'),
(10, 5690839, 'Party Wallet', 6, 13, 399, 'No Warranty', ' Well styled wallet for party wear.', 'image/wallet1.jpeg'),
(11, 5684969, 'Casual Wallet', 6, 13, 399, 'No Warranty', ' Easy to store items for casual use of wallet.', 'image/wallet3.jpeg'),
(12, 5696924, 'Makeup Brush', 8, 3, 699, 'No Warranty', ' A set of brush items for makeup.', 'image/beauty3.jpeg'),
(13, 5625812, 'Lip Sticks', 8, 3, 699, 'No Warranty', ' A long lasting lip stick for special days.', 'image/beauty2.jpeg'),
(14, 567996, 'Pots', 3, 4, 2999, 'No Warranty', ' Pots which will make you home more beautiful.\r\n', 'image/decorative3.jpg'),
(15, 5672200, 'Flower Pots', 3, 4, 999, 'No Warranty', ' Pots that are enough for making your room beautiful.', 'image/decorative2.jpeg'),
(17, 5677807, 'Record Files', 5, 11, 699, 'No Warranty', ' Can store carious amount papers.', 'image/office1.jpeg'),
(18, 5649920, ' Invitation Card', 2, 7, 299, 'No Warranty', ' A card for birthday invitations.', 'image/greeting1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `add_sub_category`
--

CREATE TABLE `add_sub_category` (
  `Id` int(11) NOT NULL,
  `Parent_Category` varchar(225) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `Status` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_sub_category`
--

INSERT INTO `add_sub_category` (`Id`, `Parent_Category`, `Category`, `Status`) VALUES
(2, 'Greeting Cards', 'Birthday Articles', 'Active'),
(3, 'Beauty Products', 'Makeup Items', 'Active'),
(4, 'Gift Articles', 'Decorative Items', 'Active'),
(5, 'Gift Articles', 'Souvenirs', 'Active'),
(7, 'Greeting Cards', 'Birthday Cards', 'Active'),
(8, 'Greeting Cards', 'Holiday Cards', 'Active'),
(9, 'Dolls', 'Collectible Dolls', 'Active'),
(10, 'Arts and Crafts Supplies', 'Drawing and Painting Supplies', 'Active'),
(11, 'Office', 'Files and Folders', 'Active'),
(12, 'Bags and Accessories', 'Hand Bags', 'Active'),
(13, 'Bags and Accessories', 'Wallets', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `Id` int(11) NOT NULL,
  `User_Id` int(11) DEFAULT NULL,
  `Session_Id` varchar(255) DEFAULT NULL,
  `Product_Id` int(11) NOT NULL,
  `Picture` varchar(225) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 1,
  `Date_Added` timestamp NOT NULL DEFAULT current_timestamp(),
  `Last_Updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`Id`, `User_Id`, `Session_Id`, `Product_Id`, `Picture`, `Quantity`, `Date_Added`, `Last_Updated`) VALUES
(13, NULL, '', 14, 'default.jpg', 3, '2024-11-19 16:06:53', '2024-11-20 10:28:36'),
(20, NULL, 'm024ph45p41rbe38p55ncbledq', 18, 'default.jpg', 5, '2024-11-20 09:19:44', '2024-11-20 09:19:44');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `Id` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Message` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`Id`, `Username`, `Message`) VALUES
(1, '', 'asdasd'),
(2, '', 'asdasd'),
(3, 'Guest', 'asdasd');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `Id` int(11) NOT NULL,
  `Role_Id` int(11) NOT NULL,
  `Username` varchar(225) NOT NULL,
  `Email` varchar(225) NOT NULL,
  `Password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`Id`, `Role_Id`, `Username`, `Email`, `Password`) VALUES
(28, 3, 'Shahzaib123', 'shahzaib123@gmail.com', 'shahzaib@123');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `Id` int(11) NOT NULL,
  `Role_Id` int(11) NOT NULL,
  `Username` varchar(225) NOT NULL,
  `Email` varchar(225) NOT NULL,
  `Password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Id`, `Role_Id`, `Username`, `Email`, `Password`) VALUES
(14, 2, 'Mubashir', 'mubashir123@gmail.com', 'mubashir@123'),
(27, 2, 'Dabeer', 'dabeer123@gmail.com', 'dabeer@123');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `Id` int(11) NOT NULL,
  `Question` text NOT NULL,
  `Answer` text NOT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Customer_Question` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`Id`, `Question`, `Answer`, `Created_at`, `Customer_Question`) VALUES
(1, 'What is the purpose of this FAQ page?', 'This FAQ page is designed to answer common questions about our website and services.', '2024-11-15 13:54:46', ''),
(2, 'How can I contact customer support?', 'You can contact our customer support team via the contact form on our website or by emailing support@example.com.', '2024-11-15 13:54:46', ''),
(3, 'How do I reset my password?', 'To reset your password, go to the login page and click \"Forgot Password\". Follow the instructions to reset your password.', '2024-11-15 13:54:46', ''),
(4, 'Is there a mobile app available?', 'Yes, we have a mobile app available for both iOS and Android. You can download it from the App Store or Google Play.', '2024-11-15 13:54:46', ''),
(5, 'Where can I find more information about your products?', 'You can find detailed information about our products on the \"Products\" page of our website, or contact us for personalized assistance.', '2024-11-15 13:54:46', ''),
(6, 'Can I get a refund if I am not satisfied with the product?', 'Yes, we offer a 30-day money-back guarantee for all products. Please visit our \"Refund Policy\" page for more details.', '2024-11-15 13:54:46', ''),
(7, '', '', '2024-11-16 06:35:30', 'Should I Pre Order?');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `Id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(99) NOT NULL,
  `Phone` int(11) NOT NULL,
  `Picture` varchar(100) NOT NULL,
  `Feedback` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`Id`, `Name`, `Email`, `Phone`, `Picture`, `Feedback`) VALUES
(1, 'shaheer naveed', 'shaheernaveed27@gmail.com', 2147483647, 'assets/img/avaters/avatar2.png', 'Your website is Awesome.'),
(2, 'Fariha', 'fariha@gmail.com', 123456789, 'assets/img/avaters/avatar1.png', 'Love Your Website.'),
(3, 'Faizan', 'faizan@gmail.com', 123456789, 'assets/img/avaters/avatar3.png', 'Marvellous working keep it up.'),
(5, 'shaheer naveed', 'shaheernaveed27@gmail.com', 2147483647, 'assets/img/avaters/8b50d460-fe0b-433f-be3c-f41ccc6ead38.jpg', 'asdasd'),
(6, 'shahzaibAhmed', 'shaheernaveed27@gmail.com', 2147483647, 'assets/img/avaters/8b50d460-fe0b-433f-be3c-f41ccc6ead38.jpg', 'asdasdsaddas');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_items`
--

CREATE TABLE `ordered_items` (
  `Item_Id` int(11) NOT NULL,
  `Order_Id` int(11) NOT NULL,
  `Product_Id` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordered_items`
--

INSERT INTO `ordered_items` (`Item_Id`, `Order_Id`, `Product_Id`, `Quantity`) VALUES
(1, 1, 4, 1),
(2, 1, 16, 1),
(3, 2, 15, 1),
(4, 2, 17, 1),
(5, 3, 18, 1),
(6, 3, 14, 1),
(7, 3, 15, 1),
(8, 3, 10, 1),
(9, 4, 11, 1),
(10, 4, 18, 1),
(11, 5, 18, 1),
(12, 7, 18, 1),
(13, 8, 18, 1),
(14, 8, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Order_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Address` text NOT NULL,
  `Payment_Method` text DEFAULT NULL,
  `Product_Code` varchar(16) NOT NULL,
  `Subtotal` decimal(10,2) NOT NULL,
  `Shipping` decimal(10,2) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `Order_Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Order_Id`, `User_Id`, `Name`, `Email`, `Phone`, `Address`, `Payment_Method`, `Product_Code`, `Subtotal`, `Shipping`, `Total`, `Order_Date`) VALUES
(19, 15, 'shaheer naveed', 'shaheernaveed27@gmail.com', '03442563919', 'SB-27 block K, Karachi', 'VPP (Value Payable Post)', '2147483647', 299.00, 50.00, 349.00, '2024-11-19 15:25:29'),
(94, 16, 'faizan', 'shaheernaveed27@gmail.com', '03442563919', 'SB-27 block K, Karachi', 'VPP (Value Payable Post)', '5123453127200045', 2999.00, 50.00, 3049.00, '2024-11-19 15:42:52'),
(95, 12, 'shaheer naveed', 'shaheernaveed27@gmail.com', '03442563919', 'SB-27 block K, Karachi', 'Credit Cards', '5123452379637231', 299.00, 50.00, 349.00, '2024-11-19 16:48:47'),
(96, 12, 'Hashir', 'hashir2005@gmail.com', '03442563919', 'SB-27 block K, Karachi', 'Credit Cards', '5123458320241608', 299.00, 50.00, 349.00, '2024-11-20 04:48:04'),
(97, 28, 'dabeer', 'dabeerzaidi25@gmail.com', '03442563919', 'SB-27 block K, Karachi', 'Demand Draft (DD)', '5123452498533912', 2893.00, 50.00, 2943.00, '2024-11-20 10:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `Id` int(11) NOT NULL,
  `Role` varchar(225) NOT NULL,
  `Status` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`Id`, `Role`, `Status`) VALUES
(1, 'admin', 'Active'),
(2, 'Employee', 'Active'),
(3, 'Customer', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `Id` int(11) NOT NULL,
  `Pro_Id` int(11) NOT NULL,
  `Pro_Category` int(11) NOT NULL,
  `Pro_Sub_Category` int(11) NOT NULL,
  `Quantity_In` int(50) NOT NULL,
  `Quantity_Out` int(50) NOT NULL,
  `Available` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`Id`, `Pro_Id`, `Pro_Category`, `Pro_Sub_Category`, `Quantity_In`, `Quantity_Out`, `Available`) VALUES
(2, 4, 9, 10, 60, 15, 45),
(3, 13, 8, 3, 66, 0, 66),
(4, 7, 6, 12, 15, 0, 15),
(5, 10, 6, 13, 60, 15, 45),
(6, 11, 6, 13, 60, 0, 60);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Role_Id` int(11) NOT NULL,
  `Username` varchar(225) NOT NULL,
  `Email` varchar(225) NOT NULL,
  `Password` varchar(225) NOT NULL,
  `Status` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Role_Id`, `Username`, `Email`, `Password`, `Status`) VALUES
(4, 1, 'Shaheer', 'shaheer123@gmail.com', 'shaheer@1234', 'admin'),
(14, 2, 'Mubashir', 'mubashir123@gmail.com', 'mubashir@123', 'Employee'),
(27, 2, 'Dabeer', 'dabeer123@gmail.com', 'dabeer@123', 'Employee'),
(28, 3, 'Shahzaib123', 'shahzaib123@gmail.com', 'shahzaib@123', 'Customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_category`
--
ALTER TABLE `add_category`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `add_product`
--
ALTER TABLE `add_product`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `cat_fk` (`Product_Category`),
  ADD KEY `sub_cat_fk` (`Product_Sub_Category`);

--
-- Indexes for table `add_sub_category`
--
ALTER TABLE `add_sub_category`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `User_Id` (`User_Id`),
  ADD KEY `Product_Id` (`Product_Id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `ordered_items`
--
ALTER TABLE `ordered_items`
  ADD PRIMARY KEY (`Item_Id`),
  ADD KEY `Order_Id` (`Order_Id`),
  ADD KEY `Product_Id` (`Product_Id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_Id`),
  ADD KEY `User_Id` (`User_Id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `pro_id_fk` (`Pro_Id`),
  ADD KEY `pro_cat_fk` (`Pro_Category`),
  ADD KEY `pro_sub_cat_fk` (`Pro_Sub_Category`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `role_id_fk` (`Role_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_category`
--
ALTER TABLE `add_category`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `add_product`
--
ALTER TABLE `add_product`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `add_sub_category`
--
ALTER TABLE `add_sub_category`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ordered_items`
--
ALTER TABLE `ordered_items`
  MODIFY `Item_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_product`
--
ALTER TABLE `add_product`
  ADD CONSTRAINT `cat_fk` FOREIGN KEY (`Product_Category`) REFERENCES `add_category` (`Id`),
  ADD CONSTRAINT `sub_cat_fk` FOREIGN KEY (`Product_Sub_Category`) REFERENCES `add_sub_category` (`Id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`Id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`Product_Id`) REFERENCES `add_product` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `pro_cat_fk` FOREIGN KEY (`Pro_Category`) REFERENCES `add_category` (`Id`),
  ADD CONSTRAINT `pro_id_fk` FOREIGN KEY (`Pro_Id`) REFERENCES `add_product` (`Id`),
  ADD CONSTRAINT `pro_sub_cat_fk` FOREIGN KEY (`Pro_Sub_Category`) REFERENCES `add_sub_category` (`Id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `role_id_fk` FOREIGN KEY (`Role_Id`) REFERENCES `role` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
