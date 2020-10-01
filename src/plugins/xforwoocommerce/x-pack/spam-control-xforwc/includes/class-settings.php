<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	class XforWC_SpamControl_Settings {

		public static function init() {

			if ( isset( $_GET['page'], $_GET['tab'] ) && ( $_GET['page'] == 'wc-settings' ) && $_GET['tab'] == 'spam_control_xforwc' ) {
				add_filter( 'svx_plugins_settings', array( 'XforWC_SpamControl_Settings', 'get_settings' ), 50 );
			}

			add_action( 'svx_ajax_saved_settings_spam_control_xforwc', array( 'XforWC_SpamControl_Function', '__start' ), 10, 1 );

		}

		public static function get_settings( $plugins ) {

			$plugins['spam_control_xforwc'] = array(
				'slug' => 'spam_control_xforwc',
				'name' => function_exists( 'XforWC' ) ? esc_html__( 'Spam Control', 'xforwoocommerce' ) : esc_html__( 'Comment and Review Spam Control for WooCommerce', 'xforwoocommerce' ),
				'desc' => function_exists( 'XforWC' ) ? esc_html__( 'Comment and Review Spam Control for WooCommerce', 'xforwoocommerce' ) . ' v' . XforWC_SpamControl()->version() : esc_html__( 'Settings page for Spam Control for WooCommerce!', 'xforwoocommerce' ),
				'link' => 'https://xforwoocommerce.com/store/spam-control/',
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
					'spam' => array(
						'name' => esc_html__( 'Spam Control', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Spam Control Options', 'xforwoocommerce' ),
					),
					'blacklist' => array(
						'name' => esc_html__( 'Blacklist', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Blacklist Options', 'xforwoocommerce' ),
					),
				),
				'settings' => array(

					'wcmn_dashboard' => array(
						'type' => 'html',
						'id' => 'wcmn_dashboard',
						'desc' => '	
							<img src="' . XforWC_SpamControl()->plugin_url() . '/includes/images/spam-control-for-woocommerce-shop.png" class="svx-dashboard-image" />
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

					'spam_control' => array(
						'name' => esc_html__( 'Activate Automatic Spam Control', 'xforwoocommerce' ),
						'type' => 'checkbox',
						'desc' => esc_html__( 'Activate automatic spam control', 'xforwoocommerce' ),
						'id'   => 'spam_control',
						'default' => '',
						'autoload' => false,
						'section' => 'spam',
						'class' => 'svx-refresh-active-tab',
					),

					'spam_notice' => array(
						'name' => esc_html__( 'Notice', 'xforwoocommerce' ),
						'type' => 'html',
						'desc' => '
						<div class="svx-option-header"><h3>' . esc_html__( 'Notice', 'xforwoocommerce' ) . '</h3></div><div class="svx-option-wrapper"><div class="svx-notice svx-info"><strong>' . esc_html__( 'Automatic spam control is active.', 'xforwoocommerce' ) . '</strong><br /><br />' . esc_html__( 'How this works? Read the following article', 'xforwoocommerce' ) . ' &rarr; <a href="' . esc_url( 'https://help.xforwoocommerce.com/category/spam-control/' ) . '" target="_blank">' . esc_html__( 'Help Center', 'xforwoocommerce' ) . '</a></div></div>',
						'section' => 'spam',
						'id'   => 'spam_notice',
						'condition' => 'spam_control:yes',
					),

					'interval' => array(
						'name' => esc_html__( 'Spam Control Interval', 'xforwoocommerce' ),
						'type' => 'select',
						'desc' => esc_html__( 'Set spam control interval', 'xforwoocommerce' ),
						'section' => 'spam',
						'id'   => 'interval',
						'default' => 'twicedaily',
						'options' => array(
							'hourly' => esc_html__( 'Once Hourly', 'xforwoocommerce' ),
							'twicedaily' => esc_html__( 'Twice Daily', 'xforwoocommerce' ),
							'daily' => esc_html__( 'Once Daily', 'xforwoocommerce' ),
						),
						'autoload' => false,
						'condition' => 'spam_control:yes',
					),

					'clear_spam' => array(
						'name' => esc_html__( 'Auto Clear Spam', 'xforwoocommerce' ),
						'type' => 'checkbox',
						'desc' => esc_html__( 'Automatically clear spamed items', 'xforwoocommerce' ),
						'id'   => 'clear_spam',
						'default' => 'yes',
						'autoload' => false,
						'section' => 'spam',
						'condition' => 'spam_control:yes',
					),

					'clear_trash' => array(
						'name' => esc_html__( 'Auto Clear Trash', 'xforwoocommerce' ),
						'type' => 'checkbox',
						'desc' => esc_html__( 'Automatically clear trashed items', 'xforwoocommerce' ),
						'id'   => 'clear_trash',
						'default' => 'yes',
						'autoload' => false,
						'section' => 'spam',
						'condition' => 'spam_control:yes',
					),

					'blacklist' => array(
						'name' => esc_html__( 'Manual Blacklist', 'xforwoocommerce' ),
						'type' => 'textarea',
						'desc' => esc_html__( 'Manual blacklist supports usernames, IPs, IP ranges or words. Add one entry per line. Manual blacklists works in addition to automatic spam protection', 'xforwoocommerce' ),
						'section' => 'blacklist',
						'id'   => 'blacklist',
						'autoload' => false,
						'default' => '',
					),

				)
			);

			foreach ( $plugins['spam_control_xforwc']['settings'] as $k => $v ) {
				if ( in_array( $k, array( 'wcmn_utility', 'wcmn_dashboard' ) ) ) {
					continue;
				}
				$get = isset( $v['translate'] ) && !empty( SevenVX()->language() ) ? $v['id'] . '_' . SevenVX()->language() : $v['id'];
				$std = isset( $v['default'] ) ?  $v['default'] : '';
				$set = ( $set = SevenVXGet()->get_option( $get, 'spam_control_xforwc' ) ) === false ? $std : $set;
				$plugins['spam_control_xforwc']['settings'][$k]['val'] = SevenVX()->stripslashes_deep( $set );
			}

			return apply_filters( 'spam_control_xforwc_settings', $plugins );
		}

		public static function stripslashes_deep( $value ) {
			$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
			return $value;
		}

	}

	XforWC_SpamControl_Settings::init();
