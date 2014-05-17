<?php
/**
 * Primary Sidebar Template
 *
 * Displays widgets for the Primary dynamic sidebar if any have been added to the sidebar through the
 * widgets screen in the admin by the user.  Otherwise, nothing is displayed.
 *
 * @package DBC
 * @subpackage Template
 */

if ( is_active_sidebar( 'primary' ) ) : ?>

	<?php do_atomic( 'before_sidebar_primary' ); // dbc_before_sidebar_primary ?>

	<aside id="sidebar-primary" class="sidebar">

		<?php do_atomic( 'open_sidebar_primary' ); // dbc_open_sidebar_primary ?>

		<?php dynamic_sidebar( 'primary' ); ?>

		<?php if ( is_post_type_archive( 'story' ) && function_exists( 'wp_get_post_type_archives' ) ): ?>

			<form style="border:3px solid #c8b6a2;padding:3px;text-align:center;background-color:#ede8e1" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=DBC_CultureWatch', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><h3 style="color:#c8b6a2; text-shadow:1px 1px 3px #000">Subscribe</h3>Enter your email:<br><input type="text" style="width:92%" name="email"/><p><input type="hidden" value="DBC_CultureWatch" name="uri"/><input type="hidden" name="loc" value="en_US"/><input type="submit" value="Submit" /></p></form>
			<div class="loop">
				<h3 class="widget-title">Stories Archive</h3>
				<ul>
					<?php wp_get_post_type_archives('story'); ?>
				</ul>
			</div>

		<?php endif; ?>

			<?php if ( is_tax( 'note' ) || get_post_type() == 'note' ) { ?>

				<p class="intro-title"><img src="http://dentonbible.org/wp-content/themes/dbc/library/images/tom-square.png" class="alignleft" /> Tom Nelson</p>
				<p class="intro">Every once in a while senior pastor Tom Nelson gets a wave of inspiration he'd like to share with the church. Find them all here.</p>
				
			<?php } ?>

			<p>Denton Bible Church archives sermons from each Sunday and makes them available online. Watch, listen, download and share!</p>

			<p><a href="http://dbcmedia.org/" class="nice small radius white button" title="Denton Bible Media">Check Out DBC Media</a></p>

			<p>What better way to connect online with others in the church than Facebook?</p>

			<p><a href="http://facebook.com/dentonbible" class="nice small radius white button" title="Denton Bible on Facebook">Are you on Facebook too?</a></p>

		<?php do_atomic( 'after_sidebar_primary' ); // dbc_after_sidebar_primary ?>

	</aside><!-- #sidebar-primary -->

	<div id="sidebar-primary-switch" title="Toggle the menu">Toggle menu</div>

<?php endif; ?>
