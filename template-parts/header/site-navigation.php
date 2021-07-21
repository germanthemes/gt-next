<?php
/**
 * Main Navigation
 *
 * @version 1.0
 * @package GT Next
 */
?>

<?php if ( has_nav_menu( 'primary' ) or has_nav_menu( 'social-header' ) ) : ?>

	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
		<?php
		echo gt_next_get_svg( 'menu' );
		echo gt_next_get_svg( 'close' );
		?>
		<span class="menu-toggle-text"><?php esc_html_e( 'Menu', 'gt-next' ); ?></span>
	</button>

	<div class="primary-navigation">

		<?php if ( has_nav_menu( 'primary' ) ) : ?>

			<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'gt-next' ); ?>">

				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
					)
				);
				?>
			</nav><!-- #site-navigation -->

		<?php endif; ?>

		<?php if ( has_nav_menu( 'social-header' ) ) : ?>

			<div class="mobile-menu-social-icons social-icons-nav">

				<?php gt_next_social_icons_menu( 'social-header' ); ?>

			</div>

		<?php endif; ?>

	</div><!-- .primary-navigation -->

<?php endif; ?>

<?php gt_next_header_search_icon(); ?>
