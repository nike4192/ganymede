<?php exit;

error_reporting( 0 );

/*require( 'db.php' );

if( $mysqli->connect_errno ) exit( 'Problem with MySQL connect' );*/

$file_name = 'sample2';
$file_path = $_SERVER[ 'DOCUMENT_ROOT' ] . '/grammar/' . $file_name . '.txt';

function sql_quateA( $string ) { return '`' . $string . '`'; }
function sql_quateB( $var ) {

	switch ( gettype( $var ) ) {

		case 'array':

			return '\'' . json_encode( $var ) . '\'';

		break;

		case 'string':

			return '"' . $var . '"';

		break;

		default:

			return $var;

		break;
		
	}

}

function sql_insert( $table_name, $assoc_array ) {

	$result = 'INSERT INTO `' . $table_name . '` ('
		.	implode( ' , ', array_map( sql_quateA, array_keys( $assoc_array ) ) )
		.	') VALUES ('
		.	implode( ' , ', array_map( sql_quateB, array_values( $assoc_array ) ) )
		.	');';

	return $result;

}

function array_range( $array, $start, $end, $value ) {

	for( $i = $start; $i <= $end; $i++ ) {

		$array[ $i ] = $value;

	}

	return $array;

}

echo '<pre>';

$_ASPECTS =Array( // Вид: совершенный, несовершенный

	'сов' => Array( 'field' => 'aspect', 'value' => 'perfective' ),
	'несов' => Array( 'field' => 'aspect', 'value' => 'inperfective' ),
	'2вид' => Array( 'field' => 'aspect', 'value' => 'bispecific' )

);

$_GENDERS = Array( // Род

	'муж' => Array( 'field' => 'gender', 'value' => 'masculine' ),
	'жен' => Array( 'field' => 'gender', 'value' => 'feminine' ),
	'ср' => Array( 'field' => 'gender', 'value' => 'neuter' ),
	'общ' => Array( 'field' => 'gender', 'value' => 'general' )

);

$_TENSES = Array( // Время

	'прош' => Array( 'field' => 'tense', 'value' => 'past' ),
	'наст' => Array( 'field' => 'tense', 'value' => 'present' ),
	'буд' => Array( 'field' => 'tense', 'value' => 'future' )

);

$_CASES = Array( // Падеж

	'им' => Array( 'field' => 'case', 'value' => 'nominative' ),
	'род' => Array( 'field' => 'case', 'value' => 'genetive' ),
	'дат' => Array( 'field' => 'case', 'value' => 'dative' ),
	'вин' => Array( 'field' => 'case', 'value' => 'accusative' ),
	'тв' => Array( 'field' => 'case', 'value' => 'instrumental' ),
	'пр' => Array( 'field' => 'case', 'value' => 'prepositional' ),
	'парт' => Array( 'field' => 'case', 'value' => 'partitive' ),
	'счет' => Array( 'field' => 'case', 'value' => 'counting' ),
	'мест' => Array( 'field' => 'case', 'value' => 'locative' ),
	'зват' => Array( 'field' => 'case', 'value' => 'vocative' )

);

$_NUMBERS = Array( // Число

	'ед' => Array( 'field' => 'number', 'value' => 'singular' ),
	'мн' => Array( 'field' => 'number', 'value' => 'plural' )

);

$_PERSONS = Array( // Лицо

	'1-е' => Array( 'field' => 'person', 'value' => 1 ),
	'2-е' => Array( 'field' => 'person', 'value' => 2 ),
	'3-е' => Array( 'field' => 'person', 'value' => 3 )

);

$_MOODS = Array( // Наклонение

	'пов' => Array( 'field' => 'mood', 'value' => 'imperative' )

);

$_VIVACIOUS = Array( // Одушевленность

	'неод' => Array( 'field' => 'vivacious', 'value' => FALSE ),
	'одуш' => Array( 'field' => 'vivacious', 'value' => TRUE )

);

$_COMPARISONS = Array( // Степень сравнения

	'прев' => Array( 'field' => 'comparison', 'value' => 'superlative' ),
	'сравн' => Array( 'field' => 'comparison', 'value' => 'comparative' ),

);

$_REFLEXIVES = Array( // Возвратность

	'воз' => Array( 'field' => 'reflexive', 'value' => TRUE )

);

