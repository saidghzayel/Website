<?php
// create custom plugin settings menu
add_action('admin_menu', 'skyali_create_menu');

function skyali_create_menu() {

	//create new top-level menu
	add_theme_page('Theme Settings', 'Vibration Options', 'administrator', 'theme_settings', 'skyali_settings_page');

	//call register settings function
	if(!isset($_GET['event'])){
	add_action( 'admin_init', 'register_mysettings');
	}
	add_action('admin_init', 'skypanel_add_scripts');
	
}

function skypanel_add_scripts() {
	if(isset($_GET['page']) == 'theme_settings'){
	wp_enqueue_script('jquery');
	wp_enqueue_style("skypanel",  get_template_directory_uri()."/scripts/admin/css/style.css", false, "1.0", "all");	
	wp_enqueue_style("tipTip",  get_template_directory_uri()."/scripts/admin/css/tipTip.css", false, "1.0", "all");
	wp_enqueue_script("Sortable",  get_template_directory_uri()."/scripts/admin/js/jquery.sortable.js", false, "1.0", "all");
	wp_enqueue_script("tipTipJS",  get_template_directory_uri()."/scripts/admin/js/jquery.tipTip.js", false, "1.0", "all");
	wp_enqueue_script("ColorPicker",  get_template_directory_uri()."/scripts/admin/js/colorpicker.js", false, "1.0", "all");
	wp_enqueue_script("Tabify",  get_template_directory_uri()."/scripts/admin/js/jquery.tabify.js", false, "1.0", "all");
	wp_enqueue_script("Skyali Custom Js",  get_template_directory_uri()."/scripts/admin/js/custom.js", false, "1.0", "all");

	
	}
}



if(!isset($_GET['event'])){
	require_once('load_option_array.php');
	
	//get_template_part( 'scripts/admin/load_option_array', get_post_format() );
}


if(!isset($_GET['event'])){
function register_mysettings() {
	//register our settings
	global $options_array;
	global $prefixs;
		foreach($options_array as $opt){
			$opt_name = $opt[1];
			$opt_name = $prefixs.$opt_name;
			$opt_name = strtolower($opt_name);
			$opt_name = str_replace(' ', '_', $opt_name);
			if(isset($_POST[$opt_name])){
		register_setting('skyali-settings-group', ''.$opt_name.'');
		}
	}
}
}

function my_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
}

function my_admin_styles() {
wp_enqueue_style('thickbox');
}

if (isset($_GET['page']) && $_GET['page'] == 'theme_settings') {
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');

}


//$array = array('name'=>'id','name','subject','black'=>'id','name','subject');

/* Insert Mysql */

//if($_post['sqlimport_ll'] == 'true'){
global $wpdb;
//$wpdb->insert(''.$wpdb->options.'', 
$myarray = array( 
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_header_options'), 'option_value' => 'Logo on Left Menu on Right', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_footer_widget'), 'option_value' => 'Enabled', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_responsive_option'), 'option_value' => 'Enabled', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_copyright_option'), 'option_value' => 'Enabled', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_heading_font_family'), 'option_value' => 'Oswald', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_body_font_family'), 'option_value' => 'Helvetica Neue', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_top_menu_font_size'), 'option_value' => '16px', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_paragraph_font_size'), 'option_value' => '13px', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_paragraph_line-height'), 'option_value' => '2.0em', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_h1_font_size'), 'option_value' => '28px', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_h2_font_size'), 'option_value' => '24px', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_h3_font_size'), 'option_value' => '20px', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_h4_font_size'), 'option_value' => '16px', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_h5_font_size'), 'option_value' => '13px', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_h6_font_size'), 'option_value' => '10px', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_font_weight'), 'option_value' => '300', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_featured_area'), 'option_value' => 'Enabled', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_related_news'), 'option_value' => 'Enabled', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_comments_area'), 'option_value' => 'Enabled', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_album_icon_links_box'), 'option_value' => 'Enabled', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_about_author'), 'option_value' => 'Enabled', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_read_more'), 'option_value' => 'Read More', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_archive'), 'option_value' => 'Archive', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_comment'), 'option_value' => 'Comment', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_search_results'), 'option_value' => 'Search Results', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_contact_form_name'), 'option_value' => 'Name', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_contact_form_email'), 'option_value' => 'Email', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_contact_form_message'), 'option_value' => 'Message', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_contact_form_send_message'), 'option_value' => 'Send Message', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_contact_form_email_sent'), 'option_value' => 'Email Sent', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_posted_by'), 'option_value' => 'Posted by', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_leave_a_reply'), 'option_value' => 'Leave a reply', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_book_show'), 'option_value' => 'Book Show', 'autoload' => 'yes'),
array('option_id' => 'NULL','option_name' => array('name'=>'skypanel_vibration_right_footer_content'), 'option_value' => '© 2013 Vibration. All Rights Reserved.', 'autoload' => 'yes'),
);
//));
if(@$_GET['sqlimport_ll'] == 'true'){
foreach($myarray as $opt){
	$opt_id = $opt['option_id'];
	$opt_name =  $opt['option_name']['name'];
	$opt_value = $opt['option_value'];
	$wpdb->insert(''.$wpdb->options.'', 
array('option_id' => 'NULL','option_name' =>''.$opt_name.'', 'option_value' => ''.$opt_value.'', 'autoload' => 'yes'
	));
}
}


