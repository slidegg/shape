<?php
/**
 * ShopKit - Content Single
 *
 * @package WordPress
 * @subpackage ShopKit
 * @since ShopKit 1.0.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'shopkit_single_header' ); ?>

	<div class="shopkit-entry-content">

		<?php do_action( 'shopkit_single' ); ?>

	</div>

	<?php do_action( 'shopkit_single_footer' ); ?>

</article>