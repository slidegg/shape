<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	add_action( 'wp_ajax_shopkit_menu_support', 'shopkit_menu_support' );

	function shopkit_menu_support() {

		if ( !isset( $_POST['shopkit_menu'] ) ) {
			die(0);
			exit;
		}

		$ids = $_POST['shopkit_menu'];

		if ( is_array( $ids ) ) {
			foreach( $ids as $id ) {
				$style = esc_attr( get_post_meta( $id, 'shopkit-menu-style', true ) );
				$bg = esc_attr( get_post_meta( $id, 'shopkit-menu-bg-url', true ) );
				$bg_pos = esc_attr( get_post_meta( $id, 'shopkit-menu-bg-pos', true ) );
				$data[$id] = "
					<p class='shopkit-menu-style description description-wide'>
						<label for='shopkit-menu-style-$id'>
							" . esc_html__( 'Menu Style', 'shopkit' ) . "
							<select id='shopkit-menu-style-$id' name='shopkit-menu-style-$id' class='widefat'>
								<option value=''>" . esc_html__( 'Default', 'shopkit' ) . "</option>
								<option value='multi-column'" . ( $style == 'multi-column' ? ' selected' : '' ).">" . esc_html__( 'Multi Column', 'shopkit' ) . "</option>
							</select>
						</label>
					</p>
					<p class='shopkit-menu-bg description description-thin'>
						<label for='shopkit-menu-bg-url-$id'>
							" . esc_html__( 'Background image', 'shopkit' ) . "<br/>
							<input type='text' value='$bg' id='shopkit-menu-bg-url-$id' name='shopkit-menu-bg-url-$id' class='widefat' /><br/>
						</label>
						<span id='shopkit-upload-$id' class='button shopkit-menu-bg-upload' style='margin-top:10px;'>" . esc_html__( 'Add Image', 'shopkit' ) . "</span>
					</p>
					<p class='shopkit-menu-bg-pos description description-thin'>
						<label for='shopkit-menu-bg-pos-$id'>
							" . esc_html__( 'Background orientation', 'shopkit' ) . "<br/>
							<select id='shopkit-menu-bg-pos-$id' name='shopkit-menu-bg-pos-$id' class='widefat'>
								<option value='left-landscape'" . ( $bg_pos == 'left-landscape' ? ' selected' : '' ).">" . esc_html__( 'Left Landscape', 'shopkit' ) . "</option>
								<option value='left-portraid'" . ( $bg_pos == 'left-portraid' ? ' selected' : '' ) . ">" . esc_html__( 'Left Portraid', 'shopkit' ) . "</option>
								<option value='right-landscape'" . ( $bg_pos == 'right-landscape' ? ' selected' : '' ) . ">" . esc_html__( 'Right Landscape', 'shopkit' ) . "</option>
								<option value='right-portraid'" . ( $bg_pos == 'right-portraid' ? ' selected' : '' ) . ">" . esc_html__( 'Right Portraid', 'shopkit' ) . "</option>
								<option value='pattern-repeat'" . ( $bg_pos == 'pattern-repeat' ? ' selected' : '' ) . ">" . esc_html__( 'Pattern', 'shopkit' ) . "</option>
								<option value='full-width'" . ( $bg_pos == 'full-width' ? ' selected' : '' ) . ">" . esc_html__( 'Cover', 'shopkit' ) . "</option>
							</select>
						</label>
					</p>
					";
			}

			wp_send_json( $data );
			exit;

		}

	}

	function shopkit_menu_item_update( $menu_id, $menu_item_id, $args ) {

		if ( isset( $_POST[ "shopkit-menu-style-$menu_item_id" ] ) ) {
			update_post_meta( $menu_item_id, 'shopkit-menu-style', $_POST[ "shopkit-menu-style-$menu_item_id" ] );
		}
		else {
			delete_post_meta( $menu_item_id, 'shopkit-menu-style' );
		}

		if ( isset( $_POST[ "shopkit-menu-bg-url-$menu_item_id" ] ) ) {
			update_post_meta( $menu_item_id, 'shopkit-menu-bg-url', $_POST[ "shopkit-menu-bg-url-$menu_item_id" ] );
			update_post_meta( $menu_item_id, 'shopkit-menu-bg-pos', $_POST[ "shopkit-menu-bg-pos-$menu_item_id" ] );
		}
		else {
			delete_post_meta( $menu_item_id, 'shopkit-menu-bg-url' );
			delete_post_meta( $menu_item_id, 'shopkit-menu-bg-pos' );
		}

	}
	add_action( 'wp_update_nav_menu_item', 'shopkit_menu_item_update', 10, 3 );


?>