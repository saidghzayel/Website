<?php
/**
 * Plugin Name: Skyali Video Embed
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
add_action( 'widgets_init', 'lt_video_widgets' );

function lt_video_widgets() {
	register_widget( 'lt_video_widget' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class lt_video_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function lt_video_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'lt_video_widget', 'description' => __('Embed a video into the sidebar.', 'visionaire') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'lt_video_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'lt_video_widget', __('Skyali - Video Embed', 'visionaire'), $widget_ops, $control_ops );
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
       <?php printf( __('%1$s', 'visionaire'), $video_embed ); ?>
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
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'visionaire'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
        <?php $video_embed_c = stripslashes(htmlspecialchars($instance['video_embed'], ENT_QUOTES)); ?>
        <p>
          <label for="<?php echo $this->get_field_id( 'video_embed' ); ?>"><?php _e('Video Embed Code:', 'visionaire'); ?></label>
		<textarea style="height:200px;" class="widefat" id="<?php echo $this->get_field_id( 'video_embed' ); ?>" name="<?php echo $this->get_field_name( 'video_embed' ); ?>"><?php echo stripslashes(htmlspecialchars(( $instance['video_embed'] ), ENT_QUOTES)); ?></textarea>
        </p>
		
	<?php
	}
}

?>