<?php
/**
 * Template Name: MBF Groups
 *
 *
 * @package Prototype
 * @subpackage Template
 */
get_header(); // Loads the header.php template. ?>

	<?php do_atomic( 'before_content' ); // prototype_before_content ?>

	<div id="content" class="nine columns push-three">

		<?php do_atomic( 'open_content' ); // prototype_open_content ?>

		<div class="hfeed">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php do_atomic( 'before_entry' ); // prototype_before_entry ?>

					<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

						<?php do_atomic( 'open_entry' ); // prototype_open_entry ?>

						<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>

						<div class="entry-content">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', hybrid_get_parent_textdomain() ) ); ?>
							<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', hybrid_get_parent_textdomain() ), 'after' => '</p>' ) ); ?>
                            
                            
        <?php $groupquery = new WP_Query( array ( 'orderby' => 'name', 'order' => 'ASC', 'category_name' => 'mbf-group' )  ); ?>
        <div id="group">
        &nbsp;
        <?php while ($groupquery->have_posts()) : $groupquery->the_post(); ?>
        <div class="group-container">
        <div class="group-photo">
        	<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
						   the_post_thumbnail('medium');
						} ?>
        </div>
        <div class="group-content">
        	<h2><?php the_title(); ?></h2>
            <?php the_content(); ?>
        </div>
        <div style="clear:both"></div>
        </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
        
						</div><!-- .entry-content -->

						<?php do_atomic( 'close_entry' ); // prototype_close_entry ?>

					</div><!-- .hentry -->

					<?php do_atomic( 'after_entry' ); // prototype_after_entry ?>

					<?php get_sidebar( 'after-singular' ); // Loads the sidebar-after-singular.php template. ?>

					<?php do_atomic( 'after_singular' ); // prototype_after_singular ?>

					<?php comments_template( '/comments.php', true ); // Loads the comments.php template. ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // prototype_close_content ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // prototype_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>
