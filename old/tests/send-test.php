<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';
require_once PHPROOT . '/check-test.php';
require_once PHPROOT . '/authorized.php';

function send_response($data) {

	switch (@$_GET['format_data']) {

		case 'json': default:

			exit(json_encode($data, JSON_UNESCAPED_UNICODE));

			break;
	}

}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

	$response = [
		'errno' => 1,
		'error_msg' => 'Поддерживается только метод POST'
	];

	send_response($response);

}

if (!check_auth()) {

	$response = [
		'errno' => 1,
		'error_msg' => 'Отправка тестов только для авторизованных пользователей'
	];

	send_response($response);

}

$attempt_data_pattern = (object) [
	'test_id' => 'string',
	'score' => 'int',
	'tasks' => [
		(object) [
			'task_id' => 'string',
			'score' => 'int',
			'errno' => 'int',
			'options' => [
				(object) [
					'option_index' => 'string',
					'is_right' => 'bool'
				]
			]
		]
	]
];

switch (@$_SERVER['CONTENT_TYPE']) {

	case 'application/json': default:

		$json = file_get_contents('php://input');

		if (!empty($json)) {

			$data = json_decode($json, true);
			$data = check_test($data, $data_pattern);

			if (!isset($data['errno']) || $data['errno'] == 0) {

				$result = insert_attempt_to_db($data);

				if (!$result) {

					$response = [
						'errno' => 1,
						'error_msg' => 'Неудалось внести тест в базу данных'
					];
					
					send_response($response);

				}

			}

			send_response($data);
		
		}

		break;

}

function insert_attempt_to_db($data) {

	global $link, $attempt_data_pattern;

	$user_id = $_COOKIE['ganymede_id'];
	$test_id = $data['test_id'];

	$send_data = cast_data($data, $attempt_data_pattern, true);

	$json_data = json_encode($send_data);

	$query = "
		INSERT INTO geom_user_tests
		(user_id, test_id, json_data)
		VALUES
		('" . $user_id . "', '" . $test_id . "', '" . $json_data . "')";

	$result = $link->query($query);

	return $result;

}


?>