//echo ' <br /> LAST QUERY:'.$wpdb->last_query; displays last query from the wp_options table so you'll what happened last in the table

//$saved_options is all of the options from the demo saved and converted into arrays from the database sql using the export feature my phpadmin
$saved_options = array(
array('skypanel_vibration_header_options', 'Logo on Left Menu on Right'),
array('skypanel_vibration_footer_widget', 'Enabled'),
array('skypanel_vibration_responsive_option', 'Enabled'),
array('skypanel_vibration_heading_font_family', 'Oswald'),
array('skypanel_vibration_body_font_family', 'Helvetica Neue'),
array('skypanel_vibration_top_menu_font_size', '16px'),
array('skypanel_vibration_paragraph_font_size', '13px'),
array('skypanel_vibration_paragraph_line-height', '2.0em'),
array('skypanel_vibration_h1_font_size', '28px'),
array('skypanel_vibration_h2_font_size', '24px'),
array('skypanel_vibration_h3_font_size', '20px'),
array('skypanel_vibration_h4_font_size', '16px'),
array('skypanel_vibration_h5_font_size', '13px'),
array('skypanel_vibration_h6_font_size', '10px'),
array('skypanel_vibration_font_weight', '300'),
array('skypanel_vibration_featured_area', 'Enabled'),
array('skypanel_vibration_related_news', 'Enabled'),
array('skypanel_vibration_comments_area', 'Enabled'),
array('skypanel_vibration_album_icon_links_box', 'Enabled'),
array('skypanel_vibration_about_author', 'Enabled'),
array('skypanel_vibration_read_more', 'Read More'),
array('skypanel_vibration_archive', 'Archive'),
array('skypanel_vibration_comment', 'Comment'),
array('skypanel_vibration_search_results', 'Search Results'),
array('skypanel_vibration_contact_form_name', 'Name'),
array('skypanel_vibration_contact_form_email', 'Email'),
array('skypanel_vibration_contact_form_message', 'Message'),
array('skypanel_vibration_contact_form_send_message', 'Send Message'),
array('skypanel_vibration_contact_form_email_sent', 'Email Sent'),
array('skypanel_vibration_posted_by', 'Posted by'),
array('skypanel_vibration_leave_a_reply', 'Leave a reply'),
array('skypanel_vibration_right_footer_content', '&copy; 2013 Vibration. All Rights Reserved.'),
);



foreach ($saved_options as $display){
	//this will display the options in another array form so you can copy and paste the options above into the "import demo" array.
	/*echo '<br />';
	echo  "array('option_id' => 'NULL','option_name' => array('name'=>'$display[0]'), 'option_value' => '$display[1]', 'autoload' => 'yes'),";*/
}



