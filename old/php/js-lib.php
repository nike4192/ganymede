<?php

	class js {

		public static function insert_vars($assoc_array_vars) {

			echo '<script>' . PHP_EOL;
			foreach ($assoc_array_vars as $key => $value)
				echo 'var ' . $key . ' = ' . json_encode($value) . ';' . PHP_EOL;

			echo '</script>' . PHP_EOL;

		}

	}

?>