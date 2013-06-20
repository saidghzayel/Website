<?php 
$prefix = 'skyali_';


$background_option_box = array('id' => 'background-option-meta-box','title' => 'Background Option','page' => array('page','post','albums','shows','gallery','videos'),'context' => 'advanced','priority' => 'high','fields' => array(array('name' => 'Background Option',
'id' => $prefix . 'background_option','type' => 'categor_drop') ) );

add_action('admin_menu', 'add_sticky_box_background_option');

// Add meta box
function add_sticky_box_background_option() {
	global $background_option_box;
	add_meta_box($background_option_box['id'], $background_option_box['title'], 'background_option_show_box', $background_option_box['page'], $background_option_box['context'], $background_option_box['priority']);
}

// Callback function to show fields in meta box
function background_option_show_box() {
	global $background_option_box, $post;
	
	// Use nonce for verification
	echo '<input type="hidden" name="page_template_category_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '';

	foreach ($background_option_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = $GLOBALS['post']->ID;
		echo '<p>','<strong>', $field['name'], '</strong>','</p>';
		switch ($field['type']) {
			case 'categor_drop':
			echo '<select name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' ', $meta ? $meta : $field['std'], '"><option value="no-repeat">no-repeat</option><option value="repeat">repeat</option></select>';
				
				break;
		}
		echo '', '';
	}
	echo '';
}


add_action('save_post', 'save_sticky_data_background_option');

// Save data from meta box
function save_sticky_data_background_option($post_id) {
	global $background_option_box;
	
	// verify nonce
	if (!wp_verify_nonce($_POST['page_template_category_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}

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
	
	foreach ($background_option_box['fields'] as $field) {
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