<?php
/*
 * Plugin Name: Skyali Page Builder
 * Plugin URI: URI: http://londonthemes.com/index.php?themeforest=true
 * Description: Skyali's page builder
 * Version: 1.0
 * Author: Skyali
 * Author URI: URI: http://londonthemes.com/index.php?themeforest=true
 */
define( 'SKYALI_DIR', trailingslashit( dirname(__FILE__) ) );
define( 'SKYALI_THEME_URI', get_template_directory_uri().'/scripts/functions/page_builder' );
error_reporting(0);
add_action( 'init', 'skyali_plugin_main' );
function skyali_plugin_main(){
	global $Skyalinav;
	
	if ( ! is_array($Skyalinav) ){
		if ( ! function_exists( 'skyali_lt_new_thumb_resize' ) ){
			function skyali_lt_new_thumb_resize( $thumbnail, $width, $height, $alt='', $forstyle = false ){
				global $shortname;
					
				$new_method = true;
				$new_method_thumb = '';
				$external_source = false;
					
				$allow_new_thumb_method = !$external_source && $new_method;
				
				if ( $allow_new_thumb_method && $thumbnail <> '' ){
					$skyali_crop = true;
					$new_method_thumb = skyali_lt_resize_image( $thumbnail, $width, $height, $skyali_crop );
					if ( is_wp_error( $new_method_thumb ) ) $new_method_thumb = '';
				}
				
				$thumb = esc_attr( $new_method_thumb );
				
				$output = '<img src="' . esc_url( $thumb ) . '" alt="' . esc_attr( $alt ) . '" width =' . esc_attr( $width ) . ' height=' . esc_attr( $height ) . ' />';
				
				return ( !$forstyle ) ? $output : $thumb;
			}
		}

		if ( ! function_exists( 'skyali_lt_resize_image' ) ){
			function skyali_lt_resize_image( $thumb, $new_width, $new_height, $crop ){
				if ( is_ssl() ) $thumb = preg_replace( '#^http://#', 'https://', $thumb );
				$info = pathinfo($thumb);
				$ext = $info['extension'];
				$name = wp_basename($thumb, ".$ext");
				$is_jpeg = false;
				$site_uri = apply_filters( 'skyali_lt_resize_image_site_uri', site_url() );
				$site_dir = apply_filters( 'skyali_lt_resize_image_site_dir', ABSPATH );
				
				#get main site url on multisite installation 
				if ( is_multisite() ){
					switch_to_blog(1);
					$site_uri = site_url();
					restore_current_blog();
				}
				
				if ( 'jpeg' == $ext ) {
					$ext = 'jpg';
					$name = preg_replace( '#.jpeg$#', '', $name );
					$is_jpeg = true;
				}
				
				$suffix = "{$new_width}x{$new_height}";
				
				$destination_dir = '' != get_option( 'skyali_lt_images_temp_folder' ) ? preg_replace( '#\/\/#', '/', get_option( 'skyali_lt_images_temp_folder' ) ) : null;
				
				$matches = apply_filters( 'skyali_lt_resize_image_site_dir', array(), $site_dir );
				if ( !empty($matches) ){
					preg_match( '#'.$matches[1].'$#', $site_uri, $site_uri_matches );
					if ( !empty($site_uri_matches) ){
						$site_uri = str_replace( $matches[1], '', $site_uri );
						$site_uri = preg_replace( '#/$#', '', $site_uri );
						$site_dir = str_replace( $matches[1], '', $site_dir );
						$site_dir = preg_replace( '#\\\/$#', '', $site_dir );
					}
				}
				
				#get local name for use in file_exists() and get_imagesize() functions
				$localfile = str_replace( apply_filters( 'skyali_lt_resize_image_localfile', $site_uri, $site_dir, skyali_lt_multisite_thumbnail($thumb) ), $site_dir, skyali_lt_multisite_thumbnail($thumb) );
				
				$add_to_suffix = '';
				if ( file_exists( $localfile ) ) $add_to_suffix = filesize( $localfile ) . '_';
				
				#prepend image filesize to be able to use images with the same filename
				$suffix = $add_to_suffix . $suffix;
				$destfilename_attributes = '-' . $suffix . '.' . $ext;
				
				$checkfilename = ( '' != $destination_dir && null !== $destination_dir ) ? path_join( $destination_dir, $name ) : path_join( dirname( $localfile ), $name );
				$checkfilename .= $destfilename_attributes;
				
				if ( $is_jpeg ) $checkfilename = preg_replace( '#.jpeg$#', '.jpg', $checkfilename );
				
				$uploads_dir = wp_upload_dir();
				$uploads_dir['basedir'] = preg_replace( '#\/\/#', '/', $uploads_dir['basedir'] );
				
				if ( null !== $destination_dir && '' != $destination_dir && apply_filters('et_enable_uploads_detection', true) ){
					$site_dir = trailingslashit( preg_replace( '#\/\/#', '/', $uploads_dir['basedir'] ) );
					$site_uri = trailingslashit( $uploads_dir['baseurl'] );
				}
				
				#check if we have an image with specified width and height
				
				if ( file_exists( $checkfilename ) ) return str_replace( $site_dir, trailingslashit( $site_uri ), $checkfilename );

				$size = @getimagesize( $localfile );
				if ( !$size ) return new WP_Error('invalid_image_path', __('Image doesn\'t exist'), $thumb);
				list($orig_width, $orig_height, $orig_type) = $size;
				
				#check if we're resizing the image to smaller dimensions
				if ( $orig_width > $new_width || $orig_height > $new_height ){
					if ( $orig_width < $new_width || $orig_height < $new_height ){
						#don't resize image if new dimensions > than its original ones
						if ( $orig_width < $new_width ) $new_width = $orig_width;
						if ( $orig_height < $new_height ) $new_height = $orig_height;
						
						#regenerate suffix and appended attributes in case we changed new width or new height dimensions
						$suffix = "{$add_to_suffix}{$new_width}x{$new_height}";
						$destfilename_attributes = '-' . $suffix . '.' . $ext;
						
						$checkfilename = ( '' != $destination_dir && null !== $destination_dir ) ? path_join( $destination_dir, $name ) : path_join( dirname( $localfile ), $name );
						$checkfilename .= $destfilename_attributes;
						
						#check if we have an image with new calculated width and height parameters
						if ( file_exists($checkfilename) ) return str_replace( $site_dir, trailingslashit( $site_uri ), $checkfilename );
					}
					
					#we didn't find the image in cache, resizing is done here
					if ( ! function_exists( 'wp_get_image_editor' ) ) {
						// compatibility with versions of WordPress prior to 3.5.
						$result = image_resize( $localfile, $new_width, $new_height, $crop, $suffix, $destination_dir );
					} else {
						$skyali_lt_image_editor = wp_get_image_editor( $localfile );
						
						if ( ! is_wp_error( $skyali_lt_image_editor ) ) {
							$skyali_lt_image_editor->resize( $new_width, $new_height, $crop );
							
							// generate correct file name/path
							$skyali_lt_new_image_name = $skyali_lt_image_editor->generate_filename( $suffix, $destination_dir );
							
							do_action( 'skyali_lt_resize_image_before_save', $skyali_lt_image_editor, $skyali_lt_new_image_name );
							
							$skyali_lt_image_editor->save( $skyali_lt_new_image_name );
							
							// assign new image path
							$result = $skyali_lt_new_image_name;
						} else {
							// assign a WP_ERROR ( WP_Image_Editor instance wasn't created properly )
							$result = $skyali_lt_image_editor;
						}
					}
						
					if ( ! is_wp_error( $result ) ) {
						#transform local image path into URI
						
						if ( $is_jpeg ) $thumb = preg_replace( '#.jpeg$#', '.jpg', $thumb);
						
						$site_dir = str_replace( '\\', '/', $site_dir );
						$result = str_replace( '\\', '/', $result );
						$result = str_replace( $site_dir, trailingslashit( $site_uri ), $result );
					}
					
					#returns resized image path or WP_Error ( if something went wrong during resizing )
					return $result;
				}
				
				#returns unmodified image, for example in case if the user is trying to resize 800x600px to 1920x1080px image
				return $thumb;
			}
		}

		if ( ! function_exists( 'skyali_lt_create_images_temp_folder' ) ){
			add_action( 'init', 'skyali_lt_create_images_temp_folder' );
			function skyali_lt_create_images_temp_folder(){
				#clean skyali_lt_temp folder once per week
				if ( false !== $last_time = get_option( 'skyali_lt_schedule_clean_images_last_time'  ) ){
					$timeout = 86400 * 7;
					if ( ( $timeout < ( time() - $last_time ) ) && '' != get_option( 'skyali_lt_images_temp_folder' ) ) skyali_lt_clean_temp_images( get_option( 'skyali_lt_images_temp_folder' ) );
				}
				
				if ( false !== get_option( 'skyali_lt_images_temp_folder' ) ) return;
				
				$uploads_dir = wp_upload_dir();
				$destination_dir = ( false === $uploads_dir['error'] ) ? path_join( $uploads_dir['basedir'], 'skyali_lt_temp' ) : null;
					
				if ( ! wp_mkdir_p( $destination_dir ) ) update_option( 'skyali_lt_images_temp_folder', '' );
				else { 
					update_option( 'skyali_lt_images_temp_folder', preg_replace( '#\/\/#', '/', $destination_dir ) );
					update_option( 'skyali_lt_schedule_clean_images_last_time', time() );
				}
			}
		}

		if ( ! function_exists( 'skyali_lt_clean_temp_images' ) ){
			function skyali_lt_clean_temp_images( $directory ){
				$dir_to_clean = @ opendir( $directory );
				
				if ( $dir_to_clean ) {
					while (($file = readdir( $dir_to_clean ) ) !== false ) {
						if ( substr($file, 0, 1) == '.' )
							continue;
						if ( is_dir( $directory.'/'.$file ) )
							skyali_lt_clean_temp_images( path_join( $directory, $file ) );
						else
							@ unlink( path_join( $directory, $file ) );
					}
					closedir( $dir_to_clean );
				}
				
				#set last time cleaning was performed
				update_option( 'skyali_lt_schedule_clean_images_last_time', time() );
			}
		}

		if ( ! function_exists( 'skyali_lt_multisite_thumbnail' ) ){
			function skyali_lt_multisite_thumbnail( $thumbnail = '' ) {
				// do nothing if it's not a Multisite installation or current site is the main one
				if ( is_main_site() ) return $thumbnail;
				
				# get the real image url
				preg_match( '#([_0-9a-zA-Z-]+/)?files/(.+)#', $thumbnail, $matches );
				if ( isset( $matches[2] ) ){
					$file = rtrim( BLOGUPLOADDIR, '/' ) . '/' . str_replace( '..', '', $matches[2] );
					if ( is_file( $file ) ) $thumbnail = str_replace( ABSPATH, get_site_url( 1 ), $file );
					else $thumbnail = '';
				}

				return $thumbnail;
			}
		}

		if ( ! function_exists( 'skyali_lt_update_uploads_dir' ) ){
			add_filter( 'update_option_upload_path', 'skyali_lt_update_uploads_dir' );
			function skyali_lt_update_uploads_dir( $upload_path ){
				$uploads_dir = wp_upload_dir();
				$destination_dir = ( false === $uploads_dir['error'] ) ? path_join( $uploads_dir['basedir'], 'skyali_lt_temp' ) : null;
				
				update_option( 'skyali_lt_images_temp_folder', preg_replace( '#\/\/#', '/', $destination_dir ) );

				return $upload_path;
			}
		}	
	}
		
	add_action( 'admin_enqueue_scripts', 'skyali_scripts_styles', 10, 1 );
	function skyali_scripts_styles( $hook ) {
		global $typenow;
		
		if ( ! in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) return;
		
		$skyali_main_settings = get_option( 'skyali_main_settings' );
		$post_types = isset( $skyali_main_settings['post_types'] ) ? (array) $skyali_main_settings['post_types'] : apply_filters( 'skyali_lt_builder_default_post_types', array( 'post', 'page','albums','gallery' ) );
		
		/*
		 * Load the builder javascript and css files for custom post types, selected on the plugin settings page,
		 * default custom post types can be added using skyali_lt_builder_default_post_types filter
		*/
		if ( isset( $typenow ) && in_array( $typenow, $post_types ) ){
			skyali_new_settings_page_js();
			skyali_new_settings_page_css();
		}
	}

	function skyali_add_custom_box(){
		/*
		 * Add the builder meta box to custom post types, selected on the plugin settings page,
		 * default custom post types can be added using skyali_lt_builder_default_post_types filter
		*/
		
		$skyali_main_settings = get_option( 'skyali_main_settings' );
		$post_types = isset( $skyali_main_settings['post_types'] ) ? (array) $skyali_main_settings['post_types'] : apply_filters( 'skyali_lt_builder_default_post_types', array( 'post', 'page','albums','gallery' ) );
		
		foreach ( $post_types as $post_type ){
			add_meta_box( 'skyali_layout', __( 'Page Builder', 'vibration' ), 'skyali_layout_custom_box', $post_type, 'normal', 'high' );
		}
	}

	function skyali_layout_custom_box(){
		skyali_new_build_settings_page();
	} 

}



