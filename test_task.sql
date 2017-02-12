-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 12, 2017 at 07:28 AM
-- Server version: 5.6.35
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `AllowTable`
--

CREATE TABLE `AllowTable` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `AllowInfo` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `AllowTable`
--

INSERT INTO `AllowTable` (`ID`, `Name`, `AllowInfo`) VALUES
(1, 'News', 1),
(2, 'Session', 1);

-- --------------------------------------------------------

--
-- Table structure for table `News`
--

CREATE TABLE `News` (
  `ID` int(11) NOT NULL,
  `ParticipantId` int(11) NOT NULL,
  `NewsTitle` varchar(255) NOT NULL,
  `NewsMessage` text NOT NULL,
  `LikesCounter` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `News`
--

INSERT INTO `News` (`ID`, `ParticipantId`, `NewsTitle`, `NewsMessage`, `LikesCounter`) VALUES
(1, 1, 'New agenda!', 'Please visit our site!', 0),
(2, 3, 'Another news', 'News test', 0),
(7, 1, 'We\'ve got news for you', 'Actually no', 0),
(8, 2, 'We\'ve got news for you', 'Actually no', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Participant`
--

CREATE TABLE `Participant` (
  `ID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Participant`
--

INSERT INTO `Participant` (`ID`, `Email`, `Name`) VALUES
(1, 'airmail@code-pilots.com', 'The first user'),
(2, 'corruptsouls@gmail.com', 'Ivan'),
(4, 'ivan.kuzin@anten.ru', 'Ivan'),
(5, 'mail@yandex.ru', 'Postman');

-- --------------------------------------------------------

--
-- Table structure for table `Session`
--

CREATE TABLE `Session` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `TimeOfEvent` datetime NOT NULL,
  `Description` text NOT NULL,
  `MaxParticipants` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Session`
--

INSERT INTO `Session` (`ID`, `Name`, `TimeOfEvent`, `Description`, `MaxParticipants`) VALUES
(123, 'Annual report', '2016-12-15 16:00:00', 'Anuual report by CEO', 3);

-- --------------------------------------------------------

--
-- Table structure for table `SessionSubscribe`
--

CREATE TABLE `SessionSubscribe` (
  `ID` int(11) NOT NULL,
  `SessionID` int(11) NOT NULL,
  `ParticipantId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SessionSubscribe`
--

INSERT INTO `SessionSubscribe` (`ID`, `SessionID`, `ParticipantId`) VALUES
(1, 123, 2),
(2, 123, 1),
(3, 123, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Speaker`
--

CREATE TABLE `Speaker` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Speaker`
--

INSERT INTO `Speaker` (`ID`, `Name`) VALUES
(1, 'Watson'),
(2, 'Arnold');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AllowTable`
--
ALTER TABLE `AllowTable`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `News`
--
ALTER TABLE `News`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Participant`
--
ALTER TABLE `Participant`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Session`
--
ALTER TABLE `Session`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `SessionSubscribe`
--
ALTER TABLE `SessionSubscribe`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Speaker`
--
ALTER TABLE `Speaker`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AllowTable`
--
ALTER TABLE `AllowTable`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `News`
--
ALTER TABLE `News`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `Participant`
--
ALTER TABLE `Participant`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Session`
--
ALTER TABLE `Session`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;
--
-- AUTO_INCREMENT for table `SessionSubscribe`
--
ALTER TABLE `SessionSubscribe`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Speaker`
--
ALTER TABLE `Speaker`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
