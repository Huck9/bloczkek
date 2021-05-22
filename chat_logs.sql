-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 22 Maj 2021, 23:37
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.6

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
-- Struktura tabeli dla tabeli `chat_logs`
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
-- Zrzut danych tabeli `chat_logs`
--

INSERT INTO `chat_logs` (`log_id`, `from_user`, `to_user`, `date`, `time`, `content`) VALUES
(128, 4, 5, '2021-05-22', '23:35:26', 'test message 1'),
(129, 5, 4, '2021-05-22', '23:35:56', 'tstmsg 2'),
(130, 5, 4, '2021-05-22', '23:36:13', 'msg3'),
(131, 4, 5, '2021-05-22', '23:36:18', 'msg4');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `chat_logs`
--
ALTER TABLE `chat_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `from_user` (`from_user`),
  ADD KEY `to_user` (`to_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `chat_logs`
--
ALTER TABLE `chat_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `chat_logs`
--
ALTER TABLE `chat_logs`
  ADD CONSTRAINT `chat_logs_ibfk_1` FOREIGN KEY (`from_user`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `chat_logs_ibfk_2` FOREIGN KEY (`to_user`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
