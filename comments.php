<?php
/**
 * The template for displaying comments.
 * This is the template that displays the area of the page that contains both 
 * the current comments and the comment form.
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
} // End If Statement

?><section id="comments" class="comments-area" aria-label="<?php esc_html_e( 'Post Comments', 'hypermarket' ); ?>"><?php

	if ( have_comments() ) :

		?><h2 class="comments-title"><?php

			printf( // WPCS: XSS OK.
				/* translators: 1: number of comments, 2: post title */
				esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'hypermarket' ) ),
				number_format_i18n( get_comments_number() ),
				sprintf( '<span>%s</span>', get_the_title() )
			);

		?></h2><?php 

		// Check for comment navigation.
		the_comments_navigation();

		?><ol class="comment-list"><?php
			wp_list_comments(
				apply_filters( 
						'hypermarket_list_comments_args', array(
						'style'       => 'ol',
						'avatar_size' => 100,
						'short_ping'  => true,
						'callback'    => 'hypermarket_comment'
					) 
				)
			);
		?></ol><!-- .comment-list --><?php 

		// Check for comment navigation.
		the_comments_navigation();

	endif;

	if ( ! comments_open() && 0 !== intval( get_comments_number() ) && post_type_supports( get_post_type(), 'comments' ) ) :
		
		?><p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'hypermarket' ); ?></p><?php

	endif;

	$args = apply_filters(
		'hypermarket_comment_form_args', array(
			'title_reply_before' => '<span id="reply-title" class="gamma comment-reply-title">',
			'title_reply_after'  => '</span>',
		)
	);

	comment_form( $args );

?></section><!-- #comments -->