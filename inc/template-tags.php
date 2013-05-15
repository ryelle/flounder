<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Flounder
 */

if ( ! function_exists( 'flounder_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function flounder_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'flounder' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<i class="icon inline  dashicons dashicons-arr-left"></i> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <i class="icon inline dashicons dashicons-arr-right"></i>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<i class="icon inline dashicons dashicons-arr-left"></i> Older posts', 'flounder' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <i class="icon inline dashicons dashicons-arr-right"></i>', 'flounder' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // flounder_content_nav

if ( ! function_exists( 'flounder_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function flounder_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'flounder' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'flounder' ), '<span class="edit-link">', '<span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-avatar">
				<?php echo get_avatar( $comment, 65 ); ?>
			</div><!-- .comment-avatar -->
			<div class="comment-content"><?php comment_text(); ?></div>
			<footer>
				<div class="comment-author vcard">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php 
					// Older than a week, show date; otherwise show __ time ago.
					if ( current_time('timestamp') - get_comment_time( 'U' ) > 604800 )
						$time = sprintf( _x( '%1$s at %2$s', '1: date, 2: time', 'flounder' ), get_comment_date(), get_comment_time() );
					else
						$time = sprintf( __( '%1$s ago', 'flounder' ), human_time_diff( get_comment_time( 'U' ), current_time('timestamp') ) );
					printf( __( 'posted %1$s by %2$s', 'flounder' ), 
						'<time datetime="'. get_comment_time( 'c' ) .'">'. $time .'</time>',
						sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) 
					); ?>
					</a>
					<?php
						if ( $comment->comment_parent ) {
							printf ( 
								'<a href="%1$s">%2$s</a>',
								esc_url( get_comment_link( $comment->comment_parent ) ),
								sprintf( __( 'in reply to %s', 'flounder' ), get_comment_author( $comment->comment_parent ) )
							);
						}
						comment_reply_link( array_merge( $args, array(
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="alignright">',
							'after'     => '</span>',
						) ) );
					?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'flounder' ); ?></em>
				<?php endif; ?>
			</footer>
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for flounder_comment()

if ( ! function_exists( 'flounder_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function flounder_posted_on() {
	printf( '<time class="entry-date meta" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'n/d/y' ) )
	);
}
endif;

if ( ! function_exists( 'flounder_posted_by' ) ) :
function flounder_posted_by() {
	printf( '<div class="author meta vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></div>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'flounder' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;

if ( ! function_exists( 'flounder_comment_link' ) ) :
function flounder_comment_link( $before = '', $after = '', $echo = true ) {
	if ( ! comments_open() ) return;
	ob_start();
	if ( ! empty( $before ) )
		echo $before;
	comments_popup_link( '<i class="icon dashicons dashicons-admin-comments"></i>'.__( 'No comments', 'flounder' ), '<i class="icon dashicons dashicons-admin-comments"></i>'.__( 'Read 1 Comment', 'flounder' ), '<i class="icon dashicons dashicons-admin-comments"></i>'.__( 'Read % Comments', 'flounder' ), 'read alignleft', '' );
	echo '<a href="#" class="add alignright"><i class="icon dashicons dashicons-plus-big"></i>Add a comment</a>';
	if ( ! empty( $after ) )
		echo $after;
	if ( $echo ) 
		ob_end_flush();
	else 
		return ob_end_clean();
}
endif;

function flounder_show_title() {
	$show_title = ( ! post_type_supports( get_post_type(), 'post-formats' ) ) || ! (
		has_post_format( 'link' ) ||
		has_post_format( 'quote' ) ||
		has_post_format( 'aside' ) ||
		has_post_format( 'status' )
	);
	
	return apply_filters( 'flounder_show_title', $show_title );
}




