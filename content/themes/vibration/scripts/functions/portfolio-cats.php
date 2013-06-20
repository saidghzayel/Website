<?php $prefix = 'skyali_';

$home_slider_style_box = array('id' => 'home-slider-style-meta-box','title' => 'Slider Options','page' => 'page','context' => 'side','priority' => 'high',
'fields' => array(
array('name' => 'Slider Style','id' => $prefix . 'home-slider-style','type' => 'category_drop'),
array('name' => 'Revolution Slider Alias','id' => $prefix . 'revolution-slider-alias','type' => 'category_drop2'),
array('name' => 'LayerSlider ID','id' => $prefix . 'layer-slider-id','type' => 'category_drop2')
) );

$page_background_color_box = array('id' => 'page-background-color-meta-box','title' => 'Page Background Color','page' => 'page','context' => 'normal','priority' => 'high','fields' => array(array('name' => 'Page Background Color',
'id' => $prefix . 'page-background-color','type' => 'category_drop') ) );

$page_heading_box = array('id' => 'page-heading-meta-box','title' => 'Page Heading','page' => 'page','context' => 'normal','priority' => 'high',
'fields' => array(
array('name' => 'Page Heading','id' => $prefix . 'page-heading','type' => 'category_drop'),

array('name' => 'Page Heading Option','id' => $prefix . 'page-heading-option','type' => 'category_drop2') 
) );

$page_background_image_box = array('id' => 'page-background-image-meta-box','title' => 'Page Background Image','page' => 'page','context' => 'normal','priority' => 'high','fields' => array(array('name' => '',
'id' => $prefix . 'page-background-image','type' => 'category_drop') ) );

$page_background_option_box = array('id' => 'page-background-option-meta-box','title' => 'Page Background Option','page' => 'page','context' => 'normal','priority' => 'high','fields' => array(array('name' => 'Page Background Option',
'id' => $prefix . 'page-background-option','type' => 'category_drop') ) );


add_action('admin_menu', 'add_sticky_box_page');

// Add meta box
function add_sticky_box_page() {
	global $home_slider_style_box;
	global $page_background_color_box;
	global $page_heading_box;
	global $page_background_image_box;
	global $page_background_option_box;
	add_meta_box($home_slider_style_box['id'], $home_slider_style_box['title'], 'home_slider_style_show_box', $home_slider_style_box['page'], $home_slider_style_box['context'], $home_slider_style_box['priority']);
	add_meta_box($page_background_color_box['id'],$page_background_color_box['title'], 'page_background_color_show_box', $page_background_color_box['page'], $page_background_color_box['context'], $page_background_color_box['priority']);
	add_meta_box($page_heading_box['id'],$page_heading_box['title'], 'page_headings_show_box', $page_heading_box['page'], $page_heading_box['context'], $page_heading_box['priority']);
add_meta_box($page_background_image_box['id'],$page_background_image_box['title'], 'page_background_image_show_box', $page_background_image_box['page'], $page_background_image_box['context'], $page_background_image_box['priority']);
add_meta_box($page_background_option_box['id'],$page_background_option_box['title'], 'page_background_option_show_box', $page_background_option_box['page'], $page_background_option_box['context'], $page_background_option_box['priority']);

}

// Callback function to show fields in meta box
function home_slider_style_show_box() {
	global $home_slider_style_box, $post;
// Use nonce for verification
	echo '<input type="hidden" name="page_template_category_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	foreach ($home_slider_style_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = $GLOBALS['post']->ID;
		$home_slider_option = get_post_meta($post->ID, 'skyali_home-slider-style', true);
		echo '<p>','<strong>', $field['name'], '</strong>','</p>';
		switch ($field['type']) {
			case 'category_drop':
			if($home_slider_option == 'revolution_slider') { $revolution_slider_option_select = ' selected="selected"';}
			if($home_slider_option == 'layer_slider') { $layer_slider_full_select = ' selected="selected"';}
			if($home_slider_option == 'no_slider') { $no_slider_select = ' selected="selected"';}
				echo '<select name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', '', $meta ? $meta : $field['std'], '">
				<option value="revolution_slider"'.$revolution_slider_option_select.'>Revolution Slider</option><option value="layer_slider"'.$layer_slider_full_select.'>LayerSlider</option><option value="no_slider"'.$no_slider_select.'>No Slider</option></select>';
				break;
				case 'category_drop2':
				echo '<input type="text" name="', @$field['id'], '" id="', @$field['id'], '" ', @$meta ? ' ' : '', ' value="', @$meta ? @$meta : @$field['std'], '" style="width:30%; height:30px; padding:3px 4px;" />';
				break;
		}
		echo '', '';
	}
	echo '';
}

