<?php 
add_action('wp_head', 'custom_css_vibration');

function custom_css_vibration() {  ?>



	<div id="fb-root">
	</div>
	<script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";  fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));</script>

<style type="text/css">
<?php if(get_option('skypanel_vibration_sticky_header') == 'Enabled') { ?>
header {
position: fixed;
z-index: 10000;
width: 100%;
margin-bottom: 10px;
float: left;
}

#page_container_holder{
margin-top:135px;
}

@media only screen and (min-width: 480px) and (max-width: 767px) {
	#page_container_holder {
margin-top: 227px !important;
}
}

@media only screen and (max-width: 479px) {	 

#page_container_holder {
margin-top: 227px !important;
}
}
<?php } ?>

<?php if ( is_active_sidebar( 'primary-top-header-widget-area' ) ) : ?>

@media only screen and (min-width: 700px) {
ul.top_menu{
	margin-top:38px !important;
}
}

@media only screen and (min-width: 480px) and (max-width: 767px) {
ul.top_menu{
	margin-top:0px !important;
}
div#header_holder ul.social_icons{
	float: right;
margin-right: 0px !important;
margin-top: 15px;
}
}

@media only screen and (max-width: 479px) {	
ul.top_menu{
	margin-top:0px !important;
}

div#header_holder ul.social_icons{
	float: right;
margin-right: 0px !important;
margin-top: 15px;
}
}

<?php endif; ?>


/* Font Settings */
<?php if(get_option('skypanel_vibration_top_menu_font_size') != '') { ?>
ul.top_menu li a{
	font-size:<?php echo get_option('skypanel_vibration_top_menu_font_size'); ?>;
}
<?php } ?>


<?php if(get_option('skypanel_vibration_paragraph_font_size') != '') { ?>
p{
	font-size:<?php echo get_option('skypanel_vibration_paragraph_font_size'); ?>;
}
<?php } ?>


<?php if(get_option('skypanel_vibration_h1_font_size') != '') { ?>
div#page_content h1{
	font-size:<?php echo get_option('skypanel_vibration_h1_font_size'); ?>;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_h2_font_size') != '') { ?>
div#page_content h2{
	font-size:<?php echo get_option('skypanel_vibration_h2_font_size'); ?>;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_h3_font_size') != '') { ?>
div#page_content h3{
	font-size:<?php echo get_option('skypanel_vibration_h3_font_size'); ?>;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_h4_font_size') != '') { ?>
div#page_content h4{
	font-size:<?php echo get_option('skypanel_vibration_h4_font_size'); ?>;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_h5_font_size') != '') { ?>
div#page_content h5{
	font-size:<?php echo get_option('skypanel_vibration_h5_font_size'); ?>;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_h6_font_size') != '') { ?>
div#page_content h6{
	font-size:<?php echo get_option('skypanel_vibration_h6_font_size'); ?>;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_font_weight') != '') { ?>
#commentform #submit,#contact_form .formsubmit,#contact_form label, #commentform label,h2.accordion-head,h2.toggle-box-head,.audio_player_list li,a,ul.top_menu li a,h1.page_heading,div.single_album div.right h5,
div.single_album_bottom a,.copyright a,.copyright p{
	font-weight:<?php echo get_option('skypanel_vibration_font_weight'); ?>;
}
<?php } ?>

/* Font Settings End */

<?php if(get_option('skypanel_vibration_heading_font_family') != '') { ?>
h1,h2,h3,h4,h5,h6,body,a{
	font-family: '<?php echo get_option('skypanel_vibration_heading_font_family'); ?>';
}
<?php } ?>



<?php if(get_option('skypanel_vibration_body_font_family') != '') { ?>
p,blockquote{
	font-family: '<?php echo get_option('skypanel_vibration_body_font_family'); ?>';
}
<?php } ?>


<?php if(get_option('skypanel_vibration_header_links') != ''){ ?>
 ul.top_menu li a,ul.top_menu li a:hover{
	color:<?php echo get_option('skypanel_vibration_header_links'); ?> !important;
}
<?php } ?>


<?php if(get_option('skypanel_vibration_headings_color') != ''){ ?>
div#page_content span.heading h3, #sidebar span.heading h3{
color:<?php echo get_option('skypanel_vibration_headings_color'); ?>;
}
.buddypress-styles div.item-list-tabs {
	border-bottom:2px solid <?php echo get_option('skypanel_vibration_headings_color'); ?>;
}

.buddypress-styles input:focus,.buddypress-styles  textarea:focus{
	border-color : <?php echo get_option('skypanel_vibration_headings_color'); ?>;
box-shadow : 0 1px 1px rgba(0, 0, 0, 0.1) inset, 0 0 8px <?php echo get_option('skypanel_vibration_headings_color'); ?>;
}

<?php } ?>


