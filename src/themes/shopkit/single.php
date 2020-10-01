<?php
/**
 * ShopKit - Single
 *
 * @package WordPress
 * @subpackage ShopKit
 * @since ShopKit 1.0.0
 */

	get_header();

	do_action( 'shopkit_before_main_content' );

	while ( have_posts() ) : the_post();

		do_action( 'shopkit_before_single' );

			get_template_part( 'content', 'single' );

		do_action( 'shopkit_after_single' );

	endwhile;

	do_action( 'shopkit_after_main_content' );

	get_footer();

?>