CREATE TABLE IF NOT EXISTS `lab_instrument_type` (
  `id_lab_instrument_type` int(11) NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(30) NOT NULL,
  `language_label` varchar(255) NOT NULL,
  PRIMARY KEY (`id_lab_instrument_type`),
  KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO lab_instrument_type (`type`, language_label) VALUES 
('NONE', 'instruments_type_none', 0);
