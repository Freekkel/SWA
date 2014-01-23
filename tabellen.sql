-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 11. Jan 2014 um 17:12
-- Server Version: 5.5.33
-- PHP-Version: 5.4.4-14+deb7u7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `swa006`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `orderid` varchar(250) NOT NULL,
  `name` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(6,4) unsigned NOT NULL,
  PRIMARY KEY (`orderid`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `orderid` varchar(250) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`orderid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `order`
--

INSERT INTO `order` (`orderid`, `userid`, `datetime`) VALUES
('2014-1', 3, '2014-01-10 21:38:04'),
('2014-10', 3, '2014-01-10 22:05:48'),
('2014-11', 3, '2014-01-10 22:05:49'),
('2014-12', 3, '2014-01-10 22:05:50'),
('2014-13', 3, '2014-01-10 22:05:50'),
('2014-14', 3, '2014-01-10 22:05:51'),
('2014-15', 3, '2014-01-10 22:05:51'),
('2014-2', 3, '2014-01-10 22:05:38'),
('2014-3', 3, '2014-01-10 22:05:39'),
('2014-4', 3, '2014-01-10 22:05:45'),
('2014-5', 3, '2014-01-10 22:05:46'),
('2014-6', 3, '2014-01-10 22:05:46'),
('2014-7', 3, '2014-01-10 22:05:47'),
('2014-8', 3, '2014-01-10 22:05:47'),
('2014-9', 3, '2014-01-10 22:05:48');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`userid`, `name`, `password`) VALUES
(1, 'admin', 'f4f553d634679748a6b18d040f5c0bc9'),
(2, 'worker', '16aa1d9d978d41dda477efa4f945293a'),
(3, 'Sven', '69e3301c151835b4eddc7f4dc3ae3be2'),
(4, 'Tassilo', 'a676ac753ae481f49e67174db0efb53c'),
(5, 'Stefan', '5195d9fa40ce1247d7b4e661179228a4');

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`orderid`) REFERENCES `order` (`orderid`);

--
-- Constraints der Tabelle `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;