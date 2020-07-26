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
	 * @since   1.0.0
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
	 * @since   1.0.0
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
	 * @since   1.0.0
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
	 * @since   1.0.0
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
	 * @since   1.0.0
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

if ( ! function_exists( 'hypermarket_site_title_or_logo' ) ) :
	/**
	 * Display the site title or logo
	 *
	 * @since   1.0.0
	 * @param   bool $echo   Echo the string or return it.
	 * @return  string
	 */
	function hypermarket_site_title_or_logo( $echo = true ) {
		if ( has_custom_logo() ) {
			$logo = get_custom_logo();
			$html = is_home() ? sprintf( '<h1 class="logo">%s</h1>', $logo ) : $logo;
		} else {
			$tag  = is_home() ? 'h1' : 'div';
			$html = sprintf( '<%s class="beta site-title"><a href="%s" rel="home">%s</a></%s>', esc_attr( $tag ), esc_url( home_url( '/' ) ), esc_html( get_bloginfo( 'name' ) ), esc_attr( $tag ) );

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= sprintf( '<p class="site-description">%s</p>', esc_html( get_bloginfo( 'description', 'display' ) ) );
			}
		}

		if ( ! $echo ) {
			return $html;
		}

		echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'hypermarket_primary_menu' ) ) :
	/**
	 * Display primary menu.
	 *
	 * @since   1.0.0
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
		</nav><!-- #site-navigation -->
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_skip_links' ) ) :
	/**
	 * Skip links
	 *
	 * @since   1.0.0
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
	 * @since   1.0.0
	 * @return  void
	 */
	function hypermarket_page_header() {
		?>
		<header class="entry-header">
			<?php
			if ( ! is_singular( 'page' ) ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			}
			?>
		</header><!-- .entry-header -->
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_page_content' ) ) :
	/**
	 * Display the post content
	 *
	 * @since   1.0.0
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
					'before' => sprintf( __( '%sPages:', 'hypermarket' ), '<div class="page-links">' ),
					'after'  => '</div>',
				)
			);
		?>
		</div><!-- .entry-content -->
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_post_header' ) ) :
	/**
	 * Display the post header with a link to the single post.
	 *
	 * @since   1.0.0
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

			if ( 'post' === get_post_type() ) :
				?>
			<div class="entry-meta">
				<?php
					/**
					 * Functions hooked in to `hypermarket_post_meta` action.
					 *
					 * @hooked  hypermarket_post_meta           - 10
					 * @hooked  hypermarket_post_taxonomy       - 20
					 */
					do_action( 'hypermarket_post_meta' );
				?>
			</div>
				<?php
				/**
				 * Functions hooked in to `hypermarket_post_header_after` action.
				 *
				 * @hooked  hypermarket_post_excerpt        - 10
				 */
				do_action( 'hypermarket_post_header_after' );
			endif;
			?>
		</header><!-- .entry-header -->
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_post_excerpt' ) ) :
	/**
	 * Display the post excerpt.
	 *
	 * @since   1.0.0
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
		</div><!-- .entry-excerpt -->
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_post_content' ) ) :
	/**
	 * Display the post content with a link to the single post.
	 *
	 * @since   1.0.0
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
					'<span class="screen-reader-text">' . get_the_title() . '</span>'
				)
			);

			do_action( 'hypermarket_post_content_after' );

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'hypermarket' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_post_meta' ) ) :
	/**
	 * Display the post meta.
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	function hypermarket_post_meta() {
		// Posted on.
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$output_time_string = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );
		$posted_on          = '
			<span class="posted-on">' .
			/* translators: 1: Open span tag, 2: Close span tag, 3: Output time. */
			sprintf( esc_html__( '%1$sPosted on%2$s %3$s', 'hypermarket' ), '<span class="screen-reader-text">', '</span>', $output_time_string ) .
			'</span>';

		echo wp_kses(
			$posted_on,
			array(
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
endif;

if ( ! function_exists( 'hypermarket_edit_post_link' ) ) :
	/**
	 * Display the edit link.
	 *
	 * @since   1.0.0
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

if ( ! function_exists( 'hypermarket_post_taxonomy' ) ) :
	/**
	 * Display the post taxonomies.
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function hypermarket_post_taxonomy() {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'hypermarket' ) );
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'hypermarket' ) );
		
		?>
		<aside class="entry-taxonomy">
		<?php
		if ( $categories_list ) :
			?>
				<div class="cat-links">
				<?php
				/* translators: 1: Open span tag, 2: Close span tag. */
				printf( _n( '%1$sCategory:%2$s', '%1$sCategories:%2$s', count( get_the_category() ), 'hypermarket' ), '<span class="screen-reader-text">', '</span>' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo wp_kses_post( $categories_list ); 
				?>
				</div>
				<?php
			endif;

		if ( $tags_list ) :
			?>
				<div class="tags-links screen-reader-text">
				<?php 
				/* translators: 1: Open span tag, 2: Close span tag. */
				printf( _n( '%1$sTag:%2$s', '%1$sTags:%2$s', count( get_the_tags() ), 'hypermarket' ), '<span class="screen-reader-text">', '</span>' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo wp_kses_post( $tags_list ); 
				?>
				</div>
				<?php 
			endif;
		?>
		</aside>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function hypermarket_paging_nav() {
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
	 * @since    1.0.0
	 * @return  void
	 */
	function hypermarket_post_nav() {
		$args = array(
			/* translators: 1: Open span tag, 2: Close span tag. */
			'next_text' => sprintf( _x( '%1$sNext post:%2$s', 'Next post', 'hypermarket' ), '<span class="screen-reader-text">', ' </span>%title' ),
			/* translators: 1: Open span tag, 2: Close span tag. */
			'prev_text' => sprintf( _x( '%1$sPrevious post:%2$s', 'Previous post', 'hypermarket' ), '<span class="screen-reader-text">', ' </span>%title' ),
		);

		the_post_navigation( $args );
	}
endif;

if ( ! function_exists( 'hypermarket_post_thumbnail' ) ) :
	/**
	 * Display post thumbnail.
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function hypermarket_post_thumbnail() {
		// Determines whether the query is for an existing single post of any post type.
		if ( is_singular() ) : 
			?>

			<div class="post-thumbnail" itemprop="ImageObject">
				<?php the_post_thumbnail( 'post-thumbnail' ); ?>
			</div><!-- .post-thumbnail -->

			<?php 
		else : 
			?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1" itemprop="ImageObject">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
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
	 * @since   1.0.0
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
	 * @since   1.0.0
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
	 * @since   1.0.0
	 * @return  void
	 */
	function hypermarket_container() {
		?>
		<div class="col-full">
		<?php
	}
endif;
