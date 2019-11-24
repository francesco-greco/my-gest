CREATE TABLE IF NOT EXISTS `labs` (
  `id_lab` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` TEXT NOT NULL,
  `id_lab_chief` INT NOT NULL,
   PRIMARY KEY (id_lab),
   KEY (id_lab_chief)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `lab_instruments` (
  `id_lab_instrument` int(11) NOT NULL AUTO_INCREMENT,
  `instrument_name` varchar(150) NOT NULL,
  `description` TEXT NOT NULL,
  `id_lab` INT NOT NULL,
   PRIMARY KEY (id_lab_instrument),
   KEY (`name`),
   KEY (id_lab)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `lab_instrument_timesheets` (
  `id_lab_instrument_timesheet` int(11) NOT NULL AUTO_INCREMENT,
  `id_lab_instrument` int(11) NOT NULL,
   id_lab_task int(11),
  `type` varchar(30) NOT NULL,
  `start_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `duration` VARCHAR(20) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_lab_instrument_timesheet`),
  KEY (`id_lab_instrument`),
  KEY (`id_lab_task`),
  KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `lab_staff` (
  `id_lab_staff` int(11) NOT NULL AUTO_INCREMENT,
  `id_lab` INT NOT NULL,
  `id_user` INT NOT NULL,
  `role` varchar(100) NOT NULL,
   PRIMARY KEY (id_lab_staff),
   KEY (id_lab),
   KEY (id_user),
   KEY (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;