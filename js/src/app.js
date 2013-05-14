jQuery( document ).ready( function( $ ) {

	var $fields = $( document.getElementById( 'comment-info-fields' ) ),
		$submit = $( document.getElementById( 'submit' ) ),
		$textarea = $( document.getElementById( 'comment' ) );

	$fields.append( $submit ).hide();
	
	$textarea.on( 'focus', function(){
		$fields.insertAfter( this ).slideDown();
	} );


} );