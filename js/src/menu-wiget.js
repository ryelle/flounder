/**
 * Handles toggling the navigation menu & widgets for small screens.
 */
( function( $ ) {
	var container  = document.getElementById( 'page' ),
	    navIcon    = document.getElementById( 'toggle-nav' ),
	    widgetIcon = document.getElementById( 'toggle-widgets' );

	// Bail if we don't see a container or nav icon
	if ( undefined == container || undefined == navIcon )
		return false;

	// Display/hide navigation
	navIcon.onclick = function() {
		$( document.body ).removeClass( 'show-widgets' );
		$( document.body ).toggleClass( 'show-nav' );
	};
	
	// Display/hide navigation
	widgetIcon.onclick = function() {
		$( document.body ).removeClass( 'show-nav' );
		$( document.body ).toggleClass( 'show-widgets' );
	};
} )( jQuery );