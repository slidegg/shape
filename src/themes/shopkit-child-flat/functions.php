<?php
//
// // Hi! Start coding below!
//
require_once __DIR__ . '/functions/checkout/fields.php';
require_once __DIR__ . '/functions/checkout/order_meta.php';
require_once __DIR__ . '/functions/checkout/layout.php';
require_once __DIR__ . '/functions/_compat.php';
require_once __DIR__ . '/functions/archive.php';
require_once __DIR__ . '/functions/assets.php';
require_once __DIR__ . '/functions/menu.php';

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
 * Add voucher ID to order management - shipping method and mail
 */
include 'functions/voucher_field.php';

/**
 * Add scripts
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('livequery', get_stylesheet_directory_uri() . '/src/js/vendor/jquery.livequery.min.js');
    wp_enqueue_script('sticky-kit', get_stylesheet_directory_uri() . '/src/js/vendor/sticky-kit.min.js');
    wp_enqueue_script('gg7', get_stylesheet_directory_uri() . '/assets/gg7.js');
    wp_enqueue_script('webslidemenu', get_stylesheet_directory_uri() . '/assets/webslide-flyout/webslidemenu/webslidemenu.js');
});

/**
 * ORDER STATUS ON HOLD FOR ANTIKATAVOLI
 */
add_filter('woocommerce_cod_process_payment_order_status', static function ($status, $order) {
    /** @var WC_Order $order */
    return 'on-hold';
}, 10, 2);

/**
 * Adds SKUs to WooCommerce order emails
 */
add_filter('woocommerce_email_order_items_args', static function ($args) {
    return array_replace($args, [
        'show_sku' => false,
        'show_image' => true,
    ]);
});
