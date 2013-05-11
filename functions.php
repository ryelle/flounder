<?php
/**
 * Flounder functions and definitions
 *
 * @package Flounder
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 500; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'flounder_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function flounder_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Flounder, use a find and replace
	 * to change 'flounder' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'flounder', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'flounder' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'structured-post-formats', array( 'aside', 'gallery', 'image', 'video', 'quote', 'link' )  );
	
	/**
	 * Add an image size that does not exceed content width
	 */
	add_image_size( 'feature', 500 );
}
endif; // flounder_setup
add_action( 'after_setup_theme', 'flounder_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function flounder_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'flounder' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'flounder_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function flounder_scripts() {
	wp_enqueue_style( 'flounder-fonts', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600,200italic,400italic,600italic' );
	wp_enqueue_style( 'dashicons', get_template_directory_uri().'/assets/fonts/dashicons.css' );
	wp_enqueue_style( 'flounder-style', get_stylesheet_uri() );

	wp_enqueue_script( 'flounder-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'flounder-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'flounder-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'flounder_scripts' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );
