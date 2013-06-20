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


fclose($fh);

?>