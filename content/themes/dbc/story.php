<?php
/**
 * Story Template
 *
 * This is the default story template.  It is used when a more specific template can't be found to display
 * singular views of the 'story' post type.
 *
 * @package DBC
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>

	<?php do_atomic( 'before_content' ); // dbc_before_content ?>

	<div id="content" role="main">

		<?php do_atomic( 'open_content' ); // dbc_open_content ?>

		<div class="hfeed">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php do_atomic( 'before_entry' ); // dbc_before_entry ?>

					<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

						<?php do_atomic( 'open_entry' ); // dbc_open_entry ?>


						<?php $publication_month = get_post_meta($post->ID, 'publication-month', true); ?>
						<?php $publication_year = get_post_meta($post->ID, 'publication-year', true); ?>
						
						<?php
							if ( !empty( $publication_month ) )
								echo apply_atomic_shortcode( 'byline', '<div class="byline">' . $publication_month .' ' . $publication_year . __( ' [entry-edit-link before=" | "]', 'dbc' ) . '</div>' );
							else
								echo apply_atomic_shortcode( 'byline', '<div class="byline">' . __( '[entry-published format="F Y"] [entry-edit-link before=" | "]', 'dbc' ) . '</div>' );
						?>
						
						<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
						
						<div class="entry-content">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'dbc' ) ); ?>
							<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'dbc' ), 'after' => '</p>' ) ); ?>
						</div><!-- .entry-content -->

						<?php do_atomic( 'close_entry' ); // dbc_close_entry ?>

					</article><!-- .hentry -->
					
					<?php do_atomic( 'after_entry' ); // dbc_after_entry ?>

					<?php get_sidebar( 'after-singular' ); // Loads the sidebar-after-singular.php template. ?>

					<?php do_atomic( 'after_singular' ); // dbc_after_singular ?>
					
				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // dbc_close_content ?>
		
		<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

	</div><!-- #content -->

	<div id="sidebar-sticky" class="addthis_toolbox addthis_default_style addthis_32x32_style">
		<div class="buttons">
			<div class="fb-like" data-href="<?php echo urlencode(get_permalink($post->ID)); ?>" data-send="false" data-layout="box_count" data-width="42" data-show-faces="false"></div>
			<p>
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_twitter"></a>
				<a class="addthis_button_email"></a>
				<a class="addthis_button_print"></a>
				<a class="addthis_button_compact"></a>
			</p>
		</div>
		<form style="margin-top: 60px;border:3px solid #c8b6a2;padding:3px;text-align:center;background-color:#ede8e1" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=DBC_CultureWatch', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><h3 style="color:#c8b6a2; text-shadow:1px 1px 3px #000">Subscribe</h3>Enter your email:<br><input type="text" style="width:92%" name="email"/><p><input type="hidden" value="DBC_CultureWatch" name="uri"/><input type="hidden" name="loc" value="en_US"/><input type="submit" value="Submit" /></p></form>
	</div><!-- #sidebar-sticky -->
	
	<?php do_atomic( 'after_content' ); // dbc_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>
