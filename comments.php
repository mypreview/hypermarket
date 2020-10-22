<?php
/**
 * The template for displaying comments.
 * This is the template that displays the area of the page that contains both 
 * the current comments and the comment form.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link        https://mypreview.github.io/hypermarket
 * @author      MyPreview
 * @since       2.0.0
 *
 * @package     hypermarket
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$hypermarket_comment_count = get_comments_number();
			if ( '1' === $hypermarket_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'hypermarket' ),
					sprintf( '<span>%s</span>', wp_kses_post( get_the_title() ) )
				);
			} else {
				printf( 
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $hypermarket_comment_count, 'comments title', 'hypermarket' ) ),
					number_format_i18n( $hypermarket_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					sprintf( '<span>%s</span>', wp_kses_post( get_the_title() ) )
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				apply_filters(
					'hypermarket_list_comments_args',
					array(
						'style'       => 'ol',
						'avatar_size' => 100,
						'short_ping'  => true,
					)
				) 
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'hypermarket' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->
