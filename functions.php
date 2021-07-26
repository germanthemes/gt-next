<?php
/**
 * GT Next functions and definitions
 *
 * @package GT Next
 */

/**
 * GT Next only works in WordPress 5.8 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '5.8', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}


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

	// Add image size for header image on single posts and pages.
	add_image_size( 'gt-next-header-image', 9999, 640, true );

	// Register Navigation Menus.
	register_nav_menus( array(
		'primary'       => esc_html__( 'Main Navigation', 'gt-next' ),
		'footer'        => esc_html__( 'Footer Navigation', 'gt-next' ),
		'social-header' => esc_html__( 'Social Icons (Header)', 'gt-next' ),
		'social-footer' => esc_html__( 'Social Icons (Footer)', 'gt-next' ),
	) );

	// Switch default core markup for galleries and captions to output valid HTML5.
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom logo feature.
	add_theme_support( 'custom-logo', apply_filters( 'gt_next_custom_logo_args', array(
		'height'      => 60,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
	) ) );

	// Set up the WordPress core custom header feature.
	add_theme_support( 'custom-header', apply_filters( 'gt_next_custom_header_args', array(
		'header-text' => false,
		'width'       => 9999,
		'height'      => 640,
	) ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'gt_next_custom_background_args', array(
		'default-color' => 'ffffff',
	) ) );

	// Add Theme Support for Selective Refresh in Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
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
 * Register widget areas and custom widgets.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function gt_next_widgets_init() {

	// Register Blog Sidebar widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'gt-next' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html_x( 'Appears on blog pages and single posts.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register Before Header widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Before Header', 'gt-next' ),
		'id'            => 'before-header',
		'description'   => esc_html_x( 'Appears above the header area.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register After Header widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'After Header', 'gt-next' ),
		'id'            => 'after-header',
		'description'   => esc_html_x( 'Appears below the header area.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register Before Blog widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Before Content', 'gt-next' ),
		'id'            => 'before-content',
		'description'   => esc_html_x( 'Appears above the content area.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register After Posts widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'After Single Posts', 'gt-next' ),
		'id'            => 'after-posts',
		'description'   => esc_html_x( 'Appears below single posts.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register After Pages widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'After Pages', 'gt-next' ),
		'id'            => 'after-pages',
		'description'   => esc_html_x( 'Appears below static pages.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register Before Footer widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Before Footer', 'gt-next' ),
		'id'            => 'before-footer',
		'description'   => esc_html_x( 'Appears above the footer area.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Register Footer Column 1 widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'gt-next' ),
		'id'            => 'footer-column-1',
		'description'   => esc_html_x( 'Appears in the first column in footer.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	// Register Footer Column 2 widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'gt-next' ),
		'id'            => 'footer-column-2',
		'description'   => esc_html_x( 'Appears in the second column in footer.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	// Register Footer Column 3 widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'gt-next' ),
		'id'            => 'footer-column-3',
		'description'   => esc_html_x( 'Appears in the third column in footer.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	// Register Footer Column 4 widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 4', 'gt-next' ),
		'id'            => 'footer-column-4',
		'description'   => esc_html_x( 'Appears in the fourth column in footer.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	// Register Footer Copyright widget area.
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Copyright', 'gt-next' ),
		'id'            => 'footer-copyright',
		'description'   => esc_html_x( 'Appears in the bottom footer line.', 'widget area description', 'gt-next' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'gt_next_widgets_init' );


/**
 * Include Files
 */

// Include Customizer Options.
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/default-options.php';

// Include Template Functions.
require get_template_directory() . '/inc/template-functions.php';

// Include Template Tags.
require get_template_directory() . '/inc/template-tags.php';

// Include Gutenberg Features.
require get_template_directory() . '/inc/gutenberg.php';

// Include Customization Features.
require get_template_directory() . '/inc/custom-colors.php';
require get_template_directory() . '/inc/custom-fonts.php';
