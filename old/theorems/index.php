<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';
require_once PHPROOT . '/theorem-module.php';
require_once PHPROOT . '/renderer.php';

if (isset($_GET['query'])) {

	$theorems = get_theorems_by_query($_GET['query']);
	if ($theorems) {

		if (@$_GET['format'] == 'json') {

			$data = [];

			foreach ($theorems as $theorem) {

				$piece_data = [
					'title' => $theorem['theorem_title'],
					'content' => $theorem['theorem_content'],
				];

				$path = preg_replace('/\\.+?$/', '', $_SERVER['PHP_SELF']);
				$query_data = ['theorem_id' => $theorem['theorem_id']];

				$piece_data['href'] = $path . '?' . http_build_query($query_data);

				array_push($data, $piece_data);

			}

			exit(json_encode($data));

		}
	
		$data = ['theorems' => $theorems];

		Renderer::render('theorems.phtml', $data, true);

	} else {

		exit('По запросу "' . $_GET['query'] . '" ничего не найдено');

	}

}

if (isset($_GET['theorem_id'])) {

	$theorem = get_theorem_data($_GET['theorem_id']);
	if ($theorem) {
	
		$data = ['theorem' => $theorem];

		Renderer::render('theorem.phtml', $data, true);

	} else {

		exit('theorem id is incorrect');

	}

}

Renderer::render('theorems-view.phtml', null, true);

?>