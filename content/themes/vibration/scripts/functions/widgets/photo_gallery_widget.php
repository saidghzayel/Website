<?php
/**
 * Plugin Name: Skyali Photo Gallery
 * Plugin URI: http://londonthemes.com/index.php?themeforest=true
 * Description: A widget that allows you to display images from your gallery.
 * Version: 1.0
 * Author: skyali
 * Author URI: http://londonthemes.com/index.php?themeforest=true
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'lt_sidebar_photo_gallery_widget' );

function lt_sidebar_photo_gallery_widget() {
	register_widget( 'lt_sidebar_photo_gallery_widget' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class lt_sidebar_photo_gallery_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function lt_sidebar_photo_gallery_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'lt_sidebar_photo_gallery_widget', 'description' => __('Display a photo gallery.', 'skyali') );

		/* Widget control settings. */
		//$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'lt_300x250_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'lt_sidebar_photo_gallery_widget', __('LT - Photo Gallery', 'skyali'), $widget_ops);
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
	   
	   $video_embed = $instance['video_embed'];
	   
       ?>
       <?php
	   $get_att_ids = $instance['attachment_ids'];
	   if(empty($entries_display)){ $entries_display = '10'; }
	   $display_category = $instance['display_category'];
	   $photo_gallery_cats = $instance['photo_gallery_cats'];
	   $photo_gallery_cats_implode = @implode(',',$photo_gallery_cats);
	   
       //show latest blog posts
        //$latest_posts = new WP_Query();
        //$latest_posts->query('caller_get_posts=1&showposts='.$entries_display.'&orderby=comment_count&cat='.$display_category.'');
		
        //while ($latest_posts->have_posts()) : $latest_posts->the_post();
       ?>

       <div id="photo_gallery">
	<div id="main_gallery_container">
		<div id="gallery_e">
			<div id="slides">
		       <?php  
		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'posts_per_page' => -1,
			'post_parent' => $post->ID,
			'include' =>''.$get_att_ids.'',
			'exclude'     => get_post_thumbnail_id()
		) );

		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				$class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
				$thumbimg =  wp_get_attachment_image_src($attachment->ID, 'photo-gallery-thumb');
				$thumbimg_l =  wp_get_attachment_image_src($attachment->ID, 'large');
				echo '<a href="'.$thumbimg_l[0].'" rel="fancybox2"><img src="' . $thumbimg[0] . '" /></a>';
			}
			
		
	}
?>
</div><!-- #slides -->
</div><!-- #gallery_e -->
</div><!-- #main_gallery_container -->
</div><!-- #photo_gallery -->
	  
	  <?php //endwhile; ?>
       
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
		
  <p><label for="<?php echo $this->get_field_id( 'attachment_ids' ); ?>"><?php _e('Attachment Post ID\'s', 'skyali'); ?></label>
 <input type="text" id="<?php echo $this->get_field_id('attachment_ids'); ?>" name="<?php echo $this->get_field_name('attachment_ids'); ?>" value="<?php echo $instance['attachment_ids']; ?>" style="width:100%;" />seperated with comma's</p>
 

 
	<?php
	}
}

?>