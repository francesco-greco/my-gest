BEGIN;

CREATE TABLE manage_send_email (
	id INT NOT NULL AUTO_INCREMENT,
	data_invio TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	email_from VARCHAR(50) NOT NULL,
	email_to VARCHAR(50) NOT NULL,
	esito VARCHAR(10) NOT NULL,
	tipo INT NOT NULL,
	PRIMARY KEY (id)
)COLLATE='utf8_general_ci';

INSERT INTO manage_send_email (email_from, email_to, esito, tipo) values ('test.test@test.it', 'ciccio.pasticcio@testing.it','ok',1);

COMMIT;