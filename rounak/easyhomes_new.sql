-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 16, 2021 at 08:14 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easyhomes`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `user_id` int(8) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `age` int(4) NOT NULL,
  `gender` varchar(3) NOT NULL,
  `email_id` varchar(40) NOT NULL,
  `phone_number` bigint(20) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email_id` (`email_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `password` (`password`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `fname`, `mname`, `lname`, `age`, `gender`, `email_id`, `phone_number`, `username`, `password`) VALUES
(11111, 'EasyHomes', 'Admin', 'Team', 20, 'M', 'easyhomes878@gmail.com', 8010076079, 'easyhomesadmin', '$2y$10$/HC..A9jz/tEogRkForehu0WA8eXO4vYbFnlyoHsd4PMKMFeDsn4a');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `request_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(6) UNSIGNED NOT NULL,
  `category_id` int(4) NOT NULL,
  `truck_id` varchar(12) DEFAULT NULL,
  `driver_contactno` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `booking_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pickup_date` date DEFAULT NULL,
  `pickup_time` time DEFAULT NULL,
  `no_of_trucks` int(11) NOT NULL,
  `source` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`,`booking_time`),
  UNIQUE KEY `request_id` (`request_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`request_id`, `user_id`, `category_id`, `truck_id`, `driver_contactno`, `status`, `booking_time`, `pickup_date`, `pickup_time`, `no_of_trucks`, `source`, `destination`) VALUES
(1, 18, 1002, NULL, NULL, 0, '2021-12-15 01:24:27', NULL, NULL, 1, '15.498224975518754,73.83069346649933', '15.530376216984365,73.83272442455109');

-- --------------------------------------------------------

--
-- Table structure for table `flat`
--

