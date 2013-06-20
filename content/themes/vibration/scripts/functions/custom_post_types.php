<?php
/* Custom Post Types */

/* Albums */
add_action('init', 'skyali_custom1_init');
function skyali_custom1_init() 
{
  $labels = array(
    'name' => _x('Albums', 'post type general name','vibration'),
    'singular_name' => _x('Albums', 'post type singular name','vibration'),
    'add_new' => _x('Add New', 'Album','vibration'),
    'add_new_item' => __('Add New Album'),'vibration',
    'edit_item' => __('Edit Album','vibration'),
    'new_item' => __('New Album','vibration'),
    'view_item' => __('View Album','vibration'),
    'search_items' => __('Search Albums','vibration'),
    'not_found' =>  __('No albums found','vibration'),
    'not_found_in_trash' => __('No albums items found in trash','vibration'), 
    'parent_item_colon' => '',
    'menu_name' => 'Albums',

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
     'supports' => array('title','editor','author','thumbnail','comments'),
	//'menu_icon' => ''.get_template_directory_uri().'/images/testimonials.png',
  ); 
  register_post_type('albums',$args);
}

function albums_post_type_categories() {
	// create a new taxonomy
	register_taxonomy(__( "albums_categories" ), array(__( "albums" )), array("hierarchical" => true, "label" => __( "Categories" ), "singular_label" => __( "Categories" ), "rewrite" => array('slug' => 'albums_categories', 'hierarchical' => true))); 
}


add_action( 'init', 'albums_post_type_categories', 0 );


/* Shows */
add_action('init', 'skyali_custom2_init');
function skyali_custom2_init() 
{
  $labels = array(
    'name' => _x('Shows', 'post type general name','vibration'),
    'singular_name' => _x('Shows', 'post type singular name','vibration'),
    'add_new' => _x('Add New', 'Show','vibration'),
    'add_new_item' => __('Add New Show'),'vibration',
    'edit_item' => __('Edit Show','vibration'),
    'new_item' => __('New Show','vibration'),
    'view_item' => __('View Show','vibration'),
    'search_items' => __('Search Shows','vibration'),
    'not_found' =>  __('No shows found','vibration'),
    'not_found_in_trash' => __('No shows items found in trash','vibration'), 
    'parent_item_colon' => '',
    'menu_name' => 'Shows',

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author','thumbnail'),
	//'menu_icon' => ''.get_template_directory_uri().'/images/testimonials.png',
  ); 
  register_post_type('shows',$args);
}

function shows_post_type_categories() {
	// create a new taxonomy
	register_taxonomy(__( "shows_categories" ), array(__( "shows" )), array("hierarchical" => true, "label" => __( "Categories" ), "singular_label" => __( "Categories" ), "rewrite" => array('slug' => 'shows_categories', 'hierarchical' => true))); 
}


add_action( 'init', 'shows_post_type_categories', 0 );


/* Gallery */
add_action('init', 'skyali_custom3_init');
function skyali_custom3_init() 
{
  $labels = array(
    'name' => _x('Gallery', 'post type general name','vibration'),
    'singular_name' => _x('Gallery', 'post type singular name','vibration'),
    'add_new' => _x('Add New', 'Gallery','vibration'),
    'add_new_item' => __('Add New Gallery'),'vibration',
    'edit_item' => __('Edit Gallery','vibration'),
    'new_item' => __('New Gallery','vibration'),
    'view_item' => __('&nbsp;','vibration'),
    'search_items' => __('Search Gallery','vibration'),
    'not_found' =>  __('No Gallery found','vibration'),
    'not_found_in_trash' => __('No Gallery items found in trash','vibration'), 
    'parent_item_colon' => '',
    'menu_name' => 'Gallery',

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author','thumbnail'),
	//'menu_icon' => ''.get_template_directory_uri().'/images/testimonials.png',
  ); 
  register_post_type('gallery',$args);
  remove_post_type_support( 'gallery', 'editor' );
}
function gallery_post_type_categories() {
	// create a new taxonomy
	register_taxonomy(__( "gallery_categories" ), array(__( "gallery" )), array("hierarchical" => true, "label" => __( "Categories" ), "singular_label" => __( "Categories" ), "rewrite" => array('slug' => 'gallery_categories', 'hierarchical' => true))); 
}


add_action( 'init', 'gallery_post_type_categories', 0 );

/* Video */
add_action('init', 'skyali_custom4_init');
function skyali_custom4_init() 
{
  $labels = array(
    'name' => _x('Video', 'post type general name','vibration'),
    'singular_name' => _x('Videos', 'post type singular name','vibration'),
    'add_new' => _x('Add New', 'Video','vibration'),
    'add_new_item' => __('Add New Video'),'vibration',
    'edit_item' => __('Edit Video','vibration'),
    'new_item' => __('New Video','vibration'),
    'view_item' => __(' ','vibration'),
    'search_items' => __('Search Videos','vibration'),
    'not_found' =>  __('No Videos found','vibration'),
    'not_found_in_trash' => __('No Videos items found in trash','vibration'), 
    'parent_item_colon' => '',
    'menu_name' => 'Videos',

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
     'supports' => array('title','editor','author','thumbnail'),
	//'menu_icon' => ''.get_template_directory_uri().'/images/testimonials.png',
  ); 
  register_post_type('videos',$args);
  remove_post_type_support( 'videos', 'editor' );
}

function videos_post_type_categories() {
	// create a new taxonomy
	register_taxonomy(__( "videos_categories" ), array(__( "videos" )), array("hierarchical" => true, "label" => __( "Categories" ), "singular_label" => __( "Categories" ), "rewrite" => array('slug' => 'videos_categories', 'hierarchical' => true))); 
}


add_action( 'init', 'videos_post_type_categories', 0 );


?>