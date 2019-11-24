CREATE TABLE IF NOT EXISTS `lab_instrument_timesheet_type` (
  `id_lab_instrument_type` int(11) NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(30) NOT NULL,
  `language_label` varchar(255) NOT NULL,
  `order` SMALLINT,
  PRIMARY KEY (`id_lab_instrument_type`),
  KEY (`type`),
  KEY (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO lab_instrument_timesheet_type (`type`, language_label, `order`) VALUES 
('OTHER', 'instruments_timesheet_type_other_label', 0),
('TESTING', 'instruments_timesheet_type_testing_label', 10),
('MAINTENANCE', 'instruments_timesheet_type_maintenance_label', 20),
('DEMO', 'instruments_timesheet_type_demo_label', 30),
('PROJECT', 'instruments_timesheet_type_project_label', 40),
('TRAINING', 'instruments_timesheet_type_training_label', 50);