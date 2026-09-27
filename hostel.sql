-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Oct 12, 2025 at 07:13 PM
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
-- Database: `hostel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(300) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `reg_date`, `updation_date`) VALUES
(1, 'admin', 'anuj.lpu1@gmail.com', 'Test@1234', '2016-04-04 20:31:45', '2016-04-17');

-- --------------------------------------------------------

--
-- Table structure for table `adminlog`
--

CREATE TABLE `adminlog` (
  `id` int(11) NOT NULL,
  `adminid` int(11) NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `logintime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fee_type` varchar(100) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `regno` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `user_id`, `fee_type`, `amount`, `regno`, `created_at`) VALUES
(10, 0, 'hostel', 6000, '31', '2025-09-15 19:42:26'),
(11, 0, 'service', 500, '31', '2025-09-15 19:42:47'),
(12, 0, 'meal', 1500, '31', '2025-09-15 19:43:11'),
(13, 0, 'hostel', 4000, '20010121', '2025-09-15 20:09:49'),
(14, 0, 'service', 500, '20010121', '2025-09-15 20:10:11'),
(15, 0, 'meal', 1500, '20010121', '2025-09-15 20:10:34'),
(16, 0, 'hostel', 4500, '2', '2025-09-25 04:12:32'),
(17, 0, 'hostel', 4500, '90', '2025-09-25 04:27:33'),
(18, 0, 'hostel', 4500, '2', '2025-09-25 04:30:10');

-- --------------------------------------------------------

--
-- Table structure for table `hostelbookings`
--

CREATE TABLE `hostelbookings` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `regno` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `hostelType` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `emergencyName` varchar(100) NOT NULL,
  `emergencyRelation` varchar(50) NOT NULL,
  `emergencyContact` varchar(20) NOT NULL,
  `bookingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `meal_type` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(11,0) NOT NULL,
  `orders` decimal(11,0) NOT NULL,
  `is_special` tinyint(1) NOT NULL,
  `occasion` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `meal_type`, `description`, `price`, `orders`, `is_special`, `occasion`, `created_at`) VALUES
(21, 'dinner', 'Biriyani,chicken and salad', 0, 0, 1, 'Religious festival', '2025-09-15 16:10:48'),
(23, 'breakfast', 'Roti,Aloo bhaji and daal', 50, 0, 0, '', '2025-09-24 16:22:15'),
(24, 'lunch', 'chicken curry, steamed rice, salad', 100, 0, 0, '', '2025-09-25 04:06:09'),
(25, 'dinner', 'Sada vat, Fish, Dal, Vorta,', 100, 0, 0, '', '2025-09-25 04:07:13'),
(26, 'lunch', 'Polao, Roast, Salad, Chatni, Cold Drinks', 200, 0, 1, 'Weekend', '2025-09-25 04:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `meal_id`, `quantity`, `total_price`, `payment_method`, `order_date`, `status`) VALUES
(1, 1, 17, 1, 0.00, 'cash', '2025-09-24 17:06:26', 'pending'),
(2, 24, 16, 1, 0.00, 'cash', '2025-09-24 17:35:39', 'pending'),
(3, 24, 23, 1, 50.00, 'cash', '2025-09-24 17:36:52', 'pending'),
(4, 24, 23, 1, 50.00, 'bkash', '2025-09-24 17:37:05', 'pending'),
(5, 24, 23, 1, 50.00, 'cash', '2025-09-24 18:17:13', 'pending'),
(6, 27, 23, 1, 50.00, 'cash', '2025-09-25 04:03:30', 'pending'),
(7, 27, 24, 1, 100.00, 'bkash', '2025-09-25 04:15:35', 'pending'),
(8, 28, 25, 1, 100.00, 'cash', '2025-09-25 04:25:34', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `regno` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `regno`, `user_id`, `payment_method`, `transaction_id`, `amount`, `status`, `created_at`) VALUES
(4, '31', 155, 'bkash', '01778643448', 8000, 'pending', '2025-09-24 15:14:25');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `roomno` int(11) DEFAULT NULL,
  `seater` int(11) DEFAULT NULL,
  `feespm` int(11) DEFAULT NULL,
  `stayfrom` date DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `regno` int(11) DEFAULT NULL,
  `firstName` varchar(500) DEFAULT NULL,
  `middleName` varchar(500) DEFAULT NULL,
  `lastName` varchar(500) DEFAULT NULL,
  `department` varchar(255) NOT NULL,
  `contactno` bigint(11) DEFAULT NULL,
  `emailid` varchar(500) DEFAULT NULL,
  `guardianName` varchar(500) DEFAULT NULL,
  `guardianRelation` varchar(500) DEFAULT NULL,
  `guardianContactno` bigint(11) DEFAULT NULL,
  `Address` varchar(500) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `roomno`, `seater`, `feespm`, `stayfrom`, `duration`, `regno`, `firstName`, `middleName`, `lastName`, `department`, `contactno`, `emailid`, `guardianName`, `guardianRelation`, `guardianContactno`, `Address`, `postingDate`, `updationDate`) VALUES
