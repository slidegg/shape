<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class ShopKit_WooCommerce {

	public static $settings;

	public static function init() {
		$class = __CLASS__;
		new $class;
	}

	function __construct() {

		add_action( 'woocommerce_before_shop_loop_item_title', __CLASS__ . '::get_loop_image_start', 9 );
		add_action( 'woocommerce_before_shop_loop_item_title', __CLASS__ . '::get_loop_image_end', 11 );

		self::$settings['image_effect'] = ShopKit_Ot_Settings::get_settings( 'general', 'wc_image_effect', 'none' );
		self::$settings['add_image_filter'] = false;

		add_filter( 'woocommerce_product_get_image', __CLASS__ . '::add_loop_image_effect_350', 10, 5 );

		add_filter( 'woocommerce_pagination_args', __CLASS__ . '::add_pagination_args', 10, 1 );

		add_action( 'wp_ajax_nopriv_shopkit_quickview', __CLASS__ . '::shopkit_quickview' );
		add_action( 'wp_ajax_shopkit_quickview', __CLASS__ . '::shopkit_quickview' );

		add_filter( 'woocommerce_add_to_cart_fragments', __CLASS__ . '::shopkit_woocommerce_header_add_to_cart_fragment');

		add_action( 'pre_get_posts', __CLASS__ . '::extend_product_search' );

		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

		add_filter( 'woocommerce_enqueue_styles', __CLASS__ . '::dequeue_styles' );

		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		add_filter( 'woocommerce_output_related_products_args', __CLASS__ . '::set_related_per_page' );

		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		add_filter( 'woocommerce_up_sells_columns', __CLASS__ . '::set_upsells_per_page' );
		add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 5 );

		$curr = ShopKit_Ot_Settings::get_settings( 'general', 'wc_orderby', 'shopkit-orderby-bc' );
		if ( $curr == 'shopkit-orderby-bcs' ) {
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count' , 20 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering' , 30 );

			add_action( 'shopkit_before_content', __CLASS__ . '::get_order_by' , 5 );
		}

		add_action( 'woocommerce_before_shop_loop_item_title', __CLASS__ . '::loop_thumbnail', 10 );
		add_filter( 'single_product_small_thumbnail_size', __CLASS__ . '::category_thumbnail' );

		add_filter( 'woocommerce_product_thumbnails_columns', __CLASS__ . '::thumbnails_columns' );
		add_action( 'init', __CLASS__ . '::set_visible_elements', 2000 );
		add_action( 'wp', __CLASS__ . '::set_product_sidebars' );

		add_action( 'add_meta_boxes' , __CLASS__ . '::remove_shop_metabox', 50 );

		add_filter( 'get_product_search_form' , __CLASS__ . '::get_product_search_form', 50 );

		add_filter( 'shopkit_javascript' , __CLASS__ . '::add_quickview' );
		add_action( 'woocommerce_archive_description', __CLASS__ . '::add_shop_desc', 9 );

	}

	public static function get_asset_url( $path ) {
		return str_replace( array( 'http:', 'https:' ), '', plugins_url( $path, WC_PLUGIN_FILE ) );
	}

	public static function add_shop_desc() {
		if ( is_shop() ) {
			if ( ( $desc = get_post_meta( get_option( 'woocommerce_shop_page_id' ), '_shopkit_short_description', true ) ) !== '' ) {
?>
			<p class="term-description"><?php echo esc_html( $desc ); ?></p>
<?php
			}
		}
	}

	public static function add_quickview( $args ) {

		$args['quickview'] = array(
			'src'     => self::get_asset_url( 'assets/js/frontend/add-to-cart-variation.js' ),
			'version' => WC_VERSION
		);

		$args['add_to_cart_variation'] = array(
			'wc_ajax_url'                      => WC_AJAX::get_endpoint( "%%endpoint%%" ),
			'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'shopkit' ),
			'i18n_make_a_selection_text'       => esc_attr__( 'Please select some product options before adding this product to your cart.', 'shopkit' ),
			'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'shopkit' ),
		);

		return $args;

	}

	public static function get_product_search_form() {

		ShopKit::$settings['woo-search'] = true;

		ob_start();

?>
		<div class="shopkit-search-wrapper">
			<div class="shopkit-search-form-wrapper">
				<?php get_search_form(); ?>
			</div>
		</div>
<?php
		unset( ShopKit::$settings['woo-search'] );
		unset( ShopKit::$settings['search-icon'] );

		return ob_get_clean();

	}

	public static function extend_product_search( $query ) {

		if ( is_search() ) {
			add_filter( 'posts_join', __CLASS__ . '::extend_product_search_join' );
			add_filter( 'posts_where', __CLASS__ . '::extend_product_search_where' );
		}

	}

	public static function extend_product_search_join( $join = '' ) {

		global $wp_the_query, $wpdb;

		if ( empty( $wp_the_query->query_vars['wc_query'] ) || empty( $wp_the_query->query_vars['s'] ) ) {
			return $join;
		}

		$join .= "INNER JOIN $wpdb->postmeta AS shopkit ON ($wpdb->posts.ID = shopkit.post_id)";
		return $join;

	}

	public static function extend_product_search_where( $where = '' ) {

		global $wp_the_query;

		if ( empty( $wp_the_query->query_vars['wc_query'] ) || empty( $wp_the_query->query_vars['s'] ) ) {
			return $where;
		}

		$where = preg_replace("/post_title LIKE ('%[^%]+%')/", "post_title LIKE $1) 
		OR (post_content LIKE $1)
		OR (shopkit.meta_key = '_sku' AND CAST(shopkit.meta_value AS CHAR) LIKE $1 ", $where);

		return $where;

	}

	public static function add_pagination_args( $args ) {

		$args['prev_text'] = esc_html__( 'Prev', 'shopkit' );
		$args['next_text'] = esc_html__( 'Next', 'shopkit' );
		$args['end_size'] = 2;
		$args['mid_size'] = 2;

		return $args;

	}

	public static function add_loop_image_effect_350( $image, $product, $size, $attr, $placeholder ) {

		if ( self::$settings['add_image_filter'] === false ) {
			return $image;
		}

		if ( !in_array( self::$settings['image_effect'], array( 'flip-horizontal', 'flip-vertical', 'zoom-fade', 'fade', 'zoom-fade-force', 'fade-force' ) ) ) {
			return $image;
		}

		$attachment_ids = method_exists( $product, 'get_gallery_image_ids' ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();

		if ( $attachment_ids && isset( $attachment_ids[0] ) ) {
			$attachment_img = wp_get_attachment_image_src( $attachment_ids[0], $size );
			self::$settings['add_image_css'] = '<span class="shopkit-woo-bg" data-url="' . esc_url( $attachment_img[0] ) . '"></span>';
		}

		return $image;

	}

	public static function get_loop_image_start() {

		self::$settings['add_image_filter'] = true;
?>
		<div class="shopkit-loop-image">
			<div class="shopkit-loop-image-inner">
<?php
	}

	public static function get_loop_image_end() {

		if ( isset( self::$settings['add_image_css'] ) ) {
			echo self::$settings['add_image_css'];
		}
		self::$settings['add_image_filter'] = false;
		self::$settings['add_image_css'] = null;
?>
			</div>
<?php
		printf( '<span data-quickview-id="%s" class="shopkit-quickview-button"></span>',
			intval( get_the_ID() )
		);
?>
		</div>
<?php
	}

	public static function check_ajax() {

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			die( esc_html__( 'AJAX Error!', 'shopkit' ) );
			exit;
		}

	}

	public static function get_product_image() {

		global $post;
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
		$thumbnail_post    = get_post( $post_thumbnail_id );
		$image_title       = $thumbnail_post->post_content;
		$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
	?>
		<div class="shopkit-quickview-figure">
			<figure class="woocommerce-product-gallery__wrapper">
			<?php
				$attributes = array(
					'title'                   => $image_title,
					'data-src'                => $full_size_image[0],
					'data-large_image'        => $full_size_image[0],
					'data-large_image_width'  => $full_size_image[1],
					'data-large_image_height' => $full_size_image[2],
				);

				if ( has_post_thumbnail() ) {
					$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="images">';
					$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
					$html .= '</div>';
				} else {
					$html  = '<div class="shopkit-quickview-image-placeholder images">';
					$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'shopkit' ) );
					$html .= '</div>';
				}

				echo apply_filters( 'shopkit_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );
			?>
			</figure>
		</div>
	<?php

	}

	public static function shopkit_quickview() {

		$out = '';

		if ( isset( $_POST['product_id'] ) ) {
			$curr_id = intval( $_POST['product_id'] );

			global $post, $post_id, $product, $withcomments;

			$withcomments = true;
			$post_id = $curr_id;

			$post = get_post( $curr_id );

			if ( $post ) {
				setup_postdata( $post );
			}

			$product = wc_get_product( $curr_id );

			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			add_action( 'woocommerce_before_single_product_summary', __CLASS__ . '::get_product_image', 20 );
			add_filter( 'woocommerce_short_description', __CLASS__ . '::strip_shortcodes', 0 );

			ob_start();
			wc_get_template( 'single-product/add-to-cart/variation.php' );
			wc_get_template( 'content-single-product.php' );
			$out = '<div class="shopkit-quickview"><a href="javascript:void(0)" class="shopkit-quickview-close"><span class="shopkit-quickview-close-button">' . esc_html__( 'Click to close product quick view!', 'shopkit' ) . '</span></a><div class="shopkit-quickview-inner single product woocommerce">' . ob_get_clean() . '</div></div>';
		}

		die( $out );
		exit;

	}

	public static function strip_shortcodes( $string ) {
		return strip_shortcodes( $string );
	}

	public static function get_cart_element() {

		global $woocommerce;

		$cart = $woocommerce->cart->get_cart();
		$cart_total = count( $cart );
		$cart_contents = $woocommerce->cart->cart_contents_count;

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
?>
			<a class="shopkit-cart-icon <?php echo isset( ShopKit::$settings['woo-cart-icon'] ) && in_array( ShopKit::$settings['woo-cart-icon'], array( 'text', 'button' ) ) ? ShopKit::$settings['woo-cart-icon'] : 'icon' ; ?>" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html_e( 'View shopping cart!', 'shopkit' ); ?>">
<?php			
			if ( isset( ShopKit::$settings['woo-cart-icon'] ) && strpos( ShopKit::$settings['woo-cart-icon'], 'icon' ) !== false ) {
				echo ShopKit_Icons::get_icon( ShopKit::$settings['woo-cart-icon'], 'cart' ) . '<span>' . esc_html( $cart_contents ) . '</span>';
			}
			else {
				echo esc_html__( 'Cart', 'shopkit' ) . '<span>' . esc_html( $cart_contents ) . '</span>';
			}
?>
			</a>
<?php
		}
?>
	<div class="shopkit-cart-wrapper">
		<div class="shopkit-cart shopkit-not-active">
			<div class="shopkit-cart-items-wrapper">
				<div class="shopkit-cart-item shopkit-cart-summary<?php echo ( $cart_total == 0 ? ' shopkit-cart-empty' : '' ); ?>">
					<div class="shopkit-centered-wrapper">
						<div class="shopkit-centered-wrapper-inner">
							<a href="<?php echo ( $cart_total == 0 ? esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) : esc_url( wc_get_checkout_url() ) ); ?>" class="shopkit-centered-wrapper-content">
<?php
							if ( $cart_total == 0 ) {
?>
								<span class="shopkit-summary-empty">
									<?php esc_html_e( 'Cart is empty. Add some products in the Shop!','shopkit'); ?>
								</span>
<?php
							}
							else {
?>
								<span class="shopkit-summary-total">
									<?php
										if ( !WC()->cart->prices_include_tax ) {
											echo WC()->cart->cart_contents_total;
										} else {
											echo WC()->cart->cart_contents_total + WC()->cart->tax_total;
										}
									?>
								</span>
								<span class="shopkit-summary-checkout">
									<?php esc_html_e( 'Go to Checkout!','shopkit' ); ?>
								</span>
								<span class="shopkit-summary-items">
									<?php echo esc_html( $cart_contents ); ?>
								</span>
<?php
							}
?>
							</a>
						</div>
					</div>
				</div>
<?php
				if ( $cart_total > 0 ) {

					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
?>
							<div class = "shopkit-cart-item">
								<div class="shopkit-cart-item-thumbnail">
<?php
										$img_size = apply_filters( 'shopkit_cart_element_image_size', 'medium' );

										if ( ! $_product->is_visible() ) {
											echo wp_kses_post( $_product->get_image( $img_size ) );
										}
										else {
											echo sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_image( $img_size ) );
										}
?>
								</div>

								<div class="shopkit-cart-item-summary">
<?php
										$name = method_exists( $_product, 'get_name' ) ? $_product->get_name() : $_product->name;

										if ( ! $product_permalink ) {
											echo esc_html( $name ) . '&nbsp;';
										}
										else {
											echo '<a href="' . esc_url( $product_permalink ) .'" class="shopkit-cart-item-title">' . esc_html( $name ) . '</a>';
										}

										$product_quantity = ' X ' . esc_attr( $cart_item['quantity'] ) . ' ';

										echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );

										if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
											echo '<span class="shopkit-cart-item-notification">' . esc_html__( 'Available on backorder', 'shopkit' ) . '</span>';
										}

										echo apply_filters( 'woocommerce_cart_item_subtotal', $woocommerce->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );

										if ( function_exists( 'wc_get_formatted_cart_item_data' ) ) {
											echo wc_get_formatted_cart_item_data( $cart_item );
										}
										else {
											echo esc_html( $woocommerce->cart->get_item_data( $cart_item ) );
										}

									?>
								</div>
								<?php
									echo '<a href="' . ( function_exists( 'wc_get_cart_remove_url' ) ? wc_get_cart_remove_url( $cart_item_key ) : WC()->cart->get_remove_url( $cart_item_key ) ) . '" class="shopkit-cart-item-remove" title="' . esc_attr__( 'Remove this item', 'shopkit' ) . '">' .  ShopKit_Icons::get_icon( 'line-icon', 'close' ) . '</a>';
								?>

							</div>
