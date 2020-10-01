<?php

/**
 * remove "Μεταφορική πελάτη" for non b2b users
 */
add_filter('woocommerce_shipping_packages', function ($packages) {
    global $yii;
    if (!$yii->user->isB2b) {
        foreach ($packages as $i => $package) {
            foreach ($package['rates'] as $j => $rate) {
                /** @var WC_Shipping_Rate $rate */
                if ($rate->get_instance_id() === 8) {
                    unset($packages[$i]['rates'][$j]);
                }
            }
        }
    }
    return $packages;
});

$invoice_extra_fields = [
    'billing_company_subject' => [
        'label' => __('Δραστηριότητα', 'woocommerce'),
        'class' => ['form-row-wide', 'invoice-field', 'billing-field'],
        'autocomplete' => false,
        'priority' => 30,
        'required' => false,
    ],
    'billing_vat_id' => [
        'label' => __('ΑΦΜ', 'woocommerce'),
        'class' => ['form-row-wide', 'invoice-field', 'billing-field'],
        'autocomplete' => false,
        'priority' => 30,
        'required' => false,
    ],
    'billing_tax_authority' => [
        'label' => __('ΔΟΥ', 'woocommerce'),
        'class' => ['form-row-wide', 'invoice-field', 'billing-field'],
        'autocomplete' => false,
        'priority' => 30,
        'required' => false,
    ],
];
$checkout_fields = [
    'document_type' => false,
    'ship_to_different_address' => false,
    'billing_first_name' => true,
    'billing_last_name' => true,
    'billing_email' => true,
    'billing_phone' => true,
    'billing_company' => ['invoice'],
    'billing_company_subject' => ['invoice'],
    'billing_vat_id' => ['invoice'],
    'billing_tax_authority' => ['invoice'],
    'billing_address_1' => ['invoice', 'billing_address'],
    'billing_city' => ['invoice', 'billing_address'],
    'billing_postcode' => ['invoice', 'billing_address'],
    'shipping_first_name' => ['shipping_address'],
    'shipping_last_name' => ['shipping_address'],
    'shipping_email' => ['shipping_address'],
    'shipping_phone' => ['shipping_address'],
    'shipping_address_1' => ['shipping_address'],
    'shipping_city' => ['shipping_address'],
    'shipping_postcode' => ['shipping_address'],
    'account_password' => false,
    'order_comments' => false,
];
$checkout_field_selectors = [
    'invoice' => '.invoice-field, .address-field.billing-field',
    'billing_address' => '.billing-field.address-field, .woocommerce-shipping-fields',
    'shipping_address' => '.shipping-field',
];
$checkout_required_fields = null;

function gg7_get_selected_shipping_method()
{
    $session = wc()->session;
    $method = $session->get('chosen_shipping_methods');
    return is_array($method) ? reset($method) : '';
}

function gg7_get_selected_payment_method()
{
    $session = wc()->session;
    $method = $session->get('chosen_payment_method');
    return is_array($method) ? reset($method) : $method;
}

function gg7_shipping_method_is_local()
{
    $session = wc()->session;
    if (strpos(gg7_get_selected_shipping_method(), 'local_pickup') === 0) {
        $session->set('ship_to_different_address', null);
        return true;
    }
    return false;
}

function gg7_checkout_required_fields()
{
    global $checkout_fields;
    global $checkout_required_fields;

    if ($checkout_required_fields === null) {
        $session = wc()->session;
        $is_shipping_local = gg7_shipping_method_is_local();

        $scenarios = [
            'invoice' => $session->get('document_type') === 'invoice',
            'billing_address' => !$is_shipping_local,
            'shipping_address' => !$is_shipping_local && (bool)$session->get('ship_to_different_address'),
        ];
        $checkout_required_fields = [];
        foreach ($scenarios as $scenario => $active) {
            foreach ($checkout_fields as $checkout_field => $required) {
                $is_required = $required === true || ($checkout_required_fields[$checkout_field] ?? false);
                if (!$is_required && $active && is_array($required) && in_array($scenario, $required, true)) {
                    $is_required = true;
                }
                $checkout_required_fields[$checkout_field] = $is_required;
            }
        }
    }
    return $checkout_required_fields;
}

