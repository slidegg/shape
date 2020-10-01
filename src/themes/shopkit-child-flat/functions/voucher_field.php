<?php
/**
 * Add custom editable field to Order Meta for Shipping Voucher ID input
 * field: erp_shipping_voucher
 * https://wordpress.stackexchange.com/questions/215219/how-to-display-custom-field-in-woocommerce-orders-in-admin-panel
 * https://stackoverflow.com/questions/51718424/custom-editable-field-in-woocommerce-admin-edit-order-pages-general-section
 */
// Save the custom editable field value as order meta data and update order item meta data
add_action('woocommerce_process_shop_order_meta', static function ($post_id, $post) {
    if (isset($_POST['erp_shipping_voucher'])) {
        // Save "voucher id" as order meta data
        update_post_meta($post_id, 'erp_shipping_voucher', sanitize_text_field($_POST['erp_shipping_voucher']));

        // Create dispached email voucher and dispached date mail meta for using ii in gg7 mu plugin for email automation later
        update_post_meta($post_id, 'email_dispached_voucher', null);

        // Update the existing "voucher ID" item meta data
        if (isset($_POST['erp_shipping_voucher'])) {
            wc_update_order_item_meta($_POST['erp_shipping_voucher'], 'erp_shipping_voucher', $_POST['erp_shipping_voucher']);
        }
    }
}, 12, 2);

//Display field value on the order edit page
add_action('woocommerce_admin_order_data_after_order_details', function ($order) {
    woocommerce_wp_text_input([
        'id' => 'erp_shipping_voucher',
        'label' => __("Shippping Voucher:", "woocommerce"),
        'value' => get_post_meta($order->get_id(), 'erp_shipping_voucher', true),
        'wrapper_class' => 'form-field-wide',
    ]);
}, 10, 1);


/**
 * add voucher link to shipping method Woocommerce
 * "Σελίδα ανακτησης αποστολής"
 */
add_action('woocommerce_init', static function () {
    //
    // shipping method form fields
    //
    foreach (wc()->shipping()->get_shipping_methods() as $shipping_method) {
        /** @var WC_Shipping_Method $shipping_method */
        $slug = $shipping_method->id;
        add_filter("woocommerce_shipping_instance_form_fields_{$slug}", static function ($fields) {
            $ret = [
                'tracking_url' => shippingMethodTrackingUrlInput(),
            ];

            return $ret + $fields;
        });
    }
});

function shippingMethodTrackingUrlInput()
{
    return [
        'title' => __('Tracking URL', 'unh'),
        'type' => 'text',
        'description' => __('URL of the page where the user can track the progress of the shipment.', 'unh'),
        'default' => '',
        'desc_tip' => true,
    ];
}