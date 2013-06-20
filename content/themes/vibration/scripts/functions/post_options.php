<?php 
$prefix = 'skyali_';

/* albums post meta */
$albums_amazon_link_box = array('id' => 'amazon-link-meta-box', 'title'=> ' Enter Amazon Link.', 'page' => 'albums', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'amazon_link', 'type' => 'field1', 'std' => '') ) );

$albums_itunes_link_box = array('id' => 'itunes-link-meta-box', 'title'=> ' Enter Itunes Link.', 'page' => 'albums', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'itunes_link', 'type' => 'field1', 'std' => '') ) );

$albums_buy_now_link_box = array('id' => 'buy-now-link-meta-box', 'title'=> ' Enter Buy Now Link.', 'page' => 'albums', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'buy_now_link', 'type' => 'field1', 'std' => '') ) );

$albums_description_box = array('id' => 'albums-description-meta-box', 'title'=> ' Album Description', 'page' => 'albums', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'albums_description', 'type' => 'field1', 'std' => '') ) );


/* shows post meta */
$show_month_box = array('id' => 'show-month-meta-box', 'title'=> ' Show Month.', 'page' => 'shows', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'show_month', 'type' => 'field1', 'std' => '') ) );

$show_day_box = array('id' => 'show-day-meta-box', 'title'=> ' Show Day.', 'page' => 'shows', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'show_day', 'type' => 'field1', 'std' => '') ) );

$show_year_box = array('id' => 'show-year-meta-box', 'title'=> ' Show Year.', 'page' => 'shows', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'show_year', 'type' => 'field1', 'std' => '') ) );

$show_time_box = array('id' => 'show-time-meta-box', 'title'=> ' Show Time.', 'page' => 'shows', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'show_time', 'type' => 'field1', 'std' => '') ) );

$show_location_box = array('id' => 'show-location-meta-box', 'title'=> ' Show Location.', 'page' => 'shows', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'show_location', 'type' => 'field1', 'std' => '') ) );

$google_map_embed_code_box = array('id' => 'google-map-embed-code-meta-box', 'title'=> ' Google Map Embed Code.', 'page' => 'shows', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'google_map_embed_code', 'type' => 'field1', 'std' => '') ) );

$ticket_link_box = array('id' => 'ticket-link-meta-box', 'title'=> ' Ticket Link.', 'page' => 'shows', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'ticket_link', 'type' => 'field1', 'std' => '') ) );

$show_status_box = array('id' => 'show-status-meta-box', 'title'=> ' Show Button Options', 'page' => 'shows', 'context' => 'normal', 'priority' => 'high', 'fields' => array(
array('name' => '', 'id'=> $prefix. 'show_status', 'type' => 'field1', 'std' => ''),
array('name' => '', 'id'=> $prefix. 'show_disable_button', 'type' => 'field2', 'std' => '')
 ) );


$show_image_link_box = array('id' => 'show-image-link-box', 'title'=> ' Show Image Link Option', 'page' => 'shows', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'show_image_link', 'type' => 'field1', 'std' => '') ) );


/* video post meta */
$video_url_box = array('id' => 'video-meta-box', 'title'=> ' Video Embed Url.', 'page' => 'videos', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'video-url', 'type' => 'field1', 'std' => '') ) );


//$blog_video_box = array('id' => 'blog-video-meta-box', 'title'=> ' Enter video embed code.', 'page' => 'post', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'blog_video', 'type' => 'field1', 'std' => '') ) );

//$blog_audio_box = array('id' => 'blog-audio-meta-box', 'title'=> 'Audio mp3 File.', 'page' => 'post', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'blog_audio', 'type' => 'field1', 'std' => '') ) );

//$blog_audio_ogg_box = array('id' => 'blog-audio-ogg-meta-box', 'title'=> ' Audio Ogg File.', 'page' => 'post', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'blog_audio_ogg', 'type' => 'field1', 'std' => '') ) );

//$blog_video_box = array('id' => 'blog-video-meta-box', 'title'=> ' Enter video embed code.', 'page' => 'post', 'context' => 'normal', 'priority' => 'core', 'fields' => array(array('name' => '', 'id'=> $prefix. 'blog_video', 'type' => 'field1', 'std' => '') ) );

//$blog_link_box = array('id' => 'blog-link-meta-box', 'title'=> 'Blog Link', 'page' => 'post', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'blog_link', 'type' => 'field1', 'std' => '') ) );

