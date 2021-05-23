-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 23 Maj 2021, 22:43
-- Wersja serwera: 10.4.18-MariaDB
-- Wersja PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `ipz`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `invoices`
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

-- --------------------------------------------------------

--
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
                         `accountType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`userID`, `name`, `surname`, `login`, `email`, `password`, `salt`, `accountType`) VALUES
(4, 'Stefan', 'Kobza', 'stefankobza', 'stefan@kobza.pl', '18612578641ae34bc4a20a233b1467f31154701205449a2fe760961067540197', 'WFQ6mA4Oxx', 'user'),
(5, 'Kamil', 'Wons', 'kwons@123', 'kwons@wp.pl', '3fa4b7e8be77d099250754892fa10208fa7b99d47694c203774ee0d2fb1cc882', 'HHtQhQJRG5', 'ADMIN'),
(8, 'Helena', 'Bamber', 'helenabam', 'helenabam@elo.pl', '30288e44030b91a499e6de005c8497f538e38477cd737ca2d2f798a1dc8b5fab', 'do3cykitBb', 'worker');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_votes`
--

CREATE TABLE `user_votes` (
                              `voteID` int(10) NOT NULL,
                              `userID` int(10) NOT NULL,
                              `votingID` int(10) NOT NULL,
                              `answer` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `votings`
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
-- Zrzut danych tabeli `votings`
--

INSERT INTO `votings` (`votingID`, `title`, `date`, `description`, `yes`, `no`, `without_answer`) VALUES
(7, 'asd', '2021-05-05', 'siema', 0, 0, 0),
(8, 'test2', '2021-05-15', 'asdasdsd', 0, 0, 0),
(9, 'dasddas', '2021-05-23', 'asdasdsdasd', 0, 0, 0),
(10, 'dasdasdsfasdfdsad', '2021-05-15', 'sadasdsdasdas', 0, 0, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `invoices`
--
ALTER TABLE `invoices`
    ADD PRIMARY KEY (`invoiceID`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`userID`);

--
-- Indeksy dla tabeli `user_votes`
--
ALTER TABLE `user_votes`
    ADD PRIMARY KEY (`voteID`);

--
-- Indeksy dla tabeli `votings`
--
ALTER TABLE `votings`
    ADD PRIMARY KEY (`votingID`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `invoices`
--
ALTER TABLE `invoices`
    MODIFY `invoiceID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
    MODIFY `userID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `user_votes`
--
ALTER TABLE `user_votes`
    MODIFY `voteID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT dla tabeli `votings`
--
ALTER TABLE `votings`
    MODIFY `votingID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
