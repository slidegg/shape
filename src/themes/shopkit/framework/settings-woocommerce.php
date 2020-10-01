<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function shopkit_woo_theme_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'shopkit_woo_theme_support' );

class ShopKit_WooCommerce_Settings {

	public static $settings;

	public static function init() {
		$class = __CLASS__;
		new $class;
	}

	function __construct() {

		add_filter( 'shopkit_settings_sections', __CLASS__ . '::add_section' );
		add_filter( ot_settings_id() . '_args', __CLASS__ . '::add_settings', 0, 1 );

	}

	public static function add_section( $sections ) {

		$sections[] = array(
			'id'          => 'woocommerce-shop',
			'title'       => esc_html__( 'Shop/Product Archives', 'shopkit' ),
			'type'        => 'shopkit'
		);
		$sections[] = array(
			'id'          => 'woocommerce-product',
			'title'       => esc_html__( 'Single Product Pages', 'shopkit' ),
			'type'        => 'shopkit'
		);

		return $sections;

	}

	public static function add_settings( $settings ) {

		$settings['settings']['wc_orderby'] = array(
			'id'          => 'wc_orderby',
			'label'       => esc_html__( 'Filter Template Position', 'shopkit' ),
			'desc'        => esc_html__( 'Set position of the Order By/Product Filter templates.', 'shopkit' ),
			'std'         => 'shopkit-orderby-bc',
			'type'        => 'select',
			'section'     => 'woocommerce-shop',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'shopkit-orderby-bcs',
				'label'       => esc_html__( 'Before Content and Sidebars', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'shopkit-orderby-bc',
				'label'       => esc_html__( 'Before Content', 'shopkit' ),
				'src'         => ''
			)
			)
		);

		$settings['settings']['wc_product_style'] = array(
			'id'          => 'wc_product_style',
			'label'       => esc_html__( 'Product Style', 'shopkit' ),
			'desc'        => esc_html__( 'Set the product style.', 'shopkit' ),
			'std'         => 'none',
			'type'        => 'select',
			'section'     => 'woocommerce-shop',
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
					'label'       => esc_html__( 'Default', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'separator-border',
					'label'       => esc_html__( 'Separator Border', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'round',
					'label'       => esc_html__( 'Round', 'shopkit' ),
					'src'         => ''
				)
			)
		);

