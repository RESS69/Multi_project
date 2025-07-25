-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 26, 2024 at 05:46 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mybookdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `BookID` int(4) NOT NULL,
  `BookName` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Genre` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Author` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `BookPrice` int(11) NOT NULL,
  `Status` enum('available','borrowed','sold','booking') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`BookID`, `BookName`, `Genre`, `Author`, `BookPrice`, `Status`) VALUES
(5019, 'how to basic', 'Edu.', 'Egg', 4, 'sold'),
(5020, 'Cartoon', 'Comedy', 'Unknown', 2, 'booking'),
(5022, 'Coding basic', 'Edu.', 'Elon musk', 5, 'booking'),
(5023, 'Ragnarok', 'Comedy', 'Gravity.', 5, 'available'),
(5024, 'Math', 'Edu.', 'Professor', 3, 'sold'),
(5025, 'Cartoon 2', 'Comedy', 'Unknown', 4, 'borrowed'),
(5026, 'PangYa', 'Comedy', 'PlayPark.co', 2, 'available'),
(5027, 'PangYa ss.2', 'Comedy', 'PlayPark.co', 2, 'available'),
(5028, 'English 1', 'Edu.', 'Mr.Jame', 2, 'available'),
(5029, 'Biological', 'Edu.', 'Ms.Jane', 5, 'available'),
(5030, 'Do YOUR BEST', 'Edu.', 'Someone who you to DO YOU', 3, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `BookingID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BookID` int(11) DEFAULT NULL,
  `BookingDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`BookingID`, `UserID`, `BookID`, `BookingDate`) VALUES
(2, 1, 5017, '2024-10-20'),
(3, 1, 5021, '2024-10-20'),
(4, 1, 5021, '2024-10-20'),
(5, 1, 5022, '2024-10-20'),
(6, 1, 5020, '2024-10-26');

-- --------------------------------------------------------

--
-- Table structure for table `borrowing`
--

CREATE TABLE `borrowing` (
  `BorrowingID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BookID` int(11) DEFAULT NULL,
  `BorrowDate` date DEFAULT NULL,
  `ReturnDate` date DEFAULT NULL,
  `Status` enum('borrowed','returned') NOT NULL DEFAULT 'borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `borrowing`
--

INSERT INTO `borrowing` (`BorrowingID`, `UserID`, `BookID`, `BorrowDate`, `ReturnDate`, `Status`) VALUES
(12, 1, 5020, '2024-10-20', '2024-10-21', 'returned'),
(13, 1, 5025, '2024-10-25', '2024-10-25', 'returned'),
(14, 1, 5020, '2024-10-25', '2024-10-25', 'returned'),
(15, 1, 5025, '2024-10-26', NULL, 'borrowed');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `PurchaseID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BookID` int(11) DEFAULT NULL,
  `PurchaseDate` date DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`PurchaseID`, `UserID`, `BookID`, `PurchaseDate`, `Amount`) VALUES
(6, 2, 5017, '2024-10-20', '0.00'),
(7, 1, 5018, '2024-10-20', '0.00'),
(8, 1, 5019, '2024-10-20', '0.00'),
(9, 1, 5024, '2024-10-26', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Role`) VALUES
(1, 'test', '$2y$10$tDZclCFDz2uNSTfqH4gk0emft/73UgNX0Nr3PDtWvzZqL.DN9/llC', 'user'),
(2, 'admin', '$2y$10$JkW7oCC6ej5lUqutS4KtQuMAwsL9BVTcoLfkXvMbufgAqLUQJ8uTC', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`BookID`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `borrowing`
--
ALTER TABLE `borrowing`
  ADD PRIMARY KEY (`BorrowingID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`PurchaseID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `BookID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5031;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `borrowing`
--
ALTER TABLE `borrowing`
  MODIFY `BorrowingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `PurchaseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `borrowing`
--
ALTER TABLE `borrowing`
  ADD CONSTRAINT `borrowing_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
