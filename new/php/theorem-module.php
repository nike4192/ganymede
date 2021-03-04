<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';
require_once PHPROOT . '/db.php';

$GLOBALS['THEOREM_IMAGE_PATH'] = '/theorems/images';

function get_theorems_by_query($theorems_query) {

	global $link, $THEOREM_IMAGE_PATH;

	$query = "
		SELECT *
		FROM geom_theorems
		WHERE theorem_title LIKE '" . $theorems_query . "%';";

	if ($result = $link->query($query)) {

		$theorems = [];

		while($theorem = $result->fetch_assoc()) {
			
			$theorem['theorem_image_src'] = $THEOREM_IMAGE_PATH . '/' . $theorem['theorem_image_src'];

			array_push($theorems, $theorem);

		}

		$result->free();

		return $theorems;

	}

	return null;

}

function get_theorem_data($theorem_id) {

	global $link, $THEOREM_IMAGE_PATH;

	$query = "
		SELECT *
		FROM geom_theorems
		WHERE theorem_id = '" . $theorem_id . "';";

	if (($result = $link->query($query)) && $result->num_rows) {
			
		$theorem_data = $result->fetch_assoc();
		$theorem_data['theorem_image_src'] = $THEOREM_IMAGE_PATH . '/' . $theorem_data['theorem_image_src'];

		$result->free();

		return $theorem_data;

	}

}

function get_theorems_list($offset, $count) {

	global $link, $THEOREM_IMAGE_PATH;

	$theorems_list = [];

	$query = "
		SELECT *
		FROM geom_theorems
		LIMIT " . $offset . ", " . $count . ";";

	if ($result = $link->query($query)) {

		while($row = $result->fetch_assoc()) {

			$row['theorem_image_src'] = $THEOREM_IMAGE_PATH . '/' . $row['theorem_image_src'];

			array_push($theorems_list, $row);

		}

	}

	return $theorems_list;

}

function get_theorems_count() {

	global $link;

	$query = "
		SELECT COUNT(*) as count
		FROM geom_theorems";

	if ($result = $link->query($query)) {

		return $result->fetch_assoc()['count'];

	}

	return false;

}
?>