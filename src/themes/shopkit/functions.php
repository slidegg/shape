<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'ShopKit_Init' ) ) :

	final class ShopKit_Init {

		public static $version = '2.1.0';

		protected static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct() {
			do_action( 'shopkit_loading' );

			$this->init_hooks();

			$this->includes();

			do_action( 'shopkit_loaded' );
		}

		private function init_hooks() {
			add_action( 'init', array( $this, 'init' ), 0 );
			add_filter( 'ot_theme_mode', array( $this, 'true' ) );
			add_filter( 'ot_show_pages', array( $this, 'false' ) );

			add_action( 'wp_before_admin_bar_render', array( $this, 'remove_ot_menu' ) );
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

			require_once( get_template_directory() . '/framework/settings-wordpress.php' );
			require_once( get_template_directory() . '/framework/settings-ot.php' );
			include_once( get_template_directory() . '/framework/settings-woocommerce.php' );
			require( get_template_directory() . '/framework/option-tree-master/ot-loader.php' );

			if ( $this->is_request( 'admin' ) ) {
				include_once( get_template_directory() . '/framework/class-activate.php' );
				include_once( get_template_directory() . '/framework/class-menu.php' );
				include_once( get_template_directory() . '/framework/settings-plugins.php' );
				include_once( get_template_directory() . '/framework/settings-theme.php' );
				include_once( get_template_directory() . '/framework/metabox-ot.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {
				include_once( get_template_directory() . '/framework/class-icons.php' );
				include_once( get_template_directory() . '/framework/class-breadcrumb-trail.php' );
				include_once( get_template_directory() . '/framework/class-theme.php' );
				if ( class_exists( 'WooCommerce' ) ) {
					include_once( get_template_directory() . '/framework/class-woocommerce.php' );
				}
			}

		}

		public function remove_ot_menu() {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu( 'ot-theme-options' );
		}

		public function frontend_includes() {

		}

		public function include_template_functions() {

		}

		public function init() {

			do_action( 'shopkit_before_init' );

			$this->load_theme_textdomain();
			$this->check_defaults();

			do_action( 'shopkit_after_init' );

		}

		public function check_defaults() {
			
			if ( !is_child_theme() ) {
				require_once( get_template_directory() . '/framework/default-child.php' );
			}
			else {
				if ( file_exists( get_stylesheet_directory() . '/demo/theme-options.php' ) ) {
					include( get_stylesheet_directory() . '/demo/theme-options.php' );
				}
			}

		}

		public function load_theme_textdomain() {

			$domain = 'shopkit';
			$dir = untrailingslashit( WP_LANG_DIR );
			$locale = apply_filters( 'theme_locale', get_locale(), $domain );

			if ( $loaded = load_textdomain( $domain, $dir . '/themes/' . $domain . '-' . $locale . '.mo' ) ) {
				return $loaded;
			}
			else {
				load_theme_textdomain( $domain, get_template_directory() . '/lang/' );
			}

		}

		public function setup_environment() {

		}

		public function template_url() {
			return untrailingslashit( esc_url( get_template_directory_uri() ) );
		}

		public function template_path() {
			return untrailingslashit( get_template_directory() );
		}

		public function ajax_url() {
			return esc_url( admin_url( 'admin-ajax.php', 'relative' ) );
		}

		public function true() {
			return true;
		}

		public function false() {
			return false;
		}

		public function version() {
			return self::$version;
		}

	}

	function WcSk() {
		return ShopKit_Init::instance();
	}

	ShopKit_Init::instance();

endif;

?>