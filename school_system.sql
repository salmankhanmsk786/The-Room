-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2023 at 05:42 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_number` int(11) NOT NULL,
  `student_ids` text NOT NULL,
  `message` text DEFAULT NULL,
  `faculty_comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_number`, `student_ids`, `message`, `faculty_comment`) VALUES
(1, '1,2,12', 'Physics Majors', 'Hello Sophie !!'),
(2, '3,12', 'Chemistry Majors', ''),
(3, '4,5,6,7,8,9,10,11,12', 'Art Majors', 'Hello Physics class!!');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `role` enum('student','faculty') NOT NULL,
  `is_logged_in` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`user_id`, `first_name`, `last_name`, `password`, `photo`, `role`, `is_logged_in`) VALUES
(1, 'Ali', 'Khan', 'abc', 'https://icons.iconarchive.com/icons/diversity-avatars/avatars/256/robot-02-icon.png', 'student', 0),
(2, 'Sophie ', 'Lopez', '123', 'https://cdn1.iconfinder.com/data/icons/Superhero_Avatars/300/Black_Widow.png', 'student', 1),
(3, 'Emily', 'Jones', '456', 'https://api.ambr.top/assets/UI/UI_AvatarIcon_Klee.png?vh=2023092501', 'student', 1),
(4, 'Michael', 'Brown', 'def', 'https://icons.iconarchive.com/icons/iconarchive/incognito-animals/256/Bear-Avatar-icon.png', 'student', 1),
(5, 'Sarah', 'Davis', 'ghi', NULL, 'student', 1),
(6, 'John', 'Doe', 'abc', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7RaG9lqvqJIkAIbIHMBCqpLB07QLPbyv4lg&usqp=CAU', 'student', 1),
(7, 'Jane', 'Smite', '123', 'https://static.vecteezy.com/system/resources/previews/002/002/297/non_2x/beautiful-woman-avatar-character-icon-free-vector.jpg', 'student', 0),
(8, 'Harry', 'Potter', 'abc123', 'https://cdn.iconscout.com/icon/free/png-256/free-harry-potter-1400849-1189177.png', 'student', 1),
(9, 'Rony', 'Weasley', '123abc', 'https://i.pinimg.com/736x/a4/f9/0f/a4f90f8db20832b6e4e546cf8c63b976.jpg', 'student', 1),
(10, 'Syar', 'Humayun', 'syar123', 'https://cdn-icons-png.flaticon.com/512/2059/2059570.png', 'student', 1),
(11, 'Omar', 'Khan', 'omar123', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRzY9wDHAooSsdcqjnI8MU9_MsR-TxLXSMi_tR6BvbDzpigFDnfMwbFM_wXKn1BipeClbc&usqp=CAU', 'student', 1),
(12, 'Ron', 'Wade', 'ron123', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMkGbL9oM2zNxKiQTl25DfyHJjBOW8PjYUvg&usqp=CAU', 'faculty', 0),
(13, 'Jon', 'Mendez', 'jon123', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShWnxiYpOXLcekDv3LfaIW0cBG-ipUWeSoErTH9Fy55vfcFcVps18LIcdE8QsnG4REqzA&usqp=CAU', 'faculty', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_number`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
