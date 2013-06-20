<!DOCTYPE html>
<!--[if lte IE 7]> <html class="ie7"> <![endif]-->
<!--[if IE 8]>     <html class="ie8"> <![endif]-->
<!--[if IE 9]>     <html class="ie9"> <![endif]-->
<!--[if !IE]><!-->              <!--<![endif]-->

 <!-- end countdown script-->
<html <?php language_attributes(); ?>><head>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<?php if(get_option('skypanel_vibration_favicon') != ''){ ?>

<link rel='shortcut icon' type='image/x-icon' href='<?php echo get_option('skypanel_vibration_favicon'); ?>' />
<?php } ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">

<title><?php

	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.

	bloginfo( 'name' );

	// Add the blog description for the home/front page.

	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) )

		echo " | $site_description";

	// Add a page number if necessary:

	if ( $paged >= 2 || $page >= 2 )

		echo ' | ' . sprintf( __( 'Page %s', 'vibration' ), max( $paged, $page ) );



	?></title>

<?php wp_head(); ?>


</head>

<body <?php body_class( @$class ); ?>>
<header>
<div id="header_holder">
<div id="header_inside">
<div class="left"><?php site_logo(); ?> </div><!-- header left -->
<div class="right">

<?php dynamic_sidebar( 'primary-top-header-widget-area' ); ?>

<ul class="top_menu">

<div class="select_holder">

<div id="navigation">

<form action="#">

<select onChange="javascript:changeLocation(this)">

<?php 

$nav_ex = @implode(',',get_option('skypanel_vibration_exclude_top_navigation_pages')); 

  $pages_list = get_pages(array('exclude' => $nav_ex )); 

  foreach ( $pages_list as $page_item ) {

     if($page_item->ID == $post->ID) { $selected = ' selected="selected"'; } else { $selected = ''; }
	 
  	$option = '<option value="' . get_page_link( $page_item->ID ) . '"'.$selected.'>';

	$option .= $page_item->post_title;

	$option .= '</option>';

	echo $option;

  }

 ?>

</select>

</form>

</div><!-- navigation -->

</div><!-- #select_holder -->

<?php if ( has_nav_menu( 'top-menu' ) ) : ?>

<?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'menu_class' => 'top_menu', 'container' => '','items_wrap' => '%3$s' ) ); ?>

<?php else :  ?>

<?php if (is_home() OR is_front_page()) $select = "active"; else $select = "page_item"; ?>

<?php wp_list_pages('sort_column=menu_order&depth=6&title_li=&exclude='.$nav_ex.'');?>

<?php endif; ?>
</ul><!-- top_menu -->
</div><!-- header right -->
</div><!-- header_inside -->
</div><!-- header_holder -->
</header>



<div id="page_container">

<div id="page_container_holder">

<div class="inside_page_container">

<?php $slider_option =  get_post_meta($post->ID, 'skyali_home-slider-style', true); ?>

<?php $revolution_slide_alias =  get_post_meta($post->ID, 'skyali_revolution-slider-alias', true); ?>

<?php $layerslider_id =  get_post_meta($post->ID, 'skyali_layer-slider-id', true); ?>

<?php if(!empty($revolution_slide_alias)){ if($slider_option == 'revolution_slider') { echo '<div class="slider_container">'; putRevSlider($revolution_slide_alias); echo '</div><!-- slider_container -->'; } } ?>

<?php if(!empty($layerslider_id)){if($slider_option == 'layer_slider') {  echo '<div class="slider_container">'; layerslider($layerslider_id); echo '</div><!-- slider_container -->'; }} ?>