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
		$has_widgets = false;
		$regions     = intval( apply_filters( 'hypermarket_footer_widget_regions', 3 ) );
		
		for ( $region = 1; $region <= $regions; $region++ ) :
			$footer_n = $region + $regions;
			$footer   = sprintf( 'footer-%d', $footer_n );

			if ( is_active_sidebar( $footer ) ) :
				?>
				<div class="site-footer__widgets">
					<?php 
					do_action( 'hypermarket_before_footer_widget_region' );
					
					dynamic_sidebar( $footer ); 

					do_action( 'hypermarket_after_footer_widget_region' );
					?>
				</div>
				<?php
				$has_widgets = ! $has_widgets;
			endif;
		endfor;

		// Run this action if all widget regions are empty!
		if ( ! $has_widgets ) {
			do_action( 'hypermarket_no_footer_widget_region' );
		}
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
		// Bail early, in case the copyright is already being outputted.
		if ( did_action( 'hypermarket_before_footer_widget_region' ) > 1 ) {
			return;
		}

		global $hypermarket;
		$return = '';

		if ( apply_filters( 'hypermarket_credit_link', true ) ) {
			// phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
			$return .= sprintf( '<a href="%s" target="_blank" title="%s" rel="author" rel="noopener noreferrer nofollow">%s</a>.', esc_url( $hypermarket->theme_uri ), esc_attr__( 'Proudly powered by WordPress', 'hypermarket' ), sprintf( esc_html__( '&copy; %1$s. Made with %2$s by %3$s', 'hypermarket' ), date_i18n( 'Y' ), '❤', $hypermarket->name ) );
		}

		$return = apply_filters( 'hypermarket_credit_links_output', $return );
		
		?>
		<div class="site-info">
		<?php 
		if ( ! empty( $return ) ) {
			echo wp_kses_post( $return ); 
		}
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
		get_sidebar( 'sidebar-1' );
	}
endif;

if ( ! function_exists( 'hypermarket_get_footer_bar' ) ) :
	/**
	 * Display the "Footer-bar" widget region.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_get_footer_bar() {
		get_sidebar( 'footer-bar' );
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

if ( ! function_exists( 'hypermarket_handheld_menu' ) ) :
	/**
	 * Display handheld (mobile) menu.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_handheld_menu() {
		if ( has_nav_menu( 'handheld' ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'handheld',
					'container'       => 'div',
					'container_class' => 'site-handheld-menu',
					'items_wrap'      => '%3$s',
					'menu_id'         => '',
					'menu_class'      => '',
					'fallback_cb'     => '',
				) 
			);
		}
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

if ( ! function_exists( 'hypermarket_notfound_header' ) ) :
	/**
	 * Display the not-found (404) header.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_notfound_header() {
		?>
		<header class="entry-header">
			<?php 
			do_action( 'hypermarket_notfound_header_before' );
			
			/* translators: 1: Open h1 tag, 2: Close h1 tag. */
			printf( esc_html__( '%1$sOops! That page can&rsquo;t be found.%2$s', 'hypermarket' ), '<h1 class="entry-title" itemprop="headline">', '</h1>' );

			/**
			 * Functions hooked into `hypermarket_notfound_header_after` action
			 *
			 * @hooked  hypermarket_notfound_search        - 10
			 */
			do_action( 'hypermarket_notfound_header_after' );
			?>
		</header>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_notfound_search' ) ) :
	/**
	 * Display the not-found (404) header.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_notfound_search() {
		/* translators: 1: Open div tag, 2: Close div tag. */
		printf( esc_html__( '%1$sNothing was found at this location. Try searching, or check out the links below.%2$s', 'hypermarket' ), '<div class="entry-description">', '</div>' );

		if ( hypermarket_is_woocommerce_activated() ) {
			hypermarket_product_search();
		} else {
			get_search_form();
		}
	}
endif;

