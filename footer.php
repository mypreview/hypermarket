<?php
/**
 * The template for displaying the footer
 * Contains the closing of the `#content` div and all content after.
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */
	
				/**
				 * Functions hooked in to `hypermarket_content_bottom` action
				 *
				 * @hooked hypermarket_container_close		   - 5
				 */
				do_action( 'hypermarket_content_bottom' );
			
			?></div><!-- #content --><?php
			
			do_action( 'hypermarket_before_footer' ); 

			?><footer id="colophon" class="site-footer" role="contentinfo"><?php

				/**
				 * Functions hooked in to `hypermarket_footer` action
				 *
				 * @hooked hypermarket_container_open		   - 5
				 * @hooked hypermarket_footer_widgets 		  - 10
				 * @hooked hypermarket_credit         		  - 20
				 * @hooked hypermarket_container_close        - 25
				 */
				do_action( 'hypermarket_footer' );
			
			?></footer><!-- #colophon --><?php

			do_action( 'hypermarket_after_footer' ); 

		?></div><!-- #page --><?php 

	wp_footer();

?></body>
</html>