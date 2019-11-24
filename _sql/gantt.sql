CREATE TABLE IF NOT EXISTS `project_gantts` (
   `id_project_gantt` int(11) NOT NULL AUTO_INCREMENT,
   `id_project` int(11) NOT NULL,
   `name` varchar(255) NOT NULL,
   `type` TINYINT,
   PRIMARY KEY (`id_project_gantt`),
   KEY (`id_project`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `project_gantt_tasks` (
   `id_project_gantt_task` int(11) NOT NULL AUTO_INCREMENT,
   `id_project_gantt` int(11) NOT NULL,
   `name` varchar(255) NOT NULL,
   `code` varchar(20) NOT NULL,
   description TEXT,
   progress INT DEFAULT 0,
   `level` INT,
   status VARCHAR(20),
   `start` BIGINT,
   duration INT,
   `end` BIGINT,
   `actual_start_date` date DEFAULT NULL,
   `actual_end_date` date DEFAULT NULL,
   startIsMilestone TINYINT,
   endIsMilestone TINYINT,
   hasChild TINYINT,
   depends VARCHAR(255),
   collapsed TINYINT DEFAULT 0,
   deleted TINYINT DEFAULT 0,
   `order` INT,
   PRIMARY KEY (`id_project_gantt_task`),
   KEY (`id_project_gantt`),
   KEY (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `project_gantt_assignments` (
   id_project_gantt_assignment  int(11) NOT NULL AUTO_INCREMENT,
   id_project_gantt_task INT,
   id_resource INT,
   `id_project_gantt_role` INT,
   effort BIGINT,
   PRIMARY KEY (`id_project_gantt_assignment`),
   KEY (`id_project_gantt_task`),
   KEY (`id_resource`),
   KEY (`id_project_gantt_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `project_gantt_roles` (
  `id_project_gantt_role` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
   enabled TINYINT DEFAULT 1,
   PRIMARY KEY (id_project_gantt_role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `project_gantt_roles` (`name`, `enabled`) VALUES 
('Project Manager', '1'), 
('Worker', '1');
