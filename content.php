<?php
/**
 * @package Flounder
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-area">
		<?php if ( flounder_show_title() ) : ?>

		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</header><!-- .entry-header -->

		<?php else: ?>

		<header class="entry-header clearfix entry-meta">
			<?php flounder_posted_on(); ?>
			<?php flounder_posted_by(); ?>
			<?php edit_post_link( __('Edit This'), '<div class="meta edit-link">', '</div>' ); ?> 
		</header><!-- .entry-header -->

		<?php endif; ?>
	
		<div class="entry-content">
			<?php if ( has_post_thumbnail() ): ?>
				<div class="entry-image"><?php
					the_post_thumbnail( 'feature' ); 

					$thumb_id = get_post_thumbnail_id();
					$thumb_post = get_post( $thumb_id );
					if ( $thumb_post && $thumb_post->post_excerpt )
						printf( '<div class="wp-caption-text">%s</div>', $thumb_post->post_excerpt );
				?></div>
			<?php endif; ?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'flounder' ) ); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'flounder' ),
					'after'  => '</div>',
				) );
			?>
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
		<?php if ( flounder_show_title() ) : // If we show the title, we need to put meta here. ?>
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

			<?php edit_post_link( __('Edit This'), '<div class="meta edit-link">', '</div>' ); ?> 
		<?php endif; // End if flounder_show_title ?>
	
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
