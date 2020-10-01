<?php

// add_action('woocommerce_init', function () {
//     /* @var WP_Query $wp_query */
//     global $wp_query;
//
//     // $wp_query->is_search()
// });

function woocommerce_page_title($echo = true)
{
    static $is_shop;
    static $is_tax;
    static $s;

    if ($is_shop === null) {
        $is_shop = is_shop();
    }
    if ($is_tax === null) {
        $is_tax = is_tax() && !$is_shop;
    }
    if ($s === null) {
        $s = false;
        if (is_search()) {
            $s = get_search_query();
        } else {
            foreach ($_REQUEST['pf_filters'] ?? [] as $filter) {
                if ($q = trim($filter['s'] ?? '')) {
                    $s = $q;
                }
            }
        }
    }

    $page_title = [];
    if ($is_tax) {
        $page_title[] = single_term_title('', false);
    }

    if ($s) {
        $search_title = sprintf(__('Search results: &ldquo;%s&rdquo;', 'woocommerce'), '<span class="search-title-term">' . $s . '</span>');

        // if (get_query_var('paged')) {
        //     /* translators: %s: page number */
        //     $search_title .= sprintf(__('&nbsp;&ndash; Page %s', 'woocommerce'), get_query_var('paged'));
        // }

        if (!empty($page_title)) {
            $target = $_SERVER['REQUEST_URI'];
            $target = explode('?', $target);
            $query = [];
            if ($target[1] ?? null) {
                parse_str($target[1], $query);
                unset($query['s']);
                $target[1] = build_query($query);
            }
            $target = implode('?', array_filter($target));

            $search_title = "<a class=\"search-title\" href=\"{$target}\">{$search_title}&nbsp;<i class=\"fa fa-times text-danger\"></i></a>";
        }

        $page_title[] = $search_title;
    } elseif (!$is_tax && $is_shop) {
        $shop_page_id = wc_get_page_id('shop');
        $page_title[] = get_the_title($shop_page_id);
    }

    $page_title = implode('<br>', $page_title);
    $page_title = apply_filters('woocommerce_page_title', $page_title);

    if ($echo) {
        echo $page_title; // WPCS: XSS ok.

        return '';
    }

    return $page_title;
}
