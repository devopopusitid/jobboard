/**
 * Sections JS
 */
;( function( $, window, document, undefined ) {

	// Selectors
	var
	$window        = $( window ),
	$body          = $( 'body' ),
	$document      = $( document );

	/**
	 * Map Section
	 */

	// Show hide the overlay
	var $smo_div = $( '.sec-maps-overlay' );

	$document.on( 'touchend click', '.smo-open-map', function( event ) {
		event.preventDefault();
		$smo_div.fadeOut( 200 );
		$body.addClass('smo-opened');
	});

	$document.on( 'touchend click', 'body.smo-opened', function( event ) {
		event.preventDefault();
		$smo_div.fadeIn( 200 );
		$body.removeClass('smo-opened');
	});


	/**
	 * Contact section
	 */

	// Make sure the parallax feature is refreshed after the contcat form button is pressed.
	$document.on( 'touchend click', '.sec-contact-form input[type=submit], .sec-contact-form button', function( event ) {
		setTimeout( function() {
			$window.trigger('resize').trigger('scroll');
		}, 1000);
	});

})( jQuery, window, document );