add_action('woocommerce_checkout_process', function () use ($checkout_fields, $invoice_extra_fields) {
    $session = wc()->session;
    foreach ($checkout_fields as $field => $required) {
        $session->set($field, filter_input(INPUT_POST, $field));
    }
    if (gg7_shipping_method_is_local()) {//fix
        foreach ($checkout_fields as $field => $required) {
            if (is_array($required) && in_array('shipping_address', $required, true)) {
                $session->set($field, null);
            }
        }
    }

    $shipping_method = gg7_get_selected_shipping_method();
    if (!$shipping_method || strpos($shipping_method, 'free_shipping:3') === 0) {
        wc_add_notice(__('Πρέπει να επιλέξετε τρόπο αποστολής'), 'error');
    }
    $payment_method = gg7_get_selected_payment_method();
    if (!$payment_method || strpos($payment_method, 'cheque') === 0) {
        wc_add_notice(__('Πρέπει να επιλέξετε τρόπο πληρωμής'), 'error');
    }
    if (!$session->get('document_type')) {
        wc_add_notice(__('Πρέπει να επιλέξετε τύπο παραστατικού'), 'error');
    }

    // $ship_to_different_address = (bool)filter_input(INPUT_POST, 'ship_to_different_address');
    // wc_add_notice(__(var_dumpp([
    //     gg7_get_selected_shipping_method(),
    //     gg7_get_selected_payment_method(),
    // ], true)), 'error');
});

add_action('woocommerce_new_order', function ($order_id) use ($invoice_extra_fields) {
    $order = wc_get_order($order_id);
    if (wc()->session->get('document_type') === 'receipt') {
        foreach (array_replace(['billing_company' => true], $invoice_extra_fields) as $field => $cnf) {
            $order->delete_meta_data($field);
            $order->delete_meta_data("_{$field}");
        }
        $order->save_meta_data();
    }
});

add_filter('woocommerce_billing_fields', function ($fields) use ($invoice_extra_fields) {
    // add invoice fields
    $invoice_fields = array_replace([
        'billing_company' => $fields['billing_company'],
    ], $invoice_extra_fields);
    unset($fields['billing_company']);

    // add invoice-field class
    $invoice_fields = array_map(function ($field) {
        $field['class'][] = 'invoice-field';
        return $field;
    }, $invoice_fields);

    // add billing-field class
    $fields = array_merge($invoice_fields, $fields);
    $fields = array_map(function ($field) {
        $field['class'][] = 'billing-field';
        return $field;
    }, $fields);

    // re-layout
    $fields['billing_email']['class'][array_search('form-row-wide', $fields['billing_email']['class'], true)] = 'form-row-first';
    $fields['billing_phone']['class'][array_search('form-row-wide', $fields['billing_phone']['class'], true)] = 'form-row-last';

    $fields['billing_company']['class'][array_search('form-row-wide', $fields['billing_company']['class'], true)] = 'form-row-first';
    $fields['billing_company_subject']['class'][array_search('form-row-wide', $fields['billing_company_subject']['class'], true)] = 'form-row-last';

    $fields['billing_vat_id']['class'][array_search('form-row-wide', $fields['billing_vat_id']['class'], true)] = 'form-row-first';
    $fields['billing_tax_authority']['class'][array_search('form-row-wide', $fields['billing_tax_authority']['class'], true)] = 'form-row-last';

    $fields['billing_city']['class'][array_search('form-row-wide', $fields['billing_city']['class'], true)] = 'form-row-first';
    $fields['billing_postcode']['class'][array_search('form-row-wide', $fields['billing_postcode']['class'], true)] = 'form-row-last';

    // reorder & return fields
    $ret = [];
    $priority = 10;
    foreach ([
                 'billing_first_name',
                 'billing_last_name',
                 'billing_email',
                 'billing_phone',

                 'billing_company',
                 'billing_company_subject',
                 'billing_vat_id',
                 'billing_tax_authority',

                 // 'billing_country',
                 'billing_address_1',
                 // 'billing_address_2',
                 'billing_city',
                 // 'billing_state',
                 'billing_postcode',
             ] as $field_name) {
        $ret[$field_name] = array_replace($fields[$field_name], [
            'priority' => $priority,
            'required' => false, //nothing is required by default, we validate this by hand
        ]);
        $priority += 10;
    }
    return $ret;
}, 10, 3);

