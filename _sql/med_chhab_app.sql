-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generato il: Nov 15, 2015 alle 22:48
-- Versione del server: 5.5.27
-- Versione PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `med_chhab_app`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id_attachment` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(30) NOT NULL,
  `upload_date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `share` tinyint(4) NOT NULL DEFAULT '0',
  `id_current_attachment_version` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id_attachment`),
  KEY `id_current_attachment_version` (`id_current_attachment_version`),
  KEY `upload_date` (`upload_date`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dump dei dati per la tabella `attachments`
--

INSERT INTO `attachments` (`id_attachment`, `category`, `upload_date`, `description`, `filename`, `original_filename`, `share`, `id_current_attachment_version`, `id_user`, `type`) VALUES
(4, 'RESULT', '2015-06-27', 'Risultato processo di segmentazione', 'd:\\_upload_saemigest/instrument_attachments/144657335ded16a9185d0cbf0f414aef.pdf', 'Chiave_Firefox_Sync.pdf', 0, NULL, 1, 'INSTRUMENT'),
(5, 'RESULT', '2015-08-11', NULL, 'd:\\_upload_saemigest/instrument_attachments/de9d0aff67d5c60bf0e2c355f20e52ac.pdf', 'giri_armonici.pdf', 0, NULL, 1, 'INSTRUMENT'),
(12, 'INSTRUCTION', '2015-08-13', 'Istruzione per NEXUS', 'd:\\_upload_saemigest/instrument_attachments/86c2b27ae5440893c98406cb9f587834.pdf', 'BON_IT_ITA525665_1366058140162.pdf', 0, NULL, 1, 'INSTRUMENT'),
(13, 'RESULT', '2015-08-15', 'Elettrogrammometria differenziale', 'd:\\_upload_saemigest/instrument_attachments/bfd9a6cd54dd9a011ebb359afc6373ea.pdf', '11.Chart_flusso_AXA_richiesta_sopralluogo.pdf.pdf', 0, NULL, 1, 'INSTRUMENT'),
(14, 'RESULT', '2015-08-14', 'wrwer', 'd:\\_upload_saemigest/instrument_attachments/19a3b64c02efbef6537dd6b1b8e2685a.pdf', '12.Chart_flusso_AXA_richiesta_cantiere_posa.pdf.pdf', 0, NULL, 1, 'INSTRUMENT'),
(16, 'OTHER', '2015-09-20', 'Contratto del progetto', 'd:\\_upload_saemigest/project_attachments/d7c3c8373366cd60ad66173df5ec23a5.pdf', 'Chiave_Firefox_Sync.pdf', 1, NULL, 1, 'PROJECT'),
(17, 'OTHER', '2015-09-20', 'Contratto del progetto', 'd:\\_upload_saemigest/project_attachments/36d26e88640743ee28dacbd00b392959.pdf', 'Chiave_Firefox_Sync.pdf', 0, NULL, 1, 'PROJECT');

-- --------------------------------------------------------

--
-- Struttura della tabella `attachment_category`
--

CREATE TABLE IF NOT EXISTS `attachment_category` (
  `id_attachment_category` int(11) NOT NULL AUTO_INCREMENT,
  `types` varchar(30) NOT NULL,
  `category` varchar(255) NOT NULL,
  `language_label` varchar(255) NOT NULL,
  `order` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_attachment_category`),
  KEY `type` (`category`),
  KEY `order` (`order`),
  KEY `filter` (`types`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `attachment_category`
--

INSERT INTO `attachment_category` (`id_attachment_category`, `types`, `category`, `language_label`, `order`) VALUES
(1, 'INSTRUMENT', 'INSTRUCTION', 'instruments_attachment_type_instruction_label', 10),
(2, 'INSTRUMENT', 'RESULT', 'instruments_attachment_type_results_label', 20),
(3, 'INSTRUMENT|PROJECT', 'OTHER', 'instruments_attachment_type_other_label', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `prevent_update` int(11) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `prevent_update`, `last_activity`, `user_data`) VALUES
('27e15ad39ff8deaed648139f0ffec1f7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge', 0, 1447605106, 'a:21:{s:14:"prevent_update";i:0;s:9:"user_data";s:0:"";s:10:"ba_user_id";s:1:"1";s:11:"ba_username";s:5:"admin";s:20:"ba_password_last_set";s:19:"2014-09-02 23:40:52";s:25:"ba_password_never_expires";s:1:"0";s:14:"ba_remember_me";s:0:"";s:18:"ba_activation_code";s:0:"";s:9:"ba_active";s:1:"1";s:14:"ba_forgot_code";s:0:"";s:19:"ba_forgot_generated";s:19:"0000-00-00 00:00:00";s:10:"ba_enabled";s:1:"1";s:13:"ba_last_login";s:19:"2015-11-15 17:31:52";s:16:"ba_last_login_ip";s:7:"0.0.0.0";s:14:"ba_userdata_id";s:1:"1";s:11:"ba_fullname";s:13:"Administrator";s:8:"ba_email";s:26:"antonio.logrosso@gmail.com";s:17:"ba_preferred_lang";s:2:"it";s:9:"ba_groups";a:1:{i:0;s:1:"1";}s:8:"ba_roles";s:88:"VZWZp1aMdJYewcoIabXRf9nsyWxei+8TyDAVridE0hjGePds078zxlr1GY8Iyg7r+5tA8gwuAbMbEsf3r7phSw==";s:18:"controller_tracker";s:37:"a:2:{i:0;s:4:"main";i:1;s:5:"users";}";}'),
('7ea2261585ac10ee0907d00267a3871f', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:42.0) Gecko/20100101 Firefox/42.0', 0, 1447604699, 'a:21:{s:14:"prevent_update";i:0;s:9:"user_data";s:0:"";s:18:"controller_tracker";s:36:"a:2:{i:0;s:4:"main";i:1;s:4:"labs";}";s:10:"ba_user_id";s:1:"3";s:11:"ba_username";s:6:"gverdi";s:20:"ba_password_last_set";s:19:"2015-11-10 00:30:55";s:25:"ba_password_never_expires";s:1:"0";s:14:"ba_remember_me";s:0:"";s:18:"ba_activation_code";s:0:"";s:9:"ba_active";s:1:"1";s:14:"ba_forgot_code";s:0:"";s:19:"ba_forgot_generated";s:19:"0000-00-00 00:00:00";s:10:"ba_enabled";s:1:"1";s:13:"ba_last_login";s:19:"2015-11-15 17:25:49";s:16:"ba_last_login_ip";s:7:"0.0.0.0";s:14:"ba_userdata_id";s:1:"3";s:11:"ba_fullname";s:14:"Giuseppe Verdi";s:8:"ba_email";s:0:"";s:17:"ba_preferred_lang";s:2:"it";s:9:"ba_groups";a:1:{i:0;s:1:"3";}s:8:"ba_roles";s:88:"nczr3HTEcdV2pYRrOU86gUWls+ZoLQtBUub2J/OX6tddltaQz4U89FVGMTh7pENN4BXzpF+lMaMfuJTOsnC/1g==";}');

-- --------------------------------------------------------

--
-- Struttura della tabella `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `clients`
--

INSERT INTO `clients` (`user_id`, `username`, `password`, `password_last_set`, `password_never_expires`, `remember_me`, `activation_code`, `active`, `forgot_code`, `forgot_generated`, `enabled`, `last_login`, `last_login_ip`) VALUES
(1, 'resp_emirates', '', '0000-00-00 00:00:00', 0, '', '', 1, '', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0),
(2, 'alogrosso', '$2a$08$zu6K9dwKBkeXllITMPJM7Ogw3fcJAJ6y22P0aT1RO/WYyYi8ZqNx6', '0000-00-00 00:00:00', 0, '', '', 1, '', '0000-00-00 00:00:00', 1, '2014-12-15 13:46:44', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `client_data`
--

CREATE TABLE IF NOT EXISTS `client_data` (
  `userdata_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `ref_surname` varchar(40) NOT NULL,
  `ref_name` varchar(40) NOT NULL,
  `preferred_lang` varchar(2) DEFAULT 'en',
  `email` varchar(254) NOT NULL,
  PRIMARY KEY (`userdata_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `client_data`
--

INSERT INTO `client_data` (`userdata_id`, `user_id`, `fullname`, `ref_surname`, `ref_name`, `preferred_lang`, `email`) VALUES
(1, 1, 'Emirate Globals', 'Resp', '', 'en', 'resp@emitareglobals.it'),
(2, 2, 'LGS Consulting', 'Lo Grosso', 'Antonio', 'it', 'antonio.logrosso@gmail.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `client_groups`
--

CREATE TABLE IF NOT EXISTS `client_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(48) NOT NULL,
  `description` text NOT NULL,
  `roles` text NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `client_groups`
--

INSERT INTO `client_groups` (`group_id`, `name`, `description`, `roles`) VALUES
(1, 'main', '', '1');

-- --------------------------------------------------------

--
-- Struttura della tabella `client_group_assoc`
--

CREATE TABLE IF NOT EXISTS `client_group_assoc` (
  `assoc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`assoc_id`),
  KEY `user_id` (`user_id`,`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `client_group_assoc`
--

INSERT INTO `client_group_assoc` (`assoc_id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `client_logins`
--

CREATE TABLE IF NOT EXISTS `client_logins` (
  `login_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `time` datetime NOT NULL,
  `success` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`login_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dump dei dati per la tabella `client_logins`
--

INSERT INTO `client_logins` (`login_id`, `ip_address`, `user_id`, `time`, `success`) VALUES
(1, 0, 2, '2014-12-09 23:21:41', 1),
(2, 0, 2, '2014-12-10 23:23:58', 1),
(3, 0, 2, '2014-12-12 06:50:46', 1),
(4, 0, 2, '2014-12-13 09:46:49', 1),
(5, 0, 2, '2014-12-13 16:16:47', 1),
(6, 0, 2, '2014-12-14 08:11:02', 1),
(7, 0, 2, '2014-12-14 09:53:49', 0),
(8, 0, 2, '2014-12-14 09:54:00', 1),
(9, 0, 2, '2014-12-14 09:54:37', 0),
(10, 0, 0, '2014-12-14 09:54:48', 0),
(11, 0, 2, '2014-12-14 09:55:48', 1),
(12, 0, 2, '2014-12-14 14:59:30', 1),
(13, 0, 2, '2014-12-14 21:58:59', 1),
(14, 0, 2, '2014-12-14 23:25:20', 1),
(15, 0, 2, '2014-12-15 13:46:44', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `labs`
--

CREATE TABLE IF NOT EXISTS `labs` (
  `id_lab` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  `id_lab_chief` int(11) NOT NULL,
  PRIMARY KEY (`id_lab`),
  KEY `id_lab_chief` (`id_lab_chief`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `labs`
--

INSERT INTO `labs` (`id_lab`, `name`, `description`, `id_lab_chief`) VALUES
(1, 'Biosintesi', 'test 2', 2),
(2, 'NMR', '', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `lab_instruments`
--

CREATE TABLE IF NOT EXISTS `lab_instruments` (
  `id_lab_instrument` int(11) NOT NULL AUTO_INCREMENT,
  `instrument_name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'NONE',
  `rentable` tinyint(4) NOT NULL DEFAULT '0',
  `id_lab` int(11) NOT NULL,
  PRIMARY KEY (`id_lab_instrument`),
  KEY `name` (`instrument_name`),
  KEY `id_lab` (`id_lab`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `lab_instruments`
--

INSERT INTO `lab_instruments` (`id_lab_instrument`, `instrument_name`, `description`, `type`, `rentable`, `id_lab`) VALUES
(1, 'Sony Z3 Compact', 'Smartphone di ultima generazione compatto e potente', 'NONE', 0, 1),
(2, 'Google Nexus 5', 'Reference device for Google experience', 'NONE', 0, 1),
(3, 'LG G4', 'Smartphone con dorso in pelle', 'NONE', 0, 2),
(4, 'test strumentazione', '', 'NONE', 0, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `lab_instrument_attachments_rel`
--

CREATE TABLE IF NOT EXISTS `lab_instrument_attachments_rel` (
  `id_lab_instrument_attachment` int(11) NOT NULL AUTO_INCREMENT,
  `id_attachment` int(11) NOT NULL,
  `id_lab_task` int(11) DEFAULT NULL,
  `id_lab_instrument` int(11) NOT NULL,
  PRIMARY KEY (`id_lab_instrument_attachment`),
  UNIQUE KEY `id_attachment_2` (`id_attachment`,`id_lab_task`,`id_lab_instrument`),
  KEY `id_lab_task` (`id_lab_task`),
  KEY `id_lab_instrument` (`id_lab_instrument`),
  KEY `id_attachment` (`id_attachment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dump dei dati per la tabella `lab_instrument_attachments_rel`
--

INSERT INTO `lab_instrument_attachments_rel` (`id_lab_instrument_attachment`, `id_attachment`, `id_lab_task`, `id_lab_instrument`) VALUES
(4, 4, 3, 1),
(5, 5, 3, 2),
(6, 12, NULL, 2),
(7, 13, 4, 3),
(8, 14, 6, 3),
(9, 15, 3, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `lab_instrument_timesheets`
--

CREATE TABLE IF NOT EXISTS `lab_instrument_timesheets` (
  `id_lab_instrument_timesheet` int(11) NOT NULL AUTO_INCREMENT,
  `id_lab_instrument` int(11) NOT NULL,
  `id_lab_task` int(11) DEFAULT NULL,
  `type` varchar(30) CHARACTER SET latin1 NOT NULL,
  `start_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `duration` varchar(30) CHARACTER SET latin1 NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_lab_instrument_timesheet`),
  KEY `id_lab_instrument` (`id_lab_instrument`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dump dei dati per la tabella `lab_instrument_timesheets`
--

INSERT INTO `lab_instrument_timesheets` (`id_lab_instrument_timesheet`, `id_lab_instrument`, `id_lab_task`, `type`, `start_timestamp`, `end_timestamp`, `duration`, `id_user`) VALUES
(1, 1, NULL, 'OTHER', '2015-06-06 22:04:00', '2015-06-07 11:21:00', '13:17', 2),
(3, 1, 3, 'PROJECT', '2015-06-07 20:27:00', '2015-06-07 20:37:00', '0:10', 2),
(4, 1, NULL, 'TESTING', '2015-06-07 18:30:00', '2015-06-07 20:34:00', '2:04', 2),
(5, 1, NULL, 'OTHER', '2015-06-10 04:00:00', '2015-06-10 10:07:00', '6:07', 2),
(6, 2, 3, 'PROJECT', '2015-08-11 10:27:00', '2015-08-11 17:27:00', '7:00', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `lab_instrument_timesheet_type`
--

CREATE TABLE IF NOT EXISTS `lab_instrument_timesheet_type` (
  `id_lab_instrument_type` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `language_label` varchar(255) NOT NULL,
  `order` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_lab_instrument_type`),
  KEY `type` (`type`),
  KEY `order` (`order`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dump dei dati per la tabella `lab_instrument_timesheet_type`
--

INSERT INTO `lab_instrument_timesheet_type` (`id_lab_instrument_type`, `type`, `language_label`, `order`) VALUES
(1, 'OTHER', 'instruments_timesheet_type_other_label', 0),
(2, 'TESTING', 'instruments_timesheet_type_testing_label', 10),
(3, 'MAINTENANCE', 'instruments_timesheet_type_maintenance_label', 20),
(4, 'DEMO', 'instruments_timesheet_type_demo_label', 30),
(5, 'PROJECT', 'instruments_timesheet_type_project_label', 40),
(6, 'TRAINING', 'instruments_timesheet_type_training_label', 50);

-- --------------------------------------------------------

--
-- Struttura della tabella `lab_instrument_type`
--

CREATE TABLE IF NOT EXISTS `lab_instrument_type` (
  `id_lab_instrument_type` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `language_label` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id_lab_instrument_type`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `lab_instrument_type`
--

INSERT INTO `lab_instrument_type` (`id_lab_instrument_type`, `type`, `language_label`, `order`) VALUES
(1, 'NONE', 'instruments_type_none', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `lab_staff`
--

CREATE TABLE IF NOT EXISTS `lab_staff` (
  `id_lab_staff` int(11) NOT NULL AUTO_INCREMENT,
  `id_lab` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  PRIMARY KEY (`id_lab_staff`),
  KEY `id_lab` (`id_lab`),
  KEY `id_user` (`id_user`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `lab_staff`
--

INSERT INTO `lab_staff` (`id_lab_staff`, `id_lab`, `id_user`, `role`) VALUES
(1, 1, 2, 'Operatore'),
(3, 2, 3, 'Ruolo 3');

-- --------------------------------------------------------

--
-- Struttura della tabella `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id_project` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `id_client` int(11) NOT NULL,
  `id_project_leader` int(11) NOT NULL,
  PRIMARY KEY (`id_project`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dump dei dati per la tabella `projects`
--

INSERT INTO `projects` (`id_project`, `name`, `code`, `description`, `start_date`, `end_date`, `id_client`, `id_project_leader`) VALUES
(9, 'Project Genesis', 'PRJGEN', '', NULL, NULL, 2, 1),
(10, 'Project Frontier', 'FRNT', 'test', '2015-08-30', '2015-11-27', 1, 2),
(11, 'Project Accessibility', 'ACC', '', NULL, NULL, 2, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `project_attachments_rel`
--

CREATE TABLE IF NOT EXISTS `project_attachments_rel` (
  `id_project_attachment` int(11) NOT NULL AUTO_INCREMENT,
  `id_attachment` int(11) NOT NULL,
  `id_project` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_project_attachment`),
  UNIQUE KEY `id_attachment_2` (`id_attachment`,`id_project`),
  KEY `id_attachment` (`id_attachment`),
  KEY `id_project` (`id_project`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `project_attachments_rel`
--

INSERT INTO `project_attachments_rel` (`id_project_attachment`, `id_attachment`, `id_project`) VALUES
(1, 16, 10),
(2, 17, 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `project_gantts`
--

CREATE TABLE IF NOT EXISTS `project_gantts` (
  `id_project_gantt` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_project_gantt`),
  KEY `id_project` (`id_project`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dump dei dati per la tabella `project_gantts`
--

INSERT INTO `project_gantts` (`id_project_gantt`, `id_project`, `name`, `type`) VALUES
(1, 9, '', 10),
(2, 9, '', 20),
(3, 10, '', 10),
(4, 10, '', 20),
(5, 11, '', 10),
(6, 11, '', 20);

-- --------------------------------------------------------

--
-- Struttura della tabella `project_gantt_assignments`
--

CREATE TABLE IF NOT EXISTS `project_gantt_assignments` (
  `id_project_gantt_assignment` int(11) NOT NULL AUTO_INCREMENT,
  `id_project_gantt_task` int(11) DEFAULT NULL,
  `id_resource` int(11) DEFAULT NULL,
  `id_project_gantt_role` int(11) DEFAULT NULL,
  `effort` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_project_gantt_assignment`),
  KEY `id_project_gantt` (`id_project_gantt_task`),
  KEY `id_resource` (`id_resource`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dump dei dati per la tabella `project_gantt_assignments`
--

INSERT INTO `project_gantt_assignments` (`id_project_gantt_assignment`, `id_project_gantt_task`, `id_resource`, `id_project_gantt_role`, `effort`) VALUES
(1, 3, 1, 1, 0),
(2, 4, 2, 1, 10800000),
(3, 6, 2, 1, 0),
(4, 8, 2, 1, 0),
(6, 9, 2, 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `project_gantt_roles`
--

CREATE TABLE IF NOT EXISTS `project_gantt_roles` (
  `id_project_gantt_role` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `enabled` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id_project_gantt_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `project_gantt_roles`
--

INSERT INTO `project_gantt_roles` (`id_project_gantt_role`, `name`, `enabled`) VALUES
(1, 'Project Manager', 1),
(2, 'Worker', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `project_gantt_tasks`
--

CREATE TABLE IF NOT EXISTS `project_gantt_tasks` (
  `id_project_gantt_task` int(11) NOT NULL AUTO_INCREMENT,
  `id_project_gantt` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text,
  `progress` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `start` bigint(20) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `end` bigint(20) DEFAULT NULL,
  `actual_start_date` date DEFAULT NULL,
  `actual_end_date` date DEFAULT NULL,
  `startIsMilestone` tinyint(4) DEFAULT NULL,
  `endIsMilestone` tinyint(4) DEFAULT NULL,
  `hasChild` tinyint(4) DEFAULT NULL,
  `depends` varchar(255) DEFAULT NULL,
  `collapsed` tinyint(4) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) DEFAULT '0',
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_project_gantt_task`),
  KEY `id_project` (`id_project_gantt`),
  KEY `order` (`order`),
  KEY `actual_start_date` (`actual_start_date`,`actual_end_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dump dei dati per la tabella `project_gantt_tasks`
--

INSERT INTO `project_gantt_tasks` (`id_project_gantt_task`, `id_project_gantt`, `name`, `code`, `description`, `progress`, `level`, `status`, `start`, `duration`, `end`, `actual_start_date`, `actual_end_date`, `startIsMilestone`, `endIsMilestone`, `hasChild`, `depends`, `collapsed`, `deleted`, `order`) VALUES
(2, 1, 'Task 1', 't1', NULL, 0, 0, 'STATUS_ACTIVE', 1420585200000, 8, 1421449199999, NULL, NULL, 0, 0, 1, NULL, 0, 0, 0),
(3, 1, 'Task 2', 't2', NULL, 59, 1, 'STATUS_ACTIVE', 1420671600000, 4, 1421189999999, '2015-08-31', '2015-12-23', 0, 0, 0, NULL, 0, 0, 1),
(4, 1, 'Task 3', 'TSK3', 'Elettrogrammometria differenziale', 0, 1, 'STATUS_ACTIVE', 1420585200000, 1, 1420671599999, NULL, NULL, 0, 0, 0, NULL, 0, 0, 2),
(5, 3, 'Project Frontier', '', NULL, 0, 0, 'STATUS_ACTIVE', 1439762400000, 4, 1440107999999, NULL, NULL, 0, 0, 1, NULL, 0, 0, 0),
(6, 3, 'Task FRNT 1', 'FRNT1', 'Test', 50, 1, 'STATUS_ACTIVE', 1439762400000, 4, 1440107999999, NULL, NULL, 0, 0, 0, NULL, 0, 0, 1),
(7, 5, 'Main task', '', NULL, 0, 0, 'STATUS_ACTIVE', 1443996000000, 3, 1444255199999, NULL, NULL, 0, 0, 1, NULL, 0, 0, 0),
(8, 5, 'First sub task', '', NULL, 0, 1, 'STATUS_ACTIVE', 1443996000000, 3, 1444255199999, NULL, NULL, 0, 0, 0, NULL, 0, 0, 1),
(9, 5, 'Task 3', '', NULL, 0, 1, 'STATUS_ACTIVE', 1443996000000, 1, 1444082399999, NULL, NULL, 0, 0, 0, NULL, 0, 0, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `password_last_set`, `password_never_expires`, `remember_me`, `activation_code`, `active`, `forgot_code`, `forgot_generated`, `enabled`, `last_login`, `last_login_ip`) VALUES
(1, 'admin', '$2a$08$560JEYl2Np/7/6RLc/mq/ecnumuBXig3e.pHh1lnH1pgpk94sTZhu', '2014-09-02 23:40:52', 0, '', '', 1, '', '0000-00-00 00:00:00', 1, '2015-11-15 17:31:52', 0),
(2, 'mrossi', '$2a$08$rShiBXdt83f4M5FWCdAONeZzj.D3VJ1lrDEUQCbwch/.BQljreJZW', '2015-11-09 23:57:21', 0, '', '', 1, '', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0),
(3, 'gverdi', '$2a$08$tEDKHjEoXkfW1L7qGsj4ceAT0lsnpkVti9JMMZCIhwZv99SGt8jHu', '2015-11-10 00:30:55', 0, '', '', 1, '', '0000-00-00 00:00:00', 1, '2015-11-15 17:25:49', 0),
(4, 'fgialli', '$2a$08$T9gnweqUKNxiUstq7lmSWuUdycZLXIil60McwZKH03pQUfg/YBNei', '2015-11-15 17:06:30', 0, '', '', 1, '', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `user_data`
--

CREATE TABLE IF NOT EXISTS `user_data` (
  `userdata_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `email` varchar(254) NOT NULL,
  `preferred_lang` varchar(2) NOT NULL DEFAULT 'en',
  PRIMARY KEY (`userdata_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `user_data`
--

INSERT INTO `user_data` (`userdata_id`, `user_id`, `fullname`, `email`, `preferred_lang`) VALUES
(1, 1, 'Administrator', 'antonio.logrosso@gmail.com', 'it'),
(2, 2, 'Mario Rossi', '', 'it'),
(3, 3, 'Giuseppe Verdi', '', 'it'),
(4, 4, 'Francesco Gialli', '', 'it');

-- --------------------------------------------------------

--
-- Struttura della tabella `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(48) NOT NULL,
  `description` text NOT NULL,
  `roles` text NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `user_groups`
--

INSERT INTO `user_groups` (`group_id`, `name`, `description`, `roles`) VALUES
(1, 'Administrators', 'Administrators (Full Access)', '1'),
(2, 'Users', 'Default User Group', '0'),
(3, 'Operatore di laboratorio', 'Operatore di laboratorio', '110000'),
(4, 'Resp. laboratorio', 'Aggiunge nuove strumentazioni, definisce lo staff e gestisce lo stato di avanzamento delle attività', '1100000'),
(5, 'Resp. Progetto', 'Questo gruppo di utenti si occupa della supervisione di un progetto tramite il Gantt associato', '1000');

-- --------------------------------------------------------

--
-- Struttura della tabella `user_group_assoc`
--

CREATE TABLE IF NOT EXISTS `user_group_assoc` (
  `assoc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`assoc_id`),
  KEY `user_id` (`user_id`,`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dump dei dati per la tabella `user_group_assoc`
--

INSERT INTO `user_group_assoc` (`assoc_id`, `user_id`, `group_id`) VALUES
(10, 1, 1),
(17, 2, 4),
(18, 3, 3),
(19, 4, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `user_logins`
--

CREATE TABLE IF NOT EXISTS `user_logins` (
  `login_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `time` datetime NOT NULL,
  `success` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`login_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=154 ;

--
-- Dump dei dati per la tabella `user_logins`
--

INSERT INTO `user_logins` (`login_id`, `ip_address`, `user_id`, `time`, `success`) VALUES
(1, 0, 1, '2014-09-02 23:52:45', 1),
(2, 0, 1, '2014-09-02 23:52:55', 0),
(3, 0, 1, '2014-09-03 23:14:35', 1),
(4, 0, 1, '2014-09-03 23:17:02', 1),
(5, 0, 1, '2014-09-03 23:18:36', 1),
(6, 0, 1, '2014-09-03 23:20:31', 1),
(7, 0, 1, '2014-09-03 23:47:43', 1),
(8, 0, 1, '2014-09-04 22:25:32', 1),
(9, 0, 1, '2014-09-07 14:45:36', 1),
(10, 0, 1, '2014-09-07 21:48:36', 1),
(11, 0, 1, '2014-09-07 21:52:40', 1),
(12, 0, 1, '2014-09-07 22:23:45', 1),
(13, 0, 1, '2014-09-07 22:24:54', 1),
(14, 0, 1, '2014-09-09 06:41:54', 1),
(15, 0, 1, '2014-09-09 19:04:03', 1),
(16, 0, 1, '2014-09-11 22:22:30', 1),
(17, 0, 1, '2014-09-14 09:35:07', 1),
(18, 0, 1, '2014-09-14 15:33:07', 1),
(19, 0, 1, '2014-09-18 23:21:50', 1),
(20, 0, 1, '2014-09-18 23:22:14', 1),
(21, 0, 1, '2014-09-18 23:23:06', 1),
(22, 0, 1, '2014-09-19 21:48:53', 1),
(23, 0, 1, '2014-09-20 16:43:16', 1),
(24, 0, 1, '2014-09-20 22:08:49', 1),
(25, 0, 1, '2014-09-21 09:35:01', 1),
(26, 0, 1, '2014-10-05 18:56:25', 1),
(27, 0, 1, '2014-10-05 22:07:52', 1),
(28, 0, 1, '2014-10-06 22:31:54', 1),
(29, 0, 1, '2014-10-07 20:03:19', 1),
(30, 0, 1, '2014-10-09 06:36:27', 1),
(31, 0, 1, '2014-10-09 06:46:21', 1),
(32, 0, 1, '2014-10-09 18:30:22', 1),
(33, 0, 1, '2014-11-22 10:39:57', 0),
(34, 0, 1, '2014-11-22 10:39:59', 0),
(35, 0, 1, '2014-11-22 10:40:03', 0),
(36, 0, 1, '2014-11-22 10:57:50', 1),
(37, 0, 1, '2014-11-23 18:50:01', 1),
(38, 0, 1, '2014-11-23 22:43:45', 1),
(39, 0, 1, '2014-11-24 22:26:36', 1),
(40, 0, 1, '2014-11-24 22:26:38', 1),
(41, 0, 1, '2014-11-29 10:15:06', 1),
(42, 0, 1, '2014-11-29 10:15:07', 1),
(43, 0, 1, '2014-11-29 22:16:24', 1),
(44, 0, 1, '2014-11-30 16:47:35', 1),
(45, 0, 1, '2014-11-30 21:19:00', 1),
(46, 0, 1, '2014-12-06 10:22:48', 1),
(47, 0, 1, '2014-12-09 21:24:28', 0),
(48, 0, 1, '2014-12-09 21:24:49', 0),
(49, 0, 1, '2014-12-09 21:26:21', 0),
(50, 0, 1, '2014-12-09 21:28:45', 1),
(51, 0, 1, '2014-12-09 23:13:08', 1),
(52, 0, 1, '2014-12-09 23:16:58', 1),
(53, 0, 1, '2014-12-10 23:24:31', 1),
(54, 0, 1, '2014-12-15 07:42:38', 1),
(55, 0, 1, '2014-12-15 13:31:29', 1),
(56, 0, 1, '2014-12-30 06:51:52', 1),
(57, 0, 1, '2015-01-05 23:54:01', 1),
(58, 0, 1, '2015-01-06 12:10:36', 1),
(59, 0, 1, '2015-01-06 23:20:55', 1),
(60, 0, 1, '2015-01-07 22:43:53', 1),
(61, 0, 1, '2015-01-08 22:31:49', 1),
(62, 0, 1, '2015-01-13 22:29:36', 1),
(63, 0, 1, '2015-01-15 22:42:01', 1),
(64, 0, 1, '2015-01-24 18:59:46', 1),
(65, 0, 1, '2015-01-24 23:09:26', 1),
(66, 0, 1, '2015-01-25 12:05:58', 1),
(67, 0, 1, '2015-01-25 15:58:42', 1),
(68, 0, 1, '2015-01-25 22:29:03', 1),
(69, 0, 1, '2015-02-08 11:27:06', 1),
(70, 0, 1, '2015-02-08 11:27:06', 1),
(71, 0, 1, '2015-02-08 15:31:05', 1),
(72, 0, 1, '2015-02-09 22:51:00', 1),
(73, 0, 1, '2015-02-10 23:25:44', 1),
(74, 0, 1, '2015-02-14 17:25:33', 1),
(75, 0, 1, '2015-02-15 11:04:22', 1),
(76, 0, 1, '2015-03-01 21:40:34', 1),
(77, 0, 1, '2015-03-08 17:41:26', 1),
(78, 0, 1, '2015-03-08 22:46:34', 1),
(79, 0, 1, '2015-03-09 23:01:59', 1),
(80, 0, 1, '2015-05-17 22:26:37', 1),
(81, 0, 1, '2015-06-02 13:41:47', 1),
(82, 0, 1, '2015-06-02 15:24:04', 1),
(83, 2130706433, 1, '2015-06-02 22:02:18', 1),
(84, 2130706433, 1, '2015-06-02 22:02:20', 1),
(85, 0, 1, '2015-06-03 22:11:50', 1),
(86, 0, 1, '2015-06-04 23:08:11', 1),
(87, 0, 1, '2015-06-07 14:50:46', 1),
(88, 0, 1, '2015-06-07 20:20:18', 1),
(89, 0, 1, '2015-06-08 23:30:44', 1),
(90, 0, 1, '2015-06-08 23:30:46', 1),
(91, 0, 1, '2015-06-10 21:55:17', 1),
(92, 0, 1, '2015-06-10 21:55:19', 1),
(93, 0, 1, '2015-06-13 18:05:28', 1),
(94, 0, 1, '2015-06-13 18:07:50', 1),
(95, 0, 1, '2015-06-21 08:42:24', 1),
(96, 0, 1, '2015-06-21 16:47:31', 1),
(97, 0, 1, '2015-06-21 19:15:24', 1),
(98, 0, 1, '2015-06-21 23:04:16', 1),
(99, 0, 1, '2015-06-22 23:39:09', 1),
(100, 2130706433, 1, '2015-06-23 22:23:41', 1),
(101, 0, 1, '2015-06-27 17:18:09', 1),
(102, 0, 1, '2015-06-27 17:48:21', 1),
(103, 0, 1, '2015-06-27 20:41:11', 1),
(104, 0, 1, '2015-06-27 20:41:12', 1),
(105, 0, 1, '2015-06-27 23:55:13', 1),
(106, 0, 1, '2015-07-19 17:45:01', 1),
(107, 0, 1, '2015-08-11 11:06:11', 1),
(108, 0, 1, '2015-08-11 22:04:21', 1),
(109, 2130706433, 1, '2015-08-12 15:45:48', 1),
(110, 0, 1, '2015-08-13 11:55:05', 1),
(111, 0, 1, '2015-08-13 16:22:08', 1),
(112, 0, 1, '2015-08-13 17:26:32', 1),
(113, 0, 1, '2015-08-15 09:55:40', 1),
(114, 0, 1, '2015-08-15 16:24:33', 1),
(115, 0, 1, '2015-08-15 20:12:44', 1),
(116, 0, 1, '2015-08-15 22:38:00', 1),
(117, 0, 1, '2015-08-16 19:03:32', 1),
(118, 0, 1, '2015-08-16 22:31:29', 1),
(119, 0, 1, '2015-08-22 16:56:50', 1),
(120, 0, 1, '2015-08-23 12:12:59', 1),
(121, 0, 1, '2015-08-23 15:50:52', 1),
(122, 0, 1, '2015-08-30 11:58:56', 1),
(123, 0, 1, '2015-08-30 15:54:07', 1),
(124, 0, 1, '2015-08-30 19:26:53', 1),
(125, 0, 1, '2015-08-30 22:20:34', 1),
(126, 2130706433, 1, '2015-08-31 22:21:39', 1),
(127, 0, 1, '2015-09-07 19:28:20', 1),
(128, 0, 1, '2015-09-08 22:14:27', 1),
(129, 0, 1, '2015-09-12 10:18:40', 1),
(130, 0, 1, '2015-09-12 22:59:26', 1),
(131, 0, 1, '2015-09-13 10:55:49', 1),
(132, 0, 1, '2015-09-14 22:16:26', 1),
(133, 0, 1, '2015-09-20 16:11:26', 1),
(134, 0, 1, '2015-09-21 22:24:14', 1),
(135, 0, 1, '2015-09-27 18:40:34', 1),
(136, 0, 1, '2015-09-27 18:59:21', 1),
(137, 0, 1, '2015-09-29 00:33:15', 1),
(138, 0, 1, '2015-10-04 15:25:41', 1),
(139, 0, 1, '2015-10-04 23:50:10', 1),
(140, 0, 1, '2015-10-18 17:47:43', 1),
(141, 0, 1, '2015-10-18 19:28:03', 1),
(142, 0, 1, '2015-10-18 22:32:40', 1),
(143, 0, 1, '2015-11-09 23:25:00', 1),
(144, 0, 3, '2015-11-10 00:30:17', 0),
(145, 0, 1, '2015-11-10 00:30:34', 1),
(146, 0, 3, '2015-11-10 00:31:14', 1),
(147, 0, 1, '2015-11-10 00:40:21', 1),
(148, 0, 1, '2015-11-15 16:03:48', 1),
(149, 0, 3, '2015-11-15 17:10:58', 1),
(150, 0, 3, '2015-11-15 17:11:22', 1),
(151, 0, 1, '2015-11-15 17:11:47', 1),
(152, 0, 3, '2015-11-15 17:25:49', 1),
(153, 0, 1, '2015-11-15 17:31:52', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
