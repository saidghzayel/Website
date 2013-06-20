<?php
/**
 * Plugin Name: Skyali SoundCloud
 * Plugin URI: http://londonthemes.com/index.php?themeforest=true
 * Description: A widget that allows you embed soundcloud into the widgets area
 * Version: 1.0
 * Author: Skyali
 * Author URI: http://londonthemes.com/index.php?themeforest=true
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'skyali_sound_cloud_widgets' );

function skyali_sound_cloud_widgets() {
	register_widget( 'skyali_sound_cloud_widget' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class skyali_sound_cloud_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function skyali_sound_cloud_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'skyali_sound_cloud_widget', 'description' => __('Embed a soundcloud into any widget area.', 'vibration') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'skyali_sound_cloud_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'skyali_sound_cloud_widget', __('Skyali - Soundcloud', 'vibration'), $widget_ops, $control_ops );
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
	   
	   $api_code = $instance['api_code'];

       ?>
       <?php printf( __('%1$s', 'vibration'),'<iframe width="100%" height="166" scrolling="no" frameborder="no" src="http://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F'.$api_code.'&show_artwork=true"></iframe>
    ' ); ?>
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

        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'vibration'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
        <?php $video_embed_c = stripslashes(htmlspecialchars($instance['video_embed'], ENT_QUOTES)); ?>
        <p>
          <label for="<?php echo $this->get_field_id( 'api_code' ); ?>"><?php _e('Api Code:', 'vibration'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'api_code' ); ?>" name="<?php echo $this->get_field_name( 'api_code' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['api_code'] ), ENT_QUOTES)); ?>">
        <p>Example:http://api.soundcloud.com/tracks/<strong>85882104</strong></p>
        </p>
		
	<?php
	}
}

?>