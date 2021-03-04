String.prototype.remove = function( removeValue ) {

	return this.replace( removeValue, '' );

}

var NAMESPACES = {

	svg: 'http://www.w3.org/2000/svg',
	use: 'http://www.w3.org/2000/svg',
	xlink: 'http://www.w3.org/1999/xlink'

}

function QS( Selector ) {

	return document.querySelector( Selector );

}

function QSA( Selector ) {

	return document.querySelectorAll( Selector );

}

Element.prototype.qs = function( Selector ) {

	return this.querySelector( Selector );

}

Element.prototype.qsa = function( Selector ) {

	return this.querySelectorAll( Selector );

}

function qElement( querySelector ) { // div.container[ href ] > p.c

	var parentSelector = querySelector.match( /^.+?(?=>|$)/ ); // div.container[ href ]
	if( parentSelector ) parentSelector = parentSelector[ 0 ];
	else return null;

	var childrenSelector = querySelector.match( />.+$/ ); // >p.c
	if( childrenSelector ) childrenSelector = childrenSelector[ 0 ].slice( 1 );

	var tagMatch = parentSelector.match( /^[^.\[#%{]+/ ); // div
	var tagName = tagMatch ? tagMatch[ 0 ].remove( /\s/g ) : 'div';
	if( tagName === '' ) tagName = 'div';

	var classes = parentSelector.match( /\.[^.\[#%{]+/g ); // container
	if( classes ) {

		classes = classes.map( function( value ) {

			return !/['"]/.exec( value ) ? value.remove( /\s/g ).slice( 1 ) : '';

		} )

	}

	var attributes = parentSelector.match( /\[[^\[]+?(?=\])/g ); // href
	if( attributes ) {

		attributes = attributes.map( function( attribute ) {

			parentSelector = parentSelector.remove( attribute ); // It's important

			attribute = attribute.slice( 1 );
			attribute = attribute.split( '=' ); // {Array}

			attribute[ 0 ] = attribute[ 0 ].remove( /['"\s]/g ); // Remove quotes
			if( attribute[ 1 ] ) {

				var value = attribute[ 1 ].match( /('|").+\1/ );
				attribute[ 1 ] = value ? value[ 0 ].slice( 1, -1 ) : attribute[ 1 ].remove( /['"\s]/g ); // Remove quotes

			} else attribute[ 1 ] = '';

			return attribute;

		} );

	}

	var id = parentSelector.match( /#[^.\[#%{]+/ );
	if( id ) id = id[ 0 ].slice( 1 );

	var bubbleProp = parentSelector.match( /%.+%/ );
	if( bubbleProp ) bubbleProp = bubbleProp[ 0 ].slice( 1, -1 );

	var textContent = parentSelector.match( /\{.+\}/ );
	if( textContent ) textContent = textContent[ 0 ].slice( 1, -1 );

	var namespace = NAMESPACES[ tagName ] || null;
	var element = ( namespace )? document.createElementNS( namespace, tagName ) : document.createElement( tagName );

	if( id ) element.id = id;

	if( classes ) {

		classes.forEach( function( value ) {

			if( value ) {

				element.classList.add( value );

			}

		} );

	}

	if( attributes ) {

		attributes.forEach( function ( attr ) {

			var namespace = attr[ 0 ].match( /^.+:/ ); // xlink:

			if( namespace ) {

				namespace = namespace[ 0 ].slice( 0, -1 ); // xlink
				element.setAttributeNS( namespace, attr[ 0 ], attr[ 1 ] );

			} else element.setAttribute( attr[ 0 ], attr[ 1 ] );

		} )

	}

	if( bubbleProp ) {

		element.setAttribute( 'bubbleprop', bubbleProp );

	}

	if( textContent ) {

		element.textContent = textContent;

	}

	var index = arguments[ 1 ] || 0;

	if( childrenSelector ) element.append( qElement( childrenSelector, index + 1 ) );

	if( index === 0 ) {

		var bubbleChildren = element.qsa( '[ bubbleprop ]' );
		bubbleChildren.forEach( function( bubbleChild ) {

			var bubbleProp = bubbleChild.getAttribute( 'bubbleprop' );
			element[ bubbleProp ] = bubbleChild;
			bubbleChild.removeAttribute( 'bubbleprop' );

		} )

	}

	return element;

}