function skyali_new_pagination($pages = '', $range = 3)
{   /*  pagination for post pages*/
     $showitems = ($range * 2)+1;  
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
		//echo's current pages number echo $pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
         $string_first =  "<div class=\"pagination\"><div class=\"pagging_inside\">";
        
 $new_string = array();
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 $string =  ($paged != $i) ? "<a href='".get_pagenum_link($i)."' class=\"link imgf\">".$i."</a>":"<span class=\"active\">".$i."</span>";
			
            array_push($new_string,$string);
			
			 }
         }
 
       
        $string_second = "</div></div>\n";
		
		$implode_pages = implode('',$new_string);
		
		return $string_first.$implode_pages.$string_second;
     }
}



/* Shortcodes for the page builder start here - Skyali */

/* Latest Posts Shortcode for page builder */
$clean_pages = array();

add_shortcode('skyali_latest_posts', 'skyali_new_latest_posts');
function skyali_new_latest_posts($atts, $content = null) {
		extract(shortcode_atts(array(
				'heading' => '',
			    'author'  => '',
				'category_name' => '', // you can pick category for the post
				'order' => 'DESC',
		        'orderby' => 'date',
				'post_status' => 'publish',
				'posts_per_page'  => '5',
				'pagination'  => 'true',
		        'tag' => ''
			), $atts));
			
$attributes = skyali_get_attributes( $atts, "skyali_latest_posts" );

global $clean_pages; 

$clean_pages = array();

if($posts_per_page == 0 OR empty($posts_per_page)){ $posts_per_page=5; }

array_push($clean_pages, $posts_per_page);

function cat_post_limit($limit) {
	
	global $paged, $myOffset;

    global $clean_pages;
	
	//echo $paged;
	if (empty($paged)) {
			$paged = 1;
	}
	$postperpage = intval($clean_pages[0]);
	$pgstrt = ((intval($paged) -1) * $postperpage) . ', ';
	$limit = 'LIMIT '.$pgstrt.$postperpage;
	return $limit;
} 

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

$comments_text = 'Comment';

if($comments_number != 1) { $comments_text = 'Comments'; }

$latest_post_array = array();

add_filter('post_limits', 'cat_post_limit');

global $myOffset;

$myOffset = 1;

$temp = $wp_query;

$paged = (get_query_var('page')) ? get_query_var('page') : 1;

global $wp_query;

$wp_query= null;

$wp_query = new WP_Query();

query_posts( array( 'offset'=>''.$myOffset.'','paged'=>''.$paged.'','post_type' => 'post', 'posts_per_page' => ''.$posts_per_page.'', 'author_name' => ''.$author.'', 'category_name' => ''.$category_name.'','order' => ''.$order.'','orderby' => ''.$post_status.'','tag' => ''.$tag.'') ); if ( have_posts() ) : while ( have_posts() ) : the_post();

$comments_number= get_comments_number(); // get_comments_number returns only a numeric value

$pages= $wp_query->max_num_pages;

$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'latest-news');

array_push($latest_post_array, '<div id="post-'.get_the_ID().'" class="latest_posts">

<div class="left"><div class="image_container">

<span class="date_holder"><span class="month">' . get_the_date('M' ) . '</span><span class="day">' . get_the_date('d') . '</span></span><!-- date_holder -->

<span class="comment_holder"><a href="'.@get_comment_link().'"><span class="comment_num">'.$comments_number.'</span> <span class="comments_word">'.$comments_text.'</span></a></span><!-- comment_holder -->

<a href="'.get_permalink($post->ID).'"><img src="'.$image[0].'" alt="' . apply_filters( 'the_title', get_the_title() ) . '"/></a>

</div><!-- image_container --></div><!-- left -->

<div class="right">

<span class="comment"><a href="'.@get_comment_link().'">'.$comments_number.' '.$comments_text.'</a></span>

<span class="date"><span>' . get_the_date( ) . '</span></span>

<span class="author"><a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.get_the_author().'</a></span>

<h4><a href="'.get_permalink($post->ID).'">' . apply_filters( 'the_title', get_the_title() ) . '</a></h4>

<p>'.excerpt(30).'...</p>

<a href="'.get_permalink($post->ID).'" class="button yellow_arrow_button">'.translate('Read More','vibration').'</a>

</div><!-- right -->

</div><!-- latest_posts -->','');

endwhile; endif; wp_reset_query();

$latest_post_array_output = implode('',$latest_post_array);

$output = ''.$latest_post_array_output.'</div> <!-- end .skyali_latest_posts -->';

if($pagination != 'false') { $show_pages = skyali_new_pagination($pages); } else { $show_pages =''; }

remove_filter('post_limits','cat_post_limit');

	return $output_first.$heading.$output.$show_pages;
}


/* Latest Posts Style 2 Shortcode for page builder */
add_shortcode('skyali_latest_posts_style_2', 'skyali_new_latest_posts_style_2');
function skyali_new_latest_posts_style_2($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
			    'author'  => '',
				'category_name' => '', // you can pick category for the post
				'order' => 'DESC',
		        'orderby' => 'date',
				'post_status' => 'publish',
				'posts_per_page'  => '5',
				'pagination'  => 'true',
		        'tag' => ''
			), $atts));
	$attributes = skyali_get_attributes( $atts, "skyali_latest_posts_style_2" );
	
	global $clean_pages; 

$clean_pages = array();

if($posts_per_page == 0 OR empty($posts_per_page)){ $posts_per_page=5; }

array_push($clean_pages, $posts_per_page);

function cat_post_limit2($limit) {
	
	global $paged, $myOffset;

    global $clean_pages;
	
	//echo $paged;
	if (empty($paged)) {
			$paged = 1;
	}
	$postperpage = intval($clean_pages[0]);
	$pgstrt = ((intval($paged) -1) * $postperpage) . ', ';
	$limit = 'LIMIT '.$pgstrt.$postperpage;
	return $limit;
} 

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

$comments_number= get_comments_number(); // get_comments_number returns only a numeric value

$comments_text = 'Comment';

if($comments_number != 1) { $comments_text = 'Comments'; }

$latest_post_array = array();

add_filter('post_limits', 'cat_post_limit2');

global $myOffset;

$myOffset = 1;

$temp = $wp_query;

$paged = (get_query_var('page')) ? get_query_var('page') : 1;

global $wp_query;

$wp_query= null;

$wp_query = new WP_Query();

query_posts( array( 'offset'=>''.$myOffset.'','paged'=>''.$paged.'','post_type' => 'post', 'showposts' => ''.$posts_per_page.'', 'author_name' => ''.$author.'', 'category_name' => ''.$category_name.'','order' => ''.$order.'','orderby' => ''.$post_status.'','tag' => ''.$tag.'', ) ); if ( have_posts() ) : while ( have_posts() ) : the_post();

$comments_number= get_comments_number(); // get_comments_number returns only a numeric value

$pages= $wp_query->max_num_pages;

$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'latest-news-style-2');

array_push($latest_post_array, '<div class="latest_posts_style_2">

<div class="top"><div class="image_container">

<span class="date_holder"><span class="month">' . get_the_date('M' ) . '</span><span class="day">' . get_the_date('d') . '</span></span><!-- date_holder -->

<span class="comment_holder"><a href="'.@get_comment_link().'"><span class="comment_num">'.$comments_number.'</span> <span class="comments_word">'.$comments_text.'</span></a></span><!-- comment_holder -->

<a href="'.get_permalink($post->ID).'"><img src="'.$image[0].'" alt="' . apply_filters( 'the_title', get_the_title() ) . '"/></a></div><!-- image_container --></div><!--top -->

<div class="bottom">

<span class="comment"><a href="'.@get_comment_link().'">'.$comments_number.' '.$comments_text.'</a></span>

<span class="date"><span>' . get_the_date( ) . '</span></span>


<span class="author"><a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.get_the_author().'</a></span>

<h4><a href="'.get_permalink($post->ID).'">' . apply_filters( 'the_title', get_the_title() ) . '</a></h4>

<p>'.excerpt(45).'...</p>

<a href="'.get_permalink($post->ID).'" class="button yellow_arrow_button">'.translate('Read More','vibration').'</a>

</div><!-- bottom -->

</div><!-- latest_posts style 2 -->','');

endwhile; endif; wp_reset_query();

$latest_post_array_output = implode('',$latest_post_array);

$output = ''.$latest_post_array_output.'</div> <!-- end .skyali_latest_posts_style_2 -->';

if($pagination != 'false') { $show_pages = skyali_new_pagination($pages); } else { $show_pages =''; }

remove_filter('post_limits','cat_post_limit2');

	return $output_first.$heading.$output.$show_pages;
}

/* Latest Posts Style 3 Shortcode for page builder */
add_shortcode('skyali_latest_posts_style_3', 'skyali_new_latest_posts_style_3');
function skyali_new_latest_posts_style_3($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
			    'author'  => '',
				'category_name' => '', // you can pick category for the post
				'order' => 'DESC',
		        'orderby' => 'date',
				'post_status' => 'publish',
				'posts_per_page'  => '5',
				'pagination'  => 'true',
		        'tag' => ''
			), $atts));
	$attributes = skyali_get_attributes( $atts, "skyali_latest_posts_style_3" );
	
	global $clean_pages; 

$clean_pages = array();

if($posts_per_page == 0 OR empty($posts_per_page)){ $posts_per_page=5; }

array_push($clean_pages, $posts_per_page);

function cat_post_limit3($limit) {
	
	global $paged, $myOffset;

    global $clean_pages;
	
	//echo $paged;
	if (empty($paged)) {
			$paged = 1;
	}
	$postperpage = intval($clean_pages[0]);
	$pgstrt = ((intval($paged) -1) * $postperpage) . ', ';
	$limit = 'LIMIT '.$pgstrt.$postperpage;
	return $limit;
} 

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

$comments_text = 'Comment';

if($comments_number != 1) { $comments_text = 'Comments'; }

$latest_post_array = array();

add_filter('post_limits', 'cat_post_limit3');

global $myOffset;

$myOffset = 1;

$temp = $wp_query;

$paged = (get_query_var('page')) ? get_query_var('page') : 1;

global $wp_query;

$wp_query= null;

$wp_query = new WP_Query();

query_posts( array( 'offset'=>''.$myOffset.'','paged'=>''.$paged.'', 'post_type' => 'post', 'showposts' => ''.$posts_per_page.'', 'author_name' => ''.$author.'', 'category_name' => ''.$category_name.'','order' => ''.$order.'','orderby' => ''.$post_status.'','tag' => ''.$tag.'', ) ); if ( have_posts() ) : while ( have_posts() ) : the_post();

$comments_number= get_comments_number(); // get_comments_number returns only a numeric value

$pages= $wp_query->max_num_pages;

$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'latest-news');

array_push($latest_post_array, '<div class="latest_posts_style_3">

<div class="left">

<span class="comment"><a href="'.@get_comment_link().'">'.$comments_number.' '.$comments_text.'</a></span>

<span class="date"><span>' . get_the_date( ) . '</span></span>

<span class="author"><a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.get_the_author().'</a></span>

<h4><a href="'.get_permalink($post->ID).'">' . apply_filters( 'the_title', get_the_title() ) . '</a></h4>

<p>'.excerpt(30).'...</p>

<a href="'.get_permalink($post->ID).'" class="button yellow_arrow_button">'.translate('Read More','vibration').'</a>

</div><!-- left -->

<div class="right"><div class="image_container">

<span class="date_holder"><span class="month">' . get_the_date('M' ) . '</span><span class="day">' . get_the_date('d') . '</span></span><!-- date_holder -->

<span class="comment_holder"><a href="'.@get_comment_link().'"><span class="comment_num">'.$comments_number.'</span> <span class="comments_word">'.$comments_text.'</span></a></span><!-- comment_holder -->

<a href="'.get_permalink($post->ID).'"><img src="'.$image[0].'" alt="' . apply_filters( 'the_title', get_the_title() ) . '"/></a></div><!-- image_container --></div><!-- right -->

</div><!-- latest_posts style 3 -->','');

endwhile; endif; wp_reset_query();

$latest_post_array_output = implode('',$latest_post_array);

$output = ''.$latest_post_array_output.'</div> <!-- end .skyali_latest_posts_style_3 -->';

if($pagination != 'false') { $show_pages = skyali_new_pagination($pages); } else { $show_pages =''; }

remove_filter('post_limits','cat_post_limit3');

	return $output_first.$heading.$output.$show_pages;
}



/* Latest Albums Shortcode for page builder */
add_shortcode('skyali_latest_albums', 'skyali_new_latest_albums');
function skyali_new_latest_albums($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
			    'author'  => '',
				'album_categories' => '', // you can pick category for the post
				'order' => 'DESC',
		        'orderby' => 'date',
				'post_status' => 'publish',
				'posts_per_page'  => '5',
				'pagination'  => 'true',
		        'tag' => ''
			), $atts));
	$attributes = skyali_get_attributes( $atts, "skyali_latest_albums" );
	
		global $clean_pages; 

$clean_pages = array();

if($posts_per_page == 0 OR empty($posts_per_page)){ $posts_per_page=5; }

array_push($clean_pages, $posts_per_page);

function cat_post_limit4($limit) {
	
	global $paged, $myOffset;

    global $clean_pages;
	
	//echo $paged;
	if (empty($paged)) {
			$paged = 1;
	}
	$postperpage = intval($clean_pages[0]);
	$pgstrt = ((intval($paged) -1) * $postperpage) . ', ';
	$limit = 'LIMIT '.$pgstrt.$postperpage;
	return $limit;
} 

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

$latest_album_array = array();

$latest_album_i = 0;

