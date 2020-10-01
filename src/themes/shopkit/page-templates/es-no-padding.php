<?php
/**
 * Template Name: No Padding Page
 *
 * @package WordPress
 * @subpackage ShopKit
 * @since ShopKit 1.0.0
 */

	get_header();

	do_action( 'shopkit_before_single_content' );

	while ( have_posts() ) : the_post();

		get_template_part( 'content', 'page' );

	endwhile;

	do_action( 'shopkit_after_single_content' );

	get_footer();

?>