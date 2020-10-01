<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	class ShopKit {

		public static $settings;

		public static function init() {
			$class = __CLASS__;
			new $class;
		}

		function __construct() {

			add_action( 'init', __CLASS__ . '::register_session' );

			add_filter( 'wp_enqueue_scripts', __CLASS__ . '::load_google_fonts' );

			add_action( 'wp_enqueue_scripts', __CLASS__ . '::add_scripts' );

			add_action( 'wp_ajax_nopriv_shopkit_section_session', __CLASS__ . '::shopkit_section_session' );
			add_action( 'wp_ajax_shopkit_section_session', __CLASS__ . '::shopkit_section_session' );

			add_action( 'wp_enqueue_scripts', __CLASS__ . '::get_scripts' );
			add_action( 'wp_footer', __CLASS__ . '::localize_scripts' );

			add_action( 'shopkit_head', __CLASS__ . '::get_head', 5 );
			add_action( 'shopkit_head', __CLASS__ . '::get_favorites_icons', 10 );
			//add_action( 'shopkit_head', __CLASS__ . '::get_seo', 15 );

			add_action( 'body_class', __CLASS__ . '::get_bodyclass', 5 );

			add_action( 'shopkit_header', __CLASS__ . '::get_header_start', 5 );

			self::$settings['header_sections'] = array_values( ShopKit_Ot_Settings::get_settings( 'general', 'header_elements', array() ) );

			$action_priority = 10;

			foreach( self::$settings['header_sections'] as $curr ) {

				add_action( 'shopkit_header', __CLASS__ . '::get_section', $action_priority );

				$action_priority = $action_priority + 10;

			}

			add_action( 'shopkit_header', __CLASS__ . '::get_header_end', 9995 );

			add_action( 'shopkit_header', __CLASS__ . '::get_content_start', 10000);

			add_action( 'shopkit_sidebar_left', __CLASS__ . '::get_sidebar_left', 100 );
			add_action( 'shopkit_sidebar_right', __CLASS__ . '::get_sidebar_right', 100 );

			add_action( 'shopkit_footer', __CLASS__ . '::get_content_end', 0 );

			add_action( 'shopkit_footer', __CLASS__ . '::get_footer_start', 5 );

			self::$settings['footer_sections'] = array_values(  ShopKit_Ot_Settings::get_settings( 'general', 'footer_elements', array() ) );

			$action_priority = 10;

			foreach( self::$settings['footer_sections'] as $curr ) {

				add_action( 'shopkit_footer', __CLASS__ . '::get_section', $action_priority );

				$action_priority = $action_priority + 10;

			}

			add_action( 'shopkit_footer', __CLASS__ . '::get_footer_end', 9995 );

			add_action( 'init', __CLASS__ . '::login_member', 1002 );
			add_action( 'init', __CLASS__ . '::add_new_member', 1002 );

			if ( is_user_logged_in() ) {
				self::$settings['user'] = wp_get_current_user();
			}

			add_filter( 'nav_menu_css_class', __CLASS__ . '::shopkit_menu_style', 10, 4 );
			add_filter( 'walker_nav_menu_start_el', __CLASS__ . '::shopkit_menu_background', 10, 4 );

			add_filter( 'the_password_form', __CLASS__ . '::replace_pwd_form' );

			add_action( 'shopkit_head', __CLASS__ . '::setup_page', 1 );
			add_action( 'shopkit_head', __CLASS__ . '::setup_post', 1 );
			add_action( 'shopkit_head', __CLASS__ . '::setup_archive', 1 );

			add_filter( 'breadcrumb_trail_args', __CLASS__ . '::breadcrumb_args', 10 );

			add_filter( 'mnthemes_add_meta_information_used', __CLASS__ . '::shopkit_info', 0 );

		}

		public static function shopkit_info( $val ) {
			$val = array_merge( $val, array( 'ShopKit Theme for WooCommerce' ) );
			return $val;
		}

		public static function register_session() {

			if( !session_id() ) {
				session_start();
			}

		}

		public static function localize_scripts() {

			if ( wp_script_is( 'shopkit-load', 'enqueued' ) ) {
				global $woocommerce;

				$vars = apply_filters( 'shopkit_javascript', array(
					'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'siteurl'=> esc_url( home_url( '/' ) ),
					'locale' => array(
						'ajax_error' => esc_html__( 'AJAX Error!', 'shopkit' ),
						'checkout' => class_exists( 'WooCommerce' ) ? '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button go_to_chekout" title="' . esc_html__( 'Go to Checkout', 'shopkit' ) . '">' . esc_html__( 'Go to Checkout', 'shopkit' ) . '</a>' : ''
					),
					'options' => array(
						'rtl' => is_rtl(),
						'sticky_header' => ShopKit_Ot_Settings::get_settings( 'general', 'sticky_header' ),
						'sticky_top' => ShopKit_Ot_Settings::get_settings( 'general', 'sticky_top' ),
						'sticky_anim' => ShopKit_Ot_Settings::get_settings( 'general', 'sticky_anim' )
					)
				) );

				if ( isset( self::$settings['collapsibles'] ) ) {
					$vars['collapsibles'] = self::$settings['collapsibles'];
				}

				wp_localize_script( 'shopkit-load', 'shopkit', $vars );
			}
		}

		public static function add_scripts() {

			wp_register_script( 'shopkit-load', WcSk()->template_url() . '/framework/js/scripts.js', array( 'jquery', 'wp-util' ), WcSk()->version() . uniqid(), true );

			wp_enqueue_script( 'shopkit-load' );

			if ( is_singular() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			if ( function_exists( 'wp_script_add_data' ) ) {
				wp_register_script( 'shopkit-ltie9', WcSk()->template_url() . '/framework/js/html5.js', array( 'jquery' ), WcSk()->version(), false );
				wp_enqueue_script( 'shopkit-ltie9' );
				wp_script_add_data( 'shopkit-ltie9', 'conditional', 'lt IE 9' );
			}

		}

		public static function load_google_fonts() {
			$fonts = get_transient( '_shopkit_google_fonts' );

			if ( empty( $fonts ) ) {
				return;
			}

			$protocol = is_ssl() ? 'https' : 'http';

			$i = 0;
			foreach ( array_unique( $fonts, SORT_REGULAR ) as $k => $v ) {
				$i++;

				$slug = str_replace( ' ', '+', ucwords( str_replace( '-', ' ', $v['slug'] ) ) );

				wp_enqueue_style( 'shopkit-font-' . $i, $protocol . '://fonts.googleapis.com/css?family=' . $slug . '%3A100%2C200%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C700%2C700italic%2C800&amp;subset=all' );
			}
		}

		public static function get_scripts() {

			$settings = apply_filters( 'shopkit_less_styles', get_option( '_shopkit_less_styles', array() ) );
			$theme = ShopKit_Ot_Settings::$mode;

			if ( !empty( $settings ) && is_array( $settings ) && isset( $settings[$theme]) ) {

				$upload = wp_upload_dir();

				$style = untrailingslashit( $upload['basedir'] ) . '/shopkit-' . $settings[$theme]['id'] . '.css';

				if ( file_exists( $style ) ) {
					$url = untrailingslashit( $upload['baseurl'] ) . '/shopkit-' . $settings[$theme]['id'] . '.css';
					wp_register_style( 'shopkit-' . $settings[$theme]['id'], $url, false, $settings[$theme]['id'] );
					wp_enqueue_style( 'shopkit-' . $settings[$theme]['id'] );

				}
				else if ( $settings[$theme]['last_known'] !== '' ) {

					$style_cached = untrailingslashit( $upload['basedir'] ) . '/shopkit-' . $settings[$theme]['last_known'] . '.css';
					$style_cached_url = untrailingslashit( $upload['baseurl'] ) . '/shopkit-' . $settings[$theme]['last_known'] . '.css';

					if ( file_exists( $style_cached ) ) {
						wp_register_style( 'shopkit-' . $settings[$theme]['last_known'], $style_cached_url, false, $settings[$theme]['last_known'] );
						wp_enqueue_style( 'shopkit-' . $style_cached_url );
					}
					else {
						$url = '/demos/precompiled-material.css';
						wp_register_style( 'shopkit-precompiled', WcSk()->template_url() . $url, false, WcSk()->version() );
						wp_enqueue_style( 'shopkit-precompiled' );
					}

				}


			}
			else {
				if ( is_child_theme() ) {
					switch ( basename( get_stylesheet_directory() ) ) {
						case 'shopkit-child-material' :
							$url = '/demos/precompiled-material.css';
						break;
						case 'shopkit-child-flat' :
							$url = '/demos/precompiled-flat.css';
						break;
						case 'shopkit-child-creative' :
							$url = '/demos/precompiled-creative.css';
						break;
						default :
							$url = '/demos/precompiled-material.css';
						break;
					}
				}
				else {
					$url = '/demos/precompiled-material.css';
				}

				wp_register_style( 'shopkit-precompiled', WcSk()->template_url() . $url, false, WcSk()->version() );
				wp_enqueue_style( 'shopkit-precompiled' );
			}

			wp_enqueue_style( 'shopkit', get_stylesheet_uri() );
		}


		public static function get_header_start() {
?>
		<header id="header" class="shopkit-header" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
<?php
		}

		public static function get_header_end() {
?>
		</header>
<?php
		}

		public static function get_content_start() {
?>
		<main id="main" class="shopkit-main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/WebPageElement">
			<?php do_action( 'shopkit_before_content' ); ?>
			<div id="main_content" class="shopkit-main-content">
				<?php
					$template = get_page_template_slug();
					if ( $template === false || !in_array( $template, array( 'page-templates/es-fullwidth-transparent-header.php', 'page-templates/es-fullwidth.php' ) ) ) {
				?>
				<div class="shopkit-inner-wrapper">
				<?php
					}
					do_action( 'shopkit_sidebar_left' );
				?>
			
					<section id="content" class="shopkit-content">
<?php
		}

		public static function get_content_end() {
?>
					</section>
<?php
					do_action( 'shopkit_sidebar_right' );
?>
					<div class="shopkit-clear"></div>
				<?php
					$template = get_page_template_slug();
					if ( $template === false || !in_array( $template, array( 'page-templates/es-fullwidth-transparent-header.php', 'page-templates/es-fullwidth.php' ) ) ) {
				?>
				</div>
				<?php } ?>
			</div>
			<?php do_action( 'shopkit_after_content' ); ?>
		</main>
<?php
		}

		public static function get_footer_start() {
?>
		<footer id="footer" class="shopkit-footer" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
<?php
		}

		public static function get_footer_end() {
?>
		</footer>
<?php
		}

		public static function get_sidebar_right() {

			get_sidebar( 'right' );

		}
		public static function get_sidebar_left() {

			get_sidebar( 'left' );

		}

		public static function get_head() {
?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
		}

		public static function get_favorites_icons() {

			if ( ( $icon = ShopKit_Ot_Settings::get_settings( 'general', 'favorites_icon' ) ) !== '' ) {
?>
<link id="br0frmd_favicon" rel="shortcut icon" href="<?php echo esc_url( $icon ); ?>" type='image/x-icon'>
<?php
			}

			if ( ( $icon = ShopKit_Ot_Settings::get_settings( 'general', 'favorites_ipad57' ) ) !== '' ) {
?>
<link id="br0frmd_favicon" rel="shortcut icon" href="<?php echo esc_url( $icon ); ?>" type='image/x-icon'>
<?php
			}

			if ( ( $icon = ShopKit_Ot_Settings::get_settings( 'general', 'favorites_ipad72' ) ) !== '' ) {
?>
<link id="br0frmd_favicon" rel="shortcut icon" href="<?php echo esc_url( $icon ); ?>" type='image/x-icon'>
<?php
			}

			if ( ( $icon = ShopKit_Ot_Settings::get_settings( 'general', 'favorites_ipad114' ) ) !== '' ) {
?>
<link id="br0frmd_favicon" rel="shortcut icon" href="<?php echo esc_url( $icon ); ?>" type='image/x-icon'>
<?php
			}

			if ( ( $icon = ShopKit_Ot_Settings::get_settings( 'general', 'favorites_ipad144' ) ) !== '' ) {
?>
<link id="br0frmd_favicon" rel="shortcut icon" href="<?php echo esc_url( $icon ); ?>" type='image/x-icon'>
<?php
			}

		}

		public static function get_seo() {

			$protocol = is_ssl() ? 'https' : 'http';

			$publisher = esc_attr( ShopKit_Ot_Settings::get_settings( 'general', 'seo_publisher' ) );

			$curr_id = get_the_ID();
			$seo = array(
				'og' => array(
					'type' => 'article',
					'sitename' => get_bloginfo('name'),
					'url' => esc_url( get_permalink( $curr_id ) ),
					'updated_time' => get_the_modified_date('Y-m-dTH:i:sO')
				),
				'article' => array(
					'published_time' => get_the_time('Y-m-dTH:i:sO'),
					'modified_time' => get_the_modified_date('Y-m-dTH:i:sO')
				)
			);

			$curr_author = esc_attr( $publisher );

			if ( is_home() || is_front_page() ) {
				$seo['og']['title'] = get_bloginfo( 'title' );
				$seo['og']['description'] = get_bloginfo( 'description' );
			}
			else if ( is_page() ) {

				$seo['og']['title'] = get_the_title($curr_id);
				$seo['og']['description'] = '';

			}
			else if ( is_single() ) {

				$curr_author = get_the_author_meta( 'bbox_gplus', intval( get_post_field( 'post_author', get_queried_object_id() ) ) );
				$seo['og']['title'] = get_the_title($curr_id);

				$seo['og']['description'] = '';

			}
			else if ( is_category() ) {

				$seo['og']['title'] = get_the_title();
				$seo['og']['description'] = get_category(get_query_var('cat'))->name;

			}
			else if ( is_archive() || is_search() || is_404() || is_front_page() || is_home() ) {

				$seo['og']['title'] = get_the_title();
				$seo['og']['description'] = get_bloginfo('description');

			}
			else {

				$seo['og']['title'] = get_bloginfo('title');
				$seo['og']['description'] = get_bloginfo('description');

			}

			if ( $curr_author !== '' ) {
				echo "<link rel='author' href='{$protocol}://plus.google.com/{$curr_author}/posts'/>\n";
			}
			if ( $publisher !== '' ) {
				echo "<link rel='publisher' href='{$protocol}://plus.google.com/{$publisher}/posts'/>\n";
			}

			foreach ( $seo as $key => $meta ) {
				foreach ( $meta as $k => $m ) {
					$m = esc_attr( htmlentities( $m ) );
					echo "<meta property='{$key}:{$k}' content='$m' />\n";
				}
			}

			$fb_publisher = esc_attr( ShopKit_Ot_Settings::get_settings( 'general', 'fb_publisher' ) );

			if ( $curr_author !== '' ) {
				echo "<meta property='article:author' content='https://www.facebook.com/{$curr_author}' />";
			}

			if ( $fb_publisher !== '' ) {
				echo "<meta property='article:publisher' content='https://www.facebook.com/{$fb_publisher}' />";
			}

			if ( is_single( 'post' ) ) {

				$article_tags = get_the_tags(get_the_ID());

				if ( is_array( $article_tags ) ) {
					foreach ( $article_tags as $article_tag ) {
						$curr_tag = esc_attr( $article_tag->name );
						echo "<meta property='article:tag' content='{$curr_tag}' />\n";
					}
				}

				$article_section = get_the_category( get_the_ID() );
				
				if ( isset( $article_section[0]->cat_name ) ) {
					$curr_section = esc_attr( $article_section[0]->cat_name );
					echo "<meta property='article:section' content='{$curr_section}' />\n";
				}

			}

			echo "<meta name='ROBOTS' content='NOODP'>\n";

		}


		public static function get_section() {

			global $shopkit_global, $wp_current_filter;

			$filter = in_array( 'shopkit_header', $wp_current_filter ) ? 'header' : 'footer' ;

			if ( $filter == 'header' ) {
				if ( !isset( $shopkit_global['header_elements'] ) || $shopkit_global == '' ) {
					$shopkit_global['header_elements'] = 0;
				}
				else {
					$shopkit_global['header_elements']++;
				}
				$curr_id = $shopkit_global['header_elements'];

				$curr_section_slug = sanitize_title( self::$settings['header_sections'][$curr_id]['title'] );
				$curr_section = str_replace( '-', '_', $curr_section_slug );
				$type = self::$settings['header_sections'][$curr_id]['select_element'];
				$width = self::$settings['header_sections'][$curr_id]['fullwidth'];
			}
			else if ( $filter == 'footer' ) {
				if ( !isset( $shopkit_global['footer_elements'] ) || $shopkit_global == '' ) {
					$shopkit_global['footer_elements'] = 0;
				}
				else {
					$shopkit_global['footer_elements']++;
				}
				$curr_id = $shopkit_global['footer_elements'];

				$curr_section_slug = sanitize_title( self::$settings['footer_sections'][$curr_id]['title'] );
				$curr_section = str_replace( '-', '_', $curr_section_slug );
				$type = self::$settings['footer_sections'][$curr_id]['select_element'];
				$width = self::$settings['footer_sections'][$curr_id]['fullwidth'];
			}

			if ( ( $condition = ShopKit_Ot_Settings::get_settings( $curr_section, $curr_section . '_condition' ) ) !== '' ) {
				$condition_result = self::get_condition( $condition );

				if ( isset( $condition_result ) && $condition_result !== true ) {
					return;
				}
			}

			do_action( 'shopkit_' . $curr_section . '_init' );

			$collapsible = ShopKit_Ot_Settings::get_settings( $curr_section, $curr_section . '_type' );

			$visibility = self::check_section_session( $curr_section, $collapsible );

			if ( $collapsible == 'collapsible-with-dismiss' ) {
				if ( isset( $visibility ) && $visibility == 'notshown' ) {
					return false;
				}
			}

			$add_visibility = isset( $visibility ) && $visibility == 'notshown' ? ' shopkit-notvisible' : '';

			$add_width = $width == 'on' ? ' shopkit-fullwidth-section' : '';

			switch( $type ) :

			case 'elements-bar' :

				$curr_left = ShopKit_Ot_Settings::get_settings( $curr_section, $curr_section . '_elements_on_left' );
				$curr_right = ShopKit_Ot_Settings::get_settings( $curr_section, $curr_section . '_elements_on_right' );

				if ( empty( $curr_left ) && empty( $curr_right ) ) {
					return;
				}
?>
	<div id="<?php echo esc_attr( $curr_section ); ?>_section" class="<?php echo esc_attr( self::get_classes( 'shopkit-elements-bar shopkit-elements-bar-' . $curr_section_slug . ' shopkit-' . $collapsible . $add_visibility . $add_width, $curr_section ) ); ?>">
<?php
		if ( $filter == 'footer' ) {
			self::get_section_type( $curr_section, $curr_section_slug, $collapsible );
		}
?>
		<div class="shopkit-element-wrapper shopkit-inner-wrapper">
<?php
		if ( !empty( $curr_left ) ) {
?>
		<div class="shopkit-section shopkit-section-left">
<?php
			foreach( $curr_left as $curr ) {
				self::get_layout_element( $curr );
			}
?>
		</div>
<?php
		}
		if ( !empty( $curr_right ) ) {
?>
		<div class="shopkit-section shopkit-section-right">
<?php
			foreach( $curr_right as $curr ) {
				self::get_layout_element( $curr );
			}
?>
		</div>
<?php
		}
?>
		</div>
<?php
		if ( $filter == 'header' ) {
			self::get_section_type( $curr_section, $curr_section_slug, $collapsible );
		}
?>
	</div>
<?php

			break;

			case 'widget-section' :

			$n=0;
			$rows = array_values( ShopKit_Ot_Settings::get_settings( $curr_section, $curr_section . '_rows' ) );
?>
	<div id="<?php echo esc_attr( $curr_section ); ?>_section" class="<?php echo esc_attr( self::get_classes( 'shopkit-widgets shopkit-widgets-' . $curr_section_slug . ' shopkit-' . $collapsible . $add_visibility . $add_width, $curr_section ) ); ?>">
<?php
		if ( $filter == 'footer' ) {
			self::get_section_type( $curr_section, $curr_section_slug, $collapsible );
		}
?>
		<div class="shopkit-inner-wrapper">
<?php
			foreach ( $rows as $row ) {

				$layout_mode = $row['select_element'];
				$visibility = isset( $settings['element_visibility'] ) ? $settings['element_visibility'] : array();
?>
				<div class="<?php echo self::get_element_classes( 'shopkit-columns shopkit-clear shopkit-' . $layout_mode, $visibility ); ?>">
<?php
					$widget_areas = intval( substr( $layout_mode, -1 ) );

					for ( $i = 1; $i <= $widget_areas; $i++ ) {
						$n++;
						$sidebar_class = $curr_section . '-widget-area-' . $n;
						$sidebar_id = str_replace( '_', '-', $curr_section ) . '-' . ( $n > 9 ? '_' : '' ) . $n;
?>
					<div id="<?php echo esc_attr( $sidebar_class ); ?>" class="shopkit-column shopkit-widget-column-<?php echo absint( $i ); ?>">
					<?php
						if ( is_active_sidebar( $sidebar_id ) ) {
							dynamic_sidebar( $sidebar_id );
						}
						else {
							if ( current_user_can( 'administrator' ) ) {
								printf( $row['title'] . '-' . $i . ' ' . esc_html__( 'Sidebar is empty! To add content here check your %1$sWidgets Section%2$s', 'shopkit' ), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>' );
							}
						}
					?>
					</div>
<?php
				}
?>
				</div>
<?php
			}
?>
		</div>
<?php
		if ( $filter == 'header' ) {
			self::get_section_type( $curr_section, $curr_section_slug, $collapsible );
		}
?>
	</div>
<?php
			break;

			case 'content-text-html' :

?>
	<div id="<?php echo esc_attr( $curr_section ); ?>_section" class="<?php echo esc_attr( self::get_classes( 'shopkit-content-text-html shopkit-content-text-html-' . $curr_section_slug . ' shopkit-' . $collapsible . $add_visibility . $add_width, $curr_section ) ); ?>">
<?php
		if ( $filter == 'footer' ) {
			self::get_section_type( $curr_section, $curr_section_slug, $collapsible );
		}
?>
		<div class="shopkit-inner-wrapper">
<?php
			echo do_shortcode( wp_kses_post( ShopKit_Ot_Settings::get_settings( $curr_section, $curr_section . '_content' ) ) );
?>
		</div>
<?php
		if ( $filter == 'header' ) {
			self::get_section_type( $curr_section, $curr_section_slug, $collapsible );
		}
?>
	</div>
<?php

			break;

			default :
			break;

			endswitch;

		}

		public static function get_footer() {

		}

		public static function get_layout_element( $settings ) {

			$type = esc_attr( $settings['select_element'] );
			$visibility = isset( $settings['element_visibility'] ) ? $settings['element_visibility'] : array();
			$class = isset( $settings['class'] ) ? esc_attr( $settings['class'] ) : '';

			if ( !class_exists( 'WooCommerce' ) && in_array( $type, array( 'woo-cart' ) ) ) {
				return;
			}

			if ( in_array( $type, array( 'separator', 'break' ) ) ) {
?>
			<div class="<?php echo self::get_element_classes( 'shopkit-layout-element shopkit-layout-element-' . $type . ' ' . $class, $visibility ); ?><?php echo in_array( $type, array( 'separator' ) ) ? ' ' . esc_attr( $settings['height'] ) : ''; ?>"></div>
<?php
				return;
			}

?>
			<div class="<?php echo self::get_element_classes( 'shopkit-layout-element shopkit-layout-element-' . $type . ' ' . $class, $visibility ); ?><?php echo in_array( $type, array( 'search', 'menu', 'woo-cart', 'social-network', 'woo-search', 'image-link', 'login', 'login-registration', 'registration' ) ) ? ' ' . esc_attr( $settings['height'] ) : ''; ?>">
<?php
			switch( $type ) {

				case 'logo' :

				$logo_image_link = ShopKit_Ot_Settings::get_settings( 'general', 'logo_image_link' );
?>
				<figure class="shopkit-logo">
					<a href="<?php echo ( $logo_image_link == '' ? esc_url( home_url( '/' ) ) : esc_url( $logo_image_link ) ); ?>" title="<?php echo esc_attr( get_bloginfo('description') ); ?>">
						<img class="<?php echo esc_attr( $settings['height'] ); ?>" src="<?php echo esc_url( ShopKit_Ot_Settings::get_settings( 'general', 'logo_image' ) ); ?>" alt="<?php bloginfo('name'); ?>" itemprop="image" />
					</a>
				</figure>
<?php
				break;

				case 'trigger' :
?>
					<div class='shopkit-section-collapsible'>
						<span class='shopkit-section-trigger-wrapper shopkit-<?php echo esc_attr( $settings['trigger'] ); ?>-trigger shopkit-active'>
							<span class='shopkit-section-trigger'></span>
						</span>
					</div>
<?php
				break;

				case 'text' :
					echo do_shortcode( wp_kses_post( $settings['text'] ) );
				break;

				case 'site-title' :

				if ( is_front_page() && !is_home() ) {
?>
				<div class="shopkit-site-title">
					<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo('description') ); ?>" itemprop="name"><?php echo apply_filters( 'shopkit_bloginfo_name', esc_html( get_bloginfo( 'name' ) ) ); ?></a></h1>
					<h3 itemprop="description"><?php echo apply_filters( 'shopkit_bloginfo_description', esc_html( get_bloginfo('description') ) ); ?></h3>
				</div>
<?php
				}
				else {
?>
				<div class="shopkit-site-title">
					<h2><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo('description') ); ?>" itemprop="name"><?php echo apply_filters( 'shopkit_bloginfo_name', esc_html( get_bloginfo('name') ) ); ?></a></h2>
					<h3 itemprop="description"><?php echo apply_filters( 'shopkit_bloginfo_description', esc_html( get_bloginfo('description') ) ); ?></h3>
				</div>
<?php
				}

				break;

				case 'site-name' :

				if ( is_front_page() && !is_home() ) {
?>
				<div class="shopkit-site-title">
					<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo('description') ); ?>" itemprop="name"><?php echo apply_filters( 'shopkit_bloginfo_name', esc_html( get_bloginfo('name') ) ); ?></a></h1>
				</div>
<?php
				}
				else {
?>
				<div class="shopkit-site-title">
					<h2><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo('description') ); ?>" itemprop="name"><?php echo apply_filters( 'shopkit_bloginfo_name', esc_html( get_bloginfo('name') ) ); ?></a></h2>
				</div>
<?php
				}

				break;

				case 'site-desc' :

				if ( is_front_page() && !is_home() ) {
?>
				<div class="shopkit-site-title">
					<h3 itemprop="description"><?php echo apply_filters( 'shopkit_bloginfo_description', esc_html( get_bloginfo('description') ) ); ?></h3>
				</div>
<?php
				}
				else {
?>
				<div class="shopkit-site-title">
					<h3 itemprop="description"><?php echo apply_filters( 'shopkit_bloginfo_description', esc_html( get_bloginfo('description') ) ); ?></h3>
				</div>
<?php
				}

				break;

				case 'menu':
				if ( $settings['menu'] !== 'none' ) {
?>
				<nav class="shopkit-menu <?php echo esc_attr( $settings['menu_style'] ); ?>" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
					<?php
						wp_nav_menu( array( 'menu' => $settings['menu'], 'container' => false, 'fallback_cb' => 'ShopKit::wp_page_menu' ) );
						self::get_mobile_menu( $settings['menu'], $settings['icon'] );
					?>
				</nav>
<?php
				}
				else {
?>
				<nav class="shopkit-menu <?php echo esc_attr( $settings['menu_style'] ); ?>" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
					<?php
						ShopKit::wp_page_menu();
					?>
				</nav>
<?php
				}
				break;

				case 'breadcrumbs' :

				shopkit_breadcrumb_trail(
					array(
						'container' => 'nav',
						'labels'    => array(
							'browse' => ''
						)
					)
				);

				break;

				case 'search' :

				self::$settings['search-icon'] = esc_attr( $settings['icon'] );
?>
				<div class="shopkit-search-wrapper <?php echo esc_attr( $settings['height'] ); ?>">
					<div class="shopkit-search-form-wrapper">
						<?php get_search_form(); ?>
					</div>
				</div>
<?php
				unset( self::$settings['search-icon'] );

				break;

				case 'woo-search' :

				self::$settings['woo-search'] = true;
				self::$settings['search-icon'] = esc_attr( $settings['icon'] );
?>
				<div class="shopkit-search-wrapper <?php echo esc_attr( $settings['height'] ); ?>">
					<div class="shopkit-search-form-wrapper">
						<?php get_search_form(); ?>
					</div>
				</div>
<?php
				unset( self::$settings['woo-search'] );
				unset( self::$settings['search-icon'] );

				break;

				case 'woo-cart' :

				self::$settings['woo-cart-icon'] = esc_attr( $settings['woo_cart_icon'] );
				ShopKit_WooCommerce::get_cart_element();
				unset( self::$settings['woo-cart-icon'] );

				break;


				case 'social-network' :

?>
				<a href="<?php echo esc_url( $settings['url'] ); ?>" target="_blank">
<?php
					echo ShopKit_Icons::get_icon( 'line-icon', esc_attr( $settings['social_network'] ) );
?>
				</a>
<?php

				break;

				case 'image-link' :

				if ( $settings['url'] !== '' ) {
?>
				<a href="<?php echo esc_url( $settings['url'] ); ?>">
<?php
				}
				if ( $settings['image'] !== '' ) {
					$class = substr( $settings['image'], -3 ) == 'svg' ? ' shopkit-svg' : '' ;
?>
				<img src="<?php echo esc_url( $settings['image'] ); ?>" class="shopkit-image<?php echo esc_attr( $class ); ?>" alt="<?php echo esc_html__( 'UI Image', 'shopkit' ); ?>" />
<?php
				}
				if ( $settings['image_hover'] !== '' ) {
					$class = substr( $settings['image'], -3 ) == 'svg' ? ' shopkit-svg' : '' ;
?>
				<img src="<?php echo esc_url( $settings['image_hover'] ); ?>" class="shopkit-image-hover<?php echo esc_attr( $class ); ?>" alt="<?php echo esc_html__( 'UI Image', 'shopkit' ); ?>" />
<?php
				}
				if ( $settings['url'] !== '' ) {
?>
				</a>
<?php
				}

				break;

				case 'login-registration' :
				case 'registration' :
				case 'login' :

					$link = class_exists( 'WooCommerce' ) ? esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) : esc_url( home_url( '/' ) );
					$icon_type = in_array( $settings['icon'], array( 'text', 'button' ) ) ? $settings['icon'] : 'icon';

					if( !is_user_logged_in() ) {

						$errors = self::show_registration_error_messages();

						$string = '';

						if ( $icon_type == 'icon' ) {
							$string .= ShopKit_Icons::get_icon( $settings['icon'], 'login' );
						}

						if ( $errors === false ) {
							$class = '';
							switch ( $type ) {
								case 'registration' :
									$reg_string = esc_html__( 'Register', 'shopkit' );
								break;
								case 'login' :
									$reg_string = esc_html__( 'Log in', 'shopkit' );
								break;
								default :
									$reg_string = esc_html__( 'Log in / Register', 'shopkit' );
								break;
							}
						}
						else {
							switch ( $type ) {
								case 'registration' :
									$reg_string = esc_html__( 'Registration invalid!', 'shopkit' );
								break;
								case 'login' :
									$reg_string = esc_html__( 'Invalid login!', 'shopkit' );
								break;
								default :
									$reg_string = esc_html__( 'Log in / Registration invalid!', 'shopkit' );
								break;
							}
							$class = ' shopkit-has-errors';
						}

						$string .= '<span>' . $reg_string . '</span>';

						echo '<a href="' . $link . '" class="shopkit-login-icon' . $class . ' ' . $icon_type . '">' . $string . '</a>';

?>
						<div class="shopkit-login shopkit-not-active">
							<div class="shopkit-login-items-wrapper">
<?php
							if ( strpos( $type, 'login' ) !== false ) {
								echo self::login_form();
							}
							if ( strpos( $type, 'registration' ) !== false ) {
								echo self::registration_form();
							}
							
							echo wp_kses_post( $errors );
?>
						</div>
						<a href="javascript:void(0)" class="shopkit-login-close"><span class="shopkit-login-close-button"><?php esc_html_e( 'Click to close the login form!', 'shopkit' ); ?></span></a>
					</div>
<?php
					}
					else {

						$user = self::$settings['user'];

						if ( $icon_type == 'icon' ) {
							echo '<a href="' . esc_url( $link ) . '" class="' . esc_attr( $icon_type ) . '">' . ShopKit_Icons::get_icon( $settings['icon'], 'login' ) . ' <span>' . esc_html( $user->display_name ) . '</span></a> <span>/</span> ' . '<a href="' . esc_url( wp_logout_url( home_url() ) ) . '" class="' . esc_attr( $icon_type ) . '">' . esc_html__( 'Logout', 'shopkit' ) . '</a>';
						}
						else {
							echo '<a href="' . esc_url( $link ) . '" class="' . esc_attr( $icon_type ) . '">' . esc_html( $user->display_name ) . '</a> <span>/</span> <a href="' . esc_url( wp_logout_url( home_url() ) ) . '" class="' . esc_attr( $icon_type ) . '">' . esc_html__( 'Logout', 'shopkit' ) . '</a>';
						}

						
					}

				break;

				default :
				break;

			}
