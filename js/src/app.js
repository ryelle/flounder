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