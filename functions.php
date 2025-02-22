<?php
/**
 * YourFone functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package YourFone
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function yourfone_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on YourFone, use a find and replace
		* to change 'yourfone' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'yourfone', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'yourfone' ),
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
			'yourfone_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

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
	
	//Support WooComerce
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'yourfone_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function yourfone_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'yourfone_content_width', 640 );
}
add_action( 'after_setup_theme', 'yourfone_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function yourfone_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'yourfone' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'yourfone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'yourfone_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function yourfone_scripts() {
	wp_enqueue_style( 'yourfone-bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), _S_VERSION );
	wp_enqueue_style( 'yourfone-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'yourfone-style', 'rtl', 'replace' );

	wp_enqueue_script( 'yourfone-navigation', '//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array('jquery'), _S_VERSION, false );
	wp_enqueue_script( 'yourfone-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'yourfone_scripts' );

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
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function add_arrow_to_menu_items( $items, $args ) {
    foreach ( $items as $item ) {
        if ( in_array( 'menu-item-has-children', $item->classes ) ) {
            $item->title .= ' <span class="submenu-arrow"><img class="down" src="' . get_template_directory_uri() . '/assets/images/rectangle-down.png"><img class="up" src="' . get_template_directory_uri() . '/assets/images/rectangle-up.png"></span>';
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_objects', 'add_arrow_to_menu_items', 10, 2 );

/*
* WooCommerce customizations
*/

/*Init hooks*/
function yourfone_init(){
	remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	add_action('woocommerce_before_main_content', 'yourfone_output_content_wrapper', 10);
	add_action('woocommerce_after_main_content', 'yourfone_output_content_wrapper_end', 10);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
	add_action('woocommerce_shop_loop_item_title', 'yourfone_add_color_attribute_before_title', 5);
	add_action('woocommerce_shop_loop_item_title', 'yourfone_add_condition_attribute_after_title', 15);
	remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
}
add_action('init', 'yourfone_init');

/* Archive wrapper start */
function yourfone_output_content_wrapper(){
	echo '<div id="main"><div class="container">';
}

/* Archive wrapper end */
function yourfone_output_content_wrapper_end(){
	echo '<div><div>';
}

/* Customize the product title in the product loop */
function woocommerce_template_loop_product_title() {
	$html = '<div class="loop-title-wrapper">';
	$html .= '<a href="' . esc_url( get_the_permalink() ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
	$html .= '<h2 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</h2>';
	$html .= '</a>';
	$html .= '<span class="attr-capacity">512 GB</span>';
	$html .= '</div>';
	echo $html;
}

/* Add color before title in product loop */
function yourfone_add_color_attribute_before_title(){
	echo '<div class="loop-color-wrapper"><span class="attr-color"></span><span class="attr-color-text">Space Black</span></div>';
}

/* Add condition and add to cart button after title in product loop */
function yourfone_add_condition_attribute_after_title(){
	$html = '<div class="loop-condition-wrapper">';
	$html .= '<div class="attr-condition">';
	$html .= '<span class="condition-title">Condition: </span><span class="condition-text">Good</span>';
	$html .= '</div>';
	$html .= '<div class="custom-add-to-cart-btn">';
	$html .= '<a href="'.esc_url( get_the_permalink() ).'"><img src="'.get_template_directory_uri().'/assets/images/eye.png"></a>';
	$html .= '</div>';
	$html .= '</div>';
	echo $html;
}