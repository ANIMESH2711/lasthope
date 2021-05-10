-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2020 at 03:32 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aktu`
--

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `QuestionId` int(11) NOT NULL,
  `SubjectId` int(11) NOT NULL DEFAULT 0,
  `UnitId` int(11) NOT NULL DEFAULT 0,
  `TopicId` int(11) NOT NULL DEFAULT 0,
  `AuthorId` int(11) NOT NULL DEFAULT 0,
  `QTypeId` enum('A','B','C','D','E') NOT NULL,
  `QTitle` varchar(300) NOT NULL,
  `Question` text NOT NULL,
  `QAnswer` text NOT NULL,
  `QMarks` decimal(5,2) NOT NULL,
  `QTime` int(3) NOT NULL,
  `QComplexity` tinyint(1) NOT NULL,
  `QBTId` enum('A','B','C','D','E','F','G','H') NOT NULL,
  `QKeywords` varchar(300) NOT NULL,
  `QCurStateId` tinyint(2) NOT NULL DEFAULT 0,
  `QCurStateUsrId` int(11) NOT NULL,
  `QRevHistoryId` int(11) DEFAULT NULL,
  `IsQLocked` tinyint(1) NOT NULL DEFAULT 0,
  `QLockUsrId` int(11) DEFAULT NULL,
  `IsQDisabled` tinyint(1) NOT NULL DEFAULT 0,
  `IsQDel` tinyint(1) NOT NULL DEFAULT 0,
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`QuestionId`),
  ADD KEY `SubjectId` (`SubjectId`),
  ADD KEY `TopicId` (`TopicId`),
  ADD KEY `UnitId` (`UnitId`),
  ADD KEY `AuthorId` (`AuthorId`),
  ADD KEY `QTypeId` (`QTypeId`),
  ADD KEY `QComplexity` (`QComplexity`),
  ADD KEY `QBTId` (`QBTId`),
  ADD KEY `QCurStateId` (`QCurStateId`),
  ADD KEY `fk_Question_UserLogin2` (`QCurStateUsrId`),
  ADD KEY `fk_Question_UserLogin3` (`QLockUsrId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `QuestionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `fk_Question_Topic1` FOREIGN KEY (`TopicId`) REFERENCES `topic` (`TopicId`),
  ADD CONSTRAINT `fk_Question_UserLogin1` FOREIGN KEY (`AuthorId`) REFERENCES `userlogin` (`UserId`),
  ADD CONSTRAINT `fk_Question_UserLogin2` FOREIGN KEY (`QCurStateUsrId`) REFERENCES `userlogin` (`UserId`),
  ADD CONSTRAINT `fk_Question_UserLogin3` FOREIGN KEY (`QLockUsrId`) REFERENCES `userlogin` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
