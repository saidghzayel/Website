(function($){
	$(function() {
		var skyali_lt_builder_width = $('#skyali_lt_layout').width(),
			$skyali_lt_builder_add_links = $( '#skyali_lt_builder_controls a.skyali_lt_add_element' ),
			$skyali_lt_main_save_button = $( '#skyali_main_save' ),
			skyali_lt_module_settings_clicked = false,
			et_hidden_editor_object = tinyMCEPreInit.mceInit['skyali_hidden_editor'],
			skyali_lt_page_builder_original_width = 742,
			skyali_lt_main_module_width = 0;
		
		$( 'body' ).delegate( 'span.skyali_settings_arrow', 'click', function(){
			var $this_setting_link = $(this),
				$settings_window = $('#active_module_settings'),
				$skyali_lt_active_module = $this_setting_link.closest('.skyali_lt_module');
				
			if ( skyali_lt_module_settings_clicked ) return false;
			else skyali_lt_module_settings_clicked = true;
			
			$('#skyali_lt_layout .skyali_lt_module').css( 'z-index', '1' );
			
			if ( $('#skyali_modules').is(':hidden') ) $skyali_lt_builder_add_links.eq(0).animate('click');
			
			$.ajax({
				type: "POST",
				url: skyali_options.ajaxurl,
				data:
				{
					action : 'skyali_show_module_options',
					skyali_lt_load_nonce : skyali_options.skyali_lt_load_nonce,
					skyali_lt_module_class : $(this).closest('.skyali_lt_module').attr('class'),
					skyali_lt_modal_window : 0,
					skyali_lt_module_exact_name : $(this).closest('.skyali_lt_module').attr('data-placeholder')
				},
				error: function( xhr, ajaxOptions, thrownError ){
					skyali_lt_module_settings_clicked = false;
				},
				success: function( data ){
					$skyali_lt_main_save_button.hide();
					$skyali_lt_active_module.addClass('skyali_lt_active');
					
					$settings_window.hide().append(data).slideDown();
					$settings_window.find('.html-active').removeClass('html-active').addClass('tmce-active');
					$('#skyali_lt_module_separator').show();
					
					$('#skyali_lt_layout .skyali_lt_module:not(.skyali_lt_active,.skyali_m_column)').css('opacity',0.5);
					$('html:not(:animated),body:not(:animated)').animate({ scrollTop: $('#skyali_lt_page_builder').offset().top - 82 }, 500);
					
					skyali_lt_deactivate_ui_actions();
					skyali_lt_module_settings_clicked = false;
					
					$( '#skyali_lt_module_settings .skyali_option' ).each( function(){
						var $this_option = $(this),
							this_option_id = $this_option.attr('id'),
							$found_element = $skyali_lt_active_module.find('.skyali_lt_module_settings .skyali_lt_module_setting.' + this_option_id);
						
						if ( $found_element.length ){
							if ( $this_option.is('select') ){
								$this_option.find("option[value='" + $found_element.html() + "']").attr('selected','selected');
							} else if ( $this_option.is('input') ){
								$this_option.val( $found_element.html() );
							} else { 
								$this_option.html( $found_element.html() );
							}
						}
						
						if ( $this_option.hasClass('skyali_wp_editor') && typeof tinyMCE !== "undefined" ) {
							tinyMCE.execCommand( "mceAddControl", true, this_option_id );
							quicktags( { id : this_option_id } );
							skyali_lt_init_new_editor( this_option_id );							
						}
						
						skyali_init_sortable_attachments();
					} );
					
					if ( $skyali_lt_active_module.hasClass('skyali_m_tabs') || $skyali_lt_active_module.hasClass('skyali_m_simple_slider') ){
						$( '#skyali_lt_module_settings #skyali_tabs .wp-editor-wrap' ).each( function(index,value){
							var $this_div = $(this),
								this_editor_content = $this_div.html();
							
							$.ajax({
								type: "POST",
								url: skyali_options.ajaxurl,
								async: false, // asynchronous requests might result in errors if there are a lot of tabs to render
								data:
								{
									action : 'skyali_lt_convert_div_to_editor',
									skyali_lt_load_nonce : skyali_options.skyali_lt_load_nonce,
									skyali_index : index
								},
								success: function( response ){
									var current_tab_id = 'skyali_tab_text_' + index;
									
									$this_div.closest('.skyali_tab').find('a.skyali_delete_tab').before( response );
									
									if ( typeof tinyMCE !== "undefined" ){
										tinyMCE.execCommand( "mceAddControl", true, current_tab_id );
										quicktags( { id : current_tab_id } );
										skyali_lt_init_new_editor( current_tab_id );
										
										tinyMCE.getInstanceById( current_tab_id ).execCommand( "mceInsertContent", false, this_editor_content );
									} else {
										$this_div.closest('.skyali_tab').find( '#' + current_tab_id ).val( this_editor_content );
									}
									$this_div.remove();
									
									skyali_lt_make_editor_droppable();
									
									skyali_lt_track_active_editor();
								}
							});
						} );
						
						if ( $( '#skyali_lt_module_settings #skyali_tabs .skyali_tabs_data-elements' ).length ){
							$( '#skyali_lt_module_settings #skyali_tabs' ).attr( 'data-elements', $( '#skyali_lt_module_settings #skyali_tabs .skyali_tabs_data-elements' ).val() );
							$( '#skyali_lt_module_settings #skyali_tabs .skyali_tabs_data-elements' ).remove();
						}
						skyali_lt_init_sortable_tabs();
					}
					
					skyali_lt_track_active_editor();
				}
			});
		} );
		
		$( 'body' ).delegate( 'span.skyali_lt_delete, span.skyali_lt_delete_column', 'click', function(){
			var $this_delete_button = $(this);
			
			if ( $this_delete_button.hasClass('skyali_lt_delete') ){
				if ( $this_delete_button.find('.skyali_delete_confirmation').length ){ 
					$this_delete_button.find('.skyali_delete_confirmation').remove();
				} else { 
					$this_delete_button.append( '<span class="skyali_delete_confirmation">' + '<span>' + skyali_options.confirm_message + '</span>' + '<a href="#" class="skyali_delete_confirm_yes">' + skyali_options.confirm_message_yes + '</a><a href="#" class="skyali_delete_confirm_no">' + skyali_options.confirm_message_no + '</a></span>' );
				}
				return false;
			}
			
			skyali_delete_module( $this_delete_button.closest('.skyali_lt_module') );
		} );
		
		$( 'body' ).delegate( '.skyali_user_layout_delete', 'click', function(){
			var $this_delete_button = $(this);
						
			if ( $this_delete_button.find('.skyali_delete_confirmation').length ){ 
				$this_delete_button.find('.skyali_delete_confirmation').remove();
			} else { 
				$this_delete_button.append( '<span class="skyali_delete_confirmation">' + '' + '<a href="#" class="skyali_delete_confirm_yes">' + skyali_options.confirm_message_yes + '</a><a href="#" class="skyali_delete_confirm_no">' + skyali_options.confirm_message_no + '</a></span>' );
			}
			return false;
		} );
		
		$( 'body' ).delegate( '.skyali_delete_confirm_yes', 'click', function(){
			var $this_button = $(this);
			
			if ( $this_button.closest('#skyali_clear_all_wrapper').length ){
				$('#skyali_lt_layout').html( '' );
				$('#skyali_helper').show();
				$this_button.closest('.skyali_delete_confirmation').remove();
				skyali_lt_layout_save( true );
			} else if ( $this_button.closest('.skyali_sample_layout').length ) {
				$.ajax({
					type: "POST",
					url: skyali_options.ajaxurl,
					data:
					{
						action : 'skyali_delete_sample_layout',
						skyali_lt_load_nonce : skyali_options.skyali_lt_load_nonce,
						skyali_lt_layout_key : $this_button.closest('.skyali_sample_layout').attr('data-name')
					},
					success: function( data ){
						$this_button.closest('.skyali_sample_layout').remove();
					}
				});
			} else if ( $this_button.closest('#skyali_create_layout_wrapper').length && $this_button.siblings('#skyali_new_layout_name').val() != '' ) {
				var layout_html = $('#skyali_lt_layout').html(),
					$save_message = jQuery("#skyali_ajax_save");
			
				$.ajax({
					type: "POST",
					url: skyali_options.ajaxurl,
					data:
					{
						action : 'skyali_create_new_sample_layout',
						skyali_lt_load_nonce : skyali_options.skyali_lt_load_nonce,
						skyali_lt_layout_html : layout_html,
						et_new_layout_name : $this_button.siblings('#skyali_new_layout_name').val()
					},
					beforeSend: function ( xhr ){
						$save_message.children("img").css("display","block");
						$save_message.children("span").css("margin","6px 0px 0px 30px").html( skyali_options.saving_text );
						$save_message.fadeIn('fast');
					},
					success: function( data ){
						$save_message.children("img").css("display","none");
						$save_message.children("span").css("margin","0px").html( skyali_options.saved_text );
						
						setTimeout(function(){
							$save_message.fadeOut("slow");
						},500);
						
						$this_button.closest('.skyali_delete_confirmation').remove();
					}
				});
			} else {
				skyali_delete_module( $(this).closest('.skyali_lt_module') );
			}
			
			return false;
		} );
		
		$( '#skyali_clear_all' ).click( function(){
			var $this_button = $(this);
						
			if ( $this_button.siblings('.skyali_delete_confirmation').length ){ 
				$this_button.siblings('.skyali_delete_confirmation').remove();
			} else { 
				$this_button.closest('span').append( '<span class="skyali_delete_confirmation">' + '<span>' + skyali_options.confirm_clear_all_message + '</span>' + '<a href="#" class="skyali_delete_confirm_yes">' + skyali_options.confirm_message_yes + '</a><a href="#" class="skyali_delete_confirm_no">' + skyali_options.confirm_message_no + '</a></span>' );
			}
			
			return false;
		} );
		
		$( '#skyali_create_layout' ).click( function(){
			var $this_button = $(this);
						
			if ( $this_button.siblings('.skyali_delete_confirmation').length ){ 
				$this_button.siblings('.skyali_delete_confirmation').remove();
			} else { 
				$this_button.closest('span').append( '<span class="skyali_delete_confirmation">' + '<label for="skyali_new_layout_name">' + skyali_options.create_layout_name + ':</label>' + '<input type="text" value="" id="skyali_new_layout_name" name="skyali_new_layout_name" />' + '' + '<a href="#" class="skyali_delete_confirm_yes">' + skyali_options.create_layout_confirm_message_yes + '</a><a href="#" class="skyali_delete_confirm_no">' + skyali_options.create_layout_confirm_message_no + '</a></span>' );
			}
			
			return false;
		} );
		
		$(document).on("keypress", "#skyali_new_layout_name", function(e) {
			// if the user hits enter, create new sample layout and make sure the form isn't submitted
			if ( e.which == 13 ) {
				$(this).siblings( '.skyali_delete_confirm_yes' ).trigger( 'click' );
				return false;
			}
		});
		
		$( 'body' ).delegate( '#skyali_secondary_buttons .skyali_delete_confirm_no', 'click', function(){
			$(this).closest('.skyali_delete_confirmation').remove();
			
			return false;
		} );
		
		$( 'body' ).delegate( '#skyali_close_dialog_settings', 'click', function(){
			var $skyali_dialog_form = $('form#skyali_dialog_settings');
			
			$skyali_dialog_form.find('.skyali_wp_editor').each( function(){
				if ( typeof tinyMCE !== "undefined" ) tinyMCE.execCommand("mceRemoveControl", false, $(this).attr('id'));
			} );
			
			skyali_lt_close_modal_window();
			
			return false;
		});
		
		$( 'body' ).delegate( 'form#skyali_lt_module_settings input#submit, #skyali_close_module_settings', 'click', function(){
			var $skyali_lt_active_module_settings = $('.skyali_lt_active .skyali_lt_module_settings');
			
			$skyali_lt_active_module_settings.empty();
			$skyali_lt_main_save_button.show();
			
			$('form#skyali_lt_module_settings .skyali_option').each( function(){
				var skyali_lt_option_value, skyali_lt_option_class,
					this_option_id = $(this).attr('id');
				
				skyali_lt_option_class = this_option_id + ' skyali_lt_module_setting';
				
				if ( $(this).is('#skyali_tabs') || $(this).is('#skyali_slides') ){
					$(this).find('.skyali_tab_title').each(function(){
						var this_value = $(this).val();
						$(this).attr('value', this_value);
					});
					$(this).find('.skyali_wp_editor').each(function(){
						var $this_textarea = $(this),
							this_value = $this_textarea.val(),
							this_value_id = $this_textarea.attr('id'),
							this_editor_content;
						
						if ( typeof tinyMCE !== "undefined" ){						
							this_editor_content = $this_textarea.is(':hidden') ? tinyMCE.get( this_value_id ).getContent() : switchEditors.wpautop( tinymce.DOM.get( this_value_id ).value );
							
							tinyMCE.execCommand("mceRemoveControl", false, this_value_id);
						} else {
							this_editor_content = $this_textarea.val();
						}
						$this_textarea.closest('.wp-editor-wrap').html( this_editor_content );
					});
					
					skyali_lt_option_value = $(this).html();
					skyali_lt_option_value += '<input type="hidden" class="skyali_tabs_data-elements" value="' + $(this).find('.skyali_tab').length + '" />';
				}
				else if ( $(this).hasClass('skyali_wp_editor') ){
					if ( typeof tinyMCE !== "undefined" ){
						skyali_lt_option_value = $(this).is(':hidden') ? tinyMCE.get( this_option_id ).getContent() : switchEditors.wpautop( tinymce.DOM.get( this_option_id ).value );
						tinyMCE.execCommand("mceRemoveControl", false, this_option_id);
					} else {
						skyali_lt_option_value = $(this).val();
					}
				}
				else if ( $(this).is('select, input') ) {
					skyali_lt_option_value = $(this).val();
				}
				else if ( $(this).is('#skyali_slides') ){
					$(this).find('input, textarea').each(function(){
						var this_value = $(this).val();
						
						if ( $(this).is('input') ) $(this).attr('value', this_value);
						else $(this).html( this_value );
					});
					skyali_lt_option_value = $(this).html();
				}
				
				if ( $(this).hasClass('skyali_module_content') ) skyali_lt_option_class += ' skyali_module_content';
				
				$skyali_lt_active_module_settings.append( '<div data-option_name="' + this_option_id + '" class="' + skyali_lt_option_class + '">' + skyali_lt_option_value + '</div>' );
			} );
			
			$( '#skyali_lt_layout .skyali_lt_module' ).removeClass('skyali_lt_active').css('opacity',1);
			
			$(this).closest('#active_module_settings').slideUp().find('form#skyali_lt_module_settings').remove();
			$('#skyali_lt_module_separator').hide();
			
			$('#skyali_lt_layout').css( 'height', 'auto' );
			
			skyali_lt_reactivate_ui_actions();
			
			$('#skyali_main_save').trigger('click');
			
			return false;
		} );
		
		$( 'body' ).delegate( 'form#skyali_dialog_settings input#submit', 'click', function(){
			var $skyali_dialog_form = $('form#skyali_dialog_settings'),
				skyali_lt_current_module_name = 'skyali_' + $skyali_dialog_form.find('input#skyali_saved_module_name').val(),
				skyali_lt_shortcode_text, skyali_lt_shortcode_content = '',
				advanced_option = false,
				editor_id = $skyali_dialog_form.find('input#skyali_lt_paste_to_editor_id').val(),
				$current_textarea,
				current_textarea_value;
			
			skyali_lt_shortcode_text = '[' + skyali_lt_current_module_name;
			
			$skyali_dialog_form.find('.skyali_option').each( function(){
				var skyali_lt_option_value,
					this_option_id = $(this).attr('id'),
					shortcode_option_id = this_option_id.replace('skyali_dialog_','');
				
				if ( this_option_id == 'skyali_slides' ){
					advanced_option = true;
					skyali_lt_shortcode_text += ']';
					
					$(this).find('.skyali_lt_attachment').each( function(){
						var $this_attachment = $(this),
							attachment_id = $this_attachment.attr('data-attachment'),
							attachment_link = $this_attachment.find('.attachment_link').val(),
							attachment_description = $this_attachment.find('.attachment_description').val();
						
						skyali_lt_shortcode_text += '[skyali_lt_attachment attachment_id="' + attachment_id + '" link="' + attachment_link + '"]' + attachment_description + '[/skyali_lt_attachment]';
					} );
				} else if ( this_option_id == 'skyali_tabs' ){
					var $current_option = $(this);
					
					advanced_option = true;
					skyali_lt_shortcode_text += ']';

					$current_option.find('.skyali_tab').each( function(){
						var $this_tab = $(this),
							tab_title = $this_tab.find('.skyali_tab_title').val(),
							tab_editor_id = $this_tab.find('textarea.skyali_wp_editor').attr('id'),
							tab_content;
						
						if ( typeof tinyMCE !== "undefined" ){						
							tab_content = $this_tab.is(':hidden') ? tinyMCE.get( tab_editor_id ).getContent() : switchEditors.wpautop( tinymce.DOM.get( tab_editor_id ).value );
							
							tinyMCE.execCommand("mceRemoveControl", false, tab_editor_id);
						} else {
							tab_content = $('#' + tab_editor_id).val();
						}
						
						if ( $current_option.parent('#skyali_slides_interface').length ) skyali_lt_shortcode_text += '[skyali_simple_slide]' + tab_content + '[/skyali_simple_slide]';
						else skyali_lt_shortcode_text += '[skyali_tab title="' + tab_title + '"]' + tab_content + '[/skyali_tab]';
					} );
				}
				else {
				
					if ( $(this).hasClass('skyali_wp_editor') ){
						if ( typeof tinyMCE !== "undefined" ){
							skyali_lt_option_value = $(this).is(':hidden') ? tinyMCE.get( this_option_id ).getContent() : switchEditors.wpautop( tinymce.DOM.get( this_option_id ).value );
							tinyMCE.execCommand("mceRemoveControl", false, this_option_id);
						} else {
							skyali_lt_option_value = $('#' + this_option_id).val();
						}
					}
					else if ( $(this).is(':checkbox') ){
						skyali_lt_option_value = ( $(this).is(':checked') ) ? 1 : 0;
					}
					else if ( $(this).is('select, input') ) {
						skyali_lt_option_value = $(this).val();
					}
					
					if ( $(this).hasClass('skyali_module_content') ) {
						skyali_lt_shortcode_content = skyali_lt_option_value;
					} else {
						skyali_lt_shortcode_text += ' ' + shortcode_option_id + '="' + skyali_lt_option_value + '"';
					}
					
				}
			} );
			
			if ( ! advanced_option ) skyali_lt_shortcode_text += ']' + skyali_lt_shortcode_content + '[/' + skyali_lt_current_module_name + ']';
			else skyali_lt_shortcode_text += '[/' + skyali_lt_current_module_name + ']';
			
			if ( typeof tinyMCE !== "undefined" ){
				switchEditors.go(editor_id,'tmce');
				tinyMCE.getInstanceById( editor_id ).execCommand("mceInsertContent", false, skyali_lt_shortcode_text);
			} else {
				$current_textarea 		= $('#skyali_lt_module_settings ' + '#' + editor_id);
				current_textarea_value 	= $current_textarea.val();
				$current_textarea.val( current_textarea_value + skyali_lt_shortcode_text );
			}
			
			skyali_lt_close_modal_window();
			
			return false;
		} );
		
		$( 'body' ).delegate( 'a.skyali_delete_attachment', 'click', function(){
			$(this).closest('.skyali_lt_attachment').remove();
			return false;
		} );
		
		$skyali_lt_builder_add_links.click( function(){
			var $skyali_lt_clicked_link = $(this),
				$skyali_lt_modules_container = $('#skyali_modules'),
				open_modules_window = false;
			
			if ( $skyali_lt_clicked_link.hasClass('skyali_lt_active') ) return false;
			
			$skyali_lt_modules_container.find('.skyali_lt_module').css( { 'opacity' : 0, 'display' : 'none' } );
			
			if ( $skyali_lt_clicked_link.hasClass('skyali_lt_add_module') )
				$skyali_lt_modules_container.find('.skyali_lt_module:not(.skyali_m_column, .skyali_sample_layout)').css({'display':'inline-block', 'opacity' : 0}).animate( { 'opacity' : 1 }, 500 );
			else if ( $skyali_lt_clicked_link.hasClass('skyali_lt_add_sample_layout') )
				$skyali_lt_modules_container.find('.skyali_lt_module.skyali_sample_layout').css({'display':'inline-block', 'opacity' : 0}).animate( { 'opacity' : 1 }, 500 );
			else
				$skyali_lt_modules_container.find('.skyali_lt_module.skyali_m_column').css({'display':'inline-block', 'opacity' : 0}).animate( { 'opacity' : 1 }, 500 );
				
			if ( $skyali_lt_modules_container.is(':hidden') || open_modules_window ) {
				$skyali_lt_modules_container.slideDown(700);
			}
				
			$skyali_lt_builder_add_links.removeClass('skyali_lt_active');
			$skyali_lt_clicked_link.addClass('skyali_lt_active');
			
			return false;
		} );
		
		(function et_integrate_media_uploader(){
			var skyali_lt_fileInput = false,
				change_image = false,
				upload_field = false,
				$upload_field_input = null,
				et_upload_field_name = '',
				skyali_lt_tb_interval;
				
			$( 'body' ).delegate( 'a#skyali_add_slider_images', 'click', function(){
				skyali_lt_fileInput = true;
				
				skyali_lt_tb_interval = setInterval( function() { 
					$('#TB_iframeContent').contents().find('.savesend .button').val('Insert Into Slider');
				}, 2000 );
				
				tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
				return false;
			});
			
			$( 'body' ).delegate( 'a.skyali_change_attachment_image', 'click', function(){
				skyali_lt_fileInput = true;
				change_image = true;
				
				$(this).closest('.skyali_lt_attachment').addClass('active');
				
				skyali_lt_tb_interval = setInterval( function() { 
					$('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image');
				}, 2000 );
				
				tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
				return false;
			});
			
			$( 'body' ).delegate( 'a.skyali_upload_button', 'click', function(){
				skyali_lt_fileInput = true;
				upload_field = true;
				
				$upload_field_input = $(this).siblings('.skyali_upload_field');
				
				skyali_lt_tb_interval = setInterval( function() { 
					$('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image');
				}, 2000 );
				
				tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
				return false;
			});
			
			window.skyali_lt_original_send_to_editor = window.send_to_editor;
			window.send_to_editor = function(html){
				var skyali_lt_attachment_class;
				
				if ( skyali_lt_fileInput ) {
					clearInterval(skyali_lt_tb_interval);
					skyali_lt_attachment_class = $( 'img', html ).attr('class');
					skyali_lt_change_image = ( change_image ) ? 1 : 0;
					skyali_lt_data_type = ( change_image ) ? 'json' : 'html';
					
					tb_remove();
					skyali_init_sortable_attachments();
					
					$.ajax({
						type: "POST",
						url: skyali_options.ajaxurl,
						dataType: skyali_lt_data_type,
						data:
						{
							action : 'skyali_add_slider_item',
							skyali_lt_load_nonce : skyali_options.skyali_lt_load_nonce,
							skyali_lt_attachment_class : skyali_lt_attachment_class,
							skyali_lt_change_image : skyali_lt_change_image
						},
						success: function( data ){
							if ( change_image )	{
								var $active_attachment = $('.skyali_lt_attachment.active').removeClass('active');
									
								attachment_settings = data;
								
								$active_attachment.attr( 'data-attachment', attachment_settings['attachment_id'] ).find('img').remove();
								$active_attachment.prepend( attachment_settings['attachment_image'] );
								
								change_image = false;
							}
							else if ( upload_field ){
								$upload_field_input.val( $(html).find('img').attr('src') );
								upload_field = false;
							}
							else {
								$('#skyali_slides:visible').append( data );
							}
						}
					});
					
					skyali_lt_fileInput = false;
				} else {
					window.skyali_lt_original_send_to_editor( html );
				}
			}
		})();
		
		$( 'body' ).delegate( 'a#skyali_add_tab', 'click', function(){
			var element_name = 1 == $(this).parent('#skyali_slides_interface').length ? 'slides' : 'tabs',
				$skyali_tabs = $(this).closest('#skyali_'+element_name+'_interface').find('#skyali_tabs'),
				next_element = parseInt( $skyali_tabs.attr('data-elements') ) + 1;
				
			$skyali_tabs.attr('data-elements',next_element);
			
			skyali_lt_init_sortable_tabs();
			$.ajax({
				type: "POST",
				url: skyali_options.ajaxurl,
				data:
				{
					action : 'skyali_add_'+element_name+'_item',
					skyali_lt_load_nonce : skyali_options.skyali_lt_load_nonce,
					skyali_tabs_length : next_element
				},
				success: function( data ){
					var tab_editor_id = $(data).find('.skyali_wp_editor').attr('id');
					
					$('#skyali_tabs:visible').append( data );
					
					if ( typeof tinyMCE !== "undefined" ){
						tinyMCE.execCommand( "mceAddControl", true, tab_editor_id );
						quicktags( { id : tab_editor_id } );
						skyali_lt_init_new_editor( tab_editor_id );
					}
					
					skyali_lt_track_active_editor();
				}
			});
			
			return false;
		});
		
		$( 'body' ).delegate( 'a.skyali_delete_tab', 'click', function(){
			var $skyali_tab_active = $(this).closest('.skyali_tab');
			
			if ( typeof tinyMCE !== "undefined" ){
				tinyMCE.execCommand( "mceRemoveControl", true, $skyali_tab_active.find('.skyali_wp_editor').attr('id') );
			}
			
			$skyali_tab_active.remove();
			
			return false;
		});
		
		$('#skyali_main_save').click(function(){
			skyali_lt_layout_save( true );
			return false;
		});
		
		function skyali_lt_layout_save( show_save_message ){
			var layout_html = $('#skyali_lt_layout').html(),
				layout_shortcode = skyali_generate_layout_shortcode( $('#skyali_lt_layout') ),
				$save_message = jQuery("#skyali_ajax_save");
			
			$.ajax({
				type: "POST",
				url: skyali_options.ajaxurl,
				data:
				{
					action : 'skyali_save_layout',
					skyali_lt_load_nonce : skyali_options.skyali_lt_load_nonce,
					skyali_lt_layout_html : layout_html,
					skyali_lt_layout_shortcode : layout_shortcode,
					skyali_post_id : $('input#post_ID').val()
				},
				beforeSend: function ( xhr ){
					if ( show_save_message ){
						$save_message.children("img").css("display","block");
						$save_message.children("span").css("margin","6px 0px 0px 30px").html( skyali_options.saving_text );
						$save_message.fadeIn('fast');
					}
				},
				success: function( data ){
					$save_message.children("img").css("display","none");
					$save_message.children("span").css("margin","0px").html( skyali_options.saved_text );
					
					setTimeout(function(){
						$save_message.fadeOut("slow");
					},500);
				}
			});
		}
		
		//make sure the hidden WordPress Editor is in Visual mode
		//switchEditors.go('skyali_hidden_editor','tmce');
		
		(function skyali_lt_init_ui(){
			$( '#skyali_lt_layout' ).droppable({
				accept: ":not(.ui-sortable-helper)",
				greedy: true,
				drop: function( event, ui ) {
					if ( ui.draggable.hasClass('skyali_sample_layout') ){
						skyali_append_sample_layout( ui.draggable );
						return;
					}
					ui.draggable.clone().appendTo( this );
					skyali_lt_init_modules_js( 0 );
				}
			}).sortable({
				forcePlaceholderSize: true,
				placeholder: 'skyali_lt_module_placeholder',
				cursor: 'move',
				distance: 2,
				start: function(event, ui) {
					ui.placeholder.text( ui.item.attr('data-placeholder') );
					ui.placeholder.css( 'width', ui.item.width() );
				},
				update: function(event, ui){
					skyali_lt_init_modules_js( 0 );
				},
				stop: function(event, ui) {
					skyali_lt_layout_save( false );
				}
			});
			
			$( '#skyali_modules .skyali_lt_module' ).draggable({
				revert: 'invalid',
				zIndex: 100,
				distance: 2,
				cursor: 'move',
				helper: 'clone'
			});
		})();
		
		$( '#skyali_lt_layout .skyali_lt_module .ui-resizable-handle' ).remove();
		skyali_lt_init_modules_js( 1 );
		
		// resizable and sortable init
		function skyali_lt_init_modules_js( skyali_lt_first_time ){
			var $skyali_lt_helper_text = $('#skyali_helper');
			
			// remove 'resizable' handler from 'full width' modules
			$( '#skyali_lt_layout > .skyali_lt_module.et_full_width .skyali_move' ).remove();
			
			$( '#skyali_lt_layout > .skyali_m_column' ).each( function(){
				$(this).removeClass('skyali_m_column_no_modules');
				if ( ! $(this).find('.skyali_lt_module').length ) $(this).addClass('skyali_m_column_no_modules');
			} );
			
			$( '#skyali_lt_layout > .skyali_lt_module:not(.et_full_width)' ).resizable({
				handles: 'e',
				containment: 'parent',
				start: function(event, ui) {
					ui.helper.css({position: ""}); // firefox fix
					
					ui.helper.css({
						position: "relative !important",
						top: "0 !important",
						left: "0 !important"
					});
				},
				stop: function(event, ui) {        
					ui.helper.css({
						position: "",
						top: "",
						left: ""
					});
					skyali_lt_calculate_modules();
				},
				resize: function(event, ui) {
					var module_width = ui.helper.hasClass('skyali_m_column_resizable') ? ( ui.size.width+26 ) : (ui.size.width+2),
						new_width = Math.floor( ( module_width / skyali_lt_builder_width ) * 100 ),
						$module_width = ui.helper.find('> span.skyali_lt_module_name > span.skyali_lt_module_width');
					
					ui.helper.css({
						top: "",
						left: ""
					});
					
					if ( new_width >= 100 ) new_width = '';
					else new_width = ' (' + new_width + '%)';
					
					if ( $module_width.length ){
						$module_width.html( new_width );
					} else {
						ui.helper.find('> span.skyali_lt_module_name').append('<span class="skyali_lt_module_width">' + new_width + '</span>')
					}
					
					if ( ui.helper.hasClass('skyali_m_column_resizable') ) ui.helper.css('height','auto');
				}
			});
			
			$( '#skyali_lt_layout .skyali_m_column' ).droppable({
				accept: ".skyali_lt_module:not(.skyali_m_column,.et_full_width,.skyali_sample_layout)",
				hoverClass: 'et_column_active',
				greedy: true,
				drop: function( event, ui ) {
					// return if we're moving modules inside the column
					if ( ui.draggable.parents('.skyali_m_column').length && $(this).find('.ui-sortable-helper').length ) return;
					
					ui.draggable.clone().appendTo( this ).css( { 'width' : '100%', 'marginRight' : '0' } ).find('span.skyali_lt_module_width').remove();
					
					if ( ui.draggable.parents('#skyali_lt_layout').length ){
						ui.draggable.remove();
					}
					
					skyali_lt_init_modules_js( 0 );
				}
			}).sortable({
				forcePlaceholderSize: true,
				cancel: 'span.et_column_name',
				placeholder: 'skyali_lt_module_placeholder',
				cursor: 'move',
				distance: 2,
				connectWith: '#skyali_lt_layout',
				zIndex: 10,
				start: function(event, ui) {
					ui.placeholder.text( ui.item.attr('data-placeholder') );
					ui.placeholder.css( 'width', ui.item.width() );
					ui.item.closest('.skyali_m_column').css( 'z-index', '10' );
				},
				stop: function(event, ui) {
					$( '#skyali_lt_layout .skyali_m_column' ).css( 'z-index', '1' );
					
					skyali_lt_layout_save( false );
				}
			});
			
			if ( $( '#skyali_lt_layout > .skyali_lt_module' ).length ) $skyali_lt_helper_text.hide();
			else $skyali_lt_helper_text.show();
			
			// columns and modules within columns can't be resized
			$( '#skyali_lt_layout .skyali_m_column:not(.skyali_m_column_resizable)' ).resizable( "destroy" );
			
			$( '#skyali_lt_layout .skyali_m_column > span.skyali_move' ).remove();
			
			$( '#skyali_lt_layout .skyali_lt_module' ).css( { 'position' : '', 'top' : '', 'left' : '', 'height' : 'auto !important', 'z-index' : '1' } ).removeClass('ui-sortable-helper').removeClass('et_column_active');
			
			// don't calculate modules width first time, the function was executed already in the skyali_lt_layout_window_resize function
			if ( skyali_lt_first_time != 1 ) skyali_lt_calculate_modules();
			
			if ( typeof tinyMCE === "undefined" ) $('body').addClass( 'skyali_lt_visual_editor_disabled' );
		}
		
		function skyali_lt_calculate_modules(){
			var skyali_lt_row_width = 0;
			
			$( '#skyali_lt_layout > .skyali_lt_module' ).each( function(){
				var $module_width_span = $(this).find('> span.skyali_lt_module_name > span.skyali_lt_module_width'),
					skyali_lt_modifier = $(this).hasClass('skyali_m_column_resizable') ? 26 : 2;
				
				if ( ! $(this).hasClass('skyali_m_column') || $(this).hasClass('skyali_m_column_resizable') ){
					if ( $module_width_span.length && $module_width_span.text() !== '' ) $(this).css( 'width', skyali_lt_builder_width * parseInt( $module_width_span.text().substring(2) ) / 100 - skyali_lt_modifier );
					else {
						if ( $(this).hasClass('skyali_m_column_resizable') ) $(this).css( 'width', skyali_lt_main_module_width - skyali_lt_modifier );
						else $(this).css( 'width', skyali_lt_main_module_width );
					}
				}
			} );
			
			$( '#skyali_lt_layout > .skyali_lt_module' ).removeClass('skyali_lt_first').each( function(index){
				if ( index === 0 || skyali_lt_row_width === 0 ) $(this).addClass('skyali_lt_first');
				
				skyali_lt_row_width += $(this).outerWidth(true);
				
				if ( skyali_lt_row_width === skyali_lt_builder_width ){
					$(this).next('.skyali_lt_module').addClass('skyali_lt_first');
					skyali_lt_row_width = 0;
				} else if ( skyali_lt_row_width > skyali_lt_builder_width ){
					$(this).addClass('skyali_lt_first');
					skyali_lt_row_width = $(this).outerWidth(true);
				}
			} );
			
			$( '#skyali_lt_layout > .skyali_lt_module.skyali_lt_first' ).each( function(){
				var skyali_lt_modifier = $(this).hasClass('skyali_m_column_resizable') ? 26 : 2,
					module_width = $(this).width(),
					$module_width_span = $(this).find('> span.skyali_lt_module_name > span.skyali_lt_module_width');
				
				if ( $module_width_span.length && $module_width_span.text() !== '' ) {
					$module_width_span.text( ' (' + Math.round( ( ( module_width + skyali_lt_modifier ) / skyali_lt_builder_width ) * 100 ) + '%)' );
				}
			} );	
		}
		
		function skyali_append_sample_layout( $layout_module ){
			$.ajax({
				type: "POST",
				url: skyali_options.ajaxurl,
				data:
				{
					action : 'skyali_append_layout',
					skyali_lt_load_nonce : skyali_options.skyali_lt_load_nonce,
					skyali_lt_layout_name : $layout_module.attr('data-name')
				},
				success: function( data ){
					$( '#skyali_lt_layout' ).append( data );
					$( '#skyali_lt_layout .skyali_lt_module .ui-resizable-handle' ).remove();
					skyali_lt_init_modules_js( 0 );
				}
			});
		}
		
		function skyali_lt_deactivate_ui_actions(){
			$( '#skyali_lt_layout' ).droppable( "disable" ).sortable( "disable" );
			
			$( '#skyali_lt_layout .skyali_m_column' ).droppable( "disable" ).sortable( "disable" );
			
			$( '#skyali_lt_layout > .skyali_lt_module span.skyali_move, #skyali_lt_layout > .skyali_lt_module span.skyali_lt_delete, #skyali_lt_layout > .skyali_lt_module span.skyali_settings_arrow' ).css( 'display', 'none' );
			
			skyali_lt_make_editor_droppable();
		}
		
		function skyali_lt_reactivate_ui_actions(){
			$( '#skyali_lt_layout' ).droppable( "enable" ).sortable( "enable" );

			$( '#skyali_lt_layout .skyali_m_column' ).droppable( "enable" ).sortable( "enable" );
			
			$( '#skyali_lt_layout > .skyali_lt_module span.skyali_move, #skyali_lt_layout > .skyali_lt_module span.skyali_lt_delete, #skyali_lt_layout > .skyali_lt_module span.skyali_settings_arrow' ).css( 'display', 'block' );
		}
		
		function skyali_lt_make_editor_droppable(){
			$( '.wp-editor-container' ).droppable({
				accept: ".skyali_lt_module",
				hoverClass: 'skyali_editor_hover',
				greedy: true,
				drop: function( event, ui ) {
					var skyali_lt_paste_to_editor_id = $(this).find('.skyali_wp_editor').attr('id'),
						skyali_lt_action = 'skyali_show_module_options';
					
					// don't allow inserting module into the same module 
					if ( $('#skyali_lt_layout .skyali_lt_active').attr('data-placeholder') == ui.draggable.attr('data-placeholder') ) return;
					if ( ui.draggable.hasClass('skyali_sample_layout') ) return;
					
					if ( ui.draggable.hasClass('skyali_m_column') ) skyali_lt_action = 'skyali_show_column_options';
					
					$.ajax({
						type: "POST",
						url: skyali_options.ajaxurl,
						data:
						{
							action : skyali_lt_action,
							skyali_lt_load_nonce : skyali_options.skyali_lt_load_nonce,
							skyali_lt_module_class : ui.draggable.attr('class'),
							skyali_lt_modal_window : 1,
							skyali_lt_paste_to_editor_id : skyali_lt_paste_to_editor_id,
							skyali_lt_module_exact_name : ui.draggable.attr('data-placeholder')
						},
						success: function( data ){
							$('body').append( '<div id="skyali_dialog_modal">' + '<div class="skyali_dialog_handle">Insert Shortcode</div>' + data + '</div> <div class="skyali_lt_modal_blocker"></div>' );
							
							$('#skyali_dialog_modal').draggable( { 'handle' : 'div.skyali_dialog_handle' } );
							
							$( '#skyali_dialog_settings .skyali_option' ).each( function(){
								var $this_option = $(this),
									this_option_id = $this_option.attr('id');
								
								if ( $this_option.hasClass('skyali_wp_editor') && typeof tinyMCE !== "undefined" ) {
									tinyMCE.execCommand( "mceAddControl", true, this_option_id );
									quicktags( { id : this_option_id } );
									skyali_lt_init_new_editor( this_option_id );
								}
							} );
							
							$('html:not(:animated),body:not(:animated)').animate({ scrollTop: 0 }, 500);
							
							skyali_lt_track_active_editor();
						}
					});
				}
			});
		}
		
		function skyali_lt_close_modal_window(){
			$( 'div#skyali_dialog_modal, div.skyali_lt_modal_blocker' ).remove();
			$('html:not(:animated),body:not(:animated)').animate({ scrollTop: $('#skyali_lt_page_builder').offset().top - 82 }, 500);
		}
		
		function skyali_init_sortable_attachments(){
			$('#skyali_slides').sortable({
				forcePlaceholderSize: true,
				cursor: 'move',
				distance: 2,
				zIndex: 10
			});
		}
		
		function skyali_lt_init_sortable_tabs(){
			$('#skyali_tabs, #skyali_slides').sortable({
				forcePlaceholderSize: true,
				cursor: 'move',
				distance: 2,
				zIndex: 10,
				start: function(e, ui){
					$(this).find('.skyali_wp_editor').each(function(){
						if ( typeof tinyMCE !== "undefined" ) tinyMCE.execCommand( 'mceRemoveControl', false, $(this).attr('id') );
					});
				},
				stop: function(e,ui) {
					$(this).find('.skyali_wp_editor').each(function(){
						if ( typeof tinyMCE !== "undefined" ){
							tinyMCE.execCommand( 'mceAddControl', false, $(this).attr('id') );
							tinyMCE.execCommand( 'mceSetContent', false, switchEditors.wpautop( $(this).val() ) );
							//$(this).sortable("refresh");
						}
					});
				}
			});
		}
		
		function skyali_lt_init_new_editor(editor_id){
			if ( typeof tinyMCEPreInit.mceInit[editor_id] !== "undefined" ) return;
			var skyali_lt_new_editor_object = et_hidden_editor_object;
			
			skyali_lt_new_editor_object['elements'] = editor_id;
			tinyMCEPreInit.mceInit[editor_id] = skyali_lt_new_editor_object;
		}
		
		function skyali_delete_module( $module ){
			$module.remove();
			skyali_lt_init_modules_js( 0 );
			
			// save changes after the element is removed
			skyali_lt_layout_save( false );
		}
		
		function skyali_generate_layout_shortcode( html_element ){
			var shortcode_output = '';
			
			html_element.find( '> .skyali_lt_module' ).each( function(){
				var $this_module = $(this),
					$this_module_width = $this_module.find('> .skyali_lt_module_name > .skyali_lt_module_width'),
					module_name = 'skyali_' + $this_module.attr('data-name'),
					module_content = '';
				
				shortcode_output += '[' + module_name;
				
				if ( $this_module_width.length && $this_module_width.text() !== '' ) shortcode_output += ' width="' + parseInt( $this_module_width.text().replace(/[()]/,'') ) + '"';
				if ( $this_module.hasClass('skyali_lt_first') ) shortcode_output += ' first_class="1"';
				
				if ( $this_module.hasClass('skyali_m_column') ){
					shortcode_output += ']' + '\n';
					shortcode_output += skyali_generate_layout_shortcode( $this_module );
				} else {
					$this_module.find('> .skyali_lt_module_settings .skyali_lt_module_setting').each( function(){
						var $this_option = $(this),
							option_name = $this_option.attr('data-option_name'),
							option_value = $this_option.html();
						
						if ( option_name == 'skyali_slides' ){
							shortcode_output += ']';
							$this_option.find('.skyali_lt_attachment').each( function(){
								var $this_attachment = $(this),
									attachment_id = $this_attachment.attr('data-attachment'),
									attachment_link = $this_attachment.find('.attachment_link').val(),
									attachment_description = $this_attachment.find('.attachment_description').html();
								
								shortcode_output += '[skyali_lt_attachment attachment_id="' + attachment_id + '" link="' + attachment_link + '"]' + attachment_description + '[/skyali_lt_attachment]';
							} );
						} else if ( option_name == 'skyali_tabs' ){
							shortcode_output += ']';
							$this_option.find('.skyali_tab').each( function(){
								var $this_tab = $(this),
									tab_title = $this_tab.find('.skyali_tab_title').val(),
									tab_content = $this_tab.find('.wp-editor-wrap').html();
								
								if ( $this_option.closest('.skyali_lt_module').hasClass('skyali_m_simple_slider') ){
									shortcode_output += '[skyali_simple_slide]' + tab_content + '[/skyali_simple_slide]';
								} else {
									shortcode_output += '[skyali_tab title="' + tab_title + '"]' + tab_content + '[/skyali_tab]';
								}
							} );
						}
						else {
							if ( $this_option.hasClass('skyali_module_content') ){
								module_content = option_value;
							} else {
								shortcode_output += ' ' + option_name + '="' + option_value + '"';
							}
						}
					} );
					
					if ( ! ( shortcode_output.charAt(shortcode_output.length-1) === ']' ) ) shortcode_output += ']';
				}
				
				shortcode_output += module_content + '[/' + module_name + ']' + '\n';
			} );
			
			return shortcode_output;
		}
		
		function skyali_lt_track_active_editor(){
			// change the active editor, when user clicks on new editors, created via ajax
			jQuery('.wp-editor-wrap').mousedown(function(e){
				wpActiveEditor = this.id.slice(3, -5);
			});
		}
		
		
		skyali_lt_layout_window_resize();
		
		function skyali_lt_layout_window_resize(){
			var $_skyali_lt_page_builder = $('#skyali_lt_page_builder')
				_window_width = $(window).width(),
				_new_page_builder_width = 0,
				_block_width_difference = 0;
			
			if ( _window_width > 1260 ) _new_page_builder_width = skyali_lt_page_builder_original_width;
			else if ( _window_width <= 1260 && _window_width > 900 ) _new_page_builder_width = skyali_lt_page_builder_original_width - ( 1260 - _window_width );
			else if ( _window_width <= 900 && _window_width > 850 ) _new_page_builder_width = skyali_lt_page_builder_original_width - ( 1260 - _window_width ) + 113;
			else _new_page_builder_width = skyali_lt_page_builder_original_width - ( 1260 - _window_width ) + 113 + 305;
			
			$_skyali_lt_page_builder.width( _new_page_builder_width );
			
			skyali_lt_builder_width = _new_page_builder_width - 42;
			
			skyali_lt_main_module_width = skyali_lt_builder_width - 2;
			
			if ( _window_width < 1260 ){
				_block_width_difference = _new_page_builder_width - _window_width;
			}
			
			skyali_lt_calculate_modules();
		}
		
		$(window).resize( function(){
			skyali_lt_layout_window_resize();
		} );
	});
})(jQuery)