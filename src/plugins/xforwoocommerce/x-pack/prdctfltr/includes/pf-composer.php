<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Prdctfltr_Sc_Products extends WPBakeryShortCode {
		}
	}

	$presets = array(
		esc_html__( 'Default', 'xforwoocommerce' ) => ''
	);

	$presetsData = Prdctfltr()->__get_presets();

	if ( is_array( $presetsData ) ) {
		foreach ( $presetsData as $presetsD ) {
			$presets[$presetsD['slug']] = $presetsD['name'];
		}
	}

	$choices_columns[1] = '1';
	$choices_columns[2] = '2';
	$choices_columns[3] = '3';
	$choices_columns[4] = '4';
	$choices_columns[5] = '5';
	$choices_columns[6] = '6';
	$choices_columns[7] = '7';
	$choices_columns[8] = '8';

	$choices_orderby['menu_order title'] = 'menu_order title';
	$choices_orderby['ID'] = 'ID';
	$choices_orderby['author'] = 'author';
	$choices_orderby['title'] = 'title';
	$choices_orderby['name'] = 'name';
	$choices_orderby['date'] = 'date';
	$choices_orderby['modified'] = 'modified';
	$choices_orderby['rand'] = 'rand';
	$choices_orderby['comment_count'] = 'comment_count';
	$choices_orderby['menu_order title'] = 'menu_order title';
	$choices_orderby['post__in'] = 'post__in';

	$choices_order['DESC'] = 'DESC';
	$choices_order['ASC'] = 'ASC';

	vc_map( array(
		'name'             => esc_html__( 'WooCommerce Product Filter', 'xforwoocommerce' ),
		'base'             => 'prdctfltr_sc_products',
		'class'            => '',
		'category'         => esc_html__( 'Content', 'xforwoocommerce' ),
		'icon' => Prdctfltr()->plugin_url() . '/includes/images/pficon.png',
		'description'      => esc_html__( 'All in one Product Filter for WooCommerce!', 'xforwoocommerce' ),
		'params' => array(

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Show Filter', 'xforwoocommerce' ),
				'param_name'  => 'use_filter',
				'value'       => array(
					'yes',
					'no',
				),
				'description' => '',
				'std'         => 'yes'
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Filter Preset', 'xforwoocommerce' ),
				'param_name'  => 'preset',
				'value'       => $presets,
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Show Categories', 'xforwoocommerce' ),
				'param_name'  => 'show_categories',
				'value'       => array(
					'yes',
					'no',
				),
				'description' => '',
				'std'         => 'no'
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Category Columns', 'xforwoocommerce' ),
				'param_name'  => 'cat_columns',
				'value'       => $choices_columns,
				'description' => '',
				'std'         => 6
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Show Products (Step Filter mode when set to NO)', 'xforwoocommerce' ),
				'param_name'  => 'show_products',
				'value'       => array(
					'yes',
					'no',
				),
				'description' => '',
				'std'         => 'yes'
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Product Columns', 'xforwoocommerce' ),
				'param_name'  => 'columns',
				'value'       => $choices_columns,
				'description' => '',
				'std'         => 4
			),

			array(
				'type'        => 'textfield',
				'class'       => '',
				'heading'     => esc_html__( 'Product Rows', 'xforwoocommerce' ),
				'param_name'  => 'rows',
				'value'       => '',
				'description' => '',
				'std'         => 4
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Pagination', 'xforwoocommerce' ),
				'param_name'  => 'pagination',
				'value'       => array(
					'yes',
					'no',
					'loadmore',
					'infinite'
				),
				'description' => '',
				'std'         => 'yes'
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Ajax', 'xforwoocommerce' ),
				'param_name'  => 'ajax',
				'value'       => array(
					'yes',
					'no',
				),
				'description' => '',
				'std'         => 'no'
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Order By', 'xforwoocommerce' ),
				'param_name'  => 'orderby',
				'value'       => $choices_orderby,
				'description' => '',
				'std'         => 'menu_order title'
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Order', 'xforwoocommerce' ),
				'param_name'  => 'order',
				'value'       => $choices_order,
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'textfield',
				'class'       => '',
				'heading'     => esc_html__( 'Min Price', 'xforwoocommerce' ),
				'param_name'  => 'min_price',
				'value'       => '',
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'textfield',
				'class'       => '',
				'heading'     => esc_html__( 'Max Price', 'xforwoocommerce' ),
				'param_name'  => 'max_price',
				'value'       => '',
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'textfield',
				'class'       => '',
				'heading'     => esc_html__( 'Product Category', 'xforwoocommerce' ),
				'param_name'  => 'product_cat',
				'value'       => '',
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'textfield',
				'class'       => '',
				'heading'     => esc_html__( 'Product Tag', 'xforwoocommerce' ),
				'param_name'  => 'product_tag',
				'value'       => '',
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'textfield',
				'class'       => '',
				'heading'     => esc_html__( 'Product Characteristics', 'xforwoocommerce' ),
				'param_name'  => 'product_characteristics',
				'value'       => '',
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Sale Products', 'xforwoocommerce' ),
				'param_name'  => 'sale_products',
				'value'       => array(
					'Default' => '',
					'on',
					'off'
				),
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Instock Products', 'xforwoocommerce' ),
				'param_name'  => 'instock_products',
				'value'       => array(
					'Default' => '',
					'in',
					'out',
					'both'
				),
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'textarea',
				'class'       => '',
				'heading'     => esc_html__( 'HTTP Query', 'xforwoocommerce' ),
				'param_name'  => 'http_query',
				'value'       => '',
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'textfield',
				'class'       => '',
				'heading'     => esc_html__( 'Custom Action', 'xforwoocommerce' ),
				'param_name'  => 'action',
				'value'       => '',
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Show Loop Title', 'xforwoocommerce' ),
				'param_name'  => 'show_loop_title',
				'value'       => array(
					'Default' => '',
					'no',
				),
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Show Loop Price', 'xforwoocommerce' ),
				'param_name'  => 'show_loop_price',
				'value'       => array(
					'Default' => '',
					'no',
				),
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Show Loop Rating', 'xforwoocommerce' ),
				'param_name'  => 'show_loop_rating',
				'value'       => array(
					'Default' => '',
					'no',
				),
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Show Loop Add to Cart', 'xforwoocommerce' ),
				'param_name'  => 'show_loop_add_to_cart',
				'value'       => array(
					'Default' => '',
					'no',
				),
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Fallback CSS (If columns option is not working)', 'xforwoocommerce' ),
				'param_name'  => 'fallback_css',
				'value'       => array(
					'yes',
					'no',
				),
				'description' => '',
				'std'         => 'no'
			),

/*			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Disable Filtering for WC Shortcodes', 'xforwoocommerce' ),
				'param_name'  => 'disable_woo_filter',
				'value'       => array(
					'yes',
					'no',
				),
				'description' => '',
				'std'         => 'no'
			),
*/
			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Disable Preset Overrides', 'xforwoocommerce' ),
				'param_name'  => 'disable_overrides',
				'value'       => array(
					'yes',
					'no',
				),
				'description' => '',
				'std'         => 'yes'
			),

			array(
				'type'        => 'textfield',
				'class'       => '',
				'heading'     => esc_html__( 'Bottom Margin', 'xforwoocommerce' ),
				'param_name'  => 'bot_margin',
				'value'       => '',
				'description' => '',
				'std'         => 40
			),

			array(
				'type'        => 'textfield',
				'class'       => '',
				'heading'     => esc_html__( 'Shortcode ID', 'xforwoocommerce' ),
				'param_name'  => 'shortcode_id',
				'value'       => '',
				'description' => '',
				'std'         => ''
			),

			array(
				'type'        => 'textfield',
				'class'       => '',
				'heading'     => esc_html__( 'Class', 'xforwoocommerce' ),
				'param_name'  => 'class',
				'value'       => '',
				'description' => '',
				'std'         => ''
			),

		)
	) );

	$shortcodes = array(
		'products',
		'recent_products',
		'sale_products',
		'best_selling_products',
		'top_rated_products',
		'featured_products',
		'product_category',
		'product_attribute'
	);

	$choices_pagination['no'] = 'no';
	$choices_pagination['yes'] = 'yes';
	$choices_pagination['loadmore'] = 'loadmore';
	$choices_pagination['infinite'] = 'infinite';

	foreach( $shortcodes as $shortcode ) {
		$params = array(
			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Product Filter - Activate', 'xforwoocommerce' ),
				'param_name'  => 'prdctfltr',
				'value'       => array(
					'yes',
					'widget',
					'no',
				),
				'description' => '',
				'std'         => 'no'
			),
			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Product Filter - Ajax', 'xforwoocommerce' ),
				'param_name'  => 'ajax',
				'value'       => array(
					'yes',
					'no',
				),
				'description' => '',
				'std'         => 'no'
			),
			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Product Filter - Select Preset', 'xforwoocommerce' ),
				'param_name'  => 'preset',
				'value'       => $presets,
				'description' => '',
				'std'         => ''
			),
			array(
				'type'        => 'dropdown',
				'class'       => '',
				'heading'     => esc_html__( 'Product Filter - Pagination', 'xforwoocommerce' ),
				'param_name'  => 'pagination',
				'value'       => $choices_pagination,
				'description' => '',
				'std'         => 'no'
			),
		);
		foreach( $params as $param ) {
			vc_add_param( $shortcode, $param );
		}
	}

