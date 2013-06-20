<?php

$prefixs = 'skypanel_vibration_';

/*** Make sure to change the theme name to the current theme for all functions etc.. ***/



 include_once('scripts/admin/options.php');

/* skyali admin functions and definitions */ 


add_theme_support( 'buddypress' );

add_theme_support( 'custom-background' );


/* extra functions */

include_once('scripts/functions/extra_functions.php');
 

add_action( 'after_setup_theme', 'skyali_setup' );



if ( ! function_exists( 'skyali_setup' ) ):

/* Sets up theme defaults and registers support for various WordPress features.*/

function skyali_setup() {



	// This theme styles the visual editor with editor-style.css to match the theme style.

	add_editor_style();



	// This theme uses post thumbnails

	add_theme_support( 'post-thumbnails' );



	// Add default posts and f RSS feed links to head

	add_theme_support( 'automatic-feed-links' );



	// Make theme available for translation

	// Translations can be filed in the /languages/ directory

	load_theme_textdomain( 'vibration', get_template_directory(). '/languages' );
	

	$locale = get_locale();

	$locale_file = get_template_directory() . "/languages/$locale.php";

	if ( is_readable( $locale_file ) )

		require_once( $locale_file );

		

/**
 * Setup My Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function my_child_theme_setup() {
	load_child_theme_textdomain( 'vibration-child-theme', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'my_child_theme_setup' );


		// Register the wp 3.0 Menus

add_action( 'init', 'register_my_menus' );



	// This theme uses wp_nav_menu() in one location.

function register_my_menus() {

	register_nav_menus(

		array(

			'top-menu' => __( 'Top Menu','vibration' ),

			'bottom-menu' => __( 'Bottom Menu','vibration' )

		)

	);

}



	// This theme allows users to set a custom background

	



	// Your changeable header business starts here

	define( 'HEADER_TEXTCOLOR', '' );

	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.

	define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );



	// The height and width of your custom header. You can hook into the theme's own filters to change these values.

	// Add a filter to skyali_header_image_width and skyali_header_image_height to change these values.

	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'skyali_header_image_width', 940 ) );

	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'skyali_header_image_height', 198 ) );



	// We'll be using post thumbnails for custom header images on posts and pages.

	// We want them to be 940 pixels wide by 198 pixels tall.

	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.

	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );



	// Don't support text inside the header image.

	define( 'NO_HEADER_TEXT', true );



	// Add a way for the custom header to be styled in the admin panel that controls

	// custom headers. See skyali_admin_header_style(), below.

	



	// ... and thus ends the changeable header business.



	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.

	register_default_headers( array(

		'berries' => array(

			'url' => '%s/images/headers/berries.jpg',

			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',

			/* translators: header image description */

			'description' => __( 'Berries', 'vibration' )

		),

		'cherryblossom' => array(

			'url' => '%s/images/headers/cherryblossoms.jpg',

			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',

			/* translators: header image description */

			'description' => __( 'Cherry Blossoms', 'vibration' )

		),

		'concave' => array(

			'url' => '%s/images/headers/concave.jpg',

			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',

			/* translators: header image description */

			'description' => __( 'Concave', 'vibration' )

		),

		'fern' => array(

			'url' => '%s/images/headers/fern.jpg',

			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',

			/* translators: header image description */

			'description' => __( 'Fern', 'vibration' )

		),

		'forestfloor' => array(

			'url' => '%s/images/headers/forestfloor.jpg',

			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',

			/* translators: header image description */

			'description' => __( 'Forest Floor', 'vibration' )

		),

		'inkwell' => array(

			'url' => '%s/images/headers/inkwell.jpg',

			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',

			/* translators: header image description */

			'description' => __( 'Inkwell', 'vibration' )

		),

		'path' => array(

			'url' => '%s/images/headers/path.jpg',

			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',

			/* translators: header image description */

			'description' => __( 'Path', 'vibration' )

		),

		'sunset' => array(

			'url' => '%s/images/headers/sunset.jpg',

			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',

			/* translators: header image description */

			'description' => __( 'Sunset', 'vibration' )

		)

	) );

}

