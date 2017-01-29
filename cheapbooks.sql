-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2016 at 06:18 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cheapbooks`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `ssn` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `address` varchar(40) NOT NULL,
  `number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`ssn`, `name`, `address`, `number`) VALUES
('1234567', 'neha', 'arlington', '123456789'),
('12345672', 'nitisha', 'dallas', '293983838'),
('1264646', 'shyam', 'Dallas', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `ISBN` varchar(20) NOT NULL,
  `title` varchar(40) NOT NULL,
  `year` varchar(20) NOT NULL,
  `price` float NOT NULL,
  `publisher` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`ISBN`, `title`, `year`, `price`, `publisher`) VALUES
('9780062409951', 'Appetites: A Cookbook 2', '2012', 10, 'HARPERCOLLINS PUBLISHERS'),
('9780062409957', 'The Moscow puzzles', '2015', 20, 'McgrawHills'),
('9780062409959', 'Appetites: A Cookbook', '2012', 5, 'HARPERCOLLINS PUBLISHERS'),
('9780312681350', 'Unwind your mind', '2013', 15, 'Creative Enterprises Studio'),
('9780486270784', 'Moscow', '2014', 20, 'Franklin'),
('9780938256175', 'Spelling Puzzles', '2016', 20, 'Pocket Watch Books');

-- --------------------------------------------------------

--
-- Table structure for table `contains`
--

