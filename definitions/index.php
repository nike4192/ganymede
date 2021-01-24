<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';
require_once PHPROOT . '/def-module.php';
require_once PHPROOT . '/renderer.php';

if (isset($_GET['query'])) {

	$def = get_def_by_query($_GET['query']);
	if ($def) {

		if (@$_GET['format'] == 'json') {

			$data = [
				'title' => $def['def_title'],
				'content' => $def['def_content'],
			];

			$path = preg_replace('/\\.+?$/', '', $_SERVER['PHP_SELF']);
			$query_data = ['def_id' => $def['def_id']];

			$data['href'] = $path . '?' . http_build_query($query_data);

			exit(json_encode($data));

		}
	
		$data = ['def' => $def];

		Renderer::render('def.phtml', $data, true);

	} else {

		exit('По запросу "' . $_GET['query'] . '" ничего не найдено');

	}

}

if (isset($_GET['def_id'])) {

	$def = get_def_data($_GET['def_id']);
	if ($def) {
	
		$data = ['def' => $def];

		Renderer::render('def.phtml', $data, true);

	} else {

		exit('Definition id is incorrect');

	}

}

Renderer::render('definitions.phtml', null, true);

?>