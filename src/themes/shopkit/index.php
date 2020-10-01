<?php
/**
 * ShopKit - Index
 *
 * @package WordPress
 * @subpackage ShopKit
 * @since ShopKit 1.0.0
 */

	get_header();

	do_action( 'shopkit_before_main_content' );

	if ( have_posts() ) {

		do_action( 'shopkit_before_archive' );

		while ( have_posts() ) : the_post();

			do_action( 'shopkit_before_archive_content' );

				get_template_part( 'content', 'archive' );

			do_action( 'shopkit_before_archive_content' );

		endwhile;

		do_action( 'shopkit_after_archive' );

	}
	else {
		get_template_part( 'content', 'none' );
	}

	do_action( 'shopkit_after_main_content' );

	get_footer();
?>