CREATE TABLE `contains` (
  `ISBN` varchar(20) NOT NULL,
  `basketID` varchar(20) NOT NULL,
  `number` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contains`
--

INSERT INTO `contains` (`ISBN`, `basketID`, `number`) VALUES
('9780062409957', '58387b67e1672', 7),
('9780062409951', '58387b67e1672', 7),
('9780062409959', '58387b67e1672', 3),
('9780486270784', '583fa3a417a79', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `username` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`username`, `address`, `email`, `phone`, `password`) VALUES
('abc', '$abc', 'abc@abc.com', '123456', '52be8da9ca042f7a9703a194d8670ed5'),
('neha', 'arlington ', 'nehashet7@gmail.com', '3133072837', 'nehas'),
('neha1', '$neha1', 'abc@abc.com', '123456', '5d0eec91d66882123486'),
('neha12', '$arlignton', 'neha@gmail.com', '123456', 'nehashet7'),
('neha2', '$aaaa', 'nehashet7@gmail.com', '123456', 'nehashet'),
('nehahset1', '$arlignton', 'nehanilcant.shet@mav', '123456', 'neha'),
('nehas', '$address', 'nehanilcant.shet@mav', '123456', 'neha'),
('nehash', '$nehashet', 'nehanilcant.shet@mav', '123456', '262f5bdd0af9098e7443ab1f8e435290'),
('nehashet', '$nehashet', 'nehashet', '123456', 'nehashet'),
('nehashet0', '$nehashet0', 'nehashet0', '123456', 'nehashet0'),
('nitis', '$goa', 'niti@gmai.com', '123456', '81dc9bdb52d04dc20036dbd8313ed055'),
('shaunak', '$pune', 'sha@gmail.com', '1234567', '81dc9bdb52d04dc20036dbd8313ed055'),
('smith', '405 Austin St, Arlington, TX', 'smith@cse.uta.edu', '705-666', 'a029d0df84eb5549c641');

-- --------------------------------------------------------

--
-- Table structure for table `shippingorder`
--

CREATE TABLE `shippingorder` (
  `ISBN` varchar(20) NOT NULL,
  `warehouseCode` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `number` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingbasket`
--

CREATE TABLE `shoppingbasket` (
  `basketID` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shoppingbasket`
--

INSERT INTO `shoppingbasket` (`basketID`, `username`) VALUES
('5839bc917f1cc', 'abc'),
('5839bb03ce0d9', 'neha1'),
('58387bcd9d0ac', 'nehahset1'),
('5839bc0cb4ecc', 'nehash'),
('58387b67e1672', 'nehashet0'),
('583eef54507c4', 'nitis'),
('583fa3a417a79', 'shaunak');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `ISBN` varchar(20) NOT NULL,
  `warehouseCode` varchar(20) NOT NULL,
  `number` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`ISBN`, `warehouseCode`, `number`) VALUES
('9780062409959', '2', 0),
('9780062409959', '3', 0),
('9780062409951', '1', 0),
('9780938256175', '1', 10),
('9780486270784', '2', 5),
('9780062409951', '3', 4);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `warehouseCode` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `address` varchar(40) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`warehouseCode`, `name`, `address`, `phone`) VALUES
('1', 'mumbai', 'mumbai', '12345'),
('2', 'mapusa', 'mapusa', '12345'),
('3', 'goa', 'goa', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `writtenby`
--

CREATE TABLE `writtenby` (
  `ssn` varchar(20) NOT NULL,
  `ISBN` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `writtenby`
--

INSERT INTO `writtenby` (`ssn`, `ISBN`) VALUES
('1234567', '9780062409951'),
('12345672', '9780062409957'),
('1264646', '9780486270784'),
('1264646', '9780938256175');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`ssn`),
  ADD KEY `ssn` (`ssn`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `ISBN` (`ISBN`);

--
-- Indexes for table `contains`
--
ALTER TABLE `contains`
  ADD KEY `ISBN` (`ISBN`,`basketID`),
  ADD KEY `basketID` (`basketID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `email_2` (`email`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `shippingorder`
--
ALTER TABLE `shippingorder`
  ADD KEY `ISBN` (`ISBN`,`warehouseCode`),
  ADD KEY `username` (`username`),
  ADD KEY `warehouseCode` (`warehouseCode`);

--
-- Indexes for table `shoppingbasket`
--
ALTER TABLE `shoppingbasket`
  ADD PRIMARY KEY (`basketID`),
  ADD KEY `username` (`username`),
  ADD KEY `basketID` (`basketID`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD KEY `ISBN` (`ISBN`,`warehouseCode`),
  ADD KEY `warehouseCode` (`warehouseCode`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`warehouseCode`),
  ADD KEY `warehouseCode` (`warehouseCode`);

--
-- Indexes for table `writtenby`
--
ALTER TABLE `writtenby`
  ADD KEY `ssn` (`ssn`,`ISBN`),
  ADD KEY `ISBN` (`ISBN`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contains`
--
ALTER TABLE `contains`
  ADD CONSTRAINT `contains_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`),
  ADD CONSTRAINT `contains_ibfk_2` FOREIGN KEY (`basketID`) REFERENCES `shoppingbasket` (`basketID`);

--
-- Constraints for table `shippingorder`
--
ALTER TABLE `shippingorder`
  ADD CONSTRAINT `shippingorder_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`),
  ADD CONSTRAINT `shippingorder_ibfk_2` FOREIGN KEY (`warehouseCode`) REFERENCES `warehouse` (`warehouseCode`),
  ADD CONSTRAINT `shippingorder_ibfk_3` FOREIGN KEY (`username`) REFERENCES `customer` (`username`);

--
-- Constraints for table `shoppingbasket`
--
ALTER TABLE `shoppingbasket`
  ADD CONSTRAINT `shoppingbasket_ibfk_1` FOREIGN KEY (`username`) REFERENCES `customer` (`username`);

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`),
  ADD CONSTRAINT `stocks_ibfk_2` FOREIGN KEY (`warehouseCode`) REFERENCES `warehouse` (`warehouseCode`);

--
-- Constraints for table `writtenby`
--
ALTER TABLE `writtenby`
  ADD CONSTRAINT `writtenby_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`),
  ADD CONSTRAINT `writtenby_ibfk_2` FOREIGN KEY (`ssn`) REFERENCES `author` (`ssn`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
