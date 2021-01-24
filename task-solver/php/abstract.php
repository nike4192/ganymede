<?

$abstract_string_rules = [

	'char' => [

		

	],

	'word' => [

		'handle' => function($char)

	]

];

function abstract_data($data) {

	switch (gettype($data)) {

		case 'string':

			return abstract_string($data);

			break;

	}

}

function abstract_string($string) {



}

?>