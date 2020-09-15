<?php
/**
 * Hypermarket template functions.
 *
 * @since       2.0.0
 * @package     hypermarket
 * @author      MyPreview (Github: @mahdiyazdani, @mypreview)
 */

if ( ! function_exists( 'hypermarket_display_comments' ) ) :
	/**
	 * Display comments
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_display_comments() {
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || 0 !== intval( get_comments_number() ) ) :
			comments_template();
		endif;
	}
endif;

if ( ! function_exists( 'hypermarket_footer_widgets' ) ) :
	/**
	 * Display the footer widget regions.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_footer_widgets() {
		$rows    = intval( apply_filters( 'hypermarket_footer_widget_rows', 1 ) );
		$regions = intval( apply_filters( 'hypermarket_footer_widget_columns', 3 ) );

		for ( $row = 1; $row <= $rows; $row++ ) :
			// Defines the number of active columns in this footer row.
			for ( $region = $regions; 0 < $region; $region-- ) {
				if ( is_active_sidebar( sprintf( 'footer-%d', esc_attr( $region + $regions * ( $row - 1 ) ) ) ) ) {
					$columns = $region;
					break;
				}
			}

			if ( isset( $columns ) ) :
				?>
				<div class=<?php echo '"footer-widgets row-' . esc_attr( $row ) . ' col-' . esc_attr( $columns ) . ' fix"'; ?>>
					<div class="col-full">
						<?php
						for ( $column = 1; $column <= $columns; $column++ ) :
							$footer_n = $column + $regions * ( $row - 1 );

							if ( is_active_sidebar( 'footer-' . esc_attr( $footer_n ) ) ) :
								?>
								<div class="block footer-widget-<?php echo esc_attr( $column ); ?>">
									<?php dynamic_sidebar( sprintf( 'footer-%d', esc_attr( $footer_n ) ) ); ?>
								</div>
								<?php
							endif;
						endfor;
						?>
					</div>
				</div><!-- .footer-widgets.row-<?php echo esc_attr( $row ); ?> -->
				<?php
				unset( $columns );
			endif;
		endfor;
	}
endif;

if ( ! function_exists( 'hypermarket_credit' ) ) :
	/**
	 * Display the theme credit.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_credit() {
		global $hypermarket;
		$links_output = '';

		if ( apply_filters( 'hypermarket_credit_link', true ) ) {
			//phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
			$links_output .= sprintf( '<a href="%s" target="_blank" title="%s" rel="author">%s</a>.', esc_url( $hypermarket->theme_uri ), esc_attr__( 'Proudly powered by WordPress', 'hypermarket' ), sprintf( esc_html__( 'Built with %s &amp; WooCommerce', 'hypermarket' ), $hypermarket->name ) );
		}

		if ( apply_filters( 'hypermarket_privacy_policy_link', true ) && function_exists( 'the_privacy_policy_link' ) ) {
			$separator    = '<span role="separator" aria-hidden="true"></span>';
			$links_output = get_the_privacy_policy_link( '', ( ! empty( $links_output ) ? $separator : '' ) ) . $links_output;
		}
		
		$links_output = apply_filters( 'hypermarket_credit_links_output', $links_output );
		
		?>
		<div class="site-info">
		<?php 
			echo esc_html( apply_filters( 'hypermarket_copyright_text', $content = sprintf( '&copy; %s %s', get_bloginfo( 'name' ), date( 'Y' ) ) ) );

		if ( ! empty( $links_output ) ) :
			?>
				<br />
				<?php
				echo wp_kses_post( $links_output ); 
			endif; 
		?>
		</div><!-- .site-info -->
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_get_sidebar' ) ) :
	/**
	 * Display default sidebar area.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_get_sidebar() {
		$region = hypermarket_is_blog_archive() ? 'blog' : null;
		get_sidebar( $region );
	}
endif;

if ( ! function_exists( 'hypermarket_site_branding' ) ) :
	/**
	 * Site branding wrapper and display
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_site_branding() {
		?>
		<div class="site-branding">
			<?php hypermarket_site_title_or_logo(); ?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_primary_menu' ) ) :
	/**
	 * Display primary menu.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_primary_menu() {
		?>
		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'hypermarket' ); ?>"  itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container'       => 'div',
					'container_class' => 'primary-navigation',
				)
			);
			?>
		</nav>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_skip_links' ) ) :
	/**
	 * Skip links
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_skip_links() {
		?>
		<a class="skip-link screen-reader-text" href="#site-navigation">
		<?php 
			esc_html_e( 'Skip to navigation', 'hypermarket' );
		?>
		</a>
		<a class="skip-link screen-reader-text" href="#content">
		<?php 
			esc_html_e( 'Skip to content', 'hypermarket' );
		?>
		</a>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_page_header' ) ) :
	/**
	 * Display the page header
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_page_header() {
		?>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
		</header>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_page_content' ) ) :
	/**
	 * Display the post content
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_page_content() {
		?>
		<div class="entry-content">
		<?php 
			the_content();
			wp_link_pages(
				array(
					/* translators: %s: open div */
					'before' => sprintf( esc_html__( '%sPages:', 'hypermarket' ), '<div class="page-links">' ),
					'after'  => '</div>',
				)
			);
		?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_post_header' ) ) :
	/**
	 * Display the post header with a link to the single post.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_post_header() {
		?>
		<header class="entry-header">
			<?php
			do_action( 'hypermarket_post_header_before' );

			if ( is_single() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			} else {
				the_title( sprintf( '<h2 class="alpha entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			}

			do_action( 'hypermarket_post_header_after' );
			?>
		</header>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_post_meta' ) ) :
	/**
	 * Display the post meta.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_post_meta() {
		if ( 'post' !== get_post_type() ) {
			return;
		}

		// Component classname.
		$classname = 'entry-meta';

		// Posted on.
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

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
		$comments        = '';
		$comments_before = '<span class="screen-reader-text">';
		$comments_after  = '</span>';

		if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
			/* translators: 1: Open span tag, 2: Close span tag. */
			$comments_number = get_comments_number_text( sprintf( esc_html__( '0%1$sLeave a comment%2$s', 'hypermarket' ), $comments_before, $comments_after ), sprintf( esc_html__( '1%1$sComment%2$s', 'hypermarket' ), $comments_before, $comments_after ), sprintf( esc_html__( '%%%1$sComments%2$s', 'hypermarket' ), $comments_before, $comments_after ) );

			$comments = sprintf(
				'<span class="post-comments"><a href="%1$s">%2$s</a></span>',
				esc_url( get_comments_link() ),
				$comments_number
			);
		}

		// Categories.
		// Output categories only if the current query is for an existing single post.
		$categories = is_single() ? hypermarket_post_categories() : '';

		echo wp_kses(
			sprintf( '<div class="%1$s"><div class="%1$s__col">%2$s %3$s</div><div class="%1$s__col">%4$s %5$s</div></div>', $classname, $author, $categories, $posted_on, $comments ),
			hypermarket_allowed_html()
		);
	}
