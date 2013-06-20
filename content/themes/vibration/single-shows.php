<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div class="page_heading_holder">

<?php $google_map_embed = get_post_meta($post->ID, 'skyali_google_map_embed_code', true); ?>

<?php 

$skyali_show_month =  get_post_meta(get_the_ID(), 'skyali_show_month', true); 

$skyali_show_day =  get_post_meta(get_the_ID(), 'skyali_show_day', true); 

$skyali_show_year =  get_post_meta(get_the_ID(), 'skyali_show_year', true); 

$skyali_show_time =  get_post_meta(get_the_ID(), 'skyali_show_time', true); 

$skyali_show_location =  get_post_meta(get_the_ID(), 'skyali_show_location', true); 

$ticket_link =  get_post_meta(get_the_ID(), 'skyali_ticket_link', true); 

$skyali_show_status =  get_post_meta(get_the_ID(), 'skyali_show_status', true); 

$show_custom_link = get_permalink($post->ID);

if(!empty($ticket_link)) { $show_custom_link = $ticket_link; }

$book_show_text = get_option('skypanel_vibration_book_show');

if(empty($book_show_text)) { $book_show_text = ''.translate('Book Show','vibration').''; }

$book_show_button_option = get_post_meta(get_the_ID(), 'skyali_show_disable_button', true); 

$hide_book_show_button = '';

if($book_show_button_option != 'enable' && !empty($book_show_button_option)) { if($book_show_button_option == 'disable') { $hide_book_show_button =' hide'; } else { } }

if($skyali_show_status == ''){ $show_link = '<a href="'.$show_custom_link.'" class="button yellow_arrow_button'. $hide_book_show_button.'">'.$book_show_text.'</a>';}

if($skyali_show_status == 'free'){ $show_link = '<a href="'.$show_custom_link.'" class="button yellow_arrow_button'. $hide_book_show_button.'">'.translate('Free Show','vibration').'</a>';}

if($skyali_show_status == 'canceled'){ $show_link = '<a href="#" class="button yellow_arrow_button'. $hide_book_show_button.'">'.translate('Canceled','vibration').'</a>';}

if($skyali_show_status == 'soldout'){ $show_link = '<a href="#" class="button yellow_arrow_button'. $hide_book_show_button.'">'.translate('Sold Out','vibration').'</a>';}

$image_full = wp_get_attachment_image_src(get_post_thumbnail_id(@$post->ID), '');

$image = wp_get_attachment_image_src(get_post_thumbnail_id(@$post->ID), 'blog-single');

?>
  
<h1 class="page_heading"><?php if(!empty($page_heading)) { echo $page_heading; } else { echo the_title(); } ?></h1></div><!-- page_heading_holder -->

<div id="page_content" class="right_sidebar">

<div class="show_single">

<div class="left">

<div class="image_container">

<span class="show_date"><span class="day"><?php echo $skyali_show_day; ?></span><span class="month"><?php echo $skyali_show_month.' <span style="font-size:11px;">, '.$skyali_show_year.'</span>'; ?></span></span>

<div class="show_single_image"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></div><!-- show_single_image -->

</div><!-- image_container -->

</div><!-- left -->

<div class="right">

<span class="show_time"><span><?php echo $skyali_show_time; ?></span></span>

<span class="show_location"><span><?php echo $skyali_show_location; ?></span></span>

<?php echo  html_entity_decode($google_map_embed); ?>

<div style="float:right; margin-top:15px;"><?php echo $show_link; ?></div>

</div><!-- right -->

</div><!-- show_single -->

<?php the_content(); ?>

<?php wp_reset_query(); ?>

<?php endwhile; ?>

</div><!-- page_content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>