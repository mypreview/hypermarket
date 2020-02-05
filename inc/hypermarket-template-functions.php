<?php
/**
 * Hypermarket template functions.
 *
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

if ( ! function_exists( 'hypermarket_display_comments' ) ) :
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
endif;

if ( ! function_exists( 'hypermarket_comment' ) ) :
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
endif;

if ( ! function_exists( 'hypermarket_footer_widgets' ) ) :
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
endif;

if ( ! function_exists( 'hypermarket_credit' ) ) :
	/**
	 * Display the theme credit.
	 *
	 * @return 	void
	 */
	function hypermarket_credit() {
		$links_output = '';

		if ( apply_filters( 'hypermarket_credit_link', true ) ) {
			$links_output .= sprintf( '<a href="%s" target="_blank" title="%s" rel="author">%s</a>.', esc_url( HYPERMARKET_THEME_URI ), esc_attr__( 'Proudly powered by WordPress', 'hypermarket' ), sprintf( esc_html__( 'Built with %s &amp; WooCommerce', 'hypermarket' ), HYPERMARKET_THEME_NAME ) );
		} // End If Statement

		if ( apply_filters( 'hypermarket_privacy_policy_link', true ) && function_exists( 'the_privacy_policy_link' ) ) {
			$separator = '<span role="separator" aria-hidden="true"></span>';
			$links_output = get_the_privacy_policy_link( '', ( ! empty( $links_output ) ? $separator : '' ) ) . $links_output;
		} // End If Statement
		
		$links_output = apply_filters( 'hypermarket_credit_links_output', $links_output );
		
		?><div class="site-info"><?php 
			echo esc_html( apply_filters( 'hypermarket_copyright_text', $content = sprintf( '&copy; %s %s', get_bloginfo( 'name' ), date( 'Y' ) ) ) );

			if ( ! empty( $links_output ) ) :
				?><br /><?php
				echo wp_kses_post( $links_output ); // WPCS: XSS ok.
			endif; 
		?></div><!-- .site-info --><?php
	}
endif;

if ( ! function_exists( 'hypermarket_site_branding' ) ) :
	/**
	 * Site branding wrapper and display
	 *
	 * @return 	void
	 */
	function hypermarket_site_branding() {
		?><div class="site-branding"><?php 
			hypermarket_site_title_or_logo(); 
		?></div><?php
	}
endif;

if ( ! function_exists( 'hypermarket_site_title_or_logo' ) ) :
	/**
	 * Display the site title or logo
	 *
	 * @param 	bool 		$echo 	Echo the string or return it.
	 * @return 	string
	 */
	function hypermarket_site_title_or_logo( $echo = true ) {
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$logo = get_custom_logo();
			$html = is_home() ? sprintf( '<h1 class="logo">%s</h1>', $logo ) : $logo;
		} else {
			$tag  = is_home() ? 'h1' : 'div';
			$html = sprintf( '<%s class="beta site-title"><a href="%s" rel="home">%s</a></%s>', esc_attr( $tag ), esc_url( home_url( '/' ) ), esc_html( get_bloginfo( 'name' ) ), esc_attr( $tag ) );

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= sprintf( '<p class="site-description">%s</p>', esc_html( get_bloginfo( 'description', 'display' ) ) );
			} // End If Statement
		} // End If Statement

		if ( ! $echo ) {
			return $html;
		} // End If Statement

		echo $html; // WPCS: XSS ok.
	}
endif;

if ( ! function_exists( 'hypermarket_primary_navigation' ) ) {
	/**
	 * Display primary navigation.
	 *
	 * @return 	void
	 */
	function hypermarket_primary_navigation() {
		?><nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'hypermarket' ); ?>">
			<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false">
				<span><?php 
					echo esc_attr( apply_filters( 
						'hypermarket_menu_toggle_text', __( 'Menu', 'hypermarket' ) 
					) );  // WPCS: XSS ok.
				?></span>
			</button><?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container_class' => 'primary-navigation'
				)
			);
			wp_nav_menu(
				array(
					'theme_location'  => 'handheld',
					'container_class' => 'handheld-navigation'
				)
			);
		?></nav><!-- #site-navigation --><?php
	}
}

if ( ! function_exists( 'hypermarket_skip_links' ) ) {
	/**
	 * Skip links
	 *
	 * @return 	void
	 */
	function hypermarket_skip_links() {
		?><a class="skip-link screen-reader-text" href="#site-navigation"><?php 
			esc_html_e( 'Skip to navigation', 'hypermarket' );
		?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php 
			esc_html_e( 'Skip to content', 'hypermarket' );
		?></a><?php
	}
}

if ( ! function_exists( 'hypermarket_page_header' ) ) {
	/**
	 * Display the page header
	 *
	 * @return 	void
	 */
	function hypermarket_page_header() {
		if ( is_front_page() && hypermarket_is_fluid_template() ) {
			return;
		} // End If Statement

		?><header class="entry-header"><?php
			hypermarket_post_thumbnail( 'full' );
			the_title( '<h1 class="entry-title">', '</h1>' );
		?></header><!-- .entry-header --><?php
	}
}

if ( ! function_exists( 'hypermarket_page_content' ) ) {
	/**
	 * Display the post content
	 *
	 * @return 	void
	 */
	function hypermarket_page_content() {
		?><div class="entry-content"><?php 
			the_content();
			wp_link_pages(
				array(
					/* translators: %s: open div */
					'before' => sprintf( __( '%sPages:', 'hypermarket' ), '<div class="page-links">' ),
					'after'  => '</div>'
				)
			);
		?></div><!-- .entry-content --><?php
	}
}

if ( ! function_exists( 'hypermarket_post_meta' ) ) {
	/**
	 * Display the post meta
	 *
	 * @return 	void
	 */
	function hypermarket_post_meta() {
		if ( 'post' !== get_post_type() ) {
			return;
		} // End If Statement

		// Posted on.
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		} // End If Statement

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$output_time_string = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );
		$posted_on = '
			<span class="posted-on">' .
			/* translators: %s: post date */
			sprintf( __( 'Posted on %s', 'hypermarket' ), $output_time_string ) .
			'</span>';

		// Author.
		$author = sprintf(
			'<span class="post-author">%1$s <a href="%2$s" class="url fn" rel="author">%3$s</a></span>',
			__( 'by', 'hypermarket' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);

		// Comments.
		$comments = '';

		if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
			$comments_number = get_comments_number_text( __( 'Leave a comment', 'hypermarket' ), __( '1 Comment', 'hypermarket' ), __( '% Comments', 'hypermarket' ) );
			$comments = sprintf(
				'<span class="post-comments">&mdash; <a href="%1$s">%2$s</a></span>',
				esc_url( get_comments_link() ),
				$comments_number
			);
		} // End If Statement

		echo wp_kses(
			sprintf( '%1$s %2$s %3$s', $posted_on, $author, $comments ), array(
				'span' => array(
					'class' => array(),
				),
				'a'    => array(
					'href'  => array(),
					'title' => array(),
					'rel'   => array(),
				),
				'time' => array(
					'datetime' => array(),
					'class'    => array(),
				),
			)
		);
	}
}