if ( ! function_exists( 'hypermarket_archive_header' ) ) :
	/**
	 * Display the archive header.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_archive_header() {
		?>
		<header class="entry-header">
			<?php 
			do_action( 'hypermarket_archive_header_before' );
			
			// Display the archive title based on the queried object.
			the_archive_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			// Display category, tag, term, or author description.
			the_archive_description( '<div class="entry-description">', '</div>' );
			
			do_action( 'hypermarket_archive_header_after' );
			?>
		</header>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_posts_page_header' ) ) :
	/**
	 * Display the blog posts page header.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_posts_page_header() {
		// Bail early if the blog posts page is not configured.
		if ( ! ! ! hypermarket_has_blog_page() || ! ! ! hypermarket_is_blog_archive() ) {
			return;
		}

		?>
		<header class="entry-header">
			<?php 
			do_action( 'hypermarket_posts_page_header_before' );

			$posts_page = get_option( 'page_for_posts', '0' );
			// Retrieve posts page (blog) title.
			printf( '<h1 class="entry-title" itemprop="headline">%s</h1>', wp_kses_post( get_the_title( $posts_page ) ) );
			
			do_action( 'hypermarket_posts_page_header_after' );
			?>
		</header>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_page_header' ) ) :
	/**
	 * Display the page header.
	 *
	 * @since   2.0.0
	 * @param   int $post_id    Queried post id.
	 * @return  void
	 */
	function hypermarket_page_header( $post_id = null ) {
		// Bail early if the page title has been removed from the view.
		if ( ! ! hypermarket_get_post_meta( 'title', $post_id ) ) {
			return;
		}

		?>
		<header class="entry-header">
			<?php 
			do_action( 'hypermarket_page_header_before' );

			// Display or retrieve the current page title with given custom markup.
			the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); 

			do_action( 'hypermarket_page_header_after' );
			?>
		</header>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_search_header' ) ) :
	/**
	 * Display header for the search query variable.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_search_header() {
		?>
		<header class="entry-header">
			<?php 
			do_action( 'hypermarket_search_header_before' );

			/* translators: 1: Open h1 tag, 2: Close h1 tag. */
			printf( esc_attr__( '%1$sResults for: %2$s', 'hypermarket' ), '<h1 class="entry-title" itemprop="headline">', sprintf( '<span>%s</span></h1>', get_search_query() ) );

			do_action( 'hypermarket_search_header_after' );
			?>
		</header>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_page_content' ) ) :
	/**
	 * Display the post content.
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
	 * @param   int $post_id    Queried post id.
	 * @return  void
	 */
	function hypermarket_post_header( $post_id = null ) {
		// Bail early if the page title has been removed from the view.
		if ( ! ! hypermarket_get_post_meta( 'title', $post_id ) ) {
			return;
		}

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
		if ( 'post' !== get_post_type() || is_search() ) {
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
	 * @param   int $post_id    Queried post id.
	 * @return  void
	 */
	function hypermarket_post_footnote( $post_id = null ) {
		$categories    = '';
		$share_buttons = '';
		$readmore      = '';
		$classname     = 'entry-footnote'; 
		$title         = get_the_title( $post_id );
		$tags          = hypermarket_post_tags();

		if ( hypermarket_is_blog_archive() || is_search() ) {
			/* translators: 1: Open anchor tag, 2: Close anchor tag. */
			$readmore   = sprintf( esc_html__( '%1$sRead more%2$s', 'hypermarket' ), sprintf( '<a href="%s" class="more-link">', esc_url( get_the_permalink( $post_id ) ) ), sprintf( '<span class="screen-reader-text">%s</span></a>', wp_kses_post( $title ) ) );
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
			'next_text' => apply_filters( 'hypermarket_paging_next_text', sprintf( esc_html_x( '%1$sNext%2$s', 'Next post', 'hypermarket' ), '<span class="screen-reader-text">', '</span>' ) ),
			/* translators: 1: Open span tag, 2: Close span tag. */
			'prev_text' => apply_filters( 'hypermarket_paging_prev_text', sprintf( esc_html_x( '%1$sPrev%2$s', 'Previous post', 'hypermarket' ), '<span class="screen-reader-text">', '</span>' ) ),
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
	 * @param   int $post_id    Queried post id.
	 * @return  void
	 */
	function hypermarket_post_thumbnail( $post_id = null ) {
		// Bail early, if the featured image has been removed from the view or no image is attached yet.
		if ( ! has_post_thumbnail() || ! ! hypermarket_get_post_meta( 'featured_media', $post_id ) ) {
			return;
		}

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

if ( ! function_exists( 'hypermarket_tag_cloud_args' ) ) :
	/**
	 * Modifies tag cloud widget arguments to display all tags in the same font size
	 * and use list format for better accessibility.
	 *
	 * @since   2.0.0
	 * @param   array $defaults    Default arguments for tag cloud widget.
	 * @return  array
	 */
	function hypermarket_tag_cloud_args( $defaults ) {
		$args = apply_filters(
			'hypermarket_tag_cloud_display_args',
			array(
				'format'   => 'list',
				'unit'     => 'px',
				'default'  => '14',
				'smallest' => '14',
				'largest'  => '14',
			) 
		);

		// Merge theme specific arguments into defaults array.
		$defaults = wp_parse_args( $defaults, $args );
		return $defaults;
	}
endif;

if ( ! function_exists( 'hypermarket_customize_more_section' ) ) :
	/**
	 * Customizer specific upsell section to provide further info.
	 *
	 * @since   2.0.0
	 * @param   WP_Customize_Manager $hm_customize    Theme Customizer object.
	 * @return  void
	 */
	function hypermarket_customize_more_section( $hm_customize ) {
		if ( ! ! apply_filters( 'hypermarket_customizer_more', true ) ) {
			$setting_key = sprintf( '%s_more', Hypermarket_Customize::$setting_prefix );
			$hm_customize->add_section(
				$setting_key,
				array(
					/* translators: %s: Emoji. */
					'title'    => sprintf( esc_html__( 'More %s', 'hypermarket' ), '⚡' ),
					'priority' => 9999,
				)
			);
			$hm_customize->add_setting(
				$setting_key,
				array(
					'default'           => null,
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$hm_customize->add_control(
				new Hypermarket_Customize_More_Control(
					$hm_customize,
					$setting_key,
					array(
						'label'    => __( 'Looking for more options?', 'hypermarket' ),
						'section'  => $setting_key,
						'settings' => $setting_key,
					)
				)
			);
		}
	}
endif;

if ( ! function_exists( 'hypermarket_div' ) ) :
	/**
	 * Open div.
	 *
	 * @since   2.0.0
	 * @return  void
	 * @phpcs:disable Squiz.PHP.EmbeddedPhp.ContentAfterEnd, Squiz.PHP.EmbeddedPhp.ContentBeforeOpen
	 */
	function hypermarket_div() {
		?><div class="div"><?php
	}
endif;

if ( ! function_exists( 'hypermarket_div_close' ) ) :
	/**
	 * Close div.
	 *
	 * @since   2.0.0
	 * @return  void
	 * @phpcs:disable Squiz.PHP.EmbeddedPhp.ContentAfterEnd, Squiz.PHP.EmbeddedPhp.ContentBeforeOpen
	 */
	function hypermarket_div_close() {
		?></div><?php
	}
endif;

if ( ! function_exists( 'hypermarket_jscroll' ) ) :
	/**
	 * Ajax scroll wrapper.
	 *
	 * @since   2.0.0
	 * @return  void
	 * @phpcs:disable Squiz.PHP.EmbeddedPhp.ContentAfterEnd, Squiz.PHP.EmbeddedPhp.ContentBeforeOpen
	 */
	function hypermarket_jscroll() {
		// Bail early, in case the AJAX pagination module is not being activated.
		if ( ! hypermarket_jscroll_activated() ) {
			return;
		}

		?><div class="jscroll-div"><div class="jscroll-div__inner"><?php
	}
endif;

if ( ! function_exists( 'hypermarket_jscroll_close' ) ) :
	/**
	 * Close Ajax scroll wrapper.
	 *
	 * @since   2.0.0
	 * @return  void
	 * @phpcs:disable Squiz.PHP.EmbeddedPhp.ContentAfterEnd, Squiz.PHP.EmbeddedPhp.ContentBeforeOpen
	 */
	function hypermarket_jscroll_close() {
		// Bail early, in case the AJAX pagination module is not being activated.
		if ( ! hypermarket_jscroll_activated() ) {
			return;
		}

		?></div></div><!-- .jscroll-div --><?php
	}
endif;

if ( ! function_exists( 'hypermarket_flkty' ) ) :
	/**
	 * Flickity carousel wrapper.
	 *
	 * @since   2.0.0
	 * @param   array $args       Value to merge with $defaults.
	 * @return  void
	 * @phpcs:disable Squiz.PHP.EmbeddedPhp.ContentAfterEnd, Squiz.PHP.EmbeddedPhp.ContentBeforeOpen
	 */
	function hypermarket_flkty( $args = array() ) {
		$defaults = apply_filters(
			'hypermarket_flickity_data_args',
			array(
				'cellSelector'    => 'li',
				'cellAlign'       => 'left',
				'groupCells'      => '100%',
				'pageDots'        => true,
				'autoPlay'        => false,
				'wrapAround'      => true,
				'adaptiveHeight'  => false,
				'prevNextButtons' => false,
			) 
		);
		// Merge user defined arguments into defaults array.
		$args = wp_parse_args( $args, $defaults );
		?><div class="flkty-div" data-flickity='<?php echo wp_json_encode( $args ); ?>'><?php
	}
endif;

if ( ! function_exists( 'hypermarket_wrapper' ) ) :
	/**
	 * Open div with `entry-wrapper` CSS class name.
	 *
	 * @since   2.0.0
	 * @return  void
	 * @phpcs:disable Squiz.PHP.EmbeddedPhp.ContentAfterEnd, Squiz.PHP.EmbeddedPhp.ContentBeforeOpen
	 */
	function hypermarket_wrapper() {
		?><div class="entry-wrapper"><?php
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
		// Retrieves theme modification value for the current theme (parent or child).
		$is_fluid   = get_theme_mod( sprintf( '%s_general_is_fluid', Hypermarket_Customize::$setting_prefix ), false );
		$classname  = 'col-full';
		$classnames = array( $classname );
		
		if ( $is_fluid ) {
			$classnames[] = sprintf( '%s--fluid', $classname );
		}

		printf( '<div class="%s">', hypermarket_sanitize_html_classes( $classnames, 'string' ) );
	}
endif;
