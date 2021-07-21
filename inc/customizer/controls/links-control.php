<?php
/**
 * Theme Links Control for the Customizer
 *
 * @package GT Next
 */

/**
 * Make sure that custom controls are only defined in the Customizer
 */
if ( class_exists( 'WP_Customize_Control' ) ) :

	/**
	 * Displays the theme links in the Customizer.
	 */
	class GT_Next_Customize_Links_Control extends WP_Customize_Control {
		/**
		 * Render Control
		 */
		public function render_content() {
			?>

			<div class="theme-links">

				<span class="customize-control-title"><?php esc_html_e( 'Theme Links', 'gt-next' ); ?></span>

				<p>
					<a href="<?php echo esc_url( __( 'https://germanthemes.de/en/themes/gt-next/', 'gt-next' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=gt-next&utm_content=theme-page" target="_blank">
						<?php esc_html_e( 'Theme Page', 'gt-next' ); ?>
					</a>
				</p>

				<p>
					<a href="https://demo.germanthemes.de/?demo=gt-next&utm_source=customizer&utm_campaign=gt-next" target="_blank">
						<?php esc_html_e( 'Theme Demo', 'gt-next' ); ?>
					</a>
				</p>

				<p>
					<a href="<?php echo esc_url( __( 'https://germanthemes.de/en/docs/gt-next-documentation/', 'gt-next' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=gt-next&utm_content=documentation" target="_blank">
						<?php esc_html_e( 'Theme Documentation', 'gt-next' ); ?>
					</a>
				</p>

				<p>
					<a href="<?php echo esc_url( __( 'https://wordpress.org/support/theme/gt-next/reviews/', 'gt-next' ) ); ?>" target="_blank">
						<?php esc_html_e( 'Rate this theme', 'gt-next' ); ?>
					</a>
				</p>

			</div>

			<?php
		}
	}

endif;
