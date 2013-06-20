<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<?php $skyali_amazon_link =  get_post_meta(get_the_ID(), 'skyali_amazon_link', true); 

$skyali_itunes_link =  get_post_meta(get_the_ID(), 'skyali_itunes_link', true); 

$skyali_buy_now_link =  get_post_meta(get_the_ID(), 'skyali_buy_now_link', true);

$skyali_albums_description =  get_post_meta(get_the_ID(), 'skyali_albums_description', true); 

$image_full = wp_get_attachment_image_src(get_post_thumbnail_id(@$post->ID), '');

$image = wp_get_attachment_image_src(get_post_thumbnail_id(@$post->ID), 'blog-single');
 ?>

<div class="page_heading_holder">

<h1 class="page_heading"><?php the_title(); ?></h1></div><!-- page_heading_holder -->

<div id="page_content" class="right_sidebar">

<div class="single_album">

<div class="latest_album">

<div class="top">

<div class="image_container">

<span class="icon_holder"><a href="<?php echo $skyali_amazon_link; ?>" class="amazon_link imgf"><?php echo translate('Buy On Amazon','vibration'); ?></a><a href="<?php echo $skyali_itunes_link; ?>" class="itunes_link imgf"><?php echo translate('Buy On Itunes','vibration'); ?></a></span><!-- icon_holder -->

<span class="date_holder"><span class="month"><?php echo get_the_date('M' ) ?></span><span class="day"><?php echo get_the_date('d') ?></span></span><!-- date_holder -->

<div class="album_single"><img src="<?php echo $image[0]; ?>" alt="<?php echo the_title(); ?>"></div><!-- album_single img -->

</div><!-- image_container -->

<div class="share_bar">

<!-- Place this tag where you want the share button to render. -->
<div class="g-plus" data-action="share" data-annotation="bubble"></div>

<!-- Place this tag after the last share tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>


<a href="https://twitter.com/share" class="twitter-share-button"><?php _e('Tweet','vibration'); ?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo the_permalink(); ?>&amp;send=false&amp;layout=button_count&amp;width=110&amp;show_faces=true&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" class="facebook_single_icon" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>




</div><!-- share_bar -->

</div><!-- top -->

</div><!-- latest_album -->


<div class="right">


<?php

$comments_number= get_comments_number(); // get_comments_number returns only a numeric value

$comments_text = 'Comment';

if($comments_number != 1) { $comments_text = 'Comments'; }

?>

<span class="comment"><a href="<?php echo get_comment_link(); ?>"><?php echo $comments_number.' '.$comments_text; ?></a></span>

<span class="date"><span><?php echo get_the_date( ); ?></span></span>

<h5><?php _e('Description','vibration'); ?>:</h5>

<p><?php echo $skyali_albums_description; ?></p>

</div><!-- right -->

</div><!-- single_album -->

<div class="single_album_bottom">

<div class="left">
<?php $term_i = 1; ?>
<?php $the_post_type = 'albums_categories'; ?>
<?php $terms = get_the_terms( $post->ID , $the_post_type );
$term_count = count($terms); 
if(!empty($terms)){
foreach ( $terms as $term ) {
echo '<a href="'.get_term_link($term->slug,$the_post_type) .'" >'.$term->name.'</a>';

if($term_i < $term_count){echo ', '; }
$term_i++;
} } ?>

</div><!-- left -->

<div class="right">

<a href="<?php echo $skyali_buy_now_link; ?>" class="button yellow_arrow_button"><?php echo translate('Buy Now','vibration'); ?></a>

</div><!-- right -->

</div><!-- single_album_bottom -->

<?php the_content(); ?>
  
<span class="heading"><h3><?php _e('Related Audio', 'vibration'); ?></h3></span>

<?php $current_post_id = get_the_ID(); ?>

<?php 

$recent_count = 1;

$related_terms  = wp_get_post_terms($post->ID, 'albums_categories', array("fields" => "names"));

foreach($related_terms as $x){ array_push($related_terms, @$x->cat_ID); }

$categories_join =  implode(',',$related_terms);

$recent_portfolio = new WP_Query('post_type=albums&showposts=4&categories='.$categories_join.''); while($recent_portfolio->have_posts()) : $recent_portfolio->the_post();  

$image_r = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'blog-single-related'); 

?>

<?php if($current_post_id != get_the_ID()){  ?>

<div class="related_news">

<a href="<?php echo the_permalink(); ?>"><img src="<?php echo $image_r[0]; ?>" alt="<?php the_title(); ?>" class="related_news_img"></a>

<div class="related_news_right"><h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5><span class="date"><?php  the_time('M d, Y'); ?></span></div><!-- related_news_right -->

</div><!-- related_news -->

<?php } ?>

<?php $recent_count++; ?>

<?php endwhile; ?>


<?php wp_reset_query(); ?>
<?php if(get_option('skypanel_vibration_comments_area') != 'Disabled'){  comments_template( '', true ); } ?>

<?php endwhile; ?>

</div><!-- page_content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>