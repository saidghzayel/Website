<?php

//load theme options & create theme option array's
$directory = dirname( __FILE__ );

$myFile = $directory.'/options.txt';

$lines = count(file($myFile)); 

$fh = fopen($myFile, 'r');

$options_i = 1;

$array_id_count = 0;

$array_push_i = 0;

global $prefixs;

$options_array = array();

while($lines >= $options_i){
	
	$options_data = fgets($fh);
	
	$options_data = substr($options_data,0,-1);
	
	//create array's for option
	$array_list[$array_id_count] = array(); 
	
	$check_option_id =  strpos($options_data, "theme_options_id_");
	
	$check_option_name = strpos($options_data, "theme_options_name_");
	
	$check_option_type = strpos($options_data, "theme_options_type_");
	
	$check_option_value = strpos($options_data, "theme_options_value_");
	
	$check_option_info = strpos($options_data, "theme_options_info_");
	
	$check_option_page = strpos($options_data, "theme_options_page_");
	
	$array_type = @$id_array;
	
	//store the option id
	if($check_option_id !== false){
		 
	$options_data = str_replace("theme_options_id_", '', $options_data);
	
	array_push($array_list[$array_id_count],$options_data); 
	
	}
	
	//store the option name
	if($check_option_name !== false) { 
	
	$options_data = str_replace("theme_options_name_", '', $options_data); 
	
	array_push($array_list[$array_id_count-1],$options_data);
	
	}
	
	//store the option type
	if($check_option_type !== false) { 
	
	$options_data = str_replace("theme_options_type_", '', $options_data); 
	
	array_push($array_list[$array_id_count-1],$options_data);
	
	}
	
	//store the option value
	if($check_option_value !== false) { 
	
	$options_data = str_replace("theme_options_value_", '', $options_data); 
	
	array_push($array_list[$array_id_count-1],$options_data);
	
	}
	
	//store the option info
	if($check_option_info !== false) { 
	
	$options_data = str_replace("theme_options_info_", '', $options_data); 
	
	array_push($array_list[$array_id_count-1],$options_data);
	
	}
	
	//store the option page
	if($check_option_page !== false) { 
	
	$options_data = str_replace("theme_options_page_", '', $options_data); 
	
	array_push($array_list[$array_id_count-1],$options_data);
	
	}
		
	if($check_option_id !== false){
		
	$array_id_count++;

	}
	
	$options_i++;
}

//push the array into the options array

while($array_id_count > $array_push_i){
	
	array_push($options_array,$array_list[$array_push_i]);
	
	$array_push_i++;
}

//list out the theme optionse

$current_main_page = @$_GET['main_page'];

if(@$_GET['main_page'] == ''){
	$current_main_page = $default_page;
}

