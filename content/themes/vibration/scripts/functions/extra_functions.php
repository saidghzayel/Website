<?php

//*** PHP FUNCTION INCLUDES ***//
require_once('admin_panel_functions.php');
require_once('display_functions.php'); //all the display options for disable, exclude, etc...
require_once('widget_functions.php');// all of our widget function
require_once('post_options.php');
require_once('shortcodes.php'); //shortcodes
require_once('custom_sidebar_options.php'); // sticky option, featured and slider option in the post/edit page.
require_once('portfolio-cats.php'); //portfolio cats
require_once('custom.php'); //custom scripts
require_once('custom_post_types.php'); //custom post types
require_once('page_builder/skyali-page-builder.php');

//** EXTRA FUNCTIONS **//


function limit_words($string, $word_limit)
{
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
	
}

function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
 
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}



function skyali_load_scripts(){
	if (!is_admin()) {
    wp_enqueue_script( 'jquery' );
	
	wp_register_script('custom', ''.get_template_directory_uri().'/scripts/js/custom.js', 'jquery', '', true);
	wp_enqueue_script('custom');
		
	wp_register_script('audio-js', ''.get_template_directory_uri().'/scripts/js/audio.min.js', 'jquery', '', true);
	wp_enqueue_script('audio-js');
	
		wp_register_script('eventcountdown', ''.get_template_directory_uri().'/scripts/js/eventcountdown.js');
	wp_enqueue_script('eventcountdown');
	
	wp_register_script('responsiveslides', ''.get_template_directory_uri().'/scripts/js/responsiveslides.min.js', 'jquery', '', true);
	wp_enqueue_script('responsiveslides');
		
	wp_register_script('organictabs', ''.get_template_directory_uri().'/scripts/js/organictabs.jquery.js', 'jquery', '', true);
	wp_enqueue_script('organictabs');		
	
	wp_register_script('superfish', ''.get_template_directory_uri().'/scripts/js/superfish.js', 'jquery', '', true);
	wp_enqueue_script('superfish');		
	
	wp_register_script('fancybox', ''.get_template_directory_uri().'/scripts/fancybox/jquery.fancybox-1.3.4.pack.js', 'jquery');
	wp_enqueue_script('fancybox');
	
	/* Add The Css */
	
	
	wp_register_style('main', ''.get_stylesheet_directory_uri().'/style.css');
	wp_enqueue_style('main');
	
	wp_register_style('responsiveslides', ''.get_template_directory_uri().'/scripts/css/responsiveslides.css');
	wp_enqueue_style('responsiveslides');
	
	wp_register_style('tabs', ''.get_template_directory_uri().'/scripts/css/tabs.css');
	wp_enqueue_style('tabs');
	
	wp_register_style('responsiveslides-theme', ''.get_template_directory_uri().'/scripts/css/themes.css');
	wp_enqueue_style('responsiveslides-theme');
	
	wp_register_style('fancybox-css', ''.get_template_directory_uri().'/scripts/fancybox/jquery.fancybox-1.3.4.css');
	wp_enqueue_style('fancybox-css');
	
	
	wp_register_style('top menu', ''.get_template_directory_uri().'/scripts/css/top_menu.css');
	wp_enqueue_style('top menu');
	
	wp_register_style('buddypress', ''.get_template_directory_uri().'/scripts/css/buddypress.css');
	wp_enqueue_style('buddypress');
	
	wp_register_style('woocommerce', ''.get_template_directory_uri().'/scripts/css/woocommerce.css');
	wp_enqueue_style('woocommerce');
	
	
	if(get_option('skypanel_vibration_responsive_option') != 'Disabled'){
	wp_register_style('responsive', ''.get_template_directory_uri().'/scripts/css/responsive.css');
	wp_enqueue_style('responsive');
	}
	
		//Skin style option bright or dark
	if(get_option('skypanel_vibration_skin_style') == 'Bright')
	{ 
	wp_register_style('bright-skin', ''.get_template_directory_uri().'/scripts/css/bright-template.css');
	wp_enqueue_style('bright-skin');
	}

	if(get_option('skypanel_vibration_heading_font_family') != ''){ 
	wp_register_style('heading-custom-font', 'http://fonts.googleapis.com/css?family='.get_option('skypanel_vibration_heading_font_family').'');
	wp_enqueue_style('heading-custom-font');
	}
	
	if(get_option('skypanel_vibration_body_font_family') != ''){ 
	wp_register_style('body-custom-font', 'http://fonts.googleapis.com/css?family='.get_option('skypanel_vibration_body_font_family').'');
	wp_enqueue_style('body-custom-font');
	}

	}
}

add_action('wp_enqueue_scripts', 'skyali_load_scripts');


/**
 * Include the TGM_Plugin_Activation class.
 */
get_template_part('scripts/functions/class-tgm-plugin-activation');
add_action('tgmpa_register', 'vibration_register_required_plugins');
function vibration_register_required_plugins() {
	$plugins = array(
		array(
			'name'     				=> 'LayerSlider', // The plugin name
			'slug'     				=> 'LayerSlider', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/scripts/functions/plugins/layerslider.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		)
	);



// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'vibration';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'vibration_register_required_plugins_2');
function vibration_register_required_plugins_2() {
	$plugins = array(
		array(
			'name'     				=> 'Revolution Slider', // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/scripts/functions/plugins/revslider.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		)
	);



// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'vibration';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa($plugins, $config);
}
function link_pag(){
	wp_link_pages();
	
}


?>