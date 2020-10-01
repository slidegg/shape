<?php

$order_metas = [
    'billing_company_subject' => __('Δραστηριότητα', 'woocommerce'),
    'billing_vat_id' => __('ΑΦΜ', 'woocommerce'),
    'billing_tax_authority' => __('ΔΟΥ', 'woocommerce'),
];

// add order meta
add_action('woocommerce_checkout_update_order_meta', function ($order_id) use ($order_metas) {
    $session = wc()->session;
    foreach ($order_metas as $meta => $meta_title) {
        if ($value = filter_input(INPUT_POST, $meta)) {
            if ($session->get('document_type') !== 'invoice') {
                $value = null;
            }
            update_post_meta($order_id, "_{$meta}", $value);
        }
    }
});

// invoice meta in e-mail new greg
add_filter('woocommerce_email_order_meta_keys', function ($keys) use ($order_metas) {
    return $keys + array_flip($order_metas);
});

add_filter('woocommerce_formatted_address_replacements', function ($replacements, $args) use ($order_metas) {
    $ret = [];
    foreach ($replacements as $k => $v) {
        $ret[$k] = $v;
        if ($k === '{company}') {
            foreach ($order_metas as $key => $label) {
                $ret["{{$key}}"] = $args[$key] ?? '';
            }
        }
    }
    return $ret;
}, 10, 2);

add_filter('woocommerce_get_order_address', function ($data, $type, $order) use ($order_metas) {
    /** @var WC_Order $order */
    if ($type === 'billing') {
        foreach ($order_metas as $key => $label) {
            $data[$key] = get_post_meta($order->get_id(), "_{$key}", true);
        }
    }
    return $data;
}, 10, 3);

add_filter('woocommerce_localisation_address_formats', function ($formats) use ($order_metas) {
    $str = implode("\n", array_map(function ($k) { return "{{$k}}"; }, array_keys($order_metas)));
    foreach ($formats as &$format) {
        $format = strtr($format, [
            "{company}\n" => "{company}\n{$str}\n",
        ]);
    }
    return $formats;
}, 10, 1);

//Show SKU on cart and checkout page
// add_filter('woocommerce_cart_item_name', 'showing_sku_in_cart_items', 99, 3);
// function showing_sku_in_cart_items($item_name, $cart_item, $cart_item_key)
// {
//     // The WC_Product object
//     $product = $cart_item['data'];
//     // Get the  SKU
//     $sku = $product->get_sku();
//
//     // When sku doesn't exist
//     if (empty($sku)) {
//         return $item_name;
//     }
//
//     // Add the sku
//     $item_name .= '<br><small class="product-sku">' . __("SKU: ", "woocommerce") . $sku . '</small>';
//
//     return $item_name;
// }

\add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
    if ($product = $cart_item['data'] ?? null) {
        /** @var WC_Product $product */
        return \array_replace([
            'sku' => [
                'key' => 'Κωδικός',
                'value' => $product->get_sku(),
            ],
        ], $item_data);
    }
    return $item_data;
}, 11, 2);
