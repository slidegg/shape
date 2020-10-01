<?php

function shopkit_flat_general_settings( $custom_settings ) {

$custom_settings['settings']['logo_image']['std'] = esc_url( preg_replace( '(^https?:)', '', untrailingslashit( get_template_directory_uri() ) . '/demos/logo-flat.png' ) );

$custom_settings['settings']['logo_image_link']['std'] = '';

$custom_settings['settings']['site_title_font']['std'] = array (
  'font-color' => '',
  'font-family' => '',
  'font-size' => '20px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '20px',
  'text-decoration' => '',
  'text-transform' => 'none',
);

$custom_settings['settings']['site_description_font']['std'] = array (
  'font-color' => '',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '400',
  'letter-spacing' => '0em',
  'line-height' => '20px',
  'text-decoration' => '',
  'text-transform' => 'none',
);

$custom_settings['settings']['favorites_icon']['std'] = '';

$custom_settings['settings']['favorites_ipad57']['std'] = '';

$custom_settings['settings']['favorites_ipad72']['std'] = '';

$custom_settings['settings']['favorites_ipad114']['std'] = '';

$custom_settings['settings']['favorites_ipad144']['std'] = '';

$custom_settings['settings']['seo_publisher']['std'] = '';

$custom_settings['settings']['fb_publisher']['std'] = '';

$custom_settings['settings']['header_elements']['std'] = array (
  2 => 
  array (
    'title' => 'Search',
    'select_element' => 'content-text-html',
    'fullwidth' => 'off',
  ),
  0 => 
  array (
    'title' => 'Header',
    'select_element' => 'elements-bar',
    'fullwidth' => 'off',
  ),
  1 => 
  array (
    'title' => 'Breadcrumbs',
    'select_element' => 'elements-bar',
    'fullwidth' => 'off',
  ),
);

$custom_settings['settings']['footer_elements']['std'] = array (
  2 => 
  array (
    'title' => 'Shop Information',
    'select_element' => 'widget-section',
    'fullwidth' => 'off',
  ),
  3 => 
  array (
    'title' => 'Shop Widgets',
    'select_element' => 'widget-section',
    'fullwidth' => 'off',
  ),
  0 => 
  array (
    'title' => 'Footer',
    'select_element' => 'widget-section',
    'fullwidth' => 'off',
  ),
);

$custom_settings['settings']['content_padding']['std'] = '40px 0 60px';

$custom_settings['settings']['content_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => 'inc-lato',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '400',
  'letter-spacing' => '',
  'line-height' => '26px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['content_link']['std'] = '#107fc9';

$custom_settings['settings']['content_link_hover']['std'] = '#333333';

$custom_settings['settings']['content_separator']['std'] = '#aaaaaa';

$custom_settings['settings']['content_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['content_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['content_button_style']['std'] = 'filled';

$custom_settings['settings']['content_background']['std'] = array (
  'background-color' => '',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);

$custom_settings['settings']['content_boxshadow']['std'] = array (
  'offset-x' => '',
  'offset-y' => '',
  'blur-radius' => '',
  'spread-radius' => '',
  'color' => '',
);

$custom_settings['settings']['content_h1_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['content_h2_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '32px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['content_h3_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['content_h4_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '18px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['content_h5_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '17px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['content_h6_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '16px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['_wrapper_background']['std'] = array (
  'background-color' => '',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);

$custom_settings['settings']['_wrapper_boxshadow']['std'] = array (
  'offset-x' => '',
  'offset-y' => '',
  'blur-radius' => '',
  'spread-radius' => '',
  'color' => '',
);

$custom_settings['settings']['_header_background']['std'] = array (
  'background-color' => '',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);

$custom_settings['settings']['_header_boxshadow']['std'] = array (
  'offset-x' => '',
  'offset-y' => '',
  'blur-radius' => '',
  'spread-radius' => '',
  'color' => '',
);

$custom_settings['settings']['_footer_background']['std'] = array (
  'background-color' => '',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);

$custom_settings['settings']['_footer_boxshadow']['std'] = array (
  'offset-x' => '',
  'offset-y' => '',
  'blur-radius' => '',
  'spread-radius' => '',
  'color' => '',
);

$custom_settings['settings']['page_title']['std'] = 'content';

$custom_settings['settings']['page_comments']['std'] = 'on';

$custom_settings['settings']['blog_style']['std'] = 'full';

$custom_settings['settings']['post_comments']['std'] = 'on';

$custom_settings['settings']['404_image']['std'] = '';

$custom_settings['settings']['wrapper_padding']['std'] = '';

$custom_settings['settings']['wrapper_mode']['std'] = 'shopkit-central';

$custom_settings['settings']['wrapper_width']['std'] = '4096';

$custom_settings['settings']['inner_wrapper_width']['std'] = '1500';

$custom_settings['settings']['columns_margin']['std'] = '50';

$custom_settings['settings']['rows_margin']['std'] = '50';

$custom_settings['settings']['custom_css']['std'] = '#header_section .shopkit-section-left .shopkit-layout-element-separator {margin-left:19px;margin-right:2px;}
#header_section .shopkit-section-right {text-transform:uppercase;}';

$custom_settings['settings']['responsive_tablet_mode']['std'] = '1120';

$custom_settings['settings']['responsive_tablet_css']['std'] = '';

$custom_settings['settings']['responsive_mobile_mode']['std'] = '840';

$custom_settings['settings']['responsive_mobile_css']['std'] = '';

$custom_settings['settings']['sticky_header']['std'] = 'off';

$custom_settings['settings']['sticky_top']['std'] = '200';

$custom_settings['settings']['sticky_anim']['std'] = '500';

$custom_settings['settings']['sidebar_heading']['std'] = 'h4';

$custom_settings['settings']['left_sidebar_1']['std'] = 'off';

$custom_settings['settings']['left_sidebar_width_1']['std'] = '200';

$custom_settings['settings']['left_sidebar_2']['std'] = 'off';

$custom_settings['settings']['left_sidebar_width_2']['std'] = '200';

$custom_settings['settings']['right_sidebar_1']['std'] = 'on';

$custom_settings['settings']['right_sidebar_width_1']['std'] = '290';

$custom_settings['settings']['right_sidebar_1_visibility']['std'] = array (
  0 => 'shopkit-responsive-low',
);

$custom_settings['settings']['right_sidebar_2']['std'] = 'on';

$custom_settings['settings']['right_sidebar_width_2']['std'] = '290';

$custom_settings['settings']['right_sidebar_2_visibility']['std'] = array (
  0 => 'shopkit-responsive-low',
  1 => 'shopkit-responsive-medium',
);

$custom_settings['settings']['sidebars']['std'] = array (
  0 => 
  array (
    'title' => 'Single Product Layout',
    'display_condition' => 'is_product||is_cart||is_checkout||is_account_page',
    'left_sidebar_1' => 'off',
    'left_sidebar_width_1' => '200',
    'left_sidebar_2' => 'off',
    'left_sidebar_width_2' => '200',
    'right_sidebar_1' => 'on',
    'right_sidebar_width_1' => '290',
    'right_sidebar_1_visibility' => 
    array (
      0 => 'shopkit-responsive-low',
    ),
    'right_sidebar_2' => 'on',
    'right_sidebar_width_2' => '290',
    'right_sidebar_2_visibility' => 
    array (
      0 => 'shopkit-responsive-low',
      1 => 'shopkit-responsive-medium',
    ),
  ),
  1 => 
  array (
    'title' => 'WooCommerce Layout',
    'display_condition' => 'is_woocommerce',
    'left_sidebar_1' => 'on',
    'left_sidebar_width_1' => '300',
    'left_sidebar_2' => 'off',
    'left_sidebar_width_2' => '200',
    'right_sidebar_1' => 'off',
    'right_sidebar_width_1' => '200',
    'right_sidebar_2' => 'off',
    'right_sidebar_width_2' => '200',
  ),
);

$custom_settings['settings']['wc_orderby']['std'] = 'shopkit-orderby-bc';

$custom_settings['settings']['wc_product_style']['std'] = 'none';

$custom_settings['settings']['wc_image_effect']['std'] = 'zoom';

$custom_settings['settings']['wc_shop_title']['std'] = 'off';

$custom_settings['settings']['wc_shop_rating']['std'] = 'off';

$custom_settings['settings']['wc_shop_price']['std'] = 'off';

$custom_settings['settings']['wc_shop_desc']['std'] = 'on';

$custom_settings['settings']['wc_shop_add_to_cart']['std'] = 'off';

$custom_settings['settings']['wc_shop_products_margin']['std'] = 'off';

$custom_settings['settings']['wc_image_position']['std'] = 'imageleft';

$custom_settings['settings']['wc_thumbnails_columns']['std'] = '4';

$custom_settings['settings']['wc_single_image_size']['std'] = '3';

$custom_settings['settings']['wc_upsell_columns']['std'] = '4';

$custom_settings['settings']['wc_related_columns']['std'] = '4';

$custom_settings['settings']['wc_product_sidebars']['std'] = 'off';

$custom_settings['settings']['wc_single_rating']['std'] = 'off';

$custom_settings['settings']['wc_single_price']['std'] = 'off';

$custom_settings['settings']['wc_single_desc']['std'] = 'off';

$custom_settings['settings']['wc_single_add_to_cart']['std'] = 'off';

$custom_settings['settings']['wc_single_meta']['std'] = 'off';

$custom_settings['settings']['wc_single_upsells']['std'] = 'off';

$custom_settings['settings']['wc_product_tabs']['std'] = 'off';

$custom_settings['settings']['wc_single_related']['std'] = 'off';

	return $custom_settings;

}
add_filter( 'shopkit_flat_general_settings_args', 'shopkit_flat_general_settings' );


function shopkit_flat_section_search_settings( $custom_settings ) {

$custom_settings['settings']['search_content']['std'] = '
<h2>Search Products! Easy Product Searches, Bigger Conversions!</h2>

<p>WooCommerce Product Filter is all in one filter for every shop! It’s a must have for any WordPress and WooCommerce Online Store owner. This plugin extends your store by adding advanced filters that both you and your customers will love. Take your business to a higher level with this brilliant plugin. Exclusively included in ShopKit theme!</p>

[prdctfltr_sc_products preset="directory-filter-preset" show_products="no" ajax="yes" action="' . esc_url( home_url() ) . '/shop/" bot_margin="0"]

';

$custom_settings['settings']['search_padding']['std'] = '50px 0 50px';

$custom_settings['settings']['search_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['search_link']['std'] = '#107fc9';

$custom_settings['settings']['search_link_hover']['std'] = '#333333';

$custom_settings['settings']['search_separator']['std'] = '#aaaaaa';

$custom_settings['settings']['search_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['search_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['search_button_style']['std'] = 'filled';

$custom_settings['settings']['search_background']['std'] = array (
  'background-color' => '#f4f4f4',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);

$custom_settings['settings']['search_boxshadow']['std'] = array (
  'offset-x' => '',
  'offset-y' => '',
  'blur-radius' => '',
  'spread-radius' => '',
  'color' => '',
);

$custom_settings['settings']['search_h1_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['search_h2_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '32px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['search_h3_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['search_h4_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '18px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['search_h5_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '17px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['search_h6_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '16px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['search_type']['std'] = 'always-collapsed-with-trigger';

$custom_settings['settings']['search_type_height']['std'] = 'shopkit-height-30';

$custom_settings['settings']['search_condition']['std'] = '';

	return $custom_settings;

}
add_filter( 'shopkit_flat_section_search_args', 'shopkit_flat_section_search_settings' );


function shopkit_flat_section_header_settings( $custom_settings ) {

$custom_settings['settings']['header_elements_align']['std'] = 'shopkit-sections-leftright';

$custom_settings['settings']['header_elements_on_left']['std'] = array (
  0 => 
  array (
    'title' => 'Logo',
    'select_element' => 'logo',
    'text' => '',
    'height' => 'shopkit-height-42',
    'class' => '',
  ),
  1 => 
  array (
    'title' => 'Site Title',
    'select_element' => 'site-title',
    'text' => '',
    'class' => '',
  ),
  4 => 
  array (
    'title' => 'Separator',
    'select_element' => 'separator',
    'text' => '',
    'height' => 'shopkit-height-24',
    'class' => '',
  ),
  6 => 
  array (
    'title' => 'Search Trigger',
    'select_element' => 'image-link',
    'text' => '',
    'image' => esc_url( preg_replace( '(^https?:)', '', untrailingslashit( get_template_directory_uri() ) . '/demos/products.svg' ) ),
    'image_hover' => esc_url( preg_replace( '(^https?:)', '', untrailingslashit( get_template_directory_uri() ) . '/demos/products-hover.svg' ) ),
    'url' => '#',
    'height' => 'shopkit-height-48',
    'class' => 'shopkit-search-trigger',
  ),
  5 => 
  array (
    'title' => 'Menu',
    'select_element' => 'menu',
    'text' => '',
    'icon' => 'button',
    'menu' => 'all-pages',
    'menu_style' => 'shopkit-menu-nomargin',
    'menu_effect' => 'sweep-to-right',
    'menu_font' => 
    array (
      'font-color' => '#222222',
      'font-family' => '',
      'font-size' => '',
      'font-style' => '',
      'font-variant' => '',
      'font-weight' => '800',
      'letter-spacing' => '0.01em',
      'line-height' => '',
      'text-decoration' => '',
      'text-transform' => 'uppercase',
    ),
    'menu_font_hover' => '#ffffff',
    'menu_background_active' => '#107fc9',
    'menu_submenu_font' => 
    array (
      'font-color' => '#222222',
      'font-family' => '',
      'font-size' => '',
      'font-style' => '',
      'font-variant' => '',
      'font-weight' => '',
      'letter-spacing' => '',
      'line-height' => '40px',
      'text-decoration' => '',
      'text-transform' => 'none',
    ),
    'menu_submenu_font_hover' => '#ffffff',
    'menu_submenu_background' => '#f4f4f4',
    'menu_submenu_background_active' => '#107fc9',
    'height' => 'shopkit-height-30',
    'class' => '',
  ),
);

$custom_settings['settings']['header_elements_on_right']['std'] = array (
  3 => 
  array (
    'title' => 'Login',
    'select_element' => 'login-registration',
    'text' => '',
    'icon' => 'text',
    'height' => 'shopkit-height-30',
    'class' => '',
  ),
  4 => 
  array (
    'title' => 'Separator',
    'select_element' => 'separator',
    'text' => '',
    'height' => 'shopkit-height-24',
    'class' => '',
  ),
  2 => 
  array (
    'title' => 'Cart',
    'select_element' => 'woo-cart',
    'text' => '',
    'woo_cart_icon' => 'text',
    'height' => 'shopkit-height-30',
    'class' => '',
  ),
);

$custom_settings['settings']['header_outer_elements_align']['std'] = 'middle';

$custom_settings['settings']['header_inner_elements_align']['std'] = 'middle';

$custom_settings['settings']['header_padding']['std'] = '20px 0';

$custom_settings['settings']['header_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['header_link']['std'] = '#107fc9';

$custom_settings['settings']['header_link_hover']['std'] = '#333333';

$custom_settings['settings']['header_separator']['std'] = '#aaaaaa';

$custom_settings['settings']['header_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['header_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['header_button_style']['std'] = 'filled';

$custom_settings['settings']['header_background']['std'] = array (
  'background-color' => '',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);

$custom_settings['settings']['header_boxshadow']['std'] = array (
  'offset-x' => '',
  'offset-y' => '',
  'blur-radius' => '',
  'spread-radius' => '',
  'color' => '',
);

$custom_settings['settings']['header_h1_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['header_h2_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '32px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['header_h3_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['header_h4_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '18px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['header_h5_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '17px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['header_h6_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '16px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['header_type']['std'] = 'normal';

$custom_settings['settings']['header_type_height']['std'] = 'shopkit-height-30';

$custom_settings['settings']['header_condition']['std'] = '';

	return $custom_settings;

}
add_filter( 'shopkit_flat_section_header_args', 'shopkit_flat_section_header_settings' );


function shopkit_flat_section_breadcrumbs_settings( $custom_settings ) {

$custom_settings['settings']['breadcrumbs_elements_align']['std'] = 'shopkit-sections-leftright';

$custom_settings['settings']['breadcrumbs_elements_on_left']['std'] = array (
  0 => 
  array (
    'title' => 'Breadcrumbs',
    'select_element' => 'breadcrumbs',
    'text' => '',
    'class' => '',
  ),
);

$custom_settings['settings']['breadcrumbs_outer_elements_align']['std'] = 'middle';

$custom_settings['settings']['breadcrumbs_inner_elements_align']['std'] = 'middle';

$custom_settings['settings']['breadcrumbs_padding']['std'] = '5px 0';

$custom_settings['settings']['breadcrumbs_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['breadcrumbs_link']['std'] = '#107fc9';

$custom_settings['settings']['breadcrumbs_link_hover']['std'] = '#333333';

$custom_settings['settings']['breadcrumbs_separator']['std'] = '#aaaaaa';

$custom_settings['settings']['breadcrumbs_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['breadcrumbs_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['breadcrumbs_button_style']['std'] = 'filled';

$custom_settings['settings']['breadcrumbs_background']['std'] = array (
  'background-color' => '#f4f4f4',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);

$custom_settings['settings']['breadcrumbs_boxshadow']['std'] = array (
  'offset-x' => '',
  'offset-y' => '',
  'blur-radius' => '',
  'spread-radius' => '',
  'color' => '',
);

$custom_settings['settings']['breadcrumbs_h1_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['breadcrumbs_h2_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '32px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['breadcrumbs_h3_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['breadcrumbs_h4_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '18px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['breadcrumbs_h5_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '17px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['breadcrumbs_h6_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '16px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['breadcrumbs_type']['std'] = 'normal';

$custom_settings['settings']['breadcrumbs_type_height']['std'] = 'shopkit-height-30';

$custom_settings['settings']['breadcrumbs_condition']['std'] = '!is_front_page';

	return $custom_settings;

}
add_filter( 'shopkit_flat_section_breadcrumbs_args', 'shopkit_flat_section_breadcrumbs_settings' );


function shopkit_flat_section_shop_information_settings( $custom_settings ) {

$custom_settings['settings']['shop_information_sidebar_heading']['std'] = 'h3';

$custom_settings['settings']['shop_information_rows']['std'] = array (
  0 => 
  array (
    'title' => 'Shop Information Row',
    'select_element' => 'widget-4-columns-4',
  ),
);

$custom_settings['settings']['shop_information_padding']['std'] = '20px 0 0';

$custom_settings['settings']['shop_information_font']['std'] = array (
  'font-color' => '#bbbbbb',
  'font-family' => '',
  'font-size' => '12px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '18px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_information_link']['std'] = '#107fc9';

$custom_settings['settings']['shop_information_link_hover']['std'] = '#333333';

$custom_settings['settings']['shop_information_separator']['std'] = '#aaaaaa';

$custom_settings['settings']['shop_information_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_information_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_information_button_style']['std'] = 'filled';

$custom_settings['settings']['shop_information_background']['std'] = array (
  'background-color' => '',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);

$custom_settings['settings']['shop_information_boxshadow']['std'] = array (
  'offset-x' => '',
  'offset-y' => '',
  'blur-radius' => '',
  'spread-radius' => '',
  'color' => '',
);

$custom_settings['settings']['shop_information_h1_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_information_h2_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '32px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_information_h3_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_information_h4_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '16px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '20px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_information_h5_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '20px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_information_h6_font']['std'] = array (
  'font-color' => '#888888',
  'font-family' => '',
  'font-size' => '12px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '20px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_information_margin_override']['std'] = 'off';

$custom_settings['settings']['shop_information_type']['std'] = 'normal';

$custom_settings['settings']['shop_information_type_height']['std'] = 'shopkit-height-30';

$custom_settings['settings']['shop_information_condition']['std'] = 'is_woocommerce';

	return $custom_settings;

}
add_filter( 'shopkit_flat_section_shop_information_args', 'shopkit_flat_section_shop_information_settings' );


function shopkit_flat_section_shop_widgets_settings( $custom_settings ) {

$custom_settings['settings']['shop_widgets_sidebar_heading']['std'] = 'h4';

$custom_settings['settings']['shop_widgets_rows']['std'] = array (
  0 => 
  array (
    'title' => 'Product Widgets',
    'select_element' => 'widget-4-columns-4',
    'element_visibility' => 
    array (
      0 => 'shopkit-responsive-low',
    ),
  ),
);

$custom_settings['settings']['shop_widgets_padding']['std'] = '60px 0 0';

$custom_settings['settings']['shop_widgets_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_widgets_link']['std'] = '#222222';

$custom_settings['settings']['shop_widgets_link_hover']['std'] = '#107fc9';

$custom_settings['settings']['shop_widgets_separator']['std'] = '#bbbbbb';

$custom_settings['settings']['shop_widgets_button_font']['std'] = array (
  'font-color' => '#333333',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_widgets_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_widgets_button_style']['std'] = 'filled';

$custom_settings['settings']['shop_widgets_background']['std'] = array (
  'background-color' => '#fafafa',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);

$custom_settings['settings']['shop_widgets_boxshadow']['std'] = array (
  'offset-x' => '',
  'offset-y' => '',
  'blur-radius' => '',
  'spread-radius' => '',
  'color' => '',
);

$custom_settings['settings']['shop_widgets_h1_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.03em',
  'line-height' => '42px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_widgets_h2_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '30px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.02em',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_widgets_h3_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '-0.01em',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_widgets_h4_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => 'uppercase',
);

$custom_settings['settings']['shop_widgets_h5_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '13px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_widgets_h6_font']['std'] = array (
  'font-color' => '#111111',
  'font-family' => '',
  'font-size' => '12px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['shop_widgets_margin_override']['std'] = 'off';

$custom_settings['settings']['shop_widgets_type']['std'] = 'normal';

$custom_settings['settings']['shop_widgets_type_height']['std'] = 'shopkit-height-30';

$custom_settings['settings']['shop_widgets_condition']['std'] = 'is_woocommerce';

	return $custom_settings;

}
add_filter( 'shopkit_flat_section_shop_widgets_args', 'shopkit_flat_section_shop_widgets_settings' );


function shopkit_flat_section_footer_settings( $custom_settings ) {

$custom_settings['settings']['footer_sidebar_heading']['std'] = 'h4';

$custom_settings['settings']['footer_rows']['std'] = array (
  1 => 
  array (
    'title' => 'Footer #1',
    'select_element' => 'widget-4-columns-4',
  ),
  0 => 
  array (
    'title' => 'Footer #2',
    'select_element' => 'widget-7-columns-3',
  ),
);

$custom_settings['settings']['footer_padding']['std'] = '60px 0 10px';

$custom_settings['settings']['footer_font']['std'] = array (
  'font-color' => '#222222',
  'font-family' => '',
  'font-size' => '',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['footer_link']['std'] = '#107fc9';

$custom_settings['settings']['footer_link_hover']['std'] = '#333333';

$custom_settings['settings']['footer_separator']['std'] = '#eeeeee';

$custom_settings['settings']['footer_button_font']['std'] = array (
  'font-color' => '#222222',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['footer_button_hover_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '40px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['footer_button_style']['std'] = 'filled';

$custom_settings['settings']['footer_background']['std'] = array (
  'background-color' => '#ffffff',
  'background-repeat' => '',
  'background-attachment' => '',
  'background-position' => '',
  'background-size' => '',
  'background-image' => '',
);

$custom_settings['settings']['footer_boxshadow']['std'] = array (
  'inset' => 'inset',
  'offset-x' => '0',
  'offset-y' => '1px',
  'blur-radius' => '0',
  'spread-radius' => '0',
  'color' => '#aaaaaa',
);

$custom_settings['settings']['footer_h1_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '36px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '',
  'letter-spacing' => '',
  'line-height' => '42px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['footer_h2_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '11px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '36px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['footer_h3_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '24px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '30px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['footer_h4_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '14px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => 'uppercase',
);

$custom_settings['settings']['footer_h5_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '13px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => '900',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['footer_h6_font']['std'] = array (
  'font-color' => '#107fc9',
  'font-family' => '',
  'font-size' => '12px',
  'font-style' => '',
  'font-variant' => '',
  'font-weight' => 'inherit',
  'letter-spacing' => '',
  'line-height' => '28px',
  'text-decoration' => '',
  'text-transform' => '',
);

$custom_settings['settings']['footer_margin_override']['std'] = 'off';

$custom_settings['settings']['footer_type']['std'] = 'normal';

$custom_settings['settings']['footer_type_height']['std'] = 'shopkit-height-30';

$custom_settings['settings']['footer_condition']['std'] = '';

	return $custom_settings;

}
add_filter( 'shopkit_flat_section_footer_args', 'shopkit_flat_section_footer_settings' );



