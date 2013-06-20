<?php

//load theme options & create theme option array's
$directory = dirname( __FILE__ );

$myFile = $directory.'/options.txt';

$lines = count(file($myFile)); 

$fh = fopen($myFile, 'r');

$options_i = 1;

$array_id_count = 0;

$array_push_i = 0;

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
	
	$array_type = $id_array;
	
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

$option_types = array("enable/disable" => "Enable/Disable Button", "drop_menu" => "Drop Down Menu", "upload" => "Upload Field", "color_picker" => "Color Picker", "check_box_list" => "Check Box List", "textarea"=> "Texarea", "text_field" => "Text Field", "select_categories" => "Select Categories", "excludepages" => "Exclude Pages", "excludecategories" => "Exclude Categories", "category_drop_menu" => "Category Drop Menu");

$count_options = 1;

echo '<input type="hidden" name="redirect_url" value="'.get_bloginfo('url').'/wp-admin/themes.php?page=theme_settings&event=settings" />';

foreach($options_array as $v){
	
	$option_id = $v["0"];

	$option_name = $v[1];
	
	$option_type = $v["2"];
	
	$option_value = $v["3"];
	
	$option_info = $v["4"];
	
	$option_page = $v["5"];
	
	if($option_name != ''){ 
	
	echo '<li>';
	
	echo '<input type="hidden" name="option_id_'.$option_id.'" value="true" />';
	
	echo '<h3>'.$option_name.'</h3>';
	
	echo '<a href="#" id="'.$count_options.'" class="delete"><img src="'.get_template_directory_uri().'/scripts/admin/css/images/delete.png" class="delete_button" /></a>';
	
	echo '<div class="right_side_icons edit_icon"><img src="'.get_template_directory_uri().'/scripts/admin/css/images/edit.png" class="toggle_button"/></div>';
	
	echo '<div class="option_holder option_holder_toggle" style="display:none;">';
	
	//echo '<h5>'; _e('Option Name:'); echo '</h5>';
	
	//echo '<input type="hidden" name="option_id_'.$count_options.'" />';
	
	echo '<div class="new_option_item"><h6>Option Name:</h6><input type="text" value="'.$option_name.'" name="option_name_'.$count_options.'"></div><!-- #new_option_item -->';
	
	///echo '<h5>'; _e('Option Type:'); echo '</h5>';
	
	echo '<div class="new_option_item"><h6>Option Type:</h6><select name="select_'.$count_options.'">';
	
	foreach($option_types as $types){
		$key = array_search($types,$option_types);
		if($key == $option_type){ $select = 'selected="select"'; } else { $select = ''; }
		echo '<option value="'.$key.'" '.$select.'>'.$types.'</option>';
	}
	
	echo '</select></div><!-- #new_option_item -->';
	
	//echo '<h5>'; _e('Option Values:'); echo '</h5>';
	
	echo '<div class="new_option_item"><h6>Option Values:</h6><input type="text" value="'.$option_value.'" name="option_values_'.$count_options.'" /></div><!-- #new_option_item -->';
	
	//echo '<h5>'; _e('Option Information:'); echo '</h5>';
	
	echo '<div class="new_option_item"><h6>Option Info:</h6><textarea name="option_info_'.$count_options.'">'.$option_info.'</textarea></div><!-- #new_option_item -->';
	
	//echo '<h5>'; _e('Page:'); echo '</h5>';
	
	echo '<div class="new_option_item"><h6>Option Page:</h6>';
	
	echo '<select name="page_option_'.$count_options.'">';
	
	foreach($pages as $option_pages){
		
	foreach($option_pages as $current_option_page){
		
	$current_option_page_link = strtolower($current_option_page);
		
	$current_option_page_link = str_replace(' ', '_',$current_option_page_link);
		
	if($current_option_page_link == $option_page){
			
	$selected = ' selected="selected"';
			
	}else{
			
	$selected = '';
			
	}
		
	echo '<option value="'.$current_option_page_link.'"'.$selected.'>'.$current_option_page.'</option>';
	
	}
	
    }

	echo '</select>';
	
	echo '</div><!-- #new_option_item -->';
	
	echo '</div>';
	
	echo '</li>';
	}
	
	$count_options++;
}