foreach($pages[$current_main_page] as $p){
	
	$current_sub_page = str_replace(' ', '_',$p);
	
	$current_sub_page = strtolower($current_sub_page);
	
	$display_none = ' style="display:none;"';
	
echo '<div id="'.$current_sub_page.'"'.$display_none.'>';

foreach($options_array as $v){
	
	$option_id = @$v["0"];

	$option_name = @$v[1];
	
	$option_name_input = $prefixs.$option_name;
	$option_name_input = strtolower($option_name_input);
	$option_name_input = str_replace(' ','_',$option_name_input);
	
	$get_option_value = get_option($option_name_input);
	
	$option_type = @$v["2"];
	
	$option_value = @$v["3"];
	
	$option_info = @$v["4"];
	
	$option_page = @$v["5"]; 
	
	if($current_sub_page == $option_page){
	
	echo '<li>';
	
	echo '<h3>'.$option_name.'</h3>';
	
	echo '<div class="option_holder">';
	
	switch($option_type){
		
	case "upload":
	
	//echo '<input type="text" class="input_type_text input_type_upload_text"><input type="button" class="upload_button">';
	
	echo '<input type="text" name="'.$option_name_input.'" id="'.$option_name_input.'" value="'.$get_option_value.'" class="upload input_type_text input_type_upload_text">';
    echo '<input id="upload_'.$option_name_input.'" class="upload_button" type="button" rel="5">';
    echo  '<div class="screenshot" id="'.$option_name_input.'_image">';
	if($get_option_value != ''){
	echo '<img src="'.$get_option_value.'" />';
	 echo '<div class="no_image"><a href="" class="remove">Remove</a></div>';
	}
	echo'</div>';
	
	break;
	
	case "drop_menu":
	
	echo '<select name="'.$option_name_input.'">';
	
	$select_options = explode(",",$option_value);
	
	foreach($select_options as $options){
		
		if($get_option_value == $options){
		$opt_select = ' selected="selected"';
		}
		else{
			$opt_select ='';
		}
		
	echo '<option value="'.$options.'"'.$opt_select.'>'.$options.'</option>';
	
	}
	
	echo '</select>';
	
	break;
	
	case "textarea":
	
	echo '<textarea class="options_textarea" name="'.$option_name_input.'">';
	
	echo $get_option_value;
	
	echo '</textarea>';
	
	break;
	
	case "enable/disable":
	
	//echo '<img src="'.get_template_directory_uri().'/scripts/admin/css/images/enable_button.png" class="enable_disable_button" />';
	
	if($get_option_value == 'Enabled'){
		$button_value = 'Enabled';
		$button_style = ' button_enabled';
	}
	else{
		$button_value = 'Disabled';
		$button_style = '';
	}
	
	echo '<input type="text" readonly="readonly" value="'.$button_value.'" class="enable_disable'.$button_style.'" name="'.$option_name_input.'" onclick="toggle(this); return false;" />';
	
	break;
	
	case "select_categories":
	
	$select_cat_options = explode(",",$option_value);
	
	echo '<div class="select_check_box_holder">';
	
	$categories = get_categories();
	
	$box_i = 1;
	
	foreach($categories as $value){
		
		if(@in_array($value->term_id,$get_option_value)){
			
		$kill_box = ' style="display:none;"';
		
		}
		
		else {
			$kill_box = '';
		}
		if($box_i == 1){
			
			echo '<ul id="sortable" class="sortable">';
			
		if(!empty($get_option_value)){
		foreach($get_option_value as $box){
			
			$box_name = get_cat_name($box);
			
			echo '<li>';
			
			echo '<div class="categories_check_box">';
			
			echo '<img src="'.get_template_directory_uri().'/scripts/admin/css/images/move.png" style="margin-top:10px; margin-right:6px; float:left;" />';
			
			echo '<input type="checkbox" checked="checked" name="'.$option_name_input.'[]" value="'.$box.'">';
			
			echo '<h6>'.$box_name.'</h6>';
			
			echo '</div>';
			
			echo '</li>';
		}
		
		echo '</ul>';
		
		}
		}
		
		$box_i++;
		
		echo '<div class="categories_check_box"'.$kill_box.'>';
			
		echo '<input type="checkbox" name="'.$option_name_input.'[]" value="'.$value->term_id.'">';
		
		echo '<h6>'.$value->name.'</h6>';
		
		echo '</div>';
		
	}
	
	echo '</div><!-- #select_check_box_holder -->';
	
	echo '<div class="selected_categories">';
	
	echo '<ul id="sortable">';
	
	//echo'<li><a href="#">Business</a></li>';
	
	
	
	echo'</ul>';
	
	echo '</div><!- select_categories-->';
	
	break;
	
	case "text_field":
	
	echo '<input type="text" name="'.$option_name_input.'" class="input_type_text text_input" value="'.$get_option_value.'" />';
	
	break;
	
	case "category_drop_menu":
	
	echo '<select name="'.$option_name_input.'">';
	
	echo '<option></option>';
	
	$get_cats = get_categories();
	
	foreach($get_cats as $cats){
		
		if(($cats->cat_ID == $get_option_value)){
			
		$select_cat = ' selected="selected"';
	
		}else{
			
			$select_cat = '';
			
		}
		echo '<option value="'.$cats->cat_ID.'"'.$select_cat.'>'.$cats->cat_name.'</option>';
	}
	
	echo '</select>';
	
	break;
	
	case"excludepages":
	
	$get_pages = get_pages(); 
	
	foreach($get_pages as $page){
		
		echo '<div class="categories_check_box" />';
		
		if(@in_array($page->ID,$get_option_value)){
		
		$check_box = ' checked="checked"';
		
		}
		
		else{
			$check_box = '';
		}
		echo '<input type="checkbox" name="'.$option_name_input.'[]" value="'.$page->ID.'"'.$check_box.' />';
		
		echo '<h6>'.$page->post_title.'</h6>';
		
		echo '</div>';
	
	}
	
	break;
	
	case"excludecategories":
	
	$get_categories = get_categories(); 
	
	foreach($get_categories as $category){
		
		echo '<div class="categories_check_box" />';
		
		if(@in_array($category->cat_ID,$get_option_value)){
		
		$check_boxes = ' checked="checked"';
		
		}
		
		else{
			$check_boxes = '';
		}
		echo '<input type="checkbox" name="'.$option_name_input.'[]" value="'.$category->cat_ID.'"'.$check_boxes.' />';
		
		echo '<h6>'.$category->cat_name.'</h6>';
		
		echo '</div>';
		
	}
	
	break;
	
	case "color_picker";
   
?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {  
    $('#<?php echo $option_name_input; ?>').ColorPicker({
    onSubmit: function(hsb, hex, rgb) {
    $('#<?php echo $option_name_input; ?>').val('#'+hex);
    },
    onBeforeShow: function () {
    $(this).ColorPickerSetColor(this.value);
    return false;
    },
    onChange: function (hsb, hex, rgb) {
    $('#cp_<?php echo $option_name_input; ?> div').css({'backgroundColor':'#'+hex, 'backgroundImage': 'none', 'borderColor':'#'+hex});
    $('#cp_<?php echo $option_name_input; ?>').prev('input').attr('value', '#'+hex);
    }
    })	
    .bind('keyup', function(){
    $(this).ColorPickerSetColor(this.value);
    });
    });
    </script>
    <input type="text" name="<?php echo $option_name_input; ?>" id="<?php echo $option_name_input; ?>" value="<?php echo $get_option_value; ?>" class="input_type_text text_input r_s_input"><?php $rgb = hex2rgb("".$get_option_value.""); $rgb_implode = implode(',', $rgb); ?>
    <div id="cp_<?php echo $option_name_input; ?>" class="color_box"><div style="background-color: rgb(<?php echo  $rgb_implode; ?>); background-image: none; border-top-color: rgb(<?php echo  $rgb_implode; ?>); border-right-color: rgb(<?php echo  $rgb_implode; ?>); border-bottom-color: rgb(<?php echo  $rgb_implode; ?>); border-left-color: rgb(<?php echo  $rgb_implode; ?>); "></div></div><!-- #cp_box -->
        
    <?php
	
	break;
	
	default:
	
	echo 'No type selected';
	
	break;
	}
	
	echo '</div><!-- option_holder -->';
	
	echo '<div class="info_holder">';
	
	if(!empty($option_info)){
	
	echo '<img src="'.get_template_directory_uri().'/scripts/admin/css/images/info.png" class="option_info" title="'.$option_info.'" />';
	
	}
	
	echo '</div><!-- #info_holder -->';
	
	echo '</li>';
}

}

echo '</div>';

}

fclose($fh);

?>