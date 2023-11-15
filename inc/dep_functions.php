<?php


if ( ! function_exists( 'stm_listing_price_view' ) ) {
	/**
	 * Price delimeter
	 */
	function stm_listing_price_view( $price ) {
		if ( ! empty( $price ) ) {
			$price_label          = stm_get_price_currency();
			$price_label_position = stm_me_get_wpcfto_mod( 'price_currency_position', 'left' );
			$price_delimeter      = stm_me_get_wpcfto_mod( 'price_delimeter', ' ' );

			if ( strpos( $price, '<' ) !== false || strpos( $price, '>' ) !== false ) {
				$price_convert = number_format( getConverPrice( filter_var( $price, FILTER_SANITIZE_NUMBER_INT ) ), 0, '', $price_delimeter );
			} elseif ( strpos( $price, '-' ) !== false ) {
				$price_array   = explode( '-', $price );
				$price_l       = ( ! empty( $price_array[0] ) ) ? number_format( getConverPrice( $price_array[0] ), 0, '', $price_delimeter ) : '';
				$price_r       = ( ! empty( $price_array[1] ) ) ? number_format( getConverPrice( $price_array[1] ), 0, '', $price_delimeter ) : '';
				$price_convert = ( ! empty( $price_l ) && ! empty( $price_r ) ) ? $price_l . '-' . $price_r : ( ( ! empty( $price_l ) ) ? $price_l : $price_r );
			} else {
				$price_convert = number_format( getConverPrice( $price ), 0, '', $price_delimeter );
			}

			if ( 'left' === $price_label_position ) {

				$response = $price_label . $price_convert;

				if ( strpos( $price, '<' ) !== false ) {
					$response = '&lt; ' . $price_label . $price_convert;
				} elseif ( strpos( $price, '>' ) !== false ) {
					$response = '&gt; ' . $price_label . $price_convert;
				}
			} else {
				$response = $price_convert . $price_label;

				if ( strpos( $price, '<' ) !== false ) {
					$response = '&lt; ' . $price_convert . $price_label;
				} elseif ( strpos( $price, '>' ) !== false ) {
					$response = '&gt; ' . $price_convert . $price_label;
				}
			}

			return apply_filters( 'stm_filter_price_view', $response, $price );
		}
	}
}

if ( ! function_exists( 'stm_get_price_currency' ) ) {
	/**
	 * Get price currency
	 */
	function stm_get_price_currency() {
		$currency = stm_me_get_wpcfto_mod( 'price_currency', '$' );
		if ( isset( $_COOKIE['stm_current_currency'] ) ) {
			$cookie   = explode( '-', $_COOKIE['stm_current_currency'] );
			$currency = $cookie[0];
		}
		return $currency;
	}
}