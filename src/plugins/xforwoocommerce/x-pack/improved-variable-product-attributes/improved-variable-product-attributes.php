<?php
/*
Plugin Name: Improved Product Options for WooCommerce
Plugin URI: https://xforwoocommerce.com
Description: XforWooCommerce Themes and Plugins! Visit https://xforwoocommerce.com
Author: 7VX LLC, USA CA
License: Codecanyon Split Licence
Version: 4.8.2
Requires at least: 4.5
Tested up to: 5.3.0
WC requires at least: 3.0.0
WC tested up to: 3.7.9
Author URI: https://xforwoocommerce.com
Text Domain: improved-variable-product-attributes
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$GLOBALS['svx'] = isset( $GLOBALS['svx'] ) && version_compare( $GLOBALS['svx'], '1.2.1') == 1 ? $GLOBALS['svx'] : '1.2.1';

if ( !class_exists( 'XforWC_Improved_Options' ) ) :

	final class XforWC_Improved_Options {

		public static $version = '4.8.2';

		protected static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct() {
			do_action( 'wcmnivpa_loading' );

			$this->includes();

			if ( !function_exists( 'XforWC' ) ) {
				$this->single_plugin();
			}

			do_action( 'wcmnivpa_loaded' );
		}

		private function single_plugin() {
			if ( is_admin() ) {
				register_activation_hook( __FILE__, array( $this, 'activate' ) );
			}

			add_action( 'init', array( $this, 'load_svx' ), 100 );

			// Legacy will be removed
			add_action( 'plugins_loaded', array( $this, 'fix_svx' ), 100 );

			// Texdomain only used if out of XforWC
			add_action( 'init', array( $this, 'textdomain' ), 0 );
		}

		public function activate() {
			if ( !class_exists( 'WooCommerce' ) ) {
				deactivate_plugins( plugin_basename( __FILE__ ) );

				wp_die( esc_html__( 'This plugin requires WooCommerce. Download it from WooCommerce official website', 'xforwoocommerce' ) . ' &rarr; https://woocommerce.com' );
				exit;
			}
		}

		public function fix_svx() {
			include_once( 'includes/svx-settings/svx-fixoptions.php' );
		}

		public function load_svx() {
			if ( $this->is_request( 'admin' ) ) {
				include_once( 'includes/svx-settings/svx-settings.php' );
			}
		}

		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'ajax' :
					return defined( 'DOING_AJAX' );
				case 'cron' :
					return defined( 'DOING_CRON' );
				case 'frontend' :
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}
		}

		public function includes() {

			if ( $this->is_request( 'admin' ) ) {

				include_once( 'includes/ivpa-settings.php' );

			}

			if ( $this->is_request( 'frontend' ) ) {
				$this->frontend_includes();
			}

		}

		public function frontend_includes() {
			include_once( 'includes/ivpa-frontend.php' );
		}

		public function textdomain() {

			$this->load_plugin_textdomain();

		}

		public function load_plugin_textdomain() {

			$domain = 'improved-variable-product-attributes';
			$dir = untrailingslashit( WP_LANG_DIR );
			$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

			if ( $loaded = load_textdomain( $domain, $dir . '/plugins/' . $domain . '-' . $locale . '.mo' ) ) {
				return $loaded;
			}
			else {
				load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
			}

		}

		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		public function plugin_basename() {
			return untrailingslashit( plugin_basename( __FILE__ ) );
		}

		public function ajax_url() {
			return admin_url( 'admin-ajax.php', 'relative' );
		}

		public static function version_check( $version = '3.0.0' ) {
			if ( class_exists( 'WooCommerce' ) ) {
				global $woocommerce;
				if( version_compare( $woocommerce->version, $version, ">=" ) ) {
					return true;
				}
			}
			return false;
		}

		public function version() {
			return self::$version;
		}

		public static function esc_color( $color ) {
			if ( empty( $color ) || is_array( $color ) ) {
				return 'rgba(0,0,0,0)';
			}

			if ( false === strpos( $color, 'rgba' ) ) {
				return sanitize_hex_color( $color );
			}

			$color = str_replace( ' ', '', $color );
			sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
			return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
		}

	}

	add_filter( 'svx_plugins', 'svx_improved_options_add_plugin', 20 );
	add_filter( 'svx_plugins_settings_short', 'svx_improved_options_add_short' );

	function svx_improved_options_add_plugin( $plugins ) {

		$plugins['improved_options'] = array(
			'slug' => 'improved_options',
			'name' => esc_html__( 'Improved Options', 'xforwoocommerce' )
		);

		return $plugins;

	}
	function svx_improved_options_add_short( $plugins ) {

		$plugins['improved_options'] = array(
			'slug' => 'improved_options',
			'settings' => array(

				'wc_settings_ivpa_automatic' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_single_enable' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_single_selectbox' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_single_addtocart' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_single_desc' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_single_image' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_single_ajax' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_single_action' => array(
					'autoload' => true,
				),
				'wc_settings_ivpa_archive_enable' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_archive_quantity' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_archive_mode' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_archive_align' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_archive_action' => array(
					'autoload' => true,
				),
				'wc_settings_ivpa_single_summary' => array(
					'autoload' => true,
				),
				'wc_settings_ivpa_single_selector' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_archive_selector' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_addcart_selector' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_price_selector' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_outofstock_mode' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_image_attributes' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_simple_support' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_step_selection' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_disable_unclick' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_backorder_support' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_force_scripts' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_use_caching' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_single_prices' => array(
					'autoload' => false,
				),
				'wc_settings_ivpa_archive_prices' => array(
					'autoload' => false,
				),
				'wc_ivpa_attribute_customization' => array(
					'autoload' => false,
					'translate' => true
				),

			)
		);
		return $plugins;
	}


	function ImprovedOptions() {
		return XforWC_Improved_Options::instance();
	}

	XforWC_Improved_Options::instance();

endif;

?>