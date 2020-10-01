<?php
/*
Plugin Name: XforWooCommerce
Plugin URI: https://xforwoocommerce.com
Description: XforWooCommerce Themes and Plugins! Visit https://xforwoocommerce.com
Author: 7VX LLC, USA CA
License: Codecanyon Split Licence
Version: 1.1.1
Requires at least: 4.5
Tested up to: 5.3.0
WC requires at least: 3.0.0
WC tested up to: 3.7.9
Author URI: https://xforwoocommerce.com
Text Domain: xforwoocommerce
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$GLOBALS['svx'] = isset( $GLOBALS['svx'] ) && version_compare( $GLOBALS['svx'], '1.2.1') == 1 ? $GLOBALS['svx'] : '1.2.1';

if ( !class_exists( 'X_for_WooCommerce' ) ) :

	final class X_for_WooCommerce {

		public static $version = '1.1.1';

		protected static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct() {
			if ( is_admin() ) {
				register_activation_hook( __FILE__, array( $this, 'activate' ) );
			}

			if ( $this->check_woocommerce() === false ) {
				return false;
			}

			do_action( 'xforwc_loading' );

			$this->init_hooks();

			$this->includes();

			do_action( 'xforwc_loaded' );
		}

		private function init_hooks() {
			add_action( 'init', array( $this, 'textdomain' ), 0 );
			add_action( 'init', array( $this, 'load_svx' ), 100 );

			// Legacy will be removed
			add_action( 'plugins_loaded', array( $this, 'fix_svx' ), 100 );
		}

		private function check_woocommerce() {
			if ( class_exists( 'WooCommerce' ) ) {
				return true;
			}
			else {
				return false;
			}
		}

		public function activate() {
			if ( !class_exists('WooCommerce') ) {
				deactivate_plugins( plugin_basename( __FILE__ ) );

				wp_die( esc_html__( 'This plugin requires WooCommerce. Download it from WooCommerce official website', 'xforwoocommerce' ) . ' &rarr; https://woocommerce.com' );
				exit;
			}
		}

		public static function load_demo() {
			include_once( 'svx-settings/svx-settings.php' );
			include_once( 'svx-settings/svx-fixoptions.php' );
		}

		public function load_svx() {
			if ( $this->is_request( 'admin' ) ) {
				include_once( 'svx-settings/svx-settings.php' );
			}
		}

		public function fix_svx() {
			include_once( 'svx-settings/svx-fixoptions.php' );
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
			$options = get_option( '_xforwoocommerce', array() );

			include_once( 'svx-settings/svx-get.php' );

			if ( !isset( $options['product-filters'] ) || $options['product-filters'] == 'yes' ) {
				include_once( 'x-pack/prdctfltr/prdctfltr.php' );
			}
			if ( !isset( $options['product-loops'] ) || $options['product-loops'] == 'yes' ) {
				include_once( 'x-pack/product-loops/product-loops.php' );
			}

			if ( !isset( $options['product-options'] ) || $options['product-options'] == 'yes' ) {
				include_once( 'x-pack/improved-variable-product-attributes/improved-variable-product-attributes.php' );
			}

			if ( !isset( $options['product-badges'] ) || $options['product-badges'] == 'yes' ) {
				include_once( 'x-pack/improved-sale-badges/improved-sale-badges.php' );
			}

			if ( !isset( $options['seo-for-woocommerce'] ) || $options['seo-for-woocommerce'] == 'yes' ) {
				include_once( 'x-pack/seo-for-woocommerce/seo-for-woocommerce.php' );
			}

			if ( !isset( $options['share-print-pdf'] ) || $options['share-print-pdf'] == 'yes' ) {
				include_once( 'x-pack/share-print-pdf-woocommerce/share-woo.php' );
			}

			if ( !isset( $options['live-editor'] ) || $options['live-editor'] == 'yes' ) {
				include_once( 'x-pack/woocommerce-frontend-shop-manager/woocommerce-frontend-shop-manager.php' );
			}

			if ( !isset( $options['warranties-and-returns'] ) || $options['warranties-and-returns'] == 'yes' ) {
				include_once( 'x-pack/woocommerce-warranties-and-returns/woocommerce-warranties-and-returns.php' );
			}

			if ( !isset( $options['add-tabs-xforwc'] ) || $options['add-tabs-xforwc'] == 'yes' ) {
				include_once( 'x-pack/add-tabs-xforwc/add-tabs-xforwc.php' );
			}

			if ( !isset( $options['spam-control-xforwc'] ) || $options['spam-control-xforwc'] == 'yes' ) {
				include_once( 'x-pack/spam-control-xforwc/spam-control-xforwc.php' );
			}

			if ( $this->is_request( 'admin' ) ) {
				include_once( 'library/xforwc-settings.php' );
			}

		}

		public function textdomain() {

			$this->load_plugin_textdomain();

		}

		public function load_plugin_textdomain() {

			$domain = 'xforwoocommerce';
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

	function XforWC() {
		return X_for_WooCommerce::instance();
	}

	X_for_WooCommerce::instance();

endif;

?>