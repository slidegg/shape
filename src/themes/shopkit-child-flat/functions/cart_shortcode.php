<?php
/**
 * Cart shortcode plugin rippof
 * https://github.com/prontotools/woocommerce-cart-count-shortcode
 *
 * USAGE EXAMPLES:
 *
 * [cart_button]
 * [cart_button icon="basket"]
 * [cart_button show_items="true"]
 * [cart_button show_items="true" show_total="true"]
 * [cart_button show_items="true" show_total="true" total_text="Total Price:"]
 * [cart_button show_items="false" items_in_cart_text="Cart"]
 * [cart_button show_items="true" empty_cart_text="Store"]
 * [cart_button items_in_cart_text="Cart" custom_css="custom"]
 */

add_shortcode("cart_button", function ($atts) {
    $defaults = [
        "icon" => "cart",
        "empty_cart_text" => "",
        "items_in_cart_text" => "",
        "show_items" => "",
        "show_total" => "",
        "total_text" => "",
        "custom_css" => "",
    ];

    $atts = shortcode_atts($defaults, $atts);

    $icon_html = "";
    if ($atts["icon"]) {
        if ("cart" == $atts["icon"]) {
            $icon_html = '<i class="fa fa-shopping-cart"></i> ';
        } elseif ($atts["icon"] == "basket") {
            $icon_html = '<i class="fa fa-shopping-basket"></i> ';
        } else {
            $icon_html = '<i class="fa fa-' . $atts["icon"] . '"></i> ';
        }
    }
    $icon_html = apply_filters('wccs_cart_icon_html', $icon_html, $atts["icon"]);

    $cart_count = "";
    if (class_exists("WooCommerce")) {
        $cart_count = WC()->cart->get_cart_contents_count();
        $cart_total = WC()->cart->get_cart_total();
//        $cart_url = WC()->cart->get_cart_url();  ORIGINAL LINE
        $cart_url = '#';
//        $shop_url = wc_get_page_permalink("shop"); ORIGINAL LINE
        $shop_url = '#';

        $cart_count_html = "";
        if ("true" == $atts["show_items"]) {
//            $cart_count_html = " (" . $cart_count . ")";  /ORIGINAL LINE
            $cart_count_html = $cart_count;
        }
        $cart_count_html = apply_filters('wccs_cart_count_html', '<span class="xoo-wsc-items-count" style="opacity: 1;">' . $cart_count_html . '</span>', $cart_count);

        $cart_total_html = "";
        if ("true" == $atts["show_total"]) {
            if ($atts["total_text"]) {
                $cart_total_html = " " . $atts["total_text"] . " " . $cart_total;
            } else {
                $cart_total_html = " Total: " . $cart_total;
            }
        }
        $cart_total_html = apply_filters('wccs_cart_total_html', $cart_total_html, $cart_total);

        $cart_text_html = "";
        $link_to_page = "";
        if ($cart_count > 0) {
            if ("" != $atts["items_in_cart_text"]) {
                $cart_text_html = $atts["items_in_cart_text"];
            }
                        $link_to_page = ' href="' . $cart_url . '"';
        } else {
            if ("" != $atts["empty_cart_text"]) {
                $cart_text_html = $atts["empty_cart_text"];
            }
            $link_to_page = ' href="' . $shop_url . '"';
        }
    }

    $custom_css = "";
    if ($atts["custom_css"]) {
        $custom_css = ' class="' . $atts["custom_css"] . '"';
    }

    $html = "<a" . $link_to_page . $custom_css . ">";
    $html .= $icon_html . $cart_text_html . '(' . $cart_count_html . ')' . $cart_total_html;
    $html .= "</a>";

    return $html;
});