endif;



if ( ! function_exists( 'skyali_admin_header_style' ) ) :

/**

 * Styles the header image displayed on the Appearance > Header admin panel.

 *

 * Referenced via add_custom_image_header() in skyali_setup().

 *

 * 

 */

function skyali_admin_header_style() {

?>

<?php

}

endif;



/**

 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.

 *

 * To override this in a child theme, remove the filter and optionally add

 * your own function tied to the wp_page_menu_args filter hook.

 *

 * 

 */

function skyali_page_menu_args( $args ) {

	$args['show_home'] = true;

	return $args;

}

add_filter( 'wp_page_menu_args', 'skyali_page_menu_args' );



/**

 * Sets the post excerpt length to 40 characters.

 *

 * To override this length in a child theme, remove the filter and add your own

 * function tied to the excerpt_length filter hook.

 *

 * 

 * @return int

 */

function skyali_excerpt_length($length) {

	return 40;

}

add_filter( 'excerpt_length', 'skyali_excerpt_length' );



/**

 * Returns a "Continue Reading" link for excerpts

 *

 * 

 * @return string "Continue Reading" link

 */

function skyali_continue_reading_link() {

	//return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'vibration' ) . '</a>';

}



/**

 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and skyali_continue_reading_link().

 *

 * To override this in a child theme, remove the filter and add your own

 * function tied to the excerpt_more filter hook.

 *

 * 

 * @return string An ellipsis

 */

function skyali_auto_excerpt_more( $more ) {

	return ' [&hellip;]' . skyali_continue_reading_link();

}

add_filter( 'excerpt_more', 'skyali_auto_excerpt_more' );



/**

 * Adds a pretty "Continue Reading" link to custom post excerpts.

 *

 * To override this link in a child theme, remove the filter and add your own

 * function tied to the get_the_excerpt filter hook.

 *

 * 

 * @return string Excerpt with a pretty "Continue Reading" link

 */

function skyali_custom_excerpt_more( $output ) {

	if ( has_excerpt() && ! is_attachment() ) {

		$output .= skyali_continue_reading_link();

	}

	return $output;

}

add_filter( 'get_the_excerpt', 'skyali_custom_excerpt_more' );



/**

 * Remove inline styles printed when the gallery shortcode is used.

 * @return string The gallery style filter, with the styles themselves removed.

 */

function skyali_remove_gallery_css( $css ) {

	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );

}

add_filter( 'gallery_style', 'skyali_remove_gallery_css' );



if ( ! function_exists( 'skyali_comment' ) ) :

/* Template for comments and pingbacks. */

function skyali_comment( $comment, $args, $depth ) {

	

	$GLOBALS['comment'] = $comment;

	switch ( $comment->comment_type ) :

		case '' :

	?>

<li>



<div class="comment"><!-- start of new comment goes inside the li -->



<div class="avatar">



<?php echo get_avatar( $comment, 50 ); ?>



</div><!-- #avatar -->



<?php if ( $comment->comment_approved == '0' ) : ?>



<div id="comment-pending"><?php _e( 'Your Comment is awaiting moderation.', 'vibration' ); ?></div>



<?php endif; ?>



<div class="comment_holder">

<?php _e('<span class="maker_name">', 'vibration');	printf( __( '%s', 'vibration' ), sprintf( '<h5>%s</h5><!-- Comment Maker Name -->', get_comment_author_link() ) ); _e('</span>', 'vibration'); ?>



<?php _e('<span class="date">'); printf( __(  '%1$s at %2$s', 'vibration' ), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( __( ' - (Edit)', 'vibration' ), '' ); _e('</span><!-- #comment date -->', 'vibration');



?>



<div class="comment_box"><p class="no_margin_bottom"><?php echo $comment->comment_content; ?></p></div><!-- #comment box -->



<div class="button"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'class' => 'SOME', 'max_depth' => $args['max_depth'] ) ) ); ?>&raquo;</div><!-- #button -->



</div><!-- #comment_holder -->



