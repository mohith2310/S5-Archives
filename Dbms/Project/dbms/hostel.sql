-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 27, 2020 at 08:27 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.25

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
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `Admin_ID` int(3) NOT NULL,
  `Fname` varchar(10) DEFAULT NULL,
  `Lname` varchar(10) DEFAULT NULL,
  `Mail` varchar(40) DEFAULT NULL,
  `Hostel_ID` int(3) DEFAULT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`Admin_ID`, `Fname`, `Lname`, `Mail`, `Hostel_ID`, `password`) VALUES
(1, 'Harry', 'Potter', 'admin1@gmail.com', 1, 'admin1'),
(2, 'Severus', 'Snape', 'admin2@gmail.com', 2, 'admin2'),
(3, 'Albus', 'Dumbledore', 'admin3@gmail.com', 7, 'admin3'),
(4, 'Ronald', 'Weasly', 'admin4@gmail.com', 10, 'admin4'),
(5, 'avinash', 'sam', 'admin5@gmail.com', 11, 'admin5'),
(6, 'Tony', 'Stark', 'admin6@gmail.com', 12, 'admin6'),
(7, 'bahubali', 'mahendra', 'admin7@gmail.com', 18, 'admin7'),
(8, 'kick', 'buttowski', 'admin8@gmail.com', NULL, 'admin8');

-- --------------------------------------------------------

--
-- Table structure for table `COMPLAINTS`
--