?>
			</div>
<?php
		}

		public static function get_bodyclass( $curr_classes ) {

			$curr_classes[] = 'shopkit';
			$curr_classes[] = ShopKit_Ot_Settings::get_settings( 'general', 'wrapper_mode' );

			$sidebars = array_values( ShopKit_Ot_Settings::get_settings( 'general', 'sidebars', array() ) );
			$sidebar_override = '';
			if ( is_singular() ) {
				$sidebar_override = get_post_meta( get_the_ID(), '_shopkit_sidebar_layout', true );
			}

			if ( !empty( $sidebars ) || $sidebar_override !== '' ) {

				if ( is_404() ) {
					$curr_classes[] = 'shopkit-cl-no-sidebars';
					self::$settings['sidebar_layout'] = array(
						'title' => 'No Sidebars',
						'left_sidebar_1' => 'off',
						'left_sidebar_2' => 'off',
						'right_sidebar_1' => 'off',
						'right_sidebar_2' => 'off'
					);
				}

				if ( is_singular() ) {

					if ( $sidebar_override !== '' && $sidebar_override !== 'default' ) {
						if ( $sidebar_override == 'none' ) {
							$curr_classes[] = 'shopkit-cl-no-sidebars';
							self::$settings['sidebar_layout'] = array(
								'title' => 'No Sidebars',
								'left_sidebar_1' => 'off',
								'left_sidebar_2' => 'off',
								'right_sidebar_1' => 'off',
								'right_sidebar_2' => 'off'
							);
						}
						else {
							foreach( $sidebars as $k => $v ) {
								if ( $sidebar_override == $k ) {
									$id = 'shopkit-cl-' . sanitize_title( $v['title'] );
									$curr_classes[] = $id;
									self::$settings['sidebar_layout'] = $v;
									break;
								}
							}
						}
					}
				}

				if ( !isset( self::$settings['sidebar_layout'] ) ) {
					foreach( $sidebars as $k => $v ) {

						if ( $v['display_condition'] !== '' ) {

							$condition_result = self::get_condition( $v['display_condition'] );

							if ( $condition_result === true ) {
								$sidebar_layout = sanitize_title( $v['title'] );
								$curr_classes[] = 'shopkit-cl-' . $sidebar_layout;
								self::$settings['sidebar_layout'] = $v;
								break;
							}

						}

					}
				}

			}

			return $curr_classes;

		}

		public static function get_classes( $classes, $el ) {

			$responsive_visibility = ShopKit_Ot_Settings::get_settings( $el, $el . '_visibility' );

			if ( !empty( $responsive_visibility ) && is_array( $responsive_visibility ) ) {
				$classes = $classes . ' ' . implode( ' ', $responsive_visibility );
			}

			$elements_align = ShopKit_Ot_Settings::get_settings( $el, $el . '_elements_align' );

			if ( $elements_align !== '' ) {
				$classes = $classes . ' ' . $elements_align;
			}

			return $classes;
		}

		public static function get_element_classes( $classes, $responsive_visibility ) {

			if ( !empty( $responsive_visibility ) && is_array( $responsive_visibility ) ) {
				$curr_classes = $classes . ' ' . implode( ' ', $responsive_visibility );
			}
			else {
				$curr_classes = $classes;
			}

			return $curr_classes;

		}

		public static function shopkit_section_session() {

			if ( isset( $_POST['section'] ) ) {

				$section = esc_attr( $_POST['section'] );
				$visibility = ( $_POST['visibility'] == 'notshown' ? 'notshown' : 'shown' );

				$_SESSION['shopkit_' . $section] = $visibility;

				die( '1' );
				exit;

			}

			die();
			exit;

		}

		public static function check_section_session( $el, $collapsible ) {

			if ( $collapsible == '' ) {
				$collapsible = 'normal';
			}

			if ( !in_array( $collapsible, array( 'normal', 'always-collapsed-with-icon', 'always-collapsed-with-trigger' ) ) ) {

				if ( !isset( $_SESSION['shopkit_' . $el] ) ) {

					$collapsed = strpos( $collapsible , 'collapsed' ) !== false ? 'notshown' : 'shown' ;

					$_SESSION['shopkit_' . $el] = $collapsed;

					return $collapsed;

				}

				return $_SESSION['shopkit_' . $el];

			}
			else {
				if ( in_array( $collapsible, array( 'always-collapsed-with-icon', 'always-collapsed-with-trigger' ) ) ) {
					return 'notshown';
				}
				return false;
			}

		}

		public static function get_section_type( $el, $el_slug, $collapsible ) {

			if ( $collapsible == 'normal' ) {
				return '';
			}

			if ( !in_array( $collapsible, array( 'collapsible-with-trigger', 'collapsed-with-trigger', 'always-collapsed-with-trigger' ) ) ) {

				$collapsed = !isset( $_SESSION['shopkit_' . $el] ) ? ( strpos( $collapsible , 'collapsed' ) === true ? 'shopkit-active' : 'shopkit-notactive' ) : ( $_SESSION['shopkit_' . $el] == 'shown' ? 'shopkit-notactive' : 'shopkit-active' ) ;
?>
		<div class="shopkit-section-collapsible">
<?php
			switch( $collapsible ) :

			case 'collapsible-with-icon' :
?>
			<span class="shopkit-section-trigger-wrapper <?php echo 'shopkit-' . $el_slug . '-trigger ' . $collapsed; ?>"><span class="shopkit-section-trigger"></span></span>
<?php
			break;

			case 'always-collapsed-with-icon' :
			case 'collapsed-with-icon' :
?>
			<span class="shopkit-section-trigger-wrapper <?php echo 'shopkit-' . $el_slug . '-trigger ' . $collapsed; ?>"><span class="shopkit-section-trigger"></span></span>
<?php
			break;

			case 'collapsible-with-dismiss' :
?>
			<span class="shopkit-section-dismiss-wrapper <?php echo 'shopkit-' . $el_slug . '-dismiss'; ?>"><span class="shopkit-section-dismiss"></span></span>
<?php
			break;

			default :
			break;

			endswitch;
?>
		</div>
<?php
			}

			$remove = false;
			if ( in_array( $collapsible, array( 'always-collapsed-with-icon', 'always-collapsed-with-trigger' ) ) ) {
				$remove = true;
			}

			self::$settings['collapsibles'][] = array(
				'slug'   => $el_slug,
				'name'   => $el,
				'remove' => $remove
			);

		}

		public static function registration_form() {

			if( !is_user_logged_in() ) {

				$registration_enabled = get_option( 'users_can_register' );
		 
				if ( $registration_enabled ) {
					$output = self::registration_form_fields();
				}
				else {
					$output = esc_html__( 'User registration is disabled.', 'shopkit' );
				}

				return $output;
			}
		}

		public static function login_form() {

			if( !is_user_logged_in() ) {

				$output = self::login_form_fields();
			}
			else {
				$current_user = self::$settings['user'];
				$output = esc_html__( 'Logged in as', 'shopkit' ) . ' ' . $current_user->user_login;
			}
			
			return $output;
		}

		public static function registration_form_fields() {

			ob_start(); ?>
				<h3><?php esc_html_e('Register New Account', 'shopkit'); ?></h3>
				<form class="shopkit-login-registration-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="POST">
					<fieldset>
						<p>
							<label><span><?php esc_html_e('Username', 'shopkit'); ?></span>
								<input name="shopkit_user_login_reg" class="required" type="text" placeholder="<?php esc_html_e('Username', 'shopkit') ?>" />
							</label>
						</p>
						<p>
							<label><span><?php esc_html_e('Email', 'shopkit'); ?></span>
								<input name="shopkit_user_email_reg" class="required" type="email" placeholder="<?php esc_html_e('Email', 'shopkit') ?>" />
							</label>
						</p>
						<p>
							<label><span><?php esc_html_e('Password', 'shopkit'); ?></span>
								<input name="shopkit_user_pass_reg" class="required" type="password" placeholder="<?php esc_html_e('Password', 'shopkit') ?>" />
							</label>
						</p>
						<p>
							<label><span><?php esc_html_e('Repeat Password', 'shopkit'); ?></span>
								<input name="shopkit_user_pass_confirm_reg" class="required" type="password" placeholder="<?php esc_html_e('Repeat Password', 'shopkit') ?>" />
							</label>
						</p>
						<p>
							<input type="hidden" name="shopkit_register_nonce" value="<?php echo wp_create_nonce('shopkit_register_nonce'); ?>"/>
							<input type="submit" value="<?php esc_html_e('Register', 'shopkit'); ?>"/>
						</p>
					</fieldset>
				</form>
			<?php
			do_action( 'shopkit_element_register_after' );
			return ob_get_clean();
		}

		public static function login_form_fields() {
		 
			ob_start(); ?>
				<h3><?php esc_html_e('Log in', 'shopkit'); ?></h3>
				<form class="shopkit-login-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
					<fieldset>
						<p>
							<label><span><?php esc_html_e('Username', 'shopkit'); ?></span>
								<input name="shopkit_user_login" class="required" type="text" placeholder="<?php esc_html_e('Username', 'shopkit') ?>"<?php isset( $_POST['shopkit_user_login'] ) ? ' value="' . esc_attr( $_POST['shopkit_user_login'] ) . '"' : '' ; ?> />
							</label>
						</p>
						<p>
							<label><span><?php esc_html_e('Password', 'shopkit'); ?></span>
								<input name="shopkit_user_pass" class="required" type="password" placeholder="<?php esc_html_e('Password', 'shopkit') ?>" />
							</label>
						</p>
						<p>
							<input type="hidden" name="shopkit_login_nonce" value="<?php echo wp_create_nonce('shopkit_login_nonce'); ?>"/>
							<input type="submit" value="<?php esc_html_e('Login', 'shopkit'); ?>"/>
						</p>
						<p><?php do_action( 'social_connect_form' ); ?></p>
					</fieldset>
				</form>
			<?php
			do_action( 'shopkit_element_login_after' );
			return ob_get_clean();
		}

		public static function login_member() {
			if( isset( $_POST['shopkit_login_nonce'] ) && wp_verify_nonce( $_POST['shopkit_login_nonce'], 'shopkit_login_nonce' ) ) {

				$user = get_user_by( 'email', $_POST['shopkit_user_login'] );
				
				if ( !$user ){
					$user = get_user_by( 'login', $_POST['shopkit_user_login'] );
				}

				if( !$user ) {
					self::registration_errors()->add('empty_username', esc_html__( 'Invalid username', 'shopkit' ) );
				}

				if( !isset($_POST['shopkit_user_pass']) || $_POST['shopkit_user_pass'] == '' ) {
					self::registration_errors()->add( 'empty_password', esc_html__('Enter password', 'shopkit' ) );
				}

				if ( $user === false ) {
					return false;
				}

				if( !wp_check_password( $_POST['shopkit_user_pass'], $user->user_pass, $user->ID ) ) {
					self::registration_errors()->add( 'empty_password', esc_html__( 'Incorrect password', 'shopkit' ) );
				}

				$errors = self::registration_errors()->get_error_messages();

				if( empty( $errors ) ) {
					wp_set_current_user( $user->ID, $user->user_login );
					wp_set_auth_cookie( $user->ID );

					do_action( 'wp_login', $user->user_login, $user );

					wp_redirect( esc_url( home_url() ) );
					exit;
				}
			}
		}

		public static function add_new_member() {
			if (isset( $_POST['shopkit_register_nonce'] ) && wp_verify_nonce($_POST['shopkit_register_nonce'], 'shopkit_register_nonce')) {

				$user_login = $_POST['shopkit_user_login_reg'];
				$user_email = $_POST['shopkit_user_email_reg'];
				$user_pass = $_POST['shopkit_user_pass_reg'];
				$pass_confirm = $_POST['shopkit_user_pass_confirm_reg'];

				if(username_exists($user_login)) {
					self::registration_errors()->add('username_unavailable', esc_html__('Username already taken', 'shopkit'));
				}
				if(!validate_username($user_login)) {
					self::registration_errors()->add('username_invalid', esc_html__('Invalid username', 'shopkit'));
				}
				if($user_login == '') {
					self::registration_errors()->add('username_empty', esc_html__('Enter username', 'shopkit'));
				}
				if(!is_email($user_email)) {
					self::registration_errors()->add('email_invalid', esc_html__('Invalid email', 'shopkit'));
				}
				if(email_exists($user_email)) {
					self::registration_errors()->add('email_used', esc_html__('Email already registered', 'shopkit'));
				}
				if($user_pass == '') {
					self::registration_errors()->add('password_empty', esc_html__('Enter password', 'shopkit'));
				}
				if($user_pass != $pass_confirm) {
					self::registration_errors()->add('password_mismatch', esc_html__('Passwords do not match', 'shopkit'));
				}

				$errors = self::registration_errors()->get_error_messages();

				if(empty($errors)) {

					$new_user_id = wp_insert_user( array(
						'user_login'		=> $user_login,
						'user_pass'	 		=> $user_pass,
						'user_email'		=> $user_email,
						'user_registered'	=> date( 'Y-m-d H:i:s' ),
						'role'				=> get_option( 'default_role', 'subscriber' ),
					) );

					if( $new_user_id ) {
						$user = get_user_by( 'login', $_POST['shopkit_user_login'] );

						wp_new_user_notification( $user->ID );
						wp_set_current_user( $user->ID, $user->user_login );
						wp_set_auth_cookie( $user->ID );

						do_action( 'wp_login', $user->user_login, $user );

						wp_redirect( esc_url( home_url() ) );
						exit;
					}

				}

			}
		}

		public static function registration_errors(){
			static $wp_error;
			return isset( $wp_error ) ? $wp_error : ( $wp_error = new WP_Error( null, null, null ) );
		}

		public static function show_registration_error_messages() {
			if($codes = self::registration_errors()->get_error_codes()) {

				$html = '<div class="shopkit-login-errors">';
				foreach($codes as $code){
					$message = self::registration_errors()->get_error_message($code);
					$html .= '<span class="error"> ' . $message . '</span> ';
				}
				$html .= '</div>';
				return $html;

			}
			return false;
		}

		public static function shopkit_menu_style( $classes, $item, $args, $depth ) {

			if ( in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-ancestor', $classes ) || in_array( 'current_page_item', $classes ) || in_array( 'current-page-ancestor', $classes ) ) {
				if ( in_array( 'menu-item-home', $classes ) || is_front_page() ) {
					$classes = array_diff( $classes, array( 'current-menu-item', 'current-menu-ancestor', 'current_page_item', 'current-page-ancestor' ) );
				}
			}

			if ( $depth !== 0 ) return $classes;

			$style = esc_attr( get_post_meta( $item->ID, 'shopkit-menu-style', true ) );

			if ( !empty( $style ) ) {
				$classes[] = 'shopkit-menu-style-' .  $style;
			}

			return $classes;

		}

		public static function shopkit_menu_background( $item_output, $item, $depth, $args ) {

			if ( $depth !== 0 ) return $item_output;

			$curr_img = esc_url( get_post_meta( $item->ID, 'shopkit-menu-bg-url', true ) );
			$curr_img_pos = esc_attr( get_post_meta( $item->ID, 'shopkit-menu-bg-pos', true ) );

			if ( !empty( $curr_img ) ) {
				$item_output = sprintf( '<img src="%1$s" class="shopkit-menu-bg" data-background-position="%2$s" alt="%3$s" />%4$s', $curr_img, $curr_img_pos, esc_html__( 'Menu background', 'shopkit' ), $item_output );
			}

			return $item_output;

		}

		public static function get_mobile_menu( $menu, $icon ) {

			$defaults = array( 'order' => 'ASC', 'orderby' => 'menu_order', 'post_type' => 'nav_menu_item', 'post_status' => 'publish', 'output' => array(), 'output_key' => 'menu_order', 'nopaging' => true );
			$menu_items = wp_get_nav_menu_items( $menu, $defaults );
?>
			<div class="shopkit-mobile-menu">
				<label>
					<span><?php echo ShopKit_Icons::get_icon( $icon, 'menu' ); ?></span>
<?php
					if ( !empty( $menu_items ) ) {
?>
						<select class="shopkit-mobile-menu-<?php echo esc_attr( $menu ); ?>" onchange="window.open(this.options[this.selectedIndex].value,'_top')">
<?php
						foreach ( $menu_items as $key => $menu_item ) {
?>
							<option value="<?php echo esc_url( $menu_item->url ); ?>"><?php echo ( $menu_item->menu_item_parent == 0 ? '' : '- ' ) . esc_html( $menu_item->title ); ?></option>
<?php
						}
?>
						</select>
<?php
					}
					else {
						wp_dropdown_pages( array( 'echo' => 1, 'name' => null, 'class' => 'shopkit-mobile-menu-all-pages' ) );
					}
?>
				</label>
			</div>
<?php
		}

		public static function revolution_slider() {

			$settings = array(
				array(
					'action' => 'shopkit_header',
					'function' => __CLASS__ . '::get_rev_abs_top',
					'priority' => '0'
				),
				array(
					'action' => 'shopkit_header',
					'function' => __CLASS__ . '::get_rev_before',
					'priority' => '9996'
				),
				array(
					'action' => 'shopkit_footer',
					'function' => __CLASS__ . '::get_rev_after',
					'priority' => '1'
				),
				array(
					'action' => 'shopkit_footer',
					'function' => __CLASS__ . '::get_rev_abs_bot',
					'priority' => '10000'
				)
			);

			for ( $i = 0; $i < 4; $i++ ) {
				add_action( $settings[$i]['action'], $settings[$i]['function'], $settings[$i]['priority'] );
			}

		}

		public static function get_rev_slider( $slider ) {
			$rev = get_post_meta( get_the_ID(), '_shopkit_' . $slider, true );

			if ( function_exists( 'putRevSlider' ) && !empty( $rev ) ) {
				putRevSlider( $rev );
			}
		}

		public static function get_rev_abs_top() {
			self::get_rev_slider( 'revolution_1' );
		}

		public static function get_rev_before() {
			self::get_rev_slider( 'revolution_2' );
		}

		public static function get_rev_after() {
			self::get_rev_slider( 'revolution_3' );
		}

		public static function get_rev_abs_bot() {
			self::get_rev_slider( 'revolution_4' );
		}

		public static function get_page_header_start() {
?>
		<header class="shopkit-entry-header">
<?php
		}

		public static function get_page_thumbnail() {

			if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
				return;
			}

			$title = esc_attr( get_the_title() );
