<?php
/**
 * hide dashboard item, notices and notifications for non-admin users with css
 */

use yii1\framework\utils\FileHelper;

add_action('admin_head', function () {
    if (!current_user_can('administrator')) {
        echo '<style>
    .menu-icon-dashboard, .update-nag, #toplevel_page_unh-default-index, #postcustom, #mymetabox_revslider_0, #woocommerce-order-downloads, #advanced-sortables  {
    display: none;
    }
  </style>';
    }
});

/**
 * redirect orders managers to orders management page
 */
add_action('wp_login', static function ($user_login = null, $user = null) {
    /**
     * @var WP_User $user
     */
    $user = $user ?? wp_get_current_user();
    if (in_array('unh_manager', $user->roles, true)) {
        wp_redirect(esc_url(admin_url() . 'edit.php?post_type=shop_order'));
        exit();
    }
});

/**
 * Admin footer modification
 */
add_filter('admin_footer_text', function () {
    echo '<span id="footer-thankyou">Developed by <a href="http://www.unhooked.co" target="_blank">Unhooked</a></span>';
});

/**
 * Create Stock Quantity extra field in Admin Dash list
 * https://stackoverflow.com/questions/56428923/display-each-woocommerce-variations-stock-quantity-in-wp-admin-column
 */
// Display the data for this cutom column on admin product list
add_action('manage_product_posts_custom_column', static function ($column, $post_id) {
    if ($column === 'is_in_stock') {
        global $product;
        $gg7_array = get_object_vars(get_the_terms($post_id, 'gg7_stock_status')[0]);
        $gg7_stock = $gg7_array['name'];
        $qty = $product->get_stock_quantity($post_id);

        if ($qty === null) {
            echo "<p class='gg7_stock'>{$gg7_stock}</p>";
        } else {
            echo "<p class='gg7_stock'>{$gg7_stock} ({$qty})</p>";
        }

    }
}, 999, 2);