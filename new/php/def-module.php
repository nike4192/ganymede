<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';
require_once PHPROOT . '/db.php';

$GLOBALS['DEF_IMAGE_PATH'] = '/definitions/images';

function get_def_by_query($query) {

	global $link, $DEF_IMAGE_PATH;

	$query = "
		SELECT *
		FROM geom_definitions
		WHERE def_title LIKE '" . $query . "%';";

	if (($result = $link->query($query)) && $result->num_rows) {
			
		$def_data = $result->fetch_assoc();
		$def_data['def_image_src'] = $DEF_IMAGE_PATH . '/' . $def_data['def_image_src'];

		$result->free();

		return $def_data;

	}

	return null;

}

function get_def_data($def_id) {

	global $link, $DEF_IMAGE_PATH;

	$query = "
		SELECT *
		FROM geom_definitions
		WHERE def_id = '" . $def_id . "';";

	if (($result = $link->query($query)) && $result->num_rows) {
			
		$def_data = $result->fetch_assoc();
		$def_data['def_image_src'] = $DEF_IMAGE_PATH . '/' . $def_data['def_image_src'];

		$result->free();

		return $def_data;

	}

}

function get_defs_count() {

	global $link;

	$query = "
		SELECT COUNT(*) as count
		FROM geom_definitions";

	if ($result = $link->query($query)) {

		return $result->fetch_assoc()['count'];

	}

	return false;

}

function get_defs_list($offset, $count) {

	global $link, $DEF_IMAGE_PATH;

	$defs_list = [];

	$query = "
		SELECT *
		FROM geom_definitions
		LIMIT " . $offset . ", " . $count . ";";

	if ($result = $link->query($query)) {

		while($row = $result->fetch_assoc()) {

			$row['def_image_src'] = $DEF_IMAGE_PATH . '/' . $row['def_image_src'];

			array_push($defs_list, $row);

		}

	}

	return $defs_list;

}

?>