</div><!-- #comment -->

    



	<?php

			break;

		case 'pingback'  :

		case 'trackback' :

	?>

	<li class="post pingback">

		<p><?php _e( 'Pingback:', 'vibration' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'vibration'), ' ' ); ?></p>

	<?php

			break;

	endswitch;

}

endif;



/**

 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.

 *

 * To override skyali_widgets_init() in a child theme, remove the action hook and add your own

 * function tied to the init hook.

 *

 * 

 * @uses register_sidebar

 */
 
 

function skyali_widgets_init() {
	
	// Area 0, located at the top of the header.

	register_sidebar( array(

		'name' => __( 'Top Header', 'vibration' ),

		'id' => 'primary-top-header-widget-area',

		'description' => __( 'A widget area for the header primarily for the social icons.', 'vibration' ),

		'before_widget' => '<div id="%1$s" class="sidebar_widget">',

		'after_widget' => '</div>',

		'before_title' => '',

		'after_title' => '',

	) );

	// Area 1, located at the top of the sidebar.

	register_sidebar( array(

		'name' => __( 'Main Sidebar', 'vibration' ),

		'id' => 'primary-widget-area',

		'description' => __( 'The first sidebar widget area', 'vibration' ),

		'before_widget' => '<div id="%1$s" class="sidebar_widget">',

		'after_widget' => '</div>',

		'before_title' => '<span class="heading"><h3>',

		'after_title' => '</h3></span>',

	) );





	// Area 2, located in the sidebar. Empty by default.

	register_sidebar( array(

		'name' => __( 'First Footer Widget Area', 'vibration' ),

		'id' => 'first-footer-widget-area',

		'description' => __( 'The first footer widget area', 'vibration' ),

		'before_widget' => '<div id="%1$s" class="footer_widget">',

		'after_widget' => '</div>',

		'before_title' => '<span class="heading"><h3>',

		'after_title' => '</h3></span>',

	) );

	

	// Area 3, located in the footer. Empty by default.

	register_sidebar( array(

		'name' => __( 'Second Footer Widget Area', 'vibration' ),

		'id' => 'second-footer-widget-area',

		'description' => __( 'The second footer widget area', 'vibration' ),

		'before_widget' => '<div id="%1$s" class="footer_widget">',

		'after_widget' => '</div>',

		'before_title' => '<span class="heading"><h3>',

		'after_title' => '</h3></span>',
	) );



	// Area 4, located in the footer. Empty by default.

	register_sidebar( array(

		'name' => __( 'Third Footer Widget Area', 'vibration' ),

		'id' => 'third-footer-widget-area',

		'description' => __( 'The third footer widget area', 'vibration' ),

		'before_widget' => '<div id="%1$s" class="footer_widget">',

		'after_widget' => '</div>',

		'before_title' => '<span class="heading"><h3>',

		'after_title' => '</h3></span>',

	) );
	
		// Area 4, located in the footer. Empty by default.

	register_sidebar( array(

		'name' => __( 'Fourth Footer Widget Area', 'vibration' ),

		'id' => 'fourth-footer-widget-area',

		'description' => __( 'The footer footer widget area', 'vibration' ),

		'before_widget' => '<div id="%1$s" class="footer_widget">',

		'after_widget' => '</div>',

		'before_title' => '<span class="heading"><h3>',

		'after_title' => '</h3></span>',

	) );


	
	
		// Area 6, located in the page template dual sidebars. Empty by default.

	register_sidebar( array(

		'name' => __( 'Left Dual Page Main Sidebar', 'vibration' ),

		'id' => 'left-dual-main-sidebar-widget-area',

		'description' => __( 'The main area for the left dual sidebar page template', 'vibration' ),

		'before_widget' => '<div id="%1$s" class="left_dual_widget">',

		'after_widget' => '</div>',

		'before_title' => '<span class="heading"><h3>',

		'after_title' => '</h3></span>',

	) );

		// Area 7, located in the page template dual sidebars. Empty by default.

	register_sidebar( array(

		'name' => __( 'Right Dual Page Main Sidebar', 'vibration' ),

		'id' => 'right-dual-main-sidebar-widget-area',

		'description' => __( 'The main area for the right dual sidebar page template', 'vibration' ),
		
		'before_widget' => '<div id="%1$s" class="right_dual_widget">',

		'after_widget' => '</div>',

		'before_title' => '<span class="heading"><h3>',

		'after_title' => '</h3></span>',

	) );





	if(get_option('skypanel_vibration_number_of_custom_sidebars') != ''){

		$sidebar_i = 1;

		$custom_sidebar_nums = get_option('skypanel_vibration_number_of_custom_sidebars');

		while($sidebar_i <= $custom_sidebar_nums){

			// Area Custom Sidebar, located in the sidebar. Empty by default.

	register_sidebar( array(

		'name' => __( 'Custom Sidebar '.$sidebar_i.'', 'vibration' ),

		'id' => 'custom-sidebar-'.$sidebar_i.'-widget-area',

		'description' => __( 'Custom sidebar '.$sidebar_i.' widget area', 'vibration' ),

		'before_widget' => '<div id="%1$s" class="sidebar_widget">',

		'after_widget' => '</div>',

		'before_title' => '<span class="heading"><h3>',

		'after_title' => '</h3></span><!-- heading -->',

	) );

	$sidebar_i++;

		}

	}

	

	if(get_option('skypanel_vibration_number_of_homepage_bottom_widget_areas') != ''){

		$sidebar_i = 1;

		$custom_sidebar_nums = get_option('skypanel_vibration_number_of_homepage_bottom_widget_areas');

		while($sidebar_i <= $custom_sidebar_nums){

			// Area Custom Sidebar, located in the sidebar. Empty by default.

	register_sidebar( array(

		'name' => __( 'Bottom Homepage Areas '.$sidebar_i.'', 'vibration' ),

		'id' => 'bottom-homepage-'.$sidebar_i.'-widget-area',

		'description' => __( 'Bottom Homepage Areas '.$sidebar_i.' widget area', 'vibration' ),

		'before_widget' => '<div id="%1$s" class="widget">',

		'after_widget' => '</div><!-- #widget -->',

		'before_title' => '<div class="heading"><h4>',

		'after_title' => '</h4></div>',

	) );

	$sidebar_i++;

		}

	}



}



