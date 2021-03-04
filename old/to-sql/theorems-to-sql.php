<?php

$root_path = '/var/www/ganymede';
$path = $root_path . '/theorems';
$json = file_get_contents($path . '/theorems.json');

$json = preg_replace('/\/\/.+/', '', $json);

$theorems = json_decode($json, true);

$row_values = array_map(function($theorem) {

	$values = array_map(function($value) {

		$value = str_replace('\\', '\\\\', $value);

		return "'" . $value . "'";

	}, array_values($theorem));

	return '(' . implode(', ', $values) . ')';

}, $theorems);

file_put_contents($path . '/theorems-sql-values', implode(', ' . PHP_EOL, $row_values));

?>