<?php
/**
 * ShopKit - Content Archive
 *
 * @package WordPress
 * @subpackage ShopKit
 * @since ShopKit 1.0.0
 */

	$shopkit_action = ( ( $shopkit_post = get_post_format() ) == 'quote' ? 'quote' : 'standard' );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'shopkit_archive_header_' . $shopkit_action ); ?>

	<div class="shopkit-entry-content">

		<?php do_action( 'shopkit_archive_' . $shopkit_action ); ?>

	</div>

	<?php do_action( 'shopkit_archive_footer_' . $shopkit_action ); ?>

</article>