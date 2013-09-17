<?php
/**
 * Slider Home Template
 *
 * Displays a slider meant for the home page template.
 * Only displays if the settings are turned on.
 *
 * @package DBC Child
 * @subpackage Template
 */
?>
<div id="slider-container">
	<div class="slider">
	<?php
		$feature_query = new WP_Query( array( 'category_name' => 'featured', 'posts_per_page' => hybrid_get_setting( 'feature_num_posts' ), 'order' => 'ASC' ) );
		while ( $feature_query->have_posts() ) : $feature_query->the_post(); ?>
			<div class="<?php hybrid_entry_class( 'feature' ); ?>">
				
				<?php get_the_image( array( 'custom_key' => array( 'Medium', 'Feature Image' ), 'default_size' => 'full', 'image_scan' => true ) ); ?>
			</div>
		<?php endwhile;  ?>
	</div>
</div>
