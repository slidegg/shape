<?php

// Hi! Start coding below!

require_once __DIR__ . '/functions/checkout/fields.php';
require_once __DIR__ . '/functions/checkout/order_meta.php';
require_once __DIR__ . '/functions/checkout/layout.php';
require_once __DIR__ . '/functions/_compat.php';
require_once __DIR__ . '/functions/archive.php';
require_once __DIR__ . '/functions/assets.php';
require_once __DIR__ . '/functions/menu.php';
require_once __DIR__ . '/functions/product_empty_prices.php';
require_once __DIR__ . '/functions/shipping.php';

/**
 * Override Shopkit functions
 * Remove Replace USERNAME with EMAIL from login and register theme forms
 */
include 'functions/shopkit_Override.php';

/**
 * New cart Shortcode with items counter
 */
include 'functions/cart_shortcode.php';

/**
 * Add password repeat to default woocommerce register form
 */
include 'functions/password_repeat.php';

/**
 * Functions for admin dashboard changes
 */
include 'functions/admin_dashboard.php';

/**
 * Add voucher ID to order management - shipping method and mail
 */
include 'functions/voucher_field.php';

/**
 * Add scripts for checkout
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('livequery', get_stylesheet_directory_uri() . '/src/js/vendor/jquery.livequery.min.js');
    wp_enqueue_script('sticky-kit', get_stylesheet_directory_uri() . '/src/js/vendor/sticky-kit.min.js');
    // wp_enqueue_script('gg7', get_stylesheet_directory_uri() . '/assets/gg7.js');
//    wp_enqueue_script('webslidemenu', get_stylesheet_directory_uri() . '/assets/webslide-mobile-js/webslidemenu/webslidemenu.js');
    wp_enqueue_script('webslidemenu', get_stylesheet_directory_uri() . '/assets/webslide-flyout/webslidemenu/webslidemenu.js');
});

/**
 * hide stuff for non-admins
 */
if (!current_user_can('update_core') || !current_user_can('manage_options')) {
    // woocommerce menu
    add_action('admin_menu', static function () {
        remove_menu_page('woocommerce');
    });

    add_action('admin_bar_menu', static function ($admin_bar) {
        /** @var WP_Admin_Bar $admin_bar */
        // if (wc_current_user_has_role('custommanagerrole')) {
        $admin_bar->remove_node('wp-logo-external');
        $admin_bar->remove_node('wp-logo');
        $admin_bar->remove_node('about');
        $admin_bar->remove_node('new-content');
        if (current_user_can('edit_products')) {
            $admin_bar->add_node([
                'id' => 'products-admin',
                'title' => 'Προϊόντα',
                'href' => admin_url('/unh/products/index', 'https'),
                // 'href' => admin_url('edit.php?post_type=product', 'https'),
            ]);
        }
        if (current_user_can('edit_products')) {//fixme
            $admin_bar->add_node([
                'id' => 'users-admin',
                'title' => 'Χρήστες',
                'href' => admin_url('/unh/users/index', 'https'),
            ]);
        }
        // }
    }, 999);

    // hide wordpress notifications
    add_filter('pre_option_update_core', static function () {
        return null;
    });
    add_filter('pre_site_transient_update_core', static function () {
        return null;
    });
    add_filter('pre_site_transient_update_plugins', static function () {
        return null;
    });
    add_filter('pre_site_transient_update_themes', static function () {
        return null;
    });
    remove_action('load-update-core.php', 'wp_update_plugins');
    add_action('init', static function () {
        remove_action('init', 'wp_version_check');
    }, 2);
    add_action('admin_head', static function () {
        // remove_action('admin_notices', 'update_nag', 3);
        // remove_action('network_admin_notices', 'update_nag', 3);
        remove_all_actions('admin_notices');
    }, 1);
}


/**
 * checkout button next to update cart button
 */
add_action('woocommerce_cart_actions', static function () {
    echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="checkout-button button alt wc-forward" >' . __('Ολοκλήρωση Παραγγελίας', 'woocommerce') . '</a>';
});

/**
 * Hide category product count in product archives
 */
add_filter('woocommerce_subcategory_count_html', static function () {
    return false;
});

/**
 * ORDER STATUS ON HOLD FOR ANTIKATAVOLI
 */
add_filter('woocommerce_cod_process_payment_order_status', static function ($status, $order) {
    /** @var WC_Order $order */
    // $user_data = get_userdata($order->get_customer_id());

    // ekseresi stous admin xwris logo?    if (!in_array('administrator', $user_data->roles, true)) {
    return 'on-hold';

    //    }
    //     return $status;
}, 10, 2);

/**
 * Break Line for Sku Email
 */
add_filter('woocommerce_order_item_name', static function ($name, $item) {
    /** @var WC_Order_Item_Product $item */
    $product = $item->get_product();
    $sku = $product->get_sku();
    $status = StockStatus::get_stock_status_text($product);

    return implode('<br>', array_filter([
        $name,
        $sku ? "SKU: {$sku}" : null,
        $status ? "Διαθεσιμότητα: {$status}" : null,
    ]));
}, 10, 2);

/**
 * Show stock status in shop loop
 */
add_action('woocommerce_after_shop_loop_item_title', static function () {
    $post = get_post();
    echo StockStatus::get_stock_status_html($post, '');
}, 1);

/**
 * Adds SKUs to WooCommerce order emails
 */
add_filter('woocommerce_email_order_items_args', static function ($args) {
    return array_replace($args, [
        'show_sku' => false,
        'show_image' => true,
    ]);
});
// add_filter('wp_get_attachment_image_src', function ($image, $attachment_id, $size, $icon) {
add_filter('wp_get_attachment_image_src', static function ($image, $attachment_id, $size) {
    if (!is_file(ABSPATH . FileHelper::urlToRelativePath($image[0] ?? ''))) {
        $image[0] = wc_placeholder_img_src($size);
    }

    return $image;
}, 9999, 3);
