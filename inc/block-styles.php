<?php
/**
 * Add block styles for the Gutenberg Editor
 *
 * @package GT Next
 */


/**
 * Registers support for block styles.
 *
 * @return void
 */
function gt_next_block_styles() {

	// Check if block style functions are available.
	if ( function_exists( 'register_block_style' ) ) {

		// Register Heading Block style.
		register_block_style( 'core/heading', array(
			'name'         => 'gt-heading',
			'label'        => esc_html__( 'GT Next', 'gt-next' ),
			'style_handle' => 'gt-next-stylesheet',
		) );

		// Register Small Buttons Block style.
		register_block_style( 'core/buttons', array(
			'name'         => 'gt-small',
			'label'        => esc_html__( 'GT Small', 'gt-next' ),
			'style_handle' => 'gt-next-stylesheet',
		) );

		// Register Large Buttons Block style.
		register_block_style( 'core/buttons', array(
			'name'         => 'gt-large',
			'label'        => esc_html__( 'GT Large', 'gt-next' ),
			'style_handle' => 'gt-next-stylesheet',
		) );
	}
}
add_action( 'after_setup_theme', 'gt_next_block_styles' );
