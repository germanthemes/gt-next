<?php
/**
 * GT Next functions and definitions
 *
 * @package GT Next
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function gt_next_setup() {

	// Make theme available for translation.
	load_theme_textdomain( 'gt-next', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Set default Post Thumbnail size.
	set_post_thumbnail_size( 1600, 900, true );

	// Register Navigation Menus.
	register_nav_menus( array(
		'primary'       => esc_html__( 'Main Navigation', 'gt-next' ),
		'footer'        => esc_html__( 'Footer Navigation', 'gt-next' ),
		'social-header' => esc_html__( 'Social Icons (Header)', 'gt-next' ),
		'social-footer' => esc_html__( 'Social Icons (Footer)', 'gt-next' ),
	) );

	// Set up the WordPress core custom logo feature.
	add_theme_support( 'custom-logo', apply_filters( 'gt_next_custom_logo_args', array(
		'height'      => 60,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
	) ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'gt_next_custom_background_args', array(
		'default-color' => 'ffffff',
	) ) );
}
add_action( 'after_setup_theme', 'gt_next_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gt_next_content_width() {
	// Set global variable for content width.
	$GLOBALS['content_width'] = apply_filters( 'gt_next_content_width', 800 );
}
add_action( 'after_setup_theme', 'gt_next_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function gt_next_scripts() {

	// Get Theme Version.
	$theme_version = wp_get_theme()->get( 'Version' );

	// Register and Enqueue Stylesheet.
	wp_enqueue_style( 'gt-next-stylesheet', get_stylesheet_uri(), array(), $theme_version );

	// Register Comment Reply Script for Threaded Comments.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gt_next_scripts' );


/**
* Enqueue theme fonts.
*/
function gt_next_theme_fonts() {
	$fonts_url = gt_next_get_fonts_url();

	// Load Fonts if necessary.
	if ( $fonts_url ) {
		require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );
		wp_enqueue_style( 'gt-next-theme-fonts', wptt_get_webfont_url( $fonts_url ), array(), '20210105' );
	}
}
add_action( 'wp_enqueue_scripts', 'gt_next_theme_fonts', 1 );
add_action( 'enqueue_block_editor_assets', 'gt_next_theme_fonts', 1 );


/**
 * Retrieve webfont URL to load fonts locally.
 */
function gt_next_get_fonts_url() {
	$font_families = array(
		'Roboto:400,400italic,700,700italic',
	);

	$query_args = array(
		'family'  => urlencode( implode( '|', $font_families ) ),
		'subset'  => urlencode( 'latin,latin-ext' ),
		'display' => urlencode( 'swap' ),
	);

	return apply_filters( 'gt_next_get_fonts_url', add_query_arg( $query_args, 'https://fonts.googleapis.com/css' ) );
}

/**
 * Include Files
 */

// Include Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';

// Include Block Styles.
require get_template_directory() . '/inc/block-styles.php';

// Include Gutenberg Features.
require get_template_directory() . '/inc/gutenberg.php';

// Include Customization Features.
#require get_template_directory() . '/inc/custom-colors.php';
#require get_template_directory() . '/inc/custom-fonts.php';
