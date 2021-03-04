
START TRANSACTION;

SET NAMES utf8mb4;

CREATE TABLE geom_user_tests (

	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`user_id` varchar(40) NOT NULL,
	`test_id` int NOT NULL,
	`json_data` JSON NOT NULL,
	`datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP()

);

COMMIT;