add_filter('post_limits', 'cat_post_limit4');

global $myOffset;

$myOffset = 1;

$temp = $wp_query;

$paged = (get_query_var('page')) ? get_query_var('page') : 1;

global $wp_query;

$wp_query= null;

$wp_query = new WP_Query();

query_posts( array( 'offset'=>''.$myOffset.'','paged'=>''.$paged.'', 'post_type' => 'albums', 'showposts' => ''.$posts_per_page.'', 'author_name' => ''.$author.'', 'album_categories' => ''.$album_categories.'','order' => ''.$order.'','orderby' => ''.$post_status.'','tag' => ''.$tag.'', ) ); if ( have_posts() ) : while ( have_posts() ) : the_post();

$pages= $wp_query->max_num_pages;

$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'latest-news');

if($latest_album_i%2) { $no_margin_right = ' no_margin_right'; } else { $no_margin_right = ''; }

$skyali_amazon_link =  get_post_meta(get_the_ID(), 'skyali_amazon_link', true); 

$skyali_itunes_link =  get_post_meta(get_the_ID(), 'skyali_itunes_link', true); 

$skyali_buy_now_link =  get_post_meta(get_the_ID(), 'skyali_buy_now_link', true); 

array_push($latest_album_array, '<div class="latest_album'.$no_margin_right.'">

<div class="top">

<div class="image_container">

<span class="icon_holder"><a href="'.$skyali_amazon_link.'" class="amazon_link imgf">'.translate('Buy On Amazon','vibration').'</a><a href="'.$skyali_itunes_link.'" class="itunes_link imgf">'.translate('Buy On Itunes','vibration').'</a></span><!-- icon_holder -->

<span class="date_holder"><span class="month">' . get_the_date('M' ) . '</span><span class="day">' . get_the_date('d') . '</span></span><!-- date_holder -->

<a href="'.get_permalink($post->ID).'"><img src="'.$image[0].'" alt="' . apply_filters( 'the_title', get_the_title() ) . '"/></a>

</div><!-- image_container -->

</div><!-- top -->

<div class="bottom">

<h4><a href="'.get_permalink($post->ID).'">' . apply_filters( 'the_title', get_the_title() ) . '</a></h4>

<a href="'.$skyali_buy_now_link.'" class="button yellow_arrow_button">'.translate('Buy Now','vibration').'</a>

</div><!-- bottom -->

</div><!-- latest_album -->','');

$latest_album_i++;

endwhile; endif; wp_reset_query();

$latest_album_array_output = implode('',$latest_album_array);

$output = ''.$latest_album_array_output.'</div> <!-- end .skyali_latest_album -->';

if($pagination != 'false') { $show_pages = skyali_new_pagination($pages); } else { $show_pages =''; }

remove_filter('post_limits','cat_post_limit4');

	return $output_first.$heading.$output.$show_pages;
}


/* Latest Shows Shortcode for page builder */
add_shortcode('skyali_latest_shows', 'skyali_new_latest_shows');
function skyali_new_latest_shows($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
			    'author'  => '',
				'shows_categories' => '', // you can pick category for the post
				'order' => 'DESC',
		        'orderby' => 'date',
				'post_status' => 'publish',
				'posts_per_page'  => '5',
				'pagination'  => 'true',
		        'tag' => ''
			), $atts));
	$attributes = skyali_get_attributes( $atts, "skyali_latest_shows" );
	
		global $clean_pages; 

$clean_pages = array();

if($posts_per_page == 0 OR empty($posts_per_page)){ $posts_per_page=5; }

array_push($clean_pages, $posts_per_page);

function cat_post_limit5($limit) {
	
	global $paged, $myOffset;

    global $clean_pages;
	
	//echo $paged;
	if (empty($paged)) {
			$paged = 1;
	}
	$postperpage = intval($clean_pages[0]);
	$pgstrt = ((intval($paged) -1) * $postperpage) . ', ';
	$limit = 'LIMIT '.$pgstrt.$postperpage;
	return $limit;
} 

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

$latest_show_array = array();

add_filter('post_limits', 'cat_post_limit5');

global $myOffset;

$myOffset = 1;

$temp = $wp_query;

$paged = (get_query_var('page')) ? get_query_var('page') : 1;

global $wp_query;

$wp_query= null;

$wp_query = new WP_Query();

query_posts( array( 'cat' => -0, 'offset'=>''.$myOffset.'','paged'=>''.$paged.'', 'post_type' => 'shows', 'showposts' => ''.$posts_per_page.'', 'author_name' => ''.$author.'', 'shows_categories' => ''.$shows_categories.'','order' => ''.$order.'','orderby' => ''.$post_status.'','tag' => ''.$tag.'', ) ); if ( have_posts() ) : while ( have_posts() ) : the_post();

$pages= $wp_query->max_num_pages;

$skyali_show_month =  get_post_meta(get_the_ID(), 'skyali_show_month', true); 

$skyali_show_day =  get_post_meta(get_the_ID(), 'skyali_show_day', true); 

$skyali_show_year =  get_post_meta(get_the_ID(), 'skyali_show_year', true); 

$skyali_show_time =  get_post_meta(get_the_ID(), 'skyali_show_time', true); 

$skyali_show_location =  get_post_meta(get_the_ID(), 'skyali_show_location', true); 

$ticket_link =  get_post_meta(get_the_ID(), 'skyali_ticket_link', true); 

$skyali_show_status =  get_post_meta(get_the_ID(), 'skyali_show_status', true); 

$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'shows');

$show_image_link_option = get_post_meta(get_the_ID(), 'skyali_show_image_link', true);

$show_custom_link = get_permalink(get_the_ID());

$book_show_text = get_option('skypanel_vibration_book_show');

if(empty($book_show_text)) { $book_show_text = ''.translate('Book Show','vibration').''; }

$book_show_button_option = get_post_meta(get_the_ID(), 'skyali_show_disable_button', true); 

$hide_book_show_button = '';

if($book_show_button_option != 'enable' && !empty($book_show_button_option)) { if($book_show_button_option == 'disable') { $hide_book_show_button =' hide'; } else { } }

if(!empty($ticket_link)) { $show_custom_link = $ticket_link; }

if($skyali_show_status == ''){ $show_link = '<a href="'.$show_custom_link.'" class="button yellow_arrow_button'.$hide_book_show_button.'">'.$book_show_text.'</a>';}

if($skyali_show_status == 'free'){ $show_link = '<a href="'.$show_custom_link.'" class="button yellow_arrow_button'.$hide_book_show_button.'">'.translate('Free Show','vibration').'</a>';}

if($skyali_show_status == 'canceled'){ $show_link = '<a href="#" class="button yellow_arrow_button'.$hide_book_show_button.'">'.translate('Canceled','vibration').'</a>';}

if($skyali_show_status == 'soldout'){ $show_link = '<a href="#" class="button yellow_arrow_button'.$hide_book_show_button.'">'.translate('Sold Out','vibration').'</a>';}

if($show_image_link_option == 'disable') { $image_url = '<img src="'.$image[0].'" class="show_img" alt="' . apply_filters( 'the_title', get_the_title() ) . '"/>'; } else { $image_url = '<a href="'.get_permalink($post->ID).'"><img src="'.$image[0].'" class="show_img" alt="' . apply_filters( 'the_title', get_the_title() ) . '"/></a>';}

if($show_image_link_option == 'disable'){ $show_title = '<h4><a href="#">' . apply_filters( 'the_title', get_the_title() ) . '</a></h4>'; } else { $show_title = '<h4><a href="'.get_permalink(get_the_ID()).'">' . apply_filters( 'the_title', get_the_title() ) . '</a></h4>';}

array_push($latest_show_array, '<div class="latest_shows">

<div class="left">

<span class="show_date"><span class="day">'.$skyali_show_day.'</span><span class="month">'.$skyali_show_month.'</span></span><!-- show_date -->

'.$image_url .'

</div><!-- left -->

<div class="right">

'.$show_title.'

<span class="show_time"><span>'.$skyali_show_time.'</span></span>

<span class="show_location"><span>'.$skyali_show_location.'</span></span>

'.$show_link.'

</div><!-- right -->

</div><!-- latest_shows -->','');

endwhile; endif; wp_reset_query();


$latest_show_array_output = implode('',$latest_show_array);

$output = ''.$latest_show_array_output.'</div> <!-- end .skyali_latest_show -->';

if($pagination != 'false') { $show_pages = skyali_new_pagination($pages); } else { $show_pages =''; }

remove_filter('post_limits','cat_post_limit5');

	return $output_first.$heading.$output.$show_pages;
}

/* Latest Shows Show Style 2 Shortcode for page builder */
add_shortcode('skyali_latest_shows_style_2', 'skyali_new_latest_shows_style_2');
function skyali_new_latest_shows_style_2($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
			    'author'  => '',
				'shows_categories' => '', // you can pick category for the post
				'order' => 'DESC',
		        'orderby' => 'date',
				'post_status' => 'publish',
				'posts_per_page'  => '5',
				'pagination'  => 'true',
		        'tag' => ''
			), $atts));
	$attributes = skyali_get_attributes( $atts, "skyali_latest_shows_style_2" );

	global $clean_pages; 

$clean_pages = array();

if($posts_per_page == 0 OR empty($posts_per_page)){ $posts_per_page=5; }

array_push($clean_pages, $posts_per_page);

function cat_post_limit6($limit) {
	
	global $paged, $myOffset;

    global $clean_pages;
	
	//echo $paged;
	if (empty($paged)) {
			$paged = 1;
	}
	$postperpage = intval($clean_pages[0]);
	$pgstrt = ((intval($paged) -1) * $postperpage) . ', ';
	$limit = 'LIMIT '.$pgstrt.$postperpage;
	return $limit;
} 

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

$latest_show_i = 0;

$latest_show_array = array();

add_filter('post_limits', 'cat_post_limit6');

global $myOffset;

$myOffset = 1;

$temp = $wp_query;

$paged = (get_query_var('page')) ? get_query_var('page') : 1;

global $wp_query;

$wp_query= null;

$wp_query = new WP_Query();

query_posts( array( 'offset'=>''.$myOffset.'','paged'=>''.$paged.'','post_type' => 'shows', 'showposts' => ''.$posts_per_page.'', 'author_name' => ''.$author.'', 'shows_categories' => ''.$shows_categories.'','order' => ''.$order.'','orderby' => ''.$post_status.'','tag' => ''.$tag.'', ) ); if ( have_posts() ) : while ( have_posts() ) : the_post();

$pages= $wp_query->max_num_pages;

if($latest_show_i%2) { $no_margin_right = ' no_margin_right'; } else { $no_margin_right = ''; }

$skyali_show_month =  get_post_meta(get_the_ID(), 'skyali_show_month', true); 

$skyali_show_day =  get_post_meta(get_the_ID(), 'skyali_show_day', true); 

$skyali_show_year =  get_post_meta(get_the_ID(), 'skyali_show_year', true); 

$skyali_show_time =  get_post_meta(get_the_ID(), 'skyali_show_time', true); 

$skyali_show_location =  get_post_meta(get_the_ID(), 'skyali_show_location', true); 

$ticket_link =  get_post_meta(get_the_ID(), 'skyali_ticket_link', true); 

$skyali_show_status =  get_post_meta(get_the_ID(), 'skyali_show_status', true); 

$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'shows');

$show_image_link_option = get_post_meta(get_the_ID(), 'skyali_show_image_link', true);

$show_custom_link = get_permalink($post->ID);

$book_show_text = get_option('skypanel_vibration_book_show');

if(empty($book_show_text)) { $book_show_text = ''.translate('Book Show','vibration').''; }

$book_show_button_option = get_post_meta(get_the_ID(), 'skyali_show_disable_button', true); 

$hide_book_show_button = '';

if($book_show_button_option != 'enable' && !empty($book_show_button_option)) { if($book_show_button_option == 'disable') { $hide_book_show_button =' hide'; } else { } }

if(!empty($ticket_link)) { $show_custom_link = $ticket_link; }

if($skyali_show_status == ''){ $show_link = '<a href="'.$show_custom_link.'" class="button yellow_arrow_button'.$hide_book_show_button.'">'.$book_show_text.'</a>';}

if($skyali_show_status == 'free'){ $show_link = '<a href="'.$show_custom_link.'" class="button yellow_arrow_button'.$hide_book_show_button.'">'.translate('Free Show','vibration').'</a>';}

if($skyali_show_status == 'canceled'){ $show_link = '<a href="#" class="button yellow_arrow_button'.$hide_book_show_button.'">'.translate('Canceled','vibration').'</a>';}

if($skyali_show_status == 'soldout'){ $show_link = '<a href="#" class="button yellow_arrow_button'.$hide_book_show_button.'">'.translate('Sold Out','vibration').'</a>';}

if($show_image_link_option == 'disable') { $image_url = '<img src="'.$image[0].'" class="show_img" alt="' . apply_filters( 'the_title', get_the_title() ) . '"/>'; } else { $image_url = '<a href="'.get_permalink($post->ID).'"><img src="'.$image[0].'" class="show_img" alt="' . apply_filters( 'the_title', get_the_title() ) . '"/></a>';}

if($show_image_link_option == 'disable'){ $show_title = '<h4><a href="#">' . apply_filters( 'the_title', get_the_title() ) . '</a></h4>'; } else { $show_title = '<h4><a href="'.get_permalink($post->ID).'">' . apply_filters( 'the_title', get_the_title() ) . '</a></h4>';}

