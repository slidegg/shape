<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	class XforWC_Improved_Badges_Frontend {

		public static $settings;

		public static function init() {
			$class = __CLASS__;
			new $class;
		}

		public static function make_a_set() {

			global $isb_set;
			$isb_set['style'] = get_option( 'wc_settings_isb_style', 'isb_style_shopkit' );
			$isb_set['color'] = get_option( 'wc_settings_isb_color', 'isb_sk_material' );
			$isb_set['position'] = ( $pos = get_option( 'wc_settings_isb_position', 'isb_left' ) ) ? $pos : 'isb_left';
			$isb_set['special'] = get_option( 'wc_settings_isb_special', '' );
			$isb_set['special_text'] = get_option( 'wc_settings_isb_special_text', '' );
			$isb_set['single'] = get_option( 'wc_settings_isb_overrides', 'no' );
			$isb_set['time'] = strtotime( current_time( 'mysql' ) );
			self::$settings = $isb_set;

		}

		function __construct() {

			self::make_a_set();

			add_action( 'wp_enqueue_scripts', array( &$this, 'isb_scripts' ) );
			add_action( 'wp_footer', array( &$this, 'check_scripts' ) );

			$this->install_shop();
			$this->install_product_page();

			add_filter( 'wc_get_template_part', array( &$this, 'isb_add_filter' ), 10, 3 );
			add_filter( 'woocommerce_locate_template', array( &$this, 'isb_add_loop_filter' ), 10, 3 );

			add_action( 'isb_get_loop_badge', array( &$this, 'isb_get_loop_badge' ), 10 );
			add_action( 'isb_get_single_badge', array( &$this, 'isb_get_single_badge' ), 10 );

			add_filter( 'mnthemes_add_meta_information_used', array( &$this, 'isb_info' ) );

		}

		function isb_info( $val ) {
			$val = array_merge ( $val, array( 'Improved Badges for WooCommerce' ) );
			return $val;
		}

		public static function isb_get_path() {
			return plugin_dir_path( __FILE__ );
		}

		function install_shop() {
			$setting = get_option( 'wc_settings_isb_archive_action', '' );
			if ( $setting !== '' ) {
				$hook = array();

				$hook = explode( ':', $setting );
				$hook[1] = isset( $hook[1] ) ? intval( $hook[1] ) : 10;

				add_action( $hook[0], array( &$this, 'isb_get_loop_badge' ), $hook[1] );
			}
		}

		function install_product_page() {
			$setting = get_option( 'wc_settings_isb_single_action', '' );
			if ( $setting !== '' ) {
				$hook = array();

				$hook = explode( ':', $setting );
				$hook[1] = isset( $hook[1] ) ? intval( $hook[1] ) : 10;

				add_action( $hook[0], array( &$this, 'isb_get_single_badge' ), $hook[1] );
			}
		}

		function isb_scripts() {

			//wp_enqueue_style( 'isb-style', ImprovedBadges()->plugin_url() . '/assets/css/style' . ( is_rtl() ? '-rtl' : '' ) . '.css', false, XforWC_Improved_Badges::$version );
			wp_enqueue_style( 'isb-style', ImprovedBadges()->plugin_url() . '/assets/css/style' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', false, XforWC_Improved_Badges::$version );

			wp_register_script( 'isb-scripts', ImprovedBadges()->plugin_url() . '/assets/js/scripts.js', array( 'jquery' ), XforWC_Improved_Badges::$version, true );
			wp_enqueue_script( 'isb-scripts' );

		}

		function check_scripts() {

			global $isb_set;

			if ( !isset( $isb_set['load_js'] ) && get_option( 'wc_settings_isb_force_scripts', 'no' ) == 'no' ) {
				wp_dequeue_script( 'isb-scripts' );
			}
			else if ( wp_script_is( 'isb-scripts', 'enqueued' ) ) {

				$curr_args = array(
					'time' => self::$settings['time'],
					'localization' => array(
						'd' => esc_html__( 'd', 'xforwoocommerce' ),
						'days' => esc_html__( 'days', 'xforwoocommerce' )
					)
				);

				wp_localize_script( 'isb-scripts', 'isb', $curr_args );

			}

		}

		function isb_add_filter( $template, $slug, $name ) {

			if ( in_array( $slug, array( 'loop/sale-flash.php', 'single-product/sale-flash.php' ) ) ) {

				if ( get_option( 'wc_settings_isb_template_overrides', 'yes' ) !== 'yes' ) {
					return $template;
				}

/*				if ( $slug == 'loop/sale-flash.php' && self::$settings['override_archive'] !== '' ) {
					return $template;
				}

				if ( $slug == 'single-product/sale-flash.php' && self::$settings['override_single'] !== '' ) {
					return $template;
				} */

				if ( $name ) {
					$path = ImprovedBadges()->plugin_path() . '/' . WC()->template_path() . "{$slug}-{$name}.php";
				} else {
					$path = ImprovedBadges()->plugin_path() . '/' . WC()->template_path() . "{$slug}.php";
				}

				return file_exists( $path ) ? $path : $template;

			}

			return $template;

		}

		function isb_add_loop_filter( $template, $template_name, $template_path ) {

			if ( in_array( $template_name, array( 'loop/sale-flash.php', 'single-product/sale-flash.php' ) ) ) {

				if ( get_option( 'wc_settings_isb_template_overrides', 'yes' ) !== 'yes' ) {
					return $template;
				}

/*				if ( $template_name == 'loop/sale-flash.php' && self::$settings['override_archive'] !== '' ) {
					return $template;
				}

				if ( $template_name == 'single-product/sale-flash.php' && self::$settings['override_single'] !== '' ) {
					return $template;
				} */

				$path = ImprovedBadges()->plugin_path() . '/' . $template_path . $template_name;
				return file_exists( $path ) ? $path : $template;

			}

			return $template;

		}

		function isb_get_loop_badge() {

			$include = ImprovedBadges()->plugin_path() . '/woocommerce/loop/sale-flash.php';

			if ( file_exists( $include ) ) {
				include( $include );
			}

		}

		function isb_get_single_badge() {

			$include = ImprovedBadges()->plugin_path() . '/woocommerce/single-product/sale-flash.php';

			if ( file_exists( $include ) ) {
				include( $include );
			}

		}

		public static function get_preset( $preset ) {

			if ( $preset == '' ) {
				return array();
			}

			if ( is_array( $preset ) ) {
				$preset = sanitize_title( $preset['preset'] );
			}

			$process = get_option( '_wcmn_isb_preset_' . $preset, array() );
			if ( isset( $process['name'] ) ) {
				return array( 0 => $process );
			}
			else {
				return array();
			}

		}

		public static function is_old_post( $id, $days = 5 ) {
			$days = (int) $days;
			$offset = $days*60*60*24;
			if ( get_post_time( 'U', false, $id ) < date( 'U' ) - $offset )
				return true;
			
			return false;
		}

		public static function overrides() {

			if ( !isset( self::$settings['overrides'] ) ) {
				self::$settings['overrides'] = get_option( 'wcmn_isb_overrides', array() );
			}

			if ( empty( self::$settings['overrides'] ) ) {
				return false;
			}

			$over = self::$settings['overrides'];

			global $product;

			if ( isset( $over['featured'] ) && $over['featured'] !== '' ) {
				if ( XforWC_Improved_Badges::version_check() === true ) {
					if ( has_term( 'featured', 'product_visibility', get_the_ID() ) ) {
						return self::get_preset( $over['featured'] );
					}
				}
				else {
					if ( get_post_meta( get_the_ID(), '_featured', true ) === 'yes' ) {
						return self::get_preset( $over['featured'] );
					}
				}
			}


			if ( isset( $over['new']['days'] ) && isset( $over['new']['preset'] ) && $over['new']['preset'] !== ''  ) {
				if ( !self::is_old_post( get_the_ID(), $over['new']['days'] ) ) {
					return self::get_preset( $over['new']['preset'] );
				}
			}

			if ( isset( $over['product_tag'] ) && is_array( $over['product_tag'] ) ) {
				foreach( $over['product_tag'] as $k => $v ) {
					$v = is_array( $v ) ? $v : array( 'term' => $k, 'preset' => $v );
					if ( !empty( $v['term'] ) && has_term( $v['term'], 'product_tag', get_the_ID() ) ) {
						return self::get_preset( $v['preset'] );
					}
				}
			}

			if ( isset( $over['product_cat'] ) && is_array( $over['product_cat'] ) ) {

				$term_ids = wp_get_post_terms( get_the_ID(), 'product_cat', array( 'fields' => 'ids' ) );

				if ( $term_ids && !is_wp_error( $term_ids ) ) {
					$term_parents = get_ancestors( $term_ids[0], 'product_cat' );

					$checks = array( $term_ids[0] );
					if ( !empty( $term_parents ) ) {
						$checks = array_merge( $checks, $term_parents );
					}

					foreach( $checks as $check ) {
						if ( array_key_exists( $check, $over['product_cat'] ) ) {
							return self::get_preset( $over['product_cat'][$check] );
						}
					}
				}
			}

			return array();

		}

		public static function get_badge() {

			global $isb_set;

			$curr_badge = array( array(
				'style'        => $isb_set['style'],
				'color'        => $isb_set['color'],
				'position'     => $isb_set['position'],
				'special'      => $isb_set['special'],
				'special_text' => $isb_set['special_text']
			) );

			if ( $isb_set['single'] == 'yes' ) {
				$curr_badge_meta = get_post_meta( get_the_ID(), '_isb_settings' );
			}

			if ( isset( $curr_badge_meta[0]['preset'] ) && $curr_badge_meta[0]['preset'] !== '' ) {
				$preset = self::get_preset( $curr_badge_meta[0]['preset'] );
				if ( !empty( $preset ) ) {
					return $preset;
				}
			}

			$override = self::overrides();
			$curr_badge = empty( $override ) ? $curr_badge : $override;

			if ( isset( $curr_badge_meta[0] ) && is_array( $curr_badge_meta[0] ) ) {

				$isbElements = array( 'style', 'color', 'position', 'special', 'special_text' );

				foreach( $isbElements as $v ) {
					if ( isset( $curr_badge_meta[0][$v] ) && $curr_badge_meta[0][$v] !== '' ) {
						$curr_badge[0][$v] = $curr_badge_meta[0][$v];
					}
				}
			}

			return $curr_badge;

		}

	}

	add_action( 'init', array( 'XforWC_Improved_Badges_Frontend', 'init' ), 998 );

	if ( !function_exists( 'mnthemes_add_meta_information' ) ) {
		function mnthemes_add_meta_information_action() {
			echo '<meta name="generator" content="' . esc_attr( implode( ', ', apply_filters( 'mnthemes_add_meta_information_used', array() ) ) ) . '"/>';
		}
		function mnthemes_add_meta_information() {
			add_action( 'wp_head', 'mnthemes_add_meta_information_action', 99 );
		}
		mnthemes_add_meta_information();
	}

?>