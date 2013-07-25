<?php
/**
 * Sidebar Home Template
 *
 * Displays any widgets for the Home dynamic sidebar if they are available.
 *
 * @package DBC
 * @subpackage Template
 */

if ( is_active_sidebar( 'home' ) ) : ?>

	<aside id="sidebar-home" class="sidebar">

		<div id="welcome">

			<div class="welcome-inner">

				<h3 class="widget-title">Welcome to Denton Bible</h3>
				<div class="welcome-service-times">Service Times</div>
				<div class="welcome-service-times-data">Sundays 9am, 11am, &amp; 6pm </div>
				<div class="welcome-directions"><a href="http://maps.google.com/maps?q=denton+bible+church&amp;hl=en&amp;cd=2&amp;ei=OV4JTM2vFJKWyATatpnzCw&amp;sig2=Bpb5ptGDjwjGgT9zWAEjtQ&amp;sll=33.211116,-97.119141&amp;sspn=60.426921,135.263672&amp;ie=UTF8&amp;t=h&amp;view=map&amp;cid=5680980661328689132&amp;ved=0CB0QpQY&amp;hq=denton+bible+church&amp;hnear=&amp;z=16&amp;iwloc=A" rel="external">Directions</a> (from Google Maps)</div>
				<div class="welcome-visiting-information"><a href="<?php echo home_url(); ?>/about-us/visitor-information/"><span>Visiting Information</span></a></div>

			</div>

		</div>

		<?php dynamic_sidebar( 'home' ); ?>

	</aside><!-- #sidebar-home -->

	<div class="clear"></div>

<?php endif; ?>