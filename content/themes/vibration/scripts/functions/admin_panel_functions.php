<?php

//*** ADMIN PANEL OPTIONS ***//
//Page Categories Logo Design, About Us Etc Admin Panel Top Navigation...
function page_categories(){
	if(isset($_GET['p'])){
	$page = htmlentities($_GET['p']);
	$category = htmlentities($_GET['c']);
	}
	else{
		$page = '';
		$category = '';
	}
	$active = 'class="active"';
	if($page == 'general' OR $page == ''){
	echo '<li><a href="admin.php?page=theme_settings&p=general&c=logo_design">Logo Design</a></li>'; 
	echo '<li><a href="admin.php?page=theme_settings&p=general&c=theme_skins">Theme Skins</a></li>';
	echo '<li><a href="admin.php?page=theme_settings&p=general&c=footer">Footer</a></li>';
	echo '<li><a href="admin.php?page=theme_settings&p=general&c=top_navigation">Menu</a></li>';
	echo '<li><a href="admin.php?page=theme_settings&p=general&c=search_bar">Search Bar</a></li>';
	}
	if($page == 'home_page'){
		echo '<li><a href="admin.php?page=theme_settings&p=home_page&c=boxes">Boxes</a></li>';
		echo '<li><a href="admin.php?page=theme_settings&p=home_page&c=slogan">Slogan</a></li>';
			echo '<li><a href="admin.php?page=theme_settings&p=home_page&c=portfolio_items">Portfolio Items</a></li>';
		echo '<li><a href="admin.php?page=theme_settings&p=home_page&c=slider">Nivo Slider</a></li>';
		echo '<li><a href="admin.php?page=theme_settings&p=home_page&c=3d_slider">3d Slider</a></li>';
		echo '<li><a href="admin.php?page=theme_settings&p=home_page&c=accordion_slider">Accordion Slider</a></li>';
		echo '<li><a href="admin.php?page=theme_settings&p=home_page&c=blog">Blog</a></li>';
	}
	
	if($page == 'post_page'){
		echo '<li><a href="admin.php?page=theme_settings&p=post_page&c=blog_img">Featured Image</a></li>'; 
		echo '<li><a href="admin.php?page=theme_settings&p=post_page&c=about_author">About Author</a></li>'; 
	} 
	if($page == 'portfolio_page'){
		echo '<li><a href="admin.php?page=theme_settings&p=portfolio_page&c=back_portfolio">Portfolio Button</a></li>';
		echo '<li><a href="admin.php?page=theme_settings&p=portfolio_page&c=recent_projects">Recent Projects</a></li>'; 
	}
	
	if($page == 'misc'){
		echo '<li><a href="admin.php?page=theme_settings&p=misc&c=contact_email">Contact Email</a></li>';
		echo '<li><a href="admin.php?page=theme_settings&p=misc&c=tracking">Tracking Code</a></li>';
		echo '<li><a href="admin.php?page=theme_settings&p=misc&c=social_icons">Social Icons</a></li>';
	}
	
}



//*** END ADMIN PANEL OPTIONS ***//
?>