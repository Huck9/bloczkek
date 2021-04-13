-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 13 Kwi 2021, 19:31
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
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `ID` int(16) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `accountType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`ID`, `name`, `surname`, `login`, `email`, `password`, `accountType`) VALUES
(1, 'ADMIN', 'ADMIN', 'ADMIN', 'ADMIN', '73acd9a5972130b75066c82595a1fae3', 'ADMIN'),
(2, 'Rossmann', 'XDDD', 'alfred90', 'siema@elo.pl', '8ee22e2997a001aaf96cbf5d35a8b8e4', 'user'),
(3, 'asdasfas', 'fas', 'asdfasdf', 'siema@elo.pl', '26c651755d2aba183c4fde5f0b17bd66', 'user'),
(4, 'dgsgsdg', 'sdfsdfsd', 'asdasd', 'siema@elo.pl', '813accfbec3d393e659d47f2a4fb4b3d', 'user'),
(5, 'XDD', 'XDD', 'XDD', 'XDD', 'XDD', 'XDD'),
(6, 'asdasfs', 'asjhdag', 'ksajdhaskd', 'siema@elo.pl', '1a06316728878fe217bb735551514549', 'user'),
(7, 'aslkdfjald', 'laskdjald', 'dlkfjal', 'cozababa@ja.kurwie', 'e6cea7aa1f512e6da0ff0e8d72bd4323', 'user');

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
  MODIFY `ID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
