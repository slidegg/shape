<?php
if (!defined('ABSPATH')) {
    return;
}

if ($check_bottom):
    ?>
    <div class="kl-main-header site-header-bottom-wrapper clearfix <?php echo implode(' ', $bottom_extra_classes); ?>">
        <div class="container siteheader-container">
            <?php do_action('zn_head__before__bottom'); ?>

            <?php
            if (has_action('zn_head__bottom_left') || has_action('zn_head__bottom_center') || has_action('zn_head__bottom_right') || has_action('zn_head_cart_area_s8')):
                ?>
                <?php do_action('zn_head__bottom_left'); ?>
                <?php do_action('zn_head__bottom_center'); ?>
                <?php do_action('zn_head__bottom_right'); ?>
            <?php endif; ?>

            <?php do_action('zn_head__after__bottom'); ?>
        </div>
    </div>
<?php endif; ?>
