<?php
/** Start the engine */
require_once( TEMPLATEPATH . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'Agency Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/themes/agency' );

$content_width = apply_filters( 'content_width', 590, 410, 910 );

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'agency_viewport_meta_tag' );
function agency_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Create additional color style options */
add_theme_support( 'genesis-style-selector', array( 'agency-green' => 'Green', 'agency-orange' => 'Orange', 'agency-red' => 'Red' ) );

/** Add support for structural wraps */
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

/** Add new image sizes */
add_image_size( 'home-featured', 280, 100, TRUE );

/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array( 'width' => 590, 'height' => 89 ) );

/** Add support for custom background */
add_custom_background();

/** Add product post type support for Geneiss layouts */
add_theme_support( 'genesis-connect-woocommerce' );
add_post_type_support( 'product', 'genesis-layouts' );

/** Set Genesis Responsive Slider defaults */
add_filter( 'genesis_responsive_slider_settings_defaults', 'agency_responsive_slider_defaults' );
function agency_responsive_slider_defaults( $defaults ) {
	$defaults['slideshow_height'] = '300';
	$defaults['slideshow_width'] = '950';
	return $defaults;
}

/** Relocate breadcrumbs */
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );

/** Customize the post info function */
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
if (!is_page()) {
    $post_info = '[post_date] by [post_author_posts_link] &middot; [post_comments] [post_edit]';
    return $post_info;
}}

/** Customize the post meta function */
add_filter( 'genesis_post_meta', 'post_meta_filter' );
function post_meta_filter($post_meta) {
if (!is_page()) {
    $post_meta = '[post_categories before="Filed Under: "] &middot; [post_tags before="Tagged: "]';
    return $post_meta;
}}

/** Modify the size of the Gravatar in the author box */
add_filter( 'genesis_author_box_gravatar_size', 'agency_author_box_gravatar_size' );
function agency_author_box_gravatar_size($size) {
    return '78';
}

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Register widget areas */
genesis_register_sidebar( array(
	'id'			=> 'home-welcome',
	'name'			=> __( 'Home Welcome', 'agency' ),
	'description'	=> __( 'This is the welcome section of the homepage.', 'agency' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-slider',
	'name'			=> __( 'Home Slider', 'agency' ),
	'description'	=> __( 'This is the slider section of the homepage.', 'agency' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-left',
	'name'			=> __( 'Home Left', 'agency' ),
	'description'	=> __( 'This is the left section of the homepage.', 'agency' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-middle',
	'name'			=> __( 'Home Middle', 'agency' ),
	'description'	=> __( 'This is the middle section of the homepage.', 'agency' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-right',
	'name'			=> __( 'Home Right', 'agency' ),
	'description'	=> __( 'This is the right section of the homepage.', 'agency' ),
) );

/**
 * Rename default 'Categories' and 'Tags' to be anything you want
 */
function rename_default_cat_tag_init() {

    global $wp_taxonomies;

    // Rename Categories
     $wp_taxonomies['category']->labels = (object) array(
        'name' => 'Locations',
        'singular_name' => 'Location',
        'all_items' => 'All Locations',
        'edit_item' => 'Edit Location',
        'menu_name' => 'Locations',
        'update_item' => 'Update Location',
        'add_new_item' => 'Add New Location',
        'search_items' => 'Search Locations',
        'popular_items' => 'Popular Locations',
        'new_item_name' => 'New Location Name',
        'add_or_remove_items' => 'Add or remove Locations',
        'parent_item' => 'Parent Location',
        'parent_item_colon' => 'Parent Location:',
        'choose_from_most_used' => 'Choose from most used Locations',
        'separate_items_with_commas' => 'Separate Locations with commas',
    );
    $wp_taxonomies['category']->label = 'Locations';

    // Rename Tags
    $wp_taxonomies['post_tag']->labels = (object) array(
        'name'          => 'Colors',
        'singular_name' => 'Color',
        'all_items'     => 'All Colors',
        'edit_item'     => 'Edit Color',
        'menu_name'     => 'Colors',
        'update_item'   => 'Update Color',
        'add_new_item'  => 'Add New Color',
        'search_items'  => 'Search Colors',
        'popular_items' => 'Popular Colors',
        'new_item_name' => 'New Color Name',
        'add_or_remove_items' => 'Add or remove Colors',
        'parent_item'   => null, 'parent_item_colon' => null,
        'choose_from_most_used' => 'Choose from most used Colors',
        'separate_items_with_commas' => 'Separate Colors with commas',
    );
    $wp_taxonomies['post_tag']->label = 'Colors';

}

add_action( 'init', 'rename_default_cat_tag_init' );

add_action('wp_enqueue_scripts', 'load_javascript_files');
function load_javascript_files() {
    wp_register_script('jqueryUI', get_stylesheet_directory_uri() . '/js/jquery-ui.js', array('jquery'), true );
    wp_register_script('theme', get_stylesheet_directory_uri() . '/js/theme.js', array('jquery', 'jqueryUI' ), true );
    wp_enqueue_script('jqueryUI');
    wp_enqueue_script('theme');
}

