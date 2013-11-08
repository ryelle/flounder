/*! Flounder */
jQuery( document ).ready( function( $ ) {

	var $fields = $( document.getElementById( 'comment-info-fields' ) ),
		$submit = $( document.getElementById( 'submit' ) ),
		$jetpack = $( document.getElementById( 'jetpack-subscribe' ) ),
		$textarea = $( document.getElementById( 'comment' ) );

	$fields.append( $submit ).append( $jetpack ).hide();
	
	$textarea.on( 'focus', function(){
		$fields.insertAfter( this ).slideDown();
	} );


} );
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
/**
 * Makes "skip to content" link work correctly in IE9 and Chrome for better
 * accessibility.
 *
 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
 */
( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && 'undefined' !== typeof( document.getElementById ) ) {
		var eventMethod = ( window.addEventListener ) ? 'addEventListener' : 'attachEvent';
		window[ eventMethod ]( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
					element.tabIndex = -1;

				element.focus();
			}
		}, false );
	}
})();
