<?php
 wp_reset_query();

/**
 * Plugin Name: Skyali Latest Shows
 * Plugin URI: http://londonthemes.com/index.php?themeforest=true
 * Description: A widget that allows you to display your latest shows.
 * Version: 1.0
 * Author: skyali
 * Author URI: http://londonthemes.com/index.php?themeforest=true
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'skyali_latest_shows_widgets' );

function skyali_latest_shows_widgets() {
	register_widget( 'skyali_latest_shows_widget' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class skyali_latest_shows_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function skyali_latest_shows_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'skyali_latest_shows_widget', 'description' => __('Display recent shows.', 'vibration') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'skyali_latest_shows_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'skyali_latest_shows_widget', __('Skyali - Latest Shows', 'vibration'), $widget_ops, $control_ops );
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
	   
	   $video_embed =@$instance['video_embed'];
	   
       ?>
       
      <div class="footer_latest_shows">
       <?php
	   $entries_display = @$instance['entries_display'];
	   if(empty($entries_display)){ $entries_display = '5'; }
	   $display_category = $instance['display_category'];
       //show latest blog posts
	   
        $latest_posts = new WP_Query();
        $latest_posts->query('ignore_sticky_posts=1&showposts='.$entries_display.'&orderby=date&shows_categories='.$display_category .'&post_type=shows');
        while ($latest_posts->have_posts()) : $latest_posts->the_post();
       ?>

      
   <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(@$post->ID), 'shows'); ?>
  
  <?php
  
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



?>
<?php echo $paged; ?>
<div class="latest_shows">

<div class="left">

<span class="show_date"><span class="day"><?php echo $skyali_show_day; ?></span><span class="month"><?php echo $skyali_show_month; ?></span></span><!-- show_date -->

<?php echo  $image_url; ?>

</div><!-- left -->

</div><!-- latest show -->



	  <?php endwhile; ?><?php wp_reset_query(); ?>
       </div><!--- footer_latest_shows -->
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

     <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'vibration'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" /></p>
		
  <p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><?php _e('How many entries to display?', 'vibrations'); ?></label>
 <input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo $instance['entries_display']; ?>" style="width:100%;" /></p>
 
   <p><label for="<?php echo $this->get_field_id( 'display_category' ); ?>"><?php _e('Display Certain Categories? Place the category id and seperate with a comma (e.g. - 1, 22, 35)', 'vibration'); ?></label>
 <input type="text" id="<?php echo $this->get_field_id('display_category'); ?>" name="<?php echo $this->get_field_name('display_category'); ?>" value="<?php echo $instance['display_category']; ?>" style="width:100%;" /></p>
	<?php
	}
}

?>