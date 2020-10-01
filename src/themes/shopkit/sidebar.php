<?php

	if ( isset( ShopKit::$settings['sidebar_layout'] ) ) {

		$selected_sidebar = ShopKit::$settings['sidebar_layout'];

		$sidebar_id = 'shopkit-cl-' . sanitize_title( $selected_sidebar['title'] );

	}

	$sidebars = array(
		'sidebar-1' => 'left_sidebar_1',
		'sidebar-2' => 'left_sidebar_2',
		'sidebar-3' => 'right_sidebar_1',
		'sidebar-4' => 'right_sidebar_2'
	);

	foreach ( $sidebars as $k => $v ) {
		$curr_sidebar = isset( $selected_sidebar ) ? $selected_sidebar[$v] : ShopKit_Ot_Settings::get_settings( 'general', $v );
		if ( $curr_sidebar == 'off' ) {
			continue;
		}

		$responsive_visibility = isset( $selected_sidebar ) ? ( isset( $selected_sidebar[$v . '_visibility'] ) ? $selected_sidebar[$v . '_visibility'] : array() ) : ShopKit_Ot_Settings::get_settings( 'general', $v . '_visibility' );
?>
		<div id="<?php echo esc_attr( $k ); ?>" class="<?php echo ShopKit::get_element_classes( 'shopkit-sidebar shopkit-' . $k, $responsive_visibility ); ?>">
			<?php
				$get_sidebar = apply_filters( 'shopkit_get_sidebar', ( isset( $sidebar_id ) ? $sidebar_id . '-' . substr( $k, -1 ) : $k ) );

				if ( is_active_sidebar( $get_sidebar ) ) {
					dynamic_sidebar( $get_sidebar );
				}
				else {
					if ( current_user_can( 'administrator' ) ) {
						printf( esc_html__( 'Sidebar is empty! To add content here check your %1$sWidgets Section%2$s', 'shopkit' ), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>' );
					}
				}
			?>
		</div>
<?php
	}
?>