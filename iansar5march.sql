-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 05, 2013 at 10:14 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iansar`
--

-- --------------------------------------------------------

--
-- Table structure for table `insr_callees`
--

CREATE TABLE IF NOT EXISTS `insr_callees` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `caller_id` bigint(20) NOT NULL COMMENT 'created by',
  `owned_by` bigint(20) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `family_name` varchar(255) DEFAULT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `highest_qualification` varchar(255) NOT NULL,
  `profession` varchar(255) NOT NULL,
  `house_no` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` int(11) NOT NULL,
  `language_read` varchar(255) NOT NULL,
  `language_write` varchar(255) NOT NULL,
  `language_speak` varchar(255) DEFAULT NULL,
  `religion` varchar(255) NOT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `social_network_id` varchar(255) DEFAULT NULL,
  `messenger_id` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `caller_id` (`caller_id`),
  KEY `owned_by` (`owned_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `insr_callees`
--

INSERT INTO `insr_callees` (`id`, `caller_id`, `owned_by`, `first_name`, `last_name`, `family_name`, `nick_name`, `gender`, `age`, `highest_qualification`, `profession`, `house_no`, `street`, `area`, `city`, `state`, `country`, `zip`, `language_read`, `language_write`, `language_speak`, `religion`, `email_id`, `phone_number`, `social_network_id`, `messenger_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Some', 'Name', 'Family', 'Nick', 'MALE', 37, 'M.E', 'SE', 'No.45', 'North Car street', 'Mandaveli', 'Chennai', 'Tamilnadu', 'India', 62000, 'tamil, english', 'tamil, english', 'tamil, english', 'buddh', 'some@some.com', '343393948433', '{"facebook":"fb"}', '{"hotmailmessenger":"msn"}', 'CONVINCED', '2013-01-13 17:02:35', '2013-01-19 10:59:12'),
(2, 1, 2, 'new amad', 'ljads', 'l;ad', 'adskfjladsf', 'FEMALE', 24, 'M.E', 'SE', 'No.45', '2nd Cross', 'Mandaveli', 'Bangalore', 'Karnataka', 'India', 560092, 'some lang', 'some lang', 'some lang', 'somethig', 'jebin@jebin.com', '919535872103', '{"facebook":"jebinbv"}', '{"gtalk":"gtalkjebin"}', 'IGNORED', '2013-01-19 19:43:01', '2013-02-28 03:46:55'),
(3, 2, 1, 'new amad1', 'de Banville', 'Family', 'adskfjladsf', 'FEMALE', 24, 'M.Er', 'SEr', 'No.45', '2nd Cross', 'Mandaveli', 'Bangalore', 'Tamilnadu', 'India', 560092, 'some lang', 'tamil, english', 'some lang', 'somethig', 'name@name.com', '919535872103', '{"facebook":"jebinbv"}', '{"gtalk":"gtalkjebin"}', 'CONVINCED', '2013-01-19 12:36:41', '2013-01-19 17:28:44');

-- --------------------------------------------------------

--
-- Table structure for table `insr_callers`
--

CREATE TABLE IF NOT EXISTS `insr_callers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role` varchar(30) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_completion_status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0=>No; 1=> Yes',
  `active_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0=>Inactive; 1=> Active',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Da''ee registration & login lookup table' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `insr_callers`
--

INSERT INTO `insr_callers` (`id`, `role`, `email`, `password`, `profile_completion_status`, `active_status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'iansarmail@gmail.com', 'a360bddfa8155e5d46326f3a31aba595', 1, 1, '2012-12-22 13:46:30', '2013-01-01 12:07:01'),
(2, NULL, 'jebin@itvillage.fr', '4be3cb0f8154fbf413c2b01311800d55', 1, 1, '2013-01-24 00:00:00', '2013-01-19 14:17:13');

-- --------------------------------------------------------

--
-- Table structure for table `insr_callers_profile`
--