<?php if(get_option('skypanel_vibration_page_title') != ''){ ?>
h1.page_heading,h1.page-title{
	color:<?php echo get_option('skypanel_vibration_page_title'); ?> !important;
}
<?php } ?>


<?php if(get_option('skypanel_vibration_read_more_links') != ''){ ?>
a.yellow_arrow_button, #contact_form .yellow_arrow_button, #commentform .yellow_arrow_button{
	color:<?php echo get_option('skypanel_vibration_read_more_links'); ?> !important;
}

<?php } ?>



<?php if(get_option('skypanel_vibration_read_more_links_background') != ''){ ?>
a.yellow_arrow_button, #contact_form .yellow_arrow_button, #commentform .yellow_arrow_button{
	background:<?php echo get_option('skypanel_vibration_read_more_links_background'); ?> url(<?php echo get_template_directory_uri(); ?>/images/yellow_arrow_link.png) no-repeat 7px 6px;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_event_countdown_color') != '') { ?>
ul#eventcountdown li span{
	color:<?php echo get_option('skypanel_vibration_event_countdown_color'); ?>;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_album_icon_links_box')== 'Disabled') { ?>
div.latest_album span.icon_holder{
	display:none;
}
<?php } ?>


<?php if(get_option('skypanel_vibration_body_text_color') != ''){ ?>
#page_container p{
	color:<?php echo get_option('skypanel_vibration_body_text_color'); ?>;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_footer_background') != ''){ ?>
.footer_holder_bg{
	background:<?php echo get_option('skypanel_vibration_footer_background'); ?> !important;
}
<?php } ?>
<?php if(get_option('skypanel_vibration_footer_headings') != ''){ ?>
#footer_holder h3,#footer_holder h4{
	color:<?php echo get_option('skypanel_vibration_footer_headings'); ?> !important;
}
<?php } ?>
<?php if(get_option('skypanel_vibration_footer_paragraphs') != ''){ ?>
#footer_inside p{
	color:<?php echo get_option('skypanel_vibration_footer_paragraphs'); ?> !important;
}
<?php } ?>
<?php if(get_option('skypanel_vibration_footer_links') != ''){ ?>
#footer_holder a{
	color:<?php echo get_option('skypanel_vibration_footer_links'); ?>;
}
<?php } ?>
<?php if(get_option('skypanel_vibration_top_menu_highlight') != ''){ ?>
ul.top_menu li.current_page_item a, ul.top_menu li.current-menu-item a, ul.top_menu li a:hover{
	background:<?php echo get_option('skypanel_vibration_top_menu_highlight'); ?>;
}

.audio_player_list li.playing a{
	color:<?php echo get_option('skypanel_vibration_top_menu_highlight'); ?>;
	}

<?php if(get_option('skypanel_vibration_headings_color') == ''){ ?>

.buddypress-styles div.item-list-tabs {
	border-bottom:2px solid <?php echo get_option('skypanel_vibration_top_menu_highlight'); ?>;
}

.buddypress-styles input:focus,.buddypress-styles  textarea:focus{
	border-color : <?php echo get_option('skypanel_vibration_top_menu_highlight'); ?>;
box-shadow : 0 1px 1px rgba(0, 0, 0, 0.1) inset, 0 0 8px <?php echo get_option('skypanel_vibration_top_menu_highlight'); ?>;
}

<?php } ?>

<?php } ?>

<?php if(get_option('skypanel_vibration_top_header_line') != ''){ ?>
#header_holder{
	border-bottom:1px solid <?php echo get_option('skypanel_vibration_top_header_line'); ?>;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_top_header_line') != ''){ ?>
#header_holder{
	border-bottom:1px solid <?php echo get_option('skypanel_vibration_top_header_line'); ?>;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_image_highlight_box_') != ''){ ?>
div.latest_posts span.comment_holder, div.latest_posts_style_2 span.comment_holder, div.latest_posts_style_3 span.comment_holder,div.latest_album span.icon_holder,.latest_shows .show_date, .latest_shows_style_2 .show_date, .show_single .show_date{
	background:<?php echo get_option('skypanel_vibration_image_highlight_box_'); ?>;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_header_options') == 'Menu on Left Logo on Right'){ ?>
#header_inside .left {
width: 40%;
float: right;
text-align: right;
}
#header_inside .right {
width: 60%;
float: left;
position: relative;
text-align: left;
height: 100%;
}
ul.top_menu{
	right:auto;
}
<?php } ?>

<?php if(get_option('skypanel_vibration_heading_highlight_line') != ''){ ?>
span.heading h3{
	border-bottom:1px solid <?php echo get_option('skypanel_vibration_heading_highlight_line'); ?>;
}
<?php } ?>
<?php if(get_option('skypanel_vibration_custom_css') != ''){  ?>
<?php echo get_option('skypanel_vibration_custom_css'); ?>
<?php } ?>
</style>
<?php
}
?>