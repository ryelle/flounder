/**
 * We need to redraw the icons on document.ready- if the font loads after 
 * the CSS renders, the icons are not displayed correctly. This forces a
 * redraw after the font is loaded.
 */
jQuery( document ).ready( function(){
	var head = document.getElementsByTagName('head')[0],
	    style = document.createElement('style');
	style.type = 'text/css';
	style.styleSheet.cssText = ':before,:after{content:none !important;}';
	head.appendChild(style);
	setTimeout(function(){
	    head.removeChild(style);
	}, 0);
});