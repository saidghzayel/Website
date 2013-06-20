<?php
/**
 * Plugin Name: Skyali Social Icons
 * Plugin URI: http://londonthemes.com/index.php?themeforest=true
 * Description: A widget that allows you embed videos into the sidebar.
 * Version: 1.0
 * Author: Skyali
 * Author URI: http://londonthemes.com/index.php?themeforest=true
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'lt_social_icons' );

function lt_social_icons() {
	register_widget( 'lt_social_icons' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class lt_social_icons extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function lt_social_icons() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'lt_social_icons', 'description' => __('Link to your social networks', 'skyali') );

		/* Create the widget. */
		$this->WP_Widget( 'lt_social_icons', __('Skyali - Social Icons', 'skyali'), $widget_ops);
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
	   
	   $rss = $instance['rss'];
	   $vimeo = $instance['vimeo'];
	   $youtube = $instance['youtube'];
	   $facebook = $instance['facebook'];
	   $twitter = $instance['twitter'];
	   $linkedin = $instance['linkedin'];
	   $deviantart = $instance['deviantart'];
	   $flickr = $instance['flickr'];
	   $stumbledupon = $instance['stumbledupon'];
	   $pinterest = $instance['pinterest'];
	   $instagram = $instance['instagram'];
	   $weibo = $instance['weibo'];
	   $douban = $instance['douban'];
	   
	   
	

       ?>
 
<ul class="social_icons">

<?php if(!empty($rss)) { ?><li><a href="<?php echo $rss; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/rss-icon.png" width="25" height="25" alt="<?php _e('Rss Feed','vibration'); ?>" /><span><?php _e('Rss Feed','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($vimeo)) { ?><li><a href="<?php echo $vimeo; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/vimeo-icon.png" width="25" height="25" alt="<?php _e('Our Vimeo','vibration'); ?>" /><span><?php _e('Our Vimeo','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($youtube)) { ?><li><a href="<?php echo $youtube; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/youtube-icon.png" width="25" height="25" alt="<?php _e('Youtube Channel','vibration'); ?>" /><span><?php _e('Youtube Channel','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($facebook)) { ?><li><a href="<?php echo $facebook; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook-icon.png" width="25" height="25" alt="<?php _e('Facebook','vibration'); ?>" /><span><?php _e('Facebook','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($twitter)) { ?><li><a href="<?php echo $twitter; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter-icon.png" width="25" height="25" alt="<?php _e('Twitter','vibration'); ?>" /><span><?php _e('Twitter','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($linkedin)) { ?><li><a href="<?php echo $linkedin; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/linkedin-icon.png" width="25" height="25" alt="<?php _e('Linkedin','vibration'); ?>" /><span><?php _e('Linkedin','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($deviantart)) { ?><li><a href="<?php echo $deviantart; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/deviantart-icon.png" width="25" height="25" alt="<?php _e('Deviantart','vibration'); ?>" /><span><?php _e('Deviantart','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($flickr)) { ?><li><a href="<?php echo $flickr; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/flickr-icon.png" width="25" height="25" alt="<?php _e('Flickr','vibration'); ?>" /><span><?php _e('Flickr','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($stumbledupon)) { ?><li><a href="<?php echo $stumbledupon; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/stumbledupon-icon.png" width="25" height="25" alt="<?php _e('Stumbledupon','vibration'); ?>" /><span><?php _e('Stumbledupon','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($pinterest)) { ?><li><a href="<?php echo $pinterest; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/pinterest-icon.png" width="25" height="25" alt="<?php _e('Pinterest','vibration'); ?>" /><span><?php _e('Pinterest','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($instagram)) { ?><li><a href="<?php echo $instagram; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/instagram-icon.png" width="25" height="25" alt="<?php _e('Instagram','vibration'); ?>" /><span><?php _e('Instagram','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($weibo)) { ?><li><a href="<?php echo $weibo; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/weibo-icon.png" width="25" height="25" alt="<?php _e('Weibo','vibration'); ?>" /><span><?php _e('Weibo','vibration'); ?></span></a></li><?php } ?>

<?php if(!empty($douban)) { ?><li><a href="<?php echo $douban ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/douban-icon.png" width="25" height="25" alt="<?php _e('Douban','vibration'); ?>" /><span><?php _e('Douban','vibration'); ?></span></a></li><?php } ?>


</ul>

     
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


?>

     <p>
     
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'skyali'); ?></label>
       
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
   
    </p>
    
    <?php $video_embed_c = stripslashes(htmlspecialchars($instance['video_embed'], ENT_QUOTES)); ?>
    
    <p><label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php _e('Rss', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" value="<?php echo $instance['rss']; ?>" style="width:100%;" /></p>
   
    <p><label for="<?php echo $this->get_field_id( 'vimeo' ); ?>"><?php _e('Vimeo', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('vimeo'); ?>" name="<?php echo $this->get_field_name('vimeo'); ?>" value="<?php echo $instance['vimeo']; ?>" style="width:100%;" /></p>
   
    <p><label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e('Youtube', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo $instance['youtube']; ?>" style="width:100%;" /></p>
   
    <p><label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('Facebook', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo $instance['facebook']; ?>" style="width:100%;" /></p>
        
    <p><label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Twitter', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $instance['twitter']; ?>" style="width:100%;" /></p>
       
    <p><label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e('Linkedin', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" value="<?php echo $instance['linkedin']; ?>" style="width:100%;" /></p>
	  
    <p><label for="<?php echo $this->get_field_id( 'deviantart' ); ?>"><?php _e('Deviantart', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('deviantart'); ?>" name="<?php echo $this->get_field_name('deviantart'); ?>" value="<?php echo $instance['deviantart']; ?>" style="width:100%;" /></p>
	
    <p><label for="<?php echo $this->get_field_id( 'flickr' ); ?>"><?php _e('Flickr', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('flickr'); ?>" name="<?php echo $this->get_field_name('flickr'); ?>" value="<?php echo $instance['flickr']; ?>" style="width:100%;" /></p>
	
    <p><label for="<?php echo $this->get_field_id( 'stumbledupon' ); ?>"><?php _e('Stumbledupon', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('stumbledupon'); ?>" name="<?php echo $this->get_field_name('stumbledupon'); ?>" value="<?php echo $instance['stumbledupon']; ?>" style="width:100%;" /></p>
	
    <p><label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e('Pinterest', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" value="<?php echo $instance['pinterest']; ?>" style="width:100%;" /></p>
	
    <p><label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e('Instagram', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" value="<?php echo $instance['instagram']; ?>" style="width:100%;" /></p>
	
    <p><label for="<?php echo $this->get_field_id( 'weibo' ); ?>"><?php _e('Weibo', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('weibo'); ?>" name="<?php echo $this->get_field_name('weibo'); ?>" value="<?php echo $instance['weibo']; ?>" style="width:100%;" /></p>
	
    <p><label for="<?php echo $this->get_field_id( 'douban' ); ?>"><?php _e('Douban', 'skyali'); ?></label><input type="text" id="<?php echo $this->get_field_id('douban'); ?>" name="<?php echo $this->get_field_name('douban'); ?>" value="<?php echo $instance['douban']; ?>" style="width:100%;" /></p>
	
    
	<?php
	}
}

?>