<?php
						}
	 
					}

				}
?>
			</div>
			<a href="javascript:void(0)" class="shopkit-woo-cart-close"><span class="shopkit-woo-cart-close-button"><?php esc_html_e( 'Click to close the shopping cart!', 'shopkit' ); ?></span></a>
		</div>
	</div>
<?php
	}

	public static function shopkit_woocommerce_header_add_to_cart_fragment( $fragments ) {

		ob_start();
?>
			<?php self::get_cart_element(); ?>
<?php

		$fragments['.shopkit-cart-wrapper'] = ob_get_clean();
		
		return $fragments;
		
	}

	public static function remove_shop_metabox(  ) {
		global $post;

		if ( isset( $post->ID ) && $post->ID == wc_get_page_id( 'shop' ) ) {
			remove_meta_box( 'shopkit_page_meta', 'page', 'normal' );
		}
	}

	public static function the_excerpt( $charlength ) {

		$excerpt = get_the_excerpt();
		$charlength++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
	
			if ( $excut < 0 ) {
				echo wp_kses_post( mb_substr( $subex, 0, $excut ) );
			}
			else {
				echo wp_kses_post( $subex );
			}

			echo '[...]';
		}
		else {
			echo wp_kses_post( $excerpt );
		}

	}

	public static function add_description() {

		global $post;

		if ( !$post->post_excerpt ) {
			return;
		}

?>
		<div class="description">
			<?php self::the_excerpt( apply_filters( 'shopkit_product_loop_excerpt_length', 50 ) ); ?>
		</div>
<?php
	}

	public static function set_visible_elements() {

		$loop_elements = array();
		$settings = array(
			'title' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_shop_title', 'off' ),
			'rating' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_shop_rating', 'off' ),
			'price' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_shop_price', 'off' ),
			'description' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_shop_desc', 'on' ),
			'add_to_cart' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_shop_add_to_cart', 'off' )
		);

		foreach( $settings as $k => $v ) {
			if ( $v == 'on' ) {
				$loop_elements[] = $k;
			}
		}
		$loop_elements = apply_filters( 'shopkit_product_loop_elements', $loop_elements );

		$single_elements = array();
		$settings = array(
			'rating' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_single_rating', 'off' ),
			'price' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_single_price', 'off' ),
			'description' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_single_desc', 'off' ),
			'add_to_cart' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_single_add_to_cart', 'off' ),
			'meta' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_single_meta', 'off' ),
			'upsells' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_single_upsells', 'off' ),
			'tabs' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_product_tabs', 'off' ),
			'related' => ShopKit_Ot_Settings::get_settings( 'general', 'wc_single_related', 'off' )
		);

		foreach( $settings as $k => $v ) {
			if ( $v == 'on' ) {
				$single_elements[] = $k;
			}
		}
		$single_elements = apply_filters( 'shopkit_single_product_elements', $single_elements );

		if ( in_array( 'title', $loop_elements ) ) {
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		}
		if ( in_array( 'rating', $loop_elements ) ) {
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		}
		if ( in_array( 'price', $loop_elements ) ) {
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		}
		if ( !in_array( 'description', $loop_elements ) ) {
			add_action( 'woocommerce_shop_loop_item_title', __CLASS__ . '::add_description', 15 );
		}
		if ( in_array( 'add_to_cart', $loop_elements ) ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		}

		if ( in_array( 'rating', $single_elements ) ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		}
		if ( in_array( 'price', $single_elements ) ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		}
		if ( in_array( 'description', $single_elements ) ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		}
		if ( in_array( 'add_to_cart', $single_elements ) ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		}
		if ( in_array( 'meta', $single_elements ) ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		}
		if ( !in_array( 'upsells', $single_elements ) ) {
			add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 5 );
		}
		if ( in_array( 'tabs', $single_elements ) ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		}
		if ( in_array( 'related', $single_elements ) ) {
			remove_action( 'woocommerce_after_single_product_summary','woocommerce_output_related_products', 20 );
		}
	}

	public static function add_product_sidebar_class( $classes ) {

		$classes[] = 'shopkit-no-product-sidebar';

		return $classes;

	}

	public static function set_product_sidebars() {

		if ( is_product() ) {
			if ( ShopKit_Ot_Settings::get_settings( 'general', 'wc_product_sidebars', 'off' ) == 'on' ) {

				add_filter( 'body_class', __CLASS__ . '::add_product_sidebar_class' );

				remove_action( 'shopkit_sidebar_left', 'ShopKit::get_sidebar_left', 100 );
				remove_action( 'shopkit_sidebar_right', 'ShopKit::get_sidebar_right', 100 );

				//remove_action( 'shopkit_sidebar', 'ShopKit::get_sidebar', 100 );
			}
		}

	}

	public static function thumbnails_columns() {

		$set = intval( ShopKit_Ot_Settings::get_settings( 'general', 'wc_thumbnails_columns', '4' ) );

		return $set;

	}

	public static function category_thumbnail( $size ) {
		return 'shop_thumbnail';
	}

	public static function loop_thumbnail( $query ) {
		echo woocommerce_template_loop_product_thumbnail();
	}

	public static function set_upsells_per_page( $args ) {

		$set = intval( ShopKit_Ot_Settings::get_settings( 'general', 'wc_upsell_columns', '4' ) );

		$args['posts_per_page'] = $set;
		$args['columns'] = $set;

		return $args;

	}

	public static function set_related_per_page( $args ) {

		$set = intval( ShopKit_Ot_Settings::get_settings( 'general', 'wc_related_columns', '4' ) );

		$args['posts_per_page'] = $set;
		$args['columns'] = $set;

		return $args;

	}

	public static function dequeue_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-general'] );
		unset( $enqueue_styles['woocommerce-layout'] );
		unset( $enqueue_styles['woocommerce-smallscreen'] );
		return $enqueue_styles;
	}

	public static function get_order_by() {

		if ( !is_woocommerce() ) {
			return;
		}

		if ( is_single() ) {
			return;
		}

?>
		<section id="order_by" class="shopkit-order-by">
			<div class="shopkit-inner-wrapper">
			<?php
				woocommerce_result_count();
				woocommerce_catalog_ordering();

			?>
			</div>
		</section>
<?php
	}

}

add_action( 'init', array( 'ShopKit_WooCommerce', 'init' ), 3 );

?>