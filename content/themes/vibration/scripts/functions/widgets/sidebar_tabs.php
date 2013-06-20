<?php
/**
 * Plugin Name: Skyali Tabs Widget
 * Plugin URI: http://londonthemes.com/index.php?themeforest=true
 * Description: A widget that allows display flickr images.
 * Version: 1.0
 * Author: skyali
 * Author URI: http://londonthemes.com/index.php?themeforest=true
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'lt_tabs_widgets' );

function lt_tabs_widgets() {
	register_widget( 'lt_tabs_widget' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class lt_tabs_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function lt_tabs_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'lt_tabs_widget', 'description' => __('Sidebar Tabs Widget', 'londonpress') );

		/* Widget control settings. */
		//$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'lt_tabs_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'lt_tabs_widget', __('LT - Sidebar Tabs', 'londonpress'), $widget_ops );
	}

	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );
	    /*$title = apply_filters('widget_title', $instance['title'] );*/
		/* Before widget (defined by themes). */
		/*echo $before_widget;*/

		/* Display the widget title if one was input (before and after defined by themes). */
		/*if ( $title )*/
		/*echo $before_title . $title . $after_title;*/

?>

<?php wp_reset_query(); ?>

<div id="example-one">

<ul class="nav">

<li class="nav-one">

<?php $tab_nav_i = 1; ?>

<?php foreach ($instance['tab_categories'] as $tab_nav) { ?>

<?php $tab_cat_name = get_cat_name($tab_nav); ?>

<?php $tab_cat_name_tab = strtolower( get_cat_name($tab_nav)) ?>

<?php if($tab_nav_i == 1){ $select_nav = ' class="current"'; }  else { $select_nav = ''; }?>

<?php if($tab_nav_i == 1){ $nav1 = ' class="nav-one"'; }  else { $nav1 = ''; }?>

<?php $tab_cat_name_tab = str_replace(' ','-',$tab_cat_name_tab); ?>

<li class="<?php echo $nav1; ?>"><a href="#<?php echo $tab_cat_name_tab; ?>"<?php echo $select_nav; ?>><?php echo $tab_cat_name; ?></a></li>

<?php $tab_nav_i++; ?>

<?php } ?>

</ul>

<div class="list-wrap">

<?php $tab_div_i = 1; ?>

<?php foreach ($instance['tab_categories'] as $cat_div) { ?>

<?php if($tab_div_i != 1){ $hide_div = ' hide'; } else { $hide_div = ''; } ?>

<?php $tab_cat_div_name = strtolower(get_cat_name($cat_div)); ?>

<?php $tab_cat_div_name = str_replace(' ', '-', $tab_cat_div_name); ?>

<ul id="<?php echo $tab_cat_div_name; ?>" class="content_area<?php echo $hide_div; ?>">

<?php 

//show most popular blog posts

$show_post = 3;

$tab_num = 0;

$popular_posts = new WP_Query();

$popular_posts->query('showposts='.$show_post.'&orderby=comment_count&cat='.$cat_div.'');

while ($popular_posts->have_posts()) : $popular_posts->the_post();

?>

<div class="tabs-post">

<?php if(has_post_thumbnail()): ?>

<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(@$post->ID), 'tabs-thumb'); ?>

<div class="image_container">

<div class="img_hover">

<?php $blog_post_type =  get_post_meta(get_the_ID(), 'skyali_blog_post_type', true); ?>

<?php $post_type_img = 'link_post_type.png'; ?>

<?php $blog_post_types = array('video','slideshow','audio','quote'); ?> 

<?php 

foreach ($blog_post_types as $p_type){
	
  if($blog_post_type == $p_type) {
	  
	  $post_type_img = ''.$p_type.'_post_type.png';
	  
  }
    
} 

?>

<a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $post_type_img; ?>" /></a>

</div><!-- img_hover -->

<a href="<?php the_permalink(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>

</div><!-- image_container -->

<?php endif; ?>

<div class="content">

<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

<?php $overall_rating =  get_post_meta(get_the_ID(), 'skyali_blog_overall_rating', true); ?>

<?php if(!empty($overall_rating) AND $overall_rating != 'none') { ?><?php if($overall_rating != '' AND $overall_rating != 'none'){ ?>

<div class="post_ratings_top"><div class="post_ratings_bottom_bg"><div class="rating_cover"></div><!-- rating_cover --><div class="post_ratings_bottom" style="width:<?php echo $overall_rating; ?>;"></div><!-- post_ratings_bottom --></div><!-- post_ratings_bottom_bg --></div><!-- post_ratings -->

<?php } ?><?php } else { echo '<span class="date">'.get_the_time('F d, Y').'</span>'; }  ?>
 
</div><!-- #content closer -->

</div><!-- #tabs post -->

<?php $tab_num++; ?>

<?php endwhile; ?>

<?php wp_reset_query(); ?>

</ul>

<?php $tab_div_i++ ; ?>

<?php } ?>
 </div> <!-- END List Wrap -->
         
         </div> <!-- END Organic Tabs (Example One) -->



<?php	
		/* After widget (defined by themes). */
		/*echo $after_widget;*/
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		//$defaults = array( 'title' => __('Example', 'example'), 'name' => __('John Doe', 'example'), 'sex' => 'male', 'show_sex' => true );
		//$instance = wp_parse_args( (array) $instance, $defaults ); ?>
<?php $args =
array(

'order' => 'desc'
); 
 ?>
<?php $categories = get_categories($args); ?>

	<p><?php $categories=  get_categories($args);
foreach ($categories as $cat) {
	$option='<p><input type="checkbox" id="'. $this->get_field_id( 'tab_categories' ) .'[]" name="'.$this->get_field_name('tab_categories').'[]"';
					if (is_array($instance['tab_categories'])) {
					foreach ($instance['tab_categories'] as $cats) {
					if($cats==$cat->term_id) {
					$option=$option.' checked="checked"';
					}
					}
					}
					$option .= ' value="'.$cat->term_id.'" />';
					$option .= ' &nbsp;'; 
                    $option .= $cat->cat_name;
                    $option .= ' ('.$cat->category_count.')';
                    $option .= '<br /></p>';
                    echo $option;
                  }?>
		
	<?php	
	}
	}
?>