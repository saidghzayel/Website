<span class="heading"><h3>

<?php

printf( _n( '(1) Reader '.get_option('skypanel_vibration_comment').'', '(%1$s) Readers '.get_option('skypanel_vibration_comment').'s ', get_comments_number() ),

number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );

?>

</h3></span><!-- heading -->

<?php if ( post_password_required() ) : ?>

<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any.', 'vibration' ); ?><?php echo get_option('skypanel_vibration_comment').'s'; ?></p>

<?php return; endif; ?>

<?php if ( have_comments() ) : ?>

<ol id="comments"><!-- main holder -->

<?php wp_list_comments( array( 'callback' => 'skyali_comment' ) );	?>

</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>

<div id="entries">

<div class="old_entries"><?php previous_comments_link( __( '<span class="meta-nav">&laquo;</span> ', 'londonpress' ) ); ?></div>

<div class="new_entries"><?php next_comments_link( __( ' <span class="meta-nav">&raquo;</span>', 'londonpress' ) ); ?></div>

</div><!-- .navigation -->
      
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

/* If there are no comments and comments are closed,

* let's leave a little note, shall we?

 */

if ( ! comments_open() ) :

?>

<p class="nocomments"<?php echo get_option('skypanel_vibration_comment'); ?>><?php _e( 's are closed.', 'vibration' ); ?></p>

<?php endif; // end ! comments_open()

endif; // end have_comments()  

// change the title of send button
$comments_args = array( 'title_reply'=>'<div class="heading"><h3>'.get_option('skypanel_vibration_leave_a_reply').'</h3></div><!-- heading -->',); 

comment_form($comments_args); ?>

<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>