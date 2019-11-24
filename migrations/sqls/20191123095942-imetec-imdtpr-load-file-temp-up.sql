BEGIN;

CREATE TABLE `imetec_imdtpr_load_file_temp` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`codice_prodotto` VARCHAR(20) NOT NULL,
	`data_produzione` VARCHAR(10) NOT NULL,
	PRIMARY KEY (`id`)
)COLLATE='utf8_general_ci' ENGINE=InnoDB;

COMMIT;