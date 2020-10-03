-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 28, 2020 at 08:54 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `litostsc_otp_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `medication`
--

CREATE TABLE `medication` (
  `Id` int(11) NOT NULL,
  `medication_name` varchar(200) NOT NULL,
  `dosage` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `once_day` varchar(50) NOT NULL,
  `once_month` varchar(50) NOT NULL,
  `meal` tinyint(1) NOT NULL,
  `once_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medication`
--

INSERT INTO `medication` (`Id`, `medication_name`, `dosage`, `user_id`, `once_day`, `once_month`, `meal`, `once_date`) VALUES
(33, 'Diabetes', '5mg', 16, '1', 'NOP', 1, '2020-09-27'),
(34, 'Colon Spray', '10mg', 16, '1', 'NOP', 0, '2020-09-27'),
(35, 'price', 'dose', 13, '0', 'NOP', 1, '2020-09-28'),
(36, 'price', 'dose', 13, 'NOP', 'month', 1, 'NOP');

-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE `times` (
  `Id` int(11) NOT NULL,
  `medication_id` int(11) NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `times`
--

INSERT INTO `times` (`Id`, `medication_id`, `time`) VALUES
(41, 33, '14:05:00'),
(42, 33, '17:00:00'),
(43, 34, '14:05:00'),
(44, 34, '17:03:00'),
(45, 35, '13:30:00'),
(46, 36, '13:32:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `phone_number` varchar(180) NOT NULL,
  `password` varchar(100) NOT NULL,
  `UTC_val` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `phone_number`, `password`, `UTC_val`) VALUES
(13, '+923118415087', '727113', 5),
(14, '+9203069616833', '249050', -12),
(15, '+923044762779', '425055', -12),
(16, '+17327892834', '737831', -5);

-- --------------------------------------------------------

--
-- Table structure for table `week`
--

CREATE TABLE `week` (
  `Id` int(11) NOT NULL,
  `medication_id` int(11) NOT NULL,
  `week` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medication`
--
ALTER TABLE `medication`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `times`
--
ALTER TABLE `times`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `medication_id` (`medication_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `week`
--
ALTER TABLE `week`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `medication_id` (`medication_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medication`
--
ALTER TABLE `medication`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `times`
--
ALTER TABLE `times`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `week`
--
ALTER TABLE `week`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medication`
--
ALTER TABLE `medication`
  ADD CONSTRAINT `medication_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`);

--
-- Constraints for table `times`
--
ALTER TABLE `times`
  ADD CONSTRAINT `times_ibfk_1` FOREIGN KEY (`medication_id`) REFERENCES `medication` (`Id`);

--
-- Constraints for table `week`
--
ALTER TABLE `week`
  ADD CONSTRAINT `week_ibfk_1` FOREIGN KEY (`medication_id`) REFERENCES `medication` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
