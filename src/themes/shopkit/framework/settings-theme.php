<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	class ShopKit_Settings {

		public static $path;
		public static $url;
		public static $settings;

		public static $less_helper;

		public static function init() {
			$class = __CLASS__;
			new $class;
		}

		function __construct() {

			self::$path = trailingslashit( get_template_directory() );
			self::$url = trailingslashit( get_template_directory_uri() );

			self::$less_helper['fonts'] = self::font_families( '', 'shopkit-settings' );

			add_filter( 'shopkit_less', __CLASS__ . '::less_vars', 10, 2 );
			add_filter( 'shopkit_optimize_less', __CLASS__ . '::optimize_less', 10 );

			add_action( 'admin_enqueue_scripts', __CLASS__ . '::add_admin_scripts' );

		}

		public static function compile() {

			$access_type = get_filesystem_method();
			if( $access_type === 'direct' ) {
				$creds = request_filesystem_credentials( site_url() . '/wp-admin/', '', false, false, array() );

				if ( !WP_Filesystem( $creds ) ) {
					return false;
				}

				require_once( get_template_directory() . '/framework/less/lessc.inc.php' );

				$src = WcSk()->template_url() . '/framework/less/shopkit.less';

				$src_scheme = wp_parse_url( $src, PHP_URL_SCHEME );

				$wp_content_url_scheme = wp_parse_url( WP_CONTENT_URL, PHP_URL_SCHEME );

				if ( $src_scheme != $wp_content_url_scheme ) {

					$src = set_url_scheme( $src, $wp_content_url_scheme );

				}

				$file = str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $src );

				$less = new lessc;

				$less->setFormatter( 'compressed' );
				$less->setPreserveComments( 'false' );
				$less->setVariables( apply_filters( 'shopkit_less', array() ) );

				$compile = $less->cachedCompile( $file );

				$upload = wp_upload_dir();

				$id = uniqid();

				$upload_dir = untrailingslashit( $upload['basedir'] ) . '/shopkit-' . $id . '.css';
				$upload_url = untrailingslashit( $upload['baseurl'] ) . '/shopkit-' . $id . '.css';

				$theme = ShopKit_Ot_Settings::$mode;

				if ( false === ( $cached = get_option( '_shopkit_less_styles' ) ) ) {
					$cached_transient = '';
				}
				else {
					if ( isset( $cached[$theme]['id'] ) ) {
						$cached_transient = $cached[$theme]['id'];
						if ( $cached[$theme]['last_known'] !== '' ) {
							$delete = untrailingslashit( $upload['basedir'] ) . '/shopkit-' . $cached[$theme]['last_known'] . '.css';
							if ( is_writable( $delete ) ) {
								unlink( $delete );
							}
						}
					}
					else {
						$cached_transient = '';
					}

				}

				$transient = array(
					'last_known' => $cached_transient,
					'id' => $id,
					'url' => $upload_url
				);


				$cached[$theme] = $transient;

				global $wp_filesystem;
				if ( $wp_filesystem->put_contents( $upload_dir, apply_filters( 'shopkit_optimize_less', $compile['compiled'] ), FS_CHMOD_FILE ) ) {
					update_option( '_shopkit_less_styles', $cached );
					return true;
				}
			}

		}

		public static function add_admin_scripts( $hook ) {

			global $pagenow;

			if ( $pagenow == 'nav-menus.php' ) {
				wp_enqueue_script( 'shopkit-admin-menu', self::$url . 'framework/js/admin-menu.js', array( 'jquery' ), WcSk()->version(), true );

				$curr_args = array(
					'ajaxurl' => admin_url( 'admin-ajax.php' )
				);
				wp_localize_script( 'shopkit-admin-menu', 'shopkit', $curr_args );

				if ( function_exists( 'wp_enqueue_media' ) ) {
					wp_enqueue_media();
				}
			}

			wp_enqueue_style( 'shopkit-admin-pages', self::$url . 'framework/css/admin-pages.css', array(), WcSk()->version() );

		}

		public static function get_settings( $curr, $default = null ) {
			if ( isset( $default ) ) {
				$settings = ot_get_option( $curr, $default );
			}
			else {
				$settings = ot_get_option( $curr );
			}
			return $settings;
		}

		public static function optimize_less( $file_contents ) {
			$file_contents = preg_replace( '/([\w-]+)\s*:\s*unset;?/', '', $file_contents );
			$file_contents = preg_replace( '/([\w-]+)\s*:\s*unset?/', '', $file_contents );

			return $file_contents;
		}

		public static function less_vars() {

			$vars = array();

			$vars['url'] = '~"' . self::$url . '"';

			$vars['rtl'] = is_rtl() ? 'true' : 'false';
			$vars['direction'] = $vars['rtl'] ? 'rtl' : 'ltr';
			$vars['left'] = $vars['rtl'] ? 'right' : 'left';
			$vars['right'] = $vars['rtl'] ? 'left' : 'right';

			$fonts = self::less_get_fonts( 'site_title' );
			foreach( $fonts as $k => $v ) {
				$vars[$k] = $v;
			}
			$fonts = self::less_get_fonts( 'site_description' );
			foreach( $fonts as $k => $v ) {
				$vars[$k] = $v;
			}

			$el_padding = ( $padding = ShopKit_Ot_Settings::get_settings( 'general', 'wrapper_padding' ) ) !== '' ? $padding : '0' ;
			$vars['wrapper_padding'] = $el_padding;

			$padding = self::less_get_padding( 'wrapper', $el_padding );
			foreach( $padding as $k => $v ) {
				$vars[$k] = $v;
			}

			$vars['wrapper_width'] = ShopKit_Ot_Settings::get_settings( 'general', 'wrapper_width' );
			$vars['inner_wrapper_width'] = ShopKit_Ot_Settings::get_settings( 'general', 'inner_wrapper_width' );
			$vars['columns_margin'] = ShopKit_Ot_Settings::get_settings( 'general', 'columns_margin' );
			$vars['rows_margin'] = ShopKit_Ot_Settings::get_settings( 'general', 'rows_margin' );

			$vars['responsive_tablet_mode'] = ShopKit_Ot_Settings::get_settings( 'general', 'responsive_tablet_mode' );
			$vars['responsive_mobile_mode'] = ShopKit_Ot_Settings::get_settings( 'general', 'responsive_mobile_mode' );

			$vars['left_sidebar_1'] = ShopKit_Ot_Settings::get_settings( 'general', 'left_sidebar_1' );
			$vars['left_sidebar_2'] = ShopKit_Ot_Settings::get_settings( 'general', 'left_sidebar_2' );
			$vars['right_sidebar_1'] = ShopKit_Ot_Settings::get_settings( 'general', 'right_sidebar_1' );
			$vars['right_sidebar_2'] = ShopKit_Ot_Settings::get_settings( 'general', 'right_sidebar_2' );

			$sidebars = array ( 'left_sidebar_1' => 'left_sidebar_width_1', 'left_sidebar_2' => 'left_sidebar_width_2', 'right_sidebar_1' => 'right_sidebar_width_1', 'right_sidebar_2' => 'right_sidebar_width_2' );

			foreach( $sidebars as $s => $sw ) {

				$visibility = ShopKit_Ot_Settings::get_settings( 'general', $s . '_visibility' );

				if ( is_array( $visibility ) ) {
					if ( in_array( 'shopkit-responsive-medium', $visibility ) ) {
						$vars[$sw . '_medium'] = 0;
					}
					else {
						$vars[$sw . '_medium'] = $vars[$s] == 'on' ? intval( ShopKit_Ot_Settings::get_settings( 'general', $sw ) ) : 0;
					}
					if ( in_array( 'shopkit-responsive-high', $visibility ) ) {
						$vars[$sw . '_high'] = 0;
					}
					else {
						$vars[$sw . '_high'] = $vars[$s] == 'on' ? intval( ShopKit_Ot_Settings::get_settings( 'general', $sw ) ) : 0;
					}
				}
				else {
					$vars[$sw . '_high'] = $vars[$s] == 'on' ? intval( ShopKit_Ot_Settings::get_settings( 'general', $sw ) ) : 0;
					$vars[$sw . '_medium'] = $vars[$s] == 'on' ? intval( ShopKit_Ot_Settings::get_settings( 'general', $sw ) ) : 0;
				}

			}

			$vars['sidebars_width_medium'] = $vars['left_sidebar_width_1_medium'] + $vars['left_sidebar_width_2_medium']+ $vars['right_sidebar_width_1_medium'] + $vars['right_sidebar_width_2_medium'];
			$vars['sidebars_width_high'] = $vars['left_sidebar_width_1_high'] + $vars['left_sidebar_width_2_high']+ $vars['right_sidebar_width_1_high'] + $vars['right_sidebar_width_2_high'];

			$sidebars = ShopKit_Ot_Settings::get_settings( 'general', 'sidebars', array() );

			if ( !empty( $sidebars ) ) {

				$sidebars_std = array(
					'sidebar-1' => array(
						'name' => esc_html__( 'Left Sidebar', 'shopkit' ) . ' 1',
						'slug' => 'left_sidebar_1',
						'width' => 'left_sidebar_width_1'
					),
					'sidebar-2' => array(
						'name' => esc_html__( 'Left Sidebar', 'shopkit' ) . ' 2',
						'slug' => 'left_sidebar_2',
						'width' => 'left_sidebar_width_2'
					),
					'sidebar-3' => array(
						'name' => esc_html__( 'Right Sidebar', 'shopkit' ) . ' 1',
						'slug' => 'right_sidebar_1',
						'width' => 'right_sidebar_width_1'
					),
					'sidebar-4' => array(
						'name' => esc_html__( 'Right Sidebar', 'shopkit' ) . ' 2',
						'slug' => 'right_sidebar_2',
						'width' => 'right_sidebar_width_2'
					)
				);

				$sidebar_elements = array();

				foreach( $sidebars as $k => $v ) {

					$name = sanitize_title( $v['title'] );
					$id = str_replace( '-', '_', $name );

					$sidebar_elements['slugs'][] = $id;
					$sidebar_elements['names'][] = $name;

					foreach( $sidebars_std as $k1 => $v1 ) {

						$slug = $id . '_' . $v1['slug'];
						$width = $id . '_' . $v1['width'];

						if ( $v[$v1['slug']] !== 'on' ) {
							$vars[$slug] = 'off';
							$vars[$width . '_medium'] = 0;
							$vars[$width . '_high'] = 0;
							continue;
						}

						$vars[$slug] = 'on';

						$visibility = isset( $v[$v1['slug'] . '_visibility'] ) ? $v[$v1['slug'] . '_visibility'] : array();

						if ( is_array( $visibility ) ) {
							if ( in_array( 'shopkit-responsive-medium', $visibility ) ) {
								$vars[$width . '_medium'] = 0;
							}
							else {
								$vars[$width . '_medium'] = $vars[$slug] == 'on' ? intval( $v[$v1['width']] ) : 0;
							}
							if ( in_array( 'shopkit-responsive-high', $visibility ) ) {
								$vars[$width . '_high'] = 0;
							}
							else {
								$vars[$width . '_high'] = $vars[$slug] == 'on' ? intval( $v[$v1['width']] ) : 0;
							}
						}
						else {
							$vars[$width . '_high'] = $vars[$slug] == 'on' ? intval( $v[$v1['width']] ) : 0;
							$vars[$width . '_medium'] = $vars[$slug] == 'on' ? intval( $v[$v1['width']] ) : 0;
						}

					}

					$vars[$id . '_width_medium'] = $vars[$id . '_left_sidebar_width_1_medium'] + $vars[$id . '_left_sidebar_width_2_medium']+ $vars[$id . '_right_sidebar_width_1_medium'] + $vars[$id . '_right_sidebar_width_2_medium'];
					$vars[$id . '_width_high'] = $vars[$id . '_left_sidebar_width_1_high'] + $vars[$id . '_left_sidebar_width_2_high']+ $vars[$id . '_right_sidebar_width_1_high'] + $vars[$id . '_right_sidebar_width_2_high'];

				}

				$vars['sidebar_layout_names'] = implode( ' ', $sidebar_elements['slugs'] );
				$vars['sidebar_layout_slugs'] = implode( ' ', $sidebar_elements['names'] );
				$vars['sidebar_layout_length'] = count( $sidebar_elements['names'] );

			}
			else {
				$vars['sidebar_layout_names'] = '';
				$vars['sidebar_layout_slugs'] = '';
				$vars['sidebar_layout_length'] = 0;
			}

			$fonts = self::less_get_fonts( 'content', 'general' );
			foreach( $fonts as $k => $v ) {
				$vars[$k] = $v;
			}

			$elements = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'button', 'button_hover' );

			foreach( $elements as $k => $el ) {

				$el = 'content_' . $el;

				$fonts = self::less_get_fonts( $el );
				foreach( $fonts as $k => $v ) {
					$vars[$k] = $v;
				}

			}

			$backgrounds = array( 'content', '_wrapper', '_header', '_footer' );
			foreach( $backgrounds as $background ) {
				$background_data = self::less_get_background( $background );
				foreach( $background_data as $k => $v ) {
					$vars[$k] = $v;
				}
			}

			$colors = self::less_get_colors( 'content' );
			foreach( $colors as $k => $v ) {
				$vars[$k] = $v;
			}

			$el_padding =  ( $padding = ShopKit_Ot_Settings::get_settings( 'general', 'content_padding' ) ) !== '' ? $padding : '0' ;
			$vars['content_padding'] = '~"' . $el_padding . '"';

			$padding = self::less_get_padding( 'content', $el_padding );
			foreach( $padding as $k => $v ) {
				$vars[$k] = $v;
			}

			$boxshadows = array( 'content_boxshadow', '_wrapper_boxshadow', '_header_boxshadow', '_footer_boxshadow' );

			foreach ( $boxshadows as $shadow ) {
				$boxshadow = ShopKit_Ot_Settings::get_settings( 'general', $shadow );

				if ( is_array( $boxshadow ) ) {
					$vars[$shadow . '_active'] = true;
					$vars[$shadow] = '' . implode( ' ', $boxshadow ) . '';
				}
				else {
					$vars[$shadow . '_active'] = 'false';
					$vars[$shadow] = '';
				}
			}

			$vars['content_button_style'] = ShopKit_Ot_Settings::get_settings( 'general', 'content_button_style' );

			$elements_header = array(
				'elements-bar' => array(
					'names' => array(),
					'slugs' => array()
				),
				'widget-section' => array(
					'names' => array(),
					'slugs' => array()
				),
				'content-text-html' => array(
					'names' => array(),
					'slugs' => array()
				)
			);

			$elements_footer = $elements_header;

			$header_elements = ShopKit_Ot_Settings::get_settings( 'general', 'header_elements', array() );
			$footer_elements = ShopKit_Ot_Settings::get_settings( 'general', 'footer_elements', array() );

			foreach( $header_elements as $section ) {
				$curr_section_slug = sanitize_title( $section['title'] );
				$elements_header[$section['select_element']]['slugs'][] = $curr_section_slug;
				$elements_header[$section['select_element']]['names'][] = str_replace( '-', '_', $curr_section_slug );
			}
			foreach( $footer_elements as $section ) {
				$curr_section_slug = sanitize_title( $section['title'] );
				$elements_footer[$section['select_element']]['slugs'][] = $curr_section_slug;
				$elements_footer[$section['select_element']]['names'][] = str_replace( '-', '_', $curr_section_slug );
			}

			$elements['elements-bar']['names'] = array_merge( $elements_header['elements-bar']['names'], $elements_footer['elements-bar']['names'] );
			$elements['elements-bar']['slugs'] = array_merge( $elements_header['elements-bar']['slugs'], $elements_footer['elements-bar']['slugs'] );

			foreach( $elements['elements-bar']['names'] as $el ) {

				$menu_effects = self::less_get_menu_effects( $el );
				
				foreach( $menu_effects as $k => $v ) {
					$vars[$k] = $v;
				}

				$background = self::less_get_background( $el, $el );
				foreach( $background as $k => $v ) {
					$vars[$k] = $v;
				}

				$colors = self::less_get_colors( $el, $el );
				foreach( $colors as $k => $v ) {
					$vars[$k] = $v;
				}

				$fonts = self::less_get_fonts( $el, $el );
				foreach( $fonts as $k => $v ) {
					$vars[$k] = $v;
				}

				$inner_elements = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'button', 'button_hover' );

				foreach( $inner_elements as $ik => $iel ) {

					$iel = $el . '_' . $iel;

					$fonts = self::less_get_fonts( $iel, $el );
					foreach( $fonts as $k => $v ) {
						$vars[$k] = $v;
					}

				}

				$vars[$el . '_button_style'] = ShopKit_Ot_Settings::get_settings( $el, $el . '_button_style' );

				$el_padding =  ( $padding = ShopKit_Ot_Settings::get_settings( $el, $el . '_padding' ) ) !== '' ? $padding : '0' ;
				$vars[$el . '_padding'] = '~"' . $el_padding . '"';

				$padding = self::less_get_padding( $el, $el_padding );
				foreach( $padding as $k => $v ) {
					$vars[$k] = $v;
				}

				$boxshadow = ShopKit_Ot_Settings::get_settings( $el, $el . '_boxshadow' );
				if ( is_array( $boxshadow ) ) {
					$vars[$el . '_boxshadow_active'] = 'true';
					$vars[$el . '_boxshadow'] = '~"' . implode( ' ', $boxshadow  ) . '"';
				}
				else {
					$vars[$el . '_boxshadow_active'] = 'false';
					$vars[$el . '_boxshadow'] = '';
				}

				$vars[$el . '_outer_elements_align'] = '~"' . ShopKit_Ot_Settings::get_settings( $el, $el . '_outer_elements_align' ) . '"';
				$vars[$el . '_inner_elements_align'] = '~"' . ShopKit_Ot_Settings::get_settings( $el, $el . '_inner_elements_align' ) . '"';

				$vars[$el . '_type_height'] = ( $self = ShopKit_Ot_Settings::get_settings( $el, $el . '_type_height' ) ) !== '' ? preg_replace( '/[^\d]/', '', $self ) : 30;
			}
			
			if ( !empty( $elements['elements-bar']['names'] ) ) {
				$vars['section_elements_bar_slugs'] = implode( ' ', $elements['elements-bar']['slugs'] );
				$vars['section_elements_bar_names'] = implode( ' ', $elements['elements-bar']['names'] );
				$vars['sections_elements_bar_length'] = count( $elements['elements-bar']['names'] );
			}
			else {
				$vars['section_elements_bar_slugs'] = '';
				$vars['section_elements_bar_names'] = '';
				$vars['sections_elements_bar_length'] = 0;
			}

			$elements['widget-section']['names'] = array_merge( $elements_header['widget-section']['names'], $elements_footer['widget-section']['names'] );
			$elements['widget-section']['slugs'] = array_merge( $elements_header['widget-section']['slugs'], $elements_footer['widget-section']['slugs'] );

			foreach( $elements['widget-section']['names'] as $el ) {

				$background = self::less_get_background( $el, $el );
				foreach( $background as $k => $v ) {
					$vars[$k] = $v;
				}

				$colors = self::less_get_colors( $el, $el );
				foreach( $colors as $k => $v ) {
					$vars[$k] = $v;
				}

				$fonts = self::less_get_fonts( $el, $el );
				foreach( $fonts as $k => $v ) {
					$vars[$k] = $v;
				}

				$inner_elements = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'button', 'button_hover' );

				foreach( $inner_elements as $ik => $iel ) {

					$iel = $el . '_' . $iel;

					$fonts = self::less_get_fonts( $iel, $el );
					foreach( $fonts as $k => $v ) {
						$vars[$k] = $v;
					}

				}

				$vars[$el . '_button_style'] = ShopKit_Ot_Settings::get_settings( $el, $el . '_button_style' );

				$el_padding =  ( $padding = ShopKit_Ot_Settings::get_settings( $el, $el . '_padding' ) ) !== '' ? $padding : '0' ;
				$vars[$el . '_padding'] = '~"' . $el_padding . '"';

				$padding = self::less_get_padding( $el, $el_padding );
				foreach( $padding as $k => $v ) {
					$vars[$k] = $v;
				}

				$boxshadow = ShopKit_Ot_Settings::get_settings( $el, $el . '_boxshadow' );
				if ( is_array( $boxshadow ) ) {
					$vars[$el . '_boxshadow_active'] = 'true';
					$vars[$el . '_boxshadow'] = '~"' . implode( ' ', $boxshadow ) . '"';
				}
				else {
					$vars[$el . '_boxshadow_active'] = 'false';
					$vars[$el . '_boxshadow'] = '';
				}

				$vars[$el . '_type_height'] = ( $self = ShopKit_Ot_Settings::get_settings( $el, $el . '_type_height' ) ) !== '' ? preg_replace( '/[^\d]/', '', $self ) : 30;

				$vars[$el . '_margin_override'] = ( $self = ShopKit_Ot_Settings::get_settings( $el, $el . '_margin_override' ) ) !== '' ? $self : 'off';
				$vars[$el . '_columns_margin'] = ( $self = ShopKit_Ot_Settings::get_settings( $el, $el . '_columns_margin' ) ) !== '' ? $self : 60;
				$vars[$el . '_rows_margin'] = ( $self = ShopKit_Ot_Settings::get_settings( $el, $el . '_rows_margin' ) ) !== '' ? $self : 30;

			}

			if ( !empty( $elements['widget-section']['names'] ) ) {
				$vars['section_widget_section_slugs'] = implode( ' ', $elements['widget-section']['slugs'] );
				$vars['section_widget_section_names'] = implode( ' ', $elements['widget-section']['names'] );
				$vars['sections_widget_section_length'] = count( $elements['widget-section']['names'] );
			}
			else {
				$vars['section_widget_section_slugs'] = '';
				$vars['section_widget_section_names'] = '';
				$vars['sections_widget_section_length'] = 0;
			}

			$elements['content-text-html']['names'] = array_merge( $elements_header['content-text-html']['names'], $elements_footer['content-text-html']['names'] );
			$elements['content-text-html']['slugs'] = array_merge( $elements_header['content-text-html']['slugs'], $elements_footer['content-text-html']['slugs'] );

			foreach( $elements['content-text-html']['names'] as $el ) {

				$background = self::less_get_background( $el, $el );
				foreach( $background as $k => $v ) {
					$vars[$k] = $v;
				}

				$colors = self::less_get_colors( $el, $el );
				foreach( $colors as $k => $v ) {
					$vars[$k] = $v;
				}

				$fonts = self::less_get_fonts( $el, $el );
				foreach( $fonts as $k => $v ) {
					$vars[$k] = $v;
				}

				$inner_elements = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'button', 'button_hover' );

				foreach( $inner_elements as $ik => $iel ) {

					$iel = $el . '_' . $iel;

					$fonts = self::less_get_fonts( $iel, $el );
					foreach( $fonts as $k => $v ) {
						$vars[$k] = $v;
					}

				}

				$vars[$el . '_button_style'] = ShopKit_Ot_Settings::get_settings( $el, $el . '_button_style' );

				$el_padding =  ( $padding = ShopKit_Ot_Settings::get_settings( $el, $el . '_padding' ) ) !== '' ? $padding : '0' ;
				$vars[$el . '_padding'] = '~"' . $el_padding . '"';

				$padding = self::less_get_padding( $el, $el_padding );
				foreach( $padding as $k => $v ) {
					$vars[$k] = $v;
				}

				$boxshadow = ShopKit_Ot_Settings::get_settings( $el, $el . '_boxshadow' );
				if ( is_array( $boxshadow ) ) {
					$vars[$el . '_boxshadow_active'] = 'true';
					$vars[$el . '_boxshadow'] = '~"' . implode( ' ', $boxshadow ) . '"';
				}
				else {
					$vars[$el . '_boxshadow_active'] = 'false';
					$vars[$el . '_boxshadow'] = '';
				}

				$vars[$el . '_type_height'] = ( $self = ShopKit_Ot_Settings::get_settings( $el, $el . '_type_height' ) ) !== '' ? preg_replace( '/[^\d]/', '', $self ) : 30;

			}

			if ( !empty( $elements['content-text-html']['names'] ) ) {
				$vars['section_content_text_html_slugs'] = implode( ' ', $elements['content-text-html']['slugs'] );
				$vars['section_content_text_html_names'] = implode( ' ', $elements['content-text-html']['names'] );
				$vars['sections_content_text_html_length'] = count( $elements['content-text-html']['names'] );
			}
			else {
				$vars['section_content_text_html_slugs'] = '';
				$vars['section_content_text_html_names'] = '';
				$vars['sections_content_text_html_length'] = 0;
			}

			if ( isset( self::$less_helper['inc_fonts'] ) ) {
				foreach( self::$less_helper['inc_fonts'] as $k => $v ) {
					$vars['inc_font_names'][] = $v['name'];
					$vars['inc_font_slugs'][] = $v['slug'];
				}
				$vars['inc_active'] = 'true';
				$vars['inc_length'] = count( $vars['inc_font_names'] );
				$vars['inc_font_names'] = implode( ', ', $vars['inc_font_names'] );
				$vars['inc_font_slugs'] = implode( ', ', $vars['inc_font_slugs'] );
			}
			else {
				$vars['inc_active'] = 'false';
				$vars['inc_length'] = 0;
				$vars['inc_font_names'] = '';
				$vars['inc_font_slugs'] = '';
			}

			if ( isset( self::$less_helper['ggl_fonts'] ) ) {
				set_transient( '_shopkit_google_fonts', self::$less_helper['ggl_fonts'] );
			}

			if ( ShopKit_Ot_Settings::get_settings( 'general', 'wc_shop_products_margin', 'off' ) == 'on' ) {
				$vars['wc_columns_margin'] = ShopKit_Ot_Settings::get_settings( 'general', 'wc_shop_products_columns_margin', '30' );
				$vars['wc_rows_margin'] = ShopKit_Ot_Settings::get_settings( 'general', 'wc_shop_products_rows_margin', '30' );
			}
			else {
				$vars['wc_columns_margin'] = $vars['columns_margin'];
				$vars['wc_rows_margin'] = $vars['rows_margin'];
			}

			$vars['wc_image_position'] = ShopKit_Ot_Settings::get_settings( 'general', 'wc_image_position', 'imageleft' );
			$vars['wc_single_image_size'] = ShopKit_Ot_Settings::get_settings( 'general', 'wc_single_image_size', '2' );
			$vars['wc_product_style'] = ShopKit_Ot_Settings::get_settings( 'general', 'wc_product_style', 'none' );
			$vars['wc_image_effect'] = ShopKit_Ot_Settings::get_settings( 'general', 'wc_image_effect', 'none' );
			$vars['wc_sticky'] = '{ background-image: url("data:image/svg+xml;charset=utf8,%3Csvg%20version%3D%271.1%27%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20xmlns%3Axlink%3D%27http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%27%20x%3D%270%27%20y%3D%270%27%20viewBox%3D%270%200%20256%20256%27%20enable-background%3D%27new%200%200%2050%2050%27%20xml%3Aspace%3D%27preserve%27%20preserveAspectRatio%3D%27none%27%3E%3Cpath%20fill%3D%27%23' . substr( $vars['content_link'], 1 ) . '%27%20d%3D%27M185%20167c-2%2C1%20-5%2C1%20-7%2C-1%20-2%2C-2%20-2%2C-5%200%2C-7%207%2C-6%2012%2C-13%2014%2C-18%202%2C-5%203%2C-9%201%2C-11%200%2C-1%20-1%2C-2%20-1%2C-2%200%2C0%20-1%2C0%20-1%2C0l0%20-1c-4%2C-2%20-10%2C-3%20-18%2C-2%20-12%2C2%20-27%2C7%20-41%2C15%200%2C0%200%2C0%20-1%2C0%20-14%2C9%20-26%2C19%20-33%2C28%20-5%2C6%20-7%2C12%20-7%2C17l0%201c0%2C0%200%2C0%200%2C0%200%2C1%200%2C1%201%2C2%201%2C3%205%2C4%2010%2C5%206%2C1%2014%2C0%2023%2C-3%203%2C-1%205%2C1%206%2C3%201%2C3%200%2C6%20-3%2C6%20-10%2C3%20-20%2C5%20-27%2C4%20-8%2C-1%20-15%2C-4%20-18%2C-10%20-1%2C-2%20-1%2C-3%20-2%2C-5%200%2C-1%200%2C-1%200%2C-1l-8%20-51%20-20%20-53c-2%2C-6%20-1%2C-12%205%2C-19%204%2C-6%2011%2C-12%2020%2C-17l0%200c9%2C-5%2017%2C-8%2025%2C-9%208%2C-1%2015%2C1%2018%2C5l37%2045%2040%2032c0%2C0%200%2C0%200%2C0%201%2C1%203%2C3%204%2C5l0%200c3%2C5%203%2C12%20-1%2C20%20-3%2C7%20-8%2C14%20-16%2C22zm-29%20-11l24%2056c1%2C2%200%2C4%20-2%2C6%20-2%2C1%20-5%2C1%20-6%2C-2l-36%20-48%200%200c-2%2C-3%20-1%2C-6%201%2C-7l12%20-7c0%2C0%200%2C0%201%2C0%202%2C-1%205%2C0%206%2C2zm-68%209c1%2C-1%201%2C-2%202%2C-3%208%2C-10%2021%2C-21%2037%2C-30l0%200c15%2C-10%2031%2C-15%2044%2C-17%202%2C0%203%2C0%204%2C0l-24%20-20c0%2C0%20-1%2C0%20-1%2C0l-37%20-45c0%2C-1%200%2C-1%20-1%2C-1%20-1%2C-2%20-4%2C-2%20-8%2C-1%20-6%2C0%20-14%2C3%20-21%2C7%20-8%2C5%20-14%2C10%20-18%2C15%20-2%2C4%20-4%2C7%20-3%2C8%200%2C0%201%2C1%201%2C1l20%2054c0%2C1%200%2C1%200%2C1l0%200%205%2031z%27%2F%3E%3C%2Fsvg%3E"); }';
			$vars['wc_woo_rating'] = '{ background-image: url("data:image/svg+xml;charset=utf8,%3Csvg%20version%3D%271.1%27%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20xmlns%3Axlink%3D%27http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%27%20x%3D%270px%27%20y%3D%270px%27%20viewBox%3D%270%200%2050%2050%27%20enable-background%3D%27new%200%200%2050%2050%27%20xml%3Aspace%3D%27preserve%27%20preserveAspectRatio%3D%27none%27%3E%3Cpath%20fill%3D%27%23ccc%27%20d%3D%27M12.6336%2031.2652l-3.6404%2015.2444c-0.1469%2C0.6109%200.089%2C1.2499%200.5937%2C1.6218%200.5062%2C0.3703%201.1827%2C0.4062%201.7249%2C0.0844l13.6898%20-8.1292%2013.6835%208.1292c0.2468%2C0.1468%200.5234%2C0.2202%200.7984%2C0.2202%200.3265%2C0%200.6515%2C-0.1015%200.9265%2C-0.3031%200.5046%2C-0.3718%200.7406%2C-1.0108%200.5937%2C-1.6217l-3.6404%20-15.2444%2012.0836%20-10.24c0.4828%2C-0.4078%200.6718%2C-1.0671%200.4781%2C-1.6686%20-0.1922%2C-0.6016%20-0.7296%2C-1.0281%20-1.3593%2C-1.0797l-15.9381%20-1.3155%20-6.1918%20-14.4522c-0.2452%2C-0.575%20-0.8108%2C-0.9468%20-1.4358%2C-0.9468%20-0.625%2C0%20-1.1906%2C0.3718%20-1.4358%2C0.9468l-6.1965%2014.4522%20-15.9334%201.314c-0.6297%2C0.0515%20-1.1671%2C0.4781%20-1.3593%2C1.0796%20-0.1937%2C0.6015%20-0.0047%2C1.2609%200.4781%2C1.6686l12.0805%2010.24zm5.9277%20-11.2665c0.5766%2C-0.0468%201.0797%2C-0.4093%201.3078%2C-0.9421l5.1309%20-11.9664%205.1247%2011.9649c0.2281%2C0.5327%200.7312%2C0.8952%201.3077%2C0.9421l13.1148%201.0812%20-9.9384%208.4229c-0.45%2C0.3796%20-0.6469%2C0.9812%20-0.5094%2C1.5546l3.0061%2012.5851%20-11.3055%20-6.7167c-0.4906%2C-0.2938%20-1.1047%2C-0.2938%20-1.5953%2C0l-11.3118%206.7183%203.0061%20-12.5867c0.1375%2C-0.5734%20-0.0594%2C-1.175%20-0.5093%2C-1.5546l-9.9354%20-8.4229%2013.107%20-1.0797z%27%2F%3E%3C%2Fsvg%3E"); }';
			$vars['wc_woo_rating_colored'] = '{ background-image: url("data:image/svg+xml;charset=utf8,%3Csvg%20version%3D%271.1%27%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20xmlns%3Axlink%3D%27http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%27%20x%3D%270px%27%20y%3D%270px%27%20viewBox%3D%270%200%2050%2050%27%20enable-background%3D%27new%200%200%2050%2050%27%20xml%3Aspace%3D%27preserve%27%20preserveAspectRatio%3D%27none%27%3E%3Cpath%20fill%3D%27%23' . substr( $vars['content_link'], 1 ) . '%27%20d%3D%27M12.6336%2031.2652l-3.6404%2015.2444c-0.1469%2C0.6109%200.089%2C1.2499%200.5937%2C1.6218%200.5062%2C0.3703%201.1827%2C0.4062%201.7249%2C0.0844l13.6898%20-8.1292%2013.6835%208.1292c0.2468%2C0.1468%200.5234%2C0.2202%200.7984%2C0.2202%200.3265%2C0%200.6515%2C-0.1015%200.9265%2C-0.3031%200.5046%2C-0.3718%200.7406%2C-1.0108%200.5937%2C-1.6217l-3.6404%20-15.2444%2012.0836%20-10.24c0.4828%2C-0.4078%200.6718%2C-1.0671%200.4781%2C-1.6686%20-0.1922%2C-0.6016%20-0.7296%2C-1.0281%20-1.3593%2C-1.0797l-15.9381%20-1.3155%20-6.1918%20-14.4522c-0.2452%2C-0.575%20-0.8108%2C-0.9468%20-1.4358%2C-0.9468%20-0.625%2C0%20-1.1906%2C0.3718%20-1.4358%2C0.9468l-6.1965%2014.4522%20-15.9334%201.314c-0.6297%2C0.0515%20-1.1671%2C0.4781%20-1.3593%2C1.0796%20-0.1937%2C0.6015%20-0.0047%2C1.2609%200.4781%2C1.6686l12.0805%2010.24zm5.9277%20-11.2665c0.5766%2C-0.0468%201.0797%2C-0.4093%201.3078%2C-0.9421l5.1309%20-11.9664%205.1247%2011.9649c0.2281%2C0.5327%200.7312%2C0.8952%201.3077%2C0.9421l13.1148%201.0812%20-9.9384%208.4229c-0.45%2C0.3796%20-0.6469%2C0.9812%20-0.5094%2C1.5546l3.0061%2012.5851%20-11.3055%20-6.7167c-0.4906%2C-0.2938%20-1.1047%2C-0.2938%20-1.5953%2C0l-11.3118%206.7183%203.0061%20-12.5867c0.1375%2C-0.5734%20-0.0594%2C-1.175%20-0.5093%2C-1.5546l-9.9354%20-8.4229%2013.107%20-1.0797z%27%2F%3E%3C%2Fsvg%3E"); }';

			if ( isset( self::$less_helper['css_menu'] ) ) {
				$vars['css_menu_active'] = 'true';
				$vars['css_menu'] = '{ ' . self::$less_helper['css_menu'] . ' }';
			}
			else {
				$vars['css_menu_active'] = 'false';
				$vars['css_menu'] = '';
			}

			$custom_css = array( 'custom_css', 'responsive_tablet_css', 'responsive_mobile_css' );

			foreach( $custom_css as $ccss ) {

				$custom_css = ShopKit_Ot_Settings::get_settings( 'general', $ccss );

				if ( $custom_css !== '' ) {
					$vars[$ccss .'_active'] = 'true';
					$vars[$ccss] = '{ ' . htmlspecialchars_decode( $custom_css, ENT_QUOTES ) . ' }';
				}
				else {
					$vars[$ccss .'_active'] = 'false';
					$vars[$ccss] = '';
				}

			}

			return $vars;

		}

		public static function less_get_menu_effects( $el ) {

			$menus = array(
				$el . '_menu_active' => 'false',
				$el . '_menu_length' => 0,
				$el . '_menu' => '',
				$el . '_menu_effect' => '',
				$el . '_menu_font_color' => '',
				$el . '_menu_font_hover' => '',
				$el . '_menu_background_active' => '',
				$el . '_submenu_font_color' => '',
				$el . '_submenu_font_hover' => '',
				$el . '_submenu_background_active' => '',
				$el . '_submenu_background' => ''
			);

			$fonts = array( $el . '_menu', $el . '_submenu' );

			$curr_elements['left'] = ShopKit_Ot_Settings::get_settings( $el, $el . '_elements_on_left' );
			$curr_elements['right'] = ShopKit_Ot_Settings::get_settings( $el, $el . '_elements_on_right' );

			if ( ShopKit_Ot_Settings::get_settings( $el, $el . '_active' ) == 'off' ) {
				return $menus;
			}

			if ( empty( $curr_elements['left'] ) && empty( $curr_elements['right'] ) ) {
				return $menus;
			}

			foreach( $curr_elements as $k => $v ) {

				if ( !empty( $v ) ) {
					foreach( $v as $curr ) {
						if ( $curr['select_element'] !== 'menu' ) continue;

						if ( !isset( self::$less_helper[$curr['menu']] ) ) {
							self::$less_helper[$curr['menu']] = 0;
						}
						else {
							self::$less_helper[$curr['menu']]++;
						}

						$curr_menu = $curr['menu'] . ( self::$less_helper[$curr['menu']] !== 0 ? '-' . self::$less_helper[$curr['menu']] : '' );

						$fonts = array(
							$el . '_menu' => $curr['menu_font'],
							$el . '_submenu' => $curr['menu_submenu_font']
						);

						foreach( $fonts as $place => $font ) {

							if ( !isset( $font['font-family'] ) ) {
								$font['font-family'] = 'sys-arial';
							}

							$type = substr( $font['font-family'], 0, 3 );

							if ( in_array( $type, array( 'inc', 'ggl' ) ) ) {
								if ( !isset( self::$less_helper[$type . '_fonts'][$font['font-family']] ) ) {
									self::$less_helper[$type . '_fonts'][$font['font-family']]['slug'] = substr( $font['font-family'], 4 );
									self::$less_helper[$type . '_fonts'][$font['font-family']]['name'] = self::$less_helper['fonts'][$font['font-family']];
								}
							}

							$menus_style[$place . '_font_family'][] = isset( $font['font-family'] ) && $font['font-family'] !== '' ? self::$less_helper['fonts'][$font['font-family']] : 'unset';
							$menus_style[$place . '_font_color'][] = isset( $font['font-color'] ) && $font['font-color'] !== '' ? $font['font-color'] : 'unset';
							$menus_style[$place . '_font_size'][] = isset( $font['font-size'] ) && $font['font-size'] !== '' ? $font['font-size'] : 'unset';
							$menus_style[$place . '_font_style'][] = isset( $font['font-style'] ) && $font['font-style'] !== '' ? $font['font-style'] : 'unset';
							$menus_style[$place . '_font_variant'][] = isset( $font['font-variant'] ) && $font['font-variant'] !== '' ? $font['font-variant'] : 'unset';
							$menus_style[$place . '_font_weight'][] = isset( $font['font-weight'] ) && $font['font-weight'] !== '' ? $font['font-weight'] : 'unset';
							$menus_style[$place . '_letter_spacing'][] = isset( $font['letter-spacing'] ) && $font['letter-spacing'] !== '' ? $font['letter-spacing'] : 'unset';
							$menus_style[$place . '_line_height'][] = isset( $font['line-height'] ) && $font['line-height'] !== '' ? $font['line-height'] : 'unset';
							$menus_style[$place . '_text_decoration'][] = isset( $font['text-decoration'] ) && $font['text-decoration'] !== '' ? $font['text-decoration'] : 'unset';
							$menus_style[$place . '_text_transform'][] = isset( $font['text-transform'] ) && $font['text-transform'] !== '' ? $font['text-transform'] : 'unset';

						}

						$menus_style[$el . '_menu'][] = ( $curr_menu == 'none' ? 'all-pages' : $curr_menu );
						$menus_style[$el . '_menu_effect'][] = $curr['menu_effect'];

						$menus_style[$el . '_menu_font_hover'][] = $curr['menu_font_hover'];
						$menus_style[$el . '_menu_background_active'][] = $curr['menu_background_active'];
						$menus_style[$el . '_submenu_font_hover'][] = $curr['menu_submenu_font_hover'];
						$menus_style[$el . '_submenu_background_active'][] = $curr['menu_submenu_background_active'];
						$menus_style[$el . '_submenu_background'][] = $curr['menu_submenu_background'];

					}
				}

			}

			if ( !empty( $menus_style ) && is_array( $menus_style[$el . '_menu'] ) ) {

				$menus[$el . '_menu_active'] = 'true';
				$menus[$el . '_menu_length'] = count( $menus_style[$el . '_menu'] );
				$menus[$el . '_menu'] = implode( ', ', $menus_style[$el . '_menu'] );
				$menus[$el . '_menu_effect'] = implode( ', ', $menus_style[$el . '_menu_effect'] );

				$menus[$el . '_menu_font_color'] = implode( ', ', $menus_style[$el . '_menu_font_color'] );
				$menus[$el . '_menu_font_hover'] = implode( ', ', $menus_style[$el . '_menu_font_hover'] );
				$menus[$el . '_menu_background_active'] = implode( ', ', $menus_style[$el . '_menu_background_active'] );
				$menus[$el . '_submenu_font_color'] = implode( ', ', $menus_style[$el . '_submenu_font_color'] );
				$menus[$el . '_submenu_font_hover'] = implode( ', ', $menus_style[$el . '_submenu_font_hover'] );
				$menus[$el . '_submenu_background_active'] = implode( ', ', $menus_style[$el . '_submenu_background_active'] );
				$menus[$el . '_submenu_background'] = implode( ', ', $menus_style[$el . '_submenu_background'] );

				for ($i = 0; $i < $menus[$el . '_menu_length']; $i++) {

					$menu = $menus_style[$el . '_menu'][$i];
					$css = '#menu-' . $menu . ' {font-family:' . $menus_style[$el . '_menu_font_family'][$i] . ';font-size:' . $menus_style[$el . '_menu_font_size'][$i] . ';font-style:' . $menus_style[$el . '_menu_font_style'][$i] . ';font-variant:' . $menus_style[$el . '_menu_font_variant'][$i] . ';font-weight:' . $menus_style[$el . '_menu_font_weight'][$i] . ';letter-spacing:' . $menus_style[$el . '_menu_letter_spacing'][$i] . ';line-height:' . $menus_style[$el . '_menu_line_height'][$i] . ';text-decoration:' . $menus_style[$el . '_menu_text_decoration'][$i] . ';text-transform:' . $menus_style[$el . '_menu_text_transform'][$i] . ';}#menu-' . $menu . ' > li > ul {padding:' . intval( $menus_style[$el . '_submenu_line_height'][$i] ) * 0.6 .'px 0 ' . intval( $menus_style[$el . '_submenu_line_height'][$i] ) * 0.3 . 'px;}#menu-' . $menu . ' ul {font-family:' . $menus_style[$el . '_submenu_font_family'][$i] . ';font-size:' . $menus_style[$el . '_submenu_font_size'][$i] . ';font-style:' . $menus_style[$el . '_submenu_font_style'][$i] . ';font-variant:' . $menus_style[$el . '_submenu_font_variant'][$i] . ';font-weight:' . $menus_style[$el . '_submenu_font_weight'][$i] . ';letter-spacing:' . $menus_style[$el . '_submenu_letter_spacing'][$i] . ';line-height:' . $menus_style[$el . '_submenu_line_height'][$i] . ';text-decoration:' . $menus_style[$el . '_submenu_text_decoration'][$i] . ';text-transform:' . $menus_style[$el . '_submenu_text_transform'][$i] . ';}';

					if ( !isset( self::$less_helper['css_menu'] ) ) {
						self::$less_helper['css_menu'] = $css;
					}
					else {
						self::$less_helper['css_menu'] .= $css;
					}

				}

			}

			return $menus;

		}

		public static function less_get_padding( $el, $el_padding ) {

			$padding = explode( ' ', $el_padding );

			if ( is_array( $padding ) ) {
				$padding_count = count( $padding );
				$padding_values = array();

				if ( $padding_count == 1 ) {
					$padding_values = array(
						$el . '_padding_top' => $padding[0],
						$el . '_padding_right' => $padding[0],
						$el . '_padding_bottom' => $padding[0],
						$el . '_padding_left' => $padding[0]
					);
				}
				else if ( $padding_count == 2 ) {
					$padding_values = array(
						$el . '_padding_top' => $padding[0],
						$el . '_padding_right' => $padding[1],
						$el . '_padding_bottom' => $padding[0],
						$el . '_padding_left' => $padding[1]
					);
				}
				else if ( $padding_count == 3 ) {
					$padding_values = array(
						$el . '_padding_top' => $padding[0],
						$el . '_padding_right' => $padding[1],
						$el . '_padding_bottom' => $padding[2],
						$el . '_padding_left' => $padding[1]
					);
				}
				else if ( $padding_count > 3 ){
					$padding_values = array(
						$el . '_padding_top' => $padding[0],
						$el . '_padding_right' => $padding[1],
						$el . '_padding_bottom' => $padding[2],
						$el . '_padding_left' => $padding[3]
					);
				}
			}
			else {
				$padding_values = array(
					$el . '_padding_top' => 'unset',
					$el . '_padding_right' => 'unset',
					$el . '_padding_bottom' => 'unset',
					$el . '_padding_left' => 'unset'
				);
			}

			return $padding_values;

		}

		public static function less_get_background( $el, $section = 'general' ) {

			$background = ShopKit_Ot_Settings::get_settings( $section, $el . '_background' );

			$vars[$el . '_background_color'] = isset( $background['background-color'] ) && $background['background-color'] !== '' ? $background['background-color'] : 'unset';

			if ( !empty( $background['background-image'] ) ) {
				$vars[$el . '_background'] = 'yes';
			}
			else {
				$vars[$el . '_background'] = 'no';
			}

			$vars[$el . '_background_repeat'] = isset( $background['background-repeat'] ) && $background['background-repeat'] !== '' ? $background['background-repeat'] : 'unset';
			$vars[$el . '_background_attachment'] = isset( $background['background-attachment'] ) && $background['background-attachment'] !== '' ? $background['background-attachment'] : 'unset';
			$vars[$el . '_background_position'] = isset( $background['background-position'] ) && $background['background-position'] !== '' ? $background['background-position'] : 'unset';
			$vars[$el . '_background_size'] = isset( $background['background-size'] ) && $background['background-size'] !== '' ? $background['background-size'] : 'unset';
			$vars[$el . '_background_image'] = isset( $background['background-image'] ) && $background['background-image'] !== '' ? '~"' . $background['background-image'] . '"' : 'unset';

			return $vars;

		}

		public static function less_get_colors( $el, $section = 'general' ) {

			$vars[$el . '_link'] = ( $self = ShopKit_Ot_Settings::get_settings( $section, $el . '_link' ) ) !== '' ? $self : 'unset';
			$vars[$el . '_link_hover'] = ( $self = ShopKit_Ot_Settings::get_settings( $section, $el . '_link_hover' ) ) !== '' ? $self : 'unset';
			$vars[$el . '_separator'] = ( $self = ShopKit_Ot_Settings::get_settings( $section, $el . '_separator' ) ) !== '' ? $self : 'unset';

			return $vars;

		}

		public static function less_get_fonts( $el, $section = 'general' ) {

			$font = ShopKit_Ot_Settings::get_settings( $section, $el . '_font' );

			if ( isset( $font['font-family'] ) ) {
				$type = substr( $font['font-family'], 0, 3 );

				if ( in_array( $type, array( 'inc', 'ggl' ) ) ) {
					if ( !isset( self::$less_helper[$type . '_fonts'][$font['font-family']] ) ) {
						self::$less_helper[$type . '_fonts'][$font['font-family']]['slug'] = substr( $font['font-family'], 4 );
						self::$less_helper[$type . '_fonts'][$font['font-family']]['name'] = self::$less_helper['fonts'][$font['font-family']];
					}
				}
			}

			$vars[$el . '_font_family'] = isset( $font['font-family'] ) && $font['font-family'] !== '' ? self::$less_helper['fonts'][$font['font-family']] : 'unset';
			$vars[$el . '_font_color'] = isset( $font['font-color'] ) && $font['font-color'] !== '' ? $font['font-color'] : 'unset';
			$vars[$el . '_font_size'] = isset( $font['font-size'] ) && $font['font-size'] !== '' ? $font['font-size'] : 'unset';
			$vars[$el . '_font_style'] = isset( $font['font-style'] ) && $font['font-style'] !== '' ? $font['font-style'] : 'unset';
			$vars[$el . '_font_variant'] = isset( $font['font-variant'] ) && $font['font-variant'] !== '' ? $font['font-variant'] : 'unset';
			$vars[$el . '_font_weight'] = isset( $font['font-weight'] ) && $font['font-weight'] !== '' ? $font['font-weight'] : 'unset';
			$vars[$el . '_letter_spacing'] = isset( $font['letter-spacing'] ) && $font['letter-spacing'] !== '' ? $font['letter-spacing'] : 'unset';
			$vars[$el . '_line_height'] = isset( $font['line-height'] ) && $font['line-height'] !== '' ? $font['line-height'] : 'unset';
			$vars[$el . '_text_decoration'] = isset( $font['text-decoration'] ) && $font['text-decoration'] !== '' ? $font['text-decoration'] : 'unset';
			$vars[$el . '_text_transform'] = isset( $font['text-transform'] ) && $font['text-transform'] !== '' ? $font['text-transform'] : 'unset';

			return $vars;

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


	}

	add_action( 'init', array( 'ShopKit_Settings', 'init' ), 1 );



?>