endif;

if ( ! function_exists( 'hypermarket_post_excerpt' ) ) :
	/**
	 * Display the post excerpt.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_post_excerpt() {
		// Bail early on single post view.
		if ( is_single() ) {
			return;
		}
		?>
		<div class="entry-excerpt" itemprop="text">
			<?php the_excerpt(); ?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_post_content' ) ) :
	/**
	 * Display the post content with a link to the single post.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_post_content() {
		?>
		<div class="entry-content" itemprop="text">
			<?php
			do_action( 'hypermarket_post_content_before' );

			the_content(
				sprintf(
					/* translators: %s: post title */
					__( 'Continue reading %s', 'hypermarket' ),
					sprintf( '<span class="screen-reader-text">%s</span>', get_the_title() )
				)
			);

			do_action( 'hypermarket_post_content_after' );

			wp_link_pages(
				array(
					/* translators: %s: Open div tag. */
					'before' => sprintf( esc_html__( '%sPages:', 'hypermarket' ), '<div class="page-links">' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_post_footnote' ) ) :
	/**
	 * Display meta-data placed at the bottom of a post content.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_post_footnote() {
		global $post;
		
		$categories    = '';
		$share_buttons = '';
		$readmore      = '';
		$classname     = 'entry-footnote'; // Component classname.
		$post_id       = (int) $post->ID; // Retrieve the ID of the current item.
		$title         = get_the_title( $post_id ); // Retrieve post title.
		$tags          = hypermarket_post_tags();

		if ( hypermarket_is_blog_archive() ) {
			/* translators: 1: Open anchor tag, 2: Close anchor tag. */
			$readmore   = hypermarket_is_blog_archive() ? sprintf( esc_html__( '%1$sRead more%2$s', 'hypermarket' ), sprintf( '<div class="%s__col"><a href="%s" class="more-link">', $classname, esc_url( get_the_permalink( $post_id ) ) ), sprintf( '<span class="screen-reader-text">%s</span></a></div>', wp_kses_post( $title ) ) ) : '';
			$categories = hypermarket_post_categories(); // Output categories only if the current query is for the archive pages.
		} else {
			$permalink     = get_the_permalink( $post_id );
			$share_buttons = hypermarket_social_share_buttons( $permalink, $title );
		}

		echo wp_kses(
			sprintf( '<div class="%1$s"><div class="%1$s__col">%2$s %3$s</div><div class="%1$s__col">%4$s %5$s</div></div>', $classname, $categories, $tags, $readmore, $share_buttons ),
			hypermarket_allowed_html()
		);
	}
endif;

if ( ! function_exists( 'hypermarket_edit_post_link' ) ) :
	/**
	 * Display the edit link.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_edit_post_link() {
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'hypermarket' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<div class="edit-link">',
			'</div>'
		);
	}
endif;

if ( ! function_exists( 'hypermarket_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_paging_nav() {
		global $wp_query;
		
		$args = array(
			'type'      => 'list',
			/* translators: 1: Open span tag, 2: Close span tag. */
			'next_text' => sprintf( _x( '%1$sNext%2$s', 'Next post', 'hypermarket' ), '<span class="screen-reader-text">', '</span>' ),
			/* translators: 1: Open span tag, 2: Close span tag. */
			'prev_text' => sprintf( _x( '%1$sPrevious%2$s', 'Previous post', 'hypermarket' ), '<span class="screen-reader-text">', '</span>' ),
		);

		the_posts_pagination( $args );
	}
