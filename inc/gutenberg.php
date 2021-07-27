<?php
/**
 * Add theme support for the Gutenberg Editor
 *
 * @package GT Next
 */


/**
 * Enqueue block styles and scripts for Gutenberg Editor.
 */
function gt_next_block_editor_assets() {

	// Get Theme Version.
	$theme_version = wp_get_theme()->get( 'Version' );

	// Enqueue Editor Styling.
	wp_enqueue_style( 'gt-next-editor-styles', get_theme_file_uri( '/assets/css/editor-styles.css' ), array(), $theme_version, 'all' );

	// Get current screen.
	$current_screen = get_current_screen();

	// Enqueue Theme Settings Editor plugin.
	if ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() && 'post' === $current_screen->base ) {
		wp_enqueue_script( 'gt-next-editor-theme-settings', get_theme_file_uri( '/assets/js/editor-theme-settings.js' ), array( 'wp-blocks', 'wp-element', 'wp-edit-post' ), $theme_version );
	}
}
add_action( 'enqueue_block_editor_assets', 'gt_next_block_editor_assets' );


/**
 * Add body classes in Gutenberg Editor.
 */
function gt_next_gutenberg_add_admin_body_class( $classes ) {
	global $post;
	$current_screen = get_current_screen();

	// Return early if we are not in the Gutenberg Editor.
	if ( ! ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() && 'post' === $current_screen->base ) ) {
		return $classes;
	}

	// Fullwidth Page Template?
	if ( 'templates/template-fullwidth.php' === get_page_template_slug( $post->ID ) ) {
		$classes .= ' gt-fullwidth-page-layout ';
	}

	// No Title Page Template?
	if ( 'templates/template-no-title.php' === get_page_template_slug( $post->ID ) ) {
		$classes .= ' gt-page-title-hidden ';
	}

	// Full-width / No Title Page Template?
	if ( 'templates/template-fullwidth-no-title.php' === get_page_template_slug( $post->ID ) ) {
		$classes .= ' gt-fullwidth-page-layout gt-page-title-hidden ';
	}

	return $classes;
}
#add_filter( 'admin_body_class', 'gt_next_gutenberg_add_admin_body_class' );
