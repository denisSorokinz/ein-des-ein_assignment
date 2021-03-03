<?php

/**
 * ein functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ein
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('ein_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ein_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ein, use a find and replace
		 * to change 'ein' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('ein', get_template_directory() . '/languages');

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
				'menu-1' => esc_html__('Primary', 'ein'),
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
				'ein_custom_background_args',
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
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'ein_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ein_content_width()
{
	$GLOBALS['content_width'] = apply_filters('ein_content_width', 640);
}
add_action('after_setup_theme', 'ein_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ein_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'ein'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'ein'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'ein_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function ein_scripts()
{
	wp_enqueue_style('ein-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('ein-style', 'rtl', 'replace');

	wp_enqueue_script('ein-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	wp_register_script('jq', 'https://code.jquery.com/jquery-3.6.0.min.js', null, null, false);
	wp_enqueue_script('jq');

	wp_enqueue_script(
		'custom',
		get_template_directory_uri() . '/js/script.js',
		array('jq'),
		null,
		false
	);
}
add_action('wp_enqueue_scripts', 'ein_scripts');

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

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

function create_news_taxonomy()
{

	// список параметров: wp-kama.ru/function/get_taxonomy_labels
	register_taxonomy('news_category', ['news'], [
		'labels'                => [
			'name'              => 'News categories',
			'singular_name'     => 'News category',
			'search_items'      => 'Search News categories',
			'all_items'         => 'All News categories',
			'view_item '        => 'View News categories',
			'parent_item'       => 'Parent News categories',
			'parent_item_colon' => 'Parent News categories:',
			'edit_item'         => 'Edit News categories',
			'update_item'       => 'Update News categories',
			'add_new_item'      => 'Add New News categories',
			'new_item_name'     => 'New Genre News categories',
			'menu_name'         => 'News categories',
		],
		'description'           => 'Taxonomy for News post type', // описание таксономии
		'public'                => true,
		// 'publicly_queryable'    => null, // равен аргументу public
		// 'show_in_nav_menus'     => true, // равен аргументу public
		// 'show_ui'               => true, // равен аргументу public
		// 'show_in_menu'          => true, // равен аргументу show_ui
		// 'show_tagcloud'         => true, // равен аргументу show_ui
		// 'show_in_quick_edit'    => null, // равен аргументу show_ui
		'hierarchical'          => false,

		'rewrite'               => true,
		//'query_var'             => $taxonomy, // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => null,
		'show_admin_column'     => false,
		'show_in_rest'          => null,
		'rest_base'             => null,
	]);
}

function news_post_type()
{
	register_post_type(
		'news',
		array(
			'labels'      => array(
				'name'          => __('News', 'textdomain'),
				'singular_name' => __('News', 'textdomain'),
			),
			'description' => "Custom post type - News",
			'public'      => true,
			'has_archive' => true,
			'taxonomies' => array('post_tag', 'news_category'),
			'supports' => array('title', 'editor', 'thumbnail')
		)
	);
}
function register_for_type()
{
	register_taxonomy_for_object_type('news_category', 'news');
}
add_action('init', 'create_news_taxonomy');
add_action('init', 'news_post_type');
add_action('init', 'register_for_type');


function filter_news()
{
	$filterSlug = $_POST["slug"];
	$ajaxposts = [];

	if ($filterSlug != "all") {
		$ajaxposts = new WP_Query([
			'post_type' => 'news',
			'order' => 'ASC',
			'tax_query' => array(
				array(
					'taxonomy' => 'news_category',
					'field' => 'slug',
					'terms' => $filterSlug
				)
			)
		]);
	} else {
		$ajaxposts = new WP_Query(array(
			'post_type' => 'news',
			'order' => 'ASC'
		));;
	}
	$response = '';

	if ($ajaxposts->have_posts()) {
		while ($ajaxposts->have_posts()) : $ajaxposts->the_post();
			$response .= get_template_part('template-parts/news-list-item');
		endwhile;
	} else {
		$response = 'empty';
	}
	echo $response;
	exit;
}

add_action('wp_ajax_news', 'filter_news');
add_action('wp_ajax_nopriv_news', 'filter_news');