$_TRANSITIVITY = Array( // Переходность

	'непер' => Array( 'field' => 'transitivity', 'value' => 0 ),
	'перех' => Array( 'field' => 'transitivity', 'value' => 1 ),
	'пер/не' => Array( 'field' => 'transitivity', 'value' => 2 )

);

$_FORMS = Array(

	'кач' => Array( 'field' => 'form', 'value' => 'qualitative' ), // Качественное
	'безл' => Array( 'field' => 'form', 'value' => 'gerund' ), // [гл]
	'страд' => Array( 'field' => 'form', 'value' => 'passive' ) // [прч]

);

$_TYPES = Array(

	'поряд' => Array( 'field' => 'type', 'value' => 'ordinal' ),
	'кол' => Array( 'field' => 'type', 'value' => 'quantitative' ),
	'собир' => Array( 'field' => 'type', 'value' => 'collective' ),
	'неопр' => Array( 'field' => 'type', 'value' => 'indefinite' ),
	'опред' => Array( 'field' => 'type', 'value' => 'definitive' ),
	'обст' => Array( 'field' => 'type', 'value' => 'adverbial' ),

	'сущ' => Array( 'field' => 'type', 'value' => 'noun' ),
	'прл' => Array( 'field' => 'type', 'value' => 'adjective' ),
	'нар' => Array( 'field' => 'type', 'value' => 'adverb' )

);

$_SUBTYPES = Array(

	'врем' => Array( 'field' => 'subtype', 'value' => 'tense' ),
	'места' => Array( 'field' => 'subtype', 'value' => 'place' ),
	'напр' => Array( 'field' => 'subtype', 'value' => 'direction' ),
	'причин' => Array( 'field' => 'subtype', 'value' => 'cause' ),
	'вопр' => Array( 'field' => 'subtype', 'value' => 'interrogative' ),
	'цель' => Array( 'field' => 'subtype', 'value' => 'intention' ),
	'степ' => Array( 'field' => 'subtype', 'value' => 'degree' ),
	'спос' => Array( 'field' => 'subtype', 'value' => 'way' )

);