//$blog_post_type_box = array('id' => 'blog-post-type-meta-box', 'title'=> ' Select a blog post type.', 'page' => 'post', 'context' => 'normal', 'priority' => 'high', 'fields' => array(array('name' => '', 'id'=> $prefix. 'blog_post_type', 'type' => 'field1', 'std' => '') ) );

//$blog_quote_box = array('id' => 'blog-quote-meta-box', 'title'=> ' Quote', 'page' => 'post', 'context' => 'normal', 'priority' => 'core', 'fields' => array(array('name' => '', 'id'=> $prefix. 'blog_quote', 'type' => 'field1', 'std' => '') ) );


add_action('admin_menu', 'add_boxes');

// Add meta box
function add_boxes() {
	global $albums_amazon_link_box ;
	global $albums_itunes_link_box  ;
	global $albums_buy_now_link_box ;
	global $albums_description_box;
	global $show_month_box;
	global $show_day_box;
	global $show_year_box;
	global $show_time_box;
	global $show_location_box;
	global $google_map_embed_code_box;
	global $ticket_link_box ;
	global $show_status_box;
	global $video_url_box ; 
	global $show_image_link_box;
	/*global $blog_video_box;
	global $blog_link_box;
	global $blog_audio_box;
	global $blog_audio_ogg_box;
	global $blog_post_type_box;
	global $blog_quote_box;*/

add_meta_box($albums_amazon_link_box['id'], $albums_amazon_link_box['title'], 'albums_amazon_link_show_box', $albums_amazon_link_box['page'], $albums_amazon_link_box['context'], $albums_amazon_link_box['priority']);

add_meta_box($albums_itunes_link_box['id'], $albums_itunes_link_box['title'], 'albums_itunes_link_show_box', $albums_itunes_link_box['page'], $albums_itunes_link_box['context'], $albums_itunes_link_box['priority']);

add_meta_box($albums_buy_now_link_box['id'], $albums_buy_now_link_box['title'], 'albums_buy_now_link_show_box',$albums_buy_now_link_box['page'], $albums_buy_now_link_box['context'],$albums_buy_now_link_box['priority']);

add_meta_box($albums_description_box['id'], $albums_description_box['title'], 'albums_description_show_box',$albums_description_box['page'], $albums_description_box['context'],$albums_description_box['priority']);


add_meta_box($show_month_box['id'], $show_month_box['title'], 'show_month_show_box', $show_month_box['page'], $show_month_box['context'], $show_month_box['priority']);

add_meta_box($show_day_box['id'], $show_day_box['title'], 'show_day_show_box', $show_day_box['page'], $show_day_box['context'], $show_day_box['priority']);

add_meta_box($show_year_box['id'], $show_year_box['title'], 'show_year_show_box',$show_year_box['page'], $show_year_box['context'],$show_year_box['priority']);

add_meta_box($show_time_box['id'], $show_time_box['title'], 'show_time_show_box', $show_time_box['page'], $show_time_box['context'], $show_time_box['priority']);

add_meta_box($show_location_box['id'], $show_location_box['title'], 'show_location_show_box', $show_location_box['page'], $show_location_box['context'], $show_location_box['priority']);

add_meta_box($google_map_embed_code_box['id'], $google_map_embed_code_box['title'], 'google_map_embed_code_show_box',$google_map_embed_code_box['page'], $google_map_embed_code_box['context'],$google_map_embed_code_box['priority']);

add_meta_box($ticket_link_box['id'], $ticket_link_box['title'], 'ticket_link_show_box',$ticket_link_box['page'], $ticket_link_box['context'], $ticket_link_box['priority']);

add_meta_box($show_status_box['id'], $show_status_box['title'], 'show_status_show_box',$show_status_box['page'], $show_status_box['context'],$show_status_box['priority']);



add_meta_box($video_url_box['id'], $video_url_box['title'], 'video_show_box', $video_url_box['page'], $video_url_box['context'], $video_url_box['priority']);

add_meta_box($show_image_link_box['id'], $show_image_link_box['title'], 'image_link_show_box', $show_image_link_box['page'], $show_image_link_box['context'], $show_image_link_box['priority']);


/*add_meta_box($blog_review_box['id'], $blog_review_box['title'], 'blog_review_show_box', $blog_review_box['page'], $blog_review_box['context'], $blog_review_box['priority']);

add_meta_box($blog_video_box['id'], $blog_video_box['title'], 'blog_video_show_box', $blog_video_box['page'], $blog_video_box['context'], $blog_video_box['priority']);

add_meta_box($blog_link_box['id'], $blog_link_box['title'], 'blog_link_show_box', $blog_link_box['page'], $blog_link_box['context'], $blog_link_box['priority']);

add_meta_box($blog_audio_box['id'], $blog_audio_box['title'], 'blog_audio_show_box', $blog_audio_box['page'], $blog_audio_box['context'], $blog_audio_box['priority']);

add_meta_box($blog_audio_ogg_box['id'], $blog_audio_ogg_box['title'], 'blog_audio_ogg_show_box', $blog_audio_ogg_box['page'], $blog_audio_ogg_box['context'], $blog_audio_ogg_box['priority']);

add_meta_box($blog_post_type_box['id'], $blog_post_type_box['title'], 'blog_post_type_show_box',$blog_post_type_box['page'], $blog_post_type_box['context'], $blog_post_type_box['priority']);

add_meta_box($blog_quote_box['id'], $blog_quote_box['title'], 'blog_quote_show_box',$blog_quote_box['page'], $blog_quote_box['context'], $blog_quote_box['priority']);
*/
}



