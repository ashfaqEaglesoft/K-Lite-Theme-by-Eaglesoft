<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage k_lite
 * @since K Lite 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}

$discussion = klite_get_discussion_data();
?>

<div id="comments" class="<?php echo comments_open() ? 'comments-area' : 'comments-area comments-closed'; ?>">
	<div class="<?php echo $discussion->responses > 0 ? 'comments-title-wrap' : 'comments-title-wrap no-responses'; ?>">
		<h2 class="comments-title">
		<?php
		if ( comments_open() ) {
			if ( have_comments() ) {
				_e( 'Join the Conversation', 'klite' );
			} else {
				_e( 'Leave a comment', 'klite' );
			}
		} else {
			if ( '1' == $discussion->responses ) {
				/* translators: %s: Post title. */
				printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'klite' ), get_the_title() );
			} else {
				printf(
					/* translators: 1: Number of comments, 2: Post title. */
					_nx(
						'%1$s reply on &ldquo;%2$s&rdquo;',
						'%1$s replies on &ldquo;%2$s&rdquo;',
						$discussion->responses,
						'comments title',
						'klite'
					),
					number_format_i18n( $discussion->responses ),
					get_the_title()
				);
			}
		}
		?>
		</h2><!-- .comments-title -->
		<?php
		// Only show discussion meta information when comments are open and available.
		if ( have_comments() && comments_open() ) {
			get_template_part( 'template-parts/post/discussion', 'meta' );
		}
		?>
	</div><!-- .comments-title-flex -->
	<?php
	if ( have_comments() ) :

		// Show comment form at top if showing newest comments at the top.
		if ( comments_open() ) {
			klite_comment_form( 'desc' );
		}

		?>
		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'walker'      => new KLite_Walker_Comment(),
					'avatar_size' => klite_get_avatar_size(),
					'short_ping'  => true,
					'style'       => 'ol',
				)
			);
			?>
		</ol><!-- .comment-list -->
		<?php

		// Show comment navigation.
		if ( have_comments() ) :
			$prev_icon     = klite_get_icon_svg( 'chevron_left', 22 );
			$next_icon     = klite_get_icon_svg( 'chevron_right', 22 );
			$comments_text = __( 'Comments', 'klite' );
			the_comments_navigation(
				array(
					'prev_text' => sprintf( '%s <span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', $prev_icon, __( 'Previous', 'klite' ), __( 'Comments', 'klite' ) ),
					'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span> %s', __( 'Next', 'klite' ), __( 'Comments', 'klite' ), $next_icon ),
				)
			);
		endif;

		// Show comment form at bottom if showing newest comments at the bottom.
		if ( comments_open() && 'asc' === strtolower( get_option( 'comment_order', 'asc' ) ) ) :
			?>
			<div class="comment-form-flex">
				<span class="screen-reader-text"><?php _e( 'Leave a comment', 'klite' ); ?></span>
				<?php klite_comment_form( 'asc' ); ?>
				<h2 class="comments-title" aria-hidden="true"><?php _e( 'Leave a comment', 'klite' ); ?></h2>
			</div>
			<?php
		endif;

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments">
				<?php _e( 'Comments are closed.', 'klite' ); ?>
			</p>
			<?php
		endif;

	else :

		// Show comment form.
		klite_comment_form( true );

	endif; // if have_comments();
	?>
</div><!-- #comments -->