		$settings['settings']['wc_image_effect'] = array(
			'id'          => 'wc_image_effect',
			'label'       => esc_html__( 'Image Effect', 'shopkit' ),
			'desc'        => esc_html__( 'Set the product image effect.', 'shopkit' ),
			'std'         => 'zoom',
			'type'        => 'select',
			'section'     => 'woocommerce-shop',
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
					'label'       => esc_html__( 'None', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'fade',
					'label'       => esc_html__( 'Fade (Uses first gallery image as second image) - Use with transparent images (PNG)', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'fade-force',
					'label'       => esc_html__( 'Fade Force Shadow (Uses first gallery image as second image) - Use with normal images (JPG)', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'flip-horizontal',
					'label'       => esc_html__( 'Flip Horizontal (Uses first gallery image as second image)', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'flip-vertical',
					'label'       => esc_html__( 'Flip Vertical (Uses first gallery image as second image)', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'zoom',
					'label'       => esc_html__( 'Zoom', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'zoom-fade',
					'label'       => esc_html__( 'Zoom and Fade (Uses first gallery image as second image) - Use with transparent images (PNG)', 'shopkit' ),
					'src'         => ''
				),
				array(
					'value'       => 'zoom-fade-force',
					'label'       => esc_html__( 'Zoom and Fade Force Shadow (Uses first gallery image as second image) - Use with normal images (JPG)', 'shopkit' ),
					'src'         => ''
				)
			)
		);

		$settings['settings']['wc_shop_title'] = array(
			'id'          => 'wc_shop_title',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Title', 'shopkit' ),
			'desc'        => esc_html__( 'Hide title from shop pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-shop',
		);

		$settings['settings']['wc_shop_rating'] = array(
			'id'          => 'wc_shop_rating',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Rating', 'shopkit' ),
			'desc'        => esc_html__( 'Hide rating from shop pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-shop',
		);

		$settings['settings']['wc_shop_price'] = array(
			'id'          => 'wc_shop_price',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Price', 'shopkit' ),
			'desc'        => esc_html__( 'Hide price from shop pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-shop',
		);

		$settings['settings']['wc_shop_desc'] = array(
			'id'          => 'wc_shop_desc',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Description', 'shopkit' ),
			'desc'        => esc_html__( 'Hide description from shop pages.', 'shopkit' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'woocommerce-shop',
		);

		$settings['settings']['wc_shop_add_to_cart'] = array(
			'id'          => 'wc_shop_add_to_cart',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Add to Cart', 'shopkit' ),
			'desc'        => esc_html__( 'Hide add to cart from shop pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-shop',
		);

		$settings['settings']['wc_shop_products_margin'] = array(
			'id'          => 'wc_shop_products_margin',
			'label'       => esc_html__( 'Custom Product Margins', 'shopkit' ),
			'desc'        => esc_html__( 'Enable custom margins for WooCommerce Product loops.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-shop',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		);

		$settings['settings']['wc_shop_products_columns_margin'] = array(
			'id'          => 'wc_shop_products_columns_margin',
			'label'       => esc_html__( 'Product Columns Margin', 'shopkit' ),
			'desc'        => esc_html__( 'Set margin between columns.', 'shopkit' ),
			'std'         => '30',
			'type'        => 'numeric-slider',
			'section'     => 'woocommerce-shop',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '0,60,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		);

		$settings['settings']['wc_shop_products_rows_margin'] = array(
			'id'          => 'wc_shop_products_rows_margin',
			'label'       => esc_html__( 'Product Rows Margin', 'shopkit' ),
			'desc'        => esc_html__( 'Set margin between rows.', 'shopkit' ),
			'std'         => '60',
			'type'        => 'numeric-slider',
			'section'     => 'woocommerce-shop',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '0,60,1',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		);

		$settings['settings']['wc_image_position'] = array(
			'id'          => 'wc_image_position',
			'label'       => esc_html__( 'Single Product Image Position', 'shopkit' ),
			'desc'        => esc_html__( 'Set the single product page image position.', 'shopkit' ),
			'std'         => 'imageleft',
			'type'        => 'select',
			'section'     => 'woocommerce-product',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => 'imageleft',
				'label'       => esc_html__( 'Product Image on Left', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'imageright',
				'label'       => esc_html__( 'Product Image on Right', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => 'fullimage',
				'label'       => esc_html__( 'Product Image Full Width', 'shopkit' ),
				'src'         => ''
			)
			)
		);


		$settings['settings']['wc_thumbnails_columns'] = array(
			'id'          => 'wc_thumbnails_columns',
			'label'       => esc_html__( 'Product Thumbnails Columns', 'shopkit' ),
			'desc'        => esc_html__( 'Set the product thumbnails columns.', 'shopkit' ),
			'std'         => '4',
			'type'        => 'select',
			'section'     => 'woocommerce-product',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => '2',
				'label'       => '2 ' . esc_html__( 'Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '3',
				'label'       => '3 ' . esc_html__( 'Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '4',
				'label'       => '4 ' . esc_html__( 'Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '5',
				'label'       => '5 ' . esc_html__( 'Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '6',
				'label'       => '6 ' . esc_html__( 'Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '7',
				'label'       => '7 ' . esc_html__( 'Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '8',
				'label'       => '8 ' . esc_html__( 'Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '9',
				'label'       => '9 ' . esc_html__( 'Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '10',
				'label'       => '10 ' . esc_html__( 'Columns', 'shopkit' ),
				'src'         => ''
			)
			)
		);

		$settings['settings']['wc_single_image_size'] = array(
			'id'          => 'wc_single_image_size',
			'label'       => esc_html__( 'Single Product Image Size', 'shopkit' ),
			'desc'        => esc_html__( 'Set the single product page image size.', 'shopkit' ),
			'std'         => '2',
			'type'        => 'select',
			'section'     => 'woocommerce-product',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => '2',
				'label'       => esc_html__( '50% Width', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '3',
				'label'       => esc_html__( '33% Width', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '4',
				'label'       => esc_html__( '25% Width', 'shopkit' ),
				'src'         => ''
			)
			)
		);

		$settings['settings']['wc_upsell_columns'] = array(
			'id'          => 'wc_upsell_columns',
			'label'       => esc_html__( 'Upsell Product Columns', 'shopkit' ),
			'desc'        => esc_html__( 'Set the upsell product columns.', 'shopkit' ),
			'std'         => '4',
			'type'        => 'select',
			'section'     => 'woocommerce-product',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => '1',
				'label'       => '1 ' . esc_html__( 'Product Column', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '2',
				'label'       => '2 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '3',
				'label'       => '3 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '4',
				'label'       => '4 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '5',
				'label'       => '5 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '6',
				'label'       => '6 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '7',
				'label'       => '7 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '8',
				'label'       => '8 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			)
			)
		);

		$settings['settings']['wc_related_columns'] = array(
			'id'          => 'wc_related_columns',
			'label'       => esc_html__( 'Related Product Columns', 'shopkit' ),
			'desc'        => esc_html__( 'Set the related product columns.', 'shopkit' ),
			'std'         => '4',
			'type'        => 'select',
			'section'     => 'woocommerce-product',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => array( 
			array(
				'value'       => '1',
				'label'       => '1 ' . esc_html__( 'Product Column', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '2',
				'label'       => '2 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '3',
				'label'       => '3 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '4',
				'label'       => '4 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '5',
				'label'       => '5 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '6',
				'label'       => '6 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '7',
				'label'       => '7 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			),
			array(
				'value'       => '8',
				'label'       => '8 ' . esc_html__( 'Product Columns', 'shopkit' ),
				'src'         => ''
			)
			)
		);

		$settings['settings']['wc_product_sidebars'] = array(
			'id'          => 'wc_product_sidebars',
			'label'       => esc_html__( 'Disable Sidebars on Products', 'shopkit' ),
			'desc'        => esc_html__( 'Hide sidebars from single product pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-product',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and',
			'choices'     => ''
		);

		$settings['settings']['wc_single_rating'] = array(
			'id'          => 'wc_single_rating',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Rating', 'shopkit' ),
			'desc'        => esc_html__( 'Hide rating from single product pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-product',
		);

		$settings['settings']['wc_single_price'] = array(
			'id'          => 'wc_single_price',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Price', 'shopkit' ),
			'desc'        => esc_html__( 'Hide price from single product pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-product',
		);

		$settings['settings']['wc_single_desc'] = array(
			'id'          => 'wc_single_desc',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Description', 'shopkit' ),
			'desc'        => esc_html__( 'Hide description from single product pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-product',
		);

		$settings['settings']['wc_single_add_to_cart'] = array(
			'id'          => 'wc_single_add_to_cart',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Add to Cart', 'shopkit' ),
			'desc'        => esc_html__( 'Hide add to cart from single product pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-product',
		);

		$settings['settings']['wc_single_meta'] = array(
			'id'          => 'wc_single_meta',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Meta', 'shopkit' ),
			'desc'        => esc_html__( 'Hide product meta from single product pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-product',
		);

		$settings['settings']['wc_single_upsells'] = array(
			'id'          => 'wc_single_upsells',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Up-Sells', 'shopkit' ),
			'desc'        => esc_html__( 'Hide product up-sells from single product pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-product',
		);

		$settings['settings']['wc_product_tabs'] = array(
			'id'          => 'wc_product_tabs',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Tabs', 'shopkit' ),
			'desc'        => esc_html__( 'Hide tabs from single product pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-product',
		);

		$settings['settings']['wc_single_related'] = array(
			'id'          => 'wc_single_related',
			'label'       => esc_html__( 'Hide', 'shopkit') . ' ' . esc_html__( 'Product Related', 'shopkit' ),
			'desc'        => esc_html__( 'Hide related products from single product pages.', 'shopkit' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'woocommerce-product',
		);

		return $settings;

	}

}

add_action( 'init', array( 'ShopKit_WooCommerce_Settings', 'init' ), 2 );


?>