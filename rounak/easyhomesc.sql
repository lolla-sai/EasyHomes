-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 14, 2021 at 05:42 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`request_id`, `user_id`, `category_id`, `truck_id`, `driver_contactno`, `status`, `booking_time`, `pickup_date`, `pickup_time`, `no_of_trucks`, `source`, `destination`) VALUES
(4, 13, 1002, '89', 5, 1, '2021-12-12 22:29:03', '2021-12-28', '23:46:00', 1, '15.495535821971455,73.83107940419018', '15.495267749045292,73.83650162918825');

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
('T1', 'Heritage Madhuban', 50);

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
('H1', 'P1', 51),
('H2', 'P4', 53);

-- --------------------------------------------------------

--
-- Table structure for table `interested`
--

DROP TABLE IF EXISTS `interested`;
CREATE TABLE IF NOT EXISTS `interested` (
  `property_id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) UNSIGNED NOT NULL,
  `phone_number` bigint(20) UNSIGNED NOT NULL,
  `alt_phone_number` bigint(20) UNSIGNED NOT NULL,
  `email_id` varchar(100) NOT NULL,
  PRIMARY KEY (`property_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

--
-- Dumping data for table `otp_table`
--

INSERT INTO `otp_table` (`otp`, `email`, `expire`) VALUES
(604899, 'leveto5764@idrct.com', '2021-11-14 18:54:51'),
(957072, 'rounaknaik23@gmail.com', '2021-11-27 15:36:54');

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
('P2', 52);

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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1 COMMENT='Property table, to store basic details of the property';

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`property_id`, `latitude`, `longitude`, `category`, `description`, `images`, `area`, `age`) VALUES
(50, 15.485050525937304, 73.82207381165003, 'sale', 'Playground nearby', 'media/rounaknaik1/house1.jpg', 80, 13),
(51, 15.495528283186887, 73.8315820287012, 'rent', 'Near Panjim Bus Stand, near Mala Lake', 'media/rounaknaik1/1638094973house1.jpg', 100, NULL),
(52, 15.492855051368224, 73.83171206219511, 'sale', 'Near Mala Lake and Panjim Bus Stand', 'media/rounaknaik1/1638095016house1.jpg', 90, NULL),
(53, 15.564449956673311, 74.03266181974345, 'both', 'Near Kadamba Bus Stand, Sankhali\r\nNear Sankhali Ravindra Bhavan', 'media/rounaknaik1/1638095336house1.jpg', 100, 10);

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
(53, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `rent_request`
--

DROP TABLE IF EXISTS `rent_request`;
CREATE TABLE IF NOT EXISTS `rent_request` (
  `property_id` int(6) UNSIGNED NOT NULL,
  `user_id` int(6) UNSIGNED NOT NULL,
  `request_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `no_of_people` int(10) UNSIGNED NOT NULL,
  `request_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`property_id`,`user_id`,`request_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rent_request`
--

INSERT INTO `rent_request` (`property_id`, `user_id`, `request_time`, `no_of_people`, `request_status`) VALUES
(53, 5, '2021-12-11 15:54:47', 1, 0),
(53, 13, '2021-12-11 16:12:04', 5, 0),
(53, 13, '2021-12-14 09:30:56', 8, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(50, 20000000),
(52, 2000000),
(53, 20000000);

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

DROP TABLE IF EXISTS `tenant`;
CREATE TABLE IF NOT EXISTS `tenant` (
  `property_id` int(6) UNSIGNED NOT NULL,
  `tenant_id` int(6) UNSIGNED NOT NULL,
  `rprice` int(11) NOT NULL,
  `start_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`property_id`,`tenant_id`,`start_date`),
  KEY `tenant_id` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `age`, `dp`, `email`, `gender`, `username`, `phone_number`, `password`) VALUES
(5, 'Sai Lolla', 20, 'media/lolla-sai/dp20211110160144.jpg', 'saisameer.lolla@gmail.com', 1, 'lolla-sai', '9404181639', '$2y$10$wnYmdHqSc5O9NsWccB50Re./mfbTx1lhlDwS2P.Rb3nPGaOv2hDli'),
(6, 'Rounak Ajit Naik', 20, 'media/rounak_naik/dp20211112155931.jpg', 'rounaknaik8@gmail.com', 1, 'rounak_naik', '9130346772', '$2y$10$PazDmr.Ta/3u0iLRnoFT.umBiEBLJFx6koQo7Wu/Q7WnILHrDgSjm'),
(7, 'Sairaj Bro', 20, 'media/sairaj_naik/dp20211112163807.png', 'naiksairaj332@gmail.com', 1, 'sairaj_naik', '1234567890', '$2y$10$ToVTv.3kVvXuCWIIarYI0ep3qo4yRb/DT/nqFtYwuTvYeCuOdAfI2'),
(8, 'Sasi Lolla', 17, 'media/lolla-sasi/dp20211114123243.png', 'saisasanklolla@gmail.com', 1, 'lolla-sasi', '8275039639', '$2y$10$qGlOG8P76YpMuFxO3Puj8.QMJWf6zq2D4DuuQhI4g5R2GYMqlpVAW'),
(9, 'Leveto Boi', 89, 'media/leveto-5764/dp20211114180909.', 'leveto5764@idrct.com', 2, 'leveto-5764', 'leveto-5764', '$2y$10$lHd23pKShEdMHGRXQmhiH.pzKZUggsMwg5WxkwWTAz4ZrJtK/ZhKO'),
(10, 'Jikaw', 25, 'media/default.jpg', 'jikaw24094@incoware.com', 3, 'jikaw24094', '8275039639', '$2y$10$.Dtc9QU8Zgg6LW9WTlWPD.PkrZJRWvogwj4k3.pRHma72T35SG/hG'),
(11, 'X Omega', 60, 'media/default.jpg', 'xomiga6142@hypteo.com', 3, 'xomega6142', 'jikaw24094', '$2y$10$g8dPeD5uXN4nhtpO.RgvJu9ThoG7D4HXoTrdDVK5UAGLE.Ys7fEuG'),
(12, 'Kewige Gal', 3, 'media/kewige/dp20211114224054.png', 'kewige2651@hypteo.com', 2, 'kewige', 'leveto-5764', '$2y$10$I3x0FJGXtZOScPgiKqP1U.7bOMecj/XtzWNqjQfH.R6n0dlYcHh.a'),
(13, 'Rounak Ajit Naik', 20, 'media/rounaknaik1/dp20211127153401.jpg', 'rounaknaik22@gmail.com', 1, 'rounaknaik1', '8010076079', '$2y$10$/0D/lZL4kue6Gx2a5UfY0ugFa2U9VcjUw38pSjAGQAil3vPNLLsOm'),
(14, 'FIST', 20, 'media/fisttimes/dp20211129215944.png', 'fisttimes19@gmail.com', 1, 'fisttimes', '8010076079', '$2y$10$GUmAg7m6EDrJRgVTFgZtz.GEOq4ARtlkGIVwkwvJa4ZICPV2El1XG');

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
(13, 50),
(13, 51),
(13, 52),
(13, 53);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`visit_id`, `user_id`, `property_id`, `date`, `request_status`) VALUES
(1, 13, 50, '2021-11-29', 0),
(2, 13, 50, '2021-11-30', 0),
(3, 13, 53, '2021-12-23', 0),
(4, 14, 52, '2021-12-01', 0);

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
