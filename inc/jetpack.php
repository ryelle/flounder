<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Flounder
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 * Use `__return_false` as the `footer_callback` so we don't show a footer.
 */
function flounder_infinite_scroll_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container'       => 'content',
		'footer'          => 'page',
		'footer_callback' => '__return_false',
	) );
}
add_action( 'after_setup_theme', 'flounder_infinite_scroll_setup' );
