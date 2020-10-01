<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	class XforWC_AddTabs_Settings {

		public static function init() {

			if ( isset( $_GET['page'], $_GET['tab'] ) && ( $_GET['page'] == 'wc-settings' ) && $_GET['tab'] == 'add_tabs_xforwc' ) {
				add_filter( 'svx_plugins_settings', array( 'XforWC_AddTabs_Settings', 'get_settings' ), 50 );
			}

		}

		public static function get_settings( $plugins ) {

			$plugins['add_tabs_xforwc'] = array(
				'slug' => 'add_tabs_xforwc',
				'name' => function_exists( 'XforWC' ) ? esc_html__( 'Add Product Tabs', 'xforwoocommerce' ) : esc_html__( 'Add Product Tabs for WooCommerce', 'xforwoocommerce' ),
				'desc' => function_exists( 'XforWC' ) ? esc_html__( 'Add Product Tabs for WooCommerce', 'xforwoocommerce' ) . ' v' . XforWC_AddTabs()->version() : esc_html__( 'Settings page for Add Product Tabs for WooCommerce!', 'xforwoocommerce' ),
				'link' => 'https://xforwoocommerce.com/store/add-tabs-woocommerce/',
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
					'tabs' => array(
						'name' => esc_html__( 'Tabs Manager', 'xforwoocommerce' ),
						'desc' => esc_html__( 'Tabs Manager Options', 'xforwoocommerce' ),
					),
					'general' => array(
						'name' => esc_html__( 'General', 'xforwoocommerce' ),
						'desc' => esc_html__( 'General Options', 'xforwoocommerce' ),
					),
				),
				'settings' => array(

					'wcmn_dashboard' => array(
						'type' => 'html',
						'id' => 'wcmn_dashboard',
                        'desc' => '	
                            <img src="' . XforWC_AddTabs()->plugin_url() . '/includes/images/add-tabs-for-woocommerce.png" class="svx-dashboard-image" />
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

					'wcmn_addtabs_utility' => array(
						'name' => esc_html__( 'Plugin Options', 'xforwoocommerce' ),
						'type' => 'utility',
						'id' => 'wcmn_addtabs_utility',
						'desc' => esc_html__( 'Quick export/import, backup and restore, or just reset your optons here', 'xforwoocommerce' ),
						'section' => 'dashboard',
					),

					'tabs' => array(
						'name' => esc_html__( 'Tabs Manager', 'xforwoocommerce' ),
						'type' => 'list-select',
						'desc' => esc_html__( 'Use the tabs manager to add tabs!', 'xforwoocommerce' ),
						'id'   => 'tabs',
						'default' => array(),
						'autoload' => false,
						'section' => 'tabs',
						'options' => 'list',
						'translate' => true,
						'selects' => array(
							'csv' => esc_html__( 'Table from CSV', 'xforwoocommerce' ),
							'image' => esc_html__( 'Image', 'xforwoocommerce' ),
							'video' => esc_html__( 'Video', 'xforwoocommerce' ),
							'html' => esc_html__( 'Text, HTML, Shortcode', 'xforwoocommerce' ),
							'product_meta' => esc_html__( 'Product Meta', 'xforwoocommerce' ),
						),
						'settings' => array(
                            'csv' => array(
								'name' => array(
									'name' => esc_html__( 'Name', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter tab name', 'xforwoocommerce' ),
									'id'   => 'name',
									'default' => '',
                                ),
								'csv' => array(
									'name' => esc_html__( 'CSV', 'xforwoocommerce' ),
									'type' => 'file',
									'desc' => esc_html__( 'Enter .csv file URL', 'xforwoocommerce' ),
									'id'   => 'csv',
									'default' => ''
								),
                                'options' => array(
                                    'name' => esc_html__( 'CSV Values', 'xforwoocommerce' ),
                                    'type' => 'list-select',
                                    'desc' => esc_html__( 'Use this option to replace CSV values with images or HTML', 'xforwoocommerce' ),
                                    'id'   => 'options',
                                    'default' => array(),
                                    'options' => 'list',
                                    'selects' => array(
                                        'image' => esc_html__( 'Image', 'xforwoocommerce' ),
                                        'html' => esc_html__( 'Text, HTML, Shortcode', 'xforwoocommerce' ),
                                    ),
                                    'settings' => array(
                                        'image' => array(
                                            'name' => array(
                                                'name' => esc_html__( 'Name', 'xforwoocommerce' ),
                                                'type' => 'text',
                                                'desc' => esc_html__( 'Enter CSV value name', 'xforwoocommerce' ),
                                                'id'   => 'name',
                                                'default' => '',
                                            ),
                                            'value' => array(
                                                'name' => esc_html__( 'Value', 'xforwoocommerce' ),
                                                'type' => 'text',
                                                'desc' => esc_html__( 'Enter CSV value to replace', 'xforwoocommerce' ),
                                                'id'   => 'value',
                                                'default' => '',
                                            ),
                                            'image' => array(
                                                'name' => esc_html__( 'Image', 'xforwoocommerce' ),
                                                'type' => 'file',
                                                'desc' => esc_html__( 'Enter CSV value replacement image URL', 'xforwoocommerce' ),
                                                'id'   => 'image',
                                                'default' => ''
											),
                                        ),
                                        'html' => array(
                                            'name' => array(
                                                'name' => esc_html__( 'Name', 'xforwoocommerce' ),
                                                'type' => 'text',
                                                'desc' => esc_html__( 'Enter CSV value name', 'xforwoocommerce' ),
                                                'id'   => 'name',
                                                'default' => '',
                                            ),
                                            'value' => array(
                                                'name' => esc_html__( 'Value', 'xforwoocommerce' ),
                                                'type' => 'text',
                                                'desc' => esc_html__( 'Enter CSV value to replace', 'xforwoocommerce' ),
                                                'id'   => 'value',
                                                'default' => '',
                                            ),
                                            'html' => array(
                                                'name' => esc_html__( 'Text, HTML, Shortcode', 'xforwoocommerce' ),
                                                'type' => 'textarea',
                                                'desc' => esc_html__( 'Enter CSV value replacement text, HTML or shortcode', 'xforwoocommerce' ),
                                                'id'   => 'html',
                                                'default' => ''
                                            ),
                                        ),
                                    ),
								),
								'condition' => array(
									'name' => esc_html__( 'Display Condition', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter tab display condition E.G. !is_singular:my-product-slug', 'xforwoocommerce' ),
									'id'   => 'condition',
									'default' => '',
                                ),
							),
							'image' => array(
								'name' => array(
									'name' => esc_html__( 'Name', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter tab name', 'xforwoocommerce' ),
									'id'   => 'name',
									'default' => '',
                                ),
								'image' => array(
									'name' => esc_html__( 'Image', 'xforwoocommerce' ),
									'type' => 'file',
									'desc' => esc_html__( 'Enter image URL', 'xforwoocommerce' ),
                                    'id'   => 'image',
									'default' => ''
								),
								'condition' => array(
									'name' => esc_html__( 'Display Condition', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter tab display condition E.G. !is_singular:my-product-slug', 'xforwoocommerce' ),
									'id'   => 'condition',
									'default' => '',
                                ),
							),
							'video' => array(
								'name' => array(
									'name' => esc_html__( 'Name', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter tab name', 'xforwoocommerce' ),
									'id'   => 'name',
									'default' => '',
                                ),
								'video' => array(
									'name' => esc_html__( 'Video URL', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter YouTube video URL E.G. https://www.youtube.com/watch?v=Wt2zOAZsbJo', 'xforwoocommerce' ),
                                    'id'   => 'video',
									'default' => ''
								),
								'condition' => array(
									'name' => esc_html__( 'Display Condition', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter tab display condition E.G. !is_singular:my-product-slug', 'xforwoocommerce' ),
									'id'   => 'condition',
									'default' => '',
                                ),
							),
							'html' => array(
								'name' => array(
									'name' => esc_html__( 'Name', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter tab name', 'xforwoocommerce' ),
									'id'   => 'name',
									'default' => '',
                                ),
								'html' => array(
									'name' => esc_html__( 'Text, HTML, Shortcode', 'xforwoocommerce' ),
									'type' => 'textarea',
									'desc' => esc_html__( 'Enter text, HTML or shortcode', 'xforwoocommerce' ),
									'id'   => 'html',
									'default' => ''
								),
								'condition' => array(
									'name' => esc_html__( 'Display Condition', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter tab display condition E.G. !is_singular:my-product-slug', 'xforwoocommerce' ),
									'id'   => 'condition',
									'default' => '',
                                ),
							),
							'product_meta' => array(
								'name' => array(
									'name' => esc_html__( 'Name', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter tab name', 'xforwoocommerce' ),
									'id'   => 'name',
									'default' => '',
                                ),
								'key' => array(
									'name' => esc_html__( 'Meta key', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter Meta Key', 'xforwoocommerce' ),
									'id'   => 'key',
									'default' => ''
                                ),
								'meta_type' => array(
									'name' => esc_html__( 'Meta type', 'xforwoocommerce' ),
									'type' => 'select',
									'desc' => esc_html__( 'Select meta type', 'xforwoocommerce' ),
                                    'id'   => 'meta_type',
                                    'options' => array(
                                        'csv' => esc_html__( 'Table from CSV', 'xforwoocommerce' ),
                                        'image' => esc_html__( 'Image', 'xforwoocommerce' ),
                                        'video' => esc_html__( 'Video', 'xforwoocommerce' ),
                                        'html' => esc_html__( 'Text, HTML, Shortcode', 'xforwoocommerce' ),
									),
									'default' => 'html'
								),
								'add_field' => array(
									'name' => esc_html__( 'Add Product Field', 'xforwoocommerce' ),
									'type' => 'checkbox',
									'desc' => esc_html__( 'Add meta key field to edit product screen', 'xforwoocommerce' ),
									'id'   => 'add_field',
									'default' => 'yes'
								),
                                'options' => array(
                                    'name' => esc_html__( 'CSV Values', 'xforwoocommerce' ),
                                    'type' => 'list-select',
                                    'desc' => esc_html__( 'Use this option to replace CSV values with images or HTML', 'xforwoocommerce' ),
                                    'id'   => 'options',
									'default' => array(),
									'options' => 'list',
                                    'selects' => array(
                                        'image' => esc_html__( 'Image', 'xforwoocommerce' ),
                                        'html' => esc_html__( 'Text, HTML, Shortcode', 'xforwoocommerce' ),
                                    ),
                                    'settings' => array(
                                        'image' => array(
                                            'name' => array(
                                                'name' => esc_html__( 'Name', 'xforwoocommerce' ),
                                                'type' => 'text',
                                                'desc' => esc_html__( 'Enter CSV value name', 'xforwoocommerce' ),
                                                'id'   => 'name',
                                                'default' => '',
                                            ),
                                            'value' => array(
                                                'name' => esc_html__( 'Value', 'xforwoocommerce' ),
                                                'type' => 'text',
                                                'desc' => esc_html__( 'Enter CSV value to replace', 'xforwoocommerce' ),
                                                'id'   => 'value',
                                                'default' => '',
                                            ),
                                            'image' => array(
                                                'name' => esc_html__( 'Image', 'xforwoocommerce' ),
                                                'type' => 'file',
                                                'desc' => esc_html__( 'Enter CSV value replacement image URL', 'xforwoocommerce' ),
                                                'id'   => 'image',
                                                'default' => ''
                                            ),
                                        ),
                                        'html' => array(
                                            'name' => array(
                                                'name' => esc_html__( 'Name', 'xforwoocommerce' ),
                                                'type' => 'text',
                                                'desc' => esc_html__( 'Enter CSV value name', 'xforwoocommerce' ),
                                                'id'   => 'name',
                                                'default' => '',
                                            ),
                                            'value' => array(
                                                'name' => esc_html__( 'Value', 'xforwoocommerce' ),
                                                'type' => 'text',
                                                'desc' => esc_html__( 'Enter CSV value to replace', 'xforwoocommerce' ),
                                                'id'   => 'value',
                                                'default' => '',
                                            ),
                                            'html' => array(
                                                'name' => esc_html__( 'Text, HTML, Shortcode', 'xforwoocommerce' ),
                                                'type' => 'textarea',
                                                'desc' => esc_html__( 'Enter CSV value replacement text, HTML or shortcode', 'xforwoocommerce' ),
                                                'id'   => 'html',
                                                'default' => ''
                                            ),
                                        ),
                                    ),
								),
								'condition' => array(
									'name' => esc_html__( 'Display Condition', 'xforwoocommerce' ),
									'type' => 'text',
									'desc' => esc_html__( 'Enter tab display condition E.G. !is_singular:my-product-slug', 'xforwoocommerce' ),
									'id'   => 'condition',
									'default' => '',
                                ),
                            ),
						),
					),

					'description' => array(
						'name' => esc_html__( 'Rename Description', 'xforwoocommerce' ),
						'type' => 'text',
						'desc' => esc_html__( 'Rename short description tab', 'xforwoocommerce' ),
						'id'   => 'description',
						'default' => '',
						'translate' => true,
						'autoload' => false,
						'section' => 'general',
					),

					'description_off' => array(
						'name' => esc_html__( 'Hide Description', 'xforwoocommerce' ),
						'type' => 'checkbox',
						'desc' => esc_html__( 'Hide short description tab', 'xforwoocommerce' ),
						'id'   => 'description_off',
						'default' => '',
						'autoload' => false,
						'section' => 'general',
					),

					'additional_information' => array(
						'name' => esc_html__( 'Rename Additional Information', 'xforwoocommerce' ),
						'type' => 'text',
						'desc' => esc_html__( 'Rename additional information tab', 'xforwoocommerce' ),
						'id'   => 'additional_information',
						'default' => '',
						'translate' => true,
						'autoload' => false,
						'section' => 'general',
					),

					'additional_information_off' => array(
						'name' => esc_html__( 'Hide Additional Information', 'xforwoocommerce' ),
						'type' => 'checkbox',
						'desc' => esc_html__( 'Hide additional information tab', 'xforwoocommerce' ),
						'id'   => 'additional_information_off',
						'default' => '',
						'autoload' => false,
						'section' => 'general',
					),

				),
			);

			foreach ( $plugins['add_tabs_xforwc']['settings'] as $k => $v ) {
				$get = isset( $v['translate'] ) && !empty( SevenVX()->language() ) ? $v['id'] . '_' . SevenVX()->language() : $v['id'];
				$std = isset( $v['default'] ) ?  $v['default'] : '';
				$set = ( $set = SevenVXGet()->get_option( $get, 'add_tabs_xforwc' ) ) === false ? $std : $set;
				$plugins['add_tabs_xforwc']['settings'][$k]['val'] = SevenVX()->stripslashes_deep( $set );
			}

			return apply_filters( 'add_tabs_xforwc_settings', $plugins );
		}

		public static function stripslashes_deep( $value ) {
			$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
			return $value;
		}

	}

	XforWC_AddTabs_Settings::init();
