<?php
/**
 * @package Flounder
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-area">
		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'flounder' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</header><!-- .entry-header -->
	
		<div class="entry-content">
			<div class="entry-format-video"><?php the_post_format_video(); ?></div>
			<?php if ( is_singular() ) : ?>
			<?php the_remaining_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'flounder' ) ); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'flounder' ),
					'after'  => '</div>',
				) );
			?>
			<?php endif; ?>
		</div><!-- .entry-content -->

		<?php if ( is_singular() ) {
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template();
		} else {
			flounder_comment_link( '<div class="comment-links clearfix">', '</div>' ); 
		} ?>

	</div><!-- .entry-area -->

	<div class="entry-meta sidebar-bg"></div>
	<footer class="entry-meta">
		<i class="icon format-icon dashicons dashicons-format-<?php echo ( ''==get_post_format() )? 'standard': get_post_format(); ?>"></i>
		<?php flounder_posted_on(); ?>
		<?php flounder_posted_by(); ?>
		<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'flounder' ) );
			if ( $categories_list ) :
		?>
		<div class="meta cat-links">
			<?php echo $categories_list; ?>
		</div>
		<?php endif; // End if categories ?>

		<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'flounder' ) );
			if ( $tags_list ) :
		?>
		<div class="meta tags-links">
			<?php echo $tags_list; ?>
		</div>
		<?php endif; // End if $tags_list ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
