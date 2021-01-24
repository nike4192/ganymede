<!DOCTYPE html>
<html>
	<head>
		<title>Search</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<script src="/js/query-script.js"></script>
		<script src="/js/jquery.js"></script>

		<style>
			@font-face {
				font-family: 'OpenSans';
				src: url( '/fonts/OpenSans-Regular.ttf');
				font-weight: 100;
			}
			body {
				margin: 0;
				font-family: 'OpenSans';
			}
			.box {
				padding: 2rem;
				margin: 0 auto;
				display: flex;
				flex-direction: column;
				box-sizing: border-box;
				width: 100%;
				max-width: 800px;
			}
			.search-container {
				margin-bottom: 0.5rem;
				display: flex;
			}
			input[ type = "search" ] {
				flex: 1 0 auto;
				margin-right: 0.5rem;
				padding: 0.5rem;
				display: flex;
			}
			ul {
				padding: 0;
				list-style-type: none;
			}
			.morph-container {
				display: flex;
				flex-direction: column;
			}
			.empty-result {
				opacity: 0.5;
			}
		</style>
	</head>
	<body>
		<main>
			<div class="box">
				<div class="search-container">
					<input type="search">
					<button class="search-button">Search</button>
				</div>
				<ul class="word-list"></ul>
			</div>
		</main>
		<script>

			var searchInput = QS( 'input[ type = "search" ]' );
			var searchButton = QS( '.search-button' );
			var wordList = QS( '.word-list' );
			var boxContainer = QS( '.box' );

			var gram = {

				class : {

					noun : 'существительное',
					adjective : 'прилагательное',
					numeral: 'числительное',
					pronoun: 'местоимение',
					verb: 'глагол',
					adverb: 'наречие',
					preposition: 'предлог',
					conjunction: 'союз',
					particle: 'частица',
					interjection: 'междометие',
					participle: 'причастие',
					transgressive: 'дееппричастие',
					predicate: 'предикат'

				},

				indeclinable : {

					true: 'несклоняемое'

				},

				immutable : {

					true: 'неизменяемое'

				},

				short : {

					true: 'краткое'

				},

				infinitive : {

					true: 'инфинитив'

				},

				case : { // Падеж

					nominative: 'именительный',
					genetive: 'родительный',
					dative: 'дательный',
					accusative: 'винительный',
					instrumental: 'творительный',
					prepositional: 'предложный',
					partitive: 'партитивный',
					counting: 'счететный',
					locative: 'местный',
					vocative: 'звательный'

				},

				aspect : { // Вид

					perfective: 'совершенный',
					inperfective: 'несовершенный',
					bispecific: 'совершенный и несовершенный'

				},

				gender : { // Род

					masculine: 'мужской',
					feminine: 'женский',
					neuter: 'средний',
					general: 'общий'

				},

				tense : { // Время

					past: 'прошедшее',
					present: 'настоящее',
					future: 'будущее'

				},

				number : { // Число

					singular: 'единственное',
					plural: 'множественное'

				},

				person : { // Лицо

					1: '1-е',
					2: '2-е',
					3: '3-е',

				},

				mood : { // Наклонение

					imperative: 'повелительное'

				},

				vivacious : { // Одушевленность

					true: 'одушевленное',
					false: 'неодушевленное'

				},

				comparison : { // Степень сравнения

					superlative: 'превосходная',
					comparative: 'сравнительная'

				},

				reflexive : {

					true: 'возвратное'

				},

				transitivity : {

					0: 'непереходный',
					1: 'переходный',
					2: 'переходный и непереходный'

				},

				form : {
					
					qualitative: 'качественное',
					gerund: 'безличное',
					passive: 'страдательное'

				},

				type : {

					ordinal: 'порядковое',
					quantitative: 'количественное',
					collective: 'собирательное',
					indefinite: 'неопределенное',
					definitive: 'определительное',
					adverbial: 'обстоятельственное',
					noun: 'существительное',
					adjective: 'прилагательное',
					adverb: 'наречие',

				},

				subtype : {

					tense: 'время',
					place: 'места',
					direction: 'направления',
					cause: 'причины',
					interrogative: 'вопросительное',
					intention: 'цель',
					degree: 'степенное',
					way: 'способ',

				}

			}

			var dictionary = {

				noun : 'существительное',
				adjective : 'прилагательное',
				numeral: 'числительное',
				pronoun: 'местоимение',
				verb: 'глагол',
				adverb: 'наречие',
				preposition: 'предлог',
				conjunction: 'союз',
				particle: 'частица',
				interjection: 'междометие',
				participle: 'причастие',
				transgressive: 'дееппричастие',
				predicate: 'предикат'

			}

			function renderFields( fields ) {

				wordList.innerHTML = '';

				if( fields.length ) {

					fields.forEach( function( field ) {

						var article = document.createElement( 'article' );
						var morphContainer = qElement( '.morph-container' );

						for( prop in field ) {

							switch( prop ) {

								case 'word':

									var heading = qElement( 'h3' );
									heading.textContent = field[ prop ];
									article.append( heading );

								break;

								case 'morph':

									var morph = field[ prop ];
									for( morphProp in morph ) {

										var span = document.createElement( 'span' );
										span.textContent = gram[ morphProp ][ morph[ morphProp ] ];
										morphContainer.append( span );

									}

								break;

							}

						}

						var item = qElement( 'li' );
						item.append( article, morphContainer );
						wordList.append( item );

					} );

				} else {

					var item = qElement( 'li.empty-result{Пустой результат}' );
					wordList.append( item );

				}

			}

			function sendRequest() {

				$.getJSON( {

					method : 'POST',
					url: '/php/search.php',
					data : { word : searchInput.value.trim() }

				} ).done( renderFields );

			}

			searchButton.addEventListener( 'click', sendRequest );
			searchInput.addEventListener( 'keydown', function( event ) {

				switch ( event.key ) {

					case 'Enter':

						sendRequest();

					break;

				}

			} );

		</script>
	</body>
</html>