<?php 

$prefix = 'skyali_';


$custom_sidebar_box = array('id' => 'custom-sidebar-meta-box','title' => 'Custom Sidebar','page' => 'page','context' => 'side','priority' => 'high','fields' => array(array('name' => 'Custom Sidebar',
'id' => $prefix . 'custom-sidebar','type' => 'category_drop') ) );

add_action('admin_menu', 'add_custom_sidebar');

// Add meta box
function add_custom_sidebar() {
	global $custom_sidebar_box;
	add_meta_box($custom_sidebar_box['id'], $custom_sidebar_box['title'], 'custom_sidebar_show_box', $custom_sidebar_box['page'], $custom_sidebar_box['context'], $custom_sidebar_box['priority']);
}

// Callback function to show fields in meta box
function custom_sidebar_show_box() {
	global $custom_sidebar_box, $post;
	
	// Use nonce for verification
	echo '<input type="hidden" name="custom_sidebar_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '';

	foreach ($custom_sidebar_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = $GLOBALS['post']->ID;
		echo '<p>','<strong>', $field['name'], '</strong>','</p>';
		switch ($field['type']) {
			case 'category_drop':
				$custom_sidebars = get_option('skypanel_vibration_number_of_custom_sidebars');
				echo '<select name="', $field['id'], '" id="', $field['id'], '" style="clear:both;">';
				echo '<option value="">None</option>';
				$custom_i = 1;
				while($custom_i <= $custom_sidebars){
				if($meta ==  'custom-sidebar-'.$custom_i.'-widget-area') { $selected = 'selected="selected" '; } else { $selected = '';  };
				echo '<option value="custom-sidebar-'.$custom_i.'-widget-area" '.$selected.'>Custom Sidebar '.$custom_i.'</option>';
				$custom_i++;
				}
				echo '</select>';
				break;
		}
		echo '', '';
	}
	echo '';
}


add_action('save_post', 'save_sticky_data_custom_sidebar');

// Save data from meta box
function save_sticky_data_custom_sidebar($post_id) {
	global $custom_sidebar_box;
	
	// verify nonce
	if (!wp_verify_nonce($_POST['custom_sidebar_meta_box_nonce'], basename(__FILE__))) {
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
	
	foreach ($custom_sidebar_box['fields'] as $field) {
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