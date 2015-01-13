-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 28, 2013 at 01:36 AM
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
  `requested_by` longtext COMMENT 'NULL=> Nobody requested, "[1,2,3]" => Json array of Requested by Daee List',
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
  `note` longtext,
  `renewed_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `caller_id` (`caller_id`),
  KEY `owned_by` (`owned_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `insr_callees`
--

INSERT INTO `insr_callees` (`id`, `caller_id`, `owned_by`, `requested_by`, `first_name`, `last_name`, `family_name`, `nick_name`, `gender`, `age`, `highest_qualification`, `profession`, `house_no`, `street`, `area`, `city`, `state`, `country`, `zip`, `language_read`, `language_write`, `language_speak`, `religion`, `email_id`, `phone_number`, `social_network_id`, `messenger_id`, `status`, `note`, `renewed_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 'Some', 'Name', 'Family', 'Nick', 'MALE', 37, 'M.E', 'SE', 'No.45', 'North Car street', 'Mandaveli', 'Chennai', 'Tamilnadu', 'India', 62000, 'tamil, english', 'tamil, english', 'tamil, english', 'buddh', 'some@some.com', '343393948433', '{"facebook":"fb"}', '{"hotmailmessenger":"msn"}', 'NO_INTERACTION_YET', 'Name of madhoo is so and so. Name of madhoo is so and so \r\nName of madhoo is so and so \r\nName of madhoo is so and so Name of madhoo is so and so Name of madhoo is so and so Name of madhoo is so and so Name of madhoo is so and so Name of madhoo is so and so Name of madhoo is so and so Name of madhoo is so and so Name of madhoo is so and so , Name of madhoo is so and so ', '2013-03-23 19:37:49', '2013-01-13 17:02:35', '2013-05-26 13:01:45'),
(2, 1, NULL, NULL, 'new amad', 'ljads', 'l;ad', 'adskfjladsf', 'FEMALE', 24, 'M.E', 'SE', 'No.45', '2nd Cross', 'Mandaveli', 'Bangalore', 'Karnataka', 'India', 560092, 'some lang', 'some lang', 'some lang', 'somethig', 'jebin@jebin.com', '919535872103', '{"facebook":"jebinbv"}', '{"gtalk":"gtalkjebin"}', 'IGNORED', 'hai', NULL, '2013-01-19 19:43:01', '2013-05-26 19:38:17'),
(3, 1, 2, NULL, 'new amad1', 'de Banville', 'Family', 'adskfjladsf', 'FEMALE', 24, 'M.Er', 'SEr', 'No.45', '2nd Cross', 'Mandaveli', 'Bangalore', 'Tamilnadu', 'India', 560092, 'some lang', 'tamil, english', 'some lang', 'somethig', 'name@name.com', '919535872103', '{"facebook":"jebinbv"}', '{"gtalk":"gtalkjebin"}', 'NO_INTERACTION_YET', NULL, NULL, '2013-01-19 12:36:41', '2013-05-26 13:11:01'),
(4, 2, 2, '["1"]', 'Blah', 'Blah', 'Blah', 'Blah', 'FEMALE', 21, 'B.tech', 'Doctor', '123', 'bah', 'blah', 'blah', 'blah', 'blah', 13333333, 'benglali', 'hidi', 'english', 'blah', 'balh@hlah.com', '234345643', '{"Twitter":"blah@twitter.com"}', '{"hotmailmessenger":"bal@hotmail.com"}', 'CONVINCED', NULL, NULL, '2013-04-20 16:43:00', '2013-05-26 18:36:22');

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
  `active_status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0=>Inactive; 1=> Active; 2=> Deleted; 3=> Blocked',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Da''ee registration & login lookup table' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `insr_callers`
--

INSERT INTO `insr_callers` (`id`, `role`, `email`, `password`, `profile_completion_status`, `active_status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'iansarmail@gmail.com', 'a360bddfa8155e5d46326f3a31aba595', 1, 1, '2012-12-22 13:46:30', '2013-04-20 12:41:37'),
(2, NULL, 'jebin@itvillage.fr', 'cc81b0da820d482462750439d6c06411', 1, 1, '2013-01-24 00:00:00', '2013-04-14 11:57:55');

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
  `type_of_user` varchar(100) DEFAULT 'LIMITED_DAEE',
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
(1, 1, 'Jebin', 'BV', 'Benjamin', 'Jebin', 'MALE', '1990-01-26', 'iansarmail@gmail.com', '{"facebook":"JebinBv","Twitter":"jebin19"}', '{"gtalk":"bvjebin@gmail.com","AIM":"jebin@aio.com"}', '', '', '', 'Bangalore', 'Karnataka', 'India', 560092, '9535872103', '', 'B.Tech(IT)', 'Software Engineer', 'DAEE', '1358256602_2012_11_05_113343jpg.png', '["Tamil","English"]', '[{"id":"2","update_at":"\\"2013-05-27 01:09:37\\""}]', NULL, 18, NULL, 1, '2012-12-23 00:03:22', '2013-05-26 19:39:37'),
(2, 2, 'jebin', 'raj', 'ben', 'jamin', 'MALE', '1992-05-26', 'jebin@itvillage.fr', '{"facebook":"jebinraj"}', '{"msn":"jebinraj"}', 'No.45', 'North Car street', 'Mandaveli', 'Chennai', 'Tamilnadu', 'India', 62000, '233453245443', NULL, 'M.tech', 'Lect', 'Da''ee', 'none', '["tamil","english"]', NULL, NULL, 8, NULL, 1, '2013-01-19 20:47:46', '2013-04-13 17:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `insr_conversations`
--

CREATE TABLE IF NOT EXISTS `insr_conversations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `callee_id` bigint(20) NOT NULL,
  `conversation` longtext CHARACTER SET utf8 NOT NULL,
  `owner_id` bigint(20) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1' COMMENT '0=>deleted 1=>not deleted',
  `interaction_status` varchar(250) NOT NULL DEFAULT 'PARTIALLY_CONVINCED' COMMENT 'ACCEPTED, DISAGREED, CONVINCED, NO_INTERACTION_YET, PARTIALLY_CONVINCED',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `caller_id` (`callee_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `insr_conversations`
--

INSERT INTO `insr_conversations` (`id`, `callee_id`, `conversation`, `owner_id`, `status`, `interaction_status`, `created_at`, `updated_at`) VALUES
(3, 1, 'what is this s?', 1, '1', 'PARTIALLY_CONVINCED', '2013-01-23 22:34:42', '2013-03-23 12:50:59'),
(4, 1, 'aldjfj;lasdf', 1, '1', 'PARTIALLY_CONVINCED', '2013-01-23 22:34:42', '2013-03-09 12:20:12'),
(5, 1, 'new one', 1, '1', 'PARTIALLY_CONVINCED', '2013-01-23 23:01:09', '2013-03-09 12:20:12'),
(6, 1, 'poyta  yo ', 1, '1', 'PARTIALLY_CONVINCED', '2013-01-23 23:02:20', '2013-03-09 12:20:12'),
(7, 1, 'Edited comfog', 1, '1', 'PARTIALLY_CONVINCED', '2013-03-09 17:19:08', '2013-03-09 15:39:29'),
(8, 1, 'DivX HiQ Debug: HiQ supported site definition updated 37 Minutes(s) ago.', 1, '1', 'PARTIALLY_CONVINCED', '2013-03-09 17:22:23', '2013-03-09 12:20:12'),
(9, 1, '$(''#add_conv''). $(''#add_conv''). $(''#add_conv'').', 1, '1', 'PARTIALLY_CONVINCED', '2013-03-09 17:24:18', '2013-03-09 12:20:12'),
(10, 1, 'conversationTemplate(Conversations) conversationTemplate(Conversations)', 1, '1', 'PARTIALLY_CONVINCED', '2013-03-09 17:26:46', '2013-03-09 12:20:12'),
(11, 1, 'conversationTemplate(Conversations)', 1, '1', 'PARTIALLY_CONVINCED', '2013-03-09 17:28:44', '2013-03-23 13:07:37'),
(12, 1, 'conversationTemplate(Conversations) conversationTemplate(Conversations)conversationTemplate(Conversations) conversationTemplate(Conversations)', 1, '1', 'PARTIALLY_CONVINCED', '2013-03-09 17:30:10', '2013-03-09 12:20:12'),
(13, 1, 'conversationTemplate(Conversations) conversationTemplate(Conversations)conversationTemplate(Conversations) conversationTemplate(Conversations)conversationTemplate(Conversations) conversationTemplate(Conversations)', 1, '0', 'PARTIALLY_CONVINCED', '2013-03-09 17:30:34', '2013-05-25 18:33:33'),
(14, 1, 'conversationTemplate(Conversations) conversationTemplate(Conversations)conversationTemplate(Conversations) conversationTemplate(Conversations)conversationTemplate(Conversations) conversationTemplate(Conversations)', 1, '0', 'PARTIALLY_CONVINCED', '2013-03-09 17:40:20', '2013-05-25 18:33:31'),
(15, 1, '<?php echo date("d/m/Y"); ?> <?php echo date("d/m/Y"); ?> <?php echo date("d/m/Y"); ?>', 1, '0', 'PARTIALLY_CONVINCED', '2013-03-09 17:44:13', '2013-03-09 12:32:35'),
(16, 1, 'conversationTemplate(Conversations) conversationTemplate(Conversations)conversationTemplate(Conversations) conversationTemplate(Conversations)conversationTemplate(Conversations) conversationTemplate(Conversations)', 1, '0', 'PARTIALLY_CONVINCED', '2013-03-09 17:44:28', '2013-03-09 12:34:48'),
(17, 1, 'add me now', 1, '0', 'PARTIALLY_CONVINCED', '2013-03-09 21:09:52', '2013-05-25 18:33:21'),
(18, 1, 'testing laset ', 1, '0', 'PARTIALLY_CONVINCED', '2013-03-09 21:14:43', '2013-05-25 18:33:30'),
(19, 1, 'New cong its', 1, '0', 'PARTIALLY_CONVINCED', '2013-04-05 23:00:58', '2013-05-25 19:10:26'),
(20, 1, 'Comment added', 1, '0', 'PARTIALLY_CONVINCED', '2013-04-07 00:10:36', '2013-05-25 19:10:25'),
(21, 1, 'test stauts', 1, '0', 'PARTIALLY_CONVINCED', '2013-05-26 00:36:40', '2013-05-25 19:10:23'),
(22, 1, 'failed tot', 1, '0', 'PARTIALLY_CONVINCED', '2013-05-26 00:38:29', '2013-05-25 19:10:22'),
(23, 1, 'adfasdfs', 1, '0', 'PARTIALLY_CONVINCED', '2013-05-26 00:38:37', '2013-05-25 19:10:27'),
(24, 1, 'adfasdfasd', 1, '0', 'PARTIALLY_CONVINCED', '2013-05-26 00:40:12', '2013-05-25 19:10:20'),
(25, 1, ' adsfadsfasdfsd  asdf asdf', 1, '0', 'PARTIALLY_CONVINCED', '2013-05-26 00:41:13', '2013-05-25 19:20:37'),
(26, 1, 'snoee', 1, '0', 'CONVINCED', '2013-05-26 00:42:18', '2013-05-25 19:20:35'),
(27, 1, 'adsfads', 1, '0', 'PARTIALLY_CONVINCED', '2013-05-26 00:49:46', '2013-05-25 19:20:39'),
(28, 1, 'interaction_status_text interaction_status_text accepted', 1, '1', 'ACCEPTED', '2013-05-26 00:50:49', '2013-05-25 19:50:39'),
(29, 1, 'new conv', 1, '1', 'NO_INTERACTION_YET', '2013-05-26 18:31:44', '2013-05-26 13:01:28'),
(32, 3, 'Now chekc', 1, '1', 'ACCEPTED', '2013-05-26 18:37:08', '2013-05-26 13:05:25'),
(33, 3, 'nwo check link', 1, '1', 'CONVINCED', '2013-05-26 18:39:42', '2013-05-26 13:05:25'),
(34, 3, 'New test', 1, '1', 'NO_INTERACTION_YET', '2013-05-26 18:41:01', '2013-05-26 13:10:13');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `insr_messages`
--

INSERT INTO `insr_messages` (`id`, `sender_id`, `receiver_id`, `type`, `status`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'ASSIGNMENT', 'DELETED', 'Assign Madhoo to Me', 'I have interest in this Madhoo. Assign him to me', '2013-04-15 07:20:14', '2013-05-03 18:56:30'),
(2, 1, 1, 'ADMIN_WARN', 'DELETED', 'WARNING !!!', 'You are misusing the system. This warning is the last.', '0000-00-00 00:00:00', '2013-05-03 19:00:33'),
(3, 1, 2, 'ADMIN_WARN', 'DELETED', 'WARNING !!!', 'warn me', '0000-00-00 00:00:00', '2013-05-03 19:35:19'),
(4, 1, 2, 'ADMIN_WARN', 'READ', 'WARNING !!!', 'Text is this!', '0000-00-00 00:00:00', '2013-05-03 18:06:34'),
(5, 1, 2, 'ADMIN_WARN', 'DELETED', 'WARNING !!!', 'Warn aginag', '2013-04-15 23:08:52', '2013-05-03 18:56:30'),
(6, 1, 2, 'ASSIGNMENT', 'DELETED', 'Assign Madhoo to Me', 'I have interest in this Madhoo. Assign him to me', '2013-04-19 23:38:43', '2013-05-03 18:56:30'),
(19, 2, 1, 'ADMIN_SPAM', 'READ', 'Spammer in iAnsar', 'nOw', '2013-05-04 17:23:37', '2013-05-07 17:47:55'),
(20, 2, 1, 'ADMIN_SPAM', 'READ', 'Spammer in iAnsar', 'Report sas spam', '2013-05-04 17:30:51', '2013-05-04 12:04:39'),
(21, 2, 1, 'ADMIN_SPAM', 'UNREAD', 'Spammer in iAnsar', 'nw', '2013-05-04 17:36:05', '2013-05-08 18:02:57'),
(22, 2, 1, 'ADMIN_SPAM', 'READ', 'Spammer in iAnsar', 'Not now booss', '2013-05-04 17:36:27', '2013-05-07 17:47:49'),
(23, 2, 1, 'ADMIN_SPAM', 'READ', 'Spammer in iAnsar', 'now', '2013-05-04 17:38:00', '2013-05-07 17:47:46'),
(24, 2, 1, 'ADMIN_SPAM', 'READ', 'Spammer in iAnsar', 'Now wait', '2013-05-04 17:38:32', '2013-05-07 17:47:43'),
(25, 2, 1, 'ADMIN_SPAM', 'READ', 'Spammer in iAnsar', 'Loader test', '2013-05-04 17:47:49', '2013-05-07 17:47:39'),
(26, 2, 1, 'ADMIN_SPAM', 'READ', 'Spammer in iAnsar', 'Takes time for laoder', '2013-05-04 18:08:50', '2013-05-04 13:50:02'),
(27, 1, 2, 'ADMIN_WARN', 'READ', 'WARNING !!!', 'Text message!', '2013-05-07 22:46:30', '2013-05-07 17:48:07'),
(28, 1, 1, 'ASSIGNMENT_SUCCESSFUL', 'READ', 'Madhoo Assigned successfully', 'Madhoo assignment successfull. <br /><a href=''/madhoo/viewmadhoo/1'' class=''fancyLink''>View Madhoo</a><br />Let Allah be with you', '2013-05-14 19:20:00', '2013-05-14 14:15:21'),
(29, 1, 2, 'ASSIGNMENT', 'UNREAD', 'Assign Madhoo to Me', 'I have interest in <a target="_blank" class="fancyLink" href="/madhoo/viewothermadhoo/2"><b>this</b></a> Madhoo. Assign him to me', '2013-05-22 23:18:23', '2013-05-22 17:48:23'),
(30, 1, 2, 'ASSIGNMENT', 'READ', 'Assign Madhoo to Me', 'I have interest in <a target="_blank" class="fancyLink" href="/madhoo/viewothermadhoo/2"><b>this</b></a> Madhoo. Assign him to me', '2013-05-22 23:20:48', '2013-05-22 18:23:03'),
(31, 1, 1, 'ASSIGNMENT_SUCCESSFUL', 'READ', 'Madhoo Assigned successfully', 'Madhoo assignment successfull. <br /><a href=''/madhoo/viewmadhoo/3''>View Madhoo</a><br />Let Allah be with you', '2013-05-22 23:27:49', '2013-05-22 18:15:50'),
(32, 1, 2, 'ASSIGNMENT', 'UNREAD', 'Assign Madhoo to Me', 'I have interest in Madhoo [[{"href":"/madhoo/viewothermadhoo/2","madhoo":2}]]. Assign him to me', '2013-05-25 22:08:39', '2013-05-25 16:44:19'),
(33, 1, 1, 'MESSAGE', 'UNREAD', 'Title message', 'Message from sender!', '2013-05-25 22:53:21', '2013-05-25 17:23:21'),
(34, 1, 2, 'MESSAGE', 'UNREAD', 'Mess tit', 'Message for you', '2013-05-25 22:54:38', '2013-05-25 17:24:38'),
(35, 1, 2, 'MESSAGE', 'UNREAD', 'new tit', 'new message', '2013-05-25 22:55:13', '2013-05-25 17:25:13'),
(36, 1, 2, 'MESSAGE', 'UNREAD', 'ok', 'ok', '2013-05-25 22:55:45', '2013-05-25 17:25:45'),
(37, 1, 2, 'MESSAGE', 'UNREAD', 'message no', 'message yes', '2013-05-25 22:57:12', '2013-05-25 17:27:12'),
(38, 1, 2, 'MESSAGE', 'UNREAD', 'send message fromd etaill page', 'page detaila', '2013-05-25 23:07:05', '2013-05-25 17:37:05'),
(39, 1, 2, 'CONVERSATION', 'READ', 'Conversation happened on one of you madhoos', 'A conversation is added in the profile of madhoo ##{"madhoo":3}##. <br />Click on <a href=''/madhoo/viewmadhoo/3''>this link</a> to see the conversation.', '2013-05-26 18:37:08', '2013-05-26 13:08:00'),
(40, 1, 2, 'CONVERSATION', 'READ', 'Conversation happened on one of you madhoos', 'A conversation is added in the profile of madhoo ##{"madhoo":3}##. <br />Click on [[{"href":"/madhoo/viewmadhoo/3","value":"this link"}]]</a> to see the conversation.', '2013-05-26 18:39:42', '2013-05-26 13:12:10'),
(41, 1, 2, 'CONVERSATION', 'READ', 'Conversation happened on one of you madhoos', 'A conversation is added in the profile of madhoo ##{"madhoo":3}##. <br />Click on [[{"href":"/madhoo/viewmadhoo/3","value":"this link"}]]</a> to see the conversation.', '2013-05-26 18:41:01', '2013-05-26 13:12:12'),
(42, 1, 2, 'ASSIGNMENT', 'UNREAD', 'Assign Madhoo to Me', 'I have interest in Madhoo <a target="_blank" class="fancyLink" href="/madhoo/viewothermadhoo/4"><b>Blah Blah</b></a>. Assign him to me', '2013-05-27 00:06:22', '2013-05-26 18:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `insr_request_management`
--

CREATE TABLE IF NOT EXISTS `insr_request_management` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `callee_id` bigint(20) NOT NULL,
  `caller_id` bigint(20) NOT NULL,
  `owner_id` bigint(20) DEFAULT NULL,
  `requested_by` bigint(20) NOT NULL,
  `responded_by` bigint(20) DEFAULT NULL,
  `approved_ignored` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `caller_id` (`caller_id`),
  KEY `callee_id` (`callee_id`),
  KEY `owner_id` (`owner_id`),
  KEY `requested_by` (`requested_by`),
  KEY `responded_by` (`responded_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All assignment and approval request should have entry here' AUTO_INCREMENT=1 ;

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
('3frp0rlffb5frsm55pr2d6vc03', 1369686539, 0x66303235356131333561393136636633323839653761623433616531646637385f5f72657475726e55726c7c733a31383a222f70726f66696c652f64617368626f617264223b66303235356131333561393136636633323839653761623433616531646637387573657253657373696f6e54696d656f75747c693a313336393639323239393b66303235356131333561393136636633323839653761623433616531646637385f5f69647c733a313a2231223b66303235356131333561393136636633323839653761623433616531646637385f5f6e616d657c733a32303a2269616e7361726d61696c40676d61696c2e636f6d223b6630323535613133356139313663663332383965376162343361653164663738726f6c657c733a353a2261646d696e223b6630323535613133356139313663663332383965376162343361653164663738656d61696c7c733a32303a2269616e7361726d61696c40676d61696c2e636f6d223b66303235356131333561393136636633323839653761623433616531646637386e616d657c733a383a224a6562696e204256223b663032353561313335613931366366333238396537616234336165316466373863616e5f696e766974657c733a313a2231223b663032353561313335613931366366333238396537616234336165316466373870726f66696c655f636f6d706c657465647c733a313a2231223b66303235356131333561393136636633323839653761623433616531646637385f5f7374617465737c613a353a7b733a343a22726f6c65223b623a313b733a353a22656d61696c223b623a313b733a343a226e616d65223b623a313b733a31303a2263616e5f696e76697465223b623a313b733a31373a2270726f66696c655f636f6d706c65746564223b623a313b7d),
('43n402arrbgen0g3cduamp6m21', 1369686431, ''),
('4i0l9jbbmudua8epa222qg7v96', 1369686440, ''),
('4q9de867atvntgk2ftnn8kkkh0', 1369686400, ''),
('5agnli0p8ilrsclsvhi28llls0', 1369686438, ''),
('77u2575k7q5vt7hs8r8oeatqc4', 1369686436, ''),
('brrikuk6k177ihnpeaaqaagkf0', 1369686374, ''),
('gu9s3gnrhvj3c8lagorif15j67', 1369686397, ''),
('h4hi05vi49dj81tlmpsvbqa016', 1369686539, ''),
('iflrjftu28l9kudikvih3hd9d0', 1369686434, ''),
('kp1tj8mffp2j15mja6sd6ub0q3', 1369686418, ''),
('njol00enr1q9a1hkreft5u65i3', 1369686365, ''),
('qof124ibp8baujk3sqtd28fu32', 1369686424, ''),
('v1h1vrgnr32kli7e3grtd8upk7', 1369686442, '');

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

--
-- Constraints for table `insr_request_management`
--
ALTER TABLE `insr_request_management`
  ADD CONSTRAINT `insr_request_management_ibfk_5` FOREIGN KEY (`responded_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_request_management_ibfk_1` FOREIGN KEY (`callee_id`) REFERENCES `insr_callees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_request_management_ibfk_2` FOREIGN KEY (`caller_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_request_management_ibfk_3` FOREIGN KEY (`owner_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_request_management_ibfk_4` FOREIGN KEY (`requested_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
