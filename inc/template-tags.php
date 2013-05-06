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

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'flounder' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'flounder' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'flounder' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'flounder' ) ); ?></div>
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
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'flounder' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'flounder' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
					<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'flounder' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( 'Edit', 'flounder' ), '<span class="edit-link">', '<span>' ); ?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
			<?php
				comment_reply_link( array_merge( $args,array(
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
				) ) );
			?>
			</div><!-- .reply -->
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
	comments_popup_link( '<i class="icon no-bg"></i>'.__( 'No comments', 'flounder' ), '<i class="icon no-bg"></i>'.__( 'Read 1 Comment', 'flounder' ), '<i class="icon no-bg"></i>'.__( 'Read % Comments', 'flounder' ), 'read alignleft', '' );
	echo '<a href="#" class="add alignright"><i class="icon"></i>Add a comment</a>';
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




