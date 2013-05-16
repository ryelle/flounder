<?php
/**
 * @package Flounder
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-area">
		<header class="entry-header entry-meta">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'flounder' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
				<?php flounder_posted_on(); ?>
			</a>
			<?php flounder_posted_by(); ?>
		</header><!-- .entry-header -->
	
		<div class="entry-content">
			<p class="entry-link"><a href="<?php the_post_format_url(); ?>" rel="bookmark"><?php the_title(); ?></a></p>
			<?php the_remaining_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'flounder' ) ); ?>
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
			flounder_comment_link( '<div class="comment-links">', '</div>' ); 
		} ?>

	</div><!-- .entry-area -->

	<div class="entry-meta sidebar-bg"></div>
	<footer class="entry-meta">
		<i class="icon format-icon dashicons dashicons-format-<?php echo ( ''==get_post_format() )? 'standard': get_post_format(); ?>"></i>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
