<?php

	error_reporting(E_ALL);

	require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';
	
	require_once PHPROOT . '/db.php';
	require_once PHPROOT . '/renderer.php';
	require_once PHPROOT . '/user.php';

	if ($_SERVER['REQUEST_METHOD'] != 'POST') {

		Renderer::render('signup.phtml');
		exit();
		
	}

	/* SIGNUP */

	function not_empty($var) {

		return !empty($var);

	}

	function check_valid_email($email) {

		return preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i', $email, $matches);

	}

	$check_list = array(

		'email' => array(
			array('validate' => 'not_empty', 'err_msg' => 'Email is required'),
			array('validate' => 'check_valid_email', 'err_msg' => 'Not valid email')),

		'login' => array(
			array('validate' => 'not_empty', 'err_msg' => 'Login is required')),

		'password' => array(
			array('validate' => 'not_empty', 'err_msg' => 'Password is required'))

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

		Renderer::render('signup.phtml', $_POST + ['valid_errors' => $valid_errors]);
		exit();

	} else {

		$data = array(
			'email' => $_POST['email'],
			'login' => $_POST['login'],
			'password_hash' => md5($_POST['password'])
		);

		$spread_columns = implode(', ', array_keys($data));
		$spread_values = "'" . implode("', '", array_values($data)) . "'";

		{ // Check email
			$query_result =
				$link->query("
					SELECT COUNT(*) AS count
					FROM geom_users
					WHERE email = '" . $data['email'] . "';");

			if ((int) $query_result->fetch_assoc()['count']) {

				$valid_errors = [
					['prop' => 'email','err_msg' => 'User with <code>' . $data['email'] . '</code> email already exists']];

				Renderer::render('signup.phtml', $_POST + ['valid_errors' => $valid_errors]);
				exit();

			}
		}

		{ // Check login
			$query_result =
				$link->query("
					SELECT COUNT(*) AS count
					FROM geom_users
					WHERE login = '" . $data['login'] . "';");

			if ((int) $query_result->fetch_assoc()['count']) {

				$valid_errors = [
					['prop' => 'login','err_msg' => 'User with <code>' . $data['login'] . '</code> login already exists']];
					
				Renderer::render('signup.phtml', $_POST + ['valid_errors' => $valid_errors]);
				exit();

			}
		}

		{ // Insert user to db

			$mysqli_result =
				$link->query("
					INSERT INTO geom_users
					(" . $spread_columns . ")
					VALUES
					(" . $spread_values . ");");

			if ($mysqli_result)
			{

				$spread_data =
					implode(' AND ',
						array_map(function($key, $value) {

							return $key . " = '" . $value . "'";

						},array_keys($data), array_values($data))
					);

				$query_result = $link->query("
					SELECT id
					FROM geom_users
					WHERE
						" . $spread_data . ";
					");

				if ($query_result->num_rows) {

					$user_id = $query_result->fetch_assoc()["id"];

					User::init_user_folder($user_id);

				}

				header('Location: /login');
			}
			else
			{
				exit('mysql error');
			}

		}

	}

?>