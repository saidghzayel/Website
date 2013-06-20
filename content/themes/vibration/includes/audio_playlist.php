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
<span class="audio_playlist_height"></span>
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/style.css" />
<script type="text/javascript" src='<?php echo includes_url(); ?>js/jquery/jquery.js'></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/scripts/js/audio.min.js"></script>
</head>
<body style="background:#000;overflow:hidden; float: left; width: 100%;">
<?php $audio_file =  $_GET['audiofile']; ?>
<div class="audio_player_list">

<audio src="http://2.s3.envato.com/files/38854800/preview.mp3" preload="none"></audio>

      <ol>
        <li><a href="#" data-src="http://s3.amazonaws.com/audiojs/01-dead-wrong-intro.mp3">dead wrong intro</a></li>
        <li><a href="#" data-src="http://s3.amazonaws.com/audiojs/02-juicy-r.mp3">juicy-r</a></li>
        <li><a href="#" data-src="http://s3.amazonaws.com/audiojs/03-its-all-about-the-crystalizabeths.mp3">it's all about the crystalizabeths</a></li>
        <li><a href="#" data-src="http://s3.amazonaws.com/audiojs/04-islands-is-the-limit.mp3">islands is the limit</a></li>
        <li><a href="#" data-src="http://s3.amazonaws.com/audiojs/05-one-more-chance-for-a-heart-to-skip-a-beat.mp3">one more chance for a heart to skip a beat</a></li>
      </ol>
      
  </div><!-- audio_player_list -->
  
<script type="text/javascript">
jQuery(document).ready(function($) {
	if($('audio').length){
        // Setup the player to autoplay the next track
        var a = audiojs.createAll({
          trackEnded: function() {
            var next = $('ol li.playing').next();
            if (!next.length) next = $('ol li').first();
            next.addClass('playing').siblings().removeClass('playing');
            audio.load($('a', next).attr('data-src'));
            audio.play();
          }
        });
        
        // Load in the first track
		if($("audio").size() == 1){ var $audio_num = 0; } else { var $audio_num = 2; }
        var audio = a[0];
            first = $('ol a').attr('data-src');
        $('ol li').first().addClass('playing');
        audio.load(first);

        // Load in a track on click
        $('ol li').click(function(e) {
          e.preventDefault();
          $(this).addClass('playing').siblings().removeClass('playing');
          audio.load($('a', this).attr('data-src'));
          audio.play();
        });
        // Keyboard shortcuts
        $(document).keydown(function(e) {
          var unicode = e.charCode ? e.charCode : e.keyCode;
             // right arrow
          if (unicode == 39) {
            var next = $('li.playing').next();
            if (!next.length) next = $('ol li').first();
            next.click();
            // back arrow
          } else if (unicode == 37) {
            var prev = $('li.playing').prev();
            if (!prev.length) prev = $('ol li').last();
            prev.click();
            // spacebar
          } else if (unicode == 32) {
            audio.playPause();
          }
        })
		}else{
	
	/* audio script will not load if not on page */
	
	}
      });
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
	//load the current height
	get_div_height();
	function get_div_height(){
		var div_height = $(".audio_player_list").height();
		$(".audio_playlist_height").html("" + div_height + "px");
	}
	
});
</script>
</body>

</html>
