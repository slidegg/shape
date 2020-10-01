<?php
/*
Plugin Name: Autopilot SEO for WooCommerce
Plugin URI: https://xforwoocommerce.com
Description: XforWooCommerce Themes and Plugins! Visit https://xforwoocommerce.com
Author: 7VX LLC, USA CA
License: Codecanyon Split Licence
Version: 1.2.2
Requires at least: 4.5
Tested up to: 5.3.0
WC requires at least: 3.0.0
WC tested up to: 3.7.9
Author URI: https://xforwoocommerce.com
Text Domain: seo-for-woocommerce
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$GLOBALS['svx'] = isset( $GLOBALS['svx'] ) && version_compare( $GLOBALS['svx'], '1.2.1') == 1 ? $GLOBALS['svx'] : '1.2.1';

if ( !class_exists( 'XforWC_SEO' ) ) :

	final class XforWC_SEO {

		public static $version = '1.2.2';

		protected static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct() {
			do_action( 'seo_for_woocommerce_loading' );

			$this->includes();

			if ( !function_exists( 'XforWC' ) ) {
				$this->single_plugin();
			}

			do_action( 'seo_for_woocommerce_loaded' );
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
				include_once( 'includes/seo-settings.php' );
				include_once( 'includes/seo-metabox.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {
				$this->frontend_includes();
			}

		}

		public function frontend_includes() {
			include_once( 'includes/seo-frontend.php' );
		}

		public function textdomain() {

			$this->load_plugin_textdomain();

		}

		public function load_plugin_textdomain() {

			$domain = 'seo-for-woocommerce';
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

	add_filter( 'svx_plugins', 'svx_seo_for_woocommerce_add_plugin', 45 );
	add_filter( 'svx_plugins_settings_short', 'svx_seo_for_woocommerce_add_short' );

	function svx_seo_for_woocommerce_add_plugin( $plugins ) {

		$plugins['seo_for_woocommerce'] = array(
			'slug' => 'seo_for_woocommerce',
			'name' => esc_html__( 'Autopilot SEO', 'xforwoocommerce' )
		);

		return $plugins;

	} 
	function svx_seo_for_woocommerce_add_short( $plugins ) {
		$plugins['seo_for_woocommerce'] = array(
			'slug' => 'seo_for_woocommerce',
			'settings' => array(

					'wcmn_seo_googleplus' => array(
						'autoload' => true,
					),

					'wcmn_seo_facebook' => array(
						'autoload' => true,
					),

					'wcmn_seo_facebook_app' => array(
						'autoload' => true,
					),

					'wcmn_seo_twitter' => array(
						'autoload' => true,
					),

					'wcmn_seo_twitter_data' => array(
						'autoload' => false,
					),

					'wcmn_seo_separator' => array(
						'autoload' => false,
					),

					'wcmn_seo_brand' => array(
						'autoload' => false,
					),

					'wcmn_seo_manufacturer' => array(
						'autoload' => false,
					),

					'wcmn_seo_color' => array(
						'autoload' => false,
					),

					'wcmn_seo_condition' => array(
						'autoload' => false,
					),

					'wcmn_seo_material' => array(
						'autoload' => false,
					),

					'wcmn_seo_authors' => array(
						'autoload' => false,
					),

					'wcmn_seo_product_image' => array(
						'autoload' => false,
					),

					'wcmn_seo_products_title' => array(
						'autoload' => false,
					),

					'wcmn_seo_products_desc' => array(
						'autoload' => false,
					),

					'wcmn_seo_product_types' => array(
						'autoload' => false,
					),

					'wcmn_seo_shop_title' => array(
						'autoload' => false,
					),

					'wcmn_seo_shop_desc' => array(
						'autoload' => false,
					),

					'wcmn_seo_taxonomies' => array(
						'autoload' => false,
					),

					'wcmn_seo_add_meta' => array(
						'autoload' => false,
					),

			)
		);

		return $plugins;
	}

	function WcmnSeo() {
		return XforWC_SEO::instance();
	}

	XforWC_SEO::instance();

endif;

?>