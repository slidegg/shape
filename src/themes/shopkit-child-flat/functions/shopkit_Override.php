<?php
/**
 * Replace USERNAME with EMAIL in REGISTRATION
 */
add_action('shopkit_element_register_after', function(){
    ob_get_clean();
    ?>
    <h3><?php esc_html_e('Register New Account', 'shopkit'); ?></h3>
    <form class="shopkit-login-registration-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="POST">
        <fieldset>
            <p>
                <label><span><?php esc_html_e('Email', 'shopkit'); ?></span>
                    <input name="shopkit_user_email_reg" class="required" type="email" placeholder="<?php esc_html_e('Email', 'shopkit') ?>" />
                </label>
            </p>
            <p>
                <label><span><?php esc_html_e('Password', 'shopkit'); ?></span>
                    <input name="shopkit_user_pass_reg" class="required" type="password" placeholder="<?php esc_html_e('Password', 'shopkit') ?>" />
                </label>
            </p>
            <p>
                <label><span><?php esc_html_e('Repeat Password', 'shopkit'); ?></span>
                    <input name="shopkit_user_pass_confirm_reg" class="required" type="password" placeholder="<?php esc_html_e('Repeat Password', 'shopkit') ?>" />
                </label>
            </p>
            <p>
                <input type="hidden" name="shopkit_register_nonce" value="<?php echo wp_create_nonce('shopkit_register_nonce'); ?>"/>
                <input type="submit" value="<?php esc_html_e('Register', 'shopkit'); ?>"/>
            </p>
        </fieldset>
    </form>
    <?php
});

/**
 * Replace USERNAME with EMAIL in LOGIN
 */
add_action('shopkit_element_login_after', function(){
    ob_get_clean();
    ?>
    <h3><?php esc_html_e('Log in', 'shopkit'); ?></h3>
    <form class="shopkit-login-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
        <fieldset>
            <p>
                <label><span><?php esc_html_e('Email', 'shopkit'); ?></span>
                    <input name="shopkit_user_login" class="required" type="text" placeholder="<?php esc_html_e('Email', 'shopkit') ?>"<?php isset( $_POST['shopkit_user_login'] ) ? ' value="' . esc_attr( $_POST['shopkit_user_login'] ) . '"' : '' ; ?> />
                </label>
            </p>
            <p>
                <label><span><?php esc_html_e('Password', 'shopkit'); ?></span>
                    <input name="shopkit_user_pass" class="required" type="password" placeholder="<?php esc_html_e('Password', 'shopkit') ?>" />
                </label>
            </p>
            <p>
                <input type="hidden" name="shopkit_login_nonce" value="<?php echo wp_create_nonce('shopkit_login_nonce'); ?>"/>
                <input type="submit" value="<?php esc_html_e('Login', 'shopkit'); ?>"/>
            </p>
            <p><?php do_action( 'social_connect_form' ); ?></p>
        </fieldset>
        <div class="links auth-popup-links">
            <a href="/my-account" class="create_account auth-popup-createacc kl-login-box auth-popup-link">ΔΗΜΙΟΥΡΓΙΑ ΛΟΓΑΡΙΑΣΜΟΥ</a> <span class="sep auth-popup-sep"> | </span>
            <a href="/my-account/lost-password/" class="kl-login-box auth-popup-link">ΞΕΧΑΣΑΤΕ ΤΟΝ ΚΩΔΙΚΟ;</a>
        </div>
    </form>
    <?php
});

add_action( 'init', array( 'ShopKit', 'init' ), 1 );