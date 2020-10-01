<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once ( get_template_directory() . '/framework/tgm-activation/class-tgm-plugin-activation.php' );

function shopkit_register_required_plugins() {
	$plugins = array(

		array(
			'name'               => 'WooCommerce',
			'slug'               => 'woocommerce',
			'source'             => '',
			'required'           => false,
			'version'            => '3.7.1',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => ''
		),

		array(
			'name'               => 'XforWooCommerce',
			'slug'               => 'xforwoocommerce',
			'source'             => get_template_directory() . '/plugins/xforwoocommerce.zip',
			'required'           => false,
			'version'            => '1.2.0',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => ''
		),

		array(
			'name'               => 'WPBakery Page Builder (formerly Visual Composer)',
			'slug'               => 'js_composer',
			'source'             => get_template_directory() . '/plugins/js_composer.zip',
			'required'           => false,
			'version'            => '6.0.5',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => ''
		),

		array(
			'name'               => 'Ultimate Addons for WPBakery Page Builder (formerly Visual Composer)',
			'slug'               => 'Ultimate_VC_Addons',
			'source'             => get_template_directory() . '/plugins/Ultimate_VC_Addons.zip',
			'required'           => false,
			'version'            => '3.19.0',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => ''
		),

		array(
			'name'               => 'Revolution Slider',
			'slug'               => 'revslider',
			'source'             => get_template_directory() . '/plugins/revslider.zip',
			'required'           => false,
			'version'            => '6.1.3',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => ''
		)


	);

	$config = array(
		'id'           => 'shopkit',
		'default_path' => '',
		'menu'         => 'shopkit-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'shopkit_register_required_plugins' );
