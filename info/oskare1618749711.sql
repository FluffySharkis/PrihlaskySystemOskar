-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Počítač: sql.endora.cz:3310
-- Vytvořeno: Pát 21. kvě 2021, 14:48
-- Verze serveru: 5.6.45-86.1
-- Verze PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `oskare1618749711`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `dite`
--

CREATE TABLE `dite` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `narozeni` date NOT NULL,
  `bydliste` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `psc` int(5) NOT NULL,
  `turnus` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `rjmeno` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `rprijmeni` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `remail` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `rtelefon` int(11) NOT NULL,
  `odkud` text COLLATE utf8_czech_ci NOT NULL,
  `gdpr` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `dite`
--

INSERT INTO `dite` (`id`, `jmeno`, `prijmeni`, `narozeni`, `bydliste`, `psc`, `turnus`, `rjmeno`, `rprijmeni`, `remail`, `rtelefon`, `odkud`, `gdpr`, `created`) VALUES
(23, 'Vojtěch', 'Macháček', '1996-05-16', 'Chudenická 1075 ', 10200, 'turnus II', 'Veronika', 'Ilková', 'vojmach2@seznam.cz', 774907911, 'Od kamaráda', 1, '2021-05-04 08:31:21'),
(16, 'Miloslava', 'Pokorna', '2011-02-11', 'Lokal 5, Praha', 14000, 'turnus II', 'Magdaléna', 'Pokorna', 'mail@adf.cz', 985447112, 'Tábor navštěvuji již několik let', 1, '2021-04-28 21:34:33'),
(20, 'Karel', 'Karpíšek', '2000-05-30', 'U Kamýku 78, Praha', 14200, 'turnus II', 'Petr', 'Karpíšek', 'karel-karpisek@centrum.cz', 733248605, 'Již jsem na táboře byl', 1, '2021-04-29 22:56:26'),
(24, 'Petr', 'Novák', '2002-05-20', 'Pod Lipami 8, Praha', 14000, 'turnus II', 'Daniela', 'Nováková', 'novakova@gmail.com', 789455111, 'Od známých', 1, '2021-05-08 23:09:09'),
(25, 'Františka', 'Dlouhá', '2001-05-25', 'Pod Lesíkem 6, Praha', 14300, 'turnus III', 'Ignác', 'Dlouhý', 'dlouhy@gmail.com', 778451211, 'Z webu', 1, '2021-05-08 23:10:36'),
(26, 'Pavel', 'Bílý', '2003-06-25', 'U Potoka 6, Praha', 14300, 'turnus I', 'Irena', 'Bílá', 'bila@gmail.com', 714551211, 'Z facebooku', 1, '2021-05-08 23:11:50'),
(27, 'Filip', 'Sajler', '2003-09-24', 'Vítězná 42, Praha', 14000, 'turnus I', 'Magdaléna', 'Sajlerová', 'msajler@gmail.com', 784114336, 'Z webu', 1, '2021-05-08 23:13:30');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `active`) VALUES
(1, 'Adam', 'adam@domena.tld', '', 1),
(2, 'Eva', 'eva@domena.tld', '$2a$10$CIlRwJepDNwuJTUgrste.uHee4weRVMPfEMdRJzDFK7yVnn1KF70m', 1),
(5, 'Juka', 'juka@seznam.cz', '$2y$10$Ge4PBiU1FoMbFfkYUVhKfec1.KtS2K5LT9Z1TpnRcEs1R.GUOUr.q', 1),
(6, 'majda', 'majda@seznam.cz', '$2y$10$/GTXLdCAXU9FqOvy1XxaLugf8SPBNLD0j5ZinwVjxVaFOo6vli1uC', 1),
(7, 'admin', '2turnusoskar@gmail.com', '$2y$10$wZXK11tXfCE6j3f/eA0pIOqVb.O3A66I2hiHTzvnrckwD0obZ744y', 1),
(8, 'test', 'test@test.cz', '$2a$10$rQsZfBLd0SHhpO/Y.kRnh.4EeGqllAeZ5Vkz53EC88vnobAbGzFIK', 1);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `dite`
--
ALTER TABLE `dite`
  ADD PRIMARY KEY (`id`,`prijmeni`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `dite`
--
ALTER TABLE `dite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
