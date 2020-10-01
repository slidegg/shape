<?php
/**
 * ShopKit - Page
 *
 * @package WordPress
 * @subpackage ShopKit
 * @since ShopKit 1.0.0
 */

	get_header();

	do_action( 'shopkit_before_main_content' );

	while ( have_posts() ) : the_post();

		do_action( 'shopkit_before_page' );

			get_template_part( 'content', 'page' );

		do_action( 'shopkit_after_page' );

	endwhile;

	do_action( 'shopkit_after_main_content' );

	get_footer();

?>