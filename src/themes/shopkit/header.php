<?php
/**
 * ShopKit - Header
 *
 * @package WordPress
 * @subpackage ShopKit
 * @since ShopKit 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="initial-scale=1">
	<?php

		do_action( 'shopkit_head' );
		wp_head();

	?>
</head>
<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
	<div id="wrapper" class="shopkit-wrapper">
<?php

	do_action( 'shopkit_header' );

?>