
START TRANSACTION;

SET NAMES utf8mb4;

CREATE TABLE `geom_tests` (
	`test_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`test_title` varchar(50) NOT NULL,
	`task_id_sequence` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `geom_tests`
(`test_title`, `task_id_sequence`)
VALUES
('Тест 1', '1-10'),
('Тест 2', '11-20'),
('Тест 3', '21-30'),
('Тест 4', '31-40'),
('Тест 5', '41-50'),
('Тест 6', '51-60'),
('Тест 7', '61-70'),
('Тест 8', '71-80'),
('Тест 9', '81-88');

COMMIT;