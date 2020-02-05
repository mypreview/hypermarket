<?php
/**
 * Hypermarket template functions.
 *
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

/**
 * Display comments
 *
 * @return 	void
 */
function hypermarket_display_comments() {
	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || 0 !== intval( get_comments_number() ) ) :
		comments_template();
	endif;
}

/**
 * Comment template
 *
 * @param 	array 	$comment 	The comment array.
 * @param 	array 	$args 		The comment args.
 * @param 	int   	$depth 		The comment depth.
 * @return 	void
 */
function hypermarket_comment( $comment, $args, $depth ) {
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	} // End If Statement
	?><<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment-body">
			<div class="comment-meta commentmetadata">
				<div class="comment-author vcard"><?php 
					echo get_avatar( $comment, 128 );
					printf( wp_kses_post( '<cite class="fn">%s</cite>', 'hypermarket' ), get_comment_author_link() ); 
				?></div><?php 
				if ( '0' === $comment->comment_approved ) : 
					?><em class="comment-awaiting-moderation"><?php 
						esc_attr_e( 'Your comment is awaiting moderation.', 'hypermarket' );
					?></em>
					<br /><?php 
				endif; 
				?><a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>" class="comment-date"><?php 
					printf( '<time datetime="%s">%s</time>', get_comment_date( 'c' ), get_comment_date() ); ?>
				</a>
			</div><!-- .comment-meta --><?php 
			if ( 'div' !== $args['style'] ) : 
				?><div id="div-comment-<?php comment_ID(); ?>" class="comment-content"><?php 
			endif; 
			?><div class="comment-text"><?php 
				comment_text(); 
			?></div><!-- .comment-text -->
			<div class="reply"><?php
				comment_reply_link(
					array_merge(
						$args, array(
							'add_below' => $add_below,
							'depth'     => $depth,
							'max_depth' => $args['max_depth']
						)
					)
				);
			edit_comment_link( __( 'Edit', 'hypermarket' ), '  ', '' );
			?></div><!-- .reply -->
		</div><?php 
		if ( 'div' !== $args['style'] ) : 
	?></div><?php 
	endif;
}

/**
 * Display the footer widget regions.
 *
 * @return 	void
 */
function hypermarket_footer_widgets() {
	$rows    = intval( apply_filters( 'hypermarket_footer_widget_rows', 2 ) );
	$regions = intval( apply_filters( 'hypermarket_footer_widget_columns', 3 ) );

	for ( $row = 1; $row <= $rows; $row++ ) :
		// Defines the number of active columns in this footer row.
		for ( $region = $regions; 0 < $region; $region-- ) {
			if ( is_active_sidebar( sprintf( 'footer-%d', esc_attr( $region + $regions * ( $row - 1 ) ) ) ) ) {
				$columns = $region;
				break;
			} // End If Statement
		} // End of the loop.

		if ( isset( $columns ) ) :
			?><div class=<?php echo '"footer-widgets row-' . esc_attr( $row ) . ' col-' . esc_attr( $columns ) . ' fix"'; ?>><?php
				for ( $column = 1; $column <= $columns; $column++ ) :
					$footer_n = $column + $regions * ( $row - 1 );

					if ( is_active_sidebar( 'footer-' . esc_attr( $footer_n ) ) ) :
						?><div class="block footer-widget-<?php echo esc_attr( $column ); ?>">
							<?php dynamic_sidebar( sprintf( 'footer-%d', esc_attr( $footer_n ) ) ); ?>
						</div><?php
					endif; // End If Statement
				endfor; // End of the loop.
			?></div><!-- .footer-widgets.row-<?php echo esc_attr( $row ); ?> --><?php
			unset( $columns );
		endif; // End If Statement
	endfor; // End of the loop.
}