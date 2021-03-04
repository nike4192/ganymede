<?php

require_once 'db.php';


$root_path = '/var/www/ganymede';
$path = $root_path . '/figures';
$json = file_get_contents($path . '/definitions.json');

$json = file_get_contents($path . '/definitions.json');
$figures = json_decode($json, true);

$row_values = array_map(function($figure) {

	$file_ext = preg_replace('/^.+\./', '', $figure['image_src']);
	$file_name = $figure['title'] . '.' . $file_ext;

	$figure['def_image_src'] = $file_name;
	$figure['def_title'] = $figure['title'];
	$figure['def_content'] = $figure['definition'];

	unset($figure['image_src']);
	unset($figure['title']);
	unset($figure['definition']);

	$values = array_map(function($value) {

		$value = str_replace('\\', '\\\\', $value);

		return "'" . $value . "'";

	}, array_values($figure));

	return '(' . implode(', ', $values) . ')';

}, $figures);

file_put_contents($path . '/def-sql-values', implode(', ' . PHP_EOL, $row_values));

?>