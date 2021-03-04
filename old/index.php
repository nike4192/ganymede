<!DOCTYPE html>
<html>
<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';

?>
<head>
	<title>Ganymede</title>

	<link rel="stylesheet" type="text/css" href="/css/main.css">

	<style>

		.viewbox > main {
			display: flex;
			justify-content: center;
			align-items: center;
		}
		
		.nav-main-box {
			margin: 1em 0;
			width: 100%;
			min-height: 300px;
			display: grid;
			grid-template-areas: "a b c"
								 "d d c";
		}

		.nav-main-box > .main-item:nth-child( 1 ) { grid-area: a; background-position-y: 0%; }
		.nav-main-box > .main-item:nth-child( 2 ) { grid-area: b; background-position-y: 25%;  }
		.nav-main-box > .main-item:nth-child( 3 ) { grid-area: c; background-position-y: 50%;  }
		.nav-main-box > .main-item:nth-child( 4 ) { grid-area: d; background-position-y: 75%;  }

		.nav-main-box {
			grid-template-columns: repeat(3, 1fr);
			grid-template-rows: repeat(2, 1fr);
			grid-gap: 1em;
		}

		.nav-main-box > .main-item {
			position: relative;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			border: 4px solid #eee9cf;
			border-radius: 20px;
			background-image: linear-gradient( #ffff calc(50% + 1.2em), #fff0 150%), url( 'images/geometry formulas pattern.png');
			background-position-x: center;
			background-size: 600px;
			box-shadow: 0 0px 5px #0000;
			transition-duration: 300ms;
		}
		.nav-main-box > .main-item:hover {
			box-shadow: 0 10px 15px #0001;
		}
		.nav-main-box > .main-item > .item-image {
			position: absolute;
			top: calc(60% - 3em);
			height: 2em;
		}
		.nav-main-box > .main-item > .item-label {
			position: absolute;
			top: calc(60% - 0.6em);
			font-family: Montserrat;
			font-size: 1.2em;
			color: #000;
			text-transform: uppercase;
			font-weight: 600;
		}

	</style>
</head>
<body>
	<?php include(DOCROOT . '/templates/header.phtml')?>

	<div class="viewbox">	
		<main>
			<div class="nav-main-box">
				<a class="main-item" href="/theorems">
					<img class="item-image" src="/svg/041-radius.svg">
					<span class="item-label">Теоремы</span>
				</a>
				<a class="main-item" href="/definitions">
					<img class="item-image" src="/svg/008-trigonometry.svg">
					<span class="item-label">Определения</span>
				</a>
				<a class="main-item" href="/formulas">
					<img class="item-image" src="/svg/037-function.svg">
					<span class="item-label">Формулы</span>
				</a>
				<a class="main-item" href="/tests">
					<img class="item-image" src="/svg/002-document.svg">
					<span class="item-label">Тесты</span>
				</a>
			</div>
		</main>
	</div>
</body>
</html>