<!DOCTYPE html>
<html lang="ru">
<?php
	require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';
?>
<head>
	<title>Ganymede</title>
	<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/css/index.css">
</head>
<body>
	<div class="page">
		<?php include(DOCROOT . '/templates/header.phtml')?>
		<div class="main">
			<a class="main__items main__item-1" href="#">
				<div class="main__item__top"></div>
				<div class="main__item__bottom">
					<h2>Чертеж</h2>
					<p>Нарисовать с помощью текста или редактора</p>
				</div>
			</a>
			<a class="main__items main__item-2" href="templates/definitions.phtml">
				<div class="main__item__top"></div>
				<div class="main__item__bottom">
					<h2>Определения</h2>
					<p>Аксиомы, теоремы и понятия с фигурами</p>
				</div>
			</a>
			<a class="main__items main__item-3" href="#">
				<div class="main__item__top"></div>
				<div class="main__item__bottom">
					<h2>Тесты</h2	>
					<p>Для проверки знаний</p>
				</div>
			</a>
		</div> 
		<?php include(DOCROOT . '/templates/footer.phtml')?>	
	</div>
</body>
</html>