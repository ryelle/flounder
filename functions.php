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
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'audio', 'video', 'quote', 'link', 'status' )  );

	/**
	 * Add an image size that does not exceed content width
	 */
	add_image_size( 'feature', 500 );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
	 */
	add_editor_style();
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
	wp_enqueue_style( 'icons', get_template_directory_uri().'/assets/fonts/dashicons.css' );
	wp_enqueue_style( 'flounder-style', get_stylesheet_uri() );

	wp_enqueue_script( 'flounder-js', get_template_directory_uri() . '/js/flounder.js', array( 'jquery' ), null, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'flounder-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'flounder_scripts' );


/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Flounder 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function flounder_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'flounder' );

	if ( 'off' !== $source_sans_pro ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source+Sans+Pro:200,400,600,200italic,400italic,600italic';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => 'latin,latin-ext',
		);
		$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Loads our special font CSS file.
 *
 * To disable in a child theme, use wp_dequeue_style()
 * function mytheme_dequeue_fonts() {
 *     wp_dequeue_style( 'flounder-fonts' );
 * }
 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
 *
 * @since Flounder 1.0
 *
 * @return void
 */
function flounder_fonts() {
	$fonts_url = flounder_fonts_url();
	if ( ! empty( $fonts_url ) )
		wp_enqueue_style( 'flounder-fonts', esc_url_raw( $fonts_url ), array(), null );
}
add_action( 'wp_enqueue_scripts', 'flounder_fonts' );

/**
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses flounder_fonts_url() to get the Google Font stylesheet URL.
 *
 * @since Flounder 1.0
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string
 */
function flounder_mce_css( $mce_css ) {
	$fonts_url = flounder_fonts_url();

	if ( empty( $fonts_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $fonts_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'flounder_mce_css' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );
