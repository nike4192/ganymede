<?php

require_once 'db.php';
require_once 'authorized.php';
require_once 'js-lib.php';
require_once 'tests-module.php';

if (!check_auth()) {

	$response = [
		'errno' => 1,
		'error_msg' => 'Проверка тестов только для авторизованных пользователей'
	];

	exit(json_encode($response));

}

// cast to object for associative array or object in json

$data_pattern = (object) [
	'test_id' => 'string',
	'tasks' => [

		(object) [
			'task_id' => 'string',
			'option_indexes' => ['string'] // to options in check_task
		]
		
	]
];

function check_test($data, $data_pattern) {

	$data = cast_data($data, $data_pattern); // In tests-module.php
	$data = handle_data($data);

	return $data;

}

function check_task($check_task, $answer_task) {

	global $task_option_msg_map;


	$check_indexes = $check_task['option_indexes'];
	$answer_indexes = $answer_task['answer_indexes'];

	$errno;
	$score;

	$options = [];

	if (count($check_indexes)) { // has answers by user

		$right_checks_count = 0;
		$wrong_checks_count = 0;

		foreach ($check_indexes as $check_index) {

			$right_flag = false;
			
			foreach ($answer_indexes as $answer_index) {

				if ($check_index == $answer_index) {

					$right_flag = true;
					$right_checks_count++;
					break;

				}

			}

			if (!$right_flag) {

				$wrong_checks_count++;

			}

			array_push($options, [

				'option_index' => $check_index,
				'is_right' => $right_flag

			] );

		}

		$answers_count = count($answer_indexes);
		$multiple_answers = $answers_count > 1;

		if (count($check_indexes) == $answers_count) { // is right

			$errno = 0;

			$score = 1;

		} elseif ($right_checks_count && $multiple_answers) { // partially true

			$errno = 2;

			$checks_count = $right_checks_count - $wrong_checks_count;
			$checks_count = max($checks_count, 0);

			$score = $checks_count / $answers_count;

		} else { // wrong
			
			$errno = 1;

			$score = 0;

		}

	} else { // no answers by user

		$errno = 3;

		$score = 0;

	}

	return $check_task + [
		'options' => $options,
		'score' => $score,
		'errno' => $errno,
		'msg' => $task_option_msg_map[$errno]
	];

}

function handle_data($data) {

	global $link, $task_option_msg_map;

	$test_id = $data['test_id'];
	$test_data = get_test($test_id, true); // with answers

	if (!$test_data) {

		return ['errno' => 1, 'error_msg' => 'Не удалось найти тест'];

	}

	$score = 0;

	foreach ($data['tasks'] as $task_key => &$check_task) {

		foreach ($test_data['tasks'] as $answer_task) {

			if ($check_task['task_id'] == $answer_task['task_id']) {

				$check_task = check_task($check_task, $answer_task);

				$score += $check_task['score'];

				break;

			}

		}

	}

	$data['score'] = $score * 100 / count($data['tasks']);

	return $data;

}

?>