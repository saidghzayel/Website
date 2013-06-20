<div id="testimonials" class="jcarousel-skin-testimonials">
    <ul>
<?php
global $post;

$args = array( 'numberposts' => 5, 'post_type'=>'testimonials');

$myposts = get_posts( $args );
foreach( $myposts as $post ) :	setup_postdata($post); ?>
  <?php $skyali_t = get_post_meta($post->ID, 'skyali_testimonial-box', true); ?>
  
  <?php $skyali_u = get_post_meta($post->ID, 'skyali_consumer-name-url', true);  ?>
  
    
    <li><blockquote><p><?php echo $skyali_t; ?> <span class="client">- <?php echo $skyali_u; ?></span></p></blockquote></li>
    

<?php endforeach;  ?>

</ul>
    
    <div class="jcarousel-control">
    <?php $testi_count = 1; ?>
    <?php $args = array( 'numberposts' => 5, 'post_type'=>'testimonials');

$myposts = get_posts( $args );
foreach( $myposts as $post ) :	setup_postdata($post); ?>
      <a href="#"><?php echo $testi_count; ?></a>
      <?php $testi_count++; endforeach;  ?>
    </div>

  </div>
