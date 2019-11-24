CREATE TABLE IF NOT EXISTS `attachments` (
  `id_attachment` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `upload_date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  share TINYINT DEFAULT 0,
  `id_current_attachment_version` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_attachment`),
  KEY `id_current_attachment_version` (`id_current_attachment_version`),
  KEY `upload_date` (`upload_date`),
  KEY (`type`),
  KEY (`category`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `attachment_category` (
  `id_attachment_category` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(30) NOT NULL,
  `types` varchar(255) NOT NULL,
  `language_label` varchar(255) NOT NULL,
  `order` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_attachment_category`),
  KEY `types` (`types`),
  KEY `order` (`order`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `attachment_type` (`id_attachment_type`, `filter`, `type`, `language_label`, `order`) VALUES
(1, 'INSTRUMENT', 'INSTRUCTION', 'instruments_attachment_type_instruction_label', 10),
(2, 'RESULT', 'INSTRUMENT', 'instruments_attachment_type_results_label', 20),
(3, 'OTHER', 'INSTRUMENT', 'instruments_attachment_type_other_label', 0);



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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `project_attachments_rel` (
  `id_project_attachment` int(11) NOT NULL AUTO_INCREMENT,
  `id_attachment` int(11) NOT NULL,
  `id_project` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_project_attachment`),
  UNIQUE KEY `id_attachment_2` (`id_attachment`,`id_project`),
  KEY `id_attachment` (`id_attachment`),
  KEY `id_project` (`id_project`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;