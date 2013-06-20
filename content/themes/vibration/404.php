<?php get_header(); ?>

<div class="page_heading_holder">

<?php $page_heading =  get_post_meta($post->ID, 'skyali_page-heading', true); ?>

<?php $sub_page_heading =  get_post_meta($post->ID, 'skyali_page-sub-heading', true); ?>

<?php if ( is_front_page() ) { ?>

<h1 class="page_heading"><?php _e( 'ERROR 404', 'vibration'); ?></h1>

<?php } else { ?>

<h1 class="page_heading"><?php _e( 'ERROR 404', 'vibration'); ?></h1>

<?php } ?>

</div><!-- page heading -->  

<div id="page_content" class="right_sidebar">

<p><?php _e( 'The page you are looking for does not exist.', 'vibration' ); ?></p>

</div><!-- page_content -->

<?php get_sidebar(); ?>


<?php get_footer(); ?>