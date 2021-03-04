<?php

require( 'db.php' );

if( $link->connect_errno ) exit( 'bad news...' );

$_FIELDS = Array();

function extract_words( $mysqli_result ) {

	$words = Array();

	while( $field = $mysqli_result->fetch_assoc() ) {

		$field[ 'morph' ] = json_decode( $field[ 'morph' ] );
		array_push( $words, $field );

	}

	return $words;

}

if(isset($_POST[ 'q' ])) {

	$q = $_POST[ 'q' ];

	if( $result = $link->query( 'SELECT * FROM dictionary WHERE word LIKE "' . $q . '%"' ) ) {

		exit( json_encode( extract_words( $result ) ) );

	}

} else if (isset($_POST[ 'word' ])) {

	$word = $_POST[ 'word' ];

	if( $result = $link->query( 'SELECT * FROM dictionary WHERE word = "' . $word . '"' ) ) {

		exit( json_encode( extract_words( $result ) ) );

	}

}

?>