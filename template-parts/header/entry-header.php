<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage k_lite
 * @since K Lite 1.0
 */

$discussion = ! is_page() && klite_can_show_post_thumbnail() ? klite_get_discussion_data() : null; ?>

<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

<?php if ( ! is_page() ) : ?>
<div class="entry-meta">
	<?php klite_posted_by(); ?>
	<?php klite_posted_on(); ?>
	<span class="comment-count">
		<?php
		if ( ! empty( $discussion ) ) {
			klite_discussion_avatars_list( $discussion->authors );
		}
		?>
		<?php klite_comment_count(); ?>
	</span>
	<?php
		// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Post title. Only visible to screen readers. */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'klite' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">' . klite_get_icon_svg( 'edit', 16 ),
			'</span>'
		);
	?>
</div><!-- .entry-meta -->
<?php endif; ?>
