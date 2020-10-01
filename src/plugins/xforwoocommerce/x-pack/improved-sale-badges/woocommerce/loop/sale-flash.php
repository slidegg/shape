<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	global $product, $isb_set;

	$isb_sale_flash = false;

	$curr_badge = XforWC_Improved_Badges_Frontend::get_badge();

	$isb_set['load_js'] = true;

	if ( isset( $curr_badge[0]['special'] ) && $curr_badge[0]['special'] !== '' ) {

		$isb_curr_set['special'] = ( isset( $curr_badge[0]['special'] ) && $curr_badge[0]['special'] !== '' ? $curr_badge[0]['special'] : $isb_set['special'] );
		$isb_curr_set['color'] = ( isset( $curr_badge[0]['color'] ) && $curr_badge[0]['color'] !== '' ? $curr_badge[0]['color'] : $isb_set['color'] );
		$isb_curr_set['position'] = ( isset( $curr_badge[0]['position'] ) && $curr_badge[0]['position'] !== '' ? $curr_badge[0]['position'] : $isb_set['position'] );

		$isb_class = implode( ' ', $isb_curr_set );

		$isb_curr_set['special_text'] = ( isset( $curr_badge[0]['special_text'] ) && $curr_badge[0]['special_text'] !== '' ? stripslashes( $curr_badge[0]['special_text'] ) : esc_html__( 'Text', 'xforwoocommerce' ) );

		if ( isset( $isb_curr_set['special'] ) ) {
			$include = ImprovedBadges()->plugin_path() . '/includes/specials/' . $isb_curr_set['special'] . '.php';
			if ( file_exists ( $include ) ) {
				include( $include );
			}
		}

		return;

	}
	else {

		if ( $product->is_type( 'grouped' ) || $product->is_type( 'external' ) ) {
			return '';
		}

		if ( !$product->is_type( 'variable' ) ) {
			$sale_price_dates_from = (int) get_post_meta( get_the_ID(), '_sale_price_dates_from', true ) + (int) get_option( 'wc_settings_isb_timer_adjust', 0 )*60;
			$sale_price_dates_to = (int) get_post_meta( get_the_ID(), '_sale_price_dates_to', true ) + (int) get_option( 'wc_settings_isb_timer_adjust', 0 )*60;

			if ( !empty( $sale_price_dates_from ) && !empty( $sale_price_dates_to ) ) {
				$current_time = current_time( 'mysql' );
				$newer_date = strtotime( $current_time );

				$since = $newer_date - $sale_price_dates_from;

				if ( 0 > $since ) {
					$isb_price['time'] = $sale_price_dates_from;
					$isb_price['time_mode'] = 'start';
				}

				if ( !isset( $isb_price['time'] ) ) {
					$since = $newer_date - $sale_price_dates_to;
					if ( 0 > $since ) {
						$isb_price['time'] = $sale_price_dates_to;
						$isb_price['time_mode'] = 'end';
					}
				}

				$timer = get_option( 'wc_settings_isb_timer', array() );
				if ( !empty( $timer ) && is_array( $timer ) && isset( $isb_price['time_mode'] ) && in_array( $isb_price['time_mode'], $timer ) ) {
					unset( $isb_price['time'] );
					unset( $isb_price['time_mode'] );
				}
			}


			if ( $product->get_price() > 0 && ( $product->is_on_sale() || isset( $isb_price['time'] ) ) !== false ) {

				$isb_price['type'] = 'simple';

				$isb_price['id'] = get_the_ID();

				$isb_price['regular'] = floatval( $product->get_regular_price() );

				$isb_price['sale'] = floatval( $product->get_sale_price() );

				$isb_price['difference'] = $isb_price['regular'] - $isb_price['sale'];

				$isb_price['percentage'] = round( ( $isb_price['regular'] - $isb_price['sale'] ) * 100 / $isb_price['regular'] );

				$isb_sale_flash = true;

			}

		}
		else {

			$isb_variations = $product->get_available_variations();
			$isb_check = 0;
			$isb_check_time = 0;

			foreach( $isb_variations as $var ) {
				$curr_product[$var['variation_id']] = new WC_Product_Variation( $var['variation_id'] );

				$sale_price_dates_from = (int) get_post_meta( $var['variation_id'], '_sale_price_dates_from', true ) + (int) get_option( 'wc_settings_isb_timer_adjust', 0 )*60;
				$sale_price_dates_to = (int) get_post_meta( $var['variation_id'], '_sale_price_dates_to', true ) + (int) get_option( 'wc_settings_isb_timer_adjust', 0 )*60;

				if ( !empty( $sale_price_dates_from ) && !empty( $sale_price_dates_to ) ) {
					$current_time = current_time( 'mysql' );
					$newer_date = strtotime( $current_time );

					$since = $newer_date - $sale_price_dates_from;

					if ( 0 > $since ) {
						$check_time = $sale_price_dates_from;
						$check_time_mode = 'start';
					}

					if ( !isset( $check_time ) ) {
						$since = $newer_date - $sale_price_dates_to;
						if ( 0 > $since ) {
							$check_time = $sale_price_dates_to;
							$check_time_mode = 'end';
						}
					}

					if ( isset( $check_time ) ) {
						if ( $check_time > $isb_check_time ) {
							$isb_price['time'] = $check_time;
							$isb_price['time_mode'] = $check_time_mode;
						}

						$timer = get_option( 'wc_settings_isb_timer', array() );
						if ( !empty( $timer ) && is_array( $timer ) && isset( $isb_price['time_mode'] ) && in_array( $isb_price['time_mode'], $timer ) ) {
							unset( $isb_price['time'] );
							unset( $isb_price['time_mode'] );
						}
					}
				}

				if ( $curr_product[$var['variation_id']]->is_on_sale() ) {

					$isb_var_regular_price = $curr_product[$var['variation_id']]->get_regular_price();
					$isb_var_sales_price = $curr_product[$var['variation_id']]->get_sale_price();

					$isb_diff = $isb_var_regular_price - $isb_var_sales_price ;

					if ( $isb_diff > $isb_check ) {
						$isb_check = $isb_diff;
						$isb_var = $var['variation_id'];
					}
				}

			}

			if ( isset( $isb_var ) ) {

				$isb_price['type'] = 'variable';

				$isb_price['id'] = $isb_var;

				$isb_price['regular'] = floatval( $curr_product[$isb_var]->get_regular_price() );

				$isb_price['sale'] = floatval( $curr_product[$isb_var]->get_sale_price() );

				$isb_price['difference'] = $isb_price['regular'] - $isb_price['sale'];

				$isb_price['percentage'] = round( ( $isb_price['regular'] - $isb_price['sale'] ) * 100 / $isb_price['regular'] );

				$isb_sale_flash = true;

			}

		}

	}

	if ( $isb_sale_flash === true ) {

		if ( !isset( $curr_badge ) ) {
			$curr_badge = array();
		}

		if ( empty( $curr_badge ) ) {
			$isb_curr_set = array(
				'style'        => $isb_set['style'],
				'color'        => $isb_set['color'],
				'position'     => $isb_set['position'],
				'special'      => $isb_set['special'],
				'special_text' => $isb_set['special_text']
			);

			$isb_class = $isb_curr_set['style'] . ' ' . $isb_curr_set['color'] . ' ' . $isb_curr_set['position'];
		}
		else {
			$isb_curr_set['style'] = ( isset( $curr_badge[0]['style'] ) && $curr_badge[0]['style'] !== '' ? $curr_badge[0]['style'] : $isb_set['style'] );
			$isb_curr_set['color'] = ( isset( $curr_badge[0]['color'] ) && $curr_badge[0]['color'] !== '' ? $curr_badge[0]['color'] : $isb_set['color'] );
			$isb_curr_set['position'] = ( isset( $curr_badge[0]['position'] ) && $curr_badge[0]['position'] !== '' ? $curr_badge[0]['position'] : $isb_set['position'] );
			$isb_curr_set['special'] = ( isset( $curr_badge[0]['special'] ) && $curr_badge[0]['special'] !== '' ? $curr_badge[0]['special'] : $isb_set['special'] );
			$isb_curr_set['special_text'] = ( isset( $curr_badge[0]['special_text'] ) && $curr_badge[0]['special_text'] !== '' ? $curr_badge[0]['special_text'] : $isb_set['special_text'] );

			$isb_class = $isb_curr_set['style'] . ' ' . $isb_curr_set['color'] . ' ' . $isb_curr_set['position'];
		}

		if ( isset( $isb_curr_set['style'] ) ) {
			$include = ImprovedBadges()->plugin_path() . '/includes/styles/' . $isb_curr_set['style'] . '.php';
			if ( file_exists ( $include ) ) {
				include( $include );
			}
		}

	}

?>