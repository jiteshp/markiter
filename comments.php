<?php
/**
 * Comments template
 *
 * The default template used by the theme to display a post or page comments.
 *
 * @package markiter
 */

?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$markiter_comment_count = get_comments_number();
			if ( '1' === $markiter_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'markiter' ),
					'<span>' . get_the_title() . '</span>' /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $markiter_comment_count, 'comments title', 'markiter' ) ),
					number_format_i18n( $markiter_comment_count )  /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */,
					'<span>' . get_the_title() . '</span>' /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 65,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'markiter' ); ?></p>
			<?php
		endif;
	endif; // Check for have_comments().
	comment_form();
	?>

</div><!-- #comments -->
