
START TRANSACTION;

SET NAMES utf8mb4;

CREATE TABLE geom_theorems (

	`theorem_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`theorem_title` varchar(200) NOT NULL,
	`theorem_image_src` varchar(200), 
	`theorem_content` text NOT NULL,
	`attributes` JSON

);

INSERT INTO geom_theorems
(`theorem_title`, `theorem_image_src`, `theorem_content`)
VALUES
('Теорема косинусов', 'Теорема косинусов.jpg', '\\begin{align} & \\text{Во всяком треугольнике квадрат одной из сторон равен сумме квадратов двух других}\\\\ & \\text{сторон минус удвоенное произведение этих сторон на косинус угла,}\\\\ & \\text{заключенного между ними}\\\\ & c^2=a^2+b^2-2ab \\cos{\\beta}\\\\ \\end{align}'), 
('Теорема синусов', 'Теорема синусов.jpg', '\\begin{align} & \\text{Во всяком треугольнике отношение любой стороны к синусу противолежащего ей угла}\\\\ & \\text{постоянно и равно диаметру описанной вокруг треугольника окружности.}\\\\ & \\frac{a}{\\sin{\\alpha}}=\\frac{b}{\\sin{\\beta}}=\\frac{c}{\\sin{\\gamma}}=2R\\\\ & \\angle{BAC}=\\alpha,\\ \\angle{ABC}=\\beta,\\ \\angle{ACB}=\\gamma,\\ R-радиус\\ описанной\\ окружности\\\\ \\end{align}'), 
('Теорема Пифагора', 'Теорема Пифагора.png', '\\begin{align} & \\text{В прямоугольном треугольнике сумма квадратов катетов (c и b) равна}\\\\ & \\text{квадрату гипотенузы(a)}\\\\ & \\ \\ a^2=c^2+b^2\\\\ \\end{align}');

COMMIT;