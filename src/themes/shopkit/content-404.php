<?php

	$image_404 = ShopKit_Ot_Settings::get_settings( 'general', '404_image' );

	if ( !empty( $image_404 ) ) {
		$url_404 = $image_404;
	}
	else {
		$url_404 =  WcSk()->template_url() . '/demos/404.svg';
	}

?>
<img src="<?php echo esc_url( $url_404 ); ?>" class="shopkit-404" />

<a href="<?php echo esc_url( home_url() ); ?>" class="shopkit-link-404"></a>