CREATE TABLE IF NOT EXISTS `insr_callers_profile` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `caller_id` bigint(20) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `family_name` varchar(255) DEFAULT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `gender` enum('MALE','FEMALE','OTHER') NOT NULL,
  `date_of_birth` date NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `social_network_id` text COMMENT 'json format {"name":"social network id"}',
  `messenger_id` text COMMENT 'json format {"name":"messenger id"}',
  `house_no` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  `primary_phone` varchar(255) NOT NULL,
  `secondary_phone` varchar(20) DEFAULT NULL,
  `highest_education` varchar(255) NOT NULL,
  `profession` varchar(50) NOT NULL,
  `type_of_user` varchar(10) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `languages_known` text NOT NULL COMMENT 'json format {"0":"language"}',
  `callee_created` text COMMENT 'Madhoo created by caller in JSON format',
  `callee_owned` text COMMENT 'Madhoo owned currently by caller in JSON',
  `can_own_cnt` tinyint(4) NOT NULL DEFAULT '5' COMMENT 'Count of how many madhoo caller can own still.',
  `unassigned_madhoo` text COMMENT 'Madhoo unassingned by caller in JSON',
  `can_invite` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0=>no, 1=>yes',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `caller_id` (`caller_id`),
  KEY `email_id` (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `insr_callers_profile`
--

INSERT INTO `insr_callers_profile` (`id`, `caller_id`, `first_name`, `last_name`, `family_name`, `nick_name`, `gender`, `date_of_birth`, `email_id`, `social_network_id`, `messenger_id`, `house_no`, `street`, `area`, `city`, `state`, `country`, `zip`, `primary_phone`, `secondary_phone`, `highest_education`, `profession`, `type_of_user`, `profile_pic`, `languages_known`, `callee_created`, `callee_owned`, `can_own_cnt`, `unassigned_madhoo`, `can_invite`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jebin', 'BV', 'Benjamin', 'Jebin', 'MALE', '1990-01-26', 'iansarmail@gmail.com', '{"facebook":"JebinBv","":"jebinbv"}', '{"gtalk":"bvjebin@gmail.com","":"jebin@aio.com"}', '105', '2nd Cross', 'Maruthi Nagar', 'Bangalore', 'Karnataka', 'India', 560092, '9535872103', '', 'B.Tech(IT)', 'Software Engineer', 'DAEE', '1358256602_2012_11_05_113343jpg.png', '["Tamil","English"]', NULL, NULL, 5, NULL, 0, '2012-12-23 00:03:22', '2013-01-15 13:30:02'),
(2, 2, 'jebin', 'raj', 'ben', 'jamin', 'MALE', '1992-05-26', 'jebin@itvillage.fr', '{"facebook":"jebinraj"}', '{"msn":"jebinraj"}', 'No.45', 'North Car street', 'Mandaveli', 'Chennai', 'Tamilnadu', 'India', 62000, '233453245443', NULL, 'M.tech', 'Lect', 'Da''ee', 'none', '{0:"tamil",1:"english"}', NULL, NULL, 5, NULL, 1, '2013-01-19 20:47:46', '2013-01-19 14:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `insr_conversations`
--

CREATE TABLE IF NOT EXISTS `insr_conversations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `callee_id` bigint(20) NOT NULL,
  `conversation` longtext CHARACTER SET utf8 NOT NULL,
  `owner_id` bigint(20) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `caller_id` (`callee_id`),
  KEY `id` (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `insr_conversations`
--

INSERT INTO `insr_conversations` (`id`, `callee_id`, `conversation`, `owner_id`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'what is this', 1, 'AGREED', '2013-01-23 22:34:42', '2013-02-28 04:12:03'),
(4, 1, 'aldjfj;lasdf', 1, 'AGREED', '2013-01-23 22:34:42', '2013-02-28 04:12:13'),
(5, 1, 'new one', 1, 'AGREED', '2013-01-23 23:01:09', '2013-02-28 04:12:19'),
(6, 1, 'poyta  yo ', 1, 'IGNORED', '2013-01-23 23:02:20', '2013-02-28 04:12:26');

-- --------------------------------------------------------

--
-- Table structure for table `insr_conversation_mapping`
--

CREATE TABLE IF NOT EXISTS `insr_conversation_mapping` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `caller_id` bigint(20) NOT NULL,
  `callee_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `caller_id` (`caller_id`,`callee_id`),
  KEY `callee_id` (`callee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `insr_conversation_mapping`
--

INSERT INTO `insr_conversation_mapping` (`id`, `caller_id`, `callee_id`, `created_at`, `updated_at`) VALUES
(13, 1, 1, '2013-01-23 22:34:42', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `insr_invitation`
--

CREATE TABLE IF NOT EXISTS `insr_invitation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `invitee_email` varchar(255) NOT NULL,
  `invited_by` bigint(20) NOT NULL,
  `lookup_phrase` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0=>Not joined;1=>joined',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitee_email` (`invitee_email`),
  KEY `invited_by` (`invited_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `insr_messages`
--

CREATE TABLE IF NOT EXISTS `insr_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sender_id` bigint(20) NOT NULL,
  `receiver_id` bigint(20) NOT NULL,
  `type` varchar(100) NOT NULL COMMENT 'ADMIN_SPAM, ADMIN_WARN, ADMIN_BLOCK, ASSIGNMENT, UNASSIGNMENT',
  `status` varchar(50) NOT NULL COMMENT 'READ, UNREAD, DELETED',
  `title` text,
  `description` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`,`receiver_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `session_table`
--

CREATE TABLE IF NOT EXISTS `session_table` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session_table`
--

INSERT INTO `session_table` (`id`, `expire`, `data`) VALUES
('2t0lsm8k8to3j30e54rkbmoda7', 1362459780, ''),
('4duoah91otinkkk12nt56poia6', 1362459783, 0x66303235356131333561393136636633323839653761623433616531646637387573657253657373696f6e54696d656f75747c693a313336323436353534333b66303235356131333561393136636633323839653761623433616531646637385f5f69647c733a313a2231223b66303235356131333561393136636633323839653761623433616531646637385f5f6e616d657c733a32303a2269616e7361726d61696c40676d61696c2e636f6d223b6630323535613133356139313663663332383965376162343361653164663738726f6c657c733a353a2261646d696e223b6630323535613133356139313663663332383965376162343361653164663738656d61696c7c733a32303a2269616e7361726d61696c40676d61696c2e636f6d223b66303235356131333561393136636633323839653761623433616531646637386e616d657c733a383a224a6562696e204256223b663032353561313335613931366366333238396537616234336165316466373863616e5f696e766974657c623a303b663032353561313335613931366366333238396537616234336165316466373870726f66696c655f636f6d706c657465647c733a313a2231223b66303235356131333561393136636633323839653761623433616531646637385f5f7374617465737c613a353a7b733a343a22726f6c65223b623a313b733a353a22656d61696c223b623a313b733a343a226e616d65223b623a313b733a31303a2263616e5f696e76697465223b623a313b733a31373a2270726f66696c655f636f6d706c65746564223b623a313b7d663032353561313335613931366366333238396537616234336165316466373870726f66696c655f7069637c733a33353a22313335383235363630325f323031325f31315f30355f3131333334336a70672e706e67223b),
('fhp28ii8jd87dbfp0b6mnq2q34', 1362459754, ''),
('m5r70brabpbfis7t9frq83e4n0', 1362459761, ''),
('p2lcu4mth83fcmv7kvd5vmesp5', 1362459780, ''),
('p6csj4lg7cam62o8j5242lgub0', 1362459702, ''),
('sbv71lt0gjnh1fdskosvcegpd5', 1362459716, ''),
('th82qqj9i47rribm4tlto102d5', 1362459783, ''),
('urohb93c1kq6hhfg5n2p86ock1', 1362459720, '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `insr_callees`
--
ALTER TABLE `insr_callees`
  ADD CONSTRAINT `insr_callees_ibfk_1` FOREIGN KEY (`caller_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_callees_ibfk_2` FOREIGN KEY (`owned_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `insr_callers_profile`
--
ALTER TABLE `insr_callers_profile`
  ADD CONSTRAINT `insr_callers_profile_ibfk_1` FOREIGN KEY (`caller_id`) REFERENCES `insr_callers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insr_conversations`
--
ALTER TABLE `insr_conversations`
  ADD CONSTRAINT `insr_conversations_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_conversations_ibfk_3` FOREIGN KEY (`callee_id`) REFERENCES `insr_callees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `insr_invitation`
--
ALTER TABLE `insr_invitation`
  ADD CONSTRAINT `insr_invitation_ibfk_1` FOREIGN KEY (`invited_by`) REFERENCES `insr_callers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insr_messages`
--
ALTER TABLE `insr_messages`
  ADD CONSTRAINT `insr_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
