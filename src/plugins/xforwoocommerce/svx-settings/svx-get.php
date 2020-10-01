<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $GLOBALS['svx'] ) && version_compare( $GLOBALS['svx'], '1.2.1' ) == 0 ) :

if ( !class_exists( 'SevenVXGet' ) ) {

	class SevenVXGet {

		public static $version = '1.2.1';

		protected static $_instance = null;

		public static $settings = array();

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		function __construct() {

		}

		public function get_option( $option, $plugin ) {
			if ( isset( self::$settings[$plugin] ) ) {
				if ( isset( self::$settings[$plugin][$option] ) ) {
					return self::$settings[$plugin][$option];
				}
				return false;
			}
			
			$options = get_option( 'svx_settings_' . $plugin, false );

			if ( $options !== false ) {
				self::$settings[$plugin] = $options;

				if ( isset( $options[$option] ) ) {
					return $options[$option];					
				}
			}

			return false;
		}


	}

	function SevenVXGet() {
		return SevenVXGet::instance();
	}

	SevenVXGet::instance();

}

endif;

?>