<?php

require_once 'constants.php';

class Renderer {

	public static function render($template_path, $data = array(), $exit = false) {

		if ($data && count($data)) {

			extract($data);
	
		}

		include DOCROOT . '/templates/' . $template_path;

		if ($exit) {

			exit();

		}

	}

}

?>