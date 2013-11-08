/**
 * Handles toggling the navigation menu & widgets for small screens.
 */
( function( $ ) {
	var container  = document.getElementById( 'page' ),
	    navIcon    = document.getElementById( 'toggle-nav' ),
	    widgetIcon = document.getElementById( 'toggle-widgets' );
			console.log(  );
	// Bail if we don't see a container
	if ( undefined == container )
		return;

	// Display/hide navigation
	if ( undefined != navIcon ) {
		$( navIcon ).on( 'click', function() {
			$( document.body ).removeClass( 'show-widgets' );
			$( document.body ).toggleClass( 'show-nav' );
		});
	}
	
	// Display/hide navigation
	if ( undefined != widgetIcon ) {
		$( widgetIcon ).on( 'click', function() {
			$( document.body ).removeClass( 'show-nav' );
			$( document.body ).toggleClass( 'show-widgets' );
		});
	}
} )( jQuery );