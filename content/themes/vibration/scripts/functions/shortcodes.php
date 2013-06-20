<?php /*Short Code Functions */ ?>
<?php 


/*** Criteria ***/

function shortcode_criteria( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'name'       => '',
		'rating'    => '0%',
        ), $atts));

echo '<div class="criteria">'.$name.'';

echo'<div class="post_ratings_top"><div class="post_ratings_bottom_bg"><div class="rating_cover"></div><!-- rating_cover --><div class="post_ratings_bottom" style="width:'.$rating.'"></div><!-- post_ratings_bottom --></div><!-- post_ratings_bottom_bg --></div><!-- post_ratings -->';

echo '</div><!-- criteria -->';

}

add_shortcode('criteria', 'shortcode_criteria');

/*** Custom Button ***/

function shortcode_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'link'       => '#',
		'background'    => '',
		'link_color' => 'ffffff',
		'size'       => '13',
		'fontsize' => '14',
        ), $atts));
   return '<a href="'.$link.'" class="imgf shortcode_button" style="color:#'.$link_color.'; padding:'.$size.'px; font-size:'.$fontsize.'px; background-color:#'.$background.';">'.do_shortcode($content).'</a>';
}

add_shortcode('button', 'shortcode_button');



/*** Accordion ***/

function shortcode_accordions( $atts, $content = null ) {
    extract(shortcode_atts(array(
        ''      => '',
        ), $atts));
return '<ul class="gdl-accordion">'.do_shortcode($content).'</ul>';

}

add_shortcode('accordions', 'shortcode_accordions');

/*** Accordion Item ***/

function shortcode_accordion_item( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'title'      => 'Title Here',
        ), $atts));
		
return'<li class="gdl-divider">
<h2 class="accordion-head title-color gdl-title"><span class="accordion-head-image"></span>'.$title.'</h2>
<div class="accordion-content" style="display:none;">
<p>'.do_shortcode($content).'</p>
</div>

</li>';


}

add_shortcode('accordion_item', 'shortcode_accordion_item');

/*** Toggles ***/

function shortcode_toggles( $atts, $content = null ) {
    extract(shortcode_atts(array(
        ''      => '',
        ), $atts));
return '<ul class="gdl-toggle-box">'.do_shortcode($content).'</ul>';

}

add_shortcode('toggles', 'shortcode_toggles');

/*** Toggle Item ***/

function shortcode_toggle_item( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'title'      => 'Title Here',
        ), $atts));
		
return'<li class="gdl-divider">
<h2 class="toggle-box-head title-color gdl-title"><span class="accordion-head-image"></span>'.$title.'</h2>
<div class="toggle-box-content" style="display:none;">
<p>'.do_shortcode($content).'</p>
</div>

</li>';


}

add_shortcode('toggle_item', 'shortcode_toggle_item');

/*** Slideshow ***/

function shortcode_slideshow( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'width'      => '400',
        ), $atts));
		
return' <div class="rslides_container">
      <ul class="rslides" id="slider1">
'.do_shortcode($content).'</ul>
			</div><!-- rslides --> <script type="text/javascript">
jQuery(document).ready(function($) {
    $(function () {

      // Slideshow 1
      $("#slider1").responsiveSlides({
        auto: false,
        pager: true,
        nav: true,
        speed: 500,
        maxwidth: 960,
        namespace: "centered-btns"
      });
    });
	 });
  </script>
';
		


}


add_shortcode('slideshow', 'shortcode_slideshow');

/*** Toggle Item ***/

function shortcode_slideshow_item( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'url'      => '',
        ), $atts));
		
return'<li><img src="'.$url.'" alt=""></li>
';


}


add_shortcode('slideshow_item', 'shortcode_slideshow_item');


/*** One Half Shortcode ***/

function shortcode_onehalf($atts, $content = null){
	
	$no_margin = '';
	
	if (isset($atts[0]) && trim($atts[0]) == 'last')  $no_margin = ' no_margin_right';
	
	return '<div class="one_half '.$no_margin.'">'.do_shortcode($content).'</div>';
}

add_shortcode('one_half', 'shortcode_onehalf');

/*** One Third Shortcode ***/

function shortcode_onethird($atts, $content = null){
	
	$no_margin = '';
	
	if (isset($atts[0]) && trim($atts[0]) == 'last')  $no_margin = ' no_margin_right';
	
	return '<div class="one_third '.$no_margin.'">'.do_shortcode($content).'</div>';
}

add_shortcode('one_third', 'shortcode_onethird');

/*** One Fourth Shortcode ***/

function shortcode_onefourth($atts, $content = null){
	
	$no_margin = '';
	
	if (isset($atts[0]) && trim($atts[0]) == 'last')  $no_margin = ' no_margin_right';
	
	return '<div class="one_fourth '.$no_margin.'">'.do_shortcode($content).'</div>';
}

add_shortcode('one_fourth', 'shortcode_onefourth');

/*** Two Thirds Shortcode ***/

function shortcode_twothirds($atts, $content = null){
	
	$no_margin = '';
	
	if (isset($atts[0]) && trim($atts[0]) == 'last')  $no_margin = ' no_margin_right';
	
	return '<div class="two_thirds '.$no_margin.'">'.do_shortcode($content).'</div>';
}

