<?php

require_once 'constants.php';

class User
{

	public static function init_user_folder($user_id) {

		$user_folder_path = DOCROOT . '/user-data/' . $user_id;

		if (mkdir($user_folder_path, 0700, true)) {

			mkdir($user_folder_path . '/tests', 0700, true);

			return TRUE;

		}

		return FALSE;

	}
}

?>