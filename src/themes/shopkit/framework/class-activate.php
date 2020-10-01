<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	class ShopKit_Activate {

		public static function init() {
			$class = __CLASS__;
			new $class;
		}

		function __construct() {
			add_action( 'admin_init', 'ShopKit_Activate::activate' );
			add_action( 'admin_menu', 'ShopKit_Activate::add_page' );
		}

		public static function add_page() {
			add_theme_page( esc_html__( 'About ShopKit', 'shopkit' ), esc_html__( 'About ShopKit', 'shopkit' ), 'edit_theme_options', 'welcome-to-shopkit', 'ShopKit_Activate::activation_page' );
		}

		public static function activate() {
			global $pagenow;
			if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
				wp_redirect( self::get_page() );
			}
		}

		public static function get_page() {
			return esc_url( admin_url( 'themes.php?page=welcome-to-shopkit' ) );
		}

		public static function activation_page() {
?>

	<div class="wrap about-wrap shopkit-welcome">

		<header class="welcome">

			<div class="title">

				<h1><?php esc_html_e( 'Welcome to ShopKit!', 'shopkit' ); ?></h1>
				<div class="about-text"><?php printf( esc_html__( 'The ultimate WooCommerce theme is here! For documentation and guides, videos, changelogs and support follow this %1$slink%2$s!', 'shopkit' ), '<a href="https://mihajlovicnenad.com/shopkit-for-woocommerce/documentation/" target="_blank">', '</a>' ); ?></div>

			</div>

			<div class="information">

				<div class="branding">
					<div class="version"><?php echo WcSk()->version(); ?></div>
					<div class="text"><?php esc_html_e( 'Version', 'shopkit' ); ?></div>
				</div>
				<div class="description">
					<?php esc_html_e( 'Thanks for using the ShopKit theme!', 'shopkit' ); ?><br/>
					<a href="https://xforwoocommerce.com/" target="_blank">XforWooCommerce.com</a>
				</div>

			</div>

			<div class="video">
				<a href="https://help.xforwoocommerce.com" target="_blank"><img src="<?php echo WcSk()->template_url() . '/library/images/video-play.jpg'; ?>" /></a>
			</div>

		</header>

		<div class="changelog">

			<div class="feature-section two-col">

				<div class="col">
					<h3><span class="dashicons dashicons-welcome-learn-more"></span> <?php esc_html_e( 'Knowledge Base', 'shopkit' ); ?></h3>
					<p><?php printf( esc_html__( 'Fine everything about our plugins and themes in our %1$sKnowledge Base%2$s. In-depth documentation for the theme, including dozens of guide videos and plugin information.', 'shopkit' ), '<a href="https://help.xforwoocommerce.com" target="_blank">', '</a>' ); ?></p>
				</div>

				<div class="col">
					<h3><span class="dashicons dashicons-id-alt"></span> <?php esc_html_e( 'Demo Content', 'shopkit' ); ?></h3>
					<p><?php printf( esc_html__( 'Want our demo content, products and pages on your website? Recreate our demo webiste in a single click! Find out how %1$shere%2$s.', 'shopkit' ), '<a href="https://help.xforwoocommerce.com" target="_blank">', '</a>' ); ?></p>
				</div>

				<div class="col">
					<h3><span class="dashicons dashicons-welcome-widgets-menus"></span> <?php esc_html_e( 'Child Themes', 'shopkit' ); ?></h3>
				<?php
					if ( is_child_theme() ) {
				?>
					<p><span class="success"><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'ShopKit is installed using child theme. Way to go!', 'shopkit' ); ?></span></p>
				<?php
					}
					else {
				?>
					<p><span class="error"><span class="dashicons dashicons-no-alt"></span> <?php esc_html_e( 'Child theme is not used. Please follow the link bellow for more information!', 'shopkit' ); ?></span></p>
				<?php
					}
				?>
					<p><?php printf( esc_html__( 'Always use a child theme instead of the original ShopKit theme. To find out more about child themes, visit this %1$slink%2$s.', 'shopkit' ), '<a href="https://help.xforwoocommerce.com" target="_blank">', '</a>' ); ?></p>
				</div>

				<div class="col">
					<h3><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e( 'Support', 'shopkit' ); ?></h3>
					<p><?php printf( esc_html__( 'Got a question about ShopKit or the exclusive extensions? Please visit our support forum %1$shere%2$s and open a ticket.', 'shopkit' ), '<a href="https://help.xforwoocommerce.com" target="_blank">', '</a>' ); ?></p>
				</div>

			</div>

		</div>

	</div>

<?php
		}

	}

	add_action( 'init', array( 'ShopKit_Activate', 'init' ) );
