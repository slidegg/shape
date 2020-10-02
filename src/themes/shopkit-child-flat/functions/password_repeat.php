<?php
/**
 * Add Repeat password Field to default woocommerce form
 * @param $reg_errors
 * @param $sanitized_user_login
 * @param $user_email
 * @return WP_Error
 * https://axlmulat.com/woocommerce/woocommerce-how-to-add-confirm-password-in-registration-and-checkout-page/
 */

// ----- validate password match on the registration page
add_filter('woocommerce_registration_errors', function ($reg_errors, $sanitized_user_login, $user_email) {
    global $woocommerce;
    extract( $_POST );
    if ( strcmp( $password, $password2 ) !== 0 ) {
        return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
    }
    return $reg_errors;
}, 10,3);

// ----- add a confirm password fields match on the registration page
add_action( 'woocommerce_register_form', function () {
    ?>
    <p class="form-row form-row-wide">
        <label for="reg_password2"><?php _e( 'Repeat password', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
    </p>
    <?php
} );

// ----- Validate confirm password field match to the checkout page
add_action( 'woocommerce_after_checkout_validation', function ( $posted ) {
    $checkout = WC()->checkout;
    if ( ! is_user_logged_in() && ( $checkout->must_create_account || ! empty( $posted['createaccount'] ) ) ) {
        if ( strcmp( $posted['account_password'], $posted['account_confirm_password'] ) !== 0 ) {
            wc_add_notice( __( 'Passwords do not match.', 'woocommerce' ), 'error' );
        }
    }
}, 10, 2 );

// ----- Add a confirm password field to the checkout page
add_action( 'woocommerce_checkout_init', function ( $checkout ) {
    if ( get_option( 'woocommerce_registration_generate_password' ) == 'no' ) {

        $fields = $checkout->get_checkout_fields();

        $fields['account']['account_confirm_password'] = array(
            'type'              => 'password',
            'label'             => __( 'Repeat password', 'woocommerce' ),
            'required'          => true,
            'placeholder'       => _x( 'Repeat password', 'placeholder', 'woocommerce' )
        );

        $checkout->__set( 'checkout_fields', $fields );
    }
}, 10, 1 );
