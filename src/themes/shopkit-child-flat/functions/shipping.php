<?php

use yii1\models\wc\Order;

add_action('woocommerce_init', function () {
    foreach (wc()->shipping()->get_shipping_methods() as $shipping_method) {
        /** @var \WC_Shipping_Method $shipping_method */
        $slug = $shipping_method->id;
        \add_filter("woocommerce_shipping_instance_form_fields_{$slug}", function ($fields) {
            $extra = [
                'extra_texts' => [
                    'title' => __('Texts', 'woocommerce'),
                    'type' => 'title',
                    'default' => '',
                    'description' => __('Informational texts displayed to customers during checkout and in e-mail messages.', 'woocommerce'),
                ],
                'text_checkout' => [
                    'title' => __('Checkout text', 'woocommerce'),
                    'placeholder' => __('Checkout text', 'woocommerce'),
                    'type' => 'textarea',
                    'default' => '',
                    'description' => '',
                ],
                'text_email' => [
                    'title' => __('E-mail text', 'woocommerce'),
                    'placeholder' => __('E-mail text', 'woocommerce'),
                    'type' => 'textarea',
                    'default' => '',
                    'description' => '',
                ],
            ];
            return $fields + $extra;
        });
    }
}, 11);

add_action('woocommerce_after_shipping_rate', function ($method, $index) {
    /** @var \WC_Shipping_Rate $method */
    /** @var int $index */
    if (!($shipping_method = \WC_Shipping_Zones::get_shipping_method($method->get_instance_id()))) {
        return;
    }
    if (trim(\strip_tags($text = $shipping_method->get_option('text_checkout')))) {
        echo '<p class="shipping-description">' . \tidy_repair_string(nl2br($text)) . '</p>';
    }
}, 10, 2);

add_action('woocommerce_email_before_order_table', function ($order, $sent_to_admin, $plain_text, $email) {
    $model = Order::instance($order);
    /** @var WC_Order $order */
    /** @var bool $sent_to_admin */
    /** @var bool $plain_text */
    /** @var bool $string */
    if ($model && $order->has_status(['processing', 'on-hold']) && ($shipping_method = $model->getShippingMethod())) {
        echo wpautop($shipping_method->get_option('text_email'));
    }
}, 9, 4);

add_filter('woocommerce_email_styles', function ($css) {
    $add = <<<CSS
.wc-bacs-bank-details-account-name { font-size: 16px; color: #666666; margin: 10px 0 0 0; }
.wc-bacs-bank-details { margin: 5px 0 10px 0; padding: 0 0 0 10px; }
.bacs_details .bank_name { display: none; }
.bacs_details .account_number { color: #666666; }
.bacs_details .sort_code { color: #666666; }
.bacs_details .iban { color: #666666; }
.bacs_details .bic { color: #666666; }
CSS;
    return "{$css}\n{$add}";
}, 10, 1);
