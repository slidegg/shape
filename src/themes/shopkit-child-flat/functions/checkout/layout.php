<?php

// add shipping/handling before order fees
// add_action('woocommerce_review_order_before_order_total', function () {
add_action('gg7_review_order_before_fees', function () {
    $cart = wc()->cart;
    if (($value = $cart->get_shipping_total() + $cart->get_shipping_tax()) > 0) {
        echo ''
            . '<tr class="fee">'
            . '<th>' . __('Μεταφορικά', 'woocommerce') . '</th>'
            . '<td>' . wc_price($value) . '</td>'
            . '</tr>';
    }
}, 0);

// remove tax summary from order total
add_filter('woocommerce_cart_totals_order_total_html', function ($value) {
    return preg_replace('#<small.*?</small>#', '', $value);
});

// add tax summary after cart total
add_action('woocommerce_review_order_after_order_total', function () {
    $cart = wc()->cart;
    $vat = 0;
    if (wc_tax_enabled() && $cart->display_prices_including_tax()) {
        $vat = $cart->get_taxes_total(true, true);
    }
    if ($vat) {
        echo ''
            . '<tr class="fee">'
            . '<th>' . __('Εκ της οποίας ΦΠΑ', 'woocommerce') . '</th>'
            . '<td>' . wc_price($vat) . '</td>'
            . '</tr>';
    }
});

// hide payment method from order review
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);

// show shipping/billing before customer details
add_action('woocommerce_checkout_before_customer_details', function () {
    echo '<div class="checkout-basics">';

    // shipping
    do_action('woocommerce_review_order_before_shipping');
    wc_cart_totals_shipping_html();
    do_action('woocommerce_review_order_after_shipping');

    // payment
    woocommerce_checkout_payment();

    // document type
    woocommerce_form_field('document_type', [
        'type' => 'select',
        'options' => [
            '' => '',
            'receipt' => __('Απόδειξη', 'woocommerce'),
            'invoice' => __('Τιμολόγιο', 'woocommerce'),
        ],
        // 'class' => ['vat-number-field form-row-wide'],
        'label' => __('Τύπος παραστατικού'),
    ], wc()->session->get('document_type'));

    echo '</div>';
}, 10);

// add_filter('woocommerce_available_payment_gateways', function ($gateways) {
//     $shipping_method = gg7_get_selected_shipping_method();
//     if ((!$shipping_method || $shipping_method === 'free_shipping:4') && isset($gateways['cod'])) {
//         unset($gateways['cod']);
//     }
//     return $gateways;
// });

// payment method section
add_action('woocommerce_review_order_before_payment', function () {
    echo '<label for="payment_method">Τρόπος πληρωμής</label>';
});

// strip cost from shipping method label
add_filter('woocommerce_cart_shipping_method_full_label', function ($label, $method) {
    /** @var WC_Shipping_Rate $method */
    return $method->get_label();
}, 10, 2);

add_filter('woocommerce_order_button_html', function ($html, $return = false) {
    return $return ? $html : '';
}, 10, 2);

remove_action('woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20);
remove_action('woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30);
remove_action('woocommerce_thankyou', 'woocommerce_order_details_table');

// add_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
// add_action( 'woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20 );
// add_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );
