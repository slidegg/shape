<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	class XforWC_Improved_Badges_Settings {

		public static $presets;
		public static $isb_style;
		public static $isb_style_special;
		public static $isb_color;
		public static $isb_position;

		public static function init() {

			self::$isb_style = array(
				'isb_style_arrow' => 'Arrow Down CSS',
				'isb_style_arrow_alt' => 'Arrow Down Alternative CSS',
				'isb_style_basic' => 'Aliexpress Style CSS',
				'isb_style_basic_alt' => 'Aliexpress Style Alternative CSS',
				'isb_style_inline' => 'Inline CSS',
				'isb_style_plain' => 'Plain CSS',
				'isb_style_pop' => 'Pop SVG',
				'isb_style_pop_round' => 'Pop Round SVG',
				'isb_style_fresh' => 'Fresh SVG',
				'isb_style_round' => 'Round Triangle SVG',
				'isb_style_tag' => 'Tag SVG',
				'isb_style_xmas_1' => 'Bonus - Christmas 1 SVG',
				'isb_style_xmas_2' => 'Bonus - Christmas 2 SVG',
				'isb_style_ribbon' => 'Ribbon FULL SVG',
				'isb_style_vintage' => 'Vintage IMG',
				'isb_style_pure' => 'Pure CSS',
				'isb_style_modern' => 'Modern CSS',
				'isb_style_transparent' => 'Transparent CSS',
				'isb_style_transparent_2' => 'Transparent #2 CSS',
				'isb_style_random_squares' => 'Random Squares SVG',
				'isb_style_fresh_2' => 'Fresh #2 SVG',
				'isb_style_valentine' => 'Valentine SVG',
				'isb_style_cool' => 'Cool SVG',
				'isb_style_triangle' => 'Triangle SVG',
				'isb_style_eu' => 'EU Elegant CSS',
				'isb_style_eu_2' => 'EU Round CSS',
				'isb_style_eu_3' => 'EU On Side CSS',
				'isb_style_candy' => 'Candy SVG',
				'isb_style_candy_arrow' => 'Candy Arrow SVG',
				'isb_style_cloud' => 'Cloud SVG',
				'isb_style_shopkit' => 'ShopKit SVG',
				'isb_style_responsive_1' => 'Responsive - Square',
				'isb_style_responsive_2' => 'Responsive - Star',
				'isb_style_responsive_3' => 'Responsive - Badge',
				'isb_style_responsive_4' => 'Responsive - Upside Badge',
				'isb_style_responsive_5' => 'Responsive - Pop',
				'isb_style_responsive_6' => 'Responsive - Round Square',
				'isb_style_responsive_7' => 'Responsive - Buzz',
				'isb_style_responsive_8' => 'Responsive - Circle',
				'isb_style_responsive_9' => 'Responsive - Shake',
				'isb_style_responsive_10' => 'Responsive - Shake Line',
				'isb_style_border_1' => 'Border - Square',
				'isb_style_border_2' => 'Border - Star',
				'isb_style_border_3' => 'Border - Badge',
				'isb_style_border_4' => 'Border - Upside Badge',
				'isb_style_border_5' => 'Border - Pop',
				'isb_style_border_6' => 'Border - Round Square',
				'isb_style_border_7' => 'Border - Buzz',
				'isb_style_border_8' => 'Border - Circle',
				'isb_style_border_9' => 'Border - Shake',
			);

			self::$isb_style_special = array(
				'isb_special_border' => 'Border CSS',
				'isb_special_border_round' => 'Border Round CSS',
				'isb_special_plain' => 'Plain CSS',
				'isb_special_arrow' => 'Arrow CSS',
				'isb_special_bigbadge' => 'Big Badge CSS',
				'isb_special_ribbon' => 'Ribbon SVG'
			);

			self::$isb_color = array(
				'isb_avada_green' => 'Avada Green',
				'isb_green' => 'Green',
				'isb_orange' => 'Orange',
				'isb_pink' => 'Pink',
				'isb_red' => 'Pale Red',
				'isb_yellow' => 'Golden Yellow',
				'isb_tirq' => 'Turquoise',
				'isb_brown' => 'Brown',
				'isb_plumb' => 'Plumb',
				'isb_marine' => 'Marine',
				'isb_dark_orange' => 'Dark Orange',
				'isb_fuschia' => 'Fuschia',
				'isb_sky' => 'Sky',
				'isb_ocean' => 'Ocean',
				'isb_regular_gray' => 'Regular Gray',
				'isb_summer_1' => 'Summer Pallete #1',
				'isb_summer_2' => 'Summer Pallete #2',
				'isb_summer_3' => 'Summer Pallete #3',
				'isb_summer_4' => 'Summer Pallete #4',
				'isb_summer_5' => 'Summer Pallete #5',
				'isb_trending_1' => 'Trending Pallete #1',
				'isb_trending_2' => 'Trending Pallete #2',
				'isb_trending_3' => 'Trending Pallete #3',
				'isb_trending_4' => 'Trending Pallete #4',
				'isb_trending_5' => 'Trending Pallete #5',
				'isb_trending_6' => 'Trending Pallete #6',
				'isb_trending_7' => 'Trending Pallete #7',
				'isb_trending_8' => 'Trending Pallete #8',
				'isb_trending_9' => 'Trending Pallete #9',
				'isb_sk_material' => 'ShopKit Material',
				'isb_sk_flat' => 'ShopKit Flat',
				'isb_sk_creative' => 'ShopKit Creative',
			);

			self::$isb_position = array(
				'isb_left' => esc_html__( 'Left', 'xforwoocommerce' ),
				'isb_right'=> esc_html__( 'Right', 'xforwoocommerce' )
			);

			add_action( 'admin_enqueue_scripts', __CLASS__ . '::isb_scripts', 9 );
			add_action( 'wp_ajax_isb_respond', __CLASS__ . '::isb_respond' );

			add_action( 'woocommerce_product_write_panel_tabs', __CLASS__ . '::isb_add_product_tab' );
			add_action( 'woocommerce_product_data_panels', __CLASS__ . '::isb_product_tab' );
			add_action( 'save_post', __CLASS__ . '::isb_product_save' );

		}

		public static function isb_scripts( $hook ) {

			$init = false;

			if ( isset($_GET['page'], $_GET['tab']) && ($_GET['page'] == 'wc-settings' ) && $_GET['tab'] == 'improved_badges' ) {
				$init = true;
			}
			if ( isset($_GET['page']) && ($_GET['page'] == 'xforwoocommerce' ) ) {
				$init = true;
			}

			if ( $hook == 'post-new.php' || $hook == 'post.php' && get_option( 'wc_settings_isb_overrides', 'no' ) == 'yes' ) {
				$init = true;
			}

			if ( $init === true ) {

				//wp_enqueue_style( 'isb-style', ImprovedBadges()->plugin_url() . '/assets/css/admin' . ( is_rtl() ? '-rtl' : '' ) . '.css', false, XforWC_Improved_Badges::$version );
				wp_enqueue_style( 'isb-style', ImprovedBadges()->plugin_url() . '/assets/css/admin' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', false, XforWC_Improved_Badges::$version );

				wp_enqueue_script( 'isb-admin', ImprovedBadges()->plugin_url() . '/assets/js/admin.js', array( 'jquery' ), XforWC_Improved_Badges::$version, true );

				$curr_args = array(
					'ajax' => admin_url( 'admin-ajax.php' ),
				);

				wp_localize_script( 'isb-admin', 'isb', $curr_args );

			}

		}

		public static function get_settings( $plugins ) {

			$plugins['improved_badges'] = array(
				'slug' => 'improved_badges',
				'name' => function_exists( 'XforWC' ) ? esc_html__( 'Badges and Counters', 'xforwoocommerce' ) : esc_html__( 'Improved Badges for WooCommerce', 'xforwoocommerce' ),
				'desc' => function_exists( 'XforWC' ) ? esc_html__( 'Improved Badges for WooCommerce', 'xforwoocommerce' ) . ' v' . ImprovedBadges()->version() : esc_html__( 'Settings page for Improved Badges for WooCommerce!', 'xforwoocommerce' ),
				'link' => 'https://xforwoocommerce.com/store/badges-and-counters/',
				'ref' => array(
					'name' => esc_html__( 'Visit XforWooCommerce.com', 'xforwoocommerce' ),
					'url' => 'https://xforwoocommerce.com'
				),
				'doc' => array(
					'name' => esc_html__( 'Get help', 'xforwoocommerce' ),
					'url' => 'https://help.xforwoocommerce.com'
				),
				'sections' => array(
					'dashboard' => array(
						'name' => esc_html__( 'Dashboard', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Dashboard Overview', 'xforwoocommerce' ),
					),
					'badges' => array(
						'name' => esc_html__( 'Default Badge', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Default Badges Options', 'xforwoocommerce' ),
					),
					'presets' => array(
						'name' => esc_html__( 'Badge Presets', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Badge Presets Options', 'xforwoocommerce' ),
					),
					'manager' => array(
						'name' => esc_html__( 'Badge Manager', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Manager Options', 'xforwoocommerce' ),
					),
					'timers' => array(
						'name' => esc_html__( 'Timer/Countdowns', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Timer/Countdowns Options', 'xforwoocommerce' ),
					),
					'installation' => array(
						'name' => esc_html__( 'Installation', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Installation Options', 'xforwoocommerce' ),
					),
				),
				'settings' => array(

					'wcmn_dashboard' => array(
						'type' => 'html',
						'id' => 'wcmn_dashboard',
						'desc' => '
						<img src="' . ImprovedBadges()->plugin_url() . '/assets/images/improved-sale-badges-for-woocommerce-shop.png" class="svx-dashboard-image" />
						<h3><span class="dashicons dashicons-store"></span> XforWooCommerce</h3>
						<p>' . esc_html__( 'Visit XforWooCommerce.com store, demos and knowledge base.', 'xforwoocommerce' ) . '</p>
						<p><a href="https://xforwoocommerce.com" class="xforwc-button-primary x-color" target="_blank">XforWooCommerce.com</a></p>

						<br /><hr />

						<h3><span class="dashicons dashicons-admin-tools"></span> ' . esc_html__( 'Help Center', 'xforwoocommerce' ) . '</h3>
						<p>' . esc_html__( 'Need support? Visit the Help Center.', 'xforwoocommerce' ) . '</p>
						<p><a href="https://help.xforwoocommerce.com" class="xforwc-button-primary red" target="_blank">XforWooCommerce.com HELP</a></p>
						
						<br /><hr />

						<h3><span class="dashicons dashicons-update"></span> ' . esc_html__( 'Automatic Updates', 'xforwoocommerce' ) . '</h3>
						<p>' . esc_html__( 'Get automatic updates, by downloading and installing the Envato Market plugin.', 'xforwoocommerce' ) . '</p>
						<p><a href="https://envato.com/market-plugin/" class="svx-button" target="_blank">Envato Market Plugin</a></p>
						
						<br />',
						'section' => 'dashboard',
					),

					'wcmn_utility' => array(
						'name' => esc_html__( 'Plugin Options', 'xforwoocommerce' ),
						'type' => 'utility',
						'id' => 'wcmn_utility',
						'desc' => esc_html__( 'Quick export/import, backup and restore, or just reset your optons here', 'xforwoocommerce' ),
						'section' => 'dashboard',
					),

					'wc_settings_isb_preview' => array(
						'name'    => esc_html__( 'Preview', 'xforwoocommerce' ),
						'type'    => 'hidden',
						'desc'    => esc_html__( 'Current badge preview', 'xforwoocommerce' ),
						'id'      => 'wc_settings_isb_preview',
						'autoload' => false,
						'section' => 'badges',
						'class'   => 'isb_preview'
					),

					'wc_settings_isb_style' => array(
						'name'    => esc_html__( 'Style', 'xforwoocommerce' ),
						'type'    => 'select',
						'desc'    => esc_html__( 'Select sale badge style', 'xforwoocommerce' ),
						'id'      => 'wc_settings_isb_style',
						'default' => 'isb_style_shopkit',
						'options' => self::$isb_style,
						'autoload' => false,
						'section' => 'badges'
					),
					'wc_settings_isb_color' => array(
						'name'    => esc_html__( 'Color', 'xforwoocommerce' ),
						'type'    => 'select',
						'desc'    => esc_html__( 'Select sale badge color', 'xforwoocommerce' ),
						'id'      => 'wc_settings_isb_color',
						'default'     => 'isb_sk_material',
						'options' => self::$isb_color,
						'autoload' => false,
						'section' => 'badges'
					),
					'wc_settings_isb_position' => array(
						'name'    => esc_html__( 'Position', 'xforwoocommerce' ),
						'type'    => 'select',
						'desc'    => esc_html__( 'Select sale badge position', 'xforwoocommerce' ),
						'id'      => 'wc_settings_isb_position',
						'default'     => 'isb_left',
						'options' => self::$isb_position,
						'autoload' => false,
						'section' => 'badges'
					),
					'wc_settings_isb_special' => array(
						'name'    => esc_html__( 'Special', 'xforwoocommerce' ),
						'type'    => 'select',
						'desc'    => esc_html__( 'Select special badge', 'xforwoocommerce' ),
						'id'      => 'wc_settings_isb_special',
						'default'     => '',
						'options' => array_merge( array( '' => esc_html__( 'None', 'xforwoocommerce' ) ), self::$isb_style_special ),
						'autoload' => false,
						'section' => 'badges'
					),
					'wc_settings_isb_special_text' => array(
						'name'    => esc_html__( 'Special Text', 'xforwoocommerce' ),
						'type'    => 'textarea',
						'desc'    => esc_html__( 'Enter special badge text', 'xforwoocommerce' ),
						'id'      => 'wc_settings_isb_special_text',
						'default'     => 'Text',
						'autoload' => false,
						'section' => 'badges'
					),

					'wcmn_isb_presets' => array(
						'name' => esc_html__( 'Presets Manager', 'xforwoocommerce' ),
						'type' => 'list',
						'id'   => 'wcmn_isb_presets',
						'desc' => esc_html__( 'Add badge presets using the Presets Manager', 'xforwoocommerce' ),
						'autoload' => false,
						'section' => 'presets',
						'title' => esc_html__( 'Preset Name', 'xforwoocommerce' ),
						'options' => 'list',
						'ajax_options' => 'ajax:wp_options:_wcmn_isb_preset_%NAME%',
						'settings' => array(
							'preview' => array(
								'name'    => esc_html__( 'Preview', 'xforwoocommerce' ),
								'type'    => 'hidden',
								'desc'    => esc_html__( 'Current badge preview', 'xforwoocommerce' ),
								'id'      => 'preview',
								'class'   => 'isb_preview'
							),
							'name' => array(
								'name' => esc_html__( 'Preset Name', 'xforwoocommerce' ),
								'type' => 'text',
								'id' => 'name',
								'desc' => esc_html__( 'Enter preset name', 'xforwoocommerce' ),
								'default' => '',
							),
							'style' => array(
								'name'    => esc_html__( 'Style', 'xforwoocommerce' ),
								'type'    => 'select',
								'desc'    => esc_html__( 'Select sale badge style', 'xforwoocommerce' ),
								'id'      => 'style',
								'default' => 'isb_style_shopkit',
								'options' => self::$isb_style,
							),
							'color' => array(
								'name'    => esc_html__( 'Color', 'xforwoocommerce' ),
								'type'    => 'select',
								'desc'    => esc_html__( 'Select sale badge color', 'xforwoocommerce' ),
								'id'      => 'color',
								'default'     => 'isb_sk_material',
								'options' => self::$isb_color,
							),
							'position' => array(
								'name'    => esc_html__( 'Position', 'xforwoocommerce' ),
								'type'    => 'select',
								'desc'    => esc_html__( 'Select sale badge position', 'xforwoocommerce' ),
								'id'      => 'position',
								'default'     => 'isb_left',
								'options' => self::$isb_position,
							),
							'special' => array(
								'name'    => esc_html__( 'Special', 'xforwoocommerce' ),
								'type'    => 'select',
								'desc'    => esc_html__( 'Select special badge', 'xforwoocommerce' ),
								'id'      => 'special',
								'default'     => '',
								'options' => array_merge( array( '' => esc_html__( 'None', 'xforwoocommerce' ) ), self::$isb_style_special ),
							),
							'special_text' => array(
								'name'    => esc_html__( 'Special Text', 'xforwoocommerce' ),
								'type'    => 'textarea',
								'desc'    => esc_html__( 'Enter special badge text', 'xforwoocommerce' ),
								'id'      => 'special_text',
								'default'     => 'Text',
							),
						),
					),

					'wcmn_isb_overrides' => array(
						'name' => esc_html__( 'Badge Overrides', 'xforwoocommerce' ),
						'type' => 'hidden',
						'id'   => 'wcmn_isb_overrides',
						'desc' => esc_html__( 'Set badge overrides', 'xforwoocommerce' ),
						'autoload' => false,
						'section' => 'hidden',
					),

					'_wcmn_expire_in' => array(
						'name' => esc_html__( 'New Badge Period', 'xforwoocommerce' ),
						'type' => 'number',
						'id'   => '_wcmn_expire_in',
						'desc' => esc_html__( 'Set new product expire in period (days)', 'xforwoocommerce' ),
						'autoload' => false,
						'section' => 'manager',
					),
					'_wcmn_expire_in_preset' => array(
						'name' => esc_html__( 'New Badge Preset', 'xforwoocommerce' ),
						'type' => 'select',
						'id'   => '_wcmn_expire_in_preset',
						'desc' => esc_html__( 'Set new product badge preset', 'xforwoocommerce' ),
						'autoload' => false,
						'section' => 'manager',
						'options' => 'read:wcmn_isb_presets',
						'class' => 'svx-selectize',
					),

					'_wcmn_featured_badge' => array(
						'name' => esc_html__( 'Featured Badge', 'xforwoocommerce' ),
						'type' => 'select',
						'id'   => '_wcmn_featured_badge',
						'desc' => esc_html__( 'Set featured badge', 'xforwoocommerce' ),
						'autoload' => false,
						'section' => 'manager',
						'options' => 'read:wcmn_isb_presets',
						'class' => 'svx-selectize',
					),

					'_wcmn_tags' => array(
						'name' => esc_html__( 'Tag Badges', 'xforwoocommerce' ),
						'type' => 'list',
						'id'   => '_wcmn_tags',
						'desc' => esc_html__( 'Add tag badge presets', 'xforwoocommerce' ),
						'autoload' => false,
						'section' => 'manager',
						'title' => esc_html__( 'Name', 'xforwoocommerce' ),
						'options' => 'list',
						'default' => array(),
						'settings' => array(
							'name' => array(
								'name' => esc_html__( 'Name', 'xforwoocommerce' ),
								'type' => 'text',
								'id' => 'name',
								'desc' => esc_html__( 'Enter override name', 'xforwoocommerce' ),
								'default' => '',
							),
							'term' => array(
								'name' => esc_html__( 'Term', 'xforwoocommerce' ),
								'type' => 'select',
								'id'   => 'term',
								'desc' => esc_html__( 'Set override term', 'xforwoocommerce' ),
								'options' => 'ajax:taxonomy:product_tag:has_none',
								'default' => '',
								'class' => 'svx-selectize',
							),
							'preset' => array(
								'name' => esc_html__( 'Preset', 'xforwoocommerce' ),
								'type' => 'select',
								'id'   => 'preset',
								'desc' => esc_html__( 'Set override preset', 'xforwoocommerce' ),
								'options' => 'read:wcmn_isb_presets',
								'default' => '',
								'class' => 'svx-selectize',
							),
						),
					),

					'_wcmn_categories' => array(
						'name' => esc_html__( 'Category Badges', 'xforwoocommerce' ),
						'type' => 'list',
						'id'   => '_wcmn_categories',
						'desc' => esc_html__( 'Add category badge presets', 'xforwoocommerce' ),
						'autoload' => false,
						'section' => 'manager',
						'title' => esc_html__( 'Name', 'xforwoocommerce' ),
						'options' => 'list',
						'default' => array(),
						'settings' => array(
							'name' => array(
								'name' => esc_html__( 'Name', 'xforwoocommerce' ),
								'type' => 'text',
								'id' => 'name',
								'desc' => esc_html__( 'Enter override name', 'xforwoocommerce' ),
								'default' => '',
							),
							'term' => array(
								'name' => esc_html__( 'Term', 'xforwoocommerce' ),
								'type' => 'select',
								'id'   => 'term',
								'desc' => esc_html__( 'Set override term', 'xforwoocommerce' ),
								'autoload' => false,
								'section' => 'manager',
								'options' => 'ajax:taxonomy:product_cat:has_none',
								'default' => '',
								'class' => 'svx-selectize',
							),
							'preset' => array(
								'name' => esc_html__( 'Preset', 'xforwoocommerce' ),
								'type' => 'select',
								'id'   => 'preset',
								'desc' => esc_html__( 'Set override preset', 'xforwoocommerce' ),
								'autoload' => false,
								'section' => 'manager',
								'options' => 'read:wcmn_isb_presets',
								'default' => '',
								'class' => 'svx-selectize',
							),
						),
					),

					'wc_settings_isb_overrides' => array(
						'name'    => esc_html__( 'Single Product Badges', 'xforwoocommerce' ),
						'type'    => 'checkbox',
						'desc'    => esc_html__( 'Enable custom badge override for each product.', 'xforwoocommerce' ),
						'id'      => 'wc_settings_isb_overrides',
						'default'     => 'no',
						'autoload' => false,
						'section' => 'installation'
					),
					'wc_settings_isb_template_overrides' => array(
						'name' => esc_html__( 'Use Tempalte Overrides', 'xforwoocommerce' ),
						'type' => 'checkbox',
						'desc' => esc_html__( 'This is the default installation when checked, sale-flash.php template will be replaced with the plugin badge. If you enter a custom action below, the entered action will be used to output the plugin badge in the appropriate place in your theme.', 'xforwoocommerce' ),
						'id'   => 'wc_settings_isb_template_overrides',
						'default' => 'yes',
						'autoload' => true,
						'section' => 'installation'
					),
					'wc_settings_isb_archive_action' => array(
						'name' => esc_html__( 'Shop Init Action', 'xforwoocommerce' ),
						'type' => 'text',
						'desc' => esc_html__( 'Use custom initialization action for Shop/Product Archive Pages. Use actions initiated in your content-single-product.php template. Please enter action name in following format action_name:priority', 'xforwoocommerce' ) . ' ( default: woocommerce_before_shop_loop_item:10 )',
						'id'   => 'wc_settings_isb_archive_action',
						'default' => '',
						'autoload' => true,
						'section' => 'installation'
					),
					'wc_settings_isb_single_action' => array(
						'name' => esc_html__( 'Single Product Init Action', 'xforwoocommerce' ),
						'type' => 'text',
						'desc' => esc_html__( 'Use custom initialization action for Single Product Pages. Use actions initiated in your content-single-product.php template. Please enter action name in following format action_name:priority', 'xforwoocommerce' ) . ' ( default: woocommerce_before_single_product_summary:15 )',
						'id'   => 'wc_settings_isb_single_action',
						'default' => '',
						'autoload' => true,
						'section' => 'installation'
					),
					'wc_settings_isb_force_scripts' => array(
						'name' => esc_html__( 'Plugin Scripts', 'xforwoocommerce' ),
						'type' => 'checkbox',
						'desc' => esc_html__( 'Check this option to enable plugin scripts in all pages. This option fixes issues in Quick Views.', 'xforwoocommerce' ),
						'id'   => 'wc_settings_isb_force_scripts',
						'default' => 'no',
						'autoload' => true,
						'section' => 'installation'
					),

					'wc_settings_isb_timer' => array(
						'name' => esc_html__( 'Disable Timers', 'xforwoocommerce' ),
						'type' => 'multiselect',
						'desc' => esc_html__( 'Select sale timers to disable.', 'xforwoocommerce' ),
						'id'   => 'wc_settings_isb_timer',
						'options' => array(
							'start' => esc_html__( 'Starting Sale', 'xforwoocommerce' ),
							'end' => esc_html__( 'Ending Sale', 'xforwoocommerce' )
						),
						'default' => array(),
						'autoload' => false,
						'section' => 'timers',
						'class' => 'svx-selectize'
					),

					'wc_settings_isb_timer_adjust' => array(
						'name' => esc_html__( 'Adjust Timer', 'xforwoocommerce' ),
						'type' => 'number',
						'desc' => esc_html__( 'Adjust sale timer countdown clock. Option is set in minutes.', 'xforwoocommerce' ),
						'id'   => 'wc_settings_isb_timer_adjust',
						'default' => '',
						'autoload' => false,
						'section' => 'timers'
					),

				)
			);

			foreach ( $plugins['improved_badges']['settings'] as $k => $v ) {
				$get = isset( $v['translate'] ) && !empty( SevenVX()->language() ) ? $v['id'] . '_' . SevenVX()->language() : $v['id'];
				$std = isset( $v['default'] ) ?  $v['default'] : '';
				$set = ( $set = get_option( $get, false ) ) === false ? $std : $set;
				$plugins['improved_badges']['settings'][$k]['val'] = SevenVX()->stripslashes_deep( $set );
			}

			return apply_filters( 'xforwc_improved_badges_settings', $plugins );

		}

		public static function call_badge() {

			if ( isset( $_POST['data']['isb_preset'] ) ) {
				$preset = self::get_preset( $_POST['data']['isb_preset'] );
				if ( !empty( $preset ) ) {
					$isb_set = array_merge(
						array( 'type' => 'simple' ),
						$preset[0]
					);
				}
			}

			if ( !isset( $isb_set ) ) {
				$isb_set = array(
					'style' => isset( $_POST['data']['isb_style'] ) && $_POST['data']['isb_style'] !== '' ? $_POST['data']['isb_style'] : get_option( 'wc_settings_isb_style', 'isb_style_shopkit' ),
					'color' => isset( $_POST['data']['isb_color'] ) && $_POST['data']['isb_color'] !== '' ? $_POST['data']['isb_color'] : get_option( 'wc_settings_isb_color', 'isb_sk_material' ),
					'position' => isset( $_POST['data']['isb_position'] ) && $_POST['data']['isb_position'] !== '' ? $_POST['data']['isb_position'] : get_option( 'wc_settings_isb_position', 'isb_left' ),
					'special' => isset( $_POST['data']['isb_special'] ) ? $_POST['data']['isb_special'] : get_option( 'wc_settings_isb_special', '' ),
					'special_text' => isset( $_POST['data']['isb_special_text'] ) ? $_POST['data']['isb_special_text'] : get_option( 'wc_settings_isb_special_text', '' ),
					'type' => 'simple',
				);
			}

			$isb_price['id'] = 1;
			$isb_price['type'] = 'simple';
			$isb_price['regular'] = 32;
			$isb_price['sale'] = 27;
			$isb_price['difference'] = $isb_price['regular'] - $isb_price['sale'];
			$isb_price['percentage'] = round( ( $isb_price['regular'] - $isb_price['sale'] ) * 100 / $isb_price['regular'] );
			$isb_price['time'] = '2:04:50';
			$isb_price['time_mode'] = 'end';

			if ( is_array( $isb_set ) ) {
				$isb_class = ( isset( $isb_set['special'] ) && $isb_set['special'] !== '' ? $isb_set['special'] : $isb_set['style'] ) . ' ' . $isb_set['color'] . ' ' . $isb_set['position'];
			}
			else {
				$isb_class = 'isb_style_shopkit isb_sk_material isb_left';
			}

			$isb_curr_set = $isb_set;

			if ( isset( $isb_set['special'] ) && $isb_set['special'] !== '' ) {
				$include = ImprovedBadges()->plugin_path() . '/includes/specials/' . $isb_set['special'] . '.php';
			}
			else {
				$include = ImprovedBadges()->plugin_path() . '/includes/styles/' . $isb_set['style'] . '.php';
			}
			

			ob_start();

			if ( file_exists( $include ) ) {
				include( $include );
			}

			$html = ob_get_clean();

			die($html);
			exit;

		}

		public static function isb_respond() {
			if ( !isset( $_POST['data'] ) ) {
				die();
				exit;
			}

			self::call_badge();

		}

		public static function isb_add_product_tab() {
			if ( get_option( 'wc_settings_isb_overrides', 'no' ) == 'yes' ) {
				echo ' <li class="isb_tab"><a href="#isb_tab"><span>'. esc_html__('Sale Badges', 'xforwoocommerce' ) .'</span></a></li>';
			}
		}

		public static function isb_product_tab() {
			if ( get_option( 'wc_settings_isb_overrides', 'no' ) == 'yes' ) {
				global $post, $isb_set;

				$curr_badge = get_post_meta( $post->ID, '_isb_settings' );

				$isb_set['preset'] = ( isset( $_POST['isb_preset'] ) ? $_POST['isb_preset'] : '' );
				$isb_set['style'] = ( isset( $_POST['isb_style'] ) ? $_POST['isb_style'] : get_option( 'wc_settings_isb_style', 'isb_style_shopkit' ) );
				$isb_set['color'] = ( isset( $_POST['isb_color'] ) ? $_POST['isb_color'] : get_option( 'wc_settings_isb_color', 'isb_sk_material' ) );
				$isb_set['position'] = ( isset( $_POST['isb_position'] ) ? $_POST['isb_position'] : get_option( 'wc_settings_isb_position', 'isb_left' ) );
				$isb_set['special'] = ( isset( $_POST['isb_special'] ) ? $_POST['isb_special'] : get_option( 'wc_settings_isb_special', '' ) );
				$isb_set['special_text'] = ( isset( $_POST['isb_special_text'] ) ? $_POST['isb_special_text'] : get_option( 'wc_settings_isb_special_text', '' ) );

				$check_settings = array(
					'preset' => $isb_set['preset'],
					'style' => $isb_set['style'],
					'color' => $isb_set['color'],
					'position' => $isb_set['position'],
					'special' => $isb_set['special'],
					'special_text' => $isb_set['special_text']
				);

				if ( is_array( $curr_badge ) && isset( $curr_badge[0] ) ) {
					$curr_badge = $curr_badge[0];
					$isb_set = $curr_badge;
					foreach ( $check_settings as $k => $v ) {
						$curr_badge[$k] = ( isset( $curr_badge[$k] ) && $curr_badge[$k] !== '' ? $curr_badge[$k] : $v );
					}
				}
				else {
					$curr_badge = $check_settings;
				}

				$isb_curr_set = $curr_badge;

				if ( isset( $curr_badge['preset'] ) && $curr_badge['preset'] !== '' ) {
					$preset = self::get_preset( $curr_badge['preset'] );
					if ( !empty( $preset ) ) {
						$isb_curr_set = $preset[0];
					}
				}

			?>
				<div id="isb_tab" class="panel woocommerce_options_panel">

					<div class="options_group grouping basic">
						<span class="wc_settings_isb_title"><?php esc_html_e('Badge Settings', 'xforwoocommerce' ); ?></span>
						<div id="isb_preview">
						<?php

							$isb_price['id'] = 1;
							$isb_price['type'] = 'simple';
							$isb_price['regular'] = 32;
							$isb_price['sale'] = 27;
							$isb_price['difference'] = $isb_price['regular'] - $isb_price['sale'];
							$isb_price['percentage'] = round( ( $isb_price['regular'] - $isb_price['sale'] ) * 100 / $isb_price['regular'] );
							$isb_price['time'] = '2:04:50';
							$isb_price['time_mode'] = 'end';

							if ( is_array($isb_curr_set) ) {
								$isb_class = ( $isb_curr_set['special'] !== '' ? $isb_curr_set['special'] : $isb_curr_set['style'] ) . ' ' . $isb_curr_set['color'] . ' ' . $isb_curr_set['position'];
							}
							else {
								$isb_class = 'isb_style_shopkit isb_sk_material isb_left';
							}

							if ( $isb_curr_set['special'] !== '' ) {
								$include = ImprovedBadges()->plugin_path() . '/includes/specials/' . $isb_curr_set['special'] . '.php';
							}
							else {
								$include = ImprovedBadges()->plugin_path() . '/includes/styles/' . $isb_curr_set['style'] . '.php';
							}

							if ( file_exists ( $include ) ) {
								include( $include );
							}

						?>
						</div>
						<p class="form-field isb_preset">
							<label for="wc_settings_isb_preset"><?php esc_html_e('Badge Preset', 'xforwoocommerce' ); ?></label>
							<?php $presets = get_option( 'wcmn_isb_presets', array() ); ?>
							<select id="wc_settings_isb_preset" name="isb_preset_single" class="option select short">
								<option value=""<?php echo ( isset( $isb_set['preset'] ) && $isb_set['preset'] == '' ? ' selected="selected"' : '' ); ?>><?php esc_html_e( 'None', 'xforwoocommerce' ); ?></option>
								<?php
									if ( !empty( $presets ) ) {
										foreach ( $presets as $k2 => $v1 ) {
									?>
											<option value="<?php echo esc_attr( $k2 ); ?>"<?php echo ( isset( $isb_set['preset'] ) && $isb_set['preset'] == $k2 ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $v1 ); ?></option>
									<?php
										}
									}
								?>
							</select>
						</p>
						<p class="form-field isb_style isb_no_preset">
							<label for="wc_settings_isb_style"><?php esc_html_e('Badge Style', 'xforwoocommerce' ); ?></label>
							<select id="wc_settings_isb_style" name="isb_style_single" class="option select short">
								<option value=""<?php echo ( isset($isb_set['style'] ) ? ' selected="selected"' : '' ); ?>><?php esc_html_e('None', 'xforwoocommerce' ); ?></option>
						<?php
							foreach ( self::$isb_style as $k => $v ) {
								printf('<option value="%1$s"%3$s>%2$s</option>', esc_attr( $k ), esc_html( $v ), ( $isb_set['style'] == $k ? ' selected="selected"' : '' ) );
							}
						?>
							</select>
						</p>
						<p class="form-field isb_color isb_no_preset">
							<label for="wc_settings_isb_color"><?php esc_html_e('Badge Color', 'xforwoocommerce' ); ?></label>
							<select id="wc_settings_isb_color" name="isb_color_single" class="option select short">
								<option value=""<?php echo ( isset($isb_set['color']) ? ' selected="selected"' : '' ); ?>><?php esc_html_e('None', 'xforwoocommerce' ); ?></option>
						<?php
							foreach ( self::$isb_color as $k => $v ) {
								printf('<option value="%1$s"%3$s>%2$s</option>', esc_attr( $k ), esc_html( $v ), ( $isb_set['color'] == $k ? ' selected="selected"' : '' ) );
							}
						?>
							</select>
						</p>
						<p class="form-field isb_position isb_no_preset">
							<label for="wc_settings_isb_position"><?php esc_html_e('Badge Position', 'xforwoocommerce' ); ?></label>
							<select id="wc_settings_isb_position" name="isb_position_single" class="option select short">
								<option value=""<?php echo ( isset($isb_set['position']) ? ' selected="selected"' : '' ); ?>><?php esc_html_e('None', 'xforwoocommerce' ); ?></option>
						<?php
							foreach ( self::$isb_position as $k => $v ) {
								printf('<option value="%1$s"%3$s>%2$s</option>', esc_attr( $k ), esc_html( $v ), ( $isb_set['position'] == $k ? ' selected="selected"' : '' ) );
							}
						?>
							</select>
						</p>
						<p class="form-field isb_special_badge isb_no_preset">
							<label for="wc_settings_isb_special"><?php esc_html_e('Special Badge', 'xforwoocommerce' ); ?></label>
							<select id="wc_settings_isb_special" name="isb_style_special" class="option select short">
								<option value=""<?php echo ( isset($isb_set['special']) ? ' selected="selected"' : '' ); ?>><?php esc_html_e('None', 'xforwoocommerce' ); ?></option>
						<?php
							foreach ( self::$isb_style_special as $k => $v ) {
								printf('<option value="%1$s"%3$s>%2$s</option>', esc_attr( $k ), esc_html( $v ), ( isset($isb_set['special']) && $isb_set['special'] == $k ? ' selected="selected"' : '' ) );
							}
						?>
							</select>
						</p>
						<p class="form-field isb_special_text isb_no_preset">
							<label for="wc_settings_isb_special_text"><?php esc_html_e('Special Badge Text', 'xforwoocommerce' ); ?></label>
							<textarea id="wc_settings_isb_special_text" name="isb_style_special_text" class="option short"><?php echo ( isset( $isb_set['special_text'] ) ? stripslashes( $isb_set['special_text'] ) : '' ); ?></textarea>
						</p>
					</div>

				</div>
			<?php
			}
		}

		public static function isb_product_save( $curr_id ) {
			if ( get_option( 'wc_settings_isb_overrides', 'no' ) == 'yes' ) {
				$curr = array();

				if ( isset( $_POST['product-type'] ) ) {
					$curr = array(
						'preset' => ( isset($_POST['isb_preset_single']) ? $_POST['isb_preset_single'] : '' ),
						'style' => ( isset($_POST['isb_style_single']) ? $_POST['isb_style_single'] : '' ),
						'color' => ( isset($_POST['isb_color_single']) ? $_POST['isb_color_single'] : '' ),
						'position' => ( isset($_POST['isb_position_single']) ? $_POST['isb_position_single'] : '' ),
						'special' => ( isset($_POST['isb_style_special']) ? $_POST['isb_style_special'] : '' ),
						'special_text' => ( isset($_POST['isb_style_special_text']) ? $_POST['isb_style_special_text'] : '' )
					);
					update_post_meta( $curr_id, '_isb_settings', $curr );
				}
			}
		}

		public static function get_preset( $preset ) {

			if ( $preset == '' ) {
				return array();
			}

			$process = get_option( '_wcmn_isb_preset_' . $preset, array() );
			if ( isset( $process['name'] ) ) {
				return array( 0 => $process );
			}
			else {
				return array();
			}

		}

	}

	add_action( 'init', array( 'XforWC_Improved_Badges_Settings', 'init' ), 100 );
	if ( isset($_GET['page'], $_GET['tab']) && ($_GET['page'] == 'wc-settings' ) && $_GET['tab'] == 'improved_badges' ) {
		add_action( 'svx_plugins_settings', array( 'XforWC_Improved_Badges_Settings', 'get_settings' ), 50 );
	}

?>