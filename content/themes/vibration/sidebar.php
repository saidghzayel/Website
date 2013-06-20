<div id="sidebar">

<?php $custom_sidebar_meta = get_post_meta($post->ID, 'skyali_custom-sidebar', true); ?>

<?php // if($custom_side_meta == '') { echo 'custom sidebar empty';} ?>

<?php

 if(is_active_sidebar( $custom_sidebar_meta ) ){	

	dynamic_sidebar( ''.$custom_sidebar_meta.'' );	 

} else { 

  dynamic_sidebar( 'primary-widget-area' ); 
  
}
wp_reset_query();
?>

</div><!-- sidebar -->