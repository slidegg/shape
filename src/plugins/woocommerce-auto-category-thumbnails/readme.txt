=== WooCommerce Auto Category Thumbnails ===
Contributors: Shellbot
Tags: woocommerce, ecommerce, e-commerce, wordpress ecommerce, shopping, categories
Requires at least: 4.0
Tested up to: 4.9.6
Donate link: http://patreon.com/shellbot
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Replace the default WooCommerce category image placeholder with a relevant project image instead.

== Description ==

** 07/06/18 - Updated for the latest version of WooCommerce **

By default, WooCommerce displays a neutral and uninteresting category image placeholder in those cases where a category has
no explicitly set thumbnail. This plugin simply replaces the placeholder image with a product image from that category.

User can choose whether to use a random product or the latest product from that category.

Feature requests welcome, please [post in the support forum](https://wordpress.org/support/plugin/woocommerce-auto-category-thumbnails "Plugin support forum").

**Usage**

There is no complicated setup, simply install the plugin and configure WooCommerce to display categories. Any categories containing products but without a
category thumbnail will now display a product image.

To switch between random and latest product display, see the settings page under WooCommerce > Settings > Auto Category Thumbnails.

More options coming soon. [Plugin release page](http://codebyshellbot.com/wordpress-plugins/woocommerce-auto-category-thumbnails/ "WooCommerce Auto Category Thumbnails").

== Installation ==

1. Upload the 'woocommerce-auto-cat-thumbnails' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Change settings if required under 'WooCommerce > Settings > Auto Category Thumbnails' in your WP admin panel
4. Enjoy!

== Frequently Asked Questions ==

= My automatic category images are displaying at weird sizes? =

Make sure your settings are correct under WooCommerce > Settings > Products > Display
in your WP admin panel. You will need to regenerate your image sizes after changing these
settings, or possibly on first install of the plugin. [Find the Regenerate Thumbnails plugin here](http://wordpress.org/plugins/regenerate-thumbnails/ "Regenerate Thumbnails").

== Changelog ==

= 1.2.1 =

* Fixed issue with category image size in newer versions of WooCommerce

= 1.2 =
* Fixed incompatibility with latest version of WooCommerce due to changed handling of product visibility setting

= 1.1 =
* Moved settings page to WooCommerce settings tab

= 1.0 =
* First version

== Upgrade Notice ==

= 1.1 =
* Moved settings page to a more user-friendly place
