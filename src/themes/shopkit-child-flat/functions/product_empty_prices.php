<?php

use yii1\models\wc\Product;

/**
 * products without price are non-purchasable
 */
add_filter('woocommerce_is_purchasable', function ($purchasable, $product) {
    $model = Product::instance($product);

    return !$model || !$model->getIsPurchasable() ? false : $purchasable;
}, 10, 2);

/**
 * hide add to cart for non-purchasable
 */
//add_filter('woocommerce_loop_add_to_cart_link', function ($html, $product, $c) {
//    /** @var WC_Product $product */
//    if (!$product->is_purchasable()) {
//        return '';
//    }
//
//    return $html;
//}, 999, 3);

/**
 * show placeholder for empty prices
 */
add_filter('woocommerce_get_price_html', function ($html, $product) {
    if (($model = Product::instance($product)) && $model->getPrice() <= 0) {
        return '<span class="woocommerce-Price-amount amount">&nbsp;</span>';
    }

    return $html;
}, 10, 2);
