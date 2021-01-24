<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';
require_once PHPROOT . '/db.php';

$GLOBALS['FORMULA_IMAGE_PATH'] = '/formulas/images';

function get_group_data($group_id) {

	global $link;

	$query = "
		SELECT *
		FROM geom_formula_groups
		WHERE group_id = '" . $group_id . "';";

	if (($result = $link->query($query)) && $result->num_rows) {

		$group = $result->fetch_assoc();

		$group['formulas'] = get_list_formulas($group['formula_ids_seq']);

		return $group;

	}

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

function get_list_formulas($seq_string) {

	global $link, $FORMULA_IMAGE_PATH;

	$list_formulas = array();

	$seq_cond = sequence_to_sql_cond('formula_id', $seq_string);

	$query = "
		SELECT *
		FROM geom_formulas
		WHERE " . $seq_cond . ";";

	if ($result = $link->query($query)) {

		$answer_pattern = '/^\s*\*/'; // important

		while($formula = $result->fetch_assoc()) {

			$formula['formula_image_src'] = $FORMULA_IMAGE_PATH . '/' . $formula['formula_image_src'];

			array_push($list_formulas, $formula);

		}

	}

	return $list_formulas;

}

function get_groups_by_query($group_query) {

	global $link;

	$query = "
		SELECT *
		FROM geom_formula_groups
		WHERE group_title LIKE '" . $group_query . "';";

	if ($result = $link->query($query)) {

		$groups = [];

		while($group = $result->fetch_assoc()) {

			array_push($groups, $group);

		}

		$result->free();

		return $groups;

	}

	return null;

}

function get_formulas_by_query($formulas_query) {

	global $link, $FORMULA_IMAGE_PATH;

	$query = "
		SELECT *
		FROM geom_formulas
		WHERE formula_title LIKE '" . $formulas_query . "%';";

	if ($result = $link->query($query)) {

		$formulas = [];

		while($formula = $result->fetch_assoc()) {
			
			$formula['formula_image_src'] = $FORMULA_IMAGE_PATH . '/' . $formula['formula_image_src'];

			array_push($formulas, $formula);

		}

		$result->free();

		return $formulas;

	}

	return null;

}

function get_formula_data($formula_id) {

	global $link, $FORMULA_IMAGE_PATH;

	$query = "
		SELECT *
		FROM geom_formulas
		WHERE formula_id = '" . $formula_id . "';";

	if (($result = $link->query($query)) && $result->num_rows) {
			
		$formula_data = $result->fetch_assoc();
		$formula_data['formula_image_src'] = $FORMULA_IMAGE_PATH . '/' . $formula_data['formula_image_src'];

		$result->free();

		return $formula_data;

	}

}

function get_formulas_list($offset, $count) {

	global $link, $FORMULA_IMAGE_PATH;

	$formulas_list = [];

	$query = "
		SELECT *
		FROM geom_formulas
		LIMIT " . $offset . ", " . $count . ";";

	if ($result = $link->query($query)) {

		while($row = $result->fetch_assoc()) {

			$row['formula_image_src'] = $FORMULA_IMAGE_PATH . '/' . $row['formula_image_src'];

			array_push($formulas_list, $row);

		}

	}

	return $formulas_list;

}

function get_formulas_count() {

	global $link;

	$query = "
		SELECT COUNT(*) as count
		FROM geom_formulas";

	if ($result = $link->query($query)) {

		return $result->fetch_assoc()['count'];

	}

	return false;

}

function get_fgroups_list($offset, $count) {

	global $link, $FORMULA_IMAGE_PATH;

	$formulas_list = [];

	$query = "
		SELECT *
		FROM geom_formula_groups
		LIMIT " . $offset . ", " . $count . ";";

	if ($result = $link->query($query)) {

		while($row = $result->fetch_assoc()) {

			array_push($formulas_list, $row);

		}

	}

	return $formulas_list;

}

function get_fgroups_count() {

	global $link;

	$query = "
		SELECT COUNT(*) as count
		FROM geom_formula_groups";

	if ($result = $link->query($query)) {

		return $result->fetch_assoc()['count'];

	}

	return false;

}
?>