function image_link_show_box() {
	global $show_image_link_box, $post;
	
	// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($show_image_link_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		$related_portfolio_o = get_post_meta($post->ID, 'skyali_show_image_link', true);
		if($related_portfolio_o == 'disable') { $port_select = 'selected="selected"';}
		echo '<tr>','<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>','<td>';
		switch ($field['type']) {
			case 'field1': 
		echo '<strong>Image Link Option</strong><br /><select  name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', '>
				<option value="enable">Enabled</option> 
				<option value="disable" '.$port_select.'>Disable</option>
				</select><p>Disable if you do not want the show image to link to show post.</p>';
		break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}


function albums_description_show_box() {
	global $albums_description_box, $post;
	
	// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($albums_description_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<textarea style="width:100%; height:100%; font-size:11px;" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', '>', $meta ? $meta : $field['std'], '</textarea>';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}

function show_status_show_box() {
	global $show_status_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($show_status_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		$show_status_meta = get_post_meta($post->ID, 'skyali_show_status', true);
		if($show_status_meta == 'free') { $show_status_selection_free = 'selected="selected"';}
		if($show_status_meta == 'canceled') { $show_status_selection_canceled = 'selected="selected"';}
		if($show_status_meta == 'soldout') { $show_status_selection_sold_out = 'selected="selected"';}
		$related_portfolio_o = get_post_meta($post->ID, 'skyali_show_disable_button', true);
		if($related_portfolio_o == 'disable') { $port_select = 'selected="selected"';}
		$book_show_text = get_option('skypanel_vibration_book_show');
		if(empty($book_show_text)) { $book_show_text = ''.translate('Book Show','vibration').''; }
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			   echo '<strong>Button Text</strong><br /><select  name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', '>
			   <option value="">'.$book_show_text.'</option>
			    <option value="free" '.$show_status_selection_free.'>Free</option>
				<option value="canceled" '.$show_status_selection_canceled.'>Canceled</option> 
				<option value="soldout" '.$show_status_selection_sold_out.'>Sold Out</option>
				</select>';
				break;
		case 'field2': 
		echo '<strong>Button Option</strong><br /><select  name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', '>
				<option value="enable">Enabled</option> 
				<option value="disable" '.$port_select.'>Disable</option>
				</select>';
		break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}

function ticket_link_show_box() {
	global $ticket_link_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($ticket_link_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" /><strong></strong>';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}

function video_show_box() {
	global $video_url_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($video_url_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" /><strong>Example: http://www.youtube.com/embed/L9szn1QQfas?autoplay=1</strong>';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}

function show_time_show_box() {
	global $show_time_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($show_time_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" /><strong> Example: 09:30 PM - 11:30 PM</strong>';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}

function show_location_show_box() {
	global $show_location_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($show_location_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" /><strong> Example: Los Angeles, CA</strong>';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}


function google_map_embed_code_show_box() {
	global $google_map_embed_code_box, $post;
	
	// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($google_map_embed_code_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<textarea style="width:100%; height:100%; font-size:11px;" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', '>', $meta ? $meta : $field['std'], '</textarea>';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}


function show_month_show_box() {
	global $show_month_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($show_month_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" /><strong>Month\'s Name</strong>';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}


function show_day_show_box() {
	global $show_day_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($show_day_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" /><strong>Day Number</strong>';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}


function show_year_show_box() {
	global $show_year_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($show_year_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" />';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}


function albums_amazon_link_show_box() {
	global $albums_amazon_link_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($albums_amazon_link_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" />';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}



function albums_itunes_link_show_box() {
	global $albums_itunes_link_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($albums_itunes_link_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" />';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}


function albums_buy_now_link_show_box() {
	global $albums_buy_now_link_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($albums_buy_now_link_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" />';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}


/*function blog_audio_show_box() {
	global $blog_audio_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($blog_audio_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" />A mp3 file is required for the html5 audio player.';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}

function blog_link_show_box() {
	global $blog_link_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($blog_link_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" />';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}

function blog_audio_ogg_show_box() {
	global $blog_audio_ogg_box, $post;
	
		// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($blog_audio_ogg_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', ' value="', $meta ? $meta : $field['std'], '" style="width:100%; height:30px; padding:3px 4px;" />A ogg file is required for the html5 audio player. <a href="http://www.mirovideoconverter.com/" target="_blank">Help converting mp3 to ogg</a>';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}


function blog_quote_show_box() {
	global $blog_quote_box, $post;
	
	// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($blog_quote_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<textarea style="width:100%; height:100%; font-size:11px;" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', '>', $meta ? $meta : $field['std'], '</textarea>';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}

function blog_video_show_box() {
	global $blog_video_box, $post;
	
	// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($blog_video_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = htmlentities($_GET['post']);
		echo '<tr>','<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>','<td>';
		switch ($field['type']) {
			case 'field1':
			    echo '<textarea style="width:100%; height:100%; font-size:11px;" name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', '>', $meta ? $meta : $field['std'], '</textarea><p>Input your video embed code in this field.</p>';
				break;
		}
		echo '<td>', '</tr>';
	}
	echo '</table>';
}


// Callback function to show fields in meta box
function blog_post_type_show_box() {
	global $blog_post_type_box, $post;
// Use nonce for verification
	echo '<input type="hidden" name="sticky_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	foreach ($blog_post_type_box['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		$post_num = $GLOBALS['post']->ID;
		$blog_post_type_option = get_post_meta($post->ID, 'skyali_blog_post_type', true);
		echo '<p>','<strong>', $field['name'], '</strong>','</p>';
		switch ($field['type']) {
			case 'field1':
			
			$post_types = array('none','image','video','slideshow','audio','quote','link');
			
				echo '<select name="', $field['id'], '" id="', $field['id'], '" ', $meta ? ' ' : '', '', $meta ? $meta : $field['std'], '">';
				
				foreach($post_types as $post_type){
				
				if($blog_post_type_option == $post_type) { $selected = 'selected="selected"';} else {$selected='';}
				
				echo '<option value="'.$post_type.'"'.$selected.'>'.$post_type.'</option>';
			
			}
				echo '</select>';
				
				break;
		}
		echo '', '';
	}
	echo '';
}*/

add_action('save_post', 'save_meta_data');

// Save data from meta box
function save_meta_data($post_id) {
	global $albums_amazon_link_box;
	global $albums_itunes_link_box;
	global $albums_buy_now_link_box;
	global $albums_description_box;
	
	global $show_month_box  ;
	global $show_day_box   ;
	global $show_year_box   ;
	global $show_time_box;
	global $show_location_box;
	global $google_map_embed_code_box;
	global $ticket_link_box ;
	global $show_status_box;

    global $video_url_box;
	global $show_image_link_box; 
/*	global $blog_video_box;
	global $blog_quote_box;
	global $blog_link_box;
	global $blog_post_type_box;
	global $blog_audio_box;
	global $blog_audio_ogg_box;*/
	
	// verify nonce
	if (!wp_verify_nonce(@$_POST['sticky_meta_box_nonce'], basename(__FILE__))) {
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
	
	
	foreach ($show_image_link_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	foreach ($ticket_link_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
	
	foreach ($albums_description_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
	
	foreach ($show_status_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
	
		foreach ($video_url_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
	
	foreach ($show_time_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
	foreach ($show_location_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
	foreach ($google_map_embed_code_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
	
	foreach ($show_month_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
	foreach ($show_day_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
	
	foreach ($show_year_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer	
	
	foreach ($albums_buy_now_link_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
	foreach ($albums_itunes_link_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
foreach ($albums_amazon_link_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
	
/*	foreach ($blog_quote_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	

	foreach ($blog_video_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer 
	
		foreach ($blog_link_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer 
	
	
	
	foreach ($blog_audio_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer	
	
	foreach ($blog_audio_ogg_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer
	
		foreach ($blog_post_type_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = @$_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'],  stripslashes(htmlspecialchars($new)));
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			
		}//else if closer
		
	}//foreach closer */
	
} //function closer

?>