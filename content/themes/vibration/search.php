<?php get_header(); ?>


<div class="page_heading_holder">

<?php $page_heading =  get_post_meta($post->ID, 'skyali_page-heading', true); ?>

<?php $sub_page_heading =  get_post_meta($post->ID, 'skyali_page-sub-heading', true); ?>

<h1 class="page_heading"><?php echo get_option('skypanel_vibration_search_results');  ?><?php printf(__('\'%s\''), $s) ?></h1>

</div><!-- page heading -->  

<div id="page_content" class="right_sidebar">

<?php  if (have_posts()) :
 while (have_posts()) : the_post(); ?>

<?php 

$comments_number= get_comments_number(); // get_comments_number returns only a numeric value

$comments_text = 'Comment';

if($comments_number != 1) { $comments_text = 'Comments'; }

?>

<div class="latest_posts">

<div class="left"><div class="image_container">

<span class="date_holder"><span class="month"><?php echo get_the_date('M' ); ?></span><span class="day"><?php echo  get_the_date('d'); ?></span></span><!-- date_holder -->

<span class="comment_holder"><a href="<?php echo @get_comment_link(); ?>"><span class="comment_num"><?php echo $comments_number ; ?></span> <span class="comments_word"><?php echo  $comments_text ; ?></span></a></span><!-- comment_holder -->

<?php

$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'latest_photo');

$image_full =   wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

?>


<a href="<?php echo get_permalink($post->ID); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php echo apply_filters( 'the_title', get_the_title() ) ; ?>"/></a>

</div><!-- image_container --></div><!-- left -->

<div class="right">

<span class="comment"><a href="<?php echo @get_comment_link(); ?>"><?php echo $comments_number.' '.$comments_text; ?></a></span>

<span class="date"><span><?php echo get_the_date( ); ?></span></span>

<span class="author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author(); ?></a></span>

<h4><a href="<?php echo get_permalink($post->ID); ?>"><?php echo apply_filters( 'the_title', get_the_title() ); ?></a></h4>

<p><?php echo excerpt(30); ?>...</p>

<a href="<?php echo get_permalink($post->ID); ?>" class="button yellow_arrow_button"><?php _e('Read More','vibration'); ?></a>

</div><!-- right -->

</div><!-- latest_posts -->

<?php endwhile; ?> 

<?php skyali_pagination(); ?>

<?php else: ?>

<p><?php _e('Sorry, The term you are searching for returned no results. Please try again.','vibration'); ?></p>

<?php endif; ?>

</div><!-- page_content -->

<?php get_sidebar(); ?>


<?php get_footer(); ?>