add_filter('widget_text', 'do_shortcode');



/** Register sidebars by running skyali_widgets_init() on the widgets_init hook. */

add_action( 'widgets_init', 'skyali_widgets_init' );



/**

 * Removes the default styles that are packaged with the Recent Comments widget.

 *

 * To override this in a child theme, remove the filter and optionally add your own

 * function tied to the widgets_init action hook.

 *

 * 

 */

function skyali_remove_recent_comments_style() {

	global $wp_widget_factory;

	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );

}

add_action( 'widgets_init', 'skyali_remove_recent_comments_style' );



if ( ! function_exists( 'skyali_posted_on' ) ) :

/**

 * Prints HTML with meta information for the current post—date/time and author.

 *

 * 

 */

function skyali_posted_on() {

	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'vibration' ),

		'meta-prep meta-prep-author',

		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',

			get_permalink(),

			esc_attr( get_the_time() ),

			get_the_date()

		),

		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',

			get_author_posts_url( get_the_author_meta( 'ID' ) ),

			sprintf( esc_attr__( 'View all posts by %s', 'vibration' ), get_the_author() ),

			get_the_author()

		)

	);

}

endif;



if ( ! function_exists( 'skyali_posted_in' ) ) :

/**

 * Prints HTML with meta information for the current post (category, tags and permalink).

 *

 * 

 */

