<?php
/**
 * auto add categories to wp menu DESKTOP
 */
add_filter('wp_nav_menu_items', static function ($items, $args) {
    if ($args->menu === 'categories') {

        $taxonomy = 'product_cat';
        $orderby = 'name';
        $show_count = 0;      // 1 for yes, 0 for no
        $pad_counts = 0;      // 1 for yes, 0 for no
        $hierarchical = 1;      // 1 for yes, 0 for no
        $title = '';
        $empty = 1;  // hide empty

        $args_woo = [
            'taxonomy' => $taxonomy,
            'orderby' => $orderby,
            'show_count' => $show_count,
            'pad_counts' => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li' => $title,
            'hide_empty' => $empty,
        ];

        $second_items = []; // define second_items
        $third_items = null;

        $all_categories = get_categories($args_woo);
        foreach ($all_categories as $cat) {
            if ($cat->category_parent === 0) {
                $category_id = $cat->term_id;

                $args2 = [
                    'taxonomy' => $taxonomy,
                    'child_of' => 0,
                    'parent' => $category_id,
                    'orderby' => $orderby,
                    'show_count' => $show_count,
                    'pad_counts' => $pad_counts,
                    'hierarchical' => $hierarchical,
                    'title_li' => $title,
                    'hide_empty' => $empty,
                ];
                $sub_cats = get_categories($args2);

                if ($sub_cats) {
                    foreach ($sub_cats as $sub_category) {
                        $second_items .= '<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="' . get_term_link($sub_category->slug, 'product_cat') . '">' . $sub_category->name . '</a>';

                        $args3 = [
                            'taxonomy' => $taxonomy,
                            'child_of' => $sub_category->id,
                            'parent' => $sub_category->term_id,
                            'orderby' => $orderby,
                            'show_count' => $show_count,
                            'pad_counts' => $pad_counts,
                            'hierarchical' => $hierarchical,
                            'title_li' => $title,
                            'hide_empty' => $empty,
                        ];
                        $sub_cats2 = get_categories($args3);

                        if ($sub_cats2) {
                            foreach ($sub_cats2 as $sub_category2) {
                                $third_items .= '<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="' . get_term_link($sub_category2->slug, 'product_cat') . '">' . $sub_category2->name . '</a></li>';
                            }
                        }
                        $second_items .= '<ul class="sub-menu">' . $third_items . '</ul></li>';
                        $third_items = null; // clear submenu for next
                    }
                }
                $items .= '<li class="menu-item"><a href="' . get_term_link($cat->slug, 'product_cat') . '">' . $cat->name . '</a><ul class="sub-menu">' . $second_items . '</ul>' . '</li>';
            }
            $second_items = null; // clear submenu for next
        }
        $items .= '<li class="menu-item"><a href="' . get_option( 'siteurl' ) . '/contact">Επικοινωνία</a></li>'; //add Contact page as last menu page of menu
    }

    return str_replace(array('ά','έ','ή','ί','ό','ύ','ώ'), array('α','ε','η','ι','ο','υ','ω'), $items ); //afairesi tonwn - Safari browser fix

}, 10, 2);


/**
 * MOBILE MENU
 * for Flyout menu use webslide-flyout asset folder and for mobile toggle menu use mobile-js folder
 * create wp-menu shortcode for menu categories
 * https://www.cozmoslabs.com/1170-wp_nav_menu-shortcode/
 * USAGE: [listmenu menu=categories menu_class=wsmenu-list] AND EXTRA CLASS "wsmenu clearfix" for only toggle and menu and "wsmobileheader clearfix" for flyout menu TO CONTAINER SHOPKIT.
 * ALSO FOR FLYOUT MENU instead of just shortcode paste this:
 * <div class="wsmobileheader clearfix "> <a id="wsnavtoggle" class="wsanimated-arrow"><span></span></a> <span class="smllogo"><a href="/"><img src="http://dev.redbuy.gr/wp-content/uploads/2019/10/redbuy-logo-v02-1.png" alt="RedBuy" width="100"></a></span></div></div></a></span></div> <div class="wsmainfull clearfix"> <div class="wsmainwp clearfix"> <div class="desktoplogo"><a href="#"><img src="images/sml-logo02.png" alt=""></a></div><nav class="wsmenu clearfix" style="height: 522px"><div class="overlapblackbg"></div>[listmenu menu=categories menu_class=wsmenu-list]</nav>
 */
function list_menu($atts, $content = null) {
    extract(shortcode_atts(array(
        'menu'            => '',
        'container'       => '',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => 'menu',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'depth'           => 0,
        'walker'          => '',
        'theme_location'  => ''),
        $atts));


    return wp_nav_menu( array(
        'menu'            => $menu,
        'container'       => $container,
        'container_class' => $container_class,
        'container_id'    => $container_id,
        'menu_class'      => $menu_class,
        'menu_id'         => $menu_id,
        'echo'            => false,
        'fallback_cb'     => $fallback_cb,
        'before'          => $before,
        'after'           => $after,
        'link_before'     => $link_before,
        'link_after'      => $link_after,
        'depth'           => $depth,
        'walker'          => $walker,
        'theme_location'  => $theme_location));
}
//Create the shortcode
add_shortcode("listmenu", "list_menu");
