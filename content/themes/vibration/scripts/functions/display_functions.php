<?php
//*** SHOW PAGE FUNCTIONS ***//

//site logo text or image
function site_logo(){
	
	$logo_height = get_option('skypanel_vibration__logo_height');
	$logo_width = get_option('skypanel_vibration_logo_width_');
	if(!empty($logo_height)){ $echo_height = ' height="'.$logo_height.'"';}
	if(!empty($logo_width)){ $echo_width = ' width="'.$logo_width.'"';}
	
	if(get_option('skypanel_vibration_logo_settings') == 'Text Logo'){ echo '<h1 class="site_logo_text">'.get_bloginfo('name').'</h1>'; } else {
		
	echo '<a href="'.get_bloginfo('url').'">';
	
	if(get_option('skypanel_vibration_retina_logo') != ''){
		echo '<img src="'.get_option('skypanel_vibration_retina_logo').'" '.$echo_height.' '.$echo_width.' border="0" alt="'.get_bloginfo('name').'"  />';
	}
	
	elseif(get_option('skypanel_vibration_logo') != '')
	
  { echo '<img src="'.get_option('skypanel_vibration_logo').'" '.$echo_height.' '.$echo_width.' border="0" alt="'.get_bloginfo('name').'"  />';}
 
  elseif(get_option('skypanel_vibration_skin_style') == 'Bright'){ echo'<img src="'.get_template_directory_uri().'/images/vibration-logo-dark.png" border="0" alt="'.get_bloginfo('name').'"/>'; }
	
	else{ echo'<img src="'.get_template_directory_uri().'/images/vibration-logo.png" border="0" alt="'.get_bloginfo('name').'"/>'; }
	
	echo'</a>';	
	
 }
 
}

function skyali_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
	 
	 //<div class="pagination"><a href="#" class="active">1</a><a href="#" class="link imgf">2</a><a href="#" class="link imgf">3</a></div><!-- #pagination -->
     {
         echo "<div class=\"pagination\">";
         //if($paged > 2 && $paged > $range+1 && $showitems < $pages)echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         //if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<a href=\"#\" class=\"active\">".$i."</a>":"<a href='".get_pagenum_link($i)."' class=\"link imgf\" >".$i."</a>";
             }
         }

        // if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
        // if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div><!-- #pagination -->\n";
     }
}


add_filter('get_avatar','change_avatar_css');

function change_avatar_css($class) {
$class = str_replace("class='avatar", "", $class) ;
return $class;
}

add_filter('comment_reply_link', 'change_reply_css');

function change_reply_css($class){
	$class = str_replace("class='comment-reply-link", "class='imgf", $class);
	return $class;
}


//add class's/id's to the previous/next links
add_filter('next_posts_link_attributes', 'posts_link_attributes');

add_filter('previous_posts_link_attributes', 'posts_link_attributes');
 
function posts_link_attributes(){
    return 'class="submit-black nav"';
}

//add class's/id's to the previus/next comment links
add_filter('previous_comments_link_attributes', 'comments_link_attributes');
add_filter('next_comments_link_attributes', 'comments_link_attributes');

function comments_link_attributes(){
	return 'class="submit-black nav"';
}

function skyali_comment_form_default_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
			
	$fields['author'] = 
		'<div class="form-row comment-form-author">' .
			'<label for="author">'.__( 'Name' ). 
			( $req ? ' <em class="meta">'.__('(required)', 'londonpress').'</em>' : '' ).
			'</label>'.
            '<input class="u-4" id="author" name="author" type="text" value="'.
            esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1" />'.
 		'</div>';
            
	$fields['email'] =
		'<div class="form-row comment-form-email">'.
        	'<label for="email">'.__( 'Email' ).
            ( $req ? ' <em class="meta">'.__('(required)', 'londonpress').'</em>' : '' ).'</label>'.
            '<input class="u-4 " id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" tabindex="2" />'.
   		'</div>';
                
    $fields['url'] =
    	'<div class="form-row comment-form-url">'.	 
        	'<label for="url">'.__( 'Website' ).'</label>' .
            '<input class="u-4" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />'.
		'</div>';
                
	return $fields;
}

add_filter('comment_form_default_fields', 'skyali_comment_form_default_fields');

function skyali_comment_form_field_comment( $field ) {
	$field =
    	'<div class="form-row comment-form-comment">' .
	        '<label for="comment">' . __( 'Comment','londonpress' ) . ' <em class="meta">'.__('(required)', 'londonpress').'</em></label>' .
    	    '<textarea class="u-8" id="comment" name="comment" cols="45" rows="8" tabindex="4"></textarea>' .
		'</div>';	
		
	return $field;
}

add_filter('comment_form_field_comment', 'skyali_comment_form_field_comment');


$content_width = 900;
?>