function skyali_settings_page() {
?>

<?php
 //pages & sub pages 
$default_page = 'General';
$default_sub_page = 'Logo Design';
$main_page = @$_GET['main_page'];
$pages = array('General' => array('Logo Design', 'Top Header','Footer Options', 'Top Menu', 'Responsive'),  'Styling' => array('Theme Styling','Font','Custom Css'), 'Post Page' => array('Post Settings'), 'Miscellaneous' => array('Tracking Code','Translation','Custom Sidebars','Albums Boxes') );

?>

<?php if(get_option('skypanel_vibration_read_more') == ''){ ?>

<div class="no_demo_options_warning">

<p><?php _e('Demo options not imported, Please click "Import Demo Options". Or simply save your own options.'); ?></p>

</div>

<?php } ?>

<?php if(@$_GET['event'] == 'settings'){ ?>

<form method="get" action="<?php echo get_template_directory_uri(); ?>/scripts/admin/save_settings.php" id="skyali_form">

<?php } else {  ?>

<form method="post" action="options.php#tab-link" id="skyali_form">

<?php } ?>

<?php settings_fields( 'skyali-settings-group' ); ?> 

<!--<input type="submit" class="button-primary"  id="save_settings" value="Save Changes"/>-->

<div id="container">

<div id="header">

<img src="<?php echo get_template_directory_uri(); ?>/scripts/admin/css/images/skypanel.png" class="logo" />

<div class="header_right">

<img src="<?php echo get_template_directory_uri(); ?>/scripts/admin/css/images/support_docs_icon.png" class="icon" />


<a href="<?php echo get_template_directory_uri(); ?>/help/index.html" target="_blank"><?php _e('Need Help?','skyali'); ?></a>

<img src="<?php echo get_template_directory_uri(); ?>/scripts/admin/css/images/import.png" class="icon" />

<?php 

echo '<a href="'.$_SERVER['PHP_SELF'].'?page=theme_settings&sqlimport_ll=true">Import Demo Options</a>';

?>

<!-- <img src="<?php echo get_template_directory_uri(); ?>/scripts/admin/css/images/more_themes.png" class="icon" />

<a href="#"><?php _e('More Themes','skyali'); ?></a> -->

</div><!-- #header_right -->

</div><!-- #header -->

<div id="skypanel_navigation">

<ul>

<?php $pages_i = 1; ?>

<?php foreach($pages as $page){
	
	$key = array_search($page,$pages);
	
	if(@$_GET['main_page'] == $key){
	
	$active = 'class="active"';
	
	}
	else{
		$active = '';
	}
	
	if(empty($_GET['main_page'])){
		if($pages_i == 1){
		$active =  'class="active"';
		}
	}
	
	echo '<li><a href="?page=theme_settings&main_page='.$key.'&sub_page=logo_design" '.$active.'>'.$key.'</a></li>';
	
	$pages_i++;
} 

?>

</ul>

</div><!-- #navigation -->

<div id="content">

<?php if(empty($_GET['event'])){ ?>

<ul class="menu" id="menu">

<?php 

$sub_page_num = 1;

if($main_page != ''){
	$get_main_page = $main_page;
}
else{
	$get_main_page = $default_page;
} 

foreach ($pages[$get_main_page] as $sub_page){
	
	if($sub_page_num == 1){
		$first_link = ' class="first_link"';
		$first_li = ' class="active"';
	}else{
		$first_link = '';
		$first_li = '';
	}
	$sub_page_link = str_replace(' ', '_',$sub_page);
	$sub_page_link = strtolower($sub_page_link);
	echo '<li'.$first_li.'><a href="#'.$sub_page_link.'"'.$first_link.'>'.$sub_page.'</a></li>';
	
	$sub_page_num++;
	
}

?>

</ul>

<?php } ?>

<div id="inside">

<ol>

<?php 

if(@$_GET['event'] == 'settings'){
require_once('theme_settings.php');
}
else{
//include the theme options
require_once('theme_options.php');
}
?>

</ol>

</div><!-- #inside -->

<div id="save_footer_holder">

<div id="save_footer">

<input type="submit" value="" name="options_save" class="options_save" />

</div><!-- #save_footer -->

</div><!-- #save_footer_holder -->

</div><!-- #content -->

</div><!-- #container -->

</form>

<?php // file writing under here ?>

<?php } ?>