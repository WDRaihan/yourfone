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
 */
function yourfone_setup() {
	/*
	* Make theme available for translation.
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
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

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
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Top Column 1', 'yourfone' ),
			'id'            => 'footer-top-1',
			'description'   => esc_html__( 'Add widgets here.', 'yourfone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Top Column 2', 'yourfone' ),
			'id'            => 'footer-top-2',
			'description'   => esc_html__( 'Add widgets here.', 'yourfone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Top Column 3', 'yourfone' ),
			'id'            => 'footer-top-3',
			'description'   => esc_html__( 'Add widgets here.', 'yourfone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Top Column 4', 'yourfone' ),
			'id'            => 'footer-top-4',
			'description'   => esc_html__( 'Add widgets here.', 'yourfone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Bottom Column 1', 'yourfone' ),
			'id'            => 'footer-bottom-1',
			'description'   => esc_html__( 'Add widgets here.', 'yourfone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Bottom Column 2', 'yourfone' ),
			'id'            => 'footer-bottom-2',
			'description'   => esc_html__( 'Add widgets here.', 'yourfone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Bottom Column 3', 'yourfone' ),
			'id'            => 'footer-bottom-3',
			'description'   => esc_html__( 'Add widgets here.', 'yourfone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Bottom Column 4', 'yourfone' ),
			'id'            => 'footer-bottom-4',
			'description'   => esc_html__( 'Add widgets here.', 'yourfone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Copyright Left', 'yourfone' ),
			'id'            => 'footer-copyright-1',
			'description'   => esc_html__( 'Add widgets here.', 'yourfone' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Copyright Right', 'yourfone' ),
			'id'            => 'footer-copyright-2',
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
 * Enqueue scripts and styles in admin dashboard.
 */
function yourfone_admin_scripts() {
	wp_enqueue_style( 'yourfone-admin-style', get_template_directory_uri().'/css/admin/style.css', array(), _S_VERSION );
	wp_enqueue_script( 'yourfone-admin-script', get_template_directory_uri().'/js/admin/script.js', array('jquery'), _S_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'yourfone_admin_scripts' );

/* Add arrow to menu */
function yourfone_add_arrow_to_menu_items( $items, $args ) {
    foreach ( $items as $item ) {
        if ( in_array( 'menu-item-has-children', $item->classes ) ) {
            $item->title .= ' <span class="submenu-arrow"><img class="down" src="' . get_template_directory_uri() . '/assets/images/rectangle-down.png"><img class="up" src="' . get_template_directory_uri() . '/assets/images/rectangle-up.png"></span>';
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_objects', 'yourfone_add_arrow_to_menu_items', 10, 2 );

/*
* WooCommerce customizations
*/
require_once 'woocommerce-features.php';

add_shortcode( 'single_variations', 'yourfone_single_variations_shortcode' );
function yourfone_single_variations_shortcode() {  
	
   $query = new WP_Query( array(
      'post_type' => 'product_variation',
      'post_status' => 'publish',
      'posts_per_page' => 24,
      'paged' => absint( empty( $_GET['product-page'] ) ? 1 : $_GET['product-page'] ),
	  'meta_query'    => array(
			array(
				'key'       => 'attribute_pa_condition',
				'value'     => 'good',
				'compare'   => '=',
			),
		),
   ));
   if ( $query->have_posts() ) {
      ob_start();
	   
      wc_setup_loop(
         array(
            'name' => 'single_variations',
            'is_shortcode' => true,
            'is_search' => false,
            'is_paginated' => true,
            'total' => $query->found_posts,
            'total_pages' => $query->max_num_pages,
            'per_page' => $query->get( 'posts_per_page' ),
            'current_page' => max( 1, $query->get( 'paged', 1 ) ),
         )
      );
	   echo '<div class="woocommerce">';
	   woocommerce_output_content_wrapper();
      woocommerce_pagination();
      woocommerce_product_loop_start();
      while ( $query->have_posts() ) {
         $query->the_post();
         	wc_get_template_part( 'content', 'product' );
      }
      woocommerce_product_loop_end();
      woocommerce_pagination();
      wp_reset_postdata();
      wc_reset_loop();
	   woocommerce_output_content_wrapper();
	   echo '</div>';
      return ob_get_clean();
   }
   return;
}
