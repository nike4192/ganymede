
( function( global ) {

	var abs = Math.abs;
	var now = window.performance.now.bind( window.performance );

	function TimeRunner( timingFunction, params ) {

		this.timingFunction = timingFunction;

		this.stopped = true;
		this.stage = 0;
		this.loop = false;
		this.reversed = false;

		if( typeof params === 'number' ) {

			this.duration = params;

		} else if( params && typeof params === 'object' ) {

			Object.assign( this, params );

		}

	}

	Object.assign( TimeRunner.prototype, {

		start: function() {

			this.reversed = false;
			this.stage = 0;

			if( this.stopped ) this.play();
			else this.init( false );

		},

		reverse: function() {

			this.reversed = true;
			this.stage = 1;

			if( this.stopped ) this.play();
            else this.init( false );

		},

		init: function( saveStage ) {

			this.origin = now();

			if( saveStage )
				this.origin -= abs( this.reversed - this.stage ) * this.duration;

		},

		play: function() {

			this.init( true );
			this.stopped = false;

			if( this.onstarted ) this.onstarted.call( this );

			requestAnimationFrame( this.request = function() {

				if( this.stopped ) return;

				var time = now() - this.origin;
				if( time > this.duration ) time = this.duration;

				var stage = time / this.duration || 1;
					stage = abs( this.reversed - stage );

				this.timingFunction.call( this, this.stage = stage );

				if( time < this.duration ) {

					this.requestID = requestAnimationFrame( this.request );
				
				} else if( this.loop ) {

					this.stage = this.reversed & 1;
					this.play();

				} else {

					this.stopped = true;
					if( this.onended ) this.onended.call( this );

				}

			}.bind( this ) );

		},

		pause: function() {

			this.stopped = true;
			cancelAnimationFrame( this.reqestID );

		},

		stop: function() {

			this.pause();
			this.reversed = false;
			this.stage = 0;

		}

	} )

	Object.defineProperties( TimeRunner.prototype, {

		ended: {

			get: function() {

				return Boolean( this.stage ^ this.reversed ); // Maybe remove Boolean

			}

		}

	} );

	function Cascade( runner ) {

		this.runners = [];

		for( var i = 0; i < arguments.length; i++ ) {

			var runner = arguments[ i ];
			this.runners.push( runner );

		}

	}

	Object.assign( Cascade.prototype, {

		start: function() {

			

		}

	} )

	global.TimeRunner = TimeRunner;

} )( window )