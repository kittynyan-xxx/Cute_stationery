-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2023 at 10:31 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `l5_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `BrandID` int(11) NOT NULL,
  `BrandName` varchar(30) NOT NULL,
  `Status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`BrandID`, `BrandName`, `Status`) VALUES
(1, 'Adidas', 'Active'),
(2, 'Giordano', 'InActive');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(50) DEFAULT NULL,
  `Status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`, `Status`) VALUES
(1, 'Sport Wear', 'Active'),
(2, 'Casual Wear', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Phone` varchar(100) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `CustomerPhoto` varchar(255) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `CustomerName`, `Gender`, `Email`, `Password`, `Phone`, `Address`, `CustomerPhoto`, `RegDate`) VALUES
(0, 'Khin', 'Female', 'khin@gmail.com', '1234', '098765432', 'YGN', 'CustomerPhoto/________International-iGCSE-alevels-caie-student-reversed.png', '2023-07-12 07:53:33'),
(1, 'Alex John', 'Male', 'alex@gmail.com', 'alex', '9089839433', 'Yangon', 'CustomerPhoto/__person_4.jpg', '2021-11-20 19:54:35');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderID` varchar(15) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Price` decimal(10,0) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderID`, `ProductID`, `Price`, `Quantity`) VALUES
('ORD-000001', 2, '200', 3),
('ORD-000002', 1, '90', 1),
('ORD-000003', 1, '90', 1),
('ORD-000004', 1, '90', 1),
('ORD-000005', 4, '40', 1),
('ORD-000006', 2, '200', 1),
('ORD-000007', 4, '40', 1),
('ORD-000008', 1, '90', 1),
('ORD-000009', 1, '90', 1),
('ORD-000010', 1, '90', 1),
('ORD-000011', 1, '90', 1),
('ORD-000012', 4, '40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` varchar(15) NOT NULL,
  `OrderDate` date NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `DeliveryType` varchar(150) NOT NULL,
  `PaymentType` varchar(150) NOT NULL,
  `CustomerName` varchar(50) NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Direction` varchar(255) NOT NULL,
  `CardNo` varchar(50) NOT NULL,
  `TotalQuantity` int(11) NOT NULL,
  `TotalAmount` decimal(10,0) NOT NULL,
  `VAT` decimal(10,0) NOT NULL,
  `GrandTotal` decimal(10,0) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `DeliveryStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `OrderDate`, `CustomerID`, `DeliveryType`, `PaymentType`, `CustomerName`, `Phone`, `Address`, `Direction`, `CardNo`, `TotalQuantity`, `TotalAmount`, `VAT`, `GrandTotal`, `Status`, `DeliveryStatus`) VALUES
('ORD-000001', '2022-10-04', 1, 'SAME', 'COD', 'Alex John', '9089839433', 'Yangon', 'Near Orchid Hotel', '', 3, '600', '30', '630', 'Pending', 'Pending'),
('ORD-000002', '2022-11-28', 0, 'SAME', 'KPAY', 'Nandar', '0934567890', 'YGN', '', '', 1, '90', '5', '95', 'Pending', 'Pending'),
('ORD-000003', '2022-12-01', 1, 'SAME', 'CARD', 'Alex John', '9089839433', 'Yangon', '', '0010111002345', 1, '90', '5', '95', 'Pending', 'Pending'),
('ORD-000004', '2022-12-05', 0, 'SAME', 'COD', 'Nandar', '0934567890', 'YGN', '', '', 1, '90', '5', '95', 'Pending', 'Pending'),
('ORD-000005', '2022-12-06', 0, 'SAME', 'COD', '', '', '', '', '', 1, '40', '2', '42', 'Pending', 'Pending'),
('ORD-000006', '2022-12-06', 0, 'SAME', 'COD', 'Nandar', '0934567890', 'YGN', '', '', 1, '200', '10', '210', 'Pending', 'Pending'),
('ORD-000007', '2022-12-19', 0, 'SAME', 'COD', 'Nandar', '0934567890', 'YGN', '', '', 1, '40', '2', '42', 'Pending', 'Pending'),
('ORD-000008', '2022-12-19', 0, 'SAME', 'COD', 'Nandar', '0934567890', 'YGN', '', '', 1, '90', '5', '95', 'Pending', 'Pending'),
('ORD-000009', '2022-12-19', 0, 'SAME', 'COD', 'Nandar', '0934567890', 'YGN', '', '', 1, '90', '5', '95', 'Pending', 'Pending'),
('ORD-000010', '2022-12-19', 0, 'SAME', 'COD', 'Nandar', '0934567890', 'YGN', '', '', 1, '90', '5', '95', 'Pending', 'Pending'),
('ORD-000011', '2023-07-10', 0, 'SAME', 'COD', 'su', '098765432', 'YGN', 'Near SeingayHar', '', 1, '90', '5', '95', 'Pending', 'Pending'),
('ORD-000012', '2023-07-12', 0, 'SAME', 'COD', 'Khin', '098765432', 'YGN', '', '', 1, '40', '2', '42', 'Pending', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(50) NOT NULL,
  `ProductType` varchar(100) NOT NULL,
  `Size` varchar(50) NOT NULL,
  `Color` varchar(50) NOT NULL,
  `Price` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `BrandID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `ProductImage1` varchar(255) NOT NULL,
  `ProductImage2` varchar(255) NOT NULL,
  `ProductImage3` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductType`, `Size`, `Color`, `Price`, `Quantity`, `BrandID`, `CategoryID`, `Description`, `ProductImage1`, `ProductImage2`, `ProductImage3`) VALUES