function skyali_posted_in() {

	// Retrieves tag list of current post, separated by commas.

	$tag_list = get_the_tag_list( '', ', ' );

	if ( $tag_list ) {

		$posted_in = __( 'in %1$s', 'vibration' ); //__( 'in %1$s <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'vibration' );

	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {

		$posted_in = __( 'in %1$s', 'vibration' ); //Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>

	} else {

		//$posted_in = __( 'in %1$s', 'vibration' ); //

	}

	// Prints the string, replacing the placeholders.

	printf(

		$posted_in,

		get_the_category_list( ', ' ),

		$tag_list,

		get_permalink(),

		the_title_attribute( 'echo=0' )

	);

}

endif;



if (function_exists('add_theme_support')) {

    add_theme_support('menus');

}







/*converts hex into rgb color for admin panel*/



function hex2rgb($hex) {

   $hex = str_replace("#", "", $hex);

 

   if(strlen($hex) == 3) {

      $r = hexdec(substr($hex,0,1).substr($hex,0,1));

      $g = hexdec(substr($hex,1,1).substr($hex,1,1));

      $b = hexdec(substr($hex,2,1).substr($hex,2,1));

   } else {

      $r = hexdec(substr($hex,0,2));

      $g = hexdec(substr($hex,2,2));

      $b = hexdec(substr($hex,4,2));

   }

   $rgb = array($r, $g, $b);

   //return implode(",", $rgb); // returns the rgb values separated by commas

   return $rgb; // returns an array with the rgb values

}





add_filter( 'get_media_item_args', 'force_send' );

function force_send($args){

	$args['send'] = true;

	return $args;

}



add_theme_support( 'post-thumbnails' );

add_image_size( 'latest-news', 600, 420, true ); 

add_image_size( 'latest-news-style-2', 790, 520, true ); 

add_image_size( 'shows', 550, 450, true ); 

add_image_size( 'latest_photo', 350, 350, true ); 

add_image_size( 'latest_video', 600, 550, true ); 

add_image_size( 'news-widget', 100, 100, true ); 

add_image_size( 'blog-single', 800, 600, true ); 

add_image_size( 'blog-single-related', 250, 200, true ); 


/**

 * Get rid of "Cheatin' uh?" error

 * note: this will create a persistent "Hello World" post

 */

function aq_cheatin_uh(){

	$id = 1;

	$check = get_post($id);

	

	if(! $check ) {

		$post = array(

		'post_title'=>'Hello World',

		'post_content'=>'whatever',

		'import_id'=>1,

		);

		wp_insert_post($post);

	}

}

add_action('init', 'aq_cheatin_uh');
 
// Actual processing of the shortcode happens here
function foobar_run_shortcode( $content ) {
    global $shortcode_tags;
 
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
    remove_all_shortcodes();
 
	add_shortcode( 'one_half', 'shortcode_onehalf' );
	add_shortcode( 'one_third', 'shortcode_onethird' );
	add_shortcode( 'one_fourth', 'shortcode_onefourth' );
	add_shortcode( 'two_thirds', 'shortcode_twothirds' );
	add_shortcode( 'three_fourths', 'shortcode_threefourths' );
 
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode( $content );
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}
 
add_filter( 'the_content', 'foobar_run_shortcode', 7 );

 // get taxonomies terms links
function custom_taxonomies_terms_links() {
	global $post, $post_id;
	// get post by post id
	$post = &get_post($post->ID);
	// get post type by post
	$post_type = $post->post_type;
	// get post type taxonomies
	$taxonomies = get_object_taxonomies($post_type);
	foreach ($taxonomies as $taxonomy) {
		// get the terms related to post
		$terms = get_the_terms( $post->ID, $taxonomy );
		if ( !empty( $terms ) ) {
			$out = array();
			foreach ( $terms as $term )
				$out[] = '<a href="' .get_term_link($term->slug, $taxonomy) .'">'.$term->name.'</a>';
			$return = join( ', ', $out );
		}
	}
	return $return;
} 

add_filter('the_content', 'addfancyboxrel', 12);
add_filter('get_comment_text', 'addfancyboxrel');
function addfancyboxrel ($content)
{   global $post;
	$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
    $replacement = '<a$1href=$2$3.$4$5 rel="fancybox2"$6>$7</a>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
 
function my_theme_wrapper_start() {
  echo '<section id="main">';
}
 
function my_theme_wrapper_end() {
  echo '</section>';
}

add_theme_support( 'woocommerce' );


// Get the id of a page by its name
function get_page_id($page_name){
	global $wpdb;
	$page_name = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."'");
	return $page_name;
}

function get_my_id (){
	the_ID();
	post_class(); 
}

?>
