<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	if ( ! isset( $content_width ) ) $content_width = 1280;

	function shopkit_theme_support() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'audio', 'gallery', 'link', 'image', 'quote', 'video' ) );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_theme_support( 'automatic-feed-links' );
		register_nav_menu( 'menu', esc_html__( 'Menu locations are defined in ShopKit options!', 'shopkit' ) );

		add_theme_support( 'align-wide' );
	}
	add_action( 'after_setup_theme', 'shopkit_theme_support' );

	function shopkit_svg_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	add_filter( 'upload_mimes', 'shopkit_svg_mime_types' );

?>