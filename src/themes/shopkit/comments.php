<?php
/**
 * ShopKit - Comments
 *
 * @package WordPress
 * @subpackage ShopKit
 * @since ShopKit 1.0.0
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'shopkit' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
			?>
		</h3>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 60,
				) );
			?>
		</ol>

		<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
			<nav class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'shopkit' ); ?></h2>
				<div class="nav-links">
					<?php
						if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'shopkit' ) ) ) :
							printf( '<div class="nav-previous button">%s</div>', $prev_link );
						endif;

						if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'shopkit' ) ) ) :
							printf( '<div class="nav-next button">%s</div>', $next_link );
						endif;
					?>
				</div>
			</nav>
		<?php
			endif;
		?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'shopkit' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div>