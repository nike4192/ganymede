<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';

	require_once PHPROOT . '/db.php';
	require_once PHPROOT . '/authorized.php';

	$request_token = @$_GET['token'];
	$user_token = @$_COOKIE['ganymede_token'];

	if (check_auth() &&
		$request_token && $user_token &&
		$request_token == $user_token) {

		$user_id = $_COOKIE['ganymede_id'];

		$query_result = $link->query("
			DELETE FROM geom_sessions
			WHERE
				user_id = '" . $user_id . "' AND
				user_token = '" . $user_token . "';
			");

		if ($query_result) {

			setcookie('ganymede_id', null, -1, '/');
			setcookie('ganymede_token', null, -1, '/');

		} else {

			die('Не удалось выйти');

		}

	}

	$redirect_url = isset($_GET['redirect_url']) ? $_GET['redirect_url'] : $_SERVER[ 'HTTP_REFERER' ];

	header('Location: ' . $redirect_url);


?>