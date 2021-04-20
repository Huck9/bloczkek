-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Kwi 2021, 02:26
-- Wersja serwera: 10.4.18-MariaDB
-- Wersja PHP: 8.0.3

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
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
                         `ID` int(16) NOT NULL,
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

INSERT INTO `users` (`ID`, `name`, `surname`, `login`, `email`, `password`, `salt`, `accountType`) VALUES
(4, 'Stefan', 'Kobza', 'stefankobza', 'stefan@kobza.pl', '18612578641ae34bc4a20a233b1467f31154701205449a2fe760961067540197', 'WFQ6mA4Oxx', 'user'),
(5, 'Kamil', 'Wons', 'kwons@123', 'kwons@wp.pl', '3fa4b7e8be77d099250754892fa10208fa7b99d47694c203774ee0d2fb1cc882', 'HHtQhQJRG5', 'ADMIN');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
    MODIFY `ID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
