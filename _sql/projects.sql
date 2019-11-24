CREATE TABLE IF NOT EXISTS `projects` (
   `id_project` int(11) NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   `description` TEXT,
   `code` varchar(20) NOT NULL,
   `id_client` int(11) NOT NULL,
   `id_project_leader` int(11) NOT NULL,
   `start_date` DATE NULL,
   `end_date` DATE NULL,
   PRIMARY KEY (`id_project`),
   UNIQUE KEY (code),
   KEY (id_client),
   KEY (id_project_leader)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;