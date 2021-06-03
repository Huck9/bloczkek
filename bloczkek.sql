-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2021 at 10:20 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipz`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_logs`
--

CREATE TABLE `chat_logs` (
  `log_id` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `to_user` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat_logs`
--

INSERT INTO `chat_logs` (`log_id`, `from_user`, `to_user`, `date`, `time`, `content`) VALUES
(128, 4, 5, '2021-05-22', '23:35:26', 'test message 1'),
(129, 5, 4, '2021-05-22', '23:35:56', 'tstmsg 2'),
(130, 5, 4, '2021-05-22', '23:36:13', 'msg3'),
(131, 4, 5, '2021-05-22', '23:36:18', 'msg4'),
(132, 4, 8, '2021-05-31', '17:58:56', 'siema Helenko '),
(133, 8, 4, '2021-05-31', '17:59:47', 'cześć Stefan');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoiceID` int(10) NOT NULL,
  `invoiceNumber` int(20) NOT NULL,
  `nettoValue` double NOT NULL,
  `vatValue` double NOT NULL,
  `bruttoValue` double NOT NULL,
  `filename` text NOT NULL,
  `date` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoiceID`, `invoiceNumber`, `nettoValue`, `vatValue`, `bruttoValue`, `filename`, `date`, `status`) VALUES
(3, 65264, 100, 23, 123, '', '2021-05-08', '');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `text` text COLLATE utf8_polish_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `title`, `text`, `date`) VALUES
(4, 'Testowe', 'testowe ogłoszenie ', '2021-06-02'),
(5, 'Testowe2', 'testowe które nie jest opublikowane', '2021-06-24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(16) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `accountType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `name`, `surname`, `login`, `email`, `password`, `salt`, `accountType`) VALUES
(4, 'Stefan', 'Kobza', 'stefankobza', 'stefan@kobza.pl', '18612578641ae34bc4a20a233b1467f31154701205449a2fe760961067540197', 'WFQ6mA4Oxx', 'user'),
(5, 'Kamil', 'Wons', 'kwons@123', 'kwons@wp.pl', '3fa4b7e8be77d099250754892fa10208fa7b99d47694c203774ee0d2fb1cc882', 'HHtQhQJRG5', 'ADMIN'),
(8, 'Helena', 'Bamber', 'helenabam', 'helenabam@elo.pl', '30288e44030b91a499e6de005c8497f538e38477cd737ca2d2f798a1dc8b5fab', 'do3cykitBb', 'worker');

-- --------------------------------------------------------

--
-- Table structure for table `user_votes`
--

CREATE TABLE `user_votes` (
  `voteID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `votingID` int(10) NOT NULL,
  `answer` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_votes`
--

INSERT INTO `user_votes` (`voteID`, `userID`, `votingID`, `answer`) VALUES
(285, 4, 10, 'Wstrzymuje sie');

-- --------------------------------------------------------

--
-- Table structure for table `votings`
--

CREATE TABLE `votings` (
  `votingID` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `yes` int(10) NOT NULL,
  `no` int(10) NOT NULL,
  `without_answer` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `votings`
--

INSERT INTO `votings` (`votingID`, `title`, `date`, `description`, `yes`, `no`, `without_answer`) VALUES
(7, 'asd', '2021-05-05', 'siema', 0, 0, 0),
(8, 'test2', '2021-05-15', 'asdasdsd', 0, 0, 0),
(9, 'dasddas', '2021-05-23', 'asdasdsdasd', 0, 0, 0),
(10, 'dasdasdsfasdfdsad', '2022-05-24', 'sadasdsdasdas', 0, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_logs`
--
ALTER TABLE `chat_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `from_user` (`from_user`),
  ADD KEY `to_user` (`to_user`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoiceID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `user_votes`
--
ALTER TABLE `user_votes`
  ADD PRIMARY KEY (`voteID`);

--
-- Indexes for table `votings`
--
ALTER TABLE `votings`
  ADD PRIMARY KEY (`votingID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_logs`
--
ALTER TABLE `chat_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoiceID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_votes`
--
ALTER TABLE `user_votes`
  MODIFY `voteID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `votings`
--
ALTER TABLE `votings`
  MODIFY `votingID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_logs`
--
ALTER TABLE `chat_logs`
  ADD CONSTRAINT `chat_logs_ibfk_1` FOREIGN KEY (`from_user`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `chat_logs_ibfk_2` FOREIGN KEY (`to_user`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