add_filter('woocommerce_shipping_fields', function ($fields) {
    // add phone/email fields
    $fields = array_replace($fields, [
        // 'shipping_check' => [
        //     'label' => 'check',
        //     'required' => true,
        //     'type' => 'checkbox',
        //     'class' => ['form-row-wide', 'shipping-field'],
        //     'validate' => ['phone'],
        //     'autocomplete' => 'tel',
        //     'priority' => 100,
        // ],
        'shipping_phone' => [
            'label' => 'Τηλέφωνο',
            'required' => true,
            'type' => 'tel',
            'class' => ['form-row-wide'],
            'validate' => ['phone'],
            'autocomplete' => 'tel',
            'priority' => 100,
        ],
        'shipping_email' => [
            'label' => 'Διεύθυνση email',
            'required' => true,
            'type' => 'email',
            'class' => ['form-row-wide'],
            'validate' => ['email'],
            'autocomplete' => 'email username',
            'priority' => 110,
        ],
    ]);

    // re-layout
    $fields['shipping_email']['class'][array_search('form-row-wide', $fields['shipping_email']['class'], true)] = 'form-row-first';
    $fields['shipping_phone']['class'][array_search('form-row-wide', $fields['shipping_phone']['class'], true)] = 'form-row-last';

    $fields['shipping_city']['class'][array_search('form-row-wide', $fields['shipping_city']['class'], true)] = 'form-row-first';
    $fields['shipping_postcode']['class'][array_search('form-row-wide', $fields['shipping_postcode']['class'], true)] = 'form-row-last';

    // reorder & return fields
    $ret = [];
    $priority = 10;
    foreach ([
                 'shipping_first_name',
                 'shipping_last_name',
                 'shipping_email',
                 'shipping_phone',

                 // 'shipping_country',
                 'shipping_address_1',
                 // 'shipping_address_2',
                 'shipping_city',
                 // 'shipping_state',
                 'shipping_postcode',
             ] as $field_name) {
        $ret[$field_name] = array_replace($fields[$field_name], [
            'priority' => $priority,
            'required' => false, //nothing is required, we validate this by hand
        ]);
        $ret[$field_name]['class'][] = 'shipping-field';
        $priority += 10;
    }
    return $ret;
}, 10, 3);

add_filter('woocommerce_checkout_fields', function ($fields) {
    // print_rp($fields);
    // print_rp(var_export(array_map(function ($f) { return array_keys($f); }, $fields), true));

    $required_fields = gg7_checkout_required_fields();
    foreach ($fields as $group => $group_fields) {
        foreach ($group_fields as $field_name => $field_options) {
            if ($required_fields[$field_name] ?? false) {
                $fields[$group][$field_name]['required'] = true;
            } elseif (in_array($group, ['billing', 'shipping'], true)) {
                $fields[$group][$field_name]['class'][] = 'hidden';
            }
        }
    }
    return $fields;
}, 10, 3);

add_action('wp_footer', function () use ($checkout_field_selectors) {
    $checkout_field_selectors = json_encode($checkout_field_selectors);
    echo "<div class=\"hidden\" style=\"display: none !important;\" id=\"gg7-checkout-field-selectors\">{$checkout_field_selectors}</div>";
});
