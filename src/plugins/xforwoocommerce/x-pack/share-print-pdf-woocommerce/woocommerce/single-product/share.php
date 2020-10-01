<?php
	if ( !isset( XforWC_PDF_Print_Share_Frontend::$settings['init'] ) ) {
		XforWC_PDF_Print_Share_Frontend::$settings['init'] = true;
	}
	$sppClass = ( get_option( 'wc_settings_spp_counts', 'no' ) == 'no' ? 'wcspp-nocounts' : 'wcspp-counts' ) . ' wcspp-style-' . get_option( 'wc_settings_spp_style', 'line-icons' );
?>
<nav class="wcspp-navigation <?php echo esc_attr( $sppClass ); ?>" data-wcspp-id="<?php the_ID(); ?>">
	<?php
		$title = '<h3>' . esc_html__( 'Share product', 'xforwoocommerce' ) . '</h3>';
		echo apply_filters( 'wc_shareprintpdf_title', $title );

		do_action( 'shareprintpdf_before' );
	?>
	<ul>
	<?php
		do_action( 'shareprintpdf_icons');
	?>
	</ul>
	<?php
		do_action( 'shareprintpdf_after' );
	?>
</nav>