/*print '<script type="text/javascript" language="javascript">   
        function createDiv()
        {
            var divTag = document.createElement("div");
          
            divTag.id = "div1";
             
            divTag.setAttribute("align","center");
             
            divTag.style.margin = "0px auto";
             
            divTag.className ="dynamicDiv";
             
            divTag.innerHTML = "This <b>HTML Div tag</b> is created using Javascript DOM dynamically.";

            /*document.body.appendChild(divTag);*/
			
			/*document.getElementById('content'); divTag.appendChild(divTag);
             
            var pTag = document.createElement("p");
             
            pTag.setAttribute("align","center");
            
            pTag.innerHTML = "This paragraph <b>HTML p tag</b> is added dynamically inside the div tag.";
             
            document.getElementById("div1").appendChild(pTag);
        }
 
    </script>';

echo ' <p align="center">
       <b>Click this button to Create and Append the Div content:</b>
       <input id="btn1" type="button" value="create div" onClick="createDiv();" />
    </p>  ';*/
	
	?>
   
<script type="text/javascript">

	var num =  <?php echo $option_id+1; ?>;
			function addStuff(){
				var i = document.createElement( 'div' ); 
				i.innerHTML = "<input type='hidden' name='option_id_"+num+"' value='true' /><h3>Option Name:</h3><input type='text' name='option_name_"+num+"' /><h3>Option Type</h3><select name='select_"+num+"'><?php foreach($option_types as $t){
		$k = array_search($t,$option_types);
		echo "<option value='".$k."'>".$t."</option>";
	}  ?></select><h3>Option Values</h3><input type='text' name='option_values_"+num+"' /><h3>Option Info</h3><textarea name='option_info_"+num+"'></textarea><h3>Option page</h3> <select name='page_option_"+num+"' /><?php
	foreach($pages as $option_pages){
		
	foreach($option_pages as $current_option_page){
		
		$current_option_page_link = strtolower($current_option_page);
		
		$current_option_page_link = str_replace(' ', '_',$current_option_page_link);
		
		echo '<option value=\''.$current_option_page_link.'\'>'.$current_option_page.'</option>';
	
	}
}

	echo '</select>';?>"; 
				var d = document.getElementById( 'mydiv' ); 
				d.appendChild( i );
				num++;
			}
</script>

<div id="mydiv">
</div>
<a onclick="addStuff()" class="add_button"></a>
    
    <?php

fclose($fh);

// Save Option Changes
/*
if(isset($_POST['options_save'])){
	
     
	
	$fo = fopen($myFile,'w') or die ("Can't open the file.");
	$count_edit = 1;
	foreach($options_array as $blank_var){
		if(!empty($_GET['option_id'])){
		$update_id = "theme_options_id_$count_edit\n";
		fwrite($fo, $update_id);
		$update_name = "theme_options_name_".$_GET['option_name_'.$count_edit.'']."\n";
		fwrite($fo, $update_name);
		$update_type = "theme_options_type_".$_GET['select_'.$count_edit.'']."\n";
		fwrite($fo, $update_type);
		$update_values = "theme_options_value_".$_GET['option_values_'.$count_edit.'']."\n";
		fwrite($fo, $update_values);
		$update_info =  "theme_options_info_".$_GET['option_info_'.$count_edit.'']."\n";
		fwrite($fo, $update_info);
		$update_page = "theme_options_page_".$_GET['page_option_'.$count_edit.'']."\n";
		fwrite($fo, $update_page);
		$count_edit++;
	}
}
	
	fclose($fo);
	
}*/
?>