(9, 106, 1, 6000, '2025-09-02', 4, 31, 'Fatima', '', 'jahan', '0', 1860213166, '0', 'Abdul Matin', 'Father', 1817749795, 'Halishohor,Block-B', '2025-09-15 19:40:27', NULL),
(10, 101, 4, 4000, '2025-08-31', 6, 20010121, 'Farjana', 'Yesmin', 'Rifat', '0', 1778643448, '0', 'Abdul Matin', 'Father', 1815111024, 'Bandar,east colony,house-no:05,type:B', '2025-09-15 20:08:12', NULL),
(11, 105, 1, 5500, '2025-09-03', 1, 31, 'Fatima', '', 'jahan', '0', 1860213166, '0', 'Abdul Mannan', 'Father', 1817749795, 'Halishohor,Block-B', '2025-09-24 19:30:31', NULL),
(12, 105, 1, 5500, '2025-09-01', 1, 31, 'Fatima', '', 'jahan', '0', 1860213166, '0', 'Abdul Mannan', 'Father', 1817749795, 'Halishohor,Block-B', '2025-09-24 19:45:58', NULL),
(13, 105, 1, 5500, '2025-09-01', 1, 31, 'Fatima', '', 'jahan', '0', 1860213166, '0', 'Abdul Mannan', 'Father', 1817749795, 'Halishohor,Block-B', '2025-09-24 19:48:23', NULL),
(14, 100, 4, 4500, '2025-09-01', 3, 2, 'Israt', 'Jahan', 'Jahan', '0', 1817749798, '0', 'Mahabul Alam', 'Father', 1817749795, 'bayazid,Block-B', '2025-09-25 04:01:46', NULL),
(15, 100, 4, 4500, '2025-09-25', 6, 90, 'tasnim', '', 'sifat', '0', 90909090909, '0', 'Abdul Mannan', 'Husband', 1979896789, 'rangamati', '2025-09-25 04:24:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `seater` int(11) DEFAULT NULL,
  `room_no` int(11) DEFAULT NULL,
  `fees` int(11) DEFAULT NULL,
  `posting_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `seater`, `room_no`, `fees`, `posting_date`) VALUES
(12, 1, 106, 6000, '2025-09-06 17:58:31'),
(15, 1, 105, 5500, '2025-09-06 18:08:09'),
(16, 4, 100, 4500, '2025-09-07 10:08:50'),
(17, 4, 107, 4500, '2025-09-07 10:13:45'),
(18, 3, 109, 5000, '2025-09-07 10:15:04'),
(23, 1, 12, 6000, '2025-09-07 19:13:10'),
(24, 2, 2, 5500, '2025-09-07 19:15:08'),
(25, 3, 3, 5000, '2025-09-07 19:19:17'),
(32, 4, 101, 4000, '2025-09-15 20:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userIp` varbinary(16) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `loginTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `userId`, `userEmail`, `userIp`, `city`, `country`, `loginTime`) VALUES
(6, 3, '10806121', 0x3a3a31, '', '', '2020-07-20 14:56:45'),
(7, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-08-25 17:29:34'),
(8, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-08-25 19:17:33'),
(9, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-08-26 05:49:54'),
(10, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-08-26 06:41:56'),
(11, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-08-26 07:59:38'),
(12, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-08-26 08:05:18'),
(13, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-08-26 08:12:35'),
(14, 5, 'paulpurna673@gmail.com', 0x3a3a31, '', '', '2025-08-26 08:15:21'),
(15, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-08-26 08:19:53'),
(16, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, '', '', '2025-08-26 08:31:24'),
(17, 7, 'sifatchy100@gmail.com', 0x3a3a31, '', '', '2025-08-26 08:35:36'),
(18, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-08-26 09:22:54'),
(19, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-09-01 17:25:01'),
(20, 8, 'nusrar89@gmail.com', 0x3a3a31, '', '', '2025-09-01 17:29:03'),
(21, 8, 'nusrar89@gmail.com', 0x3a3a31, '', '', '2025-09-01 17:35:31'),
(22, 8, 'nusrar89@gmail.com', 0x3a3a31, '', '', '2025-09-01 18:04:47'),
(23, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-09-01 20:26:19'),
(24, 8, 'nusrar89@gmail.com', 0x3a3a31, '', '', '2025-09-02 04:15:58'),
(25, 8, 'nusrar89@gmail.com', 0x3a3a31, '', '', '2025-09-02 04:30:08'),
(26, 8, 'nusrar89@gmail.com', 0x3a3a31, '', '', '2025-09-02 06:46:42'),
(27, 8, 'nusrar89@gmail.com', 0x3a3a31, '', '', '2025-09-02 06:48:12'),
(28, 8, 'nusrar89@gmail.com', 0x3a3a31, '', '', '2025-09-05 06:10:25'),
(29, 8, 'nusrar89@gmail.com', 0x3a3a31, '', '', '2025-09-05 08:18:03'),
(30, 8, 'nusrar89@gmail.com', 0x3a3a31, '', '', '2025-09-05 17:20:18'),
(31, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, '', '', '2025-09-05 18:00:25'),
(32, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-09-05 18:10:49'),
(33, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-09-05 18:30:37'),
(34, 10, 'ri@gmail.com', 0x3a3a31, '', '', '2025-09-05 18:33:18'),
(35, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, '', '', '2025-09-05 18:40:06'),
(36, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, '', '', '2025-09-05 18:40:31'),
(37, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-09-05 18:40:50'),
(38, 5, 'paulpurna673@gmail.com', 0x3a3a31, '', '', '2025-09-05 18:59:30'),
(39, 5, 'paulpurna673@gmail.com', 0x3a3a31, '', '', '2025-09-05 18:59:49'),
(40, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, '', '', '2025-09-05 19:00:43'),
(41, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, '', '', '2025-09-05 19:01:04'),
(42, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-05 19:26:50'),
(43, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-05 19:29:18'),
(44, 8, 'nusrar89@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-05 19:35:27'),
(45, 7, 'sifatchy100@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 05:49:09'),
(46, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 06:00:33'),
(47, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 06:19:13'),
(48, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 06:53:59'),
(49, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 07:01:28'),
(50, 5, 'paulpurna673@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 07:01:44'),
(51, 8, 'nusrar89@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 07:06:35'),
(52, 8, 'nusrar89@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 07:07:48'),
(53, 8, 'nusrar89@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 07:09:46'),
(54, 8, 'nusrar89@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 07:14:18'),
(55, 8, 'nusrar89@gmail.com', 0x3a3a31, '', '', '2025-09-06 07:15:01'),
(56, 8, 'nusrar89@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 07:16:44'),
(57, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 07:20:17'),
(58, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 10:27:35'),
(59, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 18:51:24'),
(60, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 19:41:55'),
(61, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 19:44:13'),
(62, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 19:44:49'),
(63, 8, 'nusrar89@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 19:51:27'),
(64, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-09-06 20:09:34'),
(65, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-06 20:12:49'),
(66, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-07 06:09:39'),
(67, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-07 06:11:14'),
(68, 8, 'nusrar89@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-07 10:49:11'),
(69, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-07 19:34:10'),
(70, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 06:05:10'),
(71, 5, 'paulpurna673@gmail.com', 0x3a3a31, '', '', '2025-09-08 09:29:25'),
(72, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, '', '', '2025-09-08 14:18:28'),
(73, 5, 'paulpurna673@gmail.com', 0x3a3a31, '', '', '2025-09-08 14:30:26'),
(74, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 14:37:25'),
(75, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 14:38:12'),
(76, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 14:38:14'),
(77, 5, 'paulpurna673@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 14:43:00'),
(78, 5, 'paulpurna673@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 14:43:02'),
(79, 5, 'paulpurna673@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 14:51:27'),
(80, 5, 'paulpurna673@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 14:55:18'),
(81, 5, 'paulpurna673@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 14:55:23'),
(82, 5, 'paulpurna673@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 14:55:40'),
(83, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 14:56:01'),
(84, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 14:56:03'),
(85, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:02:31'),
(86, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:02:32'),
(87, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:03:32'),
(88, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:06'),
(89, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:07'),
(90, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:08'),
(91, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:13'),
(92, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:15'),
(93, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:15'),
(94, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:17'),
(95, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:18'),
(96, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:18'),
(97, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:25'),
(98, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:29'),
(99, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:33'),
(100, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:34'),
(101, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:35'),
(102, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:37'),
(103, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:39'),
(104, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:39'),
(105, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:04:41'),
(106, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:05:43'),
(107, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:08:56'),
(108, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:08:59'),
(109, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:09:27'),
(110, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:09:48'),
(111, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:09:49'),
(112, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:24:04'),
(113, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:24:07'),
(114, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:24:08'),
(115, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:49:46'),
(116, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:58:50'),
(117, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:58:52'),
(118, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 15:58:53'),
(119, 10, 'ri@gmail.com', 0x3a3a31, '', '', '2025-09-08 15:59:13'),
(120, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 16:20:36'),
(121, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 17:01:51'),
(122, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 17:04:02'),
(123, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 17:25:13'),
(124, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, '', '', '2025-09-08 17:48:03'),
(125, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, '', '', '2025-09-08 17:49:03'),
(126, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 17:50:49'),
(127, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 17:54:57'),
(128, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 19:00:36'),
(129, 8, 'nusrar89@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 19:13:22'),
(130, 8, 'nusrar89@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 19:20:58'),
(131, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 20:09:49'),
(132, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 20:10:41'),
(133, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 20:30:19'),
(134, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 20:34:59'),
(135, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-08 20:36:28'),
(136, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-09 03:16:30'),
(137, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-09 03:16:55'),
(138, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-09 03:29:06'),
(139, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-09 03:36:58'),
(140, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-09 03:54:40'),
(141, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-09 04:50:35'),
(142, 4, 'rifatyesmin670@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-09 05:01:58'),
(143, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-13 18:15:28'),
(144, 10, 'ri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-13 18:26:55'),
(145, 8, 'nusrar89@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 16:01:34'),
(146, 6, 'isratjahanmahia48@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 16:12:02'),
(147, 20, 'rifa12@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 16:26:02'),
(148, 22, 'pri@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 17:40:16'),
(149, 23, 'ifa@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 17:54:17'),
(150, 20, 'rifa12@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 18:31:40'),
(151, 20, 'rifa12@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 19:02:29'),
(152, 23, 'ifa@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 19:19:11'),
(153, 20, 'rifa12@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 19:20:46'),
(154, 20, 'rifa12@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 19:22:42'),
(155, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 19:33:34'),
(156, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 19:44:13'),
(157, 26, 'rifatyesmin64@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 20:06:53'),
(158, 26, 'rifatyesmin64@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-15 20:13:18'),
(159, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-16 03:20:32'),
(160, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-16 03:20:54'),
(161, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-16 03:28:33'),
(162, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-16 03:29:07'),
(163, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-24 14:31:26'),
(164, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-24 16:32:41'),
(165, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-24 17:21:52'),
(166, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-24 18:14:07'),
(167, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-24 18:26:57'),
(168, 24, 'fa13@gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-24 18:36:00'),
(169, 27, 'israt@12gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-24 20:22:47'),
(170, 27, 'israt@12gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-25 03:59:53'),
(171, 27, 'israt@12gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-25 04:13:55'),
(172, 28, 'sipat@12gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-25 04:17:56'),
(173, 28, 'sipat@12gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-25 04:28:59'),
(174, 27, 'israt@12gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-25 04:30:31'),
(175, 28, 'sipat@12gmail.com', 0x3a3a31, 'Unknown', 'Unknown', '2025-09-25 06:55:59');

-- --------------------------------------------------------

--
-- Table structure for table `userregistration`
--

CREATE TABLE `userregistration` (
  `id` int(11) NOT NULL,
  `regNo` varchar(255) DEFAULT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `middleName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `department` varchar(100) NOT NULL,
  `contactNo` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(45) DEFAULT NULL,
  `passUdateDate` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `userregistration`
--

INSERT INTO `userregistration` (`id`, `regNo`, `firstName`, `middleName`, `lastName`, `department`, `contactNo`, `email`, `password`, `regDate`, `updationDate`, `passUdateDate`) VALUES
(3, '10806121', 'Anuj', '', 'kumar', '', 1234567890, 'test@gmail.com', 'Test@123', '2020-07-20 14:56:18', NULL, NULL),
(4, '2001011021', 'Farjana ', 'Yesmin', 'Rifat', '', 1778643448, 'rifatyesmin670@gmail.com', '#farjana#', '2025-08-25 17:29:22', '06-09-2025 12:39:11', NULL),
(5, '2001011015', 'Purna', '', 'Paul', '', 1860213166, 'paulpurna673@gmail.com', 'purna12345', '2025-08-26 08:15:10', NULL, NULL),
(6, '2001011001', 'Israt', 'Jahan', 'Mahia', '', 1998191920, 'isratjahanmahia48@gmail.com', '14142525', '2025-08-26 08:31:17', NULL, NULL),
(7, '2001011013', 'sipat ', 'tasnim ', 'maya', '', 1878787899, 'sifatchy100@gmail.com', '121212', '2025-08-26 08:35:27', NULL, NULL),
(8, '2001011016', 'Nusrat', '', 'Jahan', '', 1815111023, 'nusrar89@gmail.com', 'rifat', '2025-09-01 17:28:54', NULL, '09-09-2025 12:45:40'),
(10, '20', 'rifat', '', 'yesmin', '', 4567, 'ri@gmail.com', '12345', '2025-09-05 18:32:47', NULL, NULL),
(11, '30', 'tania', '', 'islam', '', 4578, 'tania@gmail.com', '0', '2025-09-06 08:27:54', NULL, NULL),
(12, '21', 'Fatima', '', 'Islam', '01860213166', 0, '1234', 'CSE', '2025-09-08 16:16:15', NULL, NULL),
(13, '22', 'ss', 'tt', 'mm', '019090909', 0, '78907890', 'CSE', '2025-09-08 16:21:43', NULL, NULL),
(14, '67', 'ffff', 'tt', 'hhh', '1998191920', 0, '098765', 'MGT', '2025-09-08 16:25:26', NULL, NULL),
(15, '2', 'sr', '', 'tt', '01860213166', 0, '12345', 'CSE', '2025-09-08 16:41:33', NULL, NULL),
(16, '1', 'fatima', '', 'islam', '01860213166', 0, '12345', 'CSE', '2025-09-08 16:46:43', NULL, NULL),
(17, '23', 'si', '', 'is', 'Business Administration', 1878787899, 'si@gmail.com', '$2y$10$Re77LY./88oiq/bLkcgryexY4AjYIhWXYwC5Kd5G4uc/4MEi6L95e', '2025-09-13 19:09:45', NULL, NULL),
(18, '25', 'si', '', 'is', 'Business Administration', 1878787899, 'si@132gmail.com', '$2y$10$8QKu1Gp90ERv7FjJ8M76K.CIh.pryJiz.sI9lkr86LUDg.LOZkcBW', '2025-09-13 19:11:01', NULL, NULL),
(19, '26', 'me', '', 'myself', 'Electrical Engineering', 1998191920, 'me@gmail.com', '$2y$10$rzqikPRO3vdY.eOP45.Jqe2krid5brTzLedcfGhoFOjl5IQZ3vbbK', '2025-09-13 19:14:40', NULL, NULL),
(20, '24', 'rifa', '', 'islam', 'Computer Science', 1998191920, 'rifa12@gmail.com', '$2y$10$Emam/Ds/Uapn8NfRu1ts4eNGr6J42.nD2Ru1ZP6zsu4sUzYvzOqyG', '2025-09-15 16:25:47', NULL, NULL),
(21, '27', 'Priyota', '', 'Paul', 'Computer Science', 1878787898, 'prio12@gmail.com', '$2y$10$ELOMWUKdqrs0xk9YeYnr9eyuiYvbRfZVUgoyPd1ULGWtP3BhKi7Nq', '2025-09-15 17:38:09', NULL, NULL),
(22, '28', 'Priyota', '', 'Paul', 'Computer Science', 1878787898, 'pri@gmail.com', '$2y$10$0imjZffpJSvVbhGSpUyLA.BJC1qSMxE7qojJwFChEiRrupNQMj3.G', '2025-09-15 17:39:59', NULL, NULL),
(23, '03', 'Ifat', '', 'jahan', 'Business Administration', 1860213166, 'ifa@gmail.com', '$2y$10$c9GtlpRk.BCVQ9hctyi/EexAnwF1Nm5i3RvVs.NeZnTMxilPN6jZi', '2025-09-15 17:53:57', NULL, NULL),
(24, '31', 'Fatima', '', 'jahan', 'Computer Science', 1860213166, 'fa13@gmail.com', '$2y$10$7nnJ5eHSNEoy4VMGpzpXL.4tCVF8Q4eZ64fufYx0IvMxHjv5dYRVm', '2025-09-15 19:33:19', NULL, NULL),
(25, '200101121', 'Farjana', 'Yesmin', 'Rifat', 'Computer Science', 1778643448, 'rifatyesmin67@gmail.com', '$2y$10$dOzfSRw9XdreREMayn52TefJyAAfxYNxDDukqqzIby0nP8kFND14u', '2025-09-15 20:03:36', NULL, NULL),
(26, '20010121', 'Farjana', 'Yesmin', 'Rifat', 'Computer Science', 1778643448, 'rifatyesmin64@gmail.com', '$2y$10$iiVUG7.PD8iN3Odze0kvm.tguT5fVvyVlFfQ9y8/KRssadzFSgrPG', '2025-09-15 20:06:42', NULL, NULL),
(27, '02', 'Israt', 'Jahan', 'Jahan', 'Computer Science', 1817749798, 'israt@12gmail.com', '$2y$10$VicjHVUgEWb..c89KUp1Tuj23zL9nBqfCQDGqMz8V/RDsa8pf8AqW', '2025-09-24 20:22:30', NULL, NULL),
(28, '90', 'tasnim', '', 'sifat', 'Computer Science', 90909090909, 'sipat@12gmail.com', '$2y$10$bXQS.i11ANRDtHgznxg/7OKPEKRuMap73XeazfJS8fynYA5f4fk0y', '2025-09-25 04:17:45', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hostelbookings`
--
ALTER TABLE `hostelbookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Test` (`user_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_no` (`room_no`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userregistration`
--
ALTER TABLE `userregistration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hostelbookings`
--
ALTER TABLE `hostelbookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `userregistration`
--
ALTER TABLE `userregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hostelbookings`
--
ALTER TABLE `hostelbookings`
  ADD CONSTRAINT `hostelbookings_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `userregistration` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `Test` FOREIGN KEY (`user_id`) REFERENCES `userlog` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
