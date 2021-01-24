<?php

require_once 'db.php';

$GLOBALS['task_option_msg_map'] = [

	0 => 'Верно',
	1 => 'Неверно',
	2 => 'Частично верно',
	3 => 'Пустой ответ'
	
];

function get_test($test_id, $with_answers = false) {

	global $link;

	$query = "
		SELECT *
		FROM geom_tests
		WHERE test_id = '" . $test_id . "';";

	if ($result = $link->query($query)) {

		$row = $result->fetch_assoc();
		return parse_test_data($row, $with_answers);
	}

	return false;

}

function cast_data($data, $data_pattern, $strict = false) { // strict - removes properties that are not in data_pattern

	switch (gettype($data_pattern)) {

		case 'object':

			if ($strict) {

				$data = array_intersect_key($data, (array) $data_pattern);

			}

			foreach ($data_pattern as $skey => $svalue) {

				$data[$skey] = cast_data($data[$skey], $svalue, $strict);

			}

			return $data;


		case 'array':

			if (count($data_pattern) > 1)
				die('there should be no enumeration in the data structure');
			
			foreach ($data_pattern as $skey => $svalue) {

				foreach ($data as $dkey => $dvalue) {

					$data[$dkey] = cast_data($dvalue, $svalue, $strict);

				}

			}

			return $data;

		case 'string':

			if (is_callable($data_pattern)) {

				return $data_pattern($data);

			}
		
		default:

			settype($data, $data_pattern);

			return $data;
	}

}


function check_in_sequence($value, $seq_string) {

	$seq_string = str_replace(' ', '', $seq_string); // remove spaces
	$sequences = explode(',', $seq_string);

	foreach ($sequences as $sequence) {

		$pos = strpos($sequence, '-');

		if ($pos !== false) {

			$a = (float) substr($value, 0, $pos);
			$b = (float) substr($value, $pos + 1);

			if ($value >= $a &&
				$value <= $b) return true;

		}

		if ($sequence == $value) return true;
	}

	return false;

}

function sequence_to_sql_cond($column_name, $seq_string) { // 1-2,3

	$seq_string = str_replace(' ', '', $seq_string); // remove spaces
	$sequences = explode(',', $seq_string);

	$sequences = array_map(function($value) use($column_name) {

		$pos = strpos($value, '-');

		if ($pos !== false) {

			$a = substr($value, 0, $pos);
			$b = substr($value, $pos + 1);

			return "(`" . $column_name . "` BETWEEN '" . $a . "' AND '" . $b . "')";

		}

		return "(`" . $column_name . "` = '" . $value . "')";

	}, $sequences);

	return implode(' OR ', $sequences);

}

function get_attempt($attempt_id, $associative = true) {

	global $link;

	$query = "
		SELECT *
		FROM geom_user_tests
		WHERE id = '" . $attempt_id . "';";

	if (($result = $link->query($query)) && $result->num_rows) {

		$attempt = $result->fetch_assoc();
		$attempt['data'] = json_decode($attempt['json_data'], $associative);

		unset($attempt['json_data']);

		return $attempt;

	}

}

function get_list_tasks($seq_string, $with_answers = false) {

	global $link;

	$list_tasks = array();

	$seq_cond = sequence_to_sql_cond('task_id', $seq_string);

	$query = "
		SELECT *
		FROM geom_tasks
		WHERE " . $seq_cond . ";";

	if ($result = $link->query($query)) {

		$answer_pattern = '/^\s*\*/'; // important

		while($task = $result->fetch_assoc()) {

			$answer_indexes = array();

			$options = explode('|', $task['options']);

			foreach ($options as $option_index => $option) {
			
				if (preg_match($answer_pattern, $option)) { // check optinon is answer

					array_push($answer_indexes, $option_index);

				}

				$options[$option_index] = preg_replace($answer_pattern, '', $option); // replace option with clear option

			}

			$task['options'] = $options;
			$task['multiple'] = count($answer_indexes) > 1;

			if ($with_answers) {

				$task['answer_indexes'] = $answer_indexes;

			}

			array_push($list_tasks, $task);

		}

	}

	return $list_tasks;


}

function parse_test_data($test_data, $with_answers = false) {

	$test_data['tasks'] = get_list_tasks($test_data['task_id_sequence'], $with_answers);
	unset($test_data['task_id_sequence']);

	return $test_data;

}

function get_list_tests($offset = 0, $count = 10) {

	global $link;

	$list_tests = array();

	$query = "
		SELECT *
		FROM geom_tests
		LIMIT " . $offset . ", " . $count . ";";

	if ($result = $link->query($query)) {

		while($row = $result->fetch_assoc()) {

			$test_data = parse_test_data($row);

			array_push($list_tests, $test_data);
		
		}

	}

	return $list_tests;

}

function get_tests_count() {

	global $link;

	$query = "
		SELECT COUNT(*) as count
		FROM geom_tests";

	if ($result = $link->query($query)) {

		return $result->fetch_assoc()['count'];

	}

	return false;

}

?>