DROP TABLE IF EXISTS `flat`;
CREATE TABLE IF NOT EXISTS `flat` (
  `flat_no` varchar(10) NOT NULL,
  `building_name` varchar(40) NOT NULL,
  `property_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`flat_no`,`building_name`),
  UNIQUE KEY `property_id` (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flat`
--

INSERT INTO `flat` (`flat_no`, `building_name`, `property_id`) VALUES
('T1', 'Heritage Madhuban', 56),
('FL1', 'Sun Complex', 64),
('F10', 'Krishna Apartments', 65);

-- --------------------------------------------------------

--
-- Table structure for table `house`
--

DROP TABLE IF EXISTS `house`;
CREATE TABLE IF NOT EXISTS `house` (
  `house_no` varchar(10) NOT NULL,
  `plot_no` varchar(10) NOT NULL,
  `property_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`house_no`,`plot_no`),
  UNIQUE KEY `property_id` (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `house`
--

INSERT INTO `house` (`house_no`, `plot_no`, `property_id`) VALUES
('H1', 'P1', 54),
('H5', 'P-20', 62),
('H10', 'P8', 63);

-- --------------------------------------------------------

--
-- Table structure for table `interested`
--

DROP TABLE IF EXISTS `interested`;
CREATE TABLE IF NOT EXISTS `interested` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) UNSIGNED NOT NULL,
  `phone_number` bigint(20) UNSIGNED NOT NULL,
  `alt_phone_number` bigint(20) UNSIGNED NOT NULL,
  `email_id` varchar(100) NOT NULL,
  PRIMARY KEY (`property_id`,`user_id`),
  UNIQUE KEY `id` (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `interested`
--

INSERT INTO `interested` (`id`, `property_id`, `user_id`, `phone_number`, `alt_phone_number`, `email_id`) VALUES
(2, 62, 17, 8746312007, 9874632150, 'rakesh@gmail.com'),
(1, 64, 18, 1223697452, 9874632155, 'hinole@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `otp_table`
--

DROP TABLE IF EXISTS `otp_table`;
CREATE TABLE IF NOT EXISTS `otp_table` (
  `otp` int(7) UNSIGNED DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `expire` varchar(30) NOT NULL,
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plot`
--

DROP TABLE IF EXISTS `plot`;
CREATE TABLE IF NOT EXISTS `plot` (
  `plot_number` varchar(10) NOT NULL,
  `property_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`plot_number`),
  UNIQUE KEY `property_id` (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plot`
--

INSERT INTO `plot` (`plot_number`, `property_id`) VALUES
('P4', 58);

-- --------------------------------------------------------

--
-- Table structure for table `pm_category`
--

DROP TABLE IF EXISTS `pm_category`;
CREATE TABLE IF NOT EXISTS `pm_category` (
  `category_id` int(4) NOT NULL,
  `category_name` varchar(10) NOT NULL,
  `capacity` float NOT NULL,
  `base_price` int(11) NOT NULL,
  `no_of_trucks` int(11) NOT NULL,
  `price_km` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pm_category`
--

INSERT INTO `pm_category` (`category_id`, `category_name`, `capacity`, `base_price`, `no_of_trucks`, `price_km`) VALUES
(1001, 'Very Small', 0.85, 2000, 20, 10),
(1002, 'Small', 1.5, 4000, 7, 20),
(1003, 'Medium', 2.5, 5000, 10, 20),
(1004, 'Large', 5, 7000, 8, 20),
(1005, 'Very Large', 10, 10000, 5, 25);

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

DROP TABLE IF EXISTS `property`;
CREATE TABLE IF NOT EXISTS `property` (
  `property_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id of the property',
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `category` varchar(15) NOT NULL DEFAULT '''rent''' COMMENT 'Whether the property is on rent or for sale',
  `description` text NOT NULL COMMENT 'Description of the property',
  `images` varchar(200) NOT NULL COMMENT 'Set of all images and videos of the property',
  `area` float UNSIGNED NOT NULL COMMENT 'Area (in sq. ft) of the property',
  `age` int(6) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1 COMMENT='Property table, to store basic details of the property';

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`property_id`, `latitude`, `longitude`, `category`, `description`, `images`, `area`, `age`) VALUES
(54, 15.494216733119554, 73.83145199520874, 'sale', 'Near Panjim Bus Stand, near Mala Lake and State Central Library', 'media/rounaknaik/1639508160house1.jpg', 100, 5),
(56, 15.484935076440571, 73.82195068829269, 'both', 'Society Playground, Fully furnished flat', 'media/rounakn/house1.jpg', 80, 13),
(58, 15.56030639763187, 74.02505253229158, 'sale', 'Near Park, Playground, Ravindra Bhavan and KTC Bus Stand', 'media/rounakn/1639509422house_074248.jpg', 100, NULL),
(62, 15.499739416138327, 73.83140301592685, 'rent', 'Near Panjim Jetty', 'media/rounakn/1639510113house_074248.jpg', 100, 1),
(63, 15.491381235008433, 73.83169602473076, 'both', 'Near Panjim Bus Stand and State Central Library', 'media/rakesh1234/house1.jpg', 90, 4),
(64, 15.479639202958026, 73.81074694504717, 'sale', 'Near Miramar Beach', 'media/rakesh1234/house_074248.jpg', 100, 0),
(65, 15.479414410696876, 73.80851520831827, 'rent', 'Near Miramar Beach, sea view flat', 'media/rakesh1234/1639511067house_074248.jpg', 120, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rent_price`
--

DROP TABLE IF EXISTS `rent_price`;
CREATE TABLE IF NOT EXISTS `rent_price` (
  `property_id` int(6) UNSIGNED NOT NULL,
  `rprice` int(10) DEFAULT NULL,
  PRIMARY KEY (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rent_price`
--

INSERT INTO `rent_price` (`property_id`, `rprice`) VALUES
(56, 20000),
(62, 15000),
(63, 15000),
(65, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `rent_request`
--

DROP TABLE IF EXISTS `rent_request`;
CREATE TABLE IF NOT EXISTS `rent_request` (
  `rr_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) UNSIGNED NOT NULL,
  `request_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `no_of_people` int(10) UNSIGNED NOT NULL,
  `request_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(6) UNSIGNED NOT NULL,
  `property_id` int(6) UNSIGNED NOT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `rating` float NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `property_id` (`property_id`),
  KEY `review_ibfk_2` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `property_id`, `comment`, `rating`) VALUES
(2, 16, 54, NULL, 3),
(3, 17, 54, 'It is a good property', 4),
(4, 18, 54, 'It is a good property', 3),
(5, 17, 54, 'Good', 3),
(6, 16, 54, 'Bad Place', 1),
(7, 16, 54, 'Ok', 1),
(8, 16, 54, 'Ok', 1),
(9, 16, 54, 'ok', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sale_price`
--

DROP TABLE IF EXISTS `sale_price`;
CREATE TABLE IF NOT EXISTS `sale_price` (
  `property_id` int(6) UNSIGNED NOT NULL,
  `price` int(10) DEFAULT NULL,
  PRIMARY KEY (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_price`
--

INSERT INTO `sale_price` (`property_id`, `price`) VALUES
(54, 7000000),
(56, 10000000),
(58, 2000000),
(63, 8000000),
(64, 10000000);

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

DROP TABLE IF EXISTS `tenant`;
CREATE TABLE IF NOT EXISTS `tenant` (
  `property_id` int(6) UNSIGNED NOT NULL,
  `tenant_id` int(6) UNSIGNED NOT NULL,
  `rprice` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `no_of_people` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`property_id`,`tenant_id`,`start_date`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`property_id`, `tenant_id`, `rprice`, `start_date`, `end_date`, `no_of_people`) VALUES
(62, 17, 15000, '2022-01-01', NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `age` int(3) UNSIGNED NOT NULL,
  `dp` varchar(300) DEFAULT 'media/default.jpg',
  `email` varchar(50) NOT NULL,
  `gender` int(2) NOT NULL DEFAULT '1',
  `username` varchar(20) NOT NULL,
  `phone_number` varchar(11) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `age`, `dp`, `email`, `gender`, `username`, `phone_number`, `password`) VALUES
(15, 'Rounak Ajit Naik', 20, 'media/rounaknaik/dp20211215001405.jpg', 'rounaknaik8@gmail.com', 1, 'rounaknaik', '9130346772', '$2y$10$AC08mIj.CqGHTU5Aegm2zePpopk1Y3TuglZPwf.fLH15opTo8t1ku'),
(16, 'Rounak Naik', 20, 'media/rounakn/dp20211215002920.jpg', 'rounaknaik23@gmail.com', 1, 'rounakn', '8010076079', '$2y$10$3WQbW6Ni6SrGzBvqTLNzG.Hao8r08toUAdhWkbDjrnubxhgQqSWPG'),
(17, 'Rakesh Mishra', 25, 'media/rakesh1234/dp20211215010939.jpg', 'yihibov551@ningame.com', 3, 'rakesh1234', '9012576312', '$2y$10$bX3H/z2lHptVtne6Wpg0R.ybqkNBKqH2V4dNA3.X8bLVoG0tQZsie'),
(18, 'Hinole Smith', 30, 'media/hinole/dp20211215012005.jpg', 'hinole9669@leanrights.com', 2, 'hinole', '8749630110', '$2y$10$Sym0/IlTcBSZa4csV6DcB.JNkM.N.jxmJ5HZlmLskqerbZUSit3TC'),
(19, 'Sairaj Naik', 20, 'media/sairajnaik/dp20211216124637.jpg', 'naiksairaj332@gmail.com', 1, 'sairajnaik', '9834495821', '$2y$10$kQQHfipXawZg9VOu12bCL.xYL2USdkVagUisPZzfjaIZkc7bwus0e');

-- --------------------------------------------------------

--
-- Table structure for table `user_buys`
--

DROP TABLE IF EXISTS `user_buys`;
CREATE TABLE IF NOT EXISTS `user_buys` (
  `seller_id` int(6) UNSIGNED NOT NULL,
  `property_id` int(6) UNSIGNED NOT NULL,
  `price` bigint(20) NOT NULL,
  `buys_on` date NOT NULL,
  `buyer_id` int(6) UNSIGNED NOT NULL,
  PRIMARY KEY (`seller_id`,`property_id`,`buys_on`,`buyer_id`),
  KEY `buyer_id` (`buyer_id`),
  KEY `user_buys_ibfk_2` (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_owns`
--

DROP TABLE IF EXISTS `user_owns`;
CREATE TABLE IF NOT EXISTS `user_owns` (
  `user_id` int(6) UNSIGNED NOT NULL,
  `property_id` int(6) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`,`property_id`),
  KEY `user_owns_ibfk_1` (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_owns`
--

INSERT INTO `user_owns` (`user_id`, `property_id`) VALUES
(15, 54),
(16, 56),
(16, 58),
(16, 62),
(17, 63),
(17, 64),
(17, 65);

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
CREATE TABLE IF NOT EXISTS `visits` (
  `visit_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(6) UNSIGNED NOT NULL,
  `property_id` int(6) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `request_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`property_id`,`date`),
  UNIQUE KEY `visit_id` (`visit_id`),
  KEY `property_id` (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`visit_id`, `user_id`, `property_id`, `date`, `request_status`) VALUES
(1, 18, 54, '2021-12-22', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `pm_category` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `flat`
--
ALTER TABLE `flat`
  ADD CONSTRAINT `flat_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE;

--
-- Constraints for table `house`
--
ALTER TABLE `house`
  ADD CONSTRAINT `house_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE;

--
-- Constraints for table `interested`
--
ALTER TABLE `interested`
  ADD CONSTRAINT `interested_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interested_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `plot`
--
ALTER TABLE `plot`
  ADD CONSTRAINT `plot_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE;

--
-- Constraints for table `rent_price`
--
ALTER TABLE `rent_price`
  ADD CONSTRAINT `rent_price_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_price`
--
ALTER TABLE `sale_price`
  ADD CONSTRAINT `sale_price_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE;

--
-- Constraints for table `tenant`
--
ALTER TABLE `tenant`
  ADD CONSTRAINT `tenant_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tenant_ibfk_2` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_buys`
--
ALTER TABLE `user_buys`
  ADD CONSTRAINT `user_buys_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_buys_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_buys_ibfk_3` FOREIGN KEY (`seller_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_owns`
--
ALTER TABLE `user_owns`
  ADD CONSTRAINT `user_owns_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_owns_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `property` (`property_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `visits_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