array_push($latest_show_array, '<div class="latest_shows_style_2 '. $no_margin_right.'">

<div class="top">

<span class="show_date"><span class="day">'.$skyali_show_day.'</span><span class="month">'.$skyali_show_month.'</span></span><!-- show_date -->

'.$image_url.'

</div><!-- top -->

<div class="bottom">

'.$show_title.'

<span class="show_time"><span>'.$skyali_show_time.'</span></span>

<span class="show_location"><span>'.$skyali_show_location.'</span></span>

'.$show_link.'

</div><!-- bottom -->

</div><!-- latest_shows style 2 -->','');

$latest_show_i++;

endwhile; endif; wp_reset_query();

$latest_show_array_output = implode('',$latest_show_array);

$output = ''.$latest_show_array_output.'</div> <!-- end .skyali_latest_show -->';

if($pagination != 'false') { $show_pages = skyali_new_pagination($pages); } else { $show_pages =''; }

remove_filter('post_limits','cat_post_limit6');

	return $output_first.$heading.$output.$show_pages;
}


/* Latest Photos Shortcode for page builder */
add_shortcode('skyali_latest_photos', 'skyali_new_latest_photos');
function skyali_new_latest_photos($atts, $content = null) {
		extract(shortcode_atts(array(
				'heading' => '',
			    'author'  => '',
				'gallery_categories' => '', // you can pick category for the post
				'order' => 'DESC',
		        'orderby' => 'date',
				'post_status' => 'publish',
				'posts_per_page'  => '5',
				'pagination'  => 'true',
		        'tag' => ''
			), $atts));
	$attributes = skyali_get_attributes( $atts, "skyali_latest_photos" );

	global $clean_pages; 

$clean_pages = array();

if($posts_per_page == 0 OR empty($posts_per_page)){ $posts_per_page=10; }

array_push($clean_pages, $posts_per_page);

function cat_post_limit7($limit) {
	
	global $paged, $myOffset;

    global $clean_pages;
	
	//echo $paged;
	if (empty($paged)) {
			$paged = 1;
	}
	$postperpage = intval($clean_pages[0]);
	$pgstrt = ((intval($paged) -1) * $postperpage) . ', ';
	$limit = 'LIMIT '.$pgstrt.$postperpage;
	return $limit;
} 
$photo_i = 1;

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

$output_photos_div = '<div class="latest_photos">';

$latest_gallery_array = array();

add_filter('post_limits', 'cat_post_limit7');

global $myOffset;

$myOffset = 1;

$temp = $wp_query;

$paged = (get_query_var('page')) ? get_query_var('page') : 1;

global $wp_query;

$wp_query= null;

$wp_query = new WP_Query();


query_posts( array('offset'=>''.$myOffset.'','paged'=>''.$paged.'', 'post_type' => 'gallery', 'showposts' => ''.$posts_per_page.'', 'author_name' => ''.$author.'', 'gallery_categories' => ''.$gallery_categories.'','order' => ''.$order.'','orderby' => ''.$post_status.'','tag' => ''.$tag.'', ) ); if ( have_posts() ) : while ( have_posts() ) : the_post();


if($photo_i==4 OR $photo_i == 8 OR $photo_i == 12 OR $photo_i == 16 OR $photo_i == 20 OR $photo_i ==24) { $no_margin_right = ' no_margin_right'; } else { $no_margin_right = ''; }

$pages= $wp_query->max_num_pages;

$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'latest_photo');

$image_full =   wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

array_push($latest_gallery_array, '<div class="latest_photos_item'.$no_margin_right.'"><div class="image_container"><a href="'.$image_full[0].'" rel="fancybox2"><div class="img_hover"><img src="'.get_template_directory_uri().'/images/photos_icon.png" /></div><!-- img_hover --><img src="'.$image[0].'" class="latest_photo_item" alt="' . apply_filters( 'the_title', get_the_title() ) . '"/></a></div></div><!-- latest_photos_item-->','');

$photo_i++;

endwhile; endif; wp_reset_query();

$latest_gallery_array_output = implode('',$latest_gallery_array);

$output = ''.$latest_gallery_array_output.'</div> <!-- end .skyali_latest_photo -->';

$output_photos_div_closer = '</div> <!-- end .skyali_latest_photos -->';

if($pagination != 'false') { $show_pages = skyali_new_pagination($pages); } else { $show_pages =''; }

remove_filter('post_limits','cat_post_limit7');

	return $output_first.$heading.$output_photos_div.$output.$output_photos_div_closer.$show_pages;

}



/* Latest Videos Shortcode for page builder */
add_shortcode('skyali_latest_videos', 'skyali_new_latest_videos');
function skyali_new_latest_videos($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
			    'author'  => '',
				'videos_categories' => '', // you can pick category for the post
				'order' => 'DESC',
		        'orderby' => 'date',
				'post_status' => 'publish',
				'posts_per_page'  => '5',
				'pagination'  => 'true',
		        'tag' => ''
			), $atts));
			
			$attributes = skyali_get_attributes( $atts, "skyali_latest_videos" );
			
				global $clean_pages; 

$clean_pages = array();

if($posts_per_page == 0 OR empty($posts_per_page)){ $posts_per_page=10; }


array_push($clean_pages, $posts_per_page);

function cat_post_limit8($limit) {
	
	global $paged, $myOffset;

    global $clean_pages;
	
	//echo $paged;
	if (empty($paged)) {
			$paged = 1;
	}
	$postperpage = intval($clean_pages[0]);
	$pgstrt = ((intval($paged) -1) * $postperpage) . ', ';
	$limit = 'LIMIT '.$pgstrt.$postperpage;
	return $limit;
} 
$video_i = 1;

			
$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

$output_videos_div = '<div class="latest_videos'.$no_margin_right.'">';

$latest_gallery_array = array();

add_filter('post_limits', 'cat_post_limit8');

global $myOffset;

$myOffset = 1;

$temp = $wp_query;

$paged = (get_query_var('page')) ? get_query_var('page') : 1;

global $wp_query;

$wp_query= null;

$wp_query = new WP_Query();

query_posts( array( 'offset'=>''.$myOffset.'','paged'=>''.$paged.'','post_type' => 'videos', 'showposts' => ''.$posts_per_page.'', 'author_name' => ''.$author.'', 'videos_categories' => ''.$gallery_categories.'','order' => ''.$order.'','orderby' => ''.$post_status.'','tag' => ''.$tag.'', ) ); if ( have_posts() ) : while ( have_posts() ) : the_post();

if($video_i==3 OR $video_i == 6 OR $video_i == 9 OR $video_i == 12 OR $video_i == 15 OR $video_i ==18) { $no_margin_right = ' no_margin_right'; } else { $no_margin_right = ''; }

$pages= $wp_query->max_num_pages;

$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'latest_video');

$skyali_video_url =  get_post_meta(get_the_ID(), 'skyali_video-url', true); 


if(empty($image[0])) { $check_image = 'noimage'; } else { $check_image = ''; }
if($check_image != 'noimage'){ 
array_push($latest_gallery_array, '<div class="latest_videos_item"><div class="image_container">
<a href="'.$skyali_video_url.'" class="various iframe" ><div class="img_hover"><img src="'.get_template_directory_uri().'/images/video_icon.png" /></div><!-- img_hover --><img src="'.$image[0].'"  class="latest_video_item" alt="' . apply_filters( 'the_title', get_the_title() ) . '" /></a></div></div><!-- latest_videos_item -->','');
}
else{
array_push($latest_gallery_array, '<div class="latest_videos_item"><div class="image_container"><iframe width="100%" height="100%" src="'.$skyali_video_url.'" frameborder="0" allowfullscreen></iframe></div><!-- image_container --> </div><!--  latest_videos_item  -->','');
	
}
$video_i ++;
endwhile; endif; wp_reset_query();


$latest_gallery_array_output = implode('',$latest_gallery_array);


$output = ''.$latest_gallery_array_output.'</div> <!-- end .skyali_latest_videos -->';





$output_videos_div_closer = '</div><!-- end .skyali_latest_videos -->';

if($pagination != 'false') { $show_pages = skyali_new_pagination($pages); } else { $show_pages =''; }

remove_filter('post_limits','cat_post_limit8');

	return $output_first.$heading.$output_videos_div.$output.$output_videos_div_closer.$show_pages;
}

/* Audio Player Shortcode for page builder */
add_shortcode('skyali_audio_player', 'skyali_new_audio_player');
function skyali_new_audio_player($atts, $content = null) {
		extract(shortcode_atts(array(
				'heading' => '',
				'mp3url' => '',
			), $atts));



$attributes = skyali_get_attributes( $atts, "skyali_audio_player" );

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

$Length = 10;

$RandomString = substr(str_shuffle(md5(time())),0,10);


if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }


$mp3url =   htmlentities($mp3url);

$output = '

<iframe src="'.get_template_directory_uri().'/includes/audio_player.php?&audiofile='.$mp3url.'" width="100%" height="45" frameborder="0" class="player_ifr"></iframe>

</div> <!-- end .skyali_audio_player -->
';
	return $output_first.$heading.$output.$show_pages;
	
	$count_shortcodes++;
}



/* Event Countdown Shortcode for page builder */
add_shortcode('skyali_event_countdown', 'skyali_new_event_countdown');
function skyali_new_event_countdown($atts, $content = null) {
		extract(shortcode_atts(array(
				'heading' => '',
				'event_slogan' => '',
				'event_day' => '00',
				'event_month' => '00',
				'event_year' => '00',
				'event_time' => '00',
			), $atts));

if(is_int($event_day)) { $event_day == $event_day ;} else { $event_day ==''; }

if(is_int($event_year)) { $event_year == $event_year ;} else { $event_year ==''; }

$attributes = skyali_get_attributes( $atts, "skyali_event_countdown" );

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

$Length = 10;

$RandomString = substr(str_shuffle(md5(time())),0,10);


if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

if(!empty($event_slogan)) { $post_custom_heading = '<h3 class="event_countdown_heading">'.$event_slogan.'</h3>'; } else { $post_custom_heading=''; }

$output = '

 <script type="text/javascript">
		jQuery(document).ready(function($){$("#eventcountdown").countdown({date:"'.$event_day.' '.$event_month.' '.$event_year.' '.$event_time.'",format:"on"},function(){})});

</script>
                        <ul id="eventcountdown">
						
						'.$post_custom_heading.'
						
                            <li>
                                <span class="days">00</span>
                                <p class="timeRefDays">days</p>
                            </li>
                            <li>
                                <span class="hours">00</span>
                                <p class="timeRefHours">hours</p>
                            </li>
                            <li>
                                <span class="minutes">00</span>
                                <p class="timeRefMinutes">minutes</p>
                            </li>
                            <li>
                                <span class="seconds">00</span>
                                <p class="timeRefSeconds">seconds</p>
                            </li>
                        </ul>

</div> <!-- end .skyali_event_countdown -->
';
	return $output_first.$heading.$output.$show_pages;
	
	$count_shortcodes++;
}

/* Audio Playlist Shortcode for page builder */
add_shortcode('skyali_audio_playlist', 'skyali_new_audio_playlist');
function skyali_new_audio_playlist($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
				'song_title_1' => '',
				'mp3url_1' => '',
                'song_title_2' => '',
				'mp3url_2' => '',
                'song_title_3' => '',
				'mp3url_3' => '',
                'song_title_4' => '',
				'mp3url_4' => '',
                'song_title_5' => '',
				'mp3url_5' => '',
                'song_title_6' => '',
				'mp3url_6' => '',
                'song_title_7' => '',
				'mp3url_7' => '',
                'song_title_8' => '',
				'mp3url_8' => '',
                'song_title_9' => '',
				'mp3url_9' => '',
                'song_title_10' => '',
				'mp3url_10' => '',
                'song_title_11' => '',
				'mp3url_11' => '',
                'song_title_12' => '',
				'mp3url_12' => '',
                'song_title_13' => '',
				'mp3url_13' => '',
                'song_title_14' => '',
				'mp3url_14' => '',
                'song_title_15' => '',
				'mp3url_15' => '',
                'song_title_16' => '',
				'mp3url_16' => '',
                'song_title_17' => '',
				'mp3url_17' => '',
                'song_title_18' => '',
				'mp3url_18' => '',
                'song_title_19' => '',
				'mp3url_19' => '',
                'song_title_20' => '',
				'mp3url_20' => '',
                'song_title_21' => '',
				'mp3url_21' => '',
                'song_title_22' => '',
				'mp3url_22' => '',
                'song_title_23' => '',
				'mp3url_23' => '',
                'song_title_24' => '',
				'mp3url_24' => '',
                'song_title_25' => '',
				'mp3url_25' => '',
                'song_title_26' => '',
				'mp3url_26' => '',
                'song_title_27' => '',
				'mp3url_27' => '',
                'song_title_28' => '',
				'mp3url_28' => '',
				'song_title_29' => '',
				'mp3url_29' => '',
                'song_title_30' => '',
				'mp3url_30' => ''
     
			), $atts));
	$attributes = skyali_get_attributes( $atts, "skyali_audio_playlist" );

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }


$output_array = array();

for ($i = 1; $i <= 30; $i++) {

	if(!empty(${'mp3url_'.$i}) && !empty(${'song_title_'.$i}) ){
		${'mp3url_' .$i} =  htmlentities(${'mp3url_' .$i});
	array_push($output_array,"<li><a href=\"#\" data-src=\"".${'mp3url_' .$i}."\">".${'song_title_'.$i}."</a></li>","");
	}
}

