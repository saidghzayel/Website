<?php
/**
 * Slider Home Template
 *
 * Displays a slider meant for the home page template.
 * Only displays if the settings are turned on.
 *
 * @package DBC SERVE
 * @subpackage Template
 */
 
$feature_query = new WP_Query( array( 'category_name' => 'featured', 'posts_per_page' => 10, 'meta_key' => '_expiration-date', 'orderby' => 'meta_value_num', 'order' => 'ASC' ) );

if ( $feature_query->have_posts() ) : ?>

	<div class="slider">

	<?php while ( $feature_query->have_posts() ) : $feature_query->the_post(); ?>

		<?php
		$image = get_the_image( array( 'echo' => false ) );
		if ( !empty( $image ) ) :
	 	?>
			<div><a href="<?php the_permalink(); ?>"><?php get_the_image( array( 'link_to_post' => false, 'default_size' => 'full', 'image_scan' => true ) ); ?></a></div>

		<?php endif; ?>

	<?php endwhile;  ?>

	</div>

<?php endif; ?>
