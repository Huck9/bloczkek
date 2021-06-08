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

--
-- Struktura tabeli dla tabeli `buildings`
--

CREATE TABLE `buildings` (
                             `id` int(11) NOT NULL,
                             `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `buildings`
--

INSERT INTO `buildings` (`id`, `name`) VALUES
(1, 'Wojska Polskiego 1');

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

--
-- Table structure for table `faults`
--

CREATE TABLE `faults` (
                            `faultID` int(10) NOT NULL,
                            `userID` int(20) NOT NULL,
                            `description` VARCHAR(300) NOT NULL,
                            `status` int(1) NOT NULL,
                            `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faults`
--

INSERT INTO `faults` (`faultID`, `userID`, `description`, `status`, `date`) VALUES
(1, 7, 'Kamera nie działa w godzinach 8-10', 0, '2021-06-02');

--
-- Struktura tabeli dla tabeli `cameras`
--

CREATE TABLE `cameras` (
                           `id` int(16) NOT NULL,
                           `link` varchar(100) NOT NULL,
                           `building_id` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `cameras`
--

INSERT INTO `cameras` (`id`, `link`, `building_id`) VALUES
(1, 'https://www.youtube.com/watch?v=d7qNZ_QAz0Y&list=RDEMu1xWH1tb60B92F4R9UVNoA&start_radio=1', 1);

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
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
                         `userID` int(16) NOT NULL,
                         `name` varchar(50) NOT NULL,
                         `surname` varchar(50) NOT NULL,
                         `login` varchar(50) NOT NULL,
                         `email` varchar(50) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `salt` varchar(10) NOT NULL,
                         `accountType` varchar(50) NOT NULL,
                         `building_id` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `name`, `surname`, `login`, `email`, `password`, `salt`, `accountType`, `building_id`) VALUES
(4, 'Stefan', 'Kobza', 'stefankobza', 'stefan@kobza.pl', '18612578641ae34bc4a20a233b1467f31154701205449a2fe760961067540197', 'WFQ6mA4Oxx', 'user', 1),
(5, 'Kamil', 'Wons', 'kwons@123', 'kwons@wp.pl', '3fa4b7e8be77d099250754892fa10208fa7b99d47694c203774ee0d2fb1cc882', 'HHtQhQJRG5', 'ADMIN', 0),
(6, 'Trol', 'Trolooo', 'pracownik', 'pracownik@zut.edu.pl', 'b633ac963d2d6c55835792880baa23a8cda62de30f77f669084d8d47fccedb92', 'IuQKCC3Br0', 'worker', 0),
(7, 'Jan', 'Kowal', 'kowal', 'kowal@wp.pl', 'ca4e0c298de64f8e7833d5f70c0b36c5b2c8fb2a016c74563e38fac8696e103d', 'bcnMf4YXFK', 'user', 1);

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
-- Indexes for table `faults`
--
ALTER TABLE `faults`
    ADD PRIMARY KEY (`faultID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

-- Indeksy dla tabeli `buildings`
--
ALTER TABLE `buildings`
    ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `cameras`
--
ALTER TABLE `cameras`
    ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `faults`
--
ALTER TABLE `faults`
    MODIFY `faultID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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

-- AUTO_INCREMENT dla tabeli `buildings`
--
ALTER TABLE `buildings`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `cameras`
--
ALTER TABLE `cameras`
    MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