?>
			<figure class="shopkit-post-thumbnail">
				<?php the_post_thumbnail( 'thumbnail', array( 'alt' => $title ) ); ?>
			</figure>
<?php

		}

		public static function get_page_title() {
			the_title( '<h1 class="shopkit-entry-title">', '</h1>' );
		}

		public static function get_page_description() {

			if ( ( $desc = get_post_meta( get_the_ID(), '_shopkit_short_description', true ) ) !== '' ) {
?>
			<p class="shopkit-entry-description"><?php echo esc_html( $desc ); ?></p>
<?php
			}

		}

		public static function get_page_header_end() {
?>
		</header>
<?php
		}


		public static function get_post_tags() {
?>
			<p class="shopkit-entry-tags">
				<?php the_tags( '<span class="shopkit-entry-tags-title">' . esc_html__( 'Tags', 'shopkit' ) . ':</span>', '', '' ); ?>
			</p>
<?php
		}

		public static function get_page_content() {
			the_content( '<span class="button">' . esc_html__( 'Read more', 'shopkit' ) . '</span>' );
		}

		public static function get_page_nav() {
			wp_link_pages( array(
				'before'      => '<div class="shopkit-page-links"><span class="shopkit-page-links-title">' . esc_html__( 'Pages:', 'shopkit' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span class="button">',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'shopkit' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		}

		public static function get_post_comments() {

			$allowed = ShopKit_Ot_Settings::get_settings( 'general', 'post_comments' );

			if ( $allowed == 'on' && comments_open() || get_comments_number() ) {
				comments_template();
			}
		}

		public static function get_page_comments() {

			$allowed = ShopKit_Ot_Settings::get_settings( 'general', 'page_comments' );

			if ( $allowed == 'on' && comments_open() || get_comments_number() ) {
				comments_template();
			}
		}

		public static function get_page_fullwidth_header() {

		if ( has_post_thumbnail() ) {
			$thumbnail_data = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		}
?>
		<div class="shopkit-fullwidth-entry-header"<?php ( has_post_thumbnail() ? ' style="background-image:url(\'' . esc_url( $thumbnail_data[0] ) . '\');background-position:center center;background-size:1920px auto;"' : '' ); ?>>
			<div class="shopkit-inner-wrapper">
				<?php do_action( 'shopkit_page_header_fullwidth' ); ?>
			</div>
		</div>
<?php
		}

		public static function setup_page() {

			if ( class_exists( 'RevSlider' ) ) {
				add_action( 'shopkit_head', __CLASS__ . '::revolution_slider' );
			}

			$page_title = is_page() && ( ( $page_title_override = get_post_meta( get_the_ID(), '_shopkit_page_title', true ) ) ) !== '' ? $page_title_override : ShopKit_Ot_Settings::get_settings( 'general', 'page_title' );

			switch( $page_title ) {
				case 'none' :
				break;
				case 'content' :
				default :

					add_action( 'shopkit_page_header', __CLASS__ . '::get_page_header_start', 0 );
					add_action( 'shopkit_page_header', __CLASS__ . '::get_page_title', 5 );
					add_action( 'shopkit_page_header', __CLASS__ . '::get_page_description', 10 );
					add_action( 'shopkit_page_header', __CLASS__ . '::get_page_thumbnail', 15 );
					add_action( 'shopkit_page_header', __CLASS__ . '::get_page_header_end', 100 );

				break;
				
			}

			add_action( 'shopkit_page', __CLASS__ . '::get_page_content', 5 );
			add_action( 'shopkit_page', __CLASS__ . '::get_page_nav', 10 );
			add_action( 'shopkit_after_page', __CLASS__ . '::get_page_comments', 5 );

		}

		public static function get_post_thumbnail_archive() {

			$type = get_post_format();

			if( $type !== '' ) {
				switch ($type) {

					case 'audio' :
?>
					<?php self::get_post_thumbnail_audio(); ?>
<?php
					break;

					case 'gallery' :
						self::get_post_thumbnail_gallery_archive();
					break;

					case 'video' :
?>
					<?php self::get_post_thumbnail_video(); ?>
<?php
					break;

					case 'link' :
						self::get_post_thumbnail_link_archive();
					break;

					case 'quote' :
						self::get_post_thumbnail_quote();
					break;

					case 'image' :
					default :
						self::get_post_thumbnail_image();
					break;

				}
			}
			else {
				self::get_post_thumbnail_image();
			}

		}

		public static function get_post_thumbnail() {

			$type = get_post_format();

			if( $type !== '' ) {
				switch ($type) {

					case 'audio' :
?>
					<?php self::get_post_thumbnail_audio(); ?>
<?php
					break;

					case 'gallery' :
						self::get_post_thumbnail_gallery();
					break;

					case 'video' :
?>
					<?php self::get_post_thumbnail_video(); ?>
<?php
					break;

					case 'link' :
						self::get_post_thumbnail_link();
					break;

					case 'quote' :
						self::get_post_thumbnail_quote();
					break;

					case 'image' :
					default :
						self::get_post_thumbnail_image();
					break;

				}
			}
			else {
				self::get_post_thumbnail_image();
			}

		}

		public static function get_post_thumbnail_video() {

			global $post;

			$video_override_mp4 = get_post_meta( $post->ID,'_shopkit_post_video_mpeg', true );
			$video_override_ogg = get_post_meta( $post->ID, '_shopkit_post_video_ogg', true );

			if( $video_override_mp4 !== '' || $video_override_ogg !== '') {
				$add_poster = ( has_post_thumbnail() ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ) : '' );
?>
				<div class="shopkit-entry-area shopkit-entry-video">
					<video preload="auto" loop="loop" controls<?php echo ( $add_poster !== '' ? ' poster="' . esc_url( $add_poster[0] ) . '"  data-image-replacement="' . esc_url( $add_poster[0] ) . '"' : '' ); ?>>
<?php
						if ( $video_override_mp4 !== '' ) {
?>
							<source src="<?php echo esc_url( $video_override_mp4 ); ?>" type="video/mp4" />
<?php
						}
						if ( $video_override_ogg !== '' ) {
?>
							<source src="<?php echo esc_url( $video_override_ogg ); ?>" type="video/ogg" />
<?php
						}
						esc_html_e( 'Your browser does not support the video tag.', 'shopkit' );
?>
					</video>
				</div>
<?php
			}
			else {
				$video = get_post_meta( $post->ID, '_shopkit_post_video', true );
				if ( $video !== '' ) {
?>
					<div class="shopkit-entry-area shopkit-entry-video">
<?php
					echo wp_kses_post( $video );
?>
					</div>
<?php
				}
				else {
					self::get_post_thumbnail_image();
				}
			}

		}

		public static function get_post_thumbnail_audio() {

			global $post;

			$audio_override_mp4 = get_post_meta( $post->ID,'_shopkit_post_audio_mp4', true );
			$audio_override_ogg = get_post_meta( $post->ID, '_shopkit_post_audio_ogg', true );

			if( $audio_override_mp4 !== '' || $audio_override_ogg !== '') {
				$add_poster = ( has_post_thumbnail() ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ) : '' );
?>
					<div class="shopkit-entry-area shopkit-entry-audio">
					<audio preload="auto" loop="loop" controls<?php echo ( $add_poster !== '' ? ' poster="' . esc_url( $add_poster[0] ) . '"  data-image-replacement="' . esc_url( $add_poster[0] ) . '"' : '' ); ?>>
<?php
						if ( $audio_override_mp4 !== '' ) {
?>
							<source src="<?php echo esc_url( $audio_override_mp4 ); ?>" type="audio/mpeg" />
<?php
						}
						if ( $audio_override_ogg !== '' ) {
?>
							<source src="<?php echo esc_url( $audio_override_ogg ); ?>" type="audio/ogg" />
<?php
						}
						esc_html_e( 'Your browser does not support the audio tag.', 'shopkit' );
?>
					</audio>
				</div>
<?php
			}
			else {
				$audio = get_post_meta( $post->ID, '_shopkit_post_audio', true );
				if ( $audio !== '' ) {
?>
					<div class="shopkit-entry-area shopkit-entry-audio">
<?php
					echo wp_kses_post( $audio );
?>
					</div>
<?php
				}
				else {
					self::get_post_thumbnail_image();
				}
			}

		}

		public static function get_post_thumbnail_gallery_archive() {

			global $post;

			$gallery = get_post_meta( $post->ID, '_shopkit_post_gallery', true );

			if ( $gallery !== '' ) {
				self::get_archive_header_link_end();
				echo do_shortcode( $gallery );
				self::get_archive_header_link_start();
			}
			else {
				self::get_post_thumbnail_image();
			}

		}

		public static function get_post_thumbnail_gallery() {

			global $post;

			$gallery = get_post_meta( $post->ID, '_shopkit_post_gallery', true );

			if ( $gallery !== '' ) {
				echo do_shortcode( $gallery );
			}
			else {
				self::get_post_thumbnail_image();
			}

		}

		public static function get_post_thumbnail_link_archive() {

			global $post;

			$link = get_post_meta( $post->ID, '_shopkit_post_link', true );

			if ( $link !== '' ) {
				self::get_archive_header_link_end();
?>
			<a href="<?php echo esc_url( $link ); ?>" class="shopkit-post-link" title="<?php echo esc_attr( get_the_title() ); ?>">
<?php
				if ( has_post_thumbnail() ) {
					self::get_post_thumbnail_image( 'large' );
				}
				else {
					echo '<span class="shopkit-post-link-inner">' . esc_url( $link ) . '</span>';
				}
?>
			</a>
<?php
				self::get_archive_header_link_start();
			}
			else {
				self::get_post_thumbnail_image();
			}
		}

		public static function get_post_thumbnail_link() {

			global $post;

			$link = get_post_meta( $post->ID, '_shopkit_post_link', true );

			if ( $link !== '' ) {
?>
			<a href="<?php echo esc_url( $link ); ?>" class="shopkit-post-link" title="<?php echo esc_attr( get_the_title() ); ?>">
<?php
				if ( has_post_thumbnail() ) {
					self::get_post_thumbnail_image( 'large' );
				}
				else {
					echo '<span class="shopkit-post-link-inner">' . esc_url( $link ) . '</span>';
				}
?>
			</a>
<?php
			}
			else {
				self::get_post_thumbnail_image();
			}

		}

		public static function get_post_thumbnail_quote() {

			global $post;

			$quote = get_post_meta( $post->ID,'_shopkit_post_quote',true );

			if ( $quote !== '' ) {
?>
			<blockquote>
<?php
				echo esc_html( $quote );
?>
			</blockquote>
<?php
			}
			else {
				the_content( '<span class="button">' . esc_html__( 'Read more', 'shopkit' ) . '</span>' );
			}

		}

		public static function get_post_thumbnail_image() {

			if ( has_post_thumbnail() ) {
?>
			<figure class="shopkit-post-image">
<?php
				the_post_thumbnail( 'large' );
?>
			</figure>
<?php
			}

		}

		public static function get_post_author_avatar() {

			if ( ( $avatar = get_avatar( get_the_author_meta( 'email' ), 150 ) ) !== false ) {
?>
				<div class="shopkit-author-image"><?php echo get_avatar( get_the_author_meta( 'email' ), 150 ); ?></div>
<?php
			}

		}

		public static function get_post_date_icon() {
?>
			<div class="shopkit-date-icon">
				<span class="shopkit-date"><?php the_time( 'd' ); ?></span>
				<span class="shopkit-month"><?php the_time( 'M' ); ?></span>
			</div>
<?php
		}

		public static function get_post_compact_thumbnail() {

			if ( has_post_thumbnail() ) {
?>
			<figure class="shopkit-post-compact">
<?php
				the_post_thumbnail( 'thumbnail' );
?>
			</figure>
<?php
			}

		}

		public static function get_post_meta() {
?>
			<div class="shopkit-entry-meta">
				<span class="shopkit-author-meta"><?php esc_html_e( 'Posted in', 'shopkit' ); ?> <?php the_category(', '); ?> <?php esc_html_e( 'by', 'shopkit'); ?> <?php the_author(); ?></span>
				<span class="shopkit-time-meta"><?php esc_html_e( 'on', 'shopkit' ); ?> <?php echo get_the_date( get_option( 'date_format' ) . ' @ ' . get_option( 'time_format' ) ); ?></span>
			</div>
<?php
		}

		public static function get_post_nav() {
			the_post_navigation( array(
				'next_text' => '<span class="shopkit-meta-nav button">' . esc_html__( 'Next &rarr;', 'shopkit' ) . '</span> ' .
					'<span class="screen-reader-text">' . esc_html__( 'Next post:', 'shopkit' ) . '</span> ' .
					'<span class="shopkit-post-title">%title</span>',
				'prev_text' => '<span class="shopkit-meta-nav button">' . esc_html__( '&larr; Previous', 'shopkit' ) . '</span> ' .
					'<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'shopkit' ) . '</span> ' .
					'<span class="shopkit-post-title">%title</span>',
			) );
		}

		public static function setup_post() {

			add_action( 'shopkit_single_header', __CLASS__ . '::get_page_header_start', 0 );
			add_action( 'shopkit_single_header', __CLASS__ . '::get_post_author_avatar', 10 );
			add_action( 'shopkit_single_header', __CLASS__ . '::get_post_date_icon', 15 );
			add_action( 'shopkit_single_header', __CLASS__ . '::get_page_title', 20 );
			add_action( 'shopkit_single_header', __CLASS__ . '::get_post_meta', 25 );
			add_action( 'shopkit_single_header', __CLASS__ . '::get_page_description', 30 );
			add_action( 'shopkit_single_header', __CLASS__ . '::get_post_thumbnail', 35 );
			add_action( 'shopkit_single_header', __CLASS__ . '::get_page_header_end', 100 );
			add_action( 'shopkit_single', __CLASS__ . '::get_page_content', 5 );
			add_action( 'shopkit_single', __CLASS__ . '::get_post_tags', 10 );
			add_action( 'shopkit_single', __CLASS__ . '::get_page_nav', 15 );
			add_action( 'shopkit_after_single', __CLASS__ . '::get_post_nav', 5 );
			add_action( 'shopkit_after_single', __CLASS__ . '::get_post_comments', 10 );

		}

		public static function get_archive_title() {

			if ( is_search() ) {

				$page_title = sprintf( esc_html__( 'Search Results: &ldquo;%s&rdquo;', 'shopkit' ), get_search_query() );

				if ( get_query_var( 'paged' ) ) {
					$page_title .= sprintf( esc_html__( '&nbsp;&ndash; Page %s', 'shopkit' ), intval( get_query_var( 'paged' ) ) );
				}

			}

			if ( function_exists( 'get_the_archive_title' ) ) {
				if ( !is_home() ) {
					$page_title = get_the_archive_title();
				}
				else {
					$page_title = get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' );
				}
			}
			else {

				if ( is_tax() || is_category() || is_tag() ) {
					$page_title = esc_html__( 'Archive', 'shopkit' ) . ': ' . single_term_title( '', false );
				}
				else if ( is_year() ) {
					$page_title = esc_html__( 'Archive', 'shopkit' ) . ': ' . get_query_var( 'year' );
				}
				else if( is_month() ) {
					$page_title = esc_html__( 'Archive', 'shopkit' ) . ': ' . single_month_title( ' ', false );
				}
				else if ( is_day() ) {
					$date = get_query_var( 'day' ) . single_month_title( ' ', false );
					$page_title = esc_html__( 'Archive', 'shopkit' ) . ': ' . date( get_option( 'date_format' ), strtotime( $date ) );
				}
				else if ( is_home() ) {
					$page_title = get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' );
				}
				else {
					$page_title = esc_html__( 'Archive', 'shopkit' );
				}

			}

			if ( apply_filters( 'shopkit_show_title', true ) === true ) {
?>
				<h1 class="shopkit-entry-title"><?php echo esc_html( $page_title ); ?></h1>
<?php
			}
		}

		public static function get_archive_description() {

			$desc = do_shortcode( wp_kses_post( term_description() ) );

			if ( $desc !== '' ) {
				echo '<div class="term-description">' . $desc . '</div>';
			}
		}

		public static function get_archive_header_start() {
?>
			<header class="shopkit-entry-header">
<?php
		}

		public static function get_archive_header_link_start() {
?>
				<a href="<?php the_permalink(); ?>">
<?php
		}

		public static function get_archive_post_title() {
			the_title( '<h3 class="shopkit-entry-title">', '</h3>' );
		}


		public static function get_archive_header_link_end() {
?>
				</a>
<?php

		}
		public static function get_archive_header_end() {
?>
			</header>
<?php
		}

		public static function get_archive_nav() {

			the_posts_pagination( array(
				'prev_text'          => esc_html__( 'Prev', 'shopkit' ),
				'next_text'          => esc_html__( 'Next', 'shopkit' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'shopkit' ) . ' </span>',
			) );

		}

		public static function setup_archive() {

			$blog = ShopKit_Ot_Settings::get_settings( 'general', 'blog_style' );

			add_action( 'shopkit_before_archive', __CLASS__ . '::get_archive_title', 5 );
			add_action( 'shopkit_before_archive', __CLASS__ . '::get_archive_description', 10 );

			add_action( 'shopkit_archive_header_quote', __CLASS__ . '::get_archive_header_start', 0 );
			add_action( 'shopkit_archive_header_quote', __CLASS__ . '::get_post_thumbnail_archive', 35 );
			add_action( 'shopkit_archive_header_quote', __CLASS__ . '::get_archive_header_end', 100 );

			add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_archive_header_start', 0 );
			add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_archive_header_link_start', 1 );


			if ( $blog == 'compact' ) {
				add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_post_compact_thumbnail', 10 );
			}
			else {
				add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_post_thumbnail_archive', 35 );
				add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_post_author_avatar', 10 );
			}

			add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_post_date_icon', 15 );
			add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_archive_post_title', 20 );
			add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_archive_header_link_end', 21 );
			add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_post_meta', 25 );
			add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_archive_header_link_start', 29 );
			add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_page_description', 30 );
			add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_archive_header_link_end', 36 );
			add_action( 'shopkit_archive_header_standard', __CLASS__ . '::get_archive_header_end', 100 );
			add_action( 'shopkit_archive_standard', __CLASS__ . '::get_page_content', 5 );
			add_action( 'shopkit_archive_standard', __CLASS__ . '::get_page_nav', 10 );

			add_action( 'shopkit_after_archive', __CLASS__ . '::get_archive_nav', 5 );

		}

		public static function get_condition( $input ) {

			$condition_result = false;

			if ( substr_count( $input, '||' ) > 0 ) {
				$conditions = explode( '||', $input );
			}
			else {
				$conditions = array( $input );
			}

			foreach( $conditions as $condition ) {

				$condition_function = null;
				$inverse = null;
				$condition_parameters = null;

				if ( substr_count( $condition, ':' ) == 1 ) {
					$condition = explode( ':', $condition );
					$condition_function = $condition[0];
					$condition_parameters = strpos( $condition[1], ',' ) > 0 ? array_diff( explode( ',', $condition[1] ), array( '') ) : array( $condition[1] );
				}
				else if ( substr_count( $condition, ':' ) == 0 ) {
					$condition_function = $condition;
				}

				if ( isset( $condition_function ) ) {
					if ( substr( $condition_function, 0, 1 ) == '!' ) {
						$condition_function = substr( $condition_function, 1 );
						$inverse = true;
					}

					if ( function_exists( $condition_function ) ) {
						if ( isset( $inverse ) ) {
							if ( isset( $condition_parameters ) ) {
								$condition_result = !call_user_func( $condition_function, $condition_parameters );
							}
							else {
								$condition_result = !call_user_func( $condition_function );
							}
						}
						else {
							if ( isset( $condition_parameters ) ) {
								$condition_result = call_user_func( $condition_function, $condition_parameters );
							}
							else {
								$condition_result = call_user_func( $condition_function );
							}
						}
						
					}

				}

				if ( $condition_result === true ) {
					break;
				}

			}

			return $condition_result;

		}

		public static function wp_page_menu() {
			wp_page_menu( array( 'before' => '<ul id="menu-all-pages">' ) );
		}

		public static function replace_pwd_form( $output ) {
			$post = get_post();

			$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
			
			$output = '
			<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
			
				<h4>' . esc_html__( 'Password protected!', 'shopkit' ) . '</h4>
				<p>' . esc_html__( 'This content is password protected. To view it please enter your password.', 'shopkit' ) . '</p>
				<p>
					<label for="' . esc_attr( $label ) . '">
						<input name="post_password" id="' . esc_attr( $label ) . '" placeholder="' . esc_attr__( 'Enter password',  'shopkit' ) . '" type="password" size="20" />
					</label> 
					<button type="submit" name="Submit" class="icon">' . ShopKit_Icons::get_icon( 'line-icon', 'password' ) . '</button>
				</p>
			</form>';

			 return $output;

		}

		public static function breadcrumb_args( $args ) {
			return array_merge( $args, array(
				'container'       => 'nav',
				'before'          => '',
				'after'           => '',
				'show_on_front'   => false,
				'network'         => false,
				'show_title'      => true,
				'show_browse'     => false,
				'labels'          => array(),
				'post_taxonomy'   => array(),
				'echo'            => true,
			) );
		}
		
	}

	add_action( 'init', array( 'ShopKit', 'init' ), 1 );

	if ( !function_exists( 'mnthemes_add_meta_information' ) ) {
		function mnthemes_add_meta_information_action() {
			$val = apply_filters( 'mnthemes_add_meta_information_used', array() );
			if ( !empty( $val ) ) {
				echo '<meta name="generator" content="' . implode( ', ', $val ) . '"/>';
			}
		}
		function mnthemes_add_meta_information() {
			add_action( 'wp_head', 'mnthemes_add_meta_information_action', 99 );
		}
		mnthemes_add_meta_information();
	}

?>