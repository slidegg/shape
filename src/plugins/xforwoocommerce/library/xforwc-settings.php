<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'X_for_WooCommerce_Settings' ) ) :

	final class X_for_WooCommerce_Settings {

		protected static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct() {
			do_action( 'xforwc_settings_loading' );

			$this->includes();

			do_action( 'xforwc_settings_loaded' );
		}

		public function includes() {
			add_action( 'admin_menu', array( $this, 'load_settings_page' ), 9999999999 );

			$page = isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'xforwoocommerce' ? true: false;
			if ( $page ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'load_script' ), 0 );
				add_action( 'admin_footer', array( $this, 'add_templates' ), 9999999999 );

				add_filter( 'xforwc_settings', array( $this, 'get_settings' ), 9999999999 );

				include_once( XforWC()->plugin_path() . '/x-pack/prdctfltr/prdctfltr.php' );
				include_once( XforWC()->plugin_path() . '/x-pack/product-loops/product-loops.php' );
				include_once( XforWC()->plugin_path() . '/x-pack/improved-sale-badges/improved-sale-badges.php' );
				include_once( XforWC()->plugin_path() . '/x-pack/improved-variable-product-attributes/improved-variable-product-attributes.php' );
				include_once( XforWC()->plugin_path() . '/x-pack/seo-for-woocommerce/seo-for-woocommerce.php' );
				include_once( XforWC()->plugin_path() . '/x-pack/share-print-pdf-woocommerce/share-woo.php' );
				include_once( XforWC()->plugin_path() . '/x-pack/woocommerce-frontend-shop-manager/woocommerce-frontend-shop-manager.php' );
				include_once( XforWC()->plugin_path() . '/x-pack/woocommerce-warranties-and-returns/woocommerce-warranties-and-returns.php' );
				include_once( XforWC()->plugin_path() . '/x-pack/add-tabs-xforwc/add-tabs-xforwc.php' );
				include_once( XforWC()->plugin_path() . '/x-pack/spam-control-xforwc/spam-control-xforwc.php' );
			}

			add_action( 'wp_ajax_xforwc_ajax_factory', array( $this, 'ajax_factory' ), 9999999999 );
		}

		function load_script() {
			//wp_enqueue_style( 'xforwc-style', XforWC()->plugin_url() .'/library/css/xforwoocommerce' . ( is_rtl() ? '-rtl' : '' ) . '.css', false, '' );
			wp_enqueue_style( 'xforwc-style', XforWC()->plugin_url() .'/library/css/xforwoocommerce' . ( is_rtl() ? '-rtl' : '' ) . '.min.css', false, '' );

			wp_register_script( 'xforwc-script', XforWC()->plugin_url() . '/library/js/xforwoocommerce.js', array( 'jquery', 'wp-util' ), '', true, 0 );
			wp_enqueue_script( 'xforwc-script' );

			wp_localize_script( 'xforwc-script', 'xforwc', apply_filters( 'xforwc_settings', array() ) );
			wp_localize_script( 'xforwc-script', 'svx', apply_filters( 'xforwc_svx_settings', array() ) );
		}

		function load_settings_page() {
			add_submenu_page( 'woocommerce', 'XforWooCommerce', 'XforWooCommerce', 'manage_woocommerce', 'xforwoocommerce', array( $this, 'show_settings' ) );
		}

		function show_settings() {
?>
			<div id="xforwoocommerce-dashboard">
				<a href="https://xforwoocommerce.com/" target="_blank"><img id="xforwoocommerce-logo" src="<?php echo XforWC()->plugin_url() . '/library/images/x-for-woocommerce-logo.png'; ?>" /></a>
			</div>
			<div id="xforwoocommerce-nav">
				<span class="xforwc-button-primary xforwc-back">&larr; <?php esc_html_e( 'Back', 'xforwoocommerce' ); ?></span>
				<span class="xforwc-dashboard-text"><?php esc_html_e( 'Hi! Welcome back to XforWooCommerce Dashboard v', 'xforwoocommerce' ); ?><?php echo XforWC()->version(); ?></span>
				<span class="xforwc-plugin-text"><?php esc_html_e( 'Click the button to go back to XforWooCommerce Dashboard.', 'xforwoocommerce' ); ?></span>
				<a href="https://xforwoocommerce.com/" class="xforwc-button-primary x-color" target="_blank"><?php esc_html_e( 'Visit XforWooCommerce.com', 'xforwoocommerce' ); ?></a>
				<a href="https://help.xforwoocommerce.com/" class="xforwc-button-primary red" target="_blank"><?php esc_html_e( 'Get help', 'xforwoocommerce' ); ?></a>
			</div>
			<div id="xforwoocommerce"></div>
<?php
		}

		function get_settings() {
			$options = get_option( '_xforwoocommerce', array() );

			return array(
				'ajax' => esc_url( admin_url( 'admin-ajax.php' ) ),
 				'plugins' => array(
					array(
						'name' => 'Product Filter for WooCommerce',
						'xforwc' => 'Product Filters',
						'slug' => 'product-filters',
						'image' => 'product-filter-for-woocommerce-elements.png',
						'executable' => 'prdctfltr.php',
						'version' => XforWC_Product_Filters::$version,
						'state' => !isset( $options['product-filters'] ) || $options['product-filters'] == 'yes' ? 'yes' : 'no',
					),
					array(
						'name' => 'Improved Options for WooCommerce',
						'xforwc' => 'Product Options',
						'slug' => 'product-options',
						'image' => 'improved-product-options-for-woocommerce-elements.png',
						'version' => XforWC_Improved_Options::$version,
						'state' => !isset( $options['product-options'] ) || $options['product-options'] == 'yes' ? 'yes' : 'no',
					),
					array(
						'name' => 'Improved Badges for WooCommerce',
						'xforwc' => 'Badges and Counters',
						'slug' => 'product-badges',
						'image' => 'improved-badges-for-woocommerce-elements.png',
						'version' => XforWC_Improved_Badges::$version,
						'state' => !isset( $options['product-badges'] ) || $options['product-badges'] == 'yes' ? 'yes' : 'no',
					),
					array(
						'name' => 'Autopilot SEO for WooCommerce',
						'xforwc' => 'Seach Engine Optimization (SEO)',
						'slug' => 'seo-for-woocommerce',
						'image' => 'autopilot-seo-for-woocommerce-elements.png',
						'version' => XforWC_SEO::$version,
						'state' => !isset( $options['seo-for-woocommerce'] ) || $options['seo-for-woocommerce'] == 'yes' ? 'yes' : 'no',
					),
					array(
						'name' => 'Live Product Editor for WooCommerce',
						'xforwc' => 'Live Product Editor',
						'slug' => 'live-editor',
						'image' => 'live-product-editor-for-woocommerce-elements.png',
						'executable' => 'live-editor.php',
						'version' => XforWC_Live_Editor::$version,
						'state' => !isset( $options['live-editor'] ) || $options['live-editor'] == 'yes' ? 'yes' : 'no',
					),
					array(
						'name' => 'Share, Print and PDF for WooCommerce',
						'xforwc' => 'Print, PDF and Share',
						'slug' => 'share-print-pdf',
						'image' => 'share-print-pdf-for-woocommerce-elements.png',
						'version' => XforWC_PDF_Print_Share::$version,
						'state' => !isset( $options['share-print-pdf'] ) || $options['share-print-pdf'] == 'yes' ? 'yes' : 'no',
					),
					array(
						'name' => 'Product Loops for WooCommerce',
						'xforwc' => 'Shop Design',
						'slug' => 'product-loops',
						'image' => 'product-loops-for-woocommerce-elements.png',
						'version' => XforWC_Shop_Design::$version,
						'state' => !isset( $options['product-loops'] ) || $options['product-loops'] == 'yes' ? 'yes' : 'no',
					),
					array(
						'name' => 'Warranties and Returns for WooCommerce',
						'xforwc' => 'Warranties and Returns',
						'slug' => 'warranties-and-returns',
						'image' => 'warranties-and-returns-for-woocommerce-elements.png',
						'version' => XforWC_Warranties_Returns::$version,
						'state' => !isset( $options['warranties-and-returns'] ) || $options['warranties-and-returns'] == 'yes' ? 'yes' : 'no',
					),
					array(
						'name' => 'Add Product Tabs for WooCommerce',
						'xforwc' => 'Product Tabs',
						'slug' => 'add-tabs-xforwc',
						'image' => 'add-product-tabs-for-woocommerce.png',
						'version' => XforWC_AddTabs::$version,
						'state' => !isset( $options['add-tabs-xforwc'] ) || $options['add-tabs-xforwc'] == 'yes' ? 'yes' : 'no',
					),
					array(
						'name' => 'Comment and Review Spam Control for WooCommerce',
						'xforwc' => 'Spam Control',
						'slug' => 'spam-control-xforwc',
						'image' => 'spam-control-for-woocommerce.png',
						'version' => XforWC_SpamControl::$version,
						'state' => !isset( $options['spam-control-xforwc'] ) || $options['spam-control-xforwc'] == 'yes' ? 'yes' : 'no',
					),
				),
			);
		}

		function add_templates() {
		?>
			<script type="text/template" id="tmpl-xforwc-plugin">
				<# if ( data.plugin.state && data.plugin.state == 'no' ) { #>
					<div id="xforwc-{{ data.plugin.slug }}" class="xforwc-plugin disabled">
						<img src="<?php echo XforWC()->plugin_url() . '/library/images/'; ?>{{ data.plugin.image }}" />
						<h2>{{ data.plugin.xforwc }}</h2>
						<span class="xforwc-button xforwc-disable" data-plugin="{{ data.plugin.slug }}"><?php esc_html_e( 'Activate', 'xforwoocommerce' ); ?></span>

						<span class="xforwc-plugin-label">{{ data.plugin.name }} <span class="xforwc-plugin-version">{{ data.plugin.version }}</span></span>
					</div>
				<# } else { #>
					<div id="xforwc-{{ data.plugin.slug }}" class="xforwc-plugin">
						<img src="<?php echo XforWC()->plugin_url() . '/library/images/'; ?>{{ data.plugin.image }}" />
						<h2>{{ data.plugin.xforwc }}</h2>
						<span class="xforwc-button-primary xforwc-configure" data-plugin="{{ data.plugin.slug }}"><?php esc_html_e( 'Dashboard', 'xforwoocommerce' ); ?></span>
						<span class="xforwc-plugin-label">{{ data.plugin.name }} <span class="xforwc-plugin-version">{{ data.plugin.version }}</span><br/><a href="javascript:void(0)" class="xforwc-disable activate" data-plugin="{{ data.plugin.slug }}"><?php esc_html_e( 'Deactivate module', 'xforwoocommerce' ); ?></a></span>
					</div>
				<# } #>
			</script>
		<?php
		}

		public function ajax_factory() {

			$opt = array(
				'success' => true
			);

			if ( !isset( $_POST['xforwc']['type'] ) ) {
				$this->ajax_die($opt);
			}

			if ( apply_filters( 'xforwc_can_you_save', false ) ) {
				$this->ajax_die($opt);
			}

			switch( $_POST['xforwc']['type'] ) {

				case 'get_svx' :
					wp_send_json( $this->_get_svx() );
					exit;
				break;

				case 'plugin_switch' :
					wp_send_json( $this->_plugin_switch() );
					exit;
				break;

				default :
					$this->ajax_die($opt);
				break;

			}

		}

		public function _plugin_switch() {
			$plugin = isset( $_POST['xforwc']['plugin'] ) ? $_POST['xforwc']['plugin'] : '';
			$state = isset( $_POST['xforwc']['state'] ) ? $_POST['xforwc']['state'] : '';

			if ( empty( $plugin ) || empty( $state ) ) {
				return false;
			}

			$options = get_option( '_xforwoocommerce', array() );

			$options[$plugin] = $state;

			update_option( '_xforwoocommerce', $options, true );

			return true;
		}

		public function _get_svx() {
			$plugin = isset( $_POST['xforwc']['plugin'] ) ? $_POST['xforwc']['plugin'] : '';
			if ( empty( $plugin ) ) {
				return array();
			}

			switch( $plugin ) {

				case 'product-filters' :
					$settings = XforWC_Product_Filters_Settings::get_settings( array() );
					return $settings['product_filter'];
				break;

				case 'product-loops' :
					$settings = XforWC_Shop_Design_Settings::get_settings( array() );
					return $settings['product_loops'];
				break;

				case 'product-badges' :
					$settings = XforWC_Improved_Badges_Settings::get_settings( array() );
					return $settings['improved_badges'];
				break;

				case 'product-options' :
					$settings = XforWC_Improved_Options_Settings::get_settings( array() );
					return $settings['improved_options'];
				break;

				case 'share-print-pdf' :
					$settings = WC_Spp_Settings::get_settings( array() );
					return $settings['share_print_pdf'];
				break;

				case 'seo-for-woocommerce' :
					$settings = XforWC_SEO_Settings::get_settings( array() );
					return $settings['seo_for_woocommerce'];
				break;

				case 'live-editor' :
					$settings = XforWC_Live_Editor_Settings::get_settings( array() );
					return $settings['live_editor'];
				break;

				case 'warranties-and-returns' :
					$settings = XforWC_Warranties_Returns_Settings::get_settings( array() );
					return $settings['warranties_and_returns'];
				break;

				case 'add-tabs-xforwc' :
					$settings = XforWC_AddTabs_Settings::get_settings( array() );
					return $settings['add_tabs_xforwc'];
				break;

				case 'spam-control-xforwc' :
					$settings = XforWC_SpamControl_Settings::get_settings( array() );
					return $settings['spam_control_xforwc'];
				break;

				default :
					return array();
				break;

			}
		}

		public function ajax_die($opt) {
			$opt['success'] = false;
			wp_send_json( $opt );
			exit;
		}


	}

	X_for_WooCommerce_Settings::instance();

endif;