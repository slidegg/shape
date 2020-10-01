<?php

	class XforWC_Warranties_Returns_Settings {

		public static function init() {
			add_filter( 'svx_plugins_settings', __CLASS__ . '::get_settings', 50 );
		}

		public static function get_settings( $plugins ) {

			$presets = get_terms( 'wcwar_warranty_pre', array('hide_empty' => false) );

			$ready_presets = array(
				'' => esc_html__( 'None', 'xforwoocommerce' )
			);

			foreach ( $presets as $preset ) {
				$ready_presets[$preset->term_id] = $preset->name;
			}

			$pages = get_pages();

			$ready_pages = array(
				'' => esc_html__( 'None', 'xforwoocommerce' )
			);

			foreach ( $pages as $page ) {
				$ready_pages[$page->ID] = $page->post_title;
			}

			$plugins['warranties_and_returns'] = array(
				'slug' => 'warranties_and_returns',

				'name' => function_exists( 'XforWC' ) ? esc_html__( 'Warranties and Returns', 'xforwoocommerce' ) : esc_html__( 'Warranties and Returns for WooCommerce', 'xforwoocommerce' ),
				'desc' => function_exists( 'XforWC' ) ? esc_html__( 'Warranties and Returns for WooCommerce', 'xforwoocommerce' ) . ' v' . XforWC_Warranties_Returns::$version : esc_html__( 'Settings page for Warranties and Returns for WooCommerce!', 'xforwoocommerce' ),
				'link' => 'https://xforwoocommerce.com/store/warranties-and-returns/',
				'ref' => array(
					'name' => esc_html__( 'Visit XforWooCommerce.com', 'xforwoocommerce' ),
					'url' => 'https://xforwoocommerce.com',
				),
				'doc' => array(
					'name' => esc_html__( 'Get help', 'xforwoocommerce' ),
					'url' => 'https://help.xforwoocommerce.com',
				),
				'sections' => array(
					'dashboard' => array(
						'name' => esc_html__( 'Dashboard', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Dashboard Overview', 'xforwoocommerce' ),
					),
					'warranties' => array(
						'name' => esc_html__( 'Warranties', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Warranties Options', 'xforwoocommerce' ),
					),
					'returns' => array(
						'name' => esc_html__( 'Returns', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Returns Options', 'xforwoocommerce' ),
					),
					'email' => array(
						'name' => esc_html__( 'E-Mail', 'xforwoocommerce' ),
						'desc' => esc_html__( 'E-Mail Options', 'xforwoocommerce' ),
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
						<img src="' . XforWC_Warranties_Returns::$url_path . 'assets/images/warranties-and-returns-for-woocommerce-shop.png" class="svx-dashboard-image" />
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

					'war_settings_page' => array(
						'name'    => esc_html__( 'Request Page', 'xforwoocommerce' ),
						'type'    => 'select',
						'desc'    => esc_html__( 'Please select the page for requesting warranties. Check Documentation FAQ if the page was not created automatically.', 'xforwoocommerce' ),
						'id'      => 'war_settings_page',
						'options' => $ready_pages,
						'default' => '',
						'autoload' => true,
						'section' => 'installation'
					),
					'wcwar_single_action' => array(
						'name'    => esc_html__( 'Init Action', 'xforwoocommerce' ),
						'type'    => 'text',
						'desc'    => esc_html__( 'Change default plugin initialization action on single product pages. Use actions done in your content-single-product.php file. Please enter action in the following format action_name:priority.', 'xforwoocommerce' ) . ' ( default: woocommerce_before_add_to_cart_form )',
						'id'      => 'wcwar_single_action',
						'default' => '',
						'autoload' => true,
						'section' => 'installation'
					),
					'wcwar_force_scripts' => array(
						'name' => esc_html__( 'Plugin Scripts', 'xforwoocommerce' ),
						'type' => 'checkbox',
						'desc' => esc_html__( 'Check this option to enable plugin scripts in all pages. This option fixes issues in Quick Views.', 'xforwoocommerce' ),
						'id'   => 'wcwar_force_scripts',
						'default' => 'no',
						'autoload' => true,
						'section' => 'installation'
					),
					'wcwar_single_mode' => array(
						'name'    => esc_html__( 'Customer Request Display Mode', 'xforwoocommerce' ),
						'type'    => 'select',
						'desc'    => esc_html__( 'Select display mode for the Single Warranty/Return Customer Post.', 'xforwoocommerce' ),
						'id'      => 'wcwar_single_mode',
						'default' => 'new',
						'options' => array(
							'old' => 'Old - WooThemes, Basic Themes',
							'new' => 'New - Most Supported in Premium Themes'
						),
						'autoload' => true,
						'section' => 'installation'
					),
					'wcwar_single_titles' => array(
						'name'    => esc_html__( 'Heading Size', 'xforwoocommerce' ),
						'type'    => 'select',
						'desc'    => esc_html__( 'Select heading size of warranty titles on single product pages.', 'xforwoocommerce' ),
						'id'      => 'wcwar_single_titles',
						'default' => 'h4',
						'options' => array(
							'h2' => 'H2',
							'h3' => 'H3',
							'h4' => 'H4',
							'h5' => 'H5',
							'h6' => 'H6'
						),
						'autoload' => false,
						'section' => 'installation'
					),


					'wcwar_default_warranty' => array(
						'name'    => esc_html__( 'Default Warranty', 'xforwoocommerce' ),
						'type'    => 'select',
						'desc'    => esc_html__( 'Products without warranties can have a default warranty. Please select warranty preset.', 'xforwoocommerce' ),
						'id'      => 'wcwar_default_warranty',
						'default' => '',
						'options' => $ready_presets,
						'autoload' => false,
						'section' => 'warranties'
					),
					'wcwar_default_post' => array(
						'name'    => esc_html__( 'Warranty Status', 'xforwoocommerce' ),
						'type'    => 'select',
						'desc'    => esc_html__( 'Select status for the newly submitted warranty request posts.', 'xforwoocommerce' ),
						'id'      => 'wcwar_default_post',
						'default' => 'pending',
						'options' => array(
							'draft' => esc_html__( 'Draft', 'xforwoocommerce' ),
							'publish' => esc_html__( 'Published', 'xforwoocommerce' ),
							'pending' => esc_html__( 'Pending', 'xforwoocommerce' )
						),
						'autoload' => false,
						'section' => 'warranties'
					),
					'wcwar_enable_multi_requests' => array(
						'name'    => esc_html__( 'Multi Requests', 'xforwoocommerce' ),
						'type'    => 'checkbox',
						'desc'    => esc_html__( 'Check this option to enable multi requests in the defined warranty period. New requests will available upon completing the previous requests.', 'xforwoocommerce' ),
						'id'      => 'wcwar_enable_multi_requests',
						'default' => 'no',
						'autoload' => false,
						'section' => 'warranties'
					),
					'wcwar_enable_guest_requests' => array(
						'name'    => esc_html__( 'Guest Requests', 'xforwoocommerce' ),
						'type'    => 'checkbox',
						'desc'    => esc_html__( 'Guests can access warranties using their Order ID and an E-Mail address to confirm their identity. Check this option if you want to allow guests to request warranties and returns.', 'xforwoocommerce' ),
						'id'      => 'wcwar_enable_guest_requests',
						'default' => 'no',
						'autoload' => false,
						'section' => 'warranties'
					),
					'wcwar_enable_admin_requests' => array(
						'name'    => esc_html__( 'Admin Warranties', 'xforwoocommerce' ),
						'type'    => 'checkbox',
						'desc'    => esc_html__( 'If checked admins will have the ability to create warranty requests for items without warranties.', 'xforwoocommerce' ),
						'id'      => 'wcwar_enable_admin_requests',
						'default' => 'yes',
						'autoload' => false,
						'section' => 'warranties'
					),
					'wcwar_form' => array(
						'name'    => esc_html__( 'Warranty Form', 'xforwoocommerce' ),
						'type'    => 'hidden',
						'desc'    => esc_html__( 'Use the manager to create a warranty form.', 'xforwoocommerce' ),
						'id'      => 'wcwar_form',
						'default' => '',
						'autoload' => false,
						'section' => 'warranties'
					),

					'wcwar_email_disable' => array(
						'name'    => esc_html__( 'Show/Hide Warranty Info', 'xforwoocommerce' ),
						'type'    => 'checkbox',
						'desc'    => esc_html__( 'Check this option to hide warranty information in WooCommerce Order E-Mails notifications.', 'xforwoocommerce' ),
						'id'      => 'wcwar_email_disable',
						'default' => 'no',
						'autoload' => true,
						'section' => 'email'
					),
					'wcwar_email_name' => array(
						'name'    => esc_html__( 'From Name', 'xforwoocommerce' ),
						'type'    => 'text',
						'desc'    => esc_html__( 'Enter email From Name: which should appear in quick emails.', 'xforwoocommerce' ),
						'id'      => 'wcwar_email_name',
						'default' => get_bloginfo( 'name' ),
						'autoload' => false,
						'section' => 'email'
					),
					'wcwar_email_address' => array(
						'name'    => esc_html__( 'Reply To', 'xforwoocommerce' ),
						'type'    => 'text',
						'desc'    => esc_html__( 'Enter email address that will appear as a Reply To: address in quick emails.', 'xforwoocommerce' ),
						'id'      => 'wcwar_email_address',
						'default' => get_bloginfo( 'admin_email' ),
						'autoload' => false,
						'section' => 'email'
					),
					'wcwar_email_bcc' => array(
						'name'    => esc_html__( 'BCC Copies', 'xforwoocommerce' ),
						'type'    => 'text',
						'desc'    => esc_html__( 'Enter E-Mail addresses separated by comma to send BCC copies of quick emails.', 'xforwoocommerce' ),
						'id'      => 'wcwar_email_bcc',
						'default' => '',
						'autoload' => false,
						'section' => 'email'
					),


					'wcwar_enable_returns' => array(
						'name'    => esc_html__( 'Enable Returns', 'xforwoocommerce' ),
						'type'    => 'checkbox',
						'desc'    => esc_html__( 'This option will enable the in store returns. Set your return period in which the items can be sent back by customers with a refund.', 'xforwoocommerce' ),
						'id'      => 'wcwar_enable_returns',
						'default' => 'no',
						'autoload' => false,
						'section' => 'returns'
					),
					'wcwar_returns_period' => array(
						'name' => esc_html__( 'Return Limit', 'xforwoocommerce' ),
						'type' => 'number',
						'desc' => esc_html__( 'Number of days for returning items upon order completition. If 0 is set, items will have a lifetime return period.', 'xforwoocommerce' ),
						'id'   => 'wcwar_returns_period',
						'default' => 0,
						'custom_attributes' => array(
							'min' 	=> 0,
							'max' 	=> 1826,
							'step' 	=> 1
						),
						'autoload' => false,
						'section' => 'returns'
					),
					'wcwar_returns_no_warranty' => array(
						'name'    => esc_html__( 'Returns Without a Warranty', 'xforwoocommerce' ),
						'type'    => 'checkbox',
						'desc'    => esc_html__( 'If checked, returns will be available for items that have no warranty.', 'xforwoocommerce' ),
						'id'      => 'wcwar_returns_no_warranty',
						'default' => 'no',
						'autoload' => false,
						'section' => 'returns'
					),

				)
			);

			foreach ( $plugins['warranties_and_returns']['settings'] as $k => $v ) {
				$get = isset( $v['translate'] ) && !empty( SevenVX()->language() ) ? $v['id'] . '_' . SevenVX()->language() : $v['id'];
				$std = isset( $v['default'] ) ?  $v['default'] : '';
				$set = ( $set = get_option( $get, false ) ) === false ? $std : $set;
				$plugins['warranties_and_returns']['settings'][$k]['val'] = SevenVX()->stripslashes_deep( $set );
			}

			return apply_filters( 'wc_warrantiesandreturns_settings', $plugins );
		}

	}

	if ( isset($_GET['page'], $_GET['tab']) && ($_GET['page'] == 'wc-settings' ) && $_GET['tab'] == 'warranties_and_returns' ) {
		add_action( 'init', array( 'XforWC_Warranties_Returns_Settings', 'init' ), 100 );
	}

?>