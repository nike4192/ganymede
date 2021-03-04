<?php

require_once 'db.php';

function check_auth() {

	global $link;

	$user_id = @$_COOKIE['ganymede_id'];
	$user_token = @$_COOKIE['ganymede_token'];

	if ($user_id && $user_token) {

		$query_result = $link->query("
			SELECT COUNT(*) AS count
			FROM geom_sessions
			WHERE
				user_id = '" . $user_id . "' AND
				user_token = '" . $user_token . "';");

		$session_count = (int) $query_result->fetch_assoc()['count'];
		if ($session_count > 0)
		{
			return TRUE;
		}

	}

	return FALSE;

}

?>