$comma_separated = implode("", $output_array);

$output = ''.$comma_separated.'';

$div_first = '<div class="audio_player_list">

<audio id="playlist" preload="none"></audio>

      <ol>';
	  
	  
	 


$div_end = '</ol>
      
  </div>  
  
</div> <!-- end .skyali_audio_playlist -->';

	return $output_first.$heading.$div_first.$output.$div_end;
}


/* Contact Form Shortcode for page builder */
add_shortcode('skyali_contact_form', 'skyali_new_contact_form');
function skyali_new_contact_form($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
				'contact_email' => '',
			), $atts));
	$attributes = skyali_get_attributes( $atts, "skyali_contact_form" );

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

/* Contact Form PHP */
$name_post = @trim($_POST['contactname']);
$email_post = @$_POST['email'];
$message_post = @trim($_POST['message']);
/* check if form is submitted */
if(isset($_POST['submitform'])){
if($name_post != '' && $email_post != '' && $message_post != '' && $_POST['num_check'] == 7 && $contact_email != ''){
$Name = "".$name_post.""; //senders name
$email = "".$email_post.""; //senders e-mail adress
$recipient = "".$contact_email.""; //recipient
$mail_body = "".$message_post.""; //mail body
$subject = "New message from ".$name_post.""; //subject
$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields
mail($recipient, $subject, $mail_body, $header); //mail command :)
if(filter_var($email_post, FILTER_VALIDATE_EMAIL) != true){
$email_filter = '<font size="2" color="#ff0000">*</font>';
}
}
if($message_post == ''){
$message_post_message = '<font color="#ff0000">*</font>';
}
if($email_post == ''){
$email_post_message = '<font color="#ff0000">*</font>';
}
if($name_post == ''){
$name_post_message = '<font color="#ff0000">*</font>';
}
$check_num = $_POST['num_check'];
if($check_num != 7){
$check_num_message = '<font color="#ff0000" size="2">*</font>';

}

}

$warning_box ='';
 if ( $contact_email == '' ) { 

$warning_box= '<div class="warning_box boxes">'.translate('If you are the admin of this site please setup your email.','vibration').'</div>';
 } 
 
$output='<form action="" method="post" id="contact_form">
<label for="contactname">'.get_option('skypanel_vibration_contact_form_name').''.@$name_post_message.'</label>
<input type="text" name="contactname" value="'.$name_post.'" class="round_edges" />
<label for="email">'.get_option('skypanel_vibration_contact_form_email').' '.@$email_post_message.'</label>
<input type="text" name="email" value="'.$email_post.'" class="round_edges"/>
'.@$email_filter.'
<label for="message">'.get_option('skypanel_vibration_contact_form_message').''.@$message_post_message.'</label>
<textarea name="message" class="round_edges">'.htmlentities($message_post).'</textarea>
<label for="num_check">'.translate("5 + 2 = ","vibration").''.@$check_num_message.'</label>
<input type="text" name="num_check" class="round_edges" />
<div class="button"><input type="submit" class="imgf formsubmit yellow_arrow_button" value="'.get_option('skypanel_vibration_contact_form_send_message').'" name="submitform" id="submitform" /></div>
</form></div> <!-- end .skyali_contact_form -->';

$success_box = '';

if($message_post != '' && $email_post != '' && $name_post != '' && $check_num == 7){

$success_box='<div class="success_box boxes" style="margin-top:12px;">'.get_option('skypanel_vibration_contact_form_email_sent').'</div><!-- #success -->';

}

	return $output_first.$heading.$success_box.$warning_box.$output;
}

/* Accordion Shortcode for page builder */
add_shortcode('skyali_accordion', 'skyali_new_accordion');
function skyali_new_accordion($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => ''
			), $atts));
	$attributes = skyali_get_attributes( $atts, "skyali_accordion" );

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

$output = ''. do_shortcode( skyali_fix_shortcodes($content) ) .'</div> <!-- end .skyali_accordion -->';
	return $output_first.$heading.$output;
}


/* Toggle Shortcode for page builder */
add_shortcode('skyali_toggle', 'skyali_new_toggle');
function skyali_new_toggle($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => ''
			), $atts));
	$attributes = skyali_get_attributes( $atts, "skyali_toggle" );

$output_first = "<div {$attributes['class']}{$attributes['inline_styles']}>";

if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

$output = ''. do_shortcode( skyali_fix_shortcodes($content) ) .'</div> <!-- end .skyali_toggle -->';
	
	return $output_first.$heading.$output;
}

add_shortcode('skyali_video', 'skyali_lt_new_video');
function skyali_lt_new_video($atts, $content = null) {
	extract(shortcode_atts(array(
	            'heading' => ''
			), $atts));

	$attributes = skyali_get_attributes( $atts, "skyali_video" );
		if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }
		
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>	
					<div class='skyali_video-bg'>
						<div class='skyali_video-container clearfix'>"
							. do_shortcode( skyali_fix_shortcodes($content) ) .
						"</div> <!-- end .skyali-video-container-->
					</div> <!-- end .skyali-video-bg-->
					<div class='skyali_video-bottom-left'>
						<div class='skyali_video-bottom-right'>
							<div class='skyali_video-bottom-center'></div>
						</div>	
					</div>
				</div> <!-- end .skyali_note-video-->";

	return $heading.$output;
}


add_shortcode('skyali_slider', 'skyali_lt_new_slider');
function skyali_lt_new_slider($atts, $content = null){
	global $skyali_sliders_on_page, $skyali_slider_imagesize;
	
	extract(shortcode_atts(array(
	            'heading' => '',
				'auto' => 'false',
				'pager' => 'true',
				'nav' => 'true',
				'speed' => '500',
			), $atts));
	
	
	$skyali_sliders_on_page = isset( $skyali_sliders_on_page ) ? ++$skyali_sliders_on_page : 1;
	
	if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

	
	$attributes = skyali_get_attributes( $atts, "skyali_slider" );
	if($auto != ''){ }else{$auto ='false';}
	if($pager != ''){ }else{$pager ='true';}
	if($nav != ''){ }else{$nav ='true';}
	if($speed != ''){ }else{$speed ='500';}
	$output = 	"<div id='" . esc_attr('skyali_slider_' . $skyali_sliders_on_page) . "' {$attributes['class']}{$attributes['inline_styles']}>
					 <div class='rslides_container'>
						  <ul class='rslides' id='slider".$skyali_sliders_on_page."'>"
							. do_shortcode( skyali_fix_shortcodes($content) ) .
						"</ul> <!-- end .slides -->
					</div> <!-- .responsiveslides -->
				</div> <!-- end .skyali_slider --><script type='text/javascript'>
jQuery(document).ready(function($) {
    $(function () {

      // Slideshow ".$skyali_sliders_on_page."
      $('#slider".$skyali_sliders_on_page."').responsiveSlides({
        auto:".$auto.",
        pager:".$pager.",
        nav: ".$nav.",
        speed: ".$speed.",
        maxwidth: 960,
        namespace: 'centered-btns'
      });
    });
	 });
  </script>
";
				
	return $heading.$output;
}

add_shortcode('skyali_lt_attachment', 'skyali_lt_new_attachment');
function skyali_lt_new_attachment($atts, $content = null){
	global $skyali_slider_imagesize;
	
	extract(shortcode_atts(array(
				'attachment_id' => '',
				'link' => ''
			), $atts));

	$attachment_image = $image_size = '';
	$image = wp_get_attachment_image_src( $attachment_id, 'full' );
	
	if ( '' != $skyali_slider_imagesize ){
		$image_size = explode( 'x', $skyali_slider_imagesize );
		$image_size = array_map('intval', $image_size);
	}
	
	$attachment_image = ( '' != $image && '' == $skyali_slider_imagesize ) ? $image[0] : skyali_lt_new_thumb_resize( skyali_lt_multisite_thumbnail( $image[0] ), $image_size[0], $image_size[1], '', true );
	if ( '' != $attachment_image ) $attachment_image = "<img alt='' src='" . esc_url( $attachment_image ) . "' />";
	
	$output = 	"<li>"
					." ". $attachment_image ." ".
			
				"</li>";
	
	return $output;
}

add_shortcode('skyali_tabs', 'skyali_lt_new_tabs');
function skyali_lt_new_tabs($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => ''
			), $atts));
	global $skyali_tab_titles;
	
	$skyali_tab_titles = array();
	$attributes = skyali_get_attributes( $atts, "skyali_tabs" );
if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }
	$tabs_content = "<div class=\"list-wrap\">
". do_shortcode( skyali_fix_shortcodes($content) ) .
					"</div> <!-- END list wrap -->";

	$tabs = '<ul class="nav">';
	
	$i = 0;
	foreach ( $skyali_tab_titles as $tab_title ){
		++$i;
		$title_remake = str_replace(' ', '_',$tab_title);
		$tabs .= "<li><a href='#".$title_remake."' " . ( 1 == $i ? ' class="current"' : '' ) . ">{$tab_title}</a></li>";
	}
	$tabs .= "</ul>";
	
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
	<div id=\"custom_tabs\" class=\"skyali_custom_tabs\">

					{$tabs}
					{$tabs_content}
					</div><!-- skyali_custom_tabs -->
				</div> <!-- end .skyali_tabs -->";
	
	return  $heading.$output;
}

add_shortcode('skyali_tab', 'skyali_lt_new_tab');
function skyali_lt_new_tab($atts, $content = null) {
	global $skyali_tab_titles;
	
	extract(shortcode_atts(array(
				'title' => ''
			), $atts));
	
	$skyali_tab_titles[] = '' != $title ? $title : 'Tab';
	$title_remake_content = str_replace(' ','_',$title);
	$output = 	"<ul id=\"".$title_remake_content."\" class='content_area" . ( 1 != count( $skyali_tab_titles ) ? " hidetab" : '' ) . "'><div class=\"tabs-post\">"
					. do_shortcode( skyali_fix_shortcodes($content) ) .
				"</div><!-- tabs-post--> </ul><!-- end .skyali_tab -->";

	return $output;
}

function skyali_lt_new_alt_column( $atts, $content = null, $name = '' ){
	$name = str_replace( 'alt_', '', $name );
	$attributes = skyali_get_attributes( $atts, "skyali_column {$name}" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( skyali_fix_shortcodes($content) ) .
				"</div> <!-- end .skyali_column_{$name} -->";

	return $output;
}

add_shortcode('skyali_text_block', 'skyali_lt_new_short_codes');
function skyali_lt_new_short_codes($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => ''
			), $atts));
			
	if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }		
	$attributes = skyali_get_attributes( $atts, "skyali_text_block" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( skyali_fix_shortcodes($content) ) .
				"</div> <!-- end .skyali_short_codes -->";

	return $heading.$output;
}

add_shortcode('skyali_widget_area', 'skyali_lt_new_widget_area');
function skyali_lt_new_widget_area($atts, $content = null) {
	extract(shortcode_atts(array(
				'area' => 'Page Builder Widget Area 1'
			), $atts));
			
	$attributes = skyali_get_attributes( $atts, "skyali_widget_area" );
	
	ob_start();
	dynamic_sidebar($area);
	$widgets = ob_get_contents();
	ob_end_clean();
	
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. $widgets .
				"</div> <!-- end .skyali_widget_area -->";

	return $output;
}

add_shortcode('skyali_image','skyali_lt_new_image');
function skyali_lt_new_image($atts, $content = null) {
	extract(shortcode_atts(array(
	            'heading' => '',
				'image_url' => '',
				'imagesize' => '',
				'image_title' => '',
				'skyali_image_editor' =>''
			), $atts));
		
		
			
	$attributes = skyali_get_attributes( $atts, "skyali_image" );
	
	if ( '' != $imagesize ){
		$image_size = explode( 'x', $imagesize );
		$image_size = array_map('intval', $image_size);
	}
	
	$image = ( '' != $image_url && '' == $imagesize ) ? $image_url : skyali_lt_new_thumb_resize( skyali_lt_multisite_thumbnail( $image_url ), $image_size[0], $image_size[1], '', true );
	if ( '' != $image ) $image = "<img alt='' src='" . esc_url( $image ) . "' title='' />";
	
	
	if(!empty($heading)) { $heading = '<span class="heading"><h3>'.$heading.'</h3></span>'; } else { $heading = ''; }

	
	
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='skyali_module_content'>
						<div class='skyali_module_content_inner clearfix'>"
							. ( '' != $image ? '<div class="skyali_image_box">' . "<a href='" . esc_url($image_url) . "' class='fancybox' title='" . esc_attr( $image_title ) . "'>{$image}<span class='skyali_zoom_icon'></span></a>" . '</div>' : '' )
							. ( '' != trim($content) ? '<div class="skyali_image_content">' . do_shortcode( skyali_fix_shortcodes($content) ) . '</div> <!-- end .skyali_image_content -->' : '' ) .
				"		</div> <!-- end .skyali_module_content_inner -->
					</div> <!-- end .skyali_module_content -->
				</div> <!-- end .skyali_widget_area -->";
				
	return $heading.$output;
}
	

