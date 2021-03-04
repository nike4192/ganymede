<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/php/constants.php';
require_once PHPROOT . '/formula-module.php';
require_once PHPROOT . '/renderer.php';

if (isset($_GET['query'])) {

	$formulas = get_formulas_by_query($_GET['query']);
	if ($formulas) {

		if (@$_GET['format'] == 'json') {

			$data = [];

			foreach ($formulas as $formula) {

				$piece_data = [
					'title' => $formula['formula_title'],
					'content' => $formula['formula_content'],
				];

				$path = preg_replace('/\\.+?$/', '', $_SERVER['PHP_SELF']);
				$query_data = ['formula_id' => $formula['formula_id']];

				$piece_data['href'] = $path . '?' . http_build_query($query_data);

				array_push($data, $piece_data);

			}

			exit(json_encode($data));

		}
	
		$data = ['formulas' => $formulas];

		Renderer::render('group.phtml', $data, true);

	} else {

		exit('По запросу "' . $_GET['query'] . '" ничего не найдено');

	}

}

if (isset($_GET['formula_id'])) {

	$formula = get_formula_data($_GET['formula_id']);
	if ($formula) {
	
		$data = [
			'group' => [
				'formulas' => [$formula]
			]
		];

		Renderer::render('group.phtml', $data, true);

	} else {

		exit('formula id is incorrect');

	}

}

if (isset($_GET['group_id'])) {

	$group = get_group_data($_GET['group_id']);
	if ($group) {
	
		$data = ['group' => $group];

		Renderer::render('group.phtml', $data, true);

	} else {

		exit('group id is incorrect');

	}

}

Renderer::render('formulas-view.phtml', null, true);

?>