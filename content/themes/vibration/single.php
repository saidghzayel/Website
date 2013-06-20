<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div class="page_heading_holder">

<h1 class="page_heading"><?php the_title(); ?></h1></div><!-- page_heading_holder -->

<div id="page_content" class="right_sidebar">

<?php $image_full = wp_get_attachment_image_src(get_post_thumbnail_id(@$post->ID), ''); ?>

<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(@$post->ID), 'blog-single'); ?>

<div class="featured_area<?php if(get_option('skypanel_vibration_featured_area') == 'Disabled') {echo ' hide';} ?>"><a href="<?php echo $image_full[0]; ?>" id="fancybox1" class="single_blog_featured_image"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a></div><!-- featured area -->

<?php the_content(); ?>

<span class="heading<?php if(get_option('skypanel_vibration_related_news') == 'Disabled'){ echo ' hide'; } ?>"><h3><?php _e('Related News','vibration'); ?></h3></span>


<?php

$category = get_the_category(); 

$categories = array();

foreach($category as $x){ array_push($categories, $x->cat_ID); }

$categories_join =  implode(',',$categories);

$exclude_post_id = $post->ID;

$args = array('cat' => $categories_join, 'showposts' => '3', 'post__not_in' => array($exclude_post_id));
?>
<?php $related_0 = 0; ?>

<?php $related = new WP_Query($args); while($related->have_posts()) : $related->the_post(); ?>

<?php $image_r = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'blog-single-related'); ?>

<?php if($related_0 == 0){ $first_related = ' no_margin_left'; } else { $first_related = ''; } ?>

<div class="related_news<?php if(get_option('skypanel_vibration_related_news') == 'Disabled'){ echo ' hide'; } ?><?php echo $first_related; ?>">

<a href="<?php echo the_permalink(); ?>" ><img src="<?php echo $image_r[0]; ?>" title="<?php the_title(); ?>" class="related_news_img"></a>

<div class="related_news_right"><h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5><span class="date"><?php echo the_time('F d, Y'); ?></span></div><!-- related_news_right -->

</div><!-- related_news -->

<?php $related_0++; ?>
  
<?php endwhile; ?>

<?php wp_reset_query(); ?>

<span class="heading<?php if(get_option('skypanel_vibration_about_author') == 'Disabled'){ echo ' hide'; } ?>"><h3><?php _e('About Author','vibration'); ?></h3></span>

<div id="about_author"<?php if(get_option('skypanel_vibration_about_author') == 'Disabled'){ echo ' class="hide"'; } ?>>

<div class="icon"><?php echo get_avatar( get_the_author_meta('email'), '75' ); ?></div><!-- #icon -->

<div class="author_info"><h5><?php the_author(); ?></h5><p><?php the_author_meta("description"); ?></p></div><!-- #author info -->

</div><!-- about_author -->


<?php if(get_option('skypanel_vibration_comments_area') != 'Disabled'){  comments_template( '', true ); } ?>

</div><!-- page_content -->

<?php endwhile; ?> 

<?php get_sidebar(); ?>

<?php get_footer(); ?>