<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';
	require_once PHPROOT . '/db.php';
	require_once PHPROOT . '/renderer.php';
	require_once PHPROOT . '/authorized.php';

	if ($_SERVER['REQUEST_METHOD'] != 'POST') {

		$query_data = array_intersect_key($_GET, array_flip(['redirect_url']));

		$form_action = $_SERVER['PHP_SELF'] . '?' . http_build_query($query_data);
		$data = ['form_action' => $form_action];

		Renderer::render('login.phtml', $data, true); // with exit = true

	}

	function generate_token($length) {

		$token = openssl_random_pseudo_bytes($length / 2);
		return bin2hex($token);

	}

	function not_empty($var) {

		return !empty($var);

	}

	$check_list = array(

		'login' => array(
			array('validate' => 'not_empty', 'err_msg' => 'Login is required')
		),

		'password' => array(
			array('validate' => 'not_empty', 'err_msg' => 'Password is required')
		)

	);

	$valid_errors = array();
	foreach ($_POST as $data_key => $data_value) {
		foreach ($check_list[$data_key] as $check_key => $check_value) {
			if (!$check_value['validate']($data_value)) {
				array_push($valid_errors,
					array('prop' => $data_key, 'err_msg' => $check_value['err_msg']));

				break; // Only one error by prop
			}
		}
	}

	if (count($valid_errors)) {

		$data = $_POST + ['valid_errors' => $valid_errors];

		Renderer::render('login.phtml', $data, true);

	} else {

		$data = [
			'login' => $_POST['login'],
			'password_hash' => md5($_POST['password'])
		];

		$query_result =
			$link->query("
				SELECT id 
				FROM geom_users
				WHERE (
						email = '" . $data['login'] . "'
						OR
						login = '" . $data['login'] . "' ) AND
					password_hash = '" . $data['password_hash'] . "';");

		if ($query_result->num_rows == 0) {

			$valid_errors = [
				['err_msg' => 'Login or password is incorrect']
			];

			$data = $_POST + ['valid_errors' => $valid_errors];

			Renderer::render('login.phtml', $data, true);

		} else {

			$request_count = 0;
			$MAX_REQUEST_COUNT = 100;
			$user_id = $query_result->fetch_assoc()['id'];

			do { // insert user to session

				if (++$request_count >= $MAX_REQUEST_COUNT)
					die('number of requests to db has been exceeded');

				$user_token = generate_token(32);

				$query_result =
					$link->query("
						INSERT INTO geom_sessions
						(user_id, user_token)
						VALUES
						('" . $user_id . "', '" . $user_token . "');");

			} while(!$query_result);

			$expires = time() + 3600 * 24 * 31; // 31 days
			setcookie('ganymede_id', $user_id, $expires, '/');
			setcookie('ganymede_token', $user_token, $expires, '/');

			$redirect_url = isset($_GET['redirect_url']) ? $_GET['redirect_url'] : '/';

			header('Location: ' . $redirect_url);
			exit();

		}

	}

	if (check_auth()) {

		header('Location: /');
		exit();

	}

	Renderer::render('login.phtml', ['form_action' => $_SERVER['PHP_SELF']], true);

?>