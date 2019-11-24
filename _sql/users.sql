--
-- Table structure for table `bitauth_assoc`
--

CREATE TABLE IF NOT EXISTS `user_group_assoc` (
  `assoc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`assoc_id`),
  KEY `user_id` (`user_id`,`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=UTF8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bitauth_assoc`
--

INSERT INTO `user_group_assoc` (`assoc_id`, `user_id`, `group_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bitauth_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(48) NOT NULL,
  `description` text NOT NULL,
  `roles` text NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=UTF8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bitauth_groups`
--

INSERT INTO `user_groups` (`group_id`, `name`, `description`, `roles`) VALUES
(1, 'Administrators', 'Administrators (Full Access)', 1),
(2, 'Users', 'Default User Group', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bitauth_logins`
--

CREATE TABLE IF NOT EXISTS `user_logins` (
  `login_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `time` datetime NOT NULL,
  `success` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`login_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bitauth_logins`
--


-- --------------------------------------------------------

--
-- Table structure for table `bitauth_userdata`
--

CREATE TABLE IF NOT EXISTS `user_data` (
  `userdata_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `preferred_lang` varchar(2) DEFAULT 'en',
  `email` varchar(254) NOT NULL,
  PRIMARY KEY (`userdata_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=UTF8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bitauth_userdata`
--

INSERT INTO `user_data` (`userdata_id`, `user_id`, `fullname`, `email`, preferred_lang) VALUES
(1, 1, 'Administrator', 'admin@admin.com', 'it');

-- --------------------------------------------------------

--
-- Table structure for table `bitauth_users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(60) NOT NULL,
  `password_last_set` datetime NOT NULL,
  `password_never_expires` tinyint(1) NOT NULL DEFAULT '0',
  `remember_me` varchar(40) NOT NULL,
  `activation_code` varchar(40) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `forgot_code` varchar(40) NOT NULL,
  `forgot_generated` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` datetime NOT NULL,
  `last_login_ip` int(10) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=UTF8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bitauth_users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `password_last_set`, `password_never_expires`, `remember_me`, `activation_code`, `active`, `forgot_code`, `forgot_generated`, `enabled`, `last_login`, `last_login_ip`) VALUES
(1, 'admin', '$2a$08$560JEYl2Np/7/6RLc/mq/ecnumuBXig3e.pHh1lnH1pgpk94sTZhu', now(), 0, '', '', 1, '', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0);
