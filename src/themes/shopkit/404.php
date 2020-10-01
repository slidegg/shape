<?php
/**
 * ShopKit - Page
 *
 * @package WordPress
 * @subpackage ShopKit
 * @since ShopKit 1.0.0
 */

	get_header();

	do_action( 'shopkit_before_404' );

		get_template_part( 'content', '404' );

	do_action( 'shopkit_after_404' );

	get_footer();

?>