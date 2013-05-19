<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to flounder_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Flounder
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

	<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<i class="icon dashicons dashicons-admin-comments"></i> <?php
				printf( 
					_nx( 'Read 1 comment', 'Read %1$s comments', get_comments_number(), 'comments title', 'flounder' ),
					number_format_i18n( get_comments_number() ) 
				);
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="navigation-comment" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'flounder' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'flounder' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'flounder' ) ); ?></div>
		</nav><!-- #comment-nav-before -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use flounder_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define flounder_comment() and that will be used instead.
				 * See flounder_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 'callback' => 'flounder_comment' ) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation-comment" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'flounder' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'flounder' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'flounder' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<h2 class="no-comments"><i class="icon no-bg dashicons dashicons-xit"></i><?php _e( 'Comments are closed.', 'flounder' ); ?></h2>
	<?php endif; ?>

	<?php comment_form( array(
		// 'fields' => taken care of by flounder_comment_fields in extras.php
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'title_reply' => '<i class="icon dashicons dashicons-plus-big"></i>'.__( 'Leave a Reply' ),
		'title_reply_to' => '<i class="icon dashicons dashicons-plus-big"></i>'.__( 'Leave a Reply to %s' ),
		'comment_field' => '<p class="comment-form-comment clearfix"><label class="screen-reader-text" for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="3" aria-required="true" placeholder="'. __( 'Enter your comment here&hellip;', 'flounder' ) .'"></textarea></p>',
	) ); ?>

</div><!-- #comments -->