endif;

if ( ! function_exists( 'hypermarket_post_nav' ) ) :
	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @since    2.0.0
	 * @return  void
	 */
	function hypermarket_post_nav() {
		$args = array(
			/* translators: 1: Open span tag, 2: Close span tag. */
			'next_text' => sprintf( _x( '%1$sNext%2$s', 'Next post', 'hypermarket' ), '<span aria-label="%title">', ' </span>' ),
			/* translators: 1: Open span tag, 2: Close span tag. */
			'prev_text' => sprintf( _x( '%1$sPrev%2$s', 'Previous post', 'hypermarket' ), '<span aria-label="%title">', ' </span>' ),
		);

		the_post_navigation( $args );
	}
endif;

if ( ! function_exists( 'hypermarket_post_thumbnail' ) ) :
	/**
	 * Display post thumbnail.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_post_thumbnail() {
		// Determines whether the query is for an existing single post of any post type.
		if ( is_singular() ) : 
			?>

			<div class="entry-thumbnail" itemprop="ImageObject">
				<?php the_post_thumbnail( 'entry-thumbnail' ); ?>
			</div>

			<?php 
		else : 
			?>

			<a class="entry-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1" itemprop="ImageObject">
				<?php
				the_post_thumbnail(
					'entry-thumbnail',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</a>			
			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'hypermarket_div' ) ) :
	/**
	 * Open div.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_div() {
		?>
		<div class="div">
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_div_close' ) ) :
	/**
	 * Close div.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_div_close() {
		?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_container' ) ) :
	/**
	 * The container.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_container() {
		?>
		<div class="col-full">
		<?php
	}
endif;
