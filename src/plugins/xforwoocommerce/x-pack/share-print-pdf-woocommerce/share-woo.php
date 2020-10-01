<?php
/*
Plugin Name: Share, Print and PDF Products for WooCommerce
Plugin URI: https://xforwoocommerce.com
Description: XforWooCommerce Themes and Plugins! Visit https://xforwoocommerce.com
Author: 7VX LLC, USA CA
License: Codecanyon Split Licence
Version: 2.4.2
Requires at least: 4.5
Tested up to: 5.3.0
WC requires at least: 3.0.0
WC tested up to: 3.7.9
Author URI: https://xforwoocommerce.com
Text Domain: share-print-pdf-woocommerce
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$GLOBALS['svx'] = isset( $GLOBALS['svx'] ) && version_compare( $GLOBALS['svx'], '1.2.1') == 1 ? $GLOBALS['svx'] : '1.2.1';

if ( !class_exists( 'XforWC_PDF_Print_Share' ) ) :

	final class XforWC_PDF_Print_Share {

		public static $version = '2.4.2';

		protected static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct() {
			do_action( 'wcmnspp_loading' );

			$this->includes();

			if ( !function_exists( 'XforWC' ) ) {
				$this->single_plugin();
			}

			do_action( 'wcmnspp_loaded' );
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

				include_once( 'includes/spp-settings.php' );

			}

			if ( $this->is_request( 'frontend' ) ) {
				$this->frontend_includes();
			}

		}

		public function frontend_includes() {
			include_once( 'includes/spp-frontend.php' );
		}

		public function textdomain() {

			$this->load_plugin_textdomain();

		}

		public function load_plugin_textdomain() {

			$domain = 'share-print-pdf-woocommerce';
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

	}

	add_filter( 'svx_plugins', 'svx_share_print_pdf_add_plugin', 60 );
	add_filter( 'svx_plugins_settings_short', 'svx_share_print_pdf_add_short' );

	function svx_share_print_pdf_add_plugin( $plugins ) {

		$plugins['share_print_pdf'] = array(
			'slug' => 'share_print_pdf',
			'name' => esc_html__( 'Share, Print, PDF', 'xforwoocommerce' )
		);

		return $plugins;

	}
	function svx_share_print_pdf_add_short( $plugins ) {
		$plugins['share_print_pdf'] = array(
			'slug' => 'share_print_pdf',
			'settings' => array(
				'wc_settings_spp_enable' => array(
					'autoload' => true,
				),
				'wc_settings_spp_action' => array(
						'autoload' => true,
				),
				'wc_settings_spp_force_scripts' => array(
					'autoload' => true,
				),
				'wc_settings_spp_title' => array(
					'autoload' => false,
				),
				'wc_settings_spp_style' => array(
					'autoload' => false,
				),
				'wc_settings_spp_shares' => array(
					'autoload' => false,
				),
				'wc_settings_spp_logo' => array(
					'autoload' => false,
				),
				'wc_settings_spp_pagesize' => array(
					'autoload' => false,
				),
				'wc_settings_spp_header_after' => array(
					'autoload' => false,
				),
				'wc_settings_spp_product_before' => array(
					'autoload' => false,
				),
				'wc_settings_spp_product_after' => array(
					'autoload' => false,
				),
			),
		);
		return $plugins;
	}

	function Wcmnspp() {
		return XforWC_PDF_Print_Share::instance();
	}

	XforWC_PDF_Print_Share::instance();


endif;



?>