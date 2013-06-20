<?php
/**
 * Plugin Name: Skyali Audio Player
 * Plugin URI: http://londonthemes.com/index.php?themeforest=true
 * Description: Audio player widget.
 * Version: 1.0
 * Author: Skyali
 * Author URI: http://londonthemes.com/index.php?themeforest=true
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'skyali_audio_player_widgets' );

function skyali_audio_player_widgets() {
	register_widget( 'skyali_audio_player_widget' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class skyali_audio_player_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function skyali_audio_player_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'skyali_audio_player_widget', 'description' => __('Audio Player for your widget areas', 'vibration') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'skyali_audio_player_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'skyali_audio_player_widget', __('Skyali - Audio Player', 'vibration'), $widget_ops, $control_ops );
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
	   
	   $mp3_file= $instance['mp3_file'];

       ?>
       <?php printf( __('%1$s', 'vibration'),'<iframe src="'.get_template_directory_uri().'/includes/audio_player.php?&audiofile='.$mp3_file.'" width="100%" height="45" frameborder="0" class="player_ifr"></iframe>' ); ?>
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
        <?php $mp3file_embed_c = stripslashes(htmlspecialchars($instance['mp3_file'], ENT_QUOTES)); ?>
        <p>
          <label for="<?php echo $this->get_field_id( 'mp3_file' ); ?>"><?php _e('Mp3 File:', 'vibration'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'mp3_file' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['mp3_file'] ), ENT_QUOTES)); ?>" name="<?php echo $this->get_field_name( 'mp3_file' ); ?>">
        </p>
		
	<?php
	}
}

?>