add_action( 'after_setup_theme', 'skyali_setup_theme' );
	if ( ! function_exists( 'skyali_setup_theme' ) ){
		function skyali_setup_theme(){
			remove_action( 'admin_init', 'skyali_lt_theme_check_clean_installation' );
			
			add_action( 'skyali_hidden_editor', 'et_advanced_buttons' );
			
			add_action( 'add_meta_boxes', 'skyali_add_custom_box' );
			
		}
	}


	
	function skyali_new_settings_page_css(){
		wp_enqueue_style( 'skyali_admin_css', SKYALI_THEME_URI . '/css/skyali_page_builder.css', array());
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_style( 'thickbox' );
	}

	function skyali_new_settings_page_js(){	
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_script( 'jquery-ui-resizable' );
		
		wp_enqueue_script( 'skyali_admin_js', SKYALI_THEME_URI . '/js/skyali_page_builder.js', array('jquery','jquery-ui-core','jquery-ui-sortable','jquery-ui-draggable','jquery-ui-droppable','jquery-ui-resizable') );
		wp_localize_script( 'skyali_admin_js', 'skyali_options', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'skyali_lt_load_nonce' => wp_create_nonce( 'skyali_lt_load_nonce' ), 
		'confirm_message' => __('Proceed Deleting item?', 'vibration'), 
		'confirm_clear_all_message' => __('Are you sure you want to clear all items?', 'vibration'),
		 'create_layout_name' => __('Layout Name', 'vibration'), 
		 'create_layout_confirm_message_yes' => __('Create', 'vibration'), 'create_layout_confirm_message_no' => __('Cancel', 'vibration'), 
		  'confirm_message_yes' => __('Yes', 'vibration'), 'confirm_message_no' => __('Cancel', 'vibration'), 'saving_text' => __('Saving Changes.', 'vibration'),
		   'saved_text' => __('Changes Saved.', 'vibration') ) );
	}


	function skyali_plugin_settings_validate( $input ) {
		$output = array();

		$output['post_types'] = isset( $input['post_types'] ) ? (array) $input['post_types'] : array();

		return apply_filters( 'skyali_plugin_settings_validate', $output, $input );
	}

	function skyali_field_responsive_layout_html() {
		$options = (array) skyali_get_plugin_options();
		
		$default_post_types = array( 'attachment', 'revision', 'nav_menu_item' );
		$custom_post_types = get_post_types();
		
		foreach ( $custom_post_types as $custom_post_key => $custom_post_name ){
			if ( in_array( $custom_post_key, $default_post_types ) ) unset( $custom_post_types[$custom_post_key] );
		}

		foreach ( $custom_post_types as $post_type_key => $post_type_name ){
			$post_type_object = get_post_type_object( $post_type_key );
			echo '<p><label>';
				echo '<input type="checkbox" name="skyali_main_settings[post_types][]" value="' . esc_attr( $post_type_key ) . '" ' . checked( in_array( $post_type_key, $options ), true, false ) . ' />';
				echo ' ' . esc_html( $post_type_object->labels->singular_name );
			echo '</label></p>';
		}
	}
	
	add_action('init','skyali_new_modules_init');
	function skyali_new_modules_init(){
		global $skyali_modules;
		
		$skyali_widget_areas = apply_filters( 'skyali_widget_areas', array( __(' Widget Area 1', 'skyali'), __('Page Builder Widget Area 2', 'skyali'), __('Page Builder Widget Area 3', 'skyali'), __('Page Builder Widget Area 4', 'skyali'), __('Page Builder Widget Area 5', 'skyali') ) );
		
		
		
		$skyali_modules['latest_posts'] = array(
			'name' => __('Latest Posts', 'skyali'),
			'options' => array(
			'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				)
				,
				'author' => array(
					'title' => __('Sort by author name', 'skyali'),
					'type' => 'text'
				),
				'category_name' => array(
					'title' => __('Sort by category name', 'skyali'),
					'type' => 'text'
				),
				'order' => array(
					'title' => __('Sort by order(default:DESC)', 'skyali'),
					'type' => 'text'
				),
				'orderby' => array(
					'title' => __('Sort by orderby (default:Date)', 'skyali'),
					'type' => 'text'
				),
				'posts_per_page' => array(
					'title' => __('Posts Per Page', 'skyali'),
					'type' => 'text'
				),
				'pagination' => array(
					'title' => __('Pagination (Default:true)', 'skyali'),
					'type' => 'text'
				),
				'tag' => array(
					'title' => __('Sort by tags', 'skyali'),
					'type' => 'text'
				)
				
			)
		
			
		);
		
		
		
			$skyali_modules['latest_posts_style_2'] = array(
			'name' => __('Latest Posts Style 2', 'skyali'),
			'options' => array(
				'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'author' => array(
					'title' => __('Sort by author name', 'skyali'),
					'type' => 'text'
				),
				'category_name' => array(
					'title' => __('Sort by category name', 'skyali'),
					'type' => 'text'
				),
				'order' => array(
					'title' => __('Sort by order(default:DESC)', 'skyali'),
					'type' => 'text'
				),
				'orderby' => array(
					'title' => __('Sort by orderby (default:Date)', 'skyali'),
					'type' => 'text'
				),
				'posts_per_page' => array(
					'title' => __('Posts Per Page', 'skyali'),
					'type' => 'text'
				),
				'pagination' => array(
					'title' => __('Pagination (Default:true)', 'skyali'),
					'type' => 'text'
				),
				'tag' => array(
					'title' => __('Sort by tags', 'skyali'),
					'type' => 'text'
				)
			)
		);
		
			$skyali_modules['latest_posts_style_3'] = array(
			'name' => __('Latest Posts Style 3', 'skyali'),
			'options' => array(
				'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'author' => array(
					'title' => __('Sort by author name', 'skyali'),
					'type' => 'text'
				),
				'category_name' => array(
					'title' => __('Sort by category name', 'skyali'),
					'type' => 'text'
				),
				'order' => array(
					'title' => __('Sort by order(default:DESC)', 'skyali'),
					'type' => 'text'
				),
				'orderby' => array(
					'title' => __('Sort by orderby (default:Date)', 'skyali'),
					'type' => 'text'
				),
				'posts_per_page' => array(
					'title' => __('Posts Per Page', 'skyali'),
					'type' => 'text'
				),
				'pagination' => array(
					'title' => __('Pagination (Default:true)', 'skyali'),
					'type' => 'text'
				),
				'tag' => array(
					'title' => __('Sort by tags', 'skyali'),
					'type' => 'text'
				)
			
			)
		);
		
			$skyali_modules['latest_albums'] = array(
			'name' => __('Latest Albums', 'skyali'),
			'options' => array(
				'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'author' => array(
					'title' => __('Sort by author name', 'skyali'),
					'type' => 'text'
				),
				'album_categories' => array(
					'title' => __('Sort by category ID', 'skyali'),
					'type' => 'text'
				),
				'order' => array(
					'title' => __('Sort by order(default:DESC)', 'skyali'),
					'type' => 'text'
				),
				'orderby' => array(
					'title' => __('Sort by orderby (default:Date)', 'skyali'),
					'type' => 'text'
				),
				'posts_per_page' => array(
					'title' => __('Posts Per Page', 'skyali'),
					'type' => 'text'
				),
				'pagination' => array(
					'title' => __('Pagination (Default:true)', 'skyali'),
					'type' => 'text'
				),
				'tag' => array(
					'title' => __('Sort by tags', 'skyali'),
					'type' => 'text'
				)
			)
		);
		
		
			$skyali_modules['latest_shows'] = array(
			'name' => __('Latest Shows', 'skyali'),
			'options' => array(
					'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'author' => array(
					'title' => __('Sort by author name', 'skyali'),
					'type' => 'text'
				),
				'shows_categories' => array(
					'title' => __('Sort by category ID', 'skyali'),
					'type' => 'text'
				),
				'order' => array(
					'title' => __('Sort by order(default:DESC)', 'skyali'),
					'type' => 'text'
				),
				'orderby' => array(
					'title' => __('Sort by orderby (default:Date)', 'skyali'),
					'type' => 'text'
				),
				'posts_per_page' => array(
					'title' => __('Posts Per Page', 'skyali'),
					'type' => 'text'
				),
				'pagination' => array(
					'title' => __('Pagination (Default:true)', 'skyali'),
					'type' => 'text'
				),
				'tag' => array(
					'title' => __('Sort by tags', 'skyali'),
					'type' => 'text'
				)
			)
		);
		
		$skyali_modules['latest_shows_style_2'] = array(
			'name' => __('Latest Shows Style 2', 'skyali'),
			'options' => array(
				'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'author' => array(
					'title' => __('Sort by author name', 'skyali'),
					'type' => 'text'
				),
				'shows_categories' => array(
					'title' => __('Sort by category ID', 'skyali'),
					'type' => 'text'
				),
				'order' => array(
					'title' => __('Sort by order(default:DESC)', 'skyali'),
					'type' => 'text'
				),
				'orderby' => array(
					'title' => __('Sort by orderby (default:Date)', 'skyali'),
					'type' => 'text'
				),
				'posts_per_page' => array(
					'title' => __('Posts Per Page', 'skyali'),
					'type' => 'text'
				),
				'pagination' => array(
					'title' => __('Pagination (Default:true)', 'skyali'),
					'type' => 'text'
				),
				'tag' => array(
					'title' => __('Sort by tags', 'skyali'),
					'type' => 'text'
				)
				
			)
		);
		
		
			$skyali_modules['latest_photos'] = array(
			'name' => __('Latest Photos', 'skyali'),
			'options' => array(
				'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'author' => array(
					'title' => __('Sort by author name', 'skyali'),
					'type' => 'text'
				),
				'gallery_categories' => array(
					'title' => __('Sort by category ID', 'skyali'),
					'type' => 'text'
				),
				'order' => array(
					'title' => __('Sort by order(default:DESC)', 'skyali'),
					'type' => 'text'
				),
				'orderby' => array(
					'title' => __('Sort by orderby (default:Date)', 'skyali'),
					'type' => 'text'
				),
				'posts_per_page' => array(
					'title' => __('Posts Per Page', 'skyali'),
					'type' => 'text'
				),
				'pagination' => array(
					'title' => __('Pagination (Default:true)', 'skyali'),
					'type' => 'text'
				),
				'tag' => array(
					'title' => __('Sort by tags', 'skyali'),
					'type' => 'text'
				)
				
			)
		);
		
		$skyali_modules['latest_videos'] = array(
			'name' => __('Latest Videos', 'skyali'),
			'options' => array(
				'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'author' => array(
					'title' => __('Sort by author name', 'skyali'),
					'type' => 'text'
				),
				'videos_categories' => array(
					'title' => __('Sort by category ID', 'skyali'),
					'type' => 'text'
				),
				'order' => array(
					'title' => __('Sort by order(default:DESC)', 'skyali'),
					'type' => 'text'
				),
				'orderby' => array(
					'title' => __('Sort by orderby (default:Date)', 'skyali'),
					'type' => 'text'
				),
				'posts_per_page' => array(
					'title' => __('Posts Per Page', 'skyali'),
					'type' => 'text'
				),
				'pagination' => array(
					'title' => __('Pagination (Default:true)', 'skyali'),
					'type' => 'text'
				),
				'tag' => array(
					'title' => __('Sort by tags', 'skyali'),
					'type' => 'text'
				)
				
			)
		);
		
				$skyali_modules['audio_player'] = array(
			'name' => __('Audio Player', 'skyali'),
			'options' => array(
			'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),'mp3url' => array(
					'title' => __('Mp3 Url', 'skyali'),
					'type' => 'text'
				)
				
			)
		);
		
		
				$skyali_modules['event_countdown'] = array(
			'name' => __('Event Countdown', 'skyali'),
			'options' => array(
			'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'event_slogan' => array(
					'title' => __('Event Slogan', 'skyali'),
					'type' => 'text'
				),
				'event_day' => array(
					'title' => __('Event Day (Example:24)', 'skyali'),
					'type' => 'text'
				),'event_month' => array(
					'title' => __('Event Month (Example:April)', 'skyali'),
					'type' => 'text'
				),'event_year' => array(
					'title' => __('Event Year (Example:2013)', 'skyali'),
					'type' => 'text'
				),'event_time' => array(
					'title' => __('Event Time (Example:09:00 AM)', 'skyali'),
					'type' => 'text'
				)
				
			)
		);
			
		
			$skyali_modules['audio_playlist'] = array(
			'name' => __('Audio Playlist', 'skyali'),
			'options' => array(
			'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'song_title_1' => array(
					'title' => __('Song Title 1', 'skyali'),
					'type' => 'text'
					
				),
				'mp3url_1' => array(
					'title' => __('Mp3 Url 1', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_2' => array(
					'title' => __('Song Title 2', 'skyali'),
					'type' => 'text'
					
				),
				'mp3url_2' => array(
					'title' => __('Mp3 Url 2', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_3' => array(
					'title' => __('Song Title 3', 'skyali'),
					'type' => 'text'
				
				),
				'mp3url_3' => array(
					'title' => __('Mp3 Url 3', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_4' => array(
					'title' => __('Song Title 4', 'skyali'),
					'type' => 'text'
					
				),
				'mp3url_4' => array(
					'title' => __('Mp3 Url 4', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_5' => array(
					'title' => __('Song Title 5', 'skyali'),
					'type' => 'text'
					
				),
				'mp3url_5' => array(
					'title' => __('Mp3 Url 5', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_6' => array(
					'title' => __('Song Title 6', 'skyali'),
					'type' => 'text',
					
				),
				'mp3url_6' => array(
					'title' => __('Mp3 Url 6', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_7' => array(
					'title' => __('Song Title 7', 'skyali'),
					'type' => 'text'
				
				),
				'mp3url_7' => array(
					'title' => __('Mp3 Url 7', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_8' => array(
					'title' => __('Song Title 8', 'skyali'),
					'type' => 'text'
					
				),
				'mp3url_8' => array(
					'title' => __('Mp3 Url 8', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_9' => array(
					'title' => __('Song Title 9', 'skyali'),
					'type' => 'text'
					
				),
				'mp3url_9' => array(
					'title' => __('Mp3 Url 9', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_10' => array(
					'title' => __('Song Title 10', 'skyali'),
					'type' => 'text'
					
				),
				'mp3url_10' => array(
					'title' => __('Mp3 Url 10', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_11' => array(
					'title' => __('Song Title 11', 'skyali'),
					'type' => 'text'
					
				),
				'mp3url_11' => array(
					'title' => __('Mp3 Url 11', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_12' => array(
					'title' => __('Song Title 12', 'skyali'),
					'type' => 'text'
				
				),
				'mp3url_12' => array(
					'title' => __('Mp3 Url 12', 'skyali'),
					'type' => 'text'
				
				),
				'song_title_13' => array(
					'title' => __('Song Title 13', 'skyali'),
					'type' => 'text'
					
				),
				'mp3url_13' => array(
					'title' => __('Mp3 Url 13', 'skyali'),
					'type' => 'text'
					
				),
				'song_title_14' => array(
					'title' => __('Song Title 14', 'skyali'),
					'type' => 'text'
				
				),
				'mp3url_14' => array(
					'title' => __('Mp3 Url 14', 'skyali'),
					'type' => 'text'
				
				),
				'song_title_15' => array(
					'title' => __('Song Title 15', 'skyali'),
					'type' => 'text'
				),
				'mp3url_15' => array(
					'title' => __('Mp3 Url 15', 'skyali'),
					'type' => 'text'
				),
				'song_title_16' => array(
					'title' => __('Song Title 16', 'skyali'),
					'type' => 'text'
				),
				'mp3url_16' => array(
					'title' => __('Mp3 Url 16', 'skyali'),
					'type' => 'text'
				),
				'song_title_17' => array(
					'title' => __('Song Title 17', 'skyali'),
					'type' => 'text'
				),
				'mp3url_17' => array(
					'title' => __('Mp3 Url 17', 'skyali'),
					'type' => 'text'
				),
				'song_title_18' => array(
					'title' => __('Song Title 18', 'skyali'),
					'type' => 'text'
				),
				'mp3url_18' => array(
					'title' => __('Mp3 Url 18', 'skyali'),
					'type' => 'text'
				),
				'song_title_19' => array(
					'title' => __('Song Title 19', 'skyali'),
					'type' => 'text'
				),
				'mp3url_19' => array(
					'title' => __('Mp3 Url 19', 'skyali'),
					'type' => 'text'
				),
				'song_title_20' => array(
					'title' => __('Song Title 20', 'skyali'),
					'type' => 'text'
				),
				'mp3url_20' => array(
					'title' => __('Mp3 Url 20', 'skyali'),
					'type' => 'text'
				),
				'song_title_21' => array(
					'title' => __('Song Title 21', 'skyali'),
					'type' => 'text'
				),
				'mp3url_21' => array(
					'title' => __('Mp3 Url 21', 'skyali'),
					'type' => 'text'
				),
				'song_title_22' => array(
					'title' => __('Song Title 22', 'skyali'),
					'type' => 'text'
				),
				'mp3url_22' => array(
					'title' => __('Mp3 Url 22', 'skyali'),
					'type' => 'text'
				),
				'song_title_23' => array(
					'title' => __('Song Title 23', 'skyali'),
					'type' => 'text'
				),
				'mp3url_23' => array(
					'title' => __('Mp3 Url 23', 'skyali'),
					'type' => 'text'
				),
				'song_title_24' => array(
					'title' => __('Song Title 24', 'skyali'),
					'type' => 'text'
				),
				'mp3url_24' => array(
					'title' => __('Mp3 Url 24', 'skyali'),
					'type' => 'text'
				),
				'song_title_25' => array(
					'title' => __('Song Title 25', 'skyali'),
					'type' => 'text'
				),
				'mp3url_25' => array(
					'title' => __('Mp3 Url 25', 'skyali'),
					'type' => 'text'
				),
				'song_title_26' => array(
					'title' => __('Song Title 26', 'skyali'),
					'type' => 'text'
				),
				'mp3url_26' => array(
					'title' => __('Mp3 Url 26', 'skyali'),
					'type' => 'text'
				),
				'song_title_27' => array(
					'title' => __('Song Title 27', 'skyali'),
					'type' => 'text'
					
				),
				'mp3url_27' => array(
					'title' => __('Mp3 Url 27', 'skyali'),
					'type' => 'text'
				),
				'song_title_28' => array(
					'title' => __('Song Title 28', 'skyali'),
					'type' => 'text'
				),
				'mp3url_28' => array(
					'title' => __('Mp3 Url 28', 'skyali'),
					'type' => 'text'
				),
				'song_title_29' => array(
					'title' => __('Song Title 29', 'skyali'),
					'type' => 'text'
				),
				'mp3url_29' => array(
					'title' => __('Mp3 Url 29', 'skyali'),
					'type' => 'text'
				),
				'song_title_30' => array(
					'title' => __('Song Title 30', 'skyali'),
					'type' => 'text'
				),
				'mp3url_30' => array(
					'title' => __('Mp3 Url 30', 'skyali'),
					'type' => 'text'
					
				)

			)
		);
		
			$skyali_modules['contact_form'] = array(
			'name' => __('Contact Form', 'skyali'),
			'options' => array(
			'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'contact_email' => array(
					'title' => __('Contact Email', 'skyali'),
					'type' => 'text'
				)
			)
		);
		
			$skyali_modules['accordion'] = array(
			'name' => __('Accordion', 'skyali'),
			'options' => array(
			'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'accordion' => array(
					'title' => __('Use accordion shortcodes.', 'skyali'),
					'type' => 'wp_editor',
					'is_content' => true
				)
				
			)
		);
		
				$skyali_modules['toggle'] = array(
			'name' => __('Toggle', 'skyali'),
			'options' => array(
			'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'toggle' => array(
					'title' => __('Use toggle shortcodes.', 'skyali'),
					'type' => 'wp_editor',
					'is_content' => true
				)
			)
		);
		
		$skyali_modules['video'] = array(
			'name' => __('Video', 'skyali'),
			'options' => array(
			'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'text' => array(
					'title' => __('Embed Code', 'skyali'),
					'type' => 'wp_editor',
					'is_content' => true
				)
			)		
		);
			
		$skyali_modules['slider'] = array(
			'name' => __('Slideshow', 'skyali'),
			'options' => array(
				'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'auto' => array(
					'title' => __('Auto(Default:false)', 'skyali'),
					'type' => 'text'
				),
				'pager' => array(
					'title' => __('Pager(Default:true)', 'skyali'),
					'type' => 'text'
				),
				'nav' => array(
					'title' => __('Nav(Default:true)', 'skyali'),
					'type' => 'text'
				),
				'speed' => array(
					'title' => __('Speed(Default:500)', 'skyali'),
					'type' => 'text'
				),
				'images' => array(
					'type' => 'slider_images'
				)
				
			)
		);
		
		
		
		
		$skyali_modules['tabs'] = array(
			'name' => __('Tabs', 'skyali'),
			'options' => array(
				'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'tabs' => array(
					'type' => 'tabs_interface'
				)
			)
		);
		
		
		$skyali_modules['text_block'] = array(
			'name' => __('Short Codes', 'skyali'),
			'options' => array(
			'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'skyali_lt_text_block_content' => array(
					'title' => __('Content', 'skyali'),
					'type' => 'wp_editor',
					'is_content' => true
				)
				
			)
		);
	
		
		$skyali_modules['image'] = array(
			'name' => __('Image', 'skyali'),
			'options' => array(
			'heading' => array(
					'title' => __('Heading', 'skyali'),
					'type' => 'text'
				),
				'image_url' => array(
					'title' => __('Image Url', 'skyali'),
					'type' => 'upload'
				),
				'imagesize' => array(
					'title' => __('Image Dimensions', 'skyali'),
					'type' => 'text'
				),
				
				'skyali_image_editor' => array(
					'title' => __('Use Editor', 'skyali'),
					'type' => 'wp_editor',
					'is_content' => true
				)
			)
		);
		
		$skyali_modules = apply_filters( 'skyali_modules', $skyali_modules );
		
		$skyali_settings = get_option( 'skyali_settings' );
		
	}

	function skyali_new_build_settings_page(){
		global $skyali_modules, $post;
		$skyali_helper_class = '';
		$skyali_lt_convertible_settings = get_post_meta( get_the_ID(), '_skyali_lt_builder_settings', true );
	?>
		<?php do_action( 'skyali_lt_before_page_builder' ); ?>
		
		<div id="skyali_lt_page_builder">
			<div id="skyali_lt_builder_controls" class="clearfix">
				<a href="#" class="skyali_lt_add_element skyali_lt_add_module"><span><?php esc_html_e('Add Items', 'skyali'); ?></span></a>
				
			</div> <!-- #skyali_lt_builder_controls -->
			
			<div id="skyali_modules">
				<?php
					foreach ( $skyali_modules as $module_key => $module_settings ){
						$class = "skyali_lt_module skyali_m_{$module_key}";
						if ( isset( $module_settings['full_width'] ) && $module_settings['full_width'] ) $class .= ' et_full_width';
						
						echo "<div data-placeholder='" . esc_attr( $module_settings['name'] ) . "' data-name='" . esc_attr( $module_key ) . "' class='" . esc_attr( $class ) . "'>" . '<span class="skyali_lt_module_name">' . esc_html( $module_settings['name'] ) . '</span>' .
						'<span class="skyali_move"></span><span class="skyali_lt_delete"></span><span class="skyali_settings_arrow"></span><div class="skyali_lt_module_settings"></div></div>';
					}
					
				?>
				<div id="skyali_module_separator"></div>
				<div id="active_module_settings"></div>
			</div> <!-- #skyali_modules -->
			
			<div id="skyali_lt_layout_container">
				<div id="skyali_lt_layout" class="clearfix">
					<?php 
						if ( is_array( $skyali_lt_convertible_settings ) && $skyali_lt_convertible_settings['layout_html'] ) {
							echo stripslashes( $skyali_lt_convertible_settings['layout_html'] );
							$skyali_helper_class = ' class="hidden"';
						}
					?>
				</div> <!-- #skyali_lt_layout -->
			
			</div> <!-- #skyali_lt_layout_container -->
			
			<div style="display: none;">
				<?php
					wp_editor( ' ', 'skyali_hidden_editor' );
					do_action( 'skyali_hidden_editor' );
				?>
			</div>
		</div> <!-- #skyali_lt_page_builder -->
		
		<div id="skyali_ajax_save">
			<img src="<?php echo esc_url( SKYALI_THEME_URI . '/images/skyali_page_builder_images/saver.gif' ); ?>" alt="loading" id="loading" />
			<span><?php esc_html_e( 'Changes Saving', 'vibration' ); ?></span>
		</div>
		
		<?php
			echo '<div id="skyali_save" class="clearfix">';
				echo '<div id="skyali_secondary_buttons">';
					echo '<span id="skyali_clear_all_wrapper">';
						submit_button( __('Clear Items', 'vibration'), 'secondary', 'skyali_clear_all', false );
					echo '</span>';
					
				echo '</div> <!-- #skyali_secondary_buttons -->';
				submit_button( __('Save', 'vibration'), 'primary', 'skyali_main_save', false );
			echo '</div> <!-- end #skyali_save -->';
	}

	add_action( 'wp_ajax_skyali_save_layout', 'skyali_lt_new_save_layout' );
	function skyali_lt_new_save_layout(){
		if ( ! wp_verify_nonce( $_POST['skyali_lt_load_nonce'], 'skyali_lt_load_nonce' ) ) die(-1);
		
		$skyali_lt_convertible_settings = array();
		
		$skyali_lt_convertible_settings['layout_html'] = trim( $_POST['skyali_lt_layout_html'] );
		$skyali_lt_convertible_settings['layout_shortcode'] = $_POST['skyali_lt_layout_shortcode'];
		$skyali_post_id = (int) $_POST['skyali_post_id'];
		
		if ( get_post_meta( $skyali_post_id, '_skyali_lt_builder_settings', true ) ) update_post_meta( $skyali_post_id, '_skyali_lt_builder_settings', $skyali_lt_convertible_settings );
		else add_post_meta( $skyali_post_id, '_skyali_lt_builder_settings', $skyali_lt_convertible_settings, true );
		
		die();
	}
	
	
	
	

	add_action( 'wp_ajax_skyali_append_layout', 'skyali_lt_new_append_layout' );
	function skyali_lt_new_append_layout(){
		
		
		if ( ! wp_verify_nonce( $_POST['skyali_lt_load_nonce'], 'skyali_lt_load_nonce' ) ) die(-1);
		
		$layout_name = $_POST['skyali_lt_layout_name'];
		
		
		die();
	}

	add_action( 'wp_ajax_skyali_show_module_options', 'skyali_lt_new_show_module_options' );
	function skyali_lt_new_show_module_options(){
		if ( ! wp_verify_nonce( $_POST['skyali_lt_load_nonce'], 'skyali_lt_load_nonce' ) ) die(-1);
		
		$module_class = $_POST['skyali_lt_module_class'];
		$skyali_lt_module_exact_name = $_POST['skyali_lt_module_exact_name'];
		$module_window = (int) $_POST['skyali_lt_modal_window'];
		
		preg_match( '/skyali_m_([^\s])+/', $module_class, $matches );
		$module_name = str_replace( 'skyali_m_', '', $matches[0] );
		
		$paste_to_editor_id = isset( $_POST['skyali_lt_paste_to_editor_id'] ) ? $_POST['skyali_lt_paste_to_editor_id'] : '';
		
		skyali_generate_module_options( $module_name, $module_window, $paste_to_editor_id, $skyali_lt_module_exact_name );
		
		die();
	}

	add_action( 'wp_ajax_skyali_show_column_options', 'skyali_lt_new_show_column_options' );
	function skyali_lt_new_show_column_options(){
		if ( ! wp_verify_nonce( $_POST['skyali_lt_load_nonce'], 'skyali_lt_load_nonce' ) ) die(-1);
		
		$module_class = $_POST['skyali_lt_module_class'];
		
		preg_match( '/skyali_m_column_([^\s])+/', $module_class, $matches );
		$module_name = str_replace( 'skyali_m_column_', '', $matches[0] );
		
		$paste_to_editor_id = isset( $_POST['skyali_lt_paste_to_editor_id'] ) ? $_POST['skyali_lt_paste_to_editor_id'] : '';
		
		et_generate_column_options( $module_name, $paste_to_editor_id );
		
		die();
	}

	add_action( 'wp_ajax_skyali_add_slider_item', 'skyali_lt_new_add_slider_item' );
	function skyali_lt_new_add_slider_item(){
		if ( ! wp_verify_nonce( $_POST['skyali_lt_load_nonce'], 'skyali_lt_load_nonce' ) ) die(-1);
		
		$attachment_class = $_POST['skyali_lt_attachment_class'];
		$skyali_lt_change_image = (bool) $_POST['skyali_lt_change_image'];

		preg_match( '/wp-image-([\d])+/', $attachment_class, $matches );
		$attachment_id = str_replace( 'wp-image-', '', $matches[0] );
		$attachment_image = wp_get_attachment_image( $attachment_id );
		
		if ( $skyali_lt_change_image ) {
			echo json_encode( array( 'attachment_image' => $attachment_image, 'attachment_id' => $attachment_id ) );
		} else {
			echo '<div class="skyali_lt_attachment clearfix" data-attachment="' . esc_attr( $attachment_id ) .'">' 
					. $attachment_image
					. '<div class="skyali_lt_attachment_options">'
			
					. '</div> <!-- .skyali_lt_attachment_options -->'
					. '<a href="#" class="skyali_delete_attachment">' . esc_html__('Delete Slide', 'vibration') . '</a>'
					. '<a href="#" class="skyali_change_attachment_image">' . esc_html__('Change Photo', 'vibration') . '</a>'
				. '</div>';
		}
		
		die();
	}

	add_action( 'wp_ajax_skyali_lt_convert_div_to_editor', 'skyali_lt_new_convert_div_to_editor' );
	function skyali_lt_new_convert_div_to_editor(){
		if ( ! wp_verify_nonce( $_POST['skyali_lt_load_nonce'], 'skyali_lt_load_nonce' ) ) die(-1);
		
		$index = (int) $_POST['skyali_index'];
		$option_slug = 'skyali_tab_text_' . $index;
		
		wp_editor( '', $option_slug, array( 'editor_class' => 'skyali_wp_editor' ) );
		
		die();
	}

	add_action( 'wp_ajax_skyali_add_tabs_item', 'skyali_new_add_tab_item' );
	function skyali_new_add_tab_item(){
		if ( ! wp_verify_nonce( $_POST['skyali_lt_load_nonce'], 'skyali_lt_load_nonce' ) ) die(-1);
		
		$skyali_tabs_length = (int) $_POST['skyali_tabs_length'];
		$option_slug = 'skyali_tab_text_' . $skyali_tabs_length;
		
		echo '<div class="skyali_tab">' 
				. '<p class="clearfix">' . '<label>' . esc_html__('Tab Title', 'vibration') . ': </label>' . '<input name="skyali_tab_title[]" class="skyali_tab_title" /> </p>';
				wp_editor( '', $option_slug, array( 'editor_class' => 'skyali_wp_editor' ) );
		echo 	'<a href="#" class="skyali_delete_tab">' . esc_html__('Delete this tab', 'vibration') . '</a>'
		. '</div>';
		
		die();
	}

	add_action( 'wp_ajax_skyali_add_slides_item', 'skyali_new_add_slide_item' );
	function skyali_new_add_slide_item(){
		if ( ! wp_verify_nonce( $_POST['skyali_lt_load_nonce'], 'skyali_lt_load_nonce' ) ) die(-1);
		
		$skyali_tabs_length = (int) $_POST['skyali_tabs_length'];
		$option_slug = 'skyali_slide_text_' . $skyali_tabs_length;
		
		echo '<div class="skyali_tab">';
				wp_editor( '', $option_slug, array( 'editor_class' => 'skyali_wp_editor' ) );
		echo 	'<a href="#" class="skyali_delete_tab">' . esc_html__('Delete this tab', 'vibration') . '</a>'
		. '</div>';
		
		die();
	}


	if ( ! function_exists('skyali_generate_module_options') ){
		function skyali_generate_module_options( $module_name, $module_window, $paste_to_editor_id, $skyali_lt_module_exact_name ){
			global $skyali_modules;
			
			$i = 1;
			$form_id = ( 0 == $module_window ) ? 'skyali_lt_module_settings' : 'skyali_dialog_settings';
			
			echo '<form id="' . esc_attr( $form_id ) . '">';
			echo '<span id="skyali_settings_title">' . esc_html( $skyali_lt_module_exact_name . ' ' . __('Settings', 'vibration') ) . '</span>';
			
			if ( 0 == $module_window ) echo '<a href="#" id="skyali_close_module_settings"></a>';
			else echo '<a href="#" id="skyali_close_dialog_settings"></a>';
			
			foreach ( $skyali_modules[$module_name]['options'] as $option_slug => $option_settings ){
				$content_class = isset( $option_settings['is_content'] ) && $option_settings['is_content'] ? ' skyali_module_content' : '';
				
				echo '<p class="clearfix">';
				if ( isset( $option_settings['title'] ) ) echo "<label><span class='skyali_lt_module_option_number'>{$i}</span>. {$option_settings['title']}</label>";
				
				if ( 1 == $module_window ) $option_slug = 'skyali_dialog_' . $option_slug;
				
				switch ( $option_settings['type'] ) {
					case 'wp_editor':
						wp_editor( '', $option_slug, array( 'editor_class' => 'skyali_wp_editor skyali_option' . $content_class ) );
						break;
					case 'select':
						$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						echo
						'<select name="' . esc_attr( $option_slug ) . '" id="' . esc_attr( $option_slug ) . '" class="skyali_option' . $content_class . '">'
							. ( ( '' == $std ) ? '<option value="nothing_selected">  ' . esc_html__('Select', 'vibration') . '  </option>' : '' );
							foreach ( $option_settings['options'] as $setting_value ){
								echo '<option value="' . esc_attr( $setting_value ) . '"' . selected( $setting_value, $std, false ) . '>' . esc_html( $setting_value ) . '</option>';
							}
						echo '</select>';
						break;
					case 'text':
						$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						echo '<input name="' . esc_attr( $option_slug ) . '" type="text" id="' . esc_attr( $option_slug ) . '" value="'.( '' != $std ? esc_attr( $std ) : '' ).'" class="regular-text skyali_option' . $content_class . '" />';
						break;
						break;
					case 'upload':
						echo '<input name="' . esc_attr( $option_slug ) . '" type="text" id="' . esc_attr( $option_slug ) . '" value="" class="regular-text skyali_option skyali_upload_field' . $content_class . '" />' . '<a href="#" class="skyali_upload_button">' . esc_html__('Upload', 'vibration') . '</a>';
						break;
					case 'slider_images':
						echo '<div id="skyali_lt_slider_images">' . '<div id="skyali_slides" class="skyali_option"></div>' . '<a href="#" id="skyali_add_slider_images">' . esc_html__('Add Slider Image', 'vibration') . '</a>' . '</div>';
						break;
					case 'tabs_interface':
						echo '<div id="skyali_tabs_interface">' . '<div id="skyali_tabs" class="skyali_option" data-elements="0"></div>' . '<a href="#" id="skyali_add_tab">' . esc_html__('Add New Tab', 'vibration') . '</a>' . '</div>';
						break;
					case 'slider_interface':
						echo '<div id="skyali_slides_interface">' . '<div id="skyali_tabs" class="skyali_option" data-elements="0"></div>' . '<a href="#" id="skyali_add_tab">' . esc_html__('Add New Slide', 'vibration') . '</a>' . '</div>';
						break;
				}
				
				echo '</p>';
				
				++$i;
			}
			
			submit_button();
			
			echo '<input type="hidden" id="skyali_saved_module_name" value="' . esc_attr( $module_name ) . '" />';
			
			if ( '' != $paste_to_editor_id ) echo '<input type="hidden" id="skyali_lt_paste_to_editor_id" value="' . esc_attr( $paste_to_editor_id ) . '" />';
			
			echo '</form>';
		}
	}

	if ( ! function_exists('skyali_get_attributes') ){
		function skyali_get_attributes( $atts, $additional_classes = '', $additional_styles = '' ){
			extract( shortcode_atts(array(
						'css_class' => '',
						'first_class' => '0',
						'width' => ''
					), $atts));
			$attributes = array( 'class' => '', 'inline_styles' => '' );
			
			if ( '' != $css_class ) $css_class = ' ' . $css_class;
			if ( '' != $additional_classes ) $additional_classes = ' ' . $additional_classes;
			$first_class = ( '1' == $first_class ) ? ' skyali_first' : '';
			$attributes['class'] = ' class="' . esc_attr( "skyali_module{$additional_classes}{$first_class}{$css_class}" ) . '"';
			
			if ( '' != $width ) $attributes['inline_styles'] .= " width: {$width}%;";
			$attributes['inline_styles'] .= $additional_styles;
			if ( '' != $attributes['inline_styles'] ) $attributes['inline_styles'] = ' style="' . esc_attr( $attributes['inline_styles'] ) . '"';
			
			return $attributes;
		}
	}

	if ( ! function_exists('skyali_fix_shortcodes') ){
		function skyali_fix_shortcodes($content){   
			$replace_tags_from_to = array (
				'<p>[' => '[', 
				']</p>' => ']', 
				']<br />' => ']'
			);

			return strtr( $content, $replace_tags_from_to );
		}
	}
	
add_action( 'skyali_lt_before_page_builder', 'skyali_disable_builder_option' );
function skyali_disable_builder_option(){
	$skyali_lt_builder_disable = get_post_meta( get_the_ID(), '_skyali_lt_disable_builder', true );
	
	wp_nonce_field( basename( __FILE__ ), 'skyali_lt_builder_settings_nonce' );

	echo '<p class="skyali_lt_builder_option" style="padding: 10px 0 0 6px; margin-bottom: -10px;">'
			. '<label for="skyali_lt_builder_disable" class="selectit">'
		. '</p>';
}

add_action( 'save_post', 'skyali_lt_builder_save_details', 10, 2 );
function skyali_lt_builder_save_details( $post_id, $post ){
	global $pagenow;

	if ( 'post.php' != $pagenow ) return $post_id;
		
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
	if ( ! isset( $_POST['skyali_lt_builder_settings_nonce'] ) || ! wp_verify_nonce( $_POST['skyali_lt_builder_settings_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	if ( isset( $_POST['skyali_lt_builder_disable'] ) )
		update_post_meta( $post_id, '_skyali_lt_disable_builder', 1 );
	else
		update_post_meta( $post_id, '_skyali_lt_disable_builder', 0 );
}
 
add_filter( 'the_content', 'skyali_lt_show_builder_layout' );
function skyali_lt_show_builder_layout( $content ){
	// Don't show the builder layout if the password is required
	if ( post_password_required( get_the_ID() ) ) return $content;
	
	// Don't show the builder layout if the post type is disabled in the plugin settings
	$skyali_main_settings = get_option( 'skyali_main_settings' );
	$post_types = isset( $skyali_main_settings['post_types'] ) ? (array) $skyali_main_settings['post_types'] : apply_filters( 'skyali_lt_builder_default_post_types', array( 'post', 'page','albums','gallery' ) );
	if ( ! in_array( get_post_type( get_the_ID() ), $post_types ) ) return $content;
	
	$builder_layout = get_post_meta( get_the_ID(), '_skyali_lt_builder_settings', true );
	$builder_disable = get_post_meta( get_the_ID(), '_skyali_lt_disable_builder', true );
	
	if ( ! is_singular() || ! $builder_layout || ! is_main_query() || 1 == $builder_disable ) return $content;
	
	$post_id =get_the_ID();
$post_object = get_page( $page_id );
	
	if ( $builder_layout && '' != $builder_layout['layout_shortcode'] ) $content = '<div class="skyali_lt_builder clearfix">'.do_shortcode($post_object->post_content).'' . do_shortcode( stripslashes( $builder_layout['layout_shortcode'] ) ) . '</div> <!-- .skyali_lt_builder -->';

	return $content;
}