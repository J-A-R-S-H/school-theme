<?php

/**
 * School Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package School_Theme
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function school_theme_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on School Theme, use a find and replace
	 * to change 'school-theme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('school-theme', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'school-theme'),
			'footer-right' => esc_html__('Footer - Right Side', 'school-the'),

		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'school_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);

	add_theme_support('align-wide');
}
add_action('after_setup_theme', 'school_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function school_theme_content_width()
{
	$GLOBALS['content_width'] = apply_filters('school_theme_content_width', 640);
}
add_action('after_setup_theme', 'school_theme_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function school_theme_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'school-theme'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'school-theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'school_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function school_theme_scripts()
{
	wp_enqueue_style('school-theme-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('school-theme-style', 'rtl', 'replace');

	wp_enqueue_script('school-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'school_theme_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

//load the cpt file
require get_template_directory() . '/inc/cpt-taxonomy.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}


function fwd_scripts()
{


	wp_enqueue_style(
		"aos-styles",
		get_template_directory_uri() . "/aos.css",
		array(),
		"2.3.2",
	);


	wp_enqueue_script(
		"aos-scripts",
		get_template_directory_uri() . "/js/aos.js",
		array(),
		"2.3.2",
		array("strategy" => "defer"),
	);

	wp_enqueue_script(
		"aos-settings",
		get_template_directory_uri() . "/js/aos-settings.js",
		array("aos-scripts"),
		_S_VERSION,
		array("strategy" => "defer")
	);
}
add_action('wp_enqueue_scripts', 'fwd_scripts');


function wpb_change_title_text($title)
{
	$screen = get_current_screen();

	if ('fwd-staff' == $screen->post_type) {
		$title = 'Add staff name';
	}


	if ('fwd-student' == $screen->post_type) {
		$title = 'Add Student name';
	}


	return $title;
}

add_filter('enter_title_here', 'wpb_change_title_text');

function fwd_block_editor_templates()
{

	if (isset($_GET['post_type']) && 'fwd-student' == $_GET['post_type']) {
		$post_type_object = get_post_type_object('fwd-student');
		$post_type_object->template = array(
			// define blocks here...
			array(
				'core/paragraph',
				array(
					'placeholder' => 'Add your paragraph here...'
				)
			),
			array(
				'core/button',
				array(
					'placeholder' => 'Add your link here...',
				)
			),

		);
		$post_type_object->template_lock = 'all';
	}
}

add_action('init', 'fwd_block_editor_templates');







add_image_size("custom-image-23", 200, 300, true);
