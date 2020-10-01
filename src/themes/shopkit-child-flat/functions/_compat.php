<?php

add_action('init', static function () {
    global $wpdb;
    static $redirect;

    if (!$redirect) {
        $redirect = static function ($url) {
            header('HTTP/1.1 301 Moved Permanently');
            header("Location: {$url}");
            exit(0);
        };
    }

    $parts = explode('?', $_SERVER['REQUEST_URI']);

    $parts = array_map('trim', explode('/', $parts[0]));
    $parts = array_values(array_filter($parts));

    // not an old site url
    if (($parts[0] ?? '') !== 'eshop') {
        return null;
    }

    // remove /eshop/
    array_shift($parts);

    $url = null;

    // just /eshop/
    if (empty($parts)) {
        return $redirect(get_permalink(wc_get_page_id('shop')));
    }

    // old product page?
    $slug = array_reverse($parts);
    $slug = reset($slug);
    $slug = $wpdb->_real_escape($slug);

    $product_id_parts = explode(',', $slug);

    $product_id = null;

    if ($old_id = $product_id_parts[1] ?? null) {
        $product_id = $wpdb->get_var("select post_id from wp_postmeta where meta_key='old_id' and meta_value='{$old_id}' limit 0, 1");
    }

    if ($product_id === null && preg_match('/\.html/', $slug)) {
        $product_id = $wpdb->get_var("select post_id from wp_postmeta where meta_key='old_seo_link' and meta_value='{$slug}' limit 0, 1");
    }

    if ($product_id && ($product = wc_get_product($product_id)) && $product->is_visible() && ($url = get_permalink($product_id))) {
        return $redirect(get_permalink($product_id));
    }

    // todo old product image?
    // https://www.citisaid.com/eshop/image/ex/08876.jpg
}, 0);