$_SPEECH = Array( // Часть речи

	'сущ' => Array( // Существительное

		'table' => 'nouns',
		'class' => 'noun',

		'нескл' => Array( 'field' => 'indeclinable', 'value' => TRUE ) // Несклоняемое

	) + $_CASES + $_NUMBERS + $_GENDERS + $_VIVACIOUS,

	'прл' => Array( // Прилагательное

		'table' => 'adjectives',
		'class' => 'adjective',

		'неизм' => Array( 'field' => 'immutable', 'value' => TRUE ), // Неизменяемое
		'крат' => Array( 'field' => 'short', 'value' => TRUE ) // Краткая форма

	) + $_CASES + $_NUMBERS + $_GENDERS + $_VIVACIOUS + $_COMPARISONS + $_TYPES + $_FORMS,

	'числ' => Array( // Числительное

		'table' => 'numerals',
		'class' => 'numeral'

	) + $_CASES + $_NUMBERS + $_GENDERS + $_VIVACIOUS + $_TYPES + $_FORMS,

	'мест' => Array( // Местоимение

		'table' => 'pronouns',
		'class' => 'pronoun'

	) + $_PERSONS + $_NUMBERS + $_GENDERS + $_CASES + $_VIVACIOUS + $_TYPES + $_FORMS,

	'гл' => Array( // Глагол

		'table' => 'verbs',
		'class' => 'verb',

		'инф' => Array( 'field' => 'infinitive', 'value' => TRUE )

	) + $_TENSES + $_ASPECTS + $_NUMBERS + $_PERSONS + $_GENDERS + $_MOODS + $_TRANSITIVITY + $_REFLEXIVES + $_FORMS,

	'нар' => Array( // Наречие

		'table' => 'adverbs',
		'class' => 'adverb'

	) + $_COMPARISONS + $_TYPES + $_SUBTYPES + $_FORMS,

	'предл' => Array( 'table' => 'prepositions', 'class' => 'preposition' ) + $_CASES, // Предлог

	'союз' => Array( 'table' => 'conjunctions', 'class' => 'conjunction' ),

	'част' => Array( 'table' => 'particle', 'class' => 'particle' ), // Частица

	'межд' => Array( 'table' => 'interjections', 'class' => 'interjection' ), // Междометие

	'прч' => Array( // Причастие

		'table' => 'participles',
		'class' => 'participle',

		'крат' => Array( 'field' => 'short', 'value' => TRUE ),

	) + $_ASPECTS + $_TRANSITIVITY + $_TENSES + $_NUMBERS + $_GENDERS + $_CASES + $_VIVACIOUS + $_REFLEXIVES + $_FORMS,

	'дееп' => Array( // Деепричастие

		'table' => 'transgressives',
		'class' => 'transgressive'

	) + $_ASPECTS + $_TRANSITIVITY + $_TENSES + $_REFLEXIVES,

	'предик' => Array( 'table' => 'predicates', 'class' => 'predicate' ) // Предикат

);
/*
$_ABBRS = Array(

	'сущ' => Array( 'field' => 'speech', 'value' => 'noun' ),
	'прл' => Array( 'field' => 'speech', 'value' => 'adjective' ),
	'числ' => Array( 'field' => 'speech', 'value' => 'numeral' ),
	'мест' => Array( 'field' => 'speech', 'value' => 'pronoun' ), // <= repeat мест
	'гл' => Array( 'field' => 'speech', 'value' => 'verb' ),
	'нар' => Array( 'field' => 'speech', 'value' => 'adverb' ),
	'предл' => Array( 'field' => 'speech', 'value' => 'preposition' ),
	'союз' => Array( 'field' => 'speech', 'value' => 'conjunction' ),
	'част' => Array( 'field' => 'speech', 'value' => 'particle' ), //PTCL
	'межд' => Array( 'field' => 'speech', 'value' => 'interjection' ),
	'прч' => Array( 'field' => 'speech', 'value' => 'participle' ), //PTCP
	'дееп' => Array( 'field' => 'speech', 'value' => 'transgressive' ),
	'пред' => Array( 'field' => 'speech', 'value' => 'predicate' )

	'неод' => Array( 'field' => 'vivacious', 'value' => 'inanimate' ),
	'одуш' => Array( 'field' => 'vivacious', 'value' => 'animated' ),

	'мн' => Array( 'field' => 'number', 'value' => 'plural' ),
	'ед' => Array( 'field' => 'number', 'value' => 'singular' ),

	'муж' => Array( 'field' => 'gender', 'value' => 'masculine' ),
	'жен' => Array( 'field' => 'gender', 'value' => 'feminine' ),
	'ср' => Array( 'field' => 'gender', 'value' => 'neuter' ),
	'общ' => Array( 'field' => 'gender', 'value' => 'general' ),

	'им' => Array( 'field' => 'case', 'value' => 'nominative' ),
	'род' => Array( 'field' => 'case', 'value' => 'genetive' ),
	'дат' => Array( 'field' => 'case', 'value' => 'dative' ),
	'вин' => Array( 'field' => 'case', 'value' => 'accusative' ),
	'тв' => Array( 'field' => 'case', 'value' => 'instrumental' ),
	'пр' => Array( 'field' => 'case', 'value' => 'prepositional' ),
	'парт' => Array( 'field' => 'case', 'value' => 'partitive' ),
	'счет' => Array( 'field' => 'case', 'value' => 'counting' ),
	//'мест' => Array( 'field' => 'case', 'value' => 'locative' ), // <= repeat мест
	'зват' => Array( 'field' => 'case', 'value' => 'vocative' )

);*/

$_MAIN_ID = -1;
$_BASE_ID = 0;

$_MIN_SHIFT = INF;
$_MAX_SHIFT = INF;

$_EXTREME_LINES = Array();
$shift = INF;

$multi_query = '';

$file = fopen( $file_path, 'r+' );
if( $file == null ) return;

//$output_file = fopen( 'ganymede/sql/' . $file_name . '.sql', 'w+' );
echo 'BEGIN READ' . PHP_EOL;
$counter = 0;

