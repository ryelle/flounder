<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Flounder
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-area">
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'flounder' ),
					'after'  => '</div>',
				) );
			?>
			<?php edit_post_link( __('Edit This'), '<p class"edit-link">', '</p>' ); ?> 
		</div><!-- .entry-content -->
		
		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template();
		?>
		
	</div>
	<div class="entry-meta sidebar-bg"></div>
</article><!-- #post-## -->
