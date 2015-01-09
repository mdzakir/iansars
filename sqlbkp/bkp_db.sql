DROP TABLE IF EXISTS insr_activities;

CREATE TABLE `insr_activities` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `viewer` varchar(50) DEFAULT 'admin' COMMENT 'who can view this log -> if null can be viewed by both super admin and admin',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 COMMENT='Admin and super admin can view the summary of all activities';

INSERT INTO insr_activities VALUES("20","Daee [[{\"href\":\"/daee/1\",\"daee\":\"1\"}]] has sent invitation to mdzakir.com@gmail.com","","0","2014-02-11 23:41:49","2014-02-11 23:41:49");
INSERT INTO insr_activities VALUES("21","Daee [[{\"href\":\"/daee/1\",\"daee\":\"1\"}]] has sent invitation to mdzakir.com@gmail.com","","0","2014-02-11 23:55:21","2014-02-11 23:55:21");
INSERT INTO insr_activities VALUES("22","Daee [[{\"href\":\"/daee/1\",\"daee\":\"1\"}]] has sent invitation to mdzakir.com@gmail.com","","0","2014-02-11 23:59:57","2014-02-11 23:59:57");
INSERT INTO insr_activities VALUES("23","Daee [[{\"href\":\"/daee/1\",\"daee\":\"1\"}]] has sent invitation to mdzakir.com@gmail.com","","0","2014-02-12 00:09:33","2014-02-12 00:09:33");
INSERT INTO insr_activities VALUES("24","Daee [[{\"href\":\"/daee/1\",\"daee\":\"1\"}]] has sent invitation to mdzakir.com@gmail.com","","0","2014-02-12 00:12:02","2014-02-12 00:12:02");
INSERT INTO insr_activities VALUES("25","Daee [[{\"href\":\"/daee/13\",\"daee\":\"13\"}]] has completed his profile","","0","2014-02-12 00:19:04","2014-02-12 00:19:04");
INSERT INTO insr_activities VALUES("26","Daee [[{\"href\":\"/daee/13\",\"daee\":\"13\"}]] has added a Madhoo [[{\"href\":\"/madhoo/viewmadhoo/13\",\"madhoo\":\"13\"}]]","","0","2014-02-12 00:24:06","2014-02-12 00:24:06");
INSERT INTO insr_activities VALUES("27","Daee [[{\"href\":\"/daee/13\",\"daee\":\"13\"}]] has added a conversation for the Madhoo [[{\"href\":\"/madhoo/viewmadhoo/13\",\"madhoo\":\"13\"}]]","","0","2014-02-12 00:25:38","2014-02-12 00:25:38");
INSERT INTO insr_activities VALUES("28","Madhoo [[{\"href\":\"/madhoo/viewmadhoo/13\",\"madhoo\":\"13\"}]] has been assigned to the Daee [[{\"href\":\"/daee/13\",\"daee\":\"13\"}]](Creator of the madhoo profile)","","0","2014-02-12 00:26:42","2014-02-12 00:26:42");
INSERT INTO insr_activities VALUES("29","Daee [[{\"href\":\"/daee/13\",\"daee\":\"13\"}]] has renewed the Madhoo [[{\"href\":\"/madhoo/viewmadhoo/13\",\"madhoo\":\"13\"}]]","","0","2014-02-12 00:26:57","2014-02-12 00:26:57");
INSERT INTO insr_activities VALUES("30","Daee [[{\"href\":\"/daee/13\",\"daee\":\"13\"}]] has unassigned the Madhoo [[{\"href\":\"/madhoo/viewmadhoo/13\",\"madhoo\":\"13\"}]]","","0","2014-02-12 00:27:58","2014-02-12 00:27:58");
INSERT INTO insr_activities VALUES("31","Daee [[{\"href\":\"/daee/1\",\"daee\":\"1\"}]] has sent invitation to mdzakir.com@gmail.com","","0","2014-02-16 23:58:29","2014-02-16 23:58:29");
INSERT INTO insr_activities VALUES("32","granted","","0","2014-02-17 00:00:38","2014-02-17 00:00:38");
INSERT INTO insr_activities VALUES("33","Daee [[{\"href\":\"/daee/13\",\"daee\":\"13\"}]] has sent invitation to amdzakir@outlook.com","","0","2014-02-17 00:01:20","2014-02-17 00:01:20");
INSERT INTO insr_activities VALUES("34","Daee [[{\"href\":\"/daee/14\",\"daee\":\"14\"}]] has completed his profile","","0","2014-02-17 00:05:34","2014-02-17 00:05:34");
INSERT INTO insr_activities VALUES("35","Daee [[{\"href\":\"/daee/1\",\"daee\":\"1\"}]] has sent invitation to amdzakir@outlook.com","","0","2014-02-17 00:14:44","2014-02-17 00:14:44");
INSERT INTO insr_activities VALUES("36","Daee [[{\"href\":\"/daee/15\",\"daee\":\"15\"}]] has completed his profile","","0","2014-02-17 23:20:22","2014-02-17 23:20:22");
INSERT INTO insr_activities VALUES("37","Daee [[{\"href\":\"/daee/15\",\"daee\":\"15\"}]] has requested for the Madhoo [[{\"href\":\"/madhoo/viewmadhoo/13\",\"madhoo\":\"13\"}]]","","0","2014-02-17 23:20:32","2014-02-17 23:20:32");
INSERT INTO insr_activities VALUES("38","Daee [[{\"href\":\"/daee/13\",\"daee\":\"13\"}]] has approved the request of the Daee [[{\"href\":\"/daee/15\",\"daee\":\"15\"}]] Madhoo [[{\"href\":\"/madhoo/viewmadhoo/13\",\"madhoo\":\"13\"}]]","","0","2014-02-17 23:21:30","2014-02-17 23:21:30");



