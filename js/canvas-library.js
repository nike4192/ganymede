function Canvas( width, height, ctx ) {

	var canvas = document.createElement( 'canvas' );
	if( width ) canvas.width = width;
	if( height ) canvas.height = height;
	canvas.ctx = ctx || '2d';

	return canvas;

}

Object.assign( HTMLCanvasElement.prototype, {

	clear: function() {

		var context = this.ctx;
		if( context instanceof CanvasRenderingContext2D ) {

			var m = context.getTransform();
			context.clearRect( -m.e, -m.f, this.width, this.height );

		}

	},

	fitSize: function() {

		var offsetWidth = this.offsetWidth || 300;
		var offsetHeight = this.offsetHeight || 150;

		if( this.width !== offsetWidth || this.height !== offsetHeight ) {

			this.width = offsetWidth;
			this.height = offsetHeight;

			this.dispatchEvent( new Event( 'fitsize' ) );

		}

	},

	getPicture: function( format, quality ) {

		var image = new Image( this.width, this.height );
		image.src = this.toDataURL( 'image/' + ( format || 'png' ), quality || 1 );
		return image;

	},

	cutColor: function( color, originImage, maskImage ) {

		var COLOR_MEASUREMENT_ERROR = this.COLOR_MEASUREMENT_ERROR || 80;

		if( !originImage.imageData ) originImage.computeImageData();
		if( !maskImage.imageData ) maskImage.computeImageData();

		this.width = originImage.offsetWidth || originImage.width;
		this.height = originImage.offsetHeight || originImage.height;

		var ctx = this.getContext( '2d' );

		var imageData = ctx.createImageData( this.width, this.height );
		var maskData = ctx.createImageData( this.width, this.height );

		var originImageData = originImage.imageData;
		var maskImageData = maskImage.imageData;

		for( var i = 0; i < maskImageData.data.length; i += 4 ) {

			var r = maskImageData.data[ i + 0 ];
			var g = maskImageData.data[ i + 1 ];
			var b = maskImageData.data[ i + 2 ];
			var a = maskImageData.data[ i + 3 ];

			var diffR = Math.abs( r - color.r ) < COLOR_MEASUREMENT_ERROR;
			var diffG = Math.abs( g - color.g ) < COLOR_MEASUREMENT_ERROR;
			var diffB = Math.abs( b - color.b ) < COLOR_MEASUREMENT_ERROR;

			if( diffR && diffG && diffB ) {

				imageData.data[ i + 0 ] = originImageData.data[ i + 0 ];
				imageData.data[ i + 1 ] = originImageData.data[ i + 1 ];
				imageData.data[ i + 2 ] = originImageData.data[ i + 2 ];
				imageData.data[ i + 3 ] = originImageData.data[ i + 3 ];

				maskData.data[ i + 0 ] = 255;
				maskData.data[ i + 1 ] = 255;
				maskData.data[ i + 2 ] = 255;
				maskData.data[ i + 3 ] = originImageData.data[ i + 3 ];

			}

		}

		this.imageData = imageData;
		this.maskData = maskData;

		ctx.putImageData( imageData, 0, 0 );

		var originImage = new Image;
		originImage.src = this.toDataURL( 'image/png', 1 );
		this.originImage = originImage;

	}

} )

Object.defineProperties( HTMLCanvasElement.prototype, {

	ctx: {

		set: function( value ) {

			var context = this.getContext( value );

			if( !this.CONTEXT_TYPE && context ) {

				Object.defineProperty( this, 'CONTEXT_TYPE', { // const

					value: value,
					writable: false

				} );

			} else {

				throw new Error( 'context was initiated' );

			}

		},

		get: function() {

			if( !this.CONTEXT_TYPE ) {

				var contextTypes = [ '2d', 'webgl', 'webgl2', 'experimental-webgl', 'experimental-webgl2', 'bitmaprenderer' ];

				for( var i = 0; i < contextTypes.length; i++ ) {

					var contextType = contextTypes[ i ];

					var context = this.getContext( contextType );
					if( context ) {

						this.CONTEXT_TYPE = contextType;
						return context;

					}

				}

			}

			return this.getContext( this.CONTEXT_TYPE );

		}

	},

	cx: {

		get: function() {

			return this.width / 2;

		}

	},

	cy: {

		get: function() {

			return this.height / 2;

		}

	},

	aspect: {

		get: function() {

			return this.width / this.height;

		}

	},

	autofit: {

		set: function( value ) {

			if( value === true ) {

				if( !this.liresize ) {

					window.addEventListener( 'resize', this.liresize = this.fitSize.bind( this ) );

				}

				this.fitSize();

			} else {

				if( this.liresize ) {

					window.removeEventListener( 'resize', this.liresize );
					delete this.liresize;

				}

			}

		}

	},

	autosave: {

		set: function( value ) {

			if( value === true ) {

				this.addEventListener( 'fitsize', this.fitSize );

			} else {

				this.removeEventListener( 'fitsize', this.fitSize );

			}

		}

	}

} )

Object.assign( CanvasRenderingContext2D.prototype, {

	setStyle: function( styleObject ) {

		this.restore();
		Object.assign( this, styleObject );

	}

} )