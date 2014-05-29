<?php
/**
 * Template Name: Singles Home
 *
 *
 * @package Prototype
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>

	<?php do_atomic( 'before_content' ); // prototype_before_content ?>

	<div id="content">

		<?php do_atomic( 'open_content' ); // prototype_open_content ?>

		<div class="row">


			<div class="four columns">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/YSBF-logo-web.png" alt="Young Singles Bible Fellowship" />
			</div>

			<div class="eight columns">

				<?php get_template_part( 'slider-singles' ); // loads slider-singles.php ?>

			</div>

		</div>

		<div class="row">
			<hr>
		</div>

		<div id="row">

			<div class="three columns">
				<a href="<?php echo site_url(); ?>/grow-ysbf/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/button-grow.png" alt="Grow" /></a>
			</div>

			<div class="three columns">
				<a href="<?php echo site_url(); ?>/gather-ysbf/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/button-gather.png" alt="Gather" /></a>
			</div>

			<div class="three columns">
				<a href="<?php echo site_url(); ?>/connect/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/button-connect.png" alt="Connect" /></a>
			</div>

			<div class="three columns">
				<a href="<?php echo site_url(); ?>/serve/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/button-serve.png" alt="Serve" /></a>
			</div>

		</div>
		<div class="row">
			<hr>
		</div>

		<div class="row">

			<div class="eight columns">
				<div class="video-container"><iframe src="http://player.vimeo.com/video/58578982?title=0&amp;byline=0&amp;portrait=0" width="800" height="449" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>
			</div>

			<div class="four columns">
				<h2>About Young Singles Bible Fellowship</h2>
				<h4>Grow -</h4> Find a small group, get in one-to-one discipleship, and become an equipped follower of Christ
				<h4>Gather -</h4> Join our weekly Sunday gathering, join us in social activities, and see pictures of past events
				<h4>Connect -</h4> Get plugged into DBC and the various ministries within its community
				<h4>Serve -</h4> Whether locally, nationally, or overseas, join what God is doing through His Church
			</div>

		</div>

		<div class="row">

			<div class="eight columns">

				<?php
				$args = array(
					'post_type' => 'home_page_tab',
				);

				$home_page_tabs = new WP_Query( $args );
				?>

				<?php if ( $home_page_tabs->have_posts() ) : $i = 0;  ?>

					<ul class="tabs-content contained">

					<?php while ( $home_page_tabs->have_posts() ) : $home_page_tabs->the_post(); $i++; ?>

						<li id="simple<?php echo $i; ?>Tab"<?php if ( $i == 1 ) echo ' class="active"'; ?>>

							<div class="entry-content">
								<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', hybrid_get_parent_textdomain() ) ); ?>
								<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', hybrid_get_parent_textdomain() ), 'after' => '</p>' ) ); ?>
							</div><!-- .entry-content -->

						</li><!-- .hentry -->

					<?php endwhile; ?>

					</ul>

				<?php endif; ?>

			</div>

			<div class="four columns">

				<div class="fb-like-box" data-href="https://www.facebook.com/mensministryofdbc" data-width="390" data-height="545" data-show-faces="false" data-stream="true" data-header="false"></div>

			</div>

		</div>

		<?php do_atomic( 'close_content' ); // prototype_close_content ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // prototype_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>