add_shortcode('two_thirds', 'shortcode_twothirds');

/*** Three Fourths Shortcode ***/

function shortcode_threefourths($atts, $content = null){
	
	$no_margin = '';
	
	if (isset($atts[0]) && trim($atts[0]) == 'last')  $no_margin = ' no_margin_right';
	
	return '<div class="three_fourths '.$no_margin.'">'.do_shortcode($content).'</div>';
}

add_shortcode('three_fourths', 'shortcode_threefourths');



/*** Align Image Right ***/

function shortcode_right_image($atts, $content = null){
	extract(shortcode_atts(array(
	'link' => '#'), $atts));
	return '<a href="'.$link.'"><img src="'.do_shortcode($content).'" class="imgf image_border image_right" /></a>';
}

add_shortcode('right_image', 'shortcode_right_image');


/*** Align Image Left ***/

function shortcode_left_image($atts, $content = null){
	extract(shortcode_atts(array(
	'link' => '#'), $atts));
	return '<a href="'.$link.'"><img src="'.do_shortcode($content).'" class="imgf image_border image_left" /></a>';
}

add_shortcode('left_image', 'shortcode_left_image');


/*** Image Lightbox ***/

function shortcode_lightbox($atts, $content = null){
	extract(shortcode_atts(array(
	'url' => '#', 'title' => ''),
	 $atts));
	 if (!empty($title)){ $alt = 'alt="'.$title.'"';} else{ $alt = ''; }
	return '<a href="'.$url.'" id="fancybox1"><img src="'.do_shortcode($content).'" class="image_border imgf" '.$alt.' /></a>';
}

add_shortcode('lightbox', 'shortcode_lightbox');


/*** Info Box ***/
function shortcode_info($atts, $content = null){
	return '<div class="info_box boxes">'.do_shortcode($content).'</div>';
}

add_shortcode('info_box', 'shortcode_info');



/*** Warning Box ***/
function shortcode_warning($atts, $content = null){
	return '<div class="warning_box boxes">'.do_shortcode($content).'</div>';
}

add_shortcode('warning_box', 'shortcode_warning');

/*** Success Box ***/
function shortcode_success($atts, $content = null){
	return '<div class="success_box boxes">'.do_shortcode($content).'</div>';
}

add_shortcode('success_box', 'shortcode_success');

/*** Note Box ***/
function shortcode_note($atts, $content = null){
	return '<div class="note_box boxes">'.do_shortcode($content).'</div>';
}

add_shortcode('note_box', 'shortcode_note');

/*** Dropcap ***/

function shortcode_dropcap( $atts, $content = null ) {
   return '<span class="dropcap">' . do_shortcode($content) . '</span>';
}

add_shortcode('dropcap', 'shortcode_dropcap');



/*** Highlight ***/

function shortcode_highlight( $atts, $content = null ) {
   return '<span class="shortcode_highlight">' . do_shortcode($content) . '</span>';
}

add_shortcode('highlight', 'shortcode_highlight');


/**
Hook into WordPress
*/
 
add_action('init', 'mylink_button');

/**
Create Our Initialization Function
*/
 
function mylink_button() {
 
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
     return;
   }
 
   if ( get_user_option('rich_editing') == 'true' ) {
     add_filter( 'mce_external_plugins', 'add_plugin' );
     add_filter( 'mce_buttons_3', 'register_button' );
   }
 
}

/**
Register Button
*/
 
function register_button( $buttons ) {
 array_push( $buttons, "|","one_half","one_third","one_fourth","two_thirds","three_fourths","button","slideshow","accordions","accordion_item","toggles","toggle_item" );
 return $buttons;
}

/**
Register TinyMCE Plugin
*/
 
function add_plugin( $plugin_array ) {
	$plugin_array['one_half'] = get_template_directory_uri(). '/scripts/functions/mybuttons.js';
    $plugin_array['one_third'] = get_template_directory_uri(). '/scripts/functions/mybuttons.js';
	$plugin_array['one_fourth'] = get_template_directory_uri(). '/scripts/functions/mybuttons.js';
	$plugin_array['two_thirds'] = get_template_directory_uri(). '/scripts/functions/mybuttons.js';
	$plugin_array['three_fourths'] = get_template_directory_uri(). '/scripts/functions/mybuttons.js';
	$plugin_array['button'] = get_template_directory_uri(). '/scripts/functions/mybuttons.js';
	$plugin_array['slideshow'] = get_template_directory_uri(). '/scripts/functions/mybuttons.js';
	$plugin_array['accordions'] = get_template_directory_uri(). '/scripts/functions/mybuttons.js';
    $plugin_array['accordion_item'] = get_template_directory_uri(). '/scripts/functions/mybuttons.js';
	$plugin_array['toggles'] = get_template_directory_uri(). '/scripts/functions/mybuttons.js';
    $plugin_array['toggle_item'] = get_template_directory_uri(). '/scripts/functions/mybuttons.js';
   return $plugin_array;
}


?>