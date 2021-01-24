<?php

	$link = new mysqli( '', 'geom', 'password', 'geom' );

	if ($link->connect_errno)
		die( 'Connect to db failed' );

	$GLOBALS['link'] = $link;

?>