CREATE TABLE `COMPLAINTS` (
  `Complaint_No` int(11) NOT NULL,
  `Subject` tinytext DEFAULT NULL,
  `Complaint_Status` int(2) DEFAULT 0,
  `Admin_ID` int(3) DEFAULT NULL,
  `Student_ID` varchar(15) DEFAULT NULL,
  `Hostel_ID` int(3) DEFAULT NULL,
  `room_no` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `FURNITURE`
--

CREATE TABLE `FURNITURE` (
  `Hostel_ID` int(3) NOT NULL,
  `Room_No` int(5) NOT NULL,
  `Type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `HOSTELS`
--

CREATE TABLE `HOSTELS` (
  `Hostel_ID` int(3) NOT NULL,
  `Hostel_name` varchar(10) NOT NULL,
  `No_of_rooms` int(5) NOT NULL,
  `Vacant_rooms` int(5) DEFAULT NULL,
  `Monthly_expenses` int(8) DEFAULT NULL,
  `Landmark` tinytext DEFAULT NULL,
  `Gender_flag` varchar(1) NOT NULL,
  `Admin_ID` int(3) DEFAULT NULL,
  `Batch` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `HOSTELS`
--

INSERT INTO `HOSTELS` (`Hostel_ID`, `Hostel_name`, `No_of_rooms`, `Vacant_rooms`, `Monthly_expenses`, `Landmark`, `Gender_flag`, `Admin_ID`, `Batch`) VALUES
(1, 'A', 20, 19, NULL, 'SBI circle', 'M', 1, 1),
(2, 'PG-2', 20, 20, NULL, 'SBI circle', 'M', 2, 1),
(7, 'Mega', 20, 20, NULL, 'near IH', 'M', 3, 2),
(10, 'C', 20, 20, NULL, 'near mini', 'M', 4, 2),
(11, 'D', 20, 17, NULL, 'near C', 'M', 5, 3),
(12, 'IH', 20, 20, NULL, 'near IH', 'M', 6, 3),
(18, 'F', 20, 20, NULL, 'near mini', 'M', 7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `NOTICES`
--

CREATE TABLE `NOTICES` (
  `Notice_ID` int(7) NOT NULL,
  `Subject` tinytext DEFAULT NULL,
  `Admin_ID` int(3) NOT NULL,
  `student_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `NOTICES`
--

INSERT INTO `NOTICES` (`Notice_ID`, `Subject`, `Admin_ID`, `student_id`) VALUES
(1, 'New Hostel Update', 1, '0'),
(3, 'Your complaint :Fan not working.. has been Cleared..', 1, 'b180409cs'),
(5, 'Your complaint :joking has been rejected.', 1, 'b180409cs'),
(7, 'Your complaint :hello admin has been Accepted..', 1, 'b180409cs'),
(8, 'Your complaint :hello admin has been Cleared..', 1, 'b180409cs'),
(9, 'how are you guys?', 1, '1'),
(10, 'Your complaint :i am good.. has been Accepted..', 5, 'b180299cs'),
(11, 'Your complaint :i am good.. has been Cleared..', 5, 'b180299cs'),
(12, 'Your complaint :wasup? has been rejected.', 5, 'b180299cs');

-- --------------------------------------------------------

--
-- Table structure for table `ROOM`
--

CREATE TABLE `ROOM` (
  `Hostel_ID` int(3) NOT NULL,
  `Room_No` int(4) NOT NULL,
  `Vacancies` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ROOM`
--

INSERT INTO `ROOM` (`Hostel_ID`, `Room_No`, `Vacancies`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 2),
(1, 4, 2),
(1, 5, 2),
(1, 6, 2),
(1, 7, 2),
(1, 8, 2),
(1, 9, 2),
(1, 10, 2),
(1, 11, 2),
(1, 12, 2),
(1, 13, 2),
(1, 14, 2),
(1, 15, 2),
(1, 16, 2),
(1, 17, 2),
(1, 18, 2),
(1, 19, 2),
(1, 20, 2),
(2, 1, 2),
(2, 2, 2),
(2, 3, 2),
(2, 4, 2),
(2, 5, 2),
(2, 6, 2),
(2, 7, 2),
(2, 8, 2),
(2, 9, 2),
(2, 10, 2),
(2, 11, 2),
(2, 12, 2),
(2, 13, 2),
(2, 14, 2),
(2, 15, 2),
(2, 16, 2),
(2, 17, 2),
(2, 18, 2),
(2, 19, 2),
(2, 20, 2),
(7, 1, 2),
(7, 2, 2),
(7, 3, 2),
(7, 4, 2),
(7, 5, 2),
(7, 6, 2),
(7, 7, 2),
(7, 8, 2),
(7, 9, 2),
(7, 10, 2),
(7, 11, 2),
(7, 12, 2),
(7, 13, 2),
(7, 14, 2),
(7, 15, 2),
(7, 16, 2),
(7, 17, 2),
(7, 18, 2),
(7, 19, 2),
(7, 20, 2),
(10, 1, 2),
(10, 2, 2),
(10, 3, 2),
(10, 4, 2),
(10, 5, 2),
(10, 6, 2),
(10, 7, 2),
(10, 8, 2),
(10, 9, 2),
(10, 10, 2),
(10, 11, 2),
(10, 12, 2),
(10, 13, 2),
(10, 14, 2),
(10, 15, 2),
(10, 16, 2),
(10, 17, 2),
(10, 18, 2),
(10, 19, 2),
(10, 20, 2),
(11, 1, 0),
(11, 2, 1),
(11, 3, 1),
(11, 4, 2),
(11, 5, 2),
(11, 6, 2),
(11, 7, 2),
(11, 8, 2),
(11, 9, 2),
(11, 10, 2),
(11, 11, 2),
(11, 12, 2),
(11, 13, 2),
(11, 14, 2),
(11, 15, 2),
(11, 16, 2),
(11, 17, 2),
(11, 18, 2),
(11, 19, 2),
(11, 20, 2),
(12, 1, 2),
(12, 2, 2),
(12, 3, 2),
(12, 4, 2),
(12, 5, 2),
(12, 6, 2),
(12, 7, 2),
(12, 8, 2),
(12, 9, 2),
(12, 10, 2),
(12, 11, 2),
(12, 12, 2),
(12, 13, 2),
(12, 14, 2),
(12, 15, 2),
(12, 16, 2),
(12, 17, 2),
(12, 18, 2),
(12, 19, 2),
(12, 20, 2);

-- --------------------------------------------------------

--
-- Table structure for table `room_requests`
--

CREATE TABLE `room_requests` (
  `sender_id` varchar(12) NOT NULL,
  `receiver_id` varchar(12) NOT NULL,
  `flag` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_requests`
--

INSERT INTO `room_requests` (`sender_id`, `receiver_id`, `flag`) VALUES
('b180001cs', 'b180111cs', -1),
('b180111cs', 'b180001cs', -1),
('b180111cs', 'b180299cs', -1),
('b180409cs', 'b180299cs', 1),
('b200001cs', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `STUDENTS`
--

CREATE TABLE `STUDENTS` (
  `Student_ID` varchar(15) NOT NULL,
  `full_name` varchar(30) NOT NULL,
  `PhoneNo` varchar(10) NOT NULL,
  `DOB` date DEFAULT NULL,
  `State` varchar(15) DEFAULT NULL,
  `Roomate_ID` varchar(15) DEFAULT NULL,
  `Admin_ID` int(3) DEFAULT NULL,
  `password` varchar(20) NOT NULL,
  `Hostel_ID` int(3) DEFAULT NULL,
  `Room_No` int(5) DEFAULT NULL,
  `mail` varchar(40) NOT NULL,
  `gender` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `STUDENTS`
--

INSERT INTO `STUDENTS` (`Student_ID`, `full_name`, `PhoneNo`, `DOB`, `State`, `Roomate_ID`, `Admin_ID`, `password`, `Hostel_ID`, `Room_No`, `mail`, `gender`) VALUES
('b170001cs', 'snr3', '1253647981', '1999-10-12', 'state2', NULL, NULL, '1594', NULL, NULL, 'snr3@gmail.com', 'M'),
('b170002cs', 'snr2', '1253467981', '1999-10-11', 'state3', NULL, NULL, '1794', NULL, NULL, 'snr2@gmail.com', 'F'),
('b170003cs', 'snr1', '3214567981', '1999-10-10', 'state3', NULL, NULL, '7194', NULL, NULL, 'snr1@gmail.com', 'M'),
('b170004cs', 'snr5', '2536479811', '1999-10-31', 'state5', NULL, NULL, '5914', NULL, NULL, 'snr5@gmail.com', 'F'),
('b170005cs', 'snr4', '1536427981', '1999-10-13', 'state1', NULL, NULL, '4159', NULL, NULL, 'snr4@gmail.com', 'F'),
('b180001cs', 'meghana', '7894561237', '2000-10-26', 'state2', NULL, 5, '7895', 11, 3, 'maggie@gmail.com', 'F'),
('b180111cs', 'rahul', '1234567891', '2000-10-24', 'Rajasthan', NULL, 5, '2345', 11, 2, 'rahul@gmail.com', 'M'),
('b180299cs', 'mohith kumar', '9490915217', '2000-10-23', 'Andhra', 'b180409cs', 5, '1234', 11, 1, 'mohith@gmail.com', 'M'),
('b180345cs', 'kevin', '4567891230', '2000-10-25', 'state1', NULL, NULL, '3456', NULL, NULL, 'kevin@gmail.com', 'F'),
('b180409cs', 'vi', '6303520089', '2001-01-08', 'Andhra', 'b180299cs', 5, '0408', 11, 1, 'vi@gmail.com', 'M'),
('b190001cs', 'jnr1', '1234567891', '2001-10-23', 'state1', NULL, NULL, '7894', NULL, NULL, 'jnr1@gmail.com', 'M'),
('b190002cs', 'jnr2', '1234568791', '2001-10-24', 'state2', NULL, NULL, '7849', NULL, NULL, 'jnr2@gmail.com', 'F'),
('b190003cs', 'jnr3', '1234567981', '2001-10-25', 'state3', NULL, NULL, '1794', NULL, NULL, 'jnr3@gmail.com', 'M'),
('b190005cs', 'jnr5', '2134567981', '2001-10-27', 'state4', NULL, NULL, '7914', NULL, NULL, 'jnr4@gmail.com', 'F'),
('b190040cs', 'jnr4', '1234657981', '2001-10-26', 'state4', NULL, NULL, '1749', NULL, NULL, 'jnr4@gmail.com', 'F'),
('b200001cs', 'ssnr1', '2531647981', '1998-10-17', 'state4', NULL, 1, '1111', 1, 1, 'ssnr1@gmail.com', 'M'),
('b200002cs', 'ssnr2', '5231647981', '1998-10-18', 'state1', NULL, NULL, '1211', NULL, NULL, 'ssnr2@gmail.com', 'M'),
('b200003cs', 'ssnr3', '5231147981', '1998-10-19', 'state1', NULL, NULL, '1231', NULL, NULL, 'ssnr3@gmail.com', 'F'),
('b200004cs', 'ssnr5', '5231147981', '1998-10-21', 'state6', NULL, NULL, '5238', NULL, NULL, 'ssnr5@gmail.com', 'M'),
('b200005cs', 'ssnr4', '5231147981', '1998-10-20', 'state2', NULL, NULL, '1238', NULL, NULL, 'ssnr4@gmail.com', 'F');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `COMPLAINTS`
--
ALTER TABLE `COMPLAINTS`
  ADD PRIMARY KEY (`Complaint_No`),
  ADD KEY `Admin_ID` (`Admin_ID`),
  ADD KEY `Student_ID` (`Student_ID`),
  ADD KEY `Hostel_ID` (`Hostel_ID`);

--
-- Indexes for table `FURNITURE`
--
ALTER TABLE `FURNITURE`
  ADD PRIMARY KEY (`Hostel_ID`,`Room_No`,`Type`);

--
-- Indexes for table `HOSTELS`
--
ALTER TABLE `HOSTELS`
  ADD PRIMARY KEY (`Hostel_ID`),
  ADD UNIQUE KEY `Hostel_ID` (`Hostel_ID`),
  ADD KEY `Admin_ID` (`Admin_ID`);

--
-- Indexes for table `NOTICES`
--
ALTER TABLE `NOTICES`
  ADD PRIMARY KEY (`Notice_ID`,`Admin_ID`),
  ADD KEY `NOTICES_ibfk_1` (`Admin_ID`);

--
-- Indexes for table `ROOM`
--
ALTER TABLE `ROOM`
  ADD PRIMARY KEY (`Hostel_ID`,`Room_No`);

--
-- Indexes for table `room_requests`
--
ALTER TABLE `room_requests`
  ADD PRIMARY KEY (`sender_id`,`receiver_id`);

--
-- Indexes for table `STUDENTS`
--
ALTER TABLE `STUDENTS`
  ADD PRIMARY KEY (`Student_ID`),
  ADD UNIQUE KEY `Student_ID` (`Student_ID`),
  ADD KEY `Roomate_ID` (`Roomate_ID`),
  ADD KEY `Hostel_ID` (`Hostel_ID`,`Room_No`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `Admin_ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `COMPLAINTS`
--
ALTER TABLE `COMPLAINTS`
  MODIFY `Complaint_No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `HOSTELS`
--
ALTER TABLE `HOSTELS`
  MODIFY `Hostel_ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `NOTICES`
--
ALTER TABLE `NOTICES`
  MODIFY `Notice_ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `COMPLAINTS`
--
ALTER TABLE `COMPLAINTS`
  ADD CONSTRAINT `COMPLAINTS_ibfk_1` FOREIGN KEY (`Admin_ID`) REFERENCES `Admin` (`Admin_ID`),
  ADD CONSTRAINT `COMPLAINTS_ibfk_2` FOREIGN KEY (`Student_ID`) REFERENCES `STUDENTS` (`Student_ID`),
  ADD CONSTRAINT `COMPLAINTS_ibfk_3` FOREIGN KEY (`Hostel_ID`) REFERENCES `HOSTELS` (`Hostel_ID`);

--
-- Constraints for table `FURNITURE`
--
ALTER TABLE `FURNITURE`
  ADD CONSTRAINT `FURNITURE_ibfk_1` FOREIGN KEY (`Hostel_ID`,`Room_No`) REFERENCES `ROOM` (`Hostel_ID`, `Room_No`);

--
-- Constraints for table `HOSTELS`
--
ALTER TABLE `HOSTELS`
  ADD CONSTRAINT `HOSTELS_ibfk_1` FOREIGN KEY (`Admin_ID`) REFERENCES `Admin` (`Admin_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `NOTICES`
--
ALTER TABLE `NOTICES`
  ADD CONSTRAINT `NOTICES_ibfk_1` FOREIGN KEY (`Admin_ID`) REFERENCES `Admin` (`Admin_ID`);

--
-- Constraints for table `ROOM`
--
ALTER TABLE `ROOM`
  ADD CONSTRAINT `ROOM_ibfk_1` FOREIGN KEY (`Hostel_ID`) REFERENCES `HOSTELS` (`Hostel_ID`);

--
-- Constraints for table `STUDENTS`
--
ALTER TABLE `STUDENTS`
  ADD CONSTRAINT `STUDENTS_ibfk_1` FOREIGN KEY (`Roomate_ID`) REFERENCES `STUDENTS` (`Student_ID`),
  ADD CONSTRAINT `STUDENTS_ibfk_2` FOREIGN KEY (`Hostel_ID`,`Room_No`) REFERENCES `ROOM` (`Hostel_ID`, `Room_No`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