DROP TABLE IF EXISTS insr_admin_messages;

CREATE TABLE `insr_admin_messages` (
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
  KEY `read_by` (`read_by`),
  CONSTRAINT `insr_admin_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `insr_admin_messages_ibfk_3` FOREIGN KEY (`read_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `insr_admin_messages_ibfk_4` FOREIGN KEY (`target_caller_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Messages to admin';




DROP TABLE IF EXISTS insr_callees;

CREATE TABLE `insr_callees` (
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
  KEY `owned_by` (`owned_by`),
  CONSTRAINT `insr_callees_ibfk_1` FOREIGN KEY (`caller_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `insr_callees_ibfk_2` FOREIGN KEY (`owned_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO insr_callees VALUES("13","13","15","","Ravi","Kumar","Namdhari","Ravi","MALE","27","BCA","Clerk in School","","","","Bangalore","","India","560065","English, Kannada, Hindi","English, Kannada, Hindi","English, Kannada, Hindi","Hindu","ravikumarnamdharis@iansars.com","7015454212","{\"facebook\":\"ravikumarnamdharis\"}","{\"yahoomessenger\":\"ravikumarnamdharis\"}","PARTIALLY_CONVINCED","Gave the Know the Truth booklet while traveling in bus. Need to follow up. Seems he is interested in knowing about the truth.","2014-02-17","0","0","2014-02-11 18:51:09","2014-02-17 17:51:30");



DROP TABLE IF EXISTS insr_callers;

CREATE TABLE `insr_callers` (
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COMMENT='Da''ee registration & login lookup table';

INSERT INTO insr_callers VALUES("1","super_admin","iansarmail@gmail.com","a360bddfa8155e5d46326f3a31aba595","1","1","","2012-12-22 13:46:30","2013-08-03 13:06:29");
INSERT INTO insr_callers VALUES("13","","mdzakir.com@gmail.com","f304c45d3778bc3c71bf330e881cd3fb","1","1","","2014-02-12 00:12:46","2014-02-12 00:19:04");
INSERT INTO insr_callers VALUES("15","","amdzakir@outlook.com","b1c9bc22df36ec639c82ee266f59c398","1","1","","2014-02-17 00:15:48","2014-02-17 23:20:22");



DROP TABLE IF EXISTS insr_callers_profile;

CREATE TABLE `insr_callers_profile` (
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
  `organization` text,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `caller_id` (`caller_id`),
  KEY `email_id` (`email_id`),
  CONSTRAINT `insr_callers_profile_ibfk_1` FOREIGN KEY (`caller_id`) REFERENCES `insr_callers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

INSERT INTO insr_callers_profile VALUES("1","1","Super","Admin","Super","Admin","MALE","1986-01-15","iansarmail@gmail.com","{\"facebook\":\"dmdfaisal\",\"Twitter\":\"dmdfaisal\"}","{\"gtalk\":\"dmdfaisal@gmail.com\",\"skypeid\":\"dmdfaisal\"}","","","Shivajinagar","Bangalore","Karnataka","India","560001","9739135891","","B.Tech(IT)","Software Engineer","DAEE","1377712350_Desertjpg.png","[\"Tamil\",\"English\",\"Urdu\",\"Kannada\"]","[{\"id\":\"12\",\"update_at\":\"\\\"2013-11-13 15:59:47\\\"\"}]","[{\"id\":\"12\",\"update_at\":\"\\\"2013-12-19 17:00:12\\\"\"}]","15","","1","1","","2012-12-23 00:03:22","2013-12-19 22:30:12");
INSERT INTO insr_callers_profile VALUES("13","13","Muhammad","Zakir","Kumbar","Zakir","MALE","1986-07-13","mdzakir.com@gmail.com","{\"facebook\":\"yahoobook\"}","{\"gtalk\":\"mdzakir.com\"}","","JC Nagar Road","JC Nagar","Bangalore","Karnataka","India","560006","7204180050","","Bachelors of Engg","Software Enggr","","1392144543_apple_touch_icon_144_precomposedpng.png","[\"English\",\"Hindi\",\"Kannada\"]","[{\"id\":\"13\",\"update_at\":\"\\\"2014-02-11 18:54:06\\\"\"}]","","4","[{\"id\":\"13\",\"update_at\":\"2014-02-11 18:57:58\"}]","1","0","","2014-02-12 00:19:03","2014-02-17 00:00:38");
INSERT INTO insr_callers_profile VALUES("15","15","MD","Zaakir","","Zaakir","MALE","1970-01-01","amdzakir@outlook.com","{\"Twitter\":\"yahoobook\"}","{\"hotmailmessenger\":\"amddddzakr\"}","","JC Nagar Road","JC Nagar","Bangalore","Karnataka","India","560006","65465646556","","Bachelors of Engg","Software Enggr","","1392659421_apple_touch_icon_57_precomposedpng.png","[\"English\"]","","[{\"id\":\"13\",\"update_at\":\"\\\"2014-02-17 17:51:30\\\"\"}]","4","","0","0","","2014-02-17 23:20:22","2014-02-17 23:21:30");



DROP TABLE IF EXISTS insr_conversations;

CREATE TABLE `insr_conversations` (
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
  KEY `owner_id` (`owner_id`),
  CONSTRAINT `insr_conversations_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `insr_conversations_ibfk_3` FOREIGN KEY (`callee_id`) REFERENCES `insr_callees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO insr_conversations VALUES("2","13","Met him again at RT Nagar Shanti sagar hotel. Spoke to him a li\'l bit about What is Islam and Who is Allah. He was in a hurry.","13","1","PARTIALLY_CONVINCED","2014-02-12 00:25:38","2014-02-11 18:54:06");



DROP TABLE IF EXISTS insr_invitation;

CREATE TABLE `insr_invitation` (
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
  KEY `invited_by` (`invited_by`),
  CONSTRAINT `insr_invitation_ibfk_1` FOREIGN KEY (`invited_by`) REFERENCES `insr_callers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

INSERT INTO insr_invitation VALUES("29","amdzakir@outlook.com","1","b1c9bc22df36ec639c82ee266f59c398","1","0","2014-02-17 00:14:38","2014-02-17 00:15:18");



DROP TABLE IF EXISTS insr_messages;

CREATE TABLE `insr_messages` (
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
  KEY `receiver_id` (`receiver_id`),
  CONSTRAINT `insr_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `insr_messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO insr_messages VALUES("1","13","15","ASSIGNMENT_SUCCESSFUL","READ","READ","Request for Madhoo Approved","The requested Madhoo [[{\"href\":\"/madhoo/viewmadhoo/13\",\"madhoo\":\"13\"}]] is approved to you successfully.","2014-02-17 23:21:30","2014-02-17 23:21:52");



DROP TABLE IF EXISTS insr_organizations;

CREATE TABLE `insr_organizations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('ORGANIZATION','GROUP') NOT NULL DEFAULT 'ORGANIZATION',
  `address` text NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_by` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`,`deleted_by`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `insr_organizations_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `insr_organizations_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO insr_organizations VALUES("7","Message of Peace","ORGANIZATION","Bangalore","Karnataka","India","4654165654","1","0","","2014-02-12 00:31:45","2014-02-12 00:31:45");



DROP TABLE IF EXISTS insr_request_management;

CREATE TABLE `insr_request_management` (
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
  KEY `responded_by` (`responded_by`),
  CONSTRAINT `insr_request_management_ibfk_1` FOREIGN KEY (`callee_id`) REFERENCES `insr_callees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `insr_request_management_ibfk_2` FOREIGN KEY (`caller_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `insr_request_management_ibfk_3` FOREIGN KEY (`owner_id`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `insr_request_management_ibfk_4` FOREIGN KEY (`requested_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `insr_request_management_ibfk_5` FOREIGN KEY (`responded_by`) REFERENCES `insr_callers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COMMENT='All assignment and approval request should have entry here';

INSERT INTO insr_request_management VALUES("14","13","13","","13","13","APPROVED","UNREAD","UNREAD","READ","0","2014-02-11 18:56:42","2014-02-11 18:56:42");
INSERT INTO insr_request_management VALUES("15","13","13","","15","13","APPROVED","READ","UNREAD","READ","0","2014-02-17 17:50:31","2014-02-17 17:51:30");



DROP TABLE IF EXISTS session_table;

CREATE TABLE `session_table` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO session_table VALUES("iqvhu538avu4n4di70ni4fvvm1","1392663171","03c34c52a2a70ecf69b4c5c311103c20userSessionTimeout|i:1392667881;03c34c52a2a70ecf69b4c5c311103c20__id|s:1:\"1\";03c34c52a2a70ecf69b4c5c311103c20__name|s:20:\"iansarmail@gmail.com\";03c34c52a2a70ecf69b4c5c311103c20role|s:11:\"super_admin\";03c34c52a2a70ecf69b4c5c311103c20email|s:20:\"iansarmail@gmail.com\";03c34c52a2a70ecf69b4c5c311103c20name|s:11:\"Super Admin\";03c34c52a2a70ecf69b4c5c311103c20can_invite|s:1:\"1\";03c34c52a2a70ecf69b4c5c311103c20profile_completed|s:1:\"1\";03c34c52a2a70ecf69b4c5c311103c20__states|a:5:{s:4:\"role\";b:1;s:5:\"email\";b:1;s:4:\"name\";b:1;s:10:\"can_invite\";b:1;s:17:\"profile_completed\";b:1;}");
INSERT INTO session_table VALUES("kuisb7r6karr88m0vhvsnhsu94","1392662110","03c34c52a2a70ecf69b4c5c311103c20Yii.CWebUser.flashcounters|a:0:{}");



