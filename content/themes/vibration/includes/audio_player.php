<?php 
/* FindWPConfig - searching for a root of wp */

function FindWPConfig($dirrectory){

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

		if (FindWPConfig($newdir)){

			return false;

		}	

	}

	return false;

}



if (!isset($table_prefix)){

	global $confroot;

	FindWPConfig(dirname(dirname(__FILE__)));

	include_once $confroot."/wp-config.php";

	include_once $confroot."/wp-load.php";

}
?>
<head>
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/style.css" />
<script type="text/javascript" src='<?php echo includes_url(); ?>js/jquery/jquery.js'></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/scripts/js/audio.min.js"></script>
</head>
<body style="background:#000;overflow:hidden;">
<?php $audio_file = htmlentities($_GET['audiofile']); ?>

<audio src="<?php echo $_GET['audiofile']; ?>"  preload="none"></audio>
<script type="text/javascript">
jQuery(document).ready(function($) {
 audiojs.events.ready(function() {
        var as = audiojs.createAll();
      }); });
</script>
</body>

</html>
