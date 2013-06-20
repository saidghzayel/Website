<?php 

/* FindWPConfig - searching for a root of wp */

function FindWPConfigT($dirrectory){

	global $confroot;

	

	foreach(glob($dirrectory."/*") as $f){

			

		if (basename($f) == 'wp-config.php' ){

			$confroot = str_replace("\\", "/", dirname($f));

			return true;

		}



		if (is_dir($f)){

			$newdir = dirname(dirname($f));

		}

	}



	if (isset($newdir) && $newdir != $dirrectory){

		if (FindWPConfigT($newdir)){

			return false;

		}	

	}

	return false;

}



if (!isset($table_prefix)){

	global $confroot;

	FindWPConfigT(dirname(dirname(__FILE__)));

	include_once $confroot."/wp-config.php";

	include_once $confroot."/wp-load.php";

}


 global $post;
 
 
?>
  
  <?php query_posts( array( 'post_type' => '', 'showposts' => '15' ) ); if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  
<?php

  echo'';

?>

<?php $i++; ?>

<?php endwhile; endif; ?>

<?php  wp_reset_query(); ?>