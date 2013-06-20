// JavaScript Document
jQuery(document).ready(function($) {
$(function(){
$(".option_info").tipTip({maxWidth: "auto", edgeOffset: 10});
});
});
jQuery(document).ready(function($) {
	
	$(".option_holder_toggle").hide();

	$("div.edit_icon").click(function(){
		$(this).toggleClass("active").next().slideToggle("slow");
	});

});
/* Ajax Remove */
jQuery(document).ready(function($) {
$(".delete").click(function() {
$('#load').fadeIn();
var commentContainer = $(this).parent();
var id = $(this).attr("id");
var string = 'id='+ id ;
	
$.ajax({
   data: string,
   cache: false,
   success: function(){
	commentContainer.slideUp('slow', function() {$(this).remove();});
	$('#load').fadeOut();
  }
   
 });

return false;
	});
});
jQuery(document).ready(function($) {
$('#menu').tabify();
});


jQuery(document).ready(function($) {
			$('.sortable').sortable();
			$('.handles').sortable({
				handle: 'span'
			});
			$('.connected').sortable({
				connectWith: '.connected'
			});
			$('.exclude').sortable({
				items: ':not(.disabled)'
			});
		});

 // Remove Uploaded Image
 jQuery(document).ready(function($) {
      $('.remove').live('click', function(event) { 
        $(this).hide();
        $(this).parents().prev().prev('.upload').attr('value', '');
        //$(this).parents('.screenshot').slideUp();
        $(this).parents('.screenshot').find('img').remove();
        $(this).parents('.screenshot').find('.remove').remove();
        event.preventDefault();
      });  });
	  // change upload input
	   jQuery(document).ready(function($) {
      $('.upload').live('blur', function() {
        var id = $(this).attr('id'),
            val = $(this).val(),
            img = $(this).parent().find('img'),
            btn = $(this).parent().find('.remove'),
            src = img.attr('src');
        
        // don't match update             
        if ( val != src ) {
          img.attr('src', val);
        }
        // no image to change add it
        if ( val !== '' && ( typeof src == 'undefined' || src == false ) ) {
          btnContent = '<img src="'+val+'" alt="" /><a href="" class="remove">Remove Image</a>';
          $(this).parent().find('.screenshot').append(btnContent);
        } else if ( val == '' ) {
          img.remove();
          btn.remove();
        }  
      }); });
/**
 *
 * Upload Option
 *
 * Allows window.send_to_editor to function properly using a private post_id
 * Dependencies: jQuery, Media Upload, Thickbox
 *
 */
jQuery(document).ready(function($) {
  uploadOption = {
    init: function () {
      var formfield,
          formID,
          btnContent = true;
      // On Click
      $('.upload_button').live("click", function () {
        formfield = $(this).prev('input').attr('id');
        formID = $(this).attr('rel');
        tb_show('', 'media-upload.php?post_id=0&type=image&amp;TB_iframe=1');
        return false;
      });
     
      window.original_send_to_editor = window.send_to_editor;
      window.send_to_editor = function(html) {
        if (formfield) {
          itemurl = $(html).attr('href');
          var image = /(^.*\.jpg|jpeg|png|gif|ico*)/gi;
          var document = /(^.*\.pdf|doc|docx|ppt|pptx|odt*)/gi;
          var audio = /(^.*\.mp3|m4a|ogg|wav*)/gi;
          var video = /(^.*\.mp4|m4v|mov|wmv|avi|mpg|ogv|3gp|3g2*)/gi;
          if (itemurl.match(image)) {
            btnContent = '<img src="'+itemurl+'" alt="" /><a href="" class="remove">Remove Image</a>';
          } else {
            btnContent = '<div class="no_image">'+html+'<a href="" class="remove">Remove</a></div>';
          }
          $('#' + formfield).val(itemurl);
          $('#' + formfield).next().next('div').slideDown().html(btnContent);
          tb_remove();
        } else {
          window.original_send_to_editor(html);
        }
      }
    }
  };
jQuery(document).ready(function($) {
    uploadOption.init()
  })
})(jQuery);


function toggle(button)
{
    if(button.value=="Disabled")
    {
        button.value="Enabled";
		button.className = "enable_disable button_enabled";
    }
    else
    {
        button.value="Disabled";
		button.className = "enable_disable button_disabled";
    }
}

jQuery(document).ready(function($) {
    $("#sortable,#sortable1").sortable();
  });
  
  