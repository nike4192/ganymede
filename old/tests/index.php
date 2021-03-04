<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';
require_once PHPROOT . '/authorized.php';
require_once PHPROOT . '/tests-module.php';
require_once PHPROOT . '/renderer.php';

if (isset($_GET['test_id'])) { // Show test

	$test = get_test($_GET['test_id']);
	
	if ($test) {

		Renderer::render('test.phtml', ['test' => $test], true);

	} else {

		exit('Test with ' . $_GET['test_id'] . ' id not found');

	}

}

if (isset($_GET['attempt_id'])) { // Show attempt

	if (!check_auth()) {

		exit('Проверка тестов только для авторизованных пользователей');

	}

	$attempt = get_attempt($_GET['attempt_id']);

	if (!$attempt || $attempt['user_id'] != $_COOKIE['ganymede_id']) {

		exit('Attempt id is incorrect');

	}

	$test = get_test($attempt['test_id']);
	
	if ($test) {

		$data = [
			'test' => $test,
			'attempt' => $attempt
		];

		Renderer::render('test.phtml', $data, true);

	} else {

		exit('Attempt with ' . $_GET['attempt_id'] . ' id not found');

	}


}

Renderer::render('tests-view.phtml');

?>