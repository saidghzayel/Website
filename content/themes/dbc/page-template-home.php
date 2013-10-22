<?php
/**
 * Template Name: Home
 *
 * This template is for the Home page
 *
 * @package DBC
 * @subpackage Template
 */

get_header(); ?>

	<?php do_atomic( 'before_content' ); // dbc_before_content ?>

	<div id="content" role="main">

		<?php do_atomic( 'open_content' ); // dbc_open_content ?>

		<div class="hfeed">

			<?php get_template_part( 'slider-home' ); // loads slider-home.php ?>

			<div id="mydbc">
				<a class="big-button city-button" href="<?php echo site_url(); ?>/dbc-on-the-city/">
					<div class="inner"><img style="width: 134px" src="<?php echo get_stylesheet_directory_uri(); ?>/images/city-button-logo.png">
						<div>
							<span class="league-gothic">Get Connected<br>Join a Group<br>Strengthen Community</span>
						</div>
					</div>
				</a>
				<div class="big-button buttons">
					<a href="http://dentonbible.org/notes/" class="brown-button" style="margin-bottom: 5px">Tommy's Musings</a>
					<a href="http://dentonbible.org/about-us/publications/" class="brown-button">Publications</a>
				</div>
			</div><!-- #mydbc -->

			<?php get_template_part( 'latest-message' ); // loads latest-message.php ?>

			<div class="clear"></div>

			<?php get_sidebar( 'home-features' ); // Loads sidebar-home-features.php ?>

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // dbc_close_content ?>

	</div><!-- #content -->

	<?php get_sidebar( 'home' ); ?>

	<?php do_atomic( 'after_content' ); // dbc_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>
