<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	class ShopKit_Ot_Settings {

		protected static $settings;
		public static $mode;

		public static function init() {
			$class = __CLASS__;
			new $class;
		}

		function __construct() {

			add_filter( 'ot_options_id', __CLASS__ . '::ot_options_id' );
			add_filter( 'ot_settings_id', __CLASS__ . '::ot_settings_id' );
			add_filter( 'ot_layouts_id', __CLASS__ . '::ot_layouts_id' );

			if ( is_admin() ) {
				if ( isset( $_REQUEST['page'] ) && substr( $_REQUEST['page'], 0, 7 ) == 'shopkit' ) {
					add_filter( 'ot_theme_options_page_title', __CLASS__ . '::ot_page_title' );
					add_filter( 'ot_recognized_font_families', __CLASS__ . '::font_families', 10, 2 );
					add_action( 'ot_admin_scripts_after', __CLASS__ . '::ot_add_scripts' );
					add_filter( 'ot_header_logo_link', __CLASS__ . '::ot_shopkit_logo' );
					add_filter( 'ot_header_version_text', __CLASS__ . '::ot_shopkit_title' );
				}
				add_filter( 'ot_theme_options_menu_slug', __CLASS__ . '::ot_menu_slug' );
				add_filter( 'ot_theme_options_menu_title', __CLASS__ . '::ot_menu_title' );
			}

			add_action( 'init', __CLASS__ . '::general_settings', 15 );

			self::$settings['layouts'] = array();

			self::$settings['theme'] = wp_get_theme();

			self::$mode = ( is_child_theme() ? str_replace( '-', '_', sanitize_title( self::$settings['theme']->get( 'Name' ) ) ) : 'shopkit' );

			add_action( 'widgets_init', __CLASS__ . '::register_sidebars' );

		}

		public static function ot_shopkit_logo( $logo ) {
			return '<a id="shopkit-save" href="#" title="' . esc_html__( 'Save Changes', 'shopkit' ) . '"><img src="' . WcSk()->template_url() . '/library/images/option-tree/sk-ot.png" alt="ShopKit" /></a>';
		}

		public static function ot_shopkit_title( $title ) {
			return 'ShopKit';
		}

		public static function ot_add_scripts() {

			if ( substr( get_current_screen()->id, 0, 24 ) == 'appearance_page_shopkit-' ) {

				wp_enqueue_style( 'shopkit-less', WcSk()->template_url() . '/framework/css/settings.css' );

				wp_register_script( 'shopkit-ot', WcSk()->template_url() . '/framework/js/admin.js', array( 'jquery' ), WcSk()->version(), true );
				wp_enqueue_script( 'shopkit-ot' );

				$args = array(
					'ajax' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'locale' => array(
						'error' => esc_html__( 'Error!', 'shopkit' ),
						'save_notready_colors' => esc_html__( 'All colors must be set! Please set:', 'shopkit' ),
						'save_notready_fonts' => esc_html__( 'Font sizes and line heights must be set! Please set:', 'shopkit' )
					)
				);

				wp_localize_script( 'shopkit-ot', 'shopkit', $args );

			}

		}

		public static function ot_options_id() {
			return self::$mode . '_general';
		}

		public static function ot_settings_id() {
			return self::$mode . '_general_settings';
		}

		public static function ot_layouts_id() {
			return self::$mode . '_layouts';
		}

		public static function ot_menu_slug() {
			return'shopkit-general';
		}

		public static function ot_page_title() {
			return esc_html__( 'ShopKit', 'shopkit' );
		}

		public static function ot_menu_title() {
			return esc_html__( 'ShopKit', 'shopkit' );
		}


		public static function get_settings( $option_group = 'general', $option_id, $default = '', $reset_settings = false ) {

			$options_slug = $option_group == 'general' ? self::$mode . '_general' : self::$mode . '_section_' . $option_group;

			if ( $reset_settings === true ) {
				$options = get_option( $options_slug, array() );
			}
			else {
				$options = isset( self::$settings[$option_group] ) && !empty( self::$settings[$option_group] ) ? self::$settings[$option_group] : get_option( $options_slug, array() ) ;
			}

			if ( isset( $options[$option_id] ) ) {
				return ot_wpml_filter( $options, $option_id );
			}
			else if ( strpos( $option_id, 'visibility' )>0 ) {
				return array();
			}

			if ( $default == '' || $default == array() ) {
				if ( isset( self::$settings[$option_group . '_default']['settings'][$option_id]['std'] ) ) {
					return self::$settings[$option_group . '_default']['settings'][$option_id]['std'];
				}

			}

			return $default;

		}


		public static function general_settings() {

			$saved_settings = get_option( ot_settings_id(), array() );

	$sections_array = array(
		'select_element' => array(
			'id'          => 'select_element',
			'label'       => esc_html__( 'Select Section', 'shopkit' ),
			'desc'        => esc_html__( 'Select section type.', 'shopkit' ),
			'std'         => 'elements-bar',
			'type'        => 'select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
				array(
					'value'       => 'elements-bar',
					'label'       => esc_html__( 'Elements Bar', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'widget-section',
					'label'       => esc_html__( 'Widget Section', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'content-text-html',
					'label'       => esc_html__( 'Content Text/HTML/Shortcode', 'shopkit' ),
					'src'         => ''
				)
			 )
		 ),
		'fullwidth' => array(
			'id'          => 'fullwidth',
			'label'       => esc_html__( 'Fullwidth Section', 'shopkit' ),
			'desc'        => esc_html__( 'Set element width to fullwidth.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => ''
		)
	);

	$layout_sections = apply_filters( 'shopkit_settings_sections', array(
		array(
			'id'          => 'branding',
			'title'       => esc_html__( 'Branding', 'shopkit' ),
			'type'        => 'shopkit'
		),
		array(
			'id'          => 'elements',
			'title'       => esc_html__( 'Website Elements', 'shopkit' ),
			'type'        => 'shopkit'
		),
		array(
			'id'          => 'content',
			'title'       => esc_html__( 'General Styles', 'shopkit' ),
			'type'        => 'shopkit'
		),
		array(
			'id'          => 'page',
			'title'       => esc_html__( 'Pages, Posts and Blog', 'shopkit' ),
			'type'        => 'shopkit'
		),
		array(
			'id'          => 'layout',
			'title'       => esc_html__( 'Layout and Custom CSS', 'shopkit' ),
			'type'        => 'shopkit'
		),
		array(
			'id'          => 'sticky',
			'title'       => esc_html__( 'Sticky Header', 'shopkit' ),
			'type'        => 'shopkit'
		),
		array(
			'id'          => 'sidebars',
			'title'       => esc_html__( 'Sidebars', 'shopkit' ),
			'type'        => 'shopkit'
		)
	) );

	$button_styles = array(
		array(
			'value'       => 'filled',
			'label'       => esc_html__( 'Filled', 'shopkit' ),
			'src'         => ''
		),
		array(
			'value'       => 'bordered',
			'label'       => esc_html__( 'Bordered', 'shopkit' ),
			'src'         => ''
		),
		array(
			'value'       => 'glossy',
			'label'       => esc_html__( 'Glossy', 'shopkit' ),
			'src'         => ''
		),
		array(
			'value'       => 'diamond',
			'label'       => esc_html__( 'Diamond', 'shopkit' ),
			'src'         => ''
		),
		array(
			'value'       => 'hued',
			'label'       => esc_html__( 'Hued', 'shopkit' ),
			'src'         => ''
		),
		array(
			'value'       => 'hued-3d',
			'label'       => esc_html__( 'Hued 3D', 'shopkit' ),
			'src'         => ''
		)
	);

	$custom_settings = array( 
		'contextual_help' => array(
			'sidebar'       => ''
		),
		'sections'        => $layout_sections,
		'settings'        => array(
		'header_elements' => array(
			'id'          => 'header_elements',
			'label'       => esc_html__( 'Header Elements', 'shopkit' ),
			'desc'        => esc_html__( 'Use the manager to add elements to the header area. Section titles cannot be changed.', 'shopkit' ),
			'std'         => array(),
			'type'        => 'list-item',
			'section'     => 'elements',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'settings'    => $sections_array
		),
		'footer_elements' => array(
			'id'          => 'footer_elements',
			'label'       => esc_html__( 'Footer Elements', 'shopkit' ),
			'desc'        => esc_html__( 'Use the manager to add elements to the footer area. Section titles cannot be changed.', 'shopkit' ),
			'std'         => array(),
			'type'        => 'list-item',
			'section'     => 'elements',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'settings'    => $sections_array
		),

		'sticky_header' => array(
			'id'          => 'sticky_header',
			'label'       => esc_html__( 'Sticky Header', 'shopkit' ),
			'desc'        => esc_html__( 'Activate Sticky Header.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'sticky',
		),

		'sticky_top' => array(
			'id'          => 'sticky_top',
			'label'       => esc_html__( 'Sticky From Top', 'shopkit' ),
			'desc'        => esc_html__( 'How long to scroll before activating Sticky Header (in pixels).', 'shopkit' ),
			'std'         => '200',
			'type'        => 'numeric-slider',
			'section'     => 'sticky',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '0,500,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),

		'sticky_anim' => array(
			'id'          => 'sticky_anim',
			'label'       => esc_html__( 'Sticky Animation Duration', 'shopkit' ),
			'desc'        => esc_html__( 'Set Sticky Header slide in/out animation duration (in milisecons).', 'shopkit' ),
			'std'         => '500',
			'type'        => 'numeric-slider',
			'section'     => 'sticky',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '0,2000,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),

		'logo_image' => array(
			'id'          => 'logo_image',
			'label'       => esc_html__( 'Logo/Image', 'shopkit' ),
			'desc'        => esc_html__( 'Select logo/image.', 'shopkit' ),
			'std'         => '',
			'type'        => 'upload',
			'section'     => 'branding',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'logo_image_link' => array(
			'id'          => 'logo_image_link',
			'label'       => esc_html__( 'Logo/Image Link', 'shopkit' ),
			'desc'        => esc_html__( 'Enter logo/image link. Leave blank to use the website home page.', 'shopkit' ),
			'std'         => '',
			'type'        => 'text',
			'section'     => 'branding',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'site_title_font' => array(
			'id'          => 'site_title_font',
			'label'       => esc_html__( 'Site Title Font', 'shopkit' ),
			'desc'        => esc_html__( 'Select site title font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'section'     => 'branding',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'site_description_font' => array(
			'id'          => 'site_description_font',
			'label'       => esc_html__( 'Site Description Font', 'shopkit' ),
			'desc'        => esc_html__( 'Select site description font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'section'     => 'branding',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'favorites_icon' => array(
			'id'          => 'favorites_icon',
			'label'       => esc_html__( 'Favorites Icon', 'shopkit' ),
			'desc'        => esc_html__( 'Select favorites icon.', 'shopkit' ),
			'std'         => '',
			'type'        => 'upload',
			'section'     => 'branding',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'favorites_ipad57' => array(
			'id'          => 'favorites_ipad57',
			'label'       => esc_html__( 'iDevices 57x57px', 'shopkit' ),
			'desc'        => esc_html__( 'Select favorites iDevices icon 57x57px.', 'shopkit' ),
			'std'         => '',
			'type'        => 'upload',
			'section'     => 'branding',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'favorites_ipad72' => array(
			'id'          => 'favorites_ipad72',
			'label'       => esc_html__( 'iDevices 72x72px', 'shopkit' ),
			'desc'        => esc_html__( 'Select favorites iDevices icon 72x72px.', 'shopkit' ),
			'std'         => '',
			'type'        => 'upload',
			'section'     => 'branding',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'favorites_ipad114' => array(
			'id'          => 'favorites_ipad114',
			'label'       => esc_html__( 'iDevices 114x114px', 'shopkit' ),
			'desc'        => esc_html__( 'Select favorites iDevices icon 114x114px.', 'shopkit' ),
			'std'         => '',
			'type'        => 'upload',
			'section'     => 'branding',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'favorites_ipad144' => array(
			'id'          => 'favorites_ipad144',
			'label'       => esc_html__( 'iDevices 144x144px', 'shopkit' ),
			'desc'        => esc_html__( 'Select favorites iDevices icon 142x142px.', 'shopkit' ),
			'std'         => '',
			'type'        => 'upload',
			'section'     => 'branding',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'seo_publisher' => array(
			'id'          => 'seo_publisher',
			'label'       => esc_html__( 'Site Publisher Google+ Profile', 'shopkit' ),
			'desc'        => esc_html__( 'Enter site publisher google+ profile ID.', 'shopkit' ),
			'std'         => '',
			'type'        => 'text',
			'section'     => 'branding',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'fb_publisher' => array(
			'id'          => 'fb_publisher',
			'label'       => esc_html__( 'Site Publisher Facebook Profile', 'shopkit' ),
			'desc'        => esc_html__( 'Enter site publisher facebook profile ID.', 'shopkit' ),
			'std'         => '',
			'type'        => 'text',
			'section'     => 'branding',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'wrapper_padding' => array(
			'id'          => 'wrapper_padding',
			'label'       => esc_html__( 'Wrapper Padding', 'shopkit' ),
			'desc'        => esc_html__( 'Enter padding for the wrapper. e.g. 10px 0px 10px 0px', 'shopkit' ),
			'std'         => '',
			'type'        => 'text',
			'section'     => 'layout',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'wrapper_mode' => array(
			'id'          => 'wrapper_mode',
			'label'       => esc_html__( 'Wrapper Mode', 'shopkit' ),
			'desc'        => esc_html__( 'Select wrapper mode.', 'shopkit' ),
			'std'         => 'shopkit-central',
			'type'        => 'select',
			'section'     => 'layout',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'shopkit-central',
				'label'       => esc_html__( 'Central', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-left',
				'label'       => esc_html__( 'On Left', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-right',
				'label'       => esc_html__( 'On Right', 'shopkit' ),
				'src'         => ''
			)
			)
		),
		'wrapper_width' => array(
			'id'          => 'wrapper_width',
			'label'       => esc_html__( 'Wrapper Width', 'shopkit' ),
			'desc'        => esc_html__( 'Set your website maximum width.', 'shopkit' ),
			'std'         => '1920',
			'type'        => 'numeric-slider',
			'section'     => 'layout',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '800,4096,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'inner_wrapper_width' => array(
			'id'          => 'inner_wrapper_width',
			'label'       => esc_html__( 'Inner Wrapper Width', 'shopkit' ),
			'desc'        => esc_html__( 'Set your website maximum width.', 'shopkit' ),
			'std'         => '1340',
			'type'        => 'numeric-slider',
			'section'     => 'layout',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '800,1920,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'columns_margin' => array(
			'id'          => 'columns_margin',
			'label'       => esc_html__( 'Columns Margin', 'shopkit' ),
			'desc'        => esc_html__( 'Set margin between columns.', 'shopkit' ),
			'std'         => '30',
			'type'        => 'numeric-slider',
			'section'     => 'layout',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '10,90,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'rows_margin' => array(
			'id'          => 'rows_margin',
			'label'       => esc_html__( 'Row Margin', 'shopkit' ),
			'desc'        => esc_html__( 'Set margin between rows.', 'shopkit' ),
			'std'         => '60',
			'type'        => 'numeric-slider',
			'section'     => 'layout',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '10,90,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'custom_css' => array(
			'id'          => 'custom_css',
			'label'       => esc_html__( 'Custom CSS', 'shopkit' ),
			'desc'        => esc_html__( 'Write custom CSS for the website.', 'shopkit' ),
			'std'         => '',
			'type'        => 'css',
			'section'     => 'layout',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_padding' => array(
			'id'          => 'content_padding',
			'label'       => esc_html__( 'Content Padding', 'shopkit' ),
			'desc'        => esc_html__( 'Enter padding for the content area. e.g. 10px 0px 10px 0px', 'shopkit' ),
			'std'         => '',
			'type'        => 'text',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_font' => array(
			'id'          => 'content_font',
			'label'       => esc_html__( 'Content Font', 'shopkit' ),
			'desc'        => esc_html__( 'Select content font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_link' => array(
			'id'          => 'content_link',
			'label'       => esc_html__( 'Content Link', 'shopkit' ),
			'desc'        => esc_html__( 'Select the link color in the content. Color opacity is supported.', 'shopkit' ),
			'std'         => '',
			'type'        => 'colorpicker-opacity',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_link_hover' => array(
			'id'          => 'content_link_hover',
			'label'       => esc_html__( 'Content Link Hover', 'shopkit' ),
			'desc'        => esc_html__( 'Select the link hover color in the content. Color opacity is supported.', 'shopkit' ),
			'std'         => '',
			'type'        => 'colorpicker-opacity',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_separator' => array(
			'id'          => 'content_separator',
			'label'       => esc_html__( 'Content Separator', 'shopkit' ),
			'desc'        => esc_html__( 'Select the separator color in the content. Color opacity is supported.', 'shopkit' ),
			'std'         => '',
			'type'        => 'colorpicker-opacity',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_button_font' => array(
			'id'          => 'content_button_font',
			'label'       => esc_html__( 'Content Button', 'shopkit' ),
			'desc'        => esc_html__( 'Set the content button settings. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_button_hover_font' => array(
			'id'          => 'content_button_hover_font',
			'label'       => esc_html__( 'Content Button Hover', 'shopkit' ),
			'desc'        => esc_html__( 'Set the content button hover settings. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_button_style' => array(
			'id'          => 'content_button_style',
			'label'       => esc_html__( 'Content Button Style', 'shopkit' ),
			'desc'        => esc_html__( 'Select content button style.', 'shopkit' ),
			'std'         => 'filled',
			'type'        => 'select',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => $button_styles
		),
		'content_background' => array(
			'id'          => 'content_background',
			'label'       => esc_html__( 'Content Background', 'shopkit' ),
			'desc'        => esc_html__( 'Select the background color for the content. Color opacity is supported.', 'shopkit' ),
			'std'         => '',
			'type'        => 'background',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_boxshadow' => array(
			'id'          => 'content_boxshadow',
			'label'       => esc_html__( 'Content Shadow', 'shopkit' ),
			'desc'        => esc_html__( 'Create a shadow for the content area.', 'shopkit' ),
			'std'         => '',
			'type'        => 'box-shadow',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_h1_font' => array(
			'id'          => 'content_h1_font',
			'label'       => esc_html__( 'Content H1 Font', 'shopkit' ),
			'desc'        => esc_html__( 'Select content h1 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_h2_font' => array(
			'id'          => 'content_h2_font',
			'label'       => esc_html__( 'Content H2 Font', 'shopkit' ),
			'desc'        => esc_html__( 'Select content h2 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_h3_font' => array(
			'id'          => 'content_h3_font',
			'label'       => esc_html__( 'Content H3 Font', 'shopkit' ),
			'desc'        => esc_html__( 'Select content h3 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_h4_font' => array(
			'id'          => 'content_h4_font',
			'label'       => esc_html__( 'Content H4 Font', 'shopkit' ),
			'desc'        => esc_html__( 'Select content h4 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_h5_font' => array(
			'id'          => 'content_h5_font',
			'label'       => esc_html__( 'Content H5 Font', 'shopkit' ),
			'desc'        => esc_html__( 'Select content h5 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'content_h6_font' => array(
			'id'          => 'content_h6_font',
			'label'       => esc_html__( 'Content H6 Font', 'shopkit' ),
			'desc'        => esc_html__( 'Select content h6 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'_wrapper_background' => array(
			'id'          => '_wrapper_background',
			'label'       => esc_html__( 'Wrapper Background', 'shopkit' ),
			'desc'        => esc_html__( 'Select the background color for the wrapper. Color opacity is supported.', 'shopkit' ),
			'std'         => '',
			'type'        => 'background',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'_wrapper_boxshadow' => array(
			'id'          => '_wrapper_boxshadow',
			'label'       => esc_html__( 'Wrapper Shadow', 'shopkit' ),
			'desc'        => esc_html__( 'Create a shadow for the wrapper.', 'shopkit' ),
			'std'         => '',
			'type'        => 'box-shadow',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'_header_background' => array(
			'id'          => '_header_background',
			'label'       => esc_html__( 'Header Background', 'shopkit' ),
			'desc'        => esc_html__( 'Select the background color for the header. Color opacity is supported.', 'shopkit' ),
			'std'         => '',
			'type'        => 'background',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'_header_boxshadow' => array(
			'id'          => '_header_boxshadow',
			'label'       => esc_html__( 'Header Shadow', 'shopkit' ),
			'desc'        => esc_html__( 'Create a shadow for the header.', 'shopkit' ),
			'std'         => '',
			'type'        => 'box-shadow',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'_footer_background' => array(
			'id'          => '_footer_background',
			'label'       => esc_html__( 'Footer Background', 'shopkit' ),
			'desc'        => esc_html__( 'Select the background color for the footer. Color opacity is supported.', 'shopkit' ),
			'std'         => '',
			'type'        => 'background',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'_footer_boxshadow' => array(
			'id'          => '_footer_boxshadow',
			'label'       => esc_html__( 'Footer Shadow', 'shopkit' ),
			'desc'        => esc_html__( 'Create a shadow for the footer.', 'shopkit' ),
			'std'         => '',
			'type'        => 'box-shadow',
			'section'     => 'content',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'page_title' => array(
			'id'          => 'page_title',
			'label'       => esc_html__( 'Page Title', 'shopkit' ),
			'desc'        => esc_html__( 'Set the page title appearance.', 'shopkit' ),
			'std'         => 'content',
			'type'        => 'select',
			'section'     => 'page',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array(
				array(
					'value'       => 'none',
					'label'       => esc_html__( 'Hide', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'content',
					'label'       => esc_html__( 'Above Page Content', 'shopkit' ),
					'src'         => ''
				),
			)
		),
		'page_comments' => array(
			'id'          => 'page_comments',
			'label'       => esc_html__( 'Page Comments', 'shopkit' ),
			'desc'        => esc_html__( 'Set the page comments appearance.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'page',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => ''
		),
		'blog_style' => array(
			'id'          => 'blog_style',
			'label'       => esc_html__( 'Blog Style', 'shopkit' ),
			'desc'        => esc_html__( 'Select blog style.', 'shopkit' ),
			'std'         => 'full',
			'type'        => 'select',
			'section'     => 'page',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'full',
				'label'       => esc_html__( 'Fullwidth Featured Area', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'compact',
				'label'       => esc_html__( 'Compact Design', 'shopkit' ),
				'src'         => ''
			)
			)
		),
		'post_comments' => array(
			'id'          => 'post_comments',
			'label'       => esc_html__( 'Post Comments', 'shopkit' ),
			'desc'        => esc_html__( 'Set the post comments appearance.', 'shopkit' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'page',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => ''
		),
		'404_image' => array(
			'id'          => '404_image',
			'label'       => esc_html__( '404 Image', 'shopkit' ),
			'desc'        => esc_html__( 'Select 404 page image.', 'shopkit' ),
			'std'         => '',
			'type'        => 'upload',
			'section'     => 'page',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'sidebar_heading' => array(
			'id'          => 'sidebar_heading',
			'label'       => esc_html__( 'Widget Titles', 'shopkit' ),
			'desc'        => esc_html__( 'Select widget title size.', 'shopkit' ),
			'std'         => 'h3',
			'type'        => 'select',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'h2',
				'label'       => 'H2',
				'src'         => ''
			),
			array(
				'value'       => 'h3',
				'label'       => 'H3',
				'src'         => ''
			),
			array(
				'value'       => 'h4',
				'label'       => 'H4',
				'src'         => ''
			),
			array(
				'value'       => 'h5',
				'label'       => 'H5',
				'src'         => ''
			),
			array(
				'value'       => 'h6',
				'label'       => 'H6',
				'src'         => ''
			)
			)
		),
		'left_sidebar_1' => array(
			'id'          => 'left_sidebar_1',
			'label'       => esc_html__( 'Left Sidebar #1', 'shopkit' ),
			'desc'        => esc_html__( 'Use left sidebar #1.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'left_sidebar_width_1' => array(
			'id'          => 'left_sidebar_width_1',
			'label'       => esc_html__( 'Left Sidebar #1 Width', 'shopkit' ),
			'desc'        => esc_html__( 'Set left sidebar #1 width.', 'shopkit' ),
			'std'         => '200',
			'type'        => 'numeric-slider',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '90,400,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'left_sidebar_1_visibility' => array(
			'id'          => 'left_sidebar_1_visibility',
			'label'       => esc_html__( 'Element Visibility', 'shopkit' ),
			'desc'        => esc_html__( 'Check responsive modes to hide the element.', 'shopkit' ),
			'std'         => '',
			'type'        => 'checkbox',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'shopkit-responsive-low',
				'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-medium',
				'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-high',
				'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
				'src'         => ''
			)
			)
		),
		'left_sidebar_2' => array(
			'id'          => 'left_sidebar_2',
			'label'       => esc_html__( 'Left Sidebar #2', 'shopkit' ),
			'desc'        => esc_html__( 'Use left sidebar #2.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'left_sidebar_width_2' => array(
			'id'          => 'left_sidebar_width_2',
			'label'       => esc_html__( 'Left Sidebar #2 Width', 'shopkit' ),
			'desc'        => esc_html__( 'Set left sidebar #2 width.', 'shopkit' ),
			'std'         => '200',
			'type'        => 'numeric-slider',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '90,400,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'left_sidebar_2_visibility' => array(
			'id'          => 'left_sidebar_2_visibility',
			'label'       => esc_html__( 'Element Visibility', 'shopkit' ),
			'desc'        => esc_html__( 'Check responsive modes to hide the element.', 'shopkit' ),
			'std'         => '',
			'type'        => 'checkbox',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'shopkit-responsive-low',
				'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-medium',
				'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-high',
				'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
				'src'         => ''
			)
			)
		),
		'right_sidebar_1' => array(
			'id'          => 'right_sidebar_1',
			'label'       => esc_html__( 'Right Sidebar #1', 'shopkit' ),
			'desc'        => esc_html__( 'Use right sidebar #1.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'right_sidebar_width_1' => array(
			'id'          => 'right_sidebar_width_1',
			'label'       => esc_html__( 'Right Sidebar #1 Width', 'shopkit' ),
			'desc'        => esc_html__( 'Set right sidebar #1 width.', 'shopkit' ),
			'std'         => '200',
			'type'        => 'numeric-slider',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '90,400,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'right_sidebar_1_visibility' => array(
			'id'          => 'right_sidebar_1_visibility',
			'label'       => esc_html__( 'Element Visibility', 'shopkit' ),
			'desc'        => esc_html__( 'Check responsive modes to hide the element.', 'shopkit' ),
			'std'         => '',
			'type'        => 'checkbox',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'shopkit-responsive-low',
				'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-medium',
				'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-high',
				'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
				'src'         => ''
			)
			)
		),
		'right_sidebar_2' => array(
			'id'          => 'right_sidebar_2',
			'label'       => esc_html__( 'Right Sidebar #2', 'shopkit' ),
			'desc'        => esc_html__( 'Use right sidebar #2.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'right_sidebar_width_2' => array(
			'id'          => 'right_sidebar_width_2',
			'label'       => esc_html__( 'Right Sidebar #2 Width', 'shopkit' ),
			'desc'        => esc_html__( 'Set right sidebar #2 width.', 'shopkit' ),
			'std'         => '200',
			'type'        => 'numeric-slider',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '90,400,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'right_sidebar_2_visibility' => array(
			'id'          => 'right_sidebar_2_visibility',
			'label'       => esc_html__( 'Element Visibility', 'shopkit' ),
			'desc'        => esc_html__( 'Check responsive modes to hide the element.', 'shopkit' ),
			'std'         => '',
			'type'        => 'checkbox',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'shopkit-responsive-low',
				'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-medium',
				'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-high',
				'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
				'src'         => ''
			)
			)
		),
		'sidebars' => array(
			'id'          => 'sidebars',
			'label'       => esc_html__( 'Create Sidebar Layouts', 'shopkit' ),
			'desc'        => esc_html__( 'Use the sidebar layout manager to create new sidebar layouts.', 'shopkit' ),
			'type'        => 'list-item',
			'section'     => 'sidebars',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'settings'    => array(
					'display_condition' => array(
						'id'          => 'display_condition',
						'label'       => esc_html__( 'Sidebars Display Condition', 'shopkit' ),
						'desc'        => esc_html__( 'Enter condition when to show current sidebar layout. e.g. is_woocommerce', 'shopkit' ),
						'std'         => '',
						'type'        => 'text',
						'section'     => 'sidebars',
						'rows'        => '',
						'post_type'   => '',
						'taxonomy'    => '',
						'min_max_step'=> '',
						'class'       => '',
						'condition'   => '',
						'operator'    => 'and'
					),
				'left_sidebar_1' => array(
					'id'          => 'left_sidebar_1',
					'label'       => esc_html__( 'Left Sidebar #1', 'shopkit' ),
					'desc'        => esc_html__( 'Use left sidebar #1.', 'shopkit' ),
					'std'         => 'off',
					'type'        => 'on-off',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and'
				),
				'left_sidebar_width_1' => array(
					'id'          => 'left_sidebar_width_1',
					'label'       => esc_html__( 'Left Sidebar #1 Width', 'shopkit' ),
					'desc'        => esc_html__( 'Set left sidebar #1 width.', 'shopkit' ),
					'std'         => '200',
					'type'        => 'numeric-slider',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '90,400,1',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and'
				),
				'left_sidebar_1_visibility' => array(
					'id'          => 'left_sidebar_1_visibility',
					'label'       => esc_html__( 'Element Visibility', 'shopkit' ),
					'desc'        => esc_html__( 'Check responsive modes to hide the element.', 'shopkit' ),
					'std'         => '',
					'type'        => 'checkbox',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and',
					'choices'     => array( 
					array(
						'value'       => 'shopkit-responsive-low',
						'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
						'src'         => ''
					),
					array(
						'value'       => 'shopkit-responsive-medium',
						'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
						'src'         => ''
					),
					array(
						'value'       => 'shopkit-responsive-high',
						'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
						'src'         => ''
					)
					)
				),
				'left_sidebar_2' => array(
					'id'          => 'left_sidebar_2',
					'label'       => esc_html__( 'Left Sidebar #2', 'shopkit' ),
					'desc'        => esc_html__( 'Use left sidebar #2.', 'shopkit' ),
					'std'         => 'off',
					'type'        => 'on-off',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and'
				),
				'left_sidebar_width_2' => array(
					'id'          => 'left_sidebar_width_2',
					'label'       => esc_html__( 'Left Sidebar #2 Width', 'shopkit' ),
					'desc'        => esc_html__( 'Set left sidebar #2 width.', 'shopkit' ),
					'std'         => '200',
					'type'        => 'numeric-slider',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '90,400,1',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and'
				),
				'left_sidebar_2_visibility' => array(
					'id'          => 'left_sidebar_2_visibility',
					'label'       => esc_html__( 'Element Visibility', 'shopkit' ),
					'desc'        => esc_html__( 'Check responsive modes to hide the element.', 'shopkit' ),
					'std'         => '',
					'type'        => 'checkbox',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and',
					'choices'     => array( 
					array(
						'value'       => 'shopkit-responsive-low',
						'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
						'src'         => ''
					),
					array(
						'value'       => 'shopkit-responsive-medium',
						'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
						'src'         => ''
					),
					array(
						'value'       => 'shopkit-responsive-high',
						'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
						'src'         => ''
					)
					)
				),
				'right_sidebar_1' => array(
					'id'          => 'right_sidebar_1',
					'label'       => esc_html__( 'Right Sidebar #1', 'shopkit' ),
					'desc'        => esc_html__( 'Use right sidebar #1.', 'shopkit' ),
					'std'         => 'off',
					'type'        => 'on-off',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and'
				),
				'right_sidebar_width_1' => array(
					'id'          => 'right_sidebar_width_1',
					'label'       => esc_html__( 'Right Sidebar #1 Width', 'shopkit' ),
					'desc'        => esc_html__( 'Set right sidebar #1 width.', 'shopkit' ),
					'std'         => '200',
					'type'        => 'numeric-slider',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '90,400,1',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and'
				),
				'right_sidebar_1_visibility' => array(
					'id'          => 'right_sidebar_1_visibility',
					'label'       => esc_html__( 'Element Visibility', 'shopkit' ),
					'desc'        => esc_html__( 'Check responsive modes to hide the element.', 'shopkit' ),
					'std'         => '',
					'type'        => 'checkbox',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and',
					'choices'     => array( 
					array(
						'value'       => 'shopkit-responsive-low',
						'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
						'src'         => ''
					),
					array(
						'value'       => 'shopkit-responsive-medium',
						'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
						'src'         => ''
					),
					array(
						'value'       => 'shopkit-responsive-high',
						'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
						'src'         => ''
					)
					)
				),
				'right_sidebar_2' => array(
					'id'          => 'right_sidebar_2',
					'label'       => esc_html__( 'Right Sidebar #2', 'shopkit' ),
					'desc'        => esc_html__( 'Use right sidebar #2.', 'shopkit' ),
					'std'         => 'off',
					'type'        => 'on-off',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and'
				),
				'right_sidebar_width_2' => array(
					'id'          => 'right_sidebar_width_2',
					'label'       => esc_html__( 'Right Sidebar #2 Width', 'shopkit' ),
					'desc'        => esc_html__( 'Set right sidebar #2 width.', 'shopkit' ),
					'std'         => '200',
					'type'        => 'numeric-slider',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '90,400,1',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and'
				),
				'right_sidebar_2_visibility' => array(
					'id'          => 'right_sidebar_2_visibility',
					'label'       => esc_html__( 'Element Visibility', 'shopkit' ),
					'desc'        => esc_html__( 'Check responsive modes to hide the element.', 'shopkit' ),
					'std'         => '',
					'type'        => 'checkbox',
					'section'     => 'sidebars',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => '',
					'min_max_step'=> '',
					'class'       => '',
					'condition'   => '',
					'operator'    => 'and',
					'choices'     => array( 
					array(
						'value'       => 'shopkit-responsive-low',
						'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
						'src'         => ''
					),
					array(
						'value'       => 'shopkit-responsive-medium',
						'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
						'src'         => ''
					),
					array(
						'value'       => 'shopkit-responsive-high',
						'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
						'src'         => ''
					)
					)
				),
			)
		),
		'responsive_tablet_mode' => array(
			'id'          => 'responsive_tablet_mode',
			'label'       => esc_html__( 'Responsive Tablet Mode', 'shopkit' ),
			'desc'        => esc_html__( 'Set the minimum resolution for activating the tablet mode.', 'shopkit' ),
			'std'         => '1024',
			'type'        => 'numeric-slider',
			'section'     => 'layout',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '840,1366,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'responsive_tablet_css' => array(
			'id'          => 'responsive_tablet_css',
			'label'       => esc_html__( 'Responsive Tablet Custom CSS', 'shopkit' ),
			'desc'        => esc_html__( 'Write custom CSS for the tablet mode.', 'shopkit' ),
			'std'         => '',
			'type'        => 'css',
			'section'     => 'layout',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'responsive_mobile_mode' => array(
			'id'          => 'responsive_mobile_mode',
			'label'       => esc_html__( 'Responsive Mobile Mode', 'shopkit' ),
			'desc'        => esc_html__( 'Set the minimum resolution for activating the mobile mode.', 'shopkit' ),
			'std'         => '640',
			'type'        => 'numeric-slider',
			'section'     => 'layout',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '320,960,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		'responsive_mobile_css' => array(
			'id'          => 'responsive_mobile_css',
			'label'       => esc_html__( 'Responsive Mobile Custom CSS', 'shopkit' ),
			'desc'        => esc_html__( 'Write custom CSS for the mobile mode.', 'shopkit' ),
			'std'         => '',
			'type'        => 'css',
			'section'     => 'layout',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		)
	    )
	  );

	$custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );

	self::$settings['general_default'] = $custom_settings;

	if ( $saved_settings !== $custom_settings ) {
		update_option( ot_settings_id(), $custom_settings );
	}

	global $ot_has_custom_theme_options;
	$ot_has_custom_theme_options = true;

	$sections = array();

	$header_sections = self::get_settings( 'general', 'header_elements', array(), true );

	foreach( $header_sections as $curr ) {

		$slug = sanitize_title( $curr['title'] );
		$id = str_replace( '-', '_', $slug );

		self::$settings['header_elements'][] = $id;
		self::$settings['layouts'][] = array(
			'id'          => $id,
			'title'       => $curr['title'],
			'slug'        => $slug,
			'type'        => $curr['select_element']
		);

		$sections[] = array(
			'value' => $slug,
			'label' => $curr['title'],
		);

	}

	$footer_sections = self::get_settings( 'general', 'footer_elements', array(), true );

	foreach( $footer_sections as $curr ) {

		$slug = sanitize_title( $curr['title'] );
		$id = str_replace( '-', '_', $slug );

		self::$settings['layouts'][] = array(
			'id'          => $id,
			'title'       => $curr['title'],
			'slug'        => $slug,
			'type'        => $curr['select_element']
		);

		$sections[] = array(
			'value' => $slug,
			'label' => $curr['title'],
		);

	}

	if ( !empty( self::$settings['layouts'] ) ) {

		$layout_sections = self::$settings['layouts'];

		foreach( $layout_sections as $section ) {
			self::$settings[$section['id']] = get_option( self::$mode . '_section_' . $section['id'] );
		}


	$hover_effects = array( array( 'value' => 'none', 'label' => esc_html__( 'None', 'shopkit' ), 'src' => '' ), array( 'value' => 'grow', 'label' => esc_html__( 'Grow', 'shopkit' ), 'src' => '' ), array( 'value' => 'shrink', 'label' => esc_html__( 'Shrink', 'shopkit' ), 'src' => '' ), array( 'value' => 'pulse', 'label' => esc_html__( 'Pulse', 'shopkit' ), 'src' => '' ), array( 'value' => 'push', 'label' => esc_html__( 'Push', 'shopkit' ), 'src' => '' ), array( 'value' => 'pop', 'label' => esc_html__( 'Pop', 'shopkit' ), 'src' => '' ), array( 'value' => 'rotate', 'label' => esc_html__( 'Rotate', 'shopkit' ), 'src' => '' ), array( 'value' => 'grow-rotate', 'label' => esc_html__( 'Grow Rotate', 'shopkit' ), 'src' => '' ), array( 'value' => 'float', 'label' => esc_html__( 'Float', 'shopkit' ), 'src' => '' ), array( 'value' => 'sink', 'label' => esc_html__( 'Sink', 'shopkit' ), 'src' => '' ), array( 'value' => 'bob', 'label' => esc_html__( 'Bob', 'shopkit' ), 'src' => '' ), array( 'value' => 'hang', 'label' => esc_html__( 'Hang', 'shopkit' ), 'src' => '' ), array( 'value' => 'skew', 'label' => esc_html__( 'Skew', 'shopkit' ), 'src' => '' ), array( 'value' => 'skew-forward', 'label' => esc_html__( 'Skew Forward', 'shopkit' ), 'src' => '' ), array( 'value' => 'skew-backward', 'label' => esc_html__( 'Skew Backward', 'shopkit' ), 'src' => '' ), array( 'value' => 'wobble-horizontal', 'label' => esc_html__( 'Wobble Horizontal', 'shopkit' ), 'src' => '' ), array( 'value' => 'wobble-vertical', 'label' => esc_html__( 'Wobble Vertical', 'shopkit' ), 'src' => '' ), array( 'value' => 'wobble-to-bottom-right', 'label' => esc_html__( 'Wobble To Bottom Right', 'shopkit' ), 'src' => '' ), array( 'value' => 'wobble-to-top-right', 'label' => esc_html__( 'Wobble To Top Right', 'shopkit' ), 'src' => '' ), array( 'value' => 'wobble-top', 'label' => esc_html__( 'Wobble Top', 'shopkit' ), 'src' => '' ), array( 'value' => 'wobble-bottom', 'label' => esc_html__( 'Wobble Bottom', 'shopkit' ), 'src' => '' ), array( 'value' => 'wobble-skew', 'label' => esc_html__( 'Wobble Skew', 'shopkit' ), 'src' => '' ), array( 'value' => 'buzz', 'label' => esc_html__( 'Buzz', 'shopkit' ), 'src' => '' ), array( 'value' => 'buzz-out', 'label' => esc_html__( 'Buzz Out', 'shopkit' ), 'src' => '' ), array( 'value' => 'fade', 'label' => esc_html__( 'Fade', 'shopkit' ), 'src' => '' ), array( 'value' => 'sweep-to-right', 'label' => esc_html__( 'Sweep To Right', 'shopkit' ), 'src' => '' ), array( 'value' => 'sweep-to-left', 'label' => esc_html__( 'Sweep To Left', 'shopkit' ), 'src' => '' ), array( 'value' => 'sweep-to-bottom', 'label' => esc_html__( 'Sweep To Bottom', 'shopkit' ), 'src' => '' ), array( 'value' => 'sweep-to-top', 'label' => esc_html__( 'Sweep To Top', 'shopkit' ), 'src' => '' ), array( 'value' => 'bounce-to-right', 'label' => esc_html__( 'Bounce To Right', 'shopkit' ), 'src' => '' ), array( 'value' => 'bounce-to-left', 'label' => esc_html__( 'Bounce To Left', 'shopkit' ), 'src' => '' ), array( 'value' => 'bounce-to-bottom', 'label' => esc_html__( 'Bounce To Bottom', 'shopkit' ), 'src' => '' ), array( 'value' => 'bounce-to-top', 'label' => esc_html__( 'Bounce To Top', 'shopkit' ), 'src' => '' ), array( 'value' => 'radial-out', 'label' => esc_html__( 'Radial Out', 'shopkit' ), 'src' => '' ), array( 'value' => 'rectangle-out', 'label' => esc_html__( 'Rectangle Out', 'shopkit' ), 'src' => '' ), array( 'value' => 'shutter-out-horizontal', 'label' => esc_html__( 'Shutter Out Horizontal', 'shopkit' ), 'src' => '' ), array( 'value' => 'shutter-out-vertical', 'label' => esc_html__( 'Shutter Out Vertical', 'shopkit' ), 'src' => '' ), array( 'value' => 'ripple-out', 'label' => esc_html__( 'Ripple Out', 'shopkit' ), 'src' => '' ), array( 'value' => 'ripple-in', 'label' => esc_html__( 'Ripple In', 'shopkit' ), 'src' => '' ), array( 'value' => 'underline-from-left', 'label' => esc_html__( 'Underline From Left', 'shopkit' ), 'src' => '' ), array( 'value' => 'underline-from-center', 'label' => esc_html__( 'Underline From Center', 'shopkit' ), 'src' => '' ), array( 'value' => 'underline-from-right', 'label' => esc_html__( 'Underline From Right', 'shopkit' ), 'src' => '' ), array( 'value' => 'underline-reveal', 'label' => esc_html__( 'Underline Reveal', 'shopkit' ), 'src' => '' ), array( 'value' => 'overline-reveal', 'label' => esc_html__( 'Overline Reveal', 'shopkit' ), 'src' => '' ), array( 'value' => 'overline-from-left', 'label' => esc_html__( 'Overline From Left', 'shopkit' ), 'src' => '' ), array( 'value' => 'overline-from-center', 'label' => esc_html__( 'Overline From Center', 'shopkit' ), 'src' => '' ), array( 'value' => 'overline-from-right', 'label' => esc_html__( 'Overline From Right', 'shopkit' ), 'src' => '' ), array( 'value' => 'shadow', 'label' => esc_html__( 'Shadow', 'shopkit' ), 'src' => '' ), array( 'value' => 'grow-shadow', 'label' => esc_html__( 'Grow Shadow', 'shopkit' ), 'src' => '' ), array( 'value' => 'float-shadow', 'label' => esc_html__( 'Float Shadow', 'shopkit' ), 'src' => '' ), array( 'value' => 'glow', 'label' => esc_html__( 'Glow', 'shopkit' ), 'src' => '' ), array( 'value' => 'shadow-radial', 'label' => esc_html__( 'Shadow Radial', 'shopkit' ), 'src' => '' ), array( 'value' => 'box-shadow-outset', 'label' => esc_html__( 'Box Shadow Outset', 'shopkit' ), 'src' => '' ), array( 'value' => 'box-shadow-inset', 'label' => esc_html__( 'Box Shadow Inset', 'shopkit' ), 'src' => '' ), array( 'value' => 'bubble-top', 'label' => esc_html__( 'Bubble Top', 'shopkit' ), 'src' => '' ), array( 'value' => 'bubble-right', 'label' => esc_html__( 'Bubble Right', 'shopkit' ), 'src' => '' ), array( 'value' => 'bubble-bottom', 'label' => esc_html__( 'Bubble Bottom', 'shopkit' ), 'src' => '' ), array( 'value' => 'bubble-left', 'label' => esc_html__( 'Bubble Left', 'shopkit' ), 'src' => '' ), array( 'value' => 'bubble-float-top', 'label' => esc_html__( 'Bubble Float Top', 'shopkit' ), 'src' => '' ), array( 'value' => 'bubble-float-right', 'label' => esc_html__( 'Bubble Float Right', 'shopkit' ), 'src' => '' ), array( 'value' => 'bubble-float-bottom', 'label' => esc_html__( 'Bubble Float Bottom', 'shopkit' ), 'src' => '' ), array( 'value' => 'bubble-float-left', 'label' => esc_html__( 'Bubble Float Left', 'shopkit' ), 'src' => '' ) );

	$wp_menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	$wp_ready_menus = array(
		array(
			'value' => 'none',
			'label' => esc_html__( 'None', 'shopkit' ),
			'src' => ''
		)
	);

	if ( !empty( $wp_menus ) ) {
		foreach ( $wp_menus as $wp_menu ) {
			$wp_ready_menus[] = array(
				'value' => $wp_menu->slug,
				'label' => $wp_menu->name,
				'src' => ''
			);
		}
	}

	for ( $i = 3; $i <= 25; $i++ ) {

		$n = $i*6;

		$element_heights[] = array(
			'value' => 'shopkit-height-' . $n,
			'label' => $n . esc_html__( 'px', 'shopkit'),
			'src' => ''
		);
	}

	$footer_elements_array = array( 
		'select_element' => array(
			'id'          => 'select_element',
			'label'       => esc_html__( 'Select Type', 'shopkit' ),
			'desc'        => esc_html__( 'Select row type.', 'shopkit' ),
			'std'         => 'widget-1-columns-1',
			'type'        => 'radio-image',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-select-element',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'widget-1-columns-1',
				'label'       => esc_html__( 'Layout #1', 'shopkit' ),
				'src'         => WcSk()->template_url() . '/library/images/admin/footer-1.png'
			),
			array(
				'value'       => 'widget-2-columns-2',
				'label'       => esc_html__( 'Layout #2', 'shopkit' ),
				'src'         => WcSk()->template_url() . '/library/images/admin/footer-2.png'
			),
			array(
				'value'       => 'widget-3-columns-3',
				'label'       => esc_html__( 'Layout #3', 'shopkit' ),
				'src'         => WcSk()->template_url() . '/library/images/admin/footer-3.png'
			),
			array(
				'value'       => 'widget-4-columns-4',
				'label'       => esc_html__( 'Layout #4', 'shopkit' ),
				'src'         => WcSk()->template_url() . '/library/images/admin/footer-4.png'
			),
			array(
				'value'       => 'widget-5-columns-4',
				'label'       => esc_html__( 'Layout #5', 'shopkit' ),
				'src'         => WcSk()->template_url() . '/library/images/admin/footer-5.png'
			),
			array(
				'value'       => 'widget-6-columns-4',
				'label'       => esc_html__( 'Layout #6', 'shopkit' ),
				'src'         => WcSk()->template_url() . '/library/images/admin/footer-6.png'
			),
			array(
				'value'       => 'widget-7-columns-3',
				'label'       => esc_html__( 'Layout #7', 'shopkit' ),
				'src'         => WcSk()->template_url() . '/library/images/admin/footer-7.png'
			),
			array(
				'value'       => 'widget-8-columns-3',
				'label'       => esc_html__( 'Layout #8', 'shopkit' ),
				'src'         => WcSk()->template_url() . '/library/images/admin/footer-8.png'
			)
		    )
		),
		'element_visibility' => array(
			'id'          => 'element_visibility',
			'label'       => esc_html__( 'Element Visibility', 'shopkit' ),
			'desc'        => esc_html__( 'Check responsive modes to hide the element.', 'shopkit' ),
			'std'         => '',
			'type'        => 'checkbox',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-element-visibility',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'shopkit-responsive-low',
				'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-medium',
				'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-high',
				'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
				'src'         => ''
			)
			)
		)
		);

	$elements_array = array( 
		'select_element' => array(
			'id'          => 'select_element',
			'label'       => esc_html__( 'Select Element', 'shopkit' ),
			'desc'        => esc_html__( 'Select element type.', 'shopkit' ),
			'std'         => 'none',
			'type'        => 'select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-select-element',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'none',
				'label'       => esc_html__( 'None', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'text',
				'label'       => esc_html__( 'Text/HTML', 'shopkit' ),
				'src'         => ''
			),
			  array(
				'value'       => 'login-registration',
				'label'       => esc_html__( 'User Login/Registration', 'shopkit' ),
				'src'         => ''
			),
			  array(
				'value'       => 'login',
				'label'       => esc_html__( 'User Login', 'shopkit' ),
				'src'         => ''
			),
			  array(
				'value'       => 'registration',
				'label'       => esc_html__( 'User Registration', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'image-link',
				'label'       => esc_html__( 'Image Link', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'break',
				'label'       => esc_html__( 'Line Break', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'menu',
				'label'       => esc_html__( 'Menu', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'logo',
				'label'       => esc_html__( 'Site Logo', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'site-title',
				'label'       => esc_html__( 'Site Title and Description', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'site-name',
				'label'       => esc_html__( 'Site Title', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'site-desc',
				'label'       => esc_html__( 'Site Desctiption', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'social-network',
				'label'       => esc_html__( 'Social Network', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'separator',
				'label'       => esc_html__( 'Separator', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'search',
				'label'       => esc_html__( 'Search', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'breadcrumbs',
				'label'       => esc_html__( 'Breadcrumbs', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'trigger',
				'label'       => esc_html__( 'Trigger', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'woo-cart',
				'label'       => esc_html__( 'WooCommerce Cart', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'woo-search',
				'label'       => esc_html__( 'WooCommerce Search', 'shopkit' ),
				'src'         => ''
			),
			)
		),

		'text' => array(
			'id'          => 'text',
			'label'       => esc_html__( 'Text', 'shopkit' ),
			'desc'        => esc_html__( 'Enter text.', 'shopkit' ),
			'std'         => '',
			'type'        => 'textarea-simple',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-text',
			'condition'   => '',
			'operator'    => 'and'
		),

		'social_network' => array(
			'id'          => 'social_network',
			'label'       => esc_html__( 'Social Network', 'shopkit' ),
			'desc'        => esc_html__( 'Select social network icon.', 'shopkit' ),
			'std'         => '',
			'type'        => 'select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-social-network',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array(
				array(
					'value'       => 'facebook',
					'label'       => 'Facebook',
					'src'         => ''
				),
				array(
					'value'       => 'twitter',
					'label'       => 'Twitter',
					'src'         => ''
				),
				array(
					'value'       => 'google',
					'label'       => 'Google +',
					'src'         => ''
				),
				array(
					'value'       => 'linked',
					'label'       => 'LinkedIn',
					'src'         => ''
				),
				array(
					'value'       => 'delicious',
					'label'       => 'Delicious',
					'src'         => ''
				),
				array(
					'value'       => 'pin',
					'label'       => 'Pinterest',
					'src'         => ''
				),
				array(
					'value'       => 'instagram',
					'label'       => 'Instagram',
					'src'         => ''
				),
				array(
					'value'       => 'youtube',
					'label'       => 'YouTube',
					'src'         => ''
				),
				array(
					'value'       => 'vimeo',
					'label'       => 'Vimeo',
					'src'         => ''
				),
				array(
					'value'       => 'dribbble',
					'label'       => 'Dribbble',
					'src'         => ''
				),
				array(
					'value'       => 'behance',
					'label'       => 'Behance',
					'src'         => ''
				),
				array(
					'value'       => 'skype',
					'label'       => 'Skype',
					'src'         => ''
				)
			)
		),

		'icon' => array(
			'id'          => 'icon',
			'label'       => esc_html__( 'Element Icon', 'shopkit' ),
			'desc'        => esc_html__( 'Select element icon type.', 'shopkit' ),
			'std'         => 'line-icon',
			'type'        => 'select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-menu shopkit-ot-login shopkit-ot-login-registration shopkit-ot-registration shopkit-ot-search shopkit-ot-woo-search',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
				array(
					'value'       => 'text',
					'label'       => esc_html__( 'Text', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'button',
					'label'       => esc_html__( 'Button', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'line-icon',
					'label'       => esc_html__( 'Line Icon', 'shopkit' ),
					'src'         => ''
				)
			)
		),

		'trigger' => array(
			'id'          => 'trigger',
			'label'       => esc_html__( 'Section Trigger', 'shopkit' ),
			'desc'        => esc_html__( 'Select section to show hide (works with Collapsible section options).', 'shopkit' ),
			'std'         => '',
			'type'        => 'select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-trigger',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => $sections,
		),

		'woo_cart_icon' => array(
			'id'          => 'woo_cart_icon',
			'label'       => esc_html__( 'Cart Icon', 'shopkit' ),
			'desc'        => esc_html__( 'Select cart icon type.', 'shopkit' ),
			'std'         => 'line-icon',
			'type'        => 'select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-woo-cart',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'text',
				'label'       => esc_html__( 'Text', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'button',
				'label'       => esc_html__( 'Button', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'line-icon',
				'label'       => esc_html__( 'Line Icon', 'shopkit' ),
				'src'         => ''
			)
			)
		),

		'image' => array(
			'id'          => 'image',
			'label'       => esc_html__( 'Image', 'shopkit' ),
			'desc'        => esc_html__( 'Select image.', 'shopkit' ),
			'std'         => '',
			'type'        => 'upload',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-image-link',
			'condition'   => '',
			'operator'    => 'and'
		),

		'image_hover' => array(
			'id'          => 'image_hover',
			'label'       => esc_html__( 'Image Hover', 'shopkit' ),
			'desc'        => esc_html__( 'Select image on hover.', 'shopkit' ),
			'std'         => '',
			'type'        => 'upload',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-image-link',
			'condition'   => '',
			'operator'    => 'and'
		),

		'url' => array(
			'id'          => 'url',
			'label'       => esc_html__( 'URL', 'shopkit' ),
			'desc'        => esc_html__( 'Enter link URL.', 'shopkit' ),
			'std'         => '',
			'type'        => 'text',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-image-link shopkit-ot-social-network',
			'condition'   => '',
			'operator'    => 'and'
		),

		'menu' => array(
			'id'          => 'menu',
			'label'       => esc_html__( 'Menu', 'shopkit' ),
			'desc'        => esc_html__( 'Select menu.', 'shopkit' ),
			'std'         => 'none',
			'type'        => 'select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-menu',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => $wp_ready_menus
		),

		'menu_style' => array(
			'id'          => 'menu_style',
			'label'       => esc_html__( 'Menu Style', 'shopkit' ),
			'desc'        => esc_html__( 'Select menu style.', 'shopkit' ),
			'std'         => 'shopkit-menu-nomargin',
			'type'        => 'select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-menu',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'shopkit-menu-nomargin',
				'label'       => esc_html__( 'Without Margin', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-menu-margin',
				'label'       => esc_html__( 'With Margin', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-menu-separator',
				'label'       => esc_html__( 'With Separator', 'shopkit' ),
				'src'         => ''
			)
			)
		),

		'menu_effect' => array(
			'id'          => 'menu_effect',
			'label'       => esc_html__( 'Menu Effect', 'shopkit' ),
			'desc'        => esc_html__( 'Select menu effect.', 'shopkit' ),
			'std'         => 'none',
			'type'        => 'select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-menu',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => $hover_effects
		),

		'menu_font' => array(
			'id'          => 'menu_font',
			'label'       => esc_html__( 'Menu Font', 'shopkit' ),
			'desc'        => esc_html__( 'Select menu font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-menu',
			'condition'   => '',
			'operator'    => 'and'
		),

			'menu_font_hover' => array(
				'id'          => 'menu_font_hover',
				'label'       => esc_html__( 'Menu Font Hover Color', 'shopkit' ),
				'desc'        => esc_html__( 'Select the menu font hover color. Color opacity is supported.', 'shopkit' ),
				'std'         => '',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => 'shopkit-ot-hide shopkit-ot-menu',
				'condition'   => '',
				'operator'    => 'and'
			),

			'menu_background_active' => array(
				'id'          => 'menu_background_active',
				'label'       => esc_html__( 'Menu Active Color', 'shopkit' ),
				'desc'        => esc_html__( 'Select the menu active color. Color opacity is supported.', 'shopkit' ),
				'std'         => '',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => 'shopkit-ot-hide shopkit-ot-menu',
				'condition'   => '',
				'operator'    => 'and'
			),

		'menu_submenu_font' => array(
			'id'          => 'menu_submenu_font',
			'label'       => esc_html__( ' Sub-Menu Font', 'shopkit' ),
			'desc'        => esc_html__( 'Select sub-menu font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
			'std'         => '',
			'type'        => 'typography',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-menu',
			'condition'   => '',
			'operator'    => 'and'
		),

			'menu_submenu_font_hover' => array(
				'id'          => 'menu_submenu_font_hover',
				'label'       => esc_html__( 'Sub-Menu Font Hover Color', 'shopkit' ),
				'desc'        => esc_html__( 'Select the sub-menu font hover color. Color opacity is supported.', 'shopkit' ),
				'std'         => '',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => 'shopkit-ot-hide shopkit-ot-menu',
				'condition'   => '',
				'operator'    => 'and'
			),

			'menu_submenu_background' => array(
				'id'          => 'menu_submenu_background',
				'label'       => esc_html__( 'Sub-Menu Background Color', 'shopkit' ),
				'desc'        => esc_html__( 'Select the sub-menu background color. Color opacity is supported.', 'shopkit' ),
				'std'         => '',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => 'shopkit-ot-hide shopkit-ot-menu',
				'condition'   => '',
				'operator'    => 'and'
			),

			'menu_submenu_background_active' => array(
				'id'          => 'menu_submenu_background_active',
				'label'       => esc_html__( 'Sub-Menu Hover Background Color', 'shopkit' ),
				'desc'        => esc_html__( 'Select the sub-menu hover background color. Color opacity is supported.', 'shopkit' ),
				'std'         => '',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => 'shopkit-ot-hide shopkit-ot-menu',
				'condition'   => '',
				'operator'    => 'and'
			),

		'height' => array(
			'id'          => 'height',
			'label'       => esc_html__( 'Element Height', 'shopkit' ),
			'desc'        => esc_html__( 'Set element height.', 'shopkit' ),
			'std'         => 'shopkit-height-30',
			'type'        => 'select',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-ot-hide shopkit-ot-menu shopkit-ot-woo-cart shopkit-ot-woo-search shopkit-ot-search shopkit-ot-social-network shopkit-ot-separator shopkit-ot-image-link shopkit-ot-logo shopkit-ot-login shopkit-ot-login-registration shopkit-ot-registration',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => $element_heights
		),

		'class' => array(
			'id'          => 'class',
			'label'       => esc_html__( 'Extra Class', 'shopkit' ),
			'desc'        => esc_html__( 'Enter CSS class to add to element.', 'shopkit' ),
			'std'         => '',
			'type'        => 'text',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-element-visibility',
			'condition'   => '',
			'operator'    => 'and'
		),

		'element_visibility' => array(
			'id'          => 'element_visibility',
			'label'       => esc_html__( 'Element Visibility', 'shopkit' ),
			'desc'        => esc_html__( 'Check responsive modes to hide the element.', 'shopkit' ),
			'std'         => '',
			'type'        => 'checkbox',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => 'shopkit-element-visibility',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'shopkit-responsive-low',
				'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-medium',
				'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-responsive-high',
				'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
				'src'         => ''
			)
			)
		)
	);

	foreach( $layout_sections as $section ) {

		$el = $section['id'];
		$string = $section['title'];
		$type = $section['type'];
		$curr = str_replace( '_', ' ', $el );
		$curr_section = array();
		$curr_slug = sanitize_title( $section['title'] );

		$saved_settings = get_option( self::$mode . '_section_' . $el, array() );

		switch( $type ) :

		case 'elements-bar' :

		$curr_section = array(
			$el . '_elements_align' => array(
				'id'          => $el . '_elements_align',
				'label'       => $string . ' ' . esc_html__( 'Mode', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' inner elements vertical align.', 'shopkit' ),
				'std'         => 'shopkit-sections-leftright',
				'type'        => 'select',
				'section'     => 'content',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array( 
				  array(
					'value'       => 'shopkit-sections-leftright',
					'label'       => esc_html__( 'Elements on Left and Right', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'shopkit-sections-central',
					'label'       => esc_html__( 'Elements in Center', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'shopkit-sections-left',
					'label'       => esc_html__( 'Elements on Left', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'shopkit-sections-right',
					'label'       => esc_html__( 'Elements on Right', 'shopkit' ),
					'src'         => ''
				  )
				)
			),
			$el . '_elements_on_left' => array(
				'id'          => $el . '_elements_on_left',
				'label'       => $string . ' ' . esc_html__( 'Elements on Left', 'shopkit' ),
				'desc'        => esc_html__( 'Use the manager to add elements to the ', 'shopkit' ) . $curr . esc_html__( ' area.', 'shopkit' ),
				'std'         => array(),
				'type'        => 'list-item',
				'section'     => 'content',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'settings'    => $elements_array
			),
			$el . '_elements_on_right' => array(
				'id'          => $el . '_elements_on_right',
				'label'       => $string . ' ' . esc_html__( 'Elements on Right', 'shopkit' ),
				'desc'        => esc_html__( 'Use the manager to add elements to the ', 'shopkit' ) . $curr . esc_html__( ' area.', 'shopkit' ),
				'std'         => array(),
				'type'        => 'list-item',
				'section'     => 'content',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'settings'    => $elements_array
			),
			$el . '_outer_elements_align' =>array(
				'id'          => $el . '_outer_elements_align',
				'label'       => $string . ' ' . esc_html__( 'Outer Elements Align', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' outer elements vertical align.', 'shopkit' ),
				'std'         => 'middle',
				'type'        => 'select',
				'section'     => 'content',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array( 
				  array(
					'value'       => 'top',
					'label'       => esc_html__( 'Top', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'middle',
					'label'       => esc_html__( 'Middle', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'bottom',
					'label'       => esc_html__( 'Bottom', 'shopkit' ),
					'src'         => ''
				  )
				)
			),
			$el . '_inner_elements_align' => array(
				'id'          => $el . '_inner_elements_align',
				'label'       => $string . ' ' . esc_html__( 'Inner Elements Align', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' inner elements vertical align.', 'shopkit' ),
				'std'         => 'middle',
				'type'        => 'select',
				'section'     => 'content',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array( 
				  array(
					'value'       => 'top',
					'label'       => esc_html__( 'Top', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'middle',
					'label'       => esc_html__( 'Middle', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'bottom',
					'label'       => esc_html__( 'Bottom', 'shopkit' ),
					'src'         => ''
				  )
				)
			),
			$el . '_condition' => array(
				'id'          => $el . '_condition',
				'label'       => $string . ' ' . esc_html__( 'Display Condition', 'shopkit' ),
				'desc'        => esc_html__( 'Enter condition when to show the ', 'shopkit' ) . $curr . esc_html__( '. e.g. is_woocommerce', 'shopkit' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'responsive',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_visibility' => array(
				'id'          => $el . '_visibility',
				'label'       => $string . ' ' . esc_html__( 'Responsive Visibility', 'shopkit' ),
				'desc'        => esc_html__( 'Check responsive modes to hide the ', 'shopkit' ) . $curr . esc_html__( '.', 'shopkit' ),
				'std'         => '',
				'type'        => 'checkbox',
				'section'     => 'responsive',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array( 
				  array(
					'value'       => 'shopkit-responsive-low',
					'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'shopkit-responsive-medium',
					'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'shopkit-responsive-high',
					'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
					'src'         => ''
				  )
				)
			),
			$el . '_type' => array(
				'id'          => $el . '_type',
				'label'       => $string . ' ' . esc_html__( 'Type', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' section type.', 'shopkit' ),
				'std'         => 'normal',
				'type'        => 'select',
				'section'     => 'collapsible',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array( 
				  array(
					'value'       => 'normal',
					'label'       => esc_html__( 'Normal', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsible-with-icon',
					'label'       => esc_html__( 'Collapsible with close icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsible-with-dismiss',
					'label'       => esc_html__( 'Collapsible with dismiss icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsed-with-icon',
					'label'       => esc_html__( 'Collapsed with open icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'always-collapsed-with-icon',
					'label'       => esc_html__( 'Always collapsed with open icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsible-with-trigger',
					'label'       => esc_html__( 'Collapsible with custom trigger', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsed-with-trigger',
					'label'       => esc_html__( 'Collapsed with custom trigger', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'always-collapsed-with-trigger',
					'label'       => esc_html__( 'Always collapsed with custom trigger', 'shopkit' ),
					'src'         => ''
				  )
				)
			),
			$el . '_type_height' => array(
				'id'          => $el . '_type_height',
				'label'       => $string . ' ' . esc_html__( 'Icons Size', 'shopkit' ),
				'desc'        => esc_html__( 'Set collapse type icons height.', 'shopkit' ),
				'std'         => 'shopkit-height-30',
				'type'        => 'select',
				'section'     => 'collapsible',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => $element_heights
			  ),
			$el . '_padding' => array(
				'id'          => $el . '_padding',
				'label'       => $string . ' ' . esc_html__( 'Padding', 'shopkit' ),
				'desc'        => esc_html__( 'Enter padding for the ', 'shopkit' ) . $curr . esc_html__( '. e.g. 10px 0px 10px 0px', 'shopkit' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_font' => array(
				'id'          => $el . '_font',
				'label'       => $string . ' ' . esc_html__( 'Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#888888',
					'font-family' => '',
					'font-size' => '',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '',
					'letter-spacing' => '',
					'line-height' => '',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
				),
			$el . '_link' => array(
				'id'          => $el . '_link',
				'label'       => $string . ' ' . esc_html__( 'Link', 'shopkit' ),
				'desc'        => esc_html__( 'Select the link color in the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '#ff3d00',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_link_hover' => array(
				'id'          => $el . '_link_hover',
				'label'       => $string . ' ' . esc_html__( 'Link Hover', 'shopkit' ),
				'desc'        => esc_html__( 'Select the link hover color in the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '#222222',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_separator' => array(
				'id'          => $el . '_separator',
				'label'       => $string . ' ' . esc_html__( 'Separator', 'shopkit' ),
				'desc'        => esc_html__( 'Select the separator color in the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '#dddddd',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_button_font' => array(
				'id'          => $el . '_button_font',
				'label'       => $string . ' ' . esc_html__( 'Button', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' button settings. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#ff3d00',
					'font-family' => '',
					'font-size' => '18px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '',
					'letter-spacing' => '',
					'line-height' => '48px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_button_hover_font' => array(
				'id'          => $el . '_button_hover_font',
				'label'       => $string . ' ' . esc_html__( 'Button Hover', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' button hover settings. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '18px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '',
					'letter-spacing' => '',
					'line-height' => '48px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_button_style' => array(
				'id'          => $el . '_button_style',
				'label'       => $string . ' ' . esc_html__( 'Button Style', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' button style.', 'shopkit' ),
				'std'         => 'bordered',
				'type'        => 'select',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => $button_styles
			  ),
			$el . '_background' => array(
				'id'          => $el . '_background',
				'label'       => $string . ' ' . esc_html__( 'Background', 'shopkit' ),
				'desc'        => esc_html__( 'Select the background color for the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '',
				'type'        => 'background',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => 'ot-colorpicker-opacity',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_boxshadow' => array(
				'id'          => $el . '_boxshadow',
				'label'       => $string . ' ' . esc_html__( 'Shadow', 'shopkit' ),
				'desc'        => esc_html__( 'Create a shadow for the ', 'shopkit' ) . $curr . esc_html__( ' area.', 'shopkit' ),
				'std'         => '',
				'type'        => 'box-shadow',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h1_font' => array(
				'id'          => $el . '_h1_font',
				'label'       => $string . ' ' . esc_html__( 'H1 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h1 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '36px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '42px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h2_font' => array(
				'id'          => $el . '_h2_font',
				'label'       => $string . ' ' . esc_html__( 'H2 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h2 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '30px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '36px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h3_font' => array(
				'id'          => $el . '_h3_font',
				'label'       => $string . ' ' . esc_html__( 'H3 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h3 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '24px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '30px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h4_font' => array(
				'id'          => $el . '_h4_font',
				'label'       => $string . ' ' . esc_html__( 'H4 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h4 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '18px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '28px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h5_font' => array(
				'id'          => $el . '_h5_font',
				'label'       => $string . ' ' . esc_html__( 'H5 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h5 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '16px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '28px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h6_font' => array(
				'id'          => $el . '_h6_font',
				'label'       => $string . ' ' . esc_html__( 'H6 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h6 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '14px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '28px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			)
			);

		break;

		case 'widget-section' :

			$curr_section = array(
			$el . '_sidebar_heading' => array(
				'id'          => $el . '_sidebar_heading',
				'label'       => esc_html__( 'Widget Title', 'shopkit' ),
				'desc'        => esc_html__( 'Select widget title size.', 'shopkit' ),
				'std'         => 'h3',
				'type'        => 'select',
				'section'     => 'content',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array(
					array(
						'value'       => 'h2',
						'label'       => 'H2',
						'src'         => ''
					),
					array(
						'value'       => 'h3',
						'label'       => 'H3',
						'src'         => ''
					),
					array(
						'value'       => 'h4',
						'label'       => 'H4',
						'src'         => ''
					),
					array(
						'value'       => 'h5',
						'label'       => 'H5',
						'src'         => ''
					),
					array(
						'value'       => 'h6',
						'label'       => 'H6',
						'src'         => ''
					)
				)
			),
			$el . '_rows' => array(
				'id'          => $el . '_rows',
				'label'       => $string . ' ' . esc_html__( 'Rows', 'shopkit' ),
				'desc'        => esc_html__( 'Use the manager to add rows to the ', 'shopkit' ) . $curr . esc_html__( ' area.', 'shopkit' ),
				'std'         => array(),
				'type'        => 'list-item',
				'section'     => 'content',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'settings'    => $footer_elements_array
			),
			$el . '_type' => array(
				'id'          => $el . '_type',
				'label'       => $string . ' ' . esc_html__( 'Type', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' section type.', 'shopkit' ),
				'std'         => 'normal',
				'type'        => 'select',
				'section'     => 'collapsible',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array( 
				  array(
					'value'       => 'normal',
					'label'       => esc_html__( 'Normal', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsible-with-icon',
					'label'       => esc_html__( 'Collapsible with close icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsible-with-dismiss',
					'label'       => esc_html__( 'Collapsible with dismiss icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsed-with-icon',
					'label'       => esc_html__( 'Collapsed with open icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'always-collapsed-with-icon',
					'label'       => esc_html__( 'Always collapsed with open icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsible-with-trigger',
					'label'       => esc_html__( 'Collapsible with custom trigger', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsed-with-trigger',
					'label'       => esc_html__( 'Collapsed with custom trigger', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'always-collapsed-with-trigger',
					'label'       => esc_html__( 'Always collapsed with custom trigger', 'shopkit' ),
					'src'         => ''
				  )
				)
			),
			$el . '_type_height' => array(
				'id'          => $el . '_type_height',
				'label'       => $string . ' ' . esc_html__( 'Icons Size', 'shopkit' ),
				'desc'        => esc_html__( 'Set collapse type icons height.', 'shopkit' ),
				'std'         => 'shopkit-height-30',
				'type'        => 'select',
				'section'     => 'collapsible',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => $element_heights
			  ),
			$el . '_condition' => array(
				'id'          => $el . '_condition',
				'label'       => $string . ' ' . esc_html__( 'Display Condition', 'shopkit' ),
				'desc'        => esc_html__( 'Enter condition when to show the ', 'shopkit' ) . $curr . esc_html__( '. e.g. is_woocommerce', 'shopkit' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'responsive',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_visibility' => array(
				'id'          => $el . '_visibility',
				'label'       => $string . ' ' . esc_html__( 'Responsive Visibility', 'shopkit' ),
				'desc'        => esc_html__( 'Check responsive modes to hide the ', 'shopkit' ) . $curr . esc_html__( '.', 'shopkit' ),
				'std'         => '',
				'type'        => 'checkbox',
				'section'     => 'responsive',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array( 
				  array(
					'value'       => 'shopkit-responsive-low',
					'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'shopkit-responsive-medium',
					'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'shopkit-responsive-high',
					'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
					'src'         => ''
				  )
				)
			),
			$el . '_padding' => array(
				'id'          => $el . '_padding',
				'label'       => $string . ' ' . esc_html__( 'Padding', 'shopkit' ),
				'desc'        => esc_html__( 'Enter padding for the ', 'shopkit' ) . $curr . esc_html__( '. e.g. 10px 0px 10px 0px', 'shopkit' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_font' => array(
				'id'          => $el . '_font',
				'label'       => $string . ' ' . esc_html__( 'Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#888888',
					'font-family' => '',
					'font-size' => '',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '',
					'letter-spacing' => '',
					'line-height' => '',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_link' => array(
				'id'          => $el . '_link',
				'label'       => $string . ' ' . esc_html__( 'Link', 'shopkit' ),
				'desc'        => esc_html__( 'Select the link color in the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '#ff3d00',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_link_hover' => array(
				'id'          => $el . '_link_hover',
				'label'       => $string . ' ' . esc_html__( 'Link Hover', 'shopkit' ),
				'desc'        => esc_html__( 'Select the link hover color in the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '#222222',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_separator' => array(
				'id'          => $el . '_separator',
				'label'       => $string . ' ' . esc_html__( 'Separator', 'shopkit' ),
				'desc'        => esc_html__( 'Select the separator color in the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '#dddddd',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_button_font' => array(
				'id'          => $el . '_button_font',
				'label'       => $string . ' ' . esc_html__( 'Button', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' button settings. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#ff3d00',
					'font-family' => '',
					'font-size' => '18px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '',
					'letter-spacing' => '',
					'line-height' => '48px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_button_hover_font' => array(
				'id'          => $el . '_button_hover_font',
				'label'       => $string . ' ' . esc_html__( 'Button Hover', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' button hover settings. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '18px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '',
					'letter-spacing' => '',
					'line-height' => '48px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_button_style' => array(
				'id'          => $el . '_button_style',
				'label'       => $string . ' ' . esc_html__( 'Button Style', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' button style.', 'shopkit' ),
				'std'         => 'bordered',
				'type'        => 'select',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => $button_styles
			 ),
			 $el . '_background' => array(
				'id'          => $el . '_background',
				'label'       => $string . ' ' . esc_html__( ' Background', 'shopkit' ),
				'desc'        => esc_html__( 'Select the background color for the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '',
				'type'        => 'background',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_boxshadow' => array(
				'id'          => $el . '_boxshadow',
				'label'       => $string . ' ' . esc_html__( 'Shadow', 'shopkit' ),
				'desc'        => esc_html__( 'Create a shadow for the ', 'shopkit' ) . $curr . esc_html__( ' area.', 'shopkit' ),
				'std'         => '',
				'type'        => 'box-shadow',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h1_font' => array(
				'id'          => $el . '_h1_font',
				'label'       => $string . ' ' . esc_html__( 'H1 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h1 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '36px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '42px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h2_font' => array(
				'id'          => $el . '_h2_font',
				'label'       => $string . ' ' . esc_html__( 'H2 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h2 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '30px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '36px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h3_font' => array(
				'id'          => $el . '_h3_font',
				'label'       => $string . ' ' . esc_html__( 'H3 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h3 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '24px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '30px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h4_font' => array(
				'id'          => $el . '_h4_font',
				'label'       => $string . ' ' . esc_html__( 'H4 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h4 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '18px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '28px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h5_font' => array(
				'id'          => $el . '_h5_font',
				'label'       => $string . ' ' . esc_html__( 'H5 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h5 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '16px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '28px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h6_font' => array(
				'id'          => $el . '_h6_font',
				'label'       => $string . ' ' . esc_html__( 'H6 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h6 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '14px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '28px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_margin_override' => array(
				'id'          => $el . '_margin_override',
				'label'       => $string . ' ' . esc_html__( 'Custom Margins', 'shopkit' ),
				'desc'        => esc_html__( 'Enable custom margins for .', 'shopkit' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . 'columns_margin' => array(
				'id'          => $el . '_columns_margin',
				'label'       => $string . ' ' . esc_html__( 'Columns Margin', 'shopkit' ),
				'desc'        => esc_html__( 'Set margin between columns.', 'shopkit' ),
				'std'         => '30',
				'type'        => 'numeric-slider',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '0,60,1',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . 'rows_margin' => array(
				'id'          => $el . '_rows_margin',
				'label'       => $string . ' ' . esc_html__( 'Rows Margin', 'shopkit' ),
				'desc'        => esc_html__( 'Set margin between rows.', 'shopkit' ),
				'std'         => '60',
				'type'        => 'numeric-slider',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '0,60,1',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			)
			);
		break;

		case 'content-text-html' :

			$curr_section = array(
			$el . '_content' => array(
				'id'          => $el . '_content',
				'label'       => $string . ' ' . esc_html__( 'Content', 'shopkit' ),
				'desc'        => esc_html__( 'Enter content for the ', 'shopkit' ) . $curr . esc_html__( ' section.', 'shopkit' ),
				'std'         => '',
				'type'        => 'textarea',
				'section'     => 'content',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_type' => array(
				'id'          => $el . '_type',
				'label'       => $string . ' ' . esc_html__( 'Type', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' section type.', 'shopkit' ),
				'std'         => 'normal',
				'type'        => 'select',
				'section'     => 'collapsible',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array( 
				  array(
					'value'       => 'normal',
					'label'       => esc_html__( 'Normal', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsible-with-icon',
					'label'       => esc_html__( 'Collapsible with close icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsible-with-dismiss',
					'label'       => esc_html__( 'Collapsible with dismiss icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsed-with-icon',
					'label'       => esc_html__( 'Collapsed with open icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'always-collapsed-with-icon',
					'label'       => esc_html__( 'Always collapsed with open icon', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsible-with-trigger',
					'label'       => esc_html__( 'Collapsible with custom trigger', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'collapsed-with-trigger',
					'label'       => esc_html__( 'Collapsed with custom trigger', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'always-collapsed-with-trigger',
					'label'       => esc_html__( 'Always collapsed with custom trigger', 'shopkit' ),
					'src'         => ''
				  )
				)
			),
			$el . '_type_height' => array(
				'id'          => $el . '_type_height',
				'label'       => $string . ' ' . esc_html__( 'Icons Size', 'shopkit' ),
				'desc'        => esc_html__( 'Set collapse type icons height.', 'shopkit' ),
				'std'         => 'shopkit-height-30',
				'type'        => 'select',
				'section'     => 'collapsible',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => $element_heights
			  ),
			$el . '_condition' => array(
				'id'          => $el . '_condition',
				'label'       => $string . ' ' . esc_html__( 'Display Condition', 'shopkit' ),
				'desc'        => esc_html__( 'Enter condition when to show the ', 'shopkit' ) . $curr . esc_html__( '. e.g. is_woocommerce', 'shopkit' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'responsive',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_visibility' => array(
				'id'          => $el . '_visibility',
				'label'       => $string . ' ' . esc_html__( 'Responsive Visibility', 'shopkit' ),
				'desc'        => esc_html__( 'Check responsive modes to hide the ', 'shopkit' ) . $curr . esc_html__( '.', 'shopkit' ),
				'std'         => '',
				'type'        => 'checkbox',
				'section'     => 'responsive',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => array( 
				  array(
					'value'       => 'shopkit-responsive-low',
					'label'       => esc_html__( 'Low Resolution / Mobile', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'shopkit-responsive-medium',
					'label'       => esc_html__( 'Medium Resolution / Tablet', 'shopkit' ),
					'src'         => ''
				  ),
				  array(
					'value'       => 'shopkit-responsive-high',
					'label'       => esc_html__( 'High Resolution / Laptop, Desktop', 'shopkit' ),
					'src'         => ''
				  )
				)
			),
			$el . '_padding' => array(
				'id'          => $el . '_padding',
				'label'       => $string . ' ' . esc_html__( 'Padding', 'shopkit' ),
				'desc'        => esc_html__( 'Enter padding for the ', 'shopkit' ) . $curr . esc_html__( '. e.g. 10px 0px 10px 0px', 'shopkit' ),
				'std'         => '',
				'type'        => 'text',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_font' => array(
				'id'          => $el . '_font',
				'label'       => $string . ' ' . esc_html__( 'Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#888888',
					'font-family' => '',
					'font-size' => '',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '',
					'letter-spacing' => '',
					'line-height' => '',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_link' => array(
				'id'          => $el . '_link',
				'label'       => $string . ' ' . esc_html__( 'Link', 'shopkit' ),
				'desc'        => esc_html__( 'Select the link color in the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '#ff3d00',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_link_hover' => array(
				'id'          => $el . '_link_hover',
				'label'       => $string . ' ' . esc_html__( 'Link Hover', 'shopkit' ),
				'desc'        => esc_html__( 'Select the link hover color in the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '#222222',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_separator' => array(
				'id'          => $el . '_separator',
				'label'       => $string . ' ' . esc_html__( 'Separator', 'shopkit' ),
				'desc'        => esc_html__( 'Select the separator color in the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '#dddddd',
				'type'        => 'colorpicker-opacity',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_button_font' => array(
				'id'          => $el . '_button_font',
				'label'       => $string . ' ' . esc_html__( 'Button', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' button settings. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#ff3d00',
					'font-family' => '',
					'font-size' => '18px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '',
					'letter-spacing' => '',
					'line-height' => '48px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_button_hover_font' => array(
				'id'          => $el . '_button_hover_font',
				'label'       => $string . ' ' . esc_html__( 'Button Hover', 'shopkit' ),
				'desc'        => esc_html__( 'Set the ', 'shopkit' ) . $curr . esc_html__( ' button hover settings. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '18px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '',
					'letter-spacing' => '',
					'line-height' => '48px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_button_style' => array(
				'id'          => $el . '_button_style',
				'label'       => $string . ' ' . esc_html__( 'Button Style', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' button style.', 'shopkit' ),
				'std'         => 'bordered',
				'type'        => 'select',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => $button_styles
			  ),
			$el . '_background' => array(
				'id'          => $el . '_background',
				'label'       => $string . ' ' . esc_html__( ' Background', 'shopkit' ),
				'desc'        => esc_html__( 'Select the background color for the ', 'shopkit' ) . $curr . esc_html__( '. Color opacity is supported.', 'shopkit' ),
				'std'         => '',
				'type'        => 'background',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			  ),
			$el . '_boxshadow' => array(
				'id'          => $el . '_boxshadow',
				'label'       => $string . ' ' . esc_html__( 'Shadow', 'shopkit' ),
				'desc'        => esc_html__( 'Create a shadow for the ', 'shopkit' ) . $curr . esc_html__( ' area.', 'shopkit' ),
				'std'         => '',
				'type'        => 'box-shadow',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h1_font' => array(
				'id'          => $el . '_h1_font',
				'label'       => $string . ' ' . esc_html__( 'H1 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h1 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '36px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '42px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h2_font' => array(
				'id'          => $el . '_h2_font',
				'label'       => $string . ' ' . esc_html__( 'H2 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h2 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '30px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '36px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h3_font' => array(
				'id'          => $el . '_h3_font',
				'label'       => $string . ' ' . esc_html__( 'H3 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h3 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '24px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '30px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h4_font' => array(
				'id'          => $el . '_h4_font',
				'label'       => $string . ' ' . esc_html__( 'H4 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h4 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '18px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '28px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h5_font' => array(
				'id'          => $el . '_h5_font',
				'label'       => $string . ' ' . esc_html__( 'H5 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h5 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '16px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '28px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			),
			$el . '_h6_font' => array(
				'id'          => $el . '_h6_font',
				'label'       => $string . ' ' . esc_html__( 'H6 Font', 'shopkit' ),
				'desc'        => esc_html__( 'Select ', 'shopkit' ) . $curr . esc_html__( ' h6 font. Use system fonts, included fonts or Google Fonts.', 'shopkit' ),
				'std'         => array (
					'font-color' => '#222222',
					'font-family' => '',
					'font-size' => '14px',
					'font-style' => '',
					'font-variant' => '',
					'font-weight' => '600',
					'letter-spacing' => '',
					'line-height' => '28px',
					'text-decoration' => '',
					'text-transform' => '',
				),
				'type'        => 'typography',
				'section'     => 'style',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and'
			)
			);
		break;

		default :
			$curr_section = array();
		break;

		endswitch;

		if ( in_array( $el, self::$settings['header_elements'] ) && isset( $curr_section[$el . '_visibility']['choices'] ) ) {
			$curr_section[$el . '_visibility']['choices'][] = array(
				'value'       => 'shopkit-hidein-sticky',
				'label'       => esc_html__( 'Hide in Sticky Header', 'shopkit' ),
				'src'         => ''
			);
			$curr_section[$el . '_visibility']['choices'][] = array(
				'value'       => 'shopkit-showin-sticky',
				'label'       => esc_html__( 'Visible only in Sticky Header', 'shopkit' ),
				'src'         => ''
			);
		}

		$settings_ot = array(
			'contextual_help' => null,
			'sections'        => array(
				array(
					'id'          => 'content',
					'title'       => esc_html__( 'Content', 'shopkit' )
				),
				array(
					'id'          => 'style',
					'title'       => esc_html__( 'Style', 'shopkit' )
				),
				array(
					'id'          => 'collapsible',
					'title'       => esc_html__( 'Collapsible', 'shopkit' )
				),
				array(
					'id'          => 'responsive',
					'title'       => esc_html__( 'Visibility', 'shopkit' )
				)
			),
			'settings'        => $curr_section
		);

		$id = self::$mode . '_section_' . $el;

		$settings_ot = apply_filters( $id . '_args', $settings_ot );

		self::$settings[$el . '_default'] = $settings_ot;

		if ( $saved_settings !== $settings_ot ) {
			update_option( $id . '_settings', $settings_ot );
		}

		if ( is_admin() ) {
			$settings_section = array(
				'id'              => $id . '_settings',
				'parent_slug'     => 'themes.php',
				'page_title'      => $section['title'],
				'menu_title'      => $section['title'],
				'capability'      => 'edit_theme_options',
				'menu_slug'       => 'shopkit-' . $curr_slug,
				'icon_url'        => null,
				'position'        => null,
				'updated_message' => $section['title'] . esc_html__( ' Updated',  'shopkit' ),
				'reset_message'   => $section['title'] . esc_html__( ' Reset',  'shopkit' ),
				'button_text'     => esc_html__( 'Save Changes', 'shopkit' ),
				'show_buttons'    => true,
				'screen_icon'     => 'options-general',
			);

			ot_register_settings(
				array(
					array(
						'id'              => self::$mode . '_section_' . $el,
						'pages'           => array(
							$settings_section + $settings_ot
						)
					)
				)
			);
		}
	}

			}

		}

		public static function font_families( $array, $field_id ) {

			$fonts = array(
				'inc-opensans' => '"Open Sans", sans-serif',
				'inc-raleway' => '"Raleway", sans-serif',
				'inc-lato' => '"Lato", sans-serif',
				'inc-ptsans' => '"PT Sans", sans-serif',
				'inc-ptserif' => '"PT Serif", serif',
				'inc-ubuntu' => '"Ubuntu", sans-serif',
				'sys-arial' => 'Arial, Helvetica, sans-serif',
				'sys-black' => '"Arial Black", Gadget, sans-serif',
				'sys-georgia' => 'Georgia, serif',
				'sys-impact' => 'Impact, Charcoal, sans-serif',
				'sys-lucida' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
				'sys-palatino' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
				'sys-tahoma' => 'Tahoma, Geneva, sans-serif',
				'sys-times' => '"Times New Roman", Times, serif',
				'sys-trebuchet' => '"Trebuchet MS", Helvetica, sans-serif',
				'sys-verdana' => 'Verdana, Geneva, sans-serif',
			);

			include( 'fonts.php' );

			$fonts = $fonts + $google_fonts;

			if ( $field_id == 'shopkit-settings' ) {
				array_unshift( $fonts, array( '', 'false' ) );
			}

			return $fonts;

		}

		public static function register_sidebars() {

			$widget_title = ShopKit_Ot_Settings::get_settings( 'general', 'sidebar_heading', 'h3' );

			register_sidebar( array (
				'name' => esc_html__( 'Left Sidebar 1', 'shopkit' ),
				'id' => 'sidebar-1',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<' . $widget_title . ' class="shopkit-widget-title">',
				'after_title' => '</' . $widget_title . '>',
				'description' => esc_html__( 'Left Sidebar #1.', 'shopkit' )
			) );

			register_sidebar( array (
				'name' => esc_html__( 'Left Sidebar 2', 'shopkit' ),
				'id' => 'sidebar-2',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<' . $widget_title . ' class="shopkit-widget-title">',
				'after_title' => '</' . $widget_title . '>',
				'description' => esc_html__( 'Left Sidebar #2.', 'shopkit' )
			) );

			register_sidebar( array (
				'name' => esc_html__( 'Right Sidebar 1', 'shopkit' ),
				'id' => 'sidebar-3',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<' . $widget_title . ' class="shopkit-widget-title">',
				'after_title' => '</' . $widget_title . '>',
				'description' => esc_html__( 'Right Sidebar #1.', 'shopkit' )
			) );

			register_sidebar( array (
				'name' => esc_html__( 'Right Sidebar 2', 'shopkit' ),
				'id' => 'sidebar-4',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<' . $widget_title . ' class="shopkit-widget-title">',
				'after_title' => '</' . $widget_title . '>',
				'description' => esc_html__( 'Right Sidebar #2.', 'shopkit' )
			) );

			$header_sections = ShopKit_Ot_Settings::get_settings( 'general', 'header_elements', array() );
			$header_sections = is_array( $header_sections ) ? array_values( $header_sections ) : array();

			$footer_sections = ShopKit_Ot_Settings::get_settings( 'general', 'footer_elements', array() );
			$footer_sections = is_array( $footer_sections ) ? array_values( $footer_sections ) : array();

			$sections = array_merge( $header_sections, $footer_sections );

			foreach( $sections as $curr_id => $curr ) {

				$curr_title = $sections[$curr_id]['title'];
				$curr_section_slug = sanitize_title( $sections[$curr_id]['title'] );
				$curr_section = str_replace( '-', '_', $curr_section_slug );
				$type = $sections[$curr_id]['select_element'];

				if ( $type == 'widget-section' ) {

					$n = 0;
					$q = 0;
					$rows = ShopKit_Ot_Settings::get_settings( $curr_section, $curr_section . '_rows', array() );
					$widget_title = ShopKit_Ot_Settings::get_settings( $curr_section, $curr_section . '_sidebar_heading', array() );

					foreach( $rows as $row ) {

						$q++;
						$layout_mode = $row['select_element'];
						$widget_areas = intval( substr( $layout_mode, -1 ) );

						for ( $i = 1; $i <= $widget_areas; $i++ ) {

							$n++;
							$name = $curr_title . ' ' . $q . '/' . $i;
							$id = $curr_section_slug . '-' . ( $n > 9 ? '_' : '' ) . $n;

							$get = register_sidebar( array (
								'name' => $name,
								'id' => $id,
								'before_widget' => '<section id="%1$s" class="widget %2$s">',
								'after_widget' => '</section>',
								'before_title' => '<' . $widget_title . ' class="shopkit-widget-title">',
								'after_title' => '</' . $widget_title . '>',
								'description' => $curr_title . ' # ' . $q . ' - ' . esc_html__( 'Widget Area', 'shopkit' ) . ' #' . $i
							) );

							$ready_sidebars[] = array(
								'id' => $id,
								'name' => $name
							);

						}

					}
				}

			}

			$widget_title = ShopKit_Ot_Settings::get_settings( 'general', 'sidebar_heading', 'h3' );

			$sidebars = array(
				'sidebar-1' => array(
					'name' => esc_html__( 'Left Sidebar', 'shopkit' ) . ' 1',
					'slug' => 'left_sidebar_1'
				),
				'sidebar-2' => array(
					'name' => esc_html__( 'Left Sidebar', 'shopkit' ) . ' 2',
					'slug' => 'left_sidebar_2'
				),
				'sidebar-3' => array(
					'name' => esc_html__( 'Right Sidebar', 'shopkit' ) . ' 1',
					'slug' => 'right_sidebar_1'
				),
				'sidebar-4' => array(
					'name' => esc_html__( 'Right Sidebar', 'shopkit' ) . ' 2',
					'slug' => 'right_sidebar_2'
				)
			);

			$custom_sidebars = ShopKit_Ot_Settings::get_settings( 'general', 'sidebars', array() );
			$custom_sidebars = is_array( $custom_sidebars ) ? array_values( $custom_sidebars ) : array();

			foreach( $custom_sidebars as $custom_sidebar ) {

				$name = $custom_sidebar['title'];
				$id = 'shopkit-cl-' . sanitize_title( $custom_sidebar['title'] );

				foreach( $sidebars as $k => $v ) {

					if ( $custom_sidebar[$v['slug']] !== 'on' ) {
						continue;
					}

					register_sidebar( array (
						'name' => $v['name'] . ' ' . $name,
						'id' => $id . '-' . substr( $k, -1 ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget' => '</section>',
						'before_title' => '<' . $widget_title . ' class="shopkit-widget-title">',
						'after_title' => '</' . $widget_title . '>',
						'description' => $name . ' - ' . esc_html__( 'Sidebar', 'shopkit' )
					) );

				}

			}

		}

	}

	ShopKit_Ot_Settings::init();

	remove_action( 'ot_after_theme_options_save', 'ot_save_css' );
	add_filter( 'ot_show_new_layout', 'ot_shopkit_layouts' );
	function ot_shopkit_layouts() {
		return false;
	}

?>