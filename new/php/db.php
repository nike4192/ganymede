<?php

$link = new mysqli( '', 'geom', 'cis2014W', 'geom' );

	if ($link->connect_errno)
		die( $link->connect_error  );

	$GLOBALS['link'] = $link;

?>
