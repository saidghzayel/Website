</div><!-- buddypress-styles -->

</div><!-- inside_page_container -->

</div><!-- page_container_holder -->

</div><!-- page_container -->

</section><!-- container -->

<footer id="footer"<?php if(get_option('skypanel_vibration_footer_widget') == 'Disabled'){ echo ' class="hide"';} ?>>

<div id="footer">

<div class="footer_holder_bg">

<div id="footer_holder">

<div id="footer_inside">

<div class="column_one"><?php dynamic_sidebar( 'first-footer-widget-area' ); ?></div><!-- column_one -->

<div class="column_two"><?php dynamic_sidebar( 'second-footer-widget-area' ); ?></div><!-- column_one -->

<div class="column_three"><?php dynamic_sidebar( 'third-footer-widget-area' ); ?></div><!-- column_one -->

<div class="column_four"><?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?></div><!-- column_one -->

</div><!-- footer_inside -->

</div><!-- footer_holder -->

</div><!-- footer_holder_bg -->

</div>

</footer>

<div class="copyright<?php if(get_option('skypanel_vibration_copyright_option') == 'Disabled'){ echo ' hide';} ?>">

<div class="inside">

<div class="left">

<ul class="bottom_menu">

<?php if ( has_nav_menu( 'bottom-menu' ) ) : ?>

<?php wp_nav_menu( array( 'theme_location' => 'bottom-menu', 'menu_class' => '', 'container' => '','items_wrap' => '%3$s' ) ); ?>

<?php endif; ?>

</ul>

</div><!-- left -->

<div class="right">

<p><?php echo get_option('skypanel_vibration_right_footer_content'); ?></p>

</div><!-- right -->

</div><!-- inside -->

</div><!-- copyright -->

<a href="#" class="scrollup">Scroll</a>

<?php wp_reset_query(); ?>

<?php $page_bg_url1 = @get_post_meta($post->ID, 'skyali_page-background-image', true); ?>

<?php $page_bg_color1 = @get_post_meta($post->ID, 'skyali_page-background-color', true); ?>

<?php $page_bg_repeat1 = @get_post_meta($post->ID, 'skyali_page-background-option', true); ?>

<style type="text/css">

<?php if($page_bg_url1 != '' OR $page_bg_color1 != '') { ?>

body{background:<?php if(@$page_bg_color1 != '') { echo '#'.@$page_bg_color1.' '; if($page_bg_url1 == ''){ echo ' !important;';} } if($page_bg_url1 != ''){ ?>url(<?php echo @$page_bg_url1; ?>) <?php echo @$page_bg_repeat1;?> !important;<?php } ?>}

<?php if($page_bg_color1 or $page_bg_url1 != '') { ?> 

<?php } ?>

<?php } ?>

</style>

<?php echo stripslashes(get_option('skypanel_vibration_tracking_code')); ?>

<?php wp_footer(); ?>

</body>

</html>