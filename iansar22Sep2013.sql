-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 22, 2013 at 06:05 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iansar_loc`
--

-- --------------------------------------------------------

--
-- Table structure for table `insr_activities`
--

CREATE TABLE IF NOT EXISTS `insr_activities` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `viewer` varchar(50) DEFAULT 'admin' COMMENT 'who can view this log -> if null can be viewed by both super admin and admin',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Admin and super admin can view the summary of all activities' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `insr_admin_messages`
--

CREATE TABLE IF NOT EXISTS `insr_admin_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sender_id` bigint(20) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `target_caller_id` bigint(20) DEFAULT NULL,
  `title` text,
  `message` longtext,
  `read_by` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `target_callee_id` (`target_caller_id`),
  KEY `read_by` (`read_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Messages to admin' AUTO_INCREMENT=1 ;

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
  `renewed_date` date DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `is_hidden` varchar(2) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `caller_id` (`caller_id`),
  KEY `owned_by` (`owned_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `insr_callees`
--

INSERT INTO `insr_callees` (`id`, `caller_id`, `owned_by`, `requested_by`, `first_name`, `last_name`, `family_name`, `nick_name`, `gender`, `age`, `highest_qualification`, `profession`, `house_no`, `street`, `area`, `city`, `state`, `country`, `zip`, `language_read`, `language_write`, `language_speak`, `religion`, `email_id`, `phone_number`, `social_network_id`, `messenger_id`, `status`, `note`, `renewed_date`, `is_deleted`, `is_hidden`, `created_at`, `updated_at`) VALUES
(1, 5, 6, NULL, 'Ravi', 'Kumar', 'Kalsigi', 'Ravi', 'MALE', 34, 'M.E', 'Lecturer', '', '', '', 'Bangalore', 'Karnataka', 'India', 465654, 'Kannada, English, Hindi', 'Kannada, English, Hindi', 'Kannada, English, Hindi', 'Hindu', 'ravikalsigi@vsnl.net', '4567891254', '{"facebook":"kalsigi12"}', '{"gtalk":"kalsigi12"}', 'NO_INTERACTION_YET', 'Sample information.', NULL, 0, '0', '2013-08-29 11:49:51', '2013-09-22 10:23:30'),
(2, 7, NULL, NULL, 'LAKSHMAN', 'LAKSHMAN', '', '', 'MALE', 40, 'SSC', 'Tailor', '', '', '', 'Kurnool', 'Andhra Pradesh', 'India', 0, 'Telugu', 'Telugu', 'Telugu', 'Hindu', 'irsharsh@gmail.com', '9703997802', NULL, '{"gtalk":"irsh.ppc@gmail.com"}', 'ACCEPTED', 'Alhamdulillah. He has accepted islam..Have to follow up for tarbiyah..', NULL, 0, '0', '2013-09-03 21:24:07', '2013-09-22 10:23:30'),
(3, 7, NULL, NULL, 'Dr Venkat ', 'Swamy', '', '', 'MALE', 45, 'MD', 'Doctor', '', '', '', 'Kurnool', 'Andhra Pradesh', 'India', 0, 'English, Telugu', 'English, Telugu', 'English, Telugu', 'Hindu', 'irshad_bca@rediffmail.com', '9701955049', '{"Twitter":"irsharsh@in.com"}', NULL, 'ACCEPTED', 'Tarbiyat required..', NULL, 0, '0', '2013-09-03 21:32:07', '2013-09-22 10:23:30'),
(4, 8, NULL, NULL, 'Murugesh', 'Raman', 'Rao', 'Muruga', 'MALE', 30, 'BA, LLB', 'Lawyer', '', '', '', 'Ambur', 'Tamil Nadu', 'India', 655655, 'English, Tamil', 'English, Tamil', 'English, Tamil, Malayalam', 'Hindu', 'murugarao@ramanna.com', '6464464554', '{"GooglePlus":"murugaraoaaa"}', '{"hotmailmessenger":"murugaraoaaa"}', 'NO_INTERACTION_YET', 'Met him at Annual Lawyers Meet 2013 in Bangalore. By the conversation we had it seems, he is interested in knowing about Islam.', NULL, 0, '0', '2013-09-06 12:02:07', '2013-09-22 10:23:30'),
(5, 9, NULL, NULL, 'Mikesh', 'Lasim', 'Gupta', 'Mikesh', 'MALE', 32, 'B.Tech', 'Senior Analyst at XYZABC', '', '', '', 'Bangalore', 'Karnataka', 'India', 465654, 'English, Hindi, Gujrati', 'English, Hindi, Gujrati', 'English, Hindi, Gujrati', 'Hindu', 'mikeshlasim@lasimia.com', '1848484832', '{"facebook":"mikeshmadhoo","GooglePlus":"mikeshmadhoo"}', '{"skypeid":"mikeshmadhoo"}', 'PARTIALLY_CONVINCED', 'Discussed for a while in Train.', NULL, 0, '0', '2013-09-06 12:17:30', '2013-09-22 10:23:30'),
(6, 9, NULL, NULL, 'John', 'Raj', 'White', '', 'MALE', 29, 'M.Tech', 'Research Scientist in LMNOP', '', '', '', 'Thane', 'Maharashtra', 'India', 405152, 'English, Hindi, Marathi', 'English, Hindi, Marathi', 'English, Hindi, Marathi', 'Christian', 'whitejr@joniraj.com', '646455645', '{"facebook":"jonirajwhite"}', '{"hotmailmessenger":"jonirajwhite","skypeid":"jonirajwhite"}', 'NO_INTERACTION_YET', 'Gave the online copy booklet ''purpose of life''. And have given my number for any clarfications or doubts. He is brother''s friend.', NULL, 0, '0', '2013-09-06 12:22:02', '2013-09-22 10:23:30'),
(7, 12, NULL, NULL, 'Sundar', 'Krishna', '', '', 'MALE', 34, 'BAMC', 'Practicing Intern', '', '', 'Rajajinagar', 'Bangalore', 'Karnataka', 'India', 560010, 'English, Kannada, Hindi', 'English, Kannada, Hindi', 'English, Kannada, Hindi', 'Hindu', 'iansartest7@madhoo.com', '1854844854', '{"facebook":"madhooiansartest7"}', '{"yahoomessenger":"madhooiansartest7"}', 'PARTIALLY_CONVINCED', 'Have been discussing with him about several things. But he has few questions which I am not able to answer. See if anybody who is knowledgable and knows kannada or Hindi can take it forward.', NULL, 0, '0', '2013-09-08 05:07:29', '2013-09-22 10:23:30'),
(8, 11, NULL, NULL, 'Abhishek', 'Hari', 'Gupta', 'Abhi', 'MALE', 23, 'M.Tech', 'Pursuing M.Tech in Bangalore', '', '', 'SR Nagar', 'Bangalore', 'Karnataka', 'India', 560003, 'English, Hindi, Punjabi', 'English, Hindi, Punjabi', 'English, Hindi, Punjabi', 'Hindu', 'iansartest6@madhoo.com', '6586544848', '{"GooglePlus":"madhooiansartest6"}', '{"skypeid":"madhooiansartest6"}', 'PARTIALLY_CONVINCED', 'Friend of my friend. Met him at his college''s Annual Fest. Happen to discuss a little about his life. He is bit disturbed and in search of truth. He attends Alma Mater sessions (which is now known as Infinitheism).', NULL, 0, '0', '2013-09-08 06:12:53', '2013-09-22 10:23:30'),
(9, 10, NULL, NULL, 'Dharmesh', 'Patil', 'Jangamkote', 'Dharmesh', 'MALE', 29, 'B.E', 'Software Engineer in an MNC', '', '', 'Yelhanka', 'Bangalore', 'Karnataka', 'India', 560100, 'English, Kannada, Hindi, Marathi', 'English, Kannada, Hindi, Marathi', 'English, Kannada, Hindi, Marathi', 'Hindu', 'madhoodharmesh@iansar.com', '4846463485', '{"facebook":"madhoodharmesh"}', '{"yahoomessenger":"madhoodharmesh"}', 'NO_INTERACTION_YET', '', NULL, 0, '0', '2013-09-08 06:19:39', '2013-09-22 10:23:30'),
(10, 5, NULL, NULL, 'Madan', 'Raj', 'Patel', 'Madan', 'MALE', 36, 'B.Sc', 'Jewellery shop Owner', '', '', 'Chikpet', 'Bangalore', 'Karnataka', 'India', 560003, 'English, Marvadi, Hindi, Kannada', 'English, Marvadi, Hindi, Kannada', 'English, Marvadi, Hindi', 'Hindu', 'madhoomadan@iansar.com', '6449684644', '{"facebook":"madhoomadan"}', '{"gtalk":"madhoomadan"}', 'CONVINCED', '', NULL, 0, '0', '2013-09-08 06:34:35', '2013-09-22 10:23:30'),
(11, 12, NULL, '[]', 'Ankit', 'Singh', 'Singh', 'Ankit', 'FEMALE', 23, 'Studying MBA', 'Studying MBA', '', '', 'Whitefield', 'Bangalore', 'Karnataka', 'India', 560090, 'English, Hindi', 'English, Hindi', 'English, Hindi', 'Hindu', 'ankitsinghmadhoo@iansar.com', '4584654655', '{"facebook":"ankitsinghmadhoo"}', '{"hotmailmessenger":"ankitsinghmadhoo"}', 'DISAGREED', '', NULL, 0, '0', '2013-09-08 06:38:42', '2013-09-22 10:23:30');

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
  `action_by` text,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Da''ee registration & login lookup table' AUTO_INCREMENT=13 ;

--
-- Dumping data for table `insr_callers`
--

INSERT INTO `insr_callers` (`id`, `role`, `email`, `password`, `profile_completion_status`, `active_status`, `action_by`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'iansarmail@gmail.com', 'a360bddfa8155e5d46326f3a31aba595', 1, 1, NULL, '2012-12-22 13:46:30', '2013-08-03 07:36:29'),
(4, NULL, 'mdzakir.com@gmail.com', 'f304c45d3778bc3c71bf330e881cd3fb', 1, 1, '[{"12":"1"},{"12":"3"},{"12":"1"}]', '2013-08-28 12:03:04', '2013-09-22 07:18:36'),
(5, NULL, 'amdzakir@outlook.com', 'f304c45d3778bc3c71bf330e881cd3fb', 1, 1, NULL, '2013-08-29 11:39:25', '2013-09-22 07:35:39'),
(6, NULL, 'dmdfaisal@gmail.com', 'ebac7e077c0ef9b6dd2ab181f359718f', 1, 1, NULL, '2013-09-02 02:55:37', '2013-09-02 09:01:26'),
(7, NULL, 'irsh.arsh@gmail.com', '7edcc994480116ba3ac17a3819304a8f', 1, 1, NULL, '2013-09-02 22:12:31', '2013-09-03 04:52:23'),
(8, NULL, 'iansartest1@outlook.com', 'f304c45d3778bc3c71bf330e881cd3fb', 1, 1, NULL, '2013-09-06 11:57:26', '2013-09-06 18:02:02'),
(9, NULL, 'iansartest2@outlook.com', 'f304c45d3778bc3c71bf330e881cd3fb', 1, 1, NULL, '2013-09-06 12:10:39', '2013-09-06 18:14:49'),
(10, NULL, 'iansartest3@outlook.com', 'f304c45d3778bc3c71bf330e881cd3fb', 1, 1, NULL, '2013-09-06 12:33:27', '2013-09-06 18:36:31'),
(11, NULL, 'iansartest6@outlook.com', 'f304c45d3778bc3c71bf330e881cd3fb', 1, 1, NULL, '2013-09-07 12:07:23', '2013-09-07 18:11:41'),
(12, 'admin', 'iansartest7@outlook.com', 'f304c45d3778bc3c71bf330e881cd3fb', 1, 1, NULL, '2013-09-08 05:04:04', '2013-09-09 17:35:08');

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
  `can_invite` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0=>no, 1=>yes',
  `can_hide` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `caller_id` (`caller_id`),
  KEY `email_id` (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `insr_callers_profile`
--

INSERT INTO `insr_callers_profile` (`id`, `caller_id`, `first_name`, `last_name`, `family_name`, `nick_name`, `gender`, `date_of_birth`, `email_id`, `social_network_id`, `messenger_id`, `house_no`, `street`, `area`, `city`, `state`, `country`, `zip`, `primary_phone`, `secondary_phone`, `highest_education`, `profession`, `type_of_user`, `profile_pic`, `languages_known`, `callee_created`, `callee_owned`, `can_own_cnt`, `unassigned_madhoo`, `can_invite`, `can_hide`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super', 'Admin', 'Super', 'Admin', 'MALE', '1986-01-15', 'iansarmail@gmail.com', '{"facebook":"dmdfaisal","Twitter":"dmdfaisal"}', '{"gtalk":"dmdfaisal@gmail.com","skypeid":"dmdfaisal"}', '', '', 'Shivajinagar', 'Bangalore', 'Karnataka', 'India', 560001, '9739135891', '', 'B.Tech(IT)', 'Software Engineer', 'DAEE', '1377712350_Desertjpg.png', '["Tamil","English","Urdu","Kannada"]', '', '[{"id":"1","update_at":"\\"2013-08-28 00:09:26\\""}]', 16, NULL, 1, 1, '2012-12-23 00:03:22', '2013-08-28 17:52:30'),
(4, 4, 'Muhammad', 'Zakir', 'Muhammad', 'Zakir', 'MALE', '1986-07-13', 'mdzakir.com@gmail.com', '{"facebook":"yahoobook"}', '{"skypeid":"amdzakir"}', '', '', 'Funworld', 'Bangalore', 'Karnataka', 'India', 560001, '7204180050', '', 'B.E(IS)', 'Software Engineer', NULL, '1377713152_Lighthousejpg.png', '["Kannada","English","Hindi"]', '[{"id":"11","update_at":"\\"2013-09-08 06:45:29\\""}]', NULL, 6, NULL, 1, 1, '2013-08-28 12:05:53', '2013-09-22 10:50:02'),
(5, 5, 'MD', 'Zakir', 'MD', 'Zakir', 'MALE', '1986-07-14', 'amdzakir@outlook.com', '{"facebook":"yahoobook"}', '{"skypeid":"amdzakir"}', '', '', 'Funworld', 'Bangalore', 'Karnataka', 'India', 560001, '7204180050', '', 'B.E(IS)', 'Software Engineer', NULL, '1377798104_Tulipsjpg.png', '["Kannada","English","Hindi"]', '[{"id":"10","update_at":"\\"2013-09-08 06:38:06\\""}]', NULL, 5, NULL, 0, 0, '2013-08-29 11:41:44', '2013-09-22 06:55:19'),
(6, 6, 'Faisal', 'Dokku', 'Dokku', 'Faisal', 'MALE', '1982-12-15', 'dmdfaisal@gmail.com', '{"":""}', '{"gtalk":"dmdfaisal","skypeid":"dmdfaisal"}', '31/1-2', 'Hospital Road', 'Shivajinagar', 'Bangalore', 'Karnataka', 'India', 560001, '97455076910', '97455076910', 'B.Com', 'System Analyst - IT', NULL, '1378112486_Lighthousejpg.png', '["English","Urdu","Hindi","Tamil","Arabic"]', NULL, NULL, 5, NULL, 0, 0, '2013-09-02 03:01:26', '2013-09-02 09:02:14'),
(7, 7, 'Irshad', 'Mohammed', '', '', 'MALE', '1981-01-20', 'irsh.arsh@gmail.com', '[]', '{"gtalk":"irsh.ppc@gmail.com"}', '', '', 'Tolichowki', 'Hyderabad', 'Andhra Pradesh', 'India', 500008, '9885390877', '', 'MBA', 'Business', NULL, '1378184585_islamicjpg.png', '["English","urdu"]', '[{"id":"3","update_at":"\\"2013-09-03 21:35:59\\""}]', NULL, 5, NULL, 0, 0, '2013-09-02 22:52:23', '2013-09-04 03:35:59'),
(8, 8, 'Uzair', 'Ahmed', 'Ansari', 'Uzair', 'MALE', '1983-06-08', 'iansartest1@outlook.com', '{"GooglePlus":"iansartest1"}', '{"skypeid":"iansartest1"}', '', '', 'RT Nagar', 'Bangalore', 'Karnataka', 'India', 560032, '7204180050', '', 'BA, LLB', 'Practicing lawyer', NULL, '1378490522_Koalajpg.png', '["English","Hindi","Tamil"]', '[{"id":"4","update_at":"\\"2013-09-06 12:07:43\\""}]', NULL, 5, NULL, 0, 0, '2013-09-06 12:02:02', '2013-09-06 18:07:43'),
(9, 9, 'Nazeer', 'Mohammed', 'Baig', 'Nazeer', 'MALE', '1981-12-17', 'iansartest2@outlook.com', '{"LinkedIn":"iansartest2","facebook":"iansartest2","GooglePlus":"iansartest2"}', '{"hotmailmessenger":"iansartest2"}', '', '', 'Ejipura', 'Bangalore', 'Karnataka', 'India', 560095, '7204180050', '', 'MBA', 'HR Manager', NULL, '1378491288_Hydrangeasjpg.png', '["English","Urdu","Hindi","Kannada","Telugu"]', '[{"id":"6","update_at":"\\"2013-09-06 12:27:27\\""}]', NULL, 5, NULL, 1, 0, '2013-09-06 12:14:49', '2013-09-08 11:02:44'),
(10, 10, 'Mohamed', 'Yusuf', 'Khudri', 'Yusuf', 'MALE', '1985-05-14', 'iansartest3@outlook.com', '{"facebook":"iansartest3"}', '{"yahoomessenger":"iansartest3"}', '', '', 'ChamundiNagar', 'Bangalore', 'Karnataka', 'India', 560033, '7204180050', '', 'BCA', 'Tech Specialist at PQRST', NULL, '1378492591_Jellyfishjpg.png', '["English","Kannada","Urdu","Hindi"]', '[{"id":"9","update_at":"\\"2013-09-08 06:23:20\\""}]', NULL, 5, NULL, 0, 0, '2013-09-06 12:36:31', '2013-09-08 12:23:20'),
(11, 11, 'Owes', 'Hussain', 'Mysoori', 'Owes', 'MALE', '1984-03-21', 'iansartest6@outlook.com', '{"facebook":"iansartest6","LinkedIn":"iansartest6","Pinterest":"iansartest6"}', '{"hotmailmessenger":"iansartest6","yahoomessenger":"iansartest6","skypeid":"iansartest6"}', '', '', 'Hegde Nagar', 'Bangalore', 'Karnataka', 'India', 560016, '3191445565', '', 'B.A Fine Arts', 'Artist Professor at FNARTS', NULL, '1378577501_Hydrangeasjpg.png', '["English","Tamil","Urdu"]', '[{"id":"8","update_at":"\\"2013-09-08 06:18:17\\""}]', NULL, 5, NULL, 0, 0, '2013-09-07 12:11:41', '2013-09-08 12:18:17'),
(12, 12, 'Sadiq', 'Ahmed', 'Syed', 'Sadiq', 'MALE', '1983-06-13', 'iansartest7@outlook.com', '{"GooglePlus":"iansartest7"}', '{"yahoomessenger":"iansartest7"}', '', '', 'Yeshwantpur', 'Bangalore', 'Karnataka', 'India', 560055, '8455965656', '', 'BAMC', 'Doctor - Own clinic', NULL, '1378638419_Jellyfishjpg.png', '["English","Kannada","Telugu","Tamil","Hindi"]', '[{"id":"7","update_at":"\\"2013-09-08 05:11:29\\""}]', NULL, 5, NULL, 0, 0, '2013-09-08 05:06:59', '2013-09-08 11:11:29');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `insr_conversations`
--

INSERT INTO `insr_conversations` (`id`, `callee_id`, `conversation`, `owner_id`, `status`, `interaction_status`, `created_at`, `updated_at`) VALUES
(1, 5, 'Asked for a copy of english Quran . Sent it to him.', 9, '1', 'PARTIALLY_CONVINCED', '2013-09-08 05:54:11', '2013-09-08 11:51:51');

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
  `dont_send` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitee_email` (`invitee_email`),
  KEY `invited_by` (`invited_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `insr_invitation`
--

INSERT INTO `insr_invitation` (`id`, `invitee_email`, `invited_by`, `lookup_phrase`, `status`, `dont_send`, `created_at`, `updated_at`) VALUES
(4, 'mdzakir.com@gmail.com', 1, 'd2b57705bca5a5df18a92e074b798aa5', 0, 0, '2013-08-28 12:02:29', '2013-08-28 18:02:39'),
(9, 'amdzakir@outlook.com', 1, 'b1c9bc22df36ec639c82ee266f59c398', 0, 0, '2013-08-29 11:38:46', '2013-08-29 17:39:10'),
(10, 'dmdfaisal@gmail.com', 1, 'f4d67808c0bbc1622b10c3714b58e473', 0, 0, '2013-09-02 02:53:31', '2013-09-02 08:55:04'),
(11, 'irsh.arsh@gmail.com', 1, 'fc89137727c1fc6172d20ed66d2db8b4', 0, 0, '2013-09-02 03:22:57', '2013-09-03 14:55:08'),
(12, 'jeelani.khan@gmail.com', 1, '0eb6f4f7a8017573d647c112a90bc7e9', 0, 0, '2013-09-02 03:22:57', '2013-09-02 09:22:57'),
(13, 'iansartest1@outlook.com', 4, '0f19a7d6146508fdc108341d0866a5b6', 0, 0, '2013-09-06 11:56:30', '2013-09-06 17:57:13'),
(14, 'iansartest2@outlook.com', 4, '5a4cba2ad17f61825e9fd6f8619ac265', 0, 0, '2013-09-06 12:09:17', '2013-09-06 18:10:30'),
(15, 'iansartest3@outlook.com', 9, '06f8ec2d8988232b514023e2cedfe600', 0, 0, '2013-09-06 12:32:23', '2013-09-06 18:33:15'),
(16, 'iansartest4@yahoo.com', 9, '5dacb1759d918d577626576ffea567e6', 0, 0, '2013-09-06 12:32:40', '2013-09-06 18:32:40'),
(17, 'iansartest5@yahoo.com', 9, '7cbedbfd2f2328de0ba8a5d79a495d0e', 0, 0, '2013-09-06 12:32:56', '2013-09-06 18:32:56'),
(18, 'iansartest6@outlook.com', 4, '1473a06f0a9cbc9d83ae0e8b69037ffb', 0, 0, '2013-09-07 12:06:50', '2013-09-07 18:07:05'),
(19, 'iansartest7@outlook.com', 9, '95ac848835ae1bd5451b9848aa28bc18', 0, 0, '2013-09-08 05:03:26', '2013-09-08 11:03:48');

-- --------------------------------------------------------

--
-- Table structure for table `insr_messages`
--

CREATE TABLE IF NOT EXISTS `insr_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sender_id` bigint(20) NOT NULL,
  `receiver_id` bigint(20) NOT NULL,
  `type` varchar(100) NOT NULL COMMENT 'ADMIN_SPAM, ADMIN_WARN, ADMIN_BLOCK, ASSIGNMENT, UNASSIGNMENT',
  `sender_status` varchar(50) NOT NULL DEFAULT 'READ' COMMENT 'READ, DELETED',
  `receiver_status` varchar(50) NOT NULL DEFAULT 'UNREAD' COMMENT 'READ, UNREAD, DELETED',
  `title` text,
  `description` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`,`receiver_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `insr_messages`
--

INSERT INTO `insr_messages` (`id`, `sender_id`, `receiver_id`, `type`, `sender_status`, `receiver_status`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 5, 4, 'MESSAGE', 'READ', 'UNREAD', 'Regarding your madhoo (Rahul) meeting', 'Assalaamu''alaikum Zakir, Please let me know your availability for the meeting.', '2013-08-29 11:43:54', '2013-09-07 17:57:04'),
(2, 5, 1, 'MESSAGE', 'READ', 'READ', 'Regarding my madhoo count', 'Assalamu''alaikum Brother, since I am doing dawah for full time for a coming few months, could you please increase my madhoo count.\n\nJazakAllaah khair', '2013-08-29 11:47:00', '2013-09-21 18:26:39'),
(3, 5, 4, 'MESSAGE', 'DELETED', 'UNREAD', 'Sample message for testing', ' A saint found a group of family members on the banks of a river, shouting in anger at each other. He turned to his disciples smiled ''n asked. ''Why do people in anger shout at each other?'' Disciples thought for a while, one of them said, ''Because we lose our calm, we shout.'' ''But, why should you shout when the other person is just next to you? You can as well tell him what you have to say in a soft manner.'' asked the saint Disciples gave some other answers but none satisfied the other disciples. Finally the saint explained, . ''When two people are angry at each other, their hearts distance a lot. To cover that distance they must shout to be able to hear each other. The angrier they are, the stronger they will have to shout to hear each other to cover that great distance. What happens when two people fall in love? They don''t shout at each other but talk softly, Because their hearts are very close. The distance between them is either nonexistent or very small...'' The saint continued, ''When they love each other even more, what happens? They do not speak, only whisper ''n they get even closer to each other in their love. Finally they even need not whisper, they only look at each other ''n that''s all. That is how close two people are when they love each other.'' He looked at his disciples and said. ''So when you argue do not let your hearts get distant, Do not say words that distance each other more, Or else there will come a day when the distance is so great that you will not find the path to return.''', '2013-08-29 11:48:16', '2013-09-20 18:57:21'),
(4, 4, 8, 'ASSIGNMENT_IGNORED', 'UNREAD', 'UNREAD', 'Request for Madhoo Rejected', 'The requested Madhoo [[{"href":"/madhoo/viewmadhoo/11","madhoo":"11"}]] is rejected.', '2013-09-20 23:35:51', '2013-09-20 18:05:51'),
(5, 4, 9, 'ASSIGNMENT_IGNORED', 'UNREAD', 'READ', 'Request for Madhoo Rejected', 'The requested Madhoo [[{"href":"/madhoo/viewmadhoo/11","madhoo":"11"}]] is rejected.', '2013-09-20 23:44:25', '2013-09-21 18:27:19');

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
  `caller_status` varchar(255) NOT NULL DEFAULT 'UNREAD',
  `owner_status` varchar(255) NOT NULL DEFAULT 'UNREAD',
  `sender_status` varchar(255) NOT NULL DEFAULT 'READ',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `caller_id` (`caller_id`),
  KEY `callee_id` (`callee_id`),
  KEY `owner_id` (`owner_id`),
  KEY `requested_by` (`requested_by`),
  KEY `responded_by` (`responded_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='All assignment and approval request should have entry here' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `insr_request_management`
--

INSERT INTO `insr_request_management` (`id`, `callee_id`, `caller_id`, `owner_id`, `requested_by`, `responded_by`, `approved_ignored`, `caller_status`, `owner_status`, `sender_status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 11, 4, NULL, 8, 4, 'IGNORED', 'DELETED', 'UNREAD', 'READ', 0, '2013-09-15 19:04:18', '2013-09-20 19:12:31'),
(2, 11, 4, NULL, 9, 4, 'IGNORED', 'DELETED', 'UNREAD', 'READ', 0, '2013-09-17 23:06:50', '2013-09-20 19:12:31');

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
('7ubesqoub8trvkp2ro32b0obo2', 1379852093, 0x66303235356131333561393136636633323839653761623433616531646637385969692e43576562557365722e666c617368636f756e746572737c613a303a7b7d),
('88u1lo4p666per176im3c0p0h2', 1379853048, 0x6769695f5f72657475726e55726c7c733a343a222f676969223b6769695f5f69647c733a353a227969696572223b6769695f5f6e616d657c733a353a227969696572223b6769695f5f7374617465737c613a303a7b7d66303235356131333561393136636633323839653761623433616531646637385f5f72657475726e55726c7c733a31373a222f616374697669746965732f61646d696e223b66303235356131333561393136636633323839653761623433616531646637387573657253657373696f6e54696d656f75747c693a313337393835383830373b66303235356131333561393136636633323839653761623433616531646637385f5f69647c733a313a2231223b66303235356131333561393136636633323839653761623433616531646637385f5f6e616d657c733a32303a2269616e7361726d61696c40676d61696c2e636f6d223b6630323535613133356139313663663332383965376162343361653164663738726f6c657c733a31313a2273757065725f61646d696e223b6630323535613133356139313663663332383965376162343361653164663738656d61696c7c733a32303a2269616e7361726d61696c40676d61696c2e636f6d223b66303235356131333561393136636633323839653761623433616531646637386e616d657c733a31313a2253757065722041646d696e223b663032353561313335613931366366333238396537616234336165316466373863616e5f696e766974657c733a313a2231223b663032353561313335613931366366333238396537616234336165316466373870726f66696c655f636f6d706c657465647c733a313a2231223b66303235356131333561393136636633323839653761623433616531646637385f5f7374617465737c613a353a7b733a343a22726f6c65223b623a313b733a353a22656d61696c223b623a313b733a343a226e616d65223b623a313b733a31303a2263616e5f696e76697465223b623a313b733a31373a2270726f66696c655f636f6d706c65746564223b623a313b7d),
('dpgq8ujftqnm8i6ajndk2mepo4', 1379853072, 0x66303235356131333561393136636633323839653761623433616531646637387573657253657373696f6e54696d656f75747c693a313337393835383833323b66303235356131333561393136636633323839653761623433616531646637385f5f69647c733a323a223132223b66303235356131333561393136636633323839653761623433616531646637385f5f6e616d657c733a32333a2269616e7361727465737437406f75746c6f6f6b2e636f6d223b6630323535613133356139313663663332383965376162343361653164663738726f6c657c733a353a2261646d696e223b6630323535613133356139313663663332383965376162343361653164663738656d61696c7c733a32333a2269616e7361727465737437406f75746c6f6f6b2e636f6d223b66303235356131333561393136636633323839653761623433616531646637386e616d657c733a31313a2253616469712041686d6564223b663032353561313335613931366366333238396537616234336165316466373863616e5f696e766974657c733a313a2230223b663032353561313335613931366366333238396537616234336165316466373870726f66696c655f636f6d706c657465647c733a313a2231223b66303235356131333561393136636633323839653761623433616531646637385f5f7374617465737c613a353a7b733a343a22726f6c65223b623a313b733a353a22656d61696c223b623a313b733a343a226e616d65223b623a313b733a31303a2263616e5f696e76697465223b623a313b733a31373a2270726f66696c655f636f6d706c65746564223b623a313b7d);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `insr_admin_messages`
--
ALTER TABLE `insr_admin_messages`
  ADD CONSTRAINT `insr_admin_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_admin_messages_ibfk_3` FOREIGN KEY (`read_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_admin_messages_ibfk_4` FOREIGN KEY (`target_caller_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `insr_request_management_ibfk_1` FOREIGN KEY (`callee_id`) REFERENCES `insr_callees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_request_management_ibfk_2` FOREIGN KEY (`caller_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_request_management_ibfk_3` FOREIGN KEY (`owner_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_request_management_ibfk_4` FOREIGN KEY (`requested_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `insr_request_management_ibfk_5` FOREIGN KEY (`responded_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
