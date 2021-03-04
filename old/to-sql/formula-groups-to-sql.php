<?php

$root_path = '/var/www/ganymede';
$path = $root_path . '/formulas';
$json = file_get_contents($path . '/formula-groups.json');

$json = preg_replace('/\/\/.+/', '', $json);

$formula_groups = json_decode($json, true);

$row_values = array_map(function($formula_group) {

	$values = array_map(function($value) {

		$value = str_replace('\\', '\\\\', $value);

		return "'" . $value . "'";

	}, array_values($formula_group));

	return '(' . implode(', ', $values) . ')';

}, $formula_groups);

file_put_contents($path . '/formula-groups-sql-values', implode(', ' . PHP_EOL, $row_values));

?>