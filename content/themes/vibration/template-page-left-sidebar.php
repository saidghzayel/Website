<?php

/*

Template Name: Left Sidebar

*/

?>

<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<?php  if(is_front_page()) { $paged = (get_query_var('page')) ? get_query_var('page') : 1; } else { } ?>

<?php $page_heading =  get_post_meta($post->ID, 'skyali_page-heading', true); ?>

<?php $sub_page_heading =  get_post_meta($post->ID, 'skyali_page-sub-heading', true); ?>

<?php $page_heading_option =  get_post_meta($post->ID, 'skyali_page-heading-option', true); ?>

<?php if($page_heading_option != 'disable') { ?><div class="page_heading_holder"><h1 class="page_heading"><?php if(!empty($page_heading)) { echo $page_heading; } else { echo the_title(); } ?></h1></div><!-- page heading --><?php } ?>

<?php get_sidebar(); ?>

<div id="page_content" class="left_sidebar">

<?php echo the_content(); ?>

</div><!-- page_content -->

<?php endwhile; ?> 

<?php get_footer(); ?>