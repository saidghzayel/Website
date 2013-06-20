<?php
/**
 * Plugin Name: skyali popular news
 * Plugin URI: http://londonthemes.com/index.php?themeforest=true
 * Description: A widget that allows you to display the most popular news in the sidebar.
 * Version: 1.0
 * Author: skyali
 * Author URI: http://londonthemes.com/index.php?themeforest=true
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'lt_sidebar_popular_news_widgets' );

function lt_sidebar_popular_news_widgets() {
	register_widget( 'lt_sidebar_popular_news_widget' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class lt_sidebar_popular_news_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function lt_sidebar_popular_news_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'lt_sidebar_popular_news_widget', 'description' => __('Display popular news in your sidebar.', 'skyali') );

		/* Widget control settings. */
		//$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'lt_300x250_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'lt_sidebar_popular_news_widget', __('LT - Popular News', 'skyali'), $widget_ops);
	}

	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
	    $title = apply_filters('widget_title', $instance['title'] );
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
		echo $before_title . $title . $after_title;
	   
	   
       ?>
       <?php
	   $i = 1;
	   $entries_display = $instance['entries_display'];
	   if(empty($entries_display)){ $entries_display = '5'; }
	   $display_category = $instance['display_category'];
       //show latest blog posts
        $latest_posts = new WP_Query();
        $latest_posts->query('caller_get_posts=1&showposts='.$entries_display.'&orderby=comment_count&cat='.$display_category.'');
		
        while ($latest_posts->have_posts()) : $latest_posts->the_post();
       ?>
       
       
    <div class="popular_news<?php if($i == $entries_display) { echo ' no_border_bottom no_padding_bottom'; }; ?>">
	
	<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
    


<?php $blogurl =  home_url(); //$image_url = str_replace($blogurl, '', $image_url); ?>

<?php if(has_post_thumbnail()): ?>

<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'popular-thumb'); ?>

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
     
    <div class="info">
    
  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  
  <span class="date"><?php the_time('F d, Y'); ?></span>
 
   </div><!-- #info -->

 
     <?php } ?>
    
  
    </div><!-- #latest_news -->
	  
	  <?php $i++; endwhile; ?>
       
	   <?php
		
		/* After widget (defined by themes). */
		echo $after_widget;
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

     <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'skyali'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" /></p>
		
  <p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><?php _e('How many entries to display?', 'skyali'); ?></label>
 <input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo $instance['entries_display']; ?>" style="width:100%;" /></p>
 
   <p><label for="<?php echo $this->get_field_id( 'display_category' ); ?>"><?php _e('Display Certain Categories? Place the category id and seperate with a comma (e.g. - 1, 22, 35)', 'skyali'); ?></label>
 <input type="text" id="<?php echo $this->get_field_id('display_category'); ?>" name="<?php echo $this->get_field_name('display_category'); ?>" value="<?php echo $instance['display_category']; ?>" style="width:100%;" /></p>
	<?php
	}
}

?>