while( !feof( $file ) ) {

	$token = Array();
	$morph = Array();
	
	$buffer = fgets( $file );
	$line = iconv( 'WINDOWS-1251', 'UTF-8', $buffer );
	$fields = preg_split( '/\|/', $line );
	$fields_count = count( $fields );

	if( $fields_count < 2 ) { // empty line

		$shift = INF;
		$_EXTREME_LINES = Array();
		continue;

	}

	$asterisk_matches = Array(); // unused words with asterisk
	preg_match( '/^\s*\*/', $fields[ 0 ], $asterisk_matches );
	if( count( $asterisk_matches ) > 0 ) continue;

	$token[ 'word' ] = trim( $fields[ 0 ] );
	$abbreviations = preg_split( '/\s+/', trim( $fields[ 1 ] ) );
	$token[ 'pronunciation' ] = trim( $fields[ 2 ] );

	$spaces = Array();
	preg_match( '/^\s*/', $fields[ 0 ], $spaces );
	$current_shift = strlen( $spaces[ 0 ] );

	$part_speech = $_SPEECH[ $abbreviations[ 0 ] ];
	$abbrs_count = count( $abbreviations );
	$morph[ 'class' ] = $part_speech[ 'class' ];

	for( $i = 1; $i < $abbrs_count; $i++ ) {

		$item = $part_speech[ $abbreviations[ $i ] ];
		if( $item != null ) {

			/*if( $token[ $item[ 'field' ] ] != null ) {

				echo $line;
				echo $item[ 'field' ] . ' => ' . $token[ $item[ 'field' ] ];
				return;

			}*/
			$morph[ $item[ 'field' ] ] = $item[ 'value' ];

		} else { // check availability

			print_r( $token );
			echo $line;
			echo $abbreviations[ $i ];
			return;

		}

	}

	switch( $fields_count ) { // main lemma or derivative word

		case 4: // derivative word

			$token[ 'id' ] = intval( $fields[ 3 ] );

		break;

		case 7: // lemma

			$token[ 'frequency' ] = floatval( $fields[ 3 ] );
			$token[ 'proper_name' ] = trim( $fields[ 4 ] );
			$token[ 'description' ] = trim( $fields[ 5 ] );
			$token[ 'id' ] = intval( $fields[ 6 ] );

		break;

	}

	//echo preg_replace( '/\s/', '_', $fields[ 0 ] ) . '&#9;' . trim( $token[ 'id' ] );

	if( $current_shift != $shift ) {

		if( $current_shift < $shift ) {

			if( $_EXTREME_LINES[ $shift ] != null ) $token[ 'base_id' ] = $_EXTREME_LINES[ $current_shift ];
			$_EXTREME_LINES[ $current_shift ] = $token[ 'id' ];

		} else {

			$_EXTREME_LINES = array_range( $_EXTREME_LINES, $shift, $current_shift, $_EXTREME_LINES[ $shift ] );
			if( $_EXTREME_LINES[ $shift ] != null ) $token[ 'base_id' ] = $_EXTREME_LINES[ $shift ];

		}

	} else {

		$token[ 'base_id' ] = $_EXTREME_LINES[ $current_shift ];

	}

	/*if( $_EXTREME_LINES[ $current_shift ] == null ) {
		
		if( $current_shift > $_MAX_SHIFT ) $token[ 'base_id' ] = $_BASE_ID;
		else {

			if( $_MAIN_ID < 0 ) $_MAIN_ID = $token[ 'id' ];
			else $token[ 'base_id' ] = $_MAIN_ID;
			$_BASE_ID = $token[ 'id' ];

		}
		
		$_SHIFT_SPACES = $current_shift;

	} else {

		$token[ 'base_id' ] = $_BASE_ID;

	}*/

	$shift = $current_shift;

	$token[ 'morph' ] = $morph;
	$counter++;
	//print_r( $token );
	echo $current_shift . ' ' . $fields[ 0 ] . '&#9;' . trim( $token[ 'id' ] ) . '&#9;' . trim( $token[ 'base_id' ] ) . '&#10;';

	$query = sql_insert( 'dictionary2', $token );
	//fwrite( $output_file, $query . PHP_EOL );
	//echo $query . '&#10;';

}

//$link->multi_query( $multi_query, MYSQLI_ASYNC );
//echo $counter . PHP_EOL;
echo 'THE END';

//print_r( $_SPEECH[ 'сущ' ] );

fclose( $file );

echo '</pre>';

?>