(1, 'NB Blue Shirt', 'Sport  Type', 'M', 'Grey', 90, 18, 1, 1, 'test test', 'ProductImage/_P1_1.jpg', 'ProductImage/_P1_2.jpg', 'ProductImage/_P1_3.jpg'),
(2, 'Test T Shirt', 'Test Type', 'M', 'Grey', 200, 12, 1, 2, 'Test Test Test', 'ProductImage/_P2_1.jpg', 'ProductImage/_P2_1.jpg', 'ProductImage/_P2_1.jpg'),
(3, 'T-Shirt', 'Foreign', 'S', 'Blue', 50, 3, 2, 1, 'Blue', 'ProductImage/__P2_1.jpg', '', ''),
(4, 'Shirt', 'local', 'S', 'Blue', 40, 3, 2, 2, 'This is a good shirt.', 'ProductImage/___P2_1.jpg', '', ''),
(5, 'Dress', 'Foreign', 'M', 'Red', 100, 3, 2, 2, 'Good Quality', 'ProductImage/________International-iGCSE-alevels-caie-student-reversed.png', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `PurchaseID` varchar(15) NOT NULL,
  `PurchaseDate` date NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `TotalQuantity` int(11) NOT NULL,
  `TotalAmount` decimal(10,0) NOT NULL,
  `VAT` decimal(10,0) NOT NULL,
  `GrandTotal` decimal(10,0) NOT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`PurchaseID`, `PurchaseDate`, `SupplierID`, `StaffID`, `TotalQuantity`, `TotalAmount`, `VAT`, `GrandTotal`, `Status`) VALUES
('PUR-000001', '2022-08-31', 1, 1, 12, '5000', '250', '5250', 'Confirmed'),
('PUR-000002', '2022-08-31', 1, 1, 5, '5000', '250', '5250', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `purchasedetails`
--

CREATE TABLE `purchasedetails` (
  `PurchaseID` varchar(15) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `PurchasePrice` decimal(10,0) NOT NULL,
  `PurchaseQuantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchasedetails`
--

INSERT INTO `purchasedetails` (`PurchaseID`, `ProductID`, `PurchasePrice`, `PurchaseQuantity`) VALUES
('PUR-000001', 1, '100', 10),
('PUR-000001', 2, '2000', 2),
('PUR-000002', 1, '1000', 5);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(100) NOT NULL,
  `Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`RoleID`, `RoleName`, `Status`) VALUES
(1, 'Sales Manager', 'Active'),
(3, 'National Sales Manager', 'Active'),
(4, 'Promoter', 'Active'),
(5, 'Sales Supervisor', 'Active'),
(6, 'Admin Assitant', 'Active'),
(7, 'Admin', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `StaffName` varchar(100) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `RegisterDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `StaffName`, `RoleID`, `Email`, `Phone`, `Password`, `Address`, `RegisterDate`, `Photo`) VALUES
(1, 'Jann', 1, 'jan@gmail.com', '233252324', 'jan', 'Ygn', '2022-08-10 08:42:46', 'StaffPhoto/_International-iGCSE-alevels-caie-student-reversed.png'),
(2, 'Thu', 0, 'thuthu@gmail.com', '098765432', 'thu', 'YGN', '2022-11-28 04:39:03', 'StaffPhoto/__International-iGCSE-alevels-caie-student-reversed.png'),
(3, 'Naing', 4, 'naing@gmail.com', '0934567890', 'naing', 'YGN', '2022-11-28 08:25:12', 'StaffPhoto/___International-iGCSE-alevels-caie-student-reversed.png'),
(4, 'GuGu', 1, 'gugu@gmail.com', '0934567890', 'gugu', 'YGN', '2022-12-01 04:08:39', 'StaffPhoto/____International-iGCSE-alevels-caie-student-reversed.png'),
(5, 'John', 1, 'john@gmail.com', '0934567890', 'john', 'YGN', '2022-12-01 09:04:04', 'StaffPhoto/____International-iGCSE-alevels-caie-student-reversed.png'),
(6, 'Khin', 0, 'khin@gmail.com', '0934567890', 'khin', 'YGN', '2022-12-05 08:57:23', 'StaffPhoto/______International-iGCSE-alevels-caie-student-reversed.png'),
(7, 'ArtT', 4, 'artt@gmail.com', '0934567890', 'artt', 'YGN', '2022-12-06 06:52:27', 'StaffPhoto/_______International-iGCSE-alevels-caie-student-reversed.png'),
(8, 'Naing', 4, 'naing2@gmail.com', '098765432', '1234', 'YGN', '2023-07-10 09:09:40', 'StaffPhoto/________International-iGCSE-alevels-caie-student-reversed.png'),
(9, 'Su Hnin', 1, 'hnin@gmail.com', '098765432', '1234', 'YGN', '2023-07-12 07:47:59', 'StaffPhoto/________International-iGCSE-alevels-caie-student-reversed.png');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(100) NOT NULL,
  `CompanyName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(100) NOT NULL,
  `Address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`, `CompanyName`, `Email`, `Phone`, `Address`) VALUES
(1, 'Maria & Co', 'Maria Group of Companies', 'admin@maria.com', '73794980948930', 'YANGON');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderID`,`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`PurchaseID`);

--
-- Indexes for table `purchasedetails`
--
ALTER TABLE `purchasedetails`
  ADD PRIMARY KEY (`PurchaseID`,`ProductID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
