<?php
/**
 * Custom Header support
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Flounder
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Rework this function to remove WordPress 3.4 support when WordPress 3.6 is released.
 *
 * @uses flounder_header_style()
 * @uses flounder_admin_header_style()
 * @uses flounder_admin_header_image()
 *
 * @package Flounder
 */
function flounder_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'default-text-color'     => '2c3e50',
		'width'                  => 220,
		'height'                 => 220,
		'flex-height'            => false,
		'wp-head-callback'       => 'flounder_header_style',
		'admin-head-callback'    => 'flounder_admin_header_style',
		'admin-preview-callback' => 'flounder_admin_header_image',
	);

	$args = apply_filters( 'flounder_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}
}
add_action( 'after_setup_theme', 'flounder_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @todo Remove this function when WordPress 3.6 is released.
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Flounder
 */

if ( ! function_exists( 'get_custom_header' ) ) {
	function get_custom_header() {
		return (object) array(
			'url'           => get_header_image(),
			'thumbnail_url' => get_header_image(),
			'width'         => HEADER_IMAGE_WIDTH,
			'height'        => HEADER_IMAGE_HEIGHT,
		);
	}
}

if ( ! function_exists( 'flounder_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see flounder_custom_header_setup().
 */
function flounder_header_style() {
	$header_image = get_header_image();
	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() && empty( $header_image ) )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	<?php if ( ! empty( $header_image ) ) : ?>
		.site-branding:before {
			background-image: url('<?php echo esc_url( $header_image ); ?> ');
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // flounder_header_style

if ( ! function_exists( 'flounder_add_custom_header_class' ) ) :
function flounder_add_custom_header_class( $classes ) {
	$header_image = get_header_image();
	if ( ! empty( $header_image ) )
		$classes[] = 'custom-header';
	return $classes;
}
endif; // flounder_add_custom_header_class
add_filter( 'body_class', 'flounder_add_custom_header_class' );

if ( ! function_exists( 'flounder_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see flounder_custom_header_setup().
 */
function flounder_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
		position: relative;
		z-index: -1;
		background: #2c3e50;
	}
	.site-branding {
		position: relative;
		margin: 30px;
		height: 220px;
		width: 220px;
		line-height: 220px;
		text-align: center;
		border-radius: 110px;
		background-color: #ecf0f1;
	}
	.custom-header .site-branding {
		background-color: rgba(236, 240, 241, .5);
	}
	.custom-header .site-branding:before {
		content: "";
		display: block;
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		z-index: -1;
		background-size: contain;
		background-position: center;
		background-repeat: no-repeat;
		border-radius: 110px;
	}
	.site-title {
		font-weight: 200;
		font-size: 36px;
		line-height: 220px;
	}
	.site-title a {
		text-decoration: none;
	}
	</style>
<?php
}
endif; // flounder_admin_header_style

if ( ! function_exists( 'flounder_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see flounder_custom_header_setup().
 */
function flounder_admin_header_image() { ?>
	<?php
	if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() )
		$style = ' style="display:none;"';
	else
		$style = ' style="color:#' . get_header_textcolor() . ';"';
	$header_image = get_header_image();
	if ( ! empty( $header_image ) ) : ?>
	<style>
		.custom-header .site-branding:before {
			background-image: url('<?php echo esc_url( $header_image ); ?> ');
		}
	</style>
	<?php endif; ?>

	<div id="headimg" <?php if ( ! empty( $header_image ) ) echo 'class="custom-header"'; ?>>
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"<?php echo $style; ?> onclick="return false;" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		</div>
	</div>
<?php }
endif; // flounder_admin_header_image