// Callback function to show fields in meta box
function page_headings_show_box() {
	global $page_heading_box, $post;
// Use nonce for verification
	echo '<input type="hidden" name="page_template_category_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	foreach ($page_heading_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = $GLOBALS['post']->ID;
		$heading_o = get_post_meta($post->ID, 'skyali_page-heading-option', true);
		if($heading_o == 'disable') { $heading_selection = 'selected="selected"';}
		echo '<p>','<strong>', $field['name'], '</strong>','</p>';
		switch ($field['type']) {
		case 'category_drop':
		echo '<input type="text" name="', @$field['id'], '" id="', @$field['id'], '" ', @$meta ? ' ' : '', ' value="', @$meta ? @$meta : @$field['std'], '" style="width:30%; height:30px; padding:3px 4px;" />';
				break;
					case 'category_drop2':
			echo '<select  name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', '>
				<option value="enable">Enable</option> 
				<option value="disable" '.$heading_selection.'>Disable</option>
				</select>';
				break;
		}
		echo '', '';
	}
	echo '';
}



// Callback function to show fields in meta box
function page_background_color_show_box() {
	global $page_background_color_box, $post;
	
?><!-- In the head section of the page -->
<script>
<!--
function wopen(url, name, w, h)
{
// Fudge factors for window decoration space.
 // In my tests these work well on all platforms & browsers.
w += 32;
h += 96;
 var win = window.open(url,
  name, 
  'width=' + w + ', height=' + h + ', ' +
  'location=no, menubar=no, ' +
  'status=no, toolbar=no, scrollbars=no, resizable=no');
 win.resizeTo(w, h);
 win.focus();
}
// -->
</script><?php

// Use nonce for verification
	echo '<input type="hidden" name="page_template_category_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	foreach ($page_background_color_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = $GLOBALS['post']->ID;
		echo '<p>','<strong>', $field['name'], '</strong>','</p>';
		switch ($field['type']) {
			case 'category_drop':
				echo '<input type="text" name="', @$field['id'], '" id="', @$field['id'], '" ', @$meta ? ' ' : '', ' value="', @$meta ? @$meta : @$field['std'], '" style="width:30%; height:30px; padding:3px 4px;" /><p><a href="http://www.colorpicker.com/" target="popup"
 onClick="wopen(\'http://www.colorpicker.com/\', \'popup\', 640, 480); return false;">Color Picker</a> - Copy and paste code into box.</p>';
				break;
		}
		echo '', '';
	}
	echo '';
}

// Callback function to show fields in meta box
function page_background_image_show_box() {
	global $page_background_image_box, $post;
// Use nonce for verification
	echo '<input type="hidden" name="page_template_category_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	foreach ($page_background_image_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = $GLOBALS['post']->ID;
		echo '<p>','<strong>', $field['name'], '</strong>','</p>';
		switch ($field['type']) {
		case 'category_drop':
		echo '<input type="text" name="', @$field['id'], '" id="', @$field['id'], '" ', @$meta ? ' ' : '', ' value="', @$meta ? @$meta : @$field['std'], '" style="width:30%; height:30px; padding:3px 4px;" /><p><a href="http://www.patternify.com/" target="_blank">Pattern Generator</a> - Copy and paste Base64 Code or Background Image Url.</p>';
				break;
		}
		echo '', '';
	}
	echo '';
}

// Callback function to show fields in meta box
function page_background_option_show_box() {
	global $page_background_option_box, $post;
// Use nonce for verification
	echo '<input type="hidden" name="page_template_category_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	foreach ($page_background_option_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = $GLOBALS['post']->ID;
		$page_bg_option = get_post_meta($post->ID, 'skyali_page-background-option', true);
		echo '<p>','<strong>', $field['name'], '</strong>','</p>';
		switch ($field['type']) {
			case 'category_drop':
			if($page_bg_option == 'no-repeat') { $page_bg_oopt = ' selected="selected"';}
				echo '<select name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', '', $meta ? $meta : $field['std'], '">
				<option value="repeat">Repeat</option><option value="no-repeat"'.$page_bg_oopt.'>No Repeat</option></select>';
				break;
		}
		echo '', '';
	}
	echo '';
}




add_action('save_post', 'save_sticky_data_page');

// Save data from meta box
function save_sticky_data_page($post_id) {
	global $home_slider_style_box;
	global $page_heading_box;
	global $page_background_color_box;
	global $page_background_image_box;
	global $page_background_option_box;
	
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	foreach ($home_slider_style_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}//else if closer
	}//foreach closer
	
	
	foreach ($page_heading_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}//else if closer
	}//foreach closer
	

	foreach ($page_background_color_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}//else if closer
	}//foreach closer
	
	foreach ($page_background_image_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}//else if closer
	}//foreach closer
	
	foreach ($page_background_option_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}//else if closer
	}//foreach closer
	
} //function closer

?>