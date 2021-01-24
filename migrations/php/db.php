<?php

	$link = new mysqli( '', 'coorxyz', 'Qq60eyEt65', 'coorxyz_training' );

	if ($link->connect_errno)
		die( 'Connect to db failed' );

	$GLOBALS['link'] = $link;

?>
