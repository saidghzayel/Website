<?php
/**
 * Plugin Name: Skyali Flickr Widget
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
add_action( 'widgets_init', 'lt_flickr_widgets' );

function lt_flickr_widgets() {
	register_widget( 'lt_flickr_widget' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class lt_flickr_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function lt_flickr_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'lt_flickr_widget', 'description' => __('Flickr Widget.', 'vibration') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'lt_flickr_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'lt_flickr_widget', __('Skyali - Flickr', 'vibration'), $widget_ops, $control_ops );
	}

	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( @$title )
			// disable title for ad echo $before_title . $title . $after_title;

		// Content goes here
?>
<?php
	$settings = get_option("widget_flickrwidget");
	$id = $settings['id'];
	$number = $settings['number'];
?>  <div class="column"><span class="heading"><h3><?php _e('Flickr Photostream','vibration'); ?></h3></span>
    <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>  </div><!-- #column -->



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

        <?php 
	$settings = get_option("widget_flickrwidget");

	// check if anything's been sent
	if (isset($_POST['update_flickr'])) {
		$settings['id'] = strip_tags(stripslashes($_POST['flickr_id']));
		$settings['number'] = strip_tags(stripslashes($_POST['flickr_number']));

		update_option("widget_flickrwidget",$settings);
	}

	echo '<p>
			<label for="flickr_id">Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):
			<input id="flickr_id" name="flickr_id" type="text" class="widefat" value="'.$settings['id'].'" /></label></p>';
	echo '<p>
			<label for="flickr_number">Number of photos:
			<input id="flickr_number" name="flickr_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
	echo '<input type="hidden" id="update_flickr" name="update_flickr" value="1" />';

?>
		
	<?php
	}
}

?>