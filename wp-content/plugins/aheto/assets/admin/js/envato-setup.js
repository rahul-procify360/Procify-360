
var EnvatoWizard = (function($){

	let t;
	let import_time = 0;
    let import_time_text = 0;
    let import_media_time = 0;
    let import_pages_time = 0;
    let import_menus_time = 0;

	$('a.button.refresh').on('click', function (e) {
		e.preventDefault();
		location.reload();
	});


    function check_import_time(){
        $('.aheto-import-theme-data--list .import-item-wrap input[value=on]').each(function () {
            if($(this).is(':checked')){
                import_time += $(this).data('time');
            }
        });
		
        $('.import-item-wrap[data-type="media"] input[data-time]').each(function () {
            import_media_time += +$(this).data('time');
		});
        let import_media_time_text = Math.round(import_media_time/60) < 1 ? Math.round(import_media_time) + ' secs' : Math.round(import_media_time/60) + ' min';
        $('.import-item-wrap[data-type="media"]').eq(0).find('.import-time').html(import_media_time_text).attr('data-time', import_media_time.toFixed(2));


        $('.import-item-wrap[data-type="menus"] input[data-time]').each(function () {
            import_menus_time += +$(this).data('time');
        });
        let import_menus_time_text = Math.round(import_menus_time/60) < 1 ? Math.round(import_menus_time) + ' secs' : Math.round(import_menus_time/60) + ' min';
        $('.import-item-wrap[data-type="menus"]').eq(0).find('.import-time').html(import_menus_time_text).attr('data-time', import_menus_time.toFixed(2));


        $('.import-item-wrap[data-type="pages"] input[data-time]').each(function () {
            import_pages_time += +$(this).data('time');
        });
        let import_pages_time_text = Math.round(import_pages_time/60) < 1 ? Math.round(import_pages_time) + ' secs' : Math.round(import_pages_time/60) + ' min';
        $('.import-item-wrap[data-type="pages"]').eq(0).find('.import-time').html(import_pages_time_text).attr('data-time', import_pages_time.toFixed(2));

        import_time_text = import_time > 60 ? Math.round(import_time/60) + ' min' : (Math.round(import_time) === 1 ? Math.round(import_time) + ' sec' : Math.round(import_time) + ' secs');

        $('.summary-time span').html(import_time_text);
    }


    function recheck_import_time(){
        $('.aheto-import-theme-data--list .import-item-wrap input').on('change', function () {

        	let parent = $(this).closest('.import-item-wrap');
        	let timeAll = parent.data('type') === 'default' ? false : parent.find('.import-time').attr('data-time');
            let time = 0;
            let type = parent.data('type');


            if($(this).is(':checked') && $(this).attr('value') === 'on'){
          		time = timeAll ? +timeAll : +$(this).data('time');
                import_time += +time;

                if(timeAll){
                    $('.aheto-import-theme-data--list .import-item-wrap[data-type="'+ type +'"] input[value="on"]').prop("checked", true);
				}

            }else{
                time = timeAll ? +timeAll : +$(this).closest('.radio-buttons').find('input[value=on][data-time]').data('time');
                import_time = import_time - +time;
                if(timeAll){
                    $('.aheto-import-theme-data--list .import-item-wrap[data-type="'+ type +'"] input[value="on"]').prop("checked", false);
                }
			}

            import_time_text = import_time > 60 ? Math.round(import_time/60) + ' min' : (Math.round(import_time) === 1 ? Math.round(import_time) + ' sec' : Math.round(import_time) + ' secs');

            $('.summary-time span').html(import_time_text);

        });
	}


	function importItemSwitch(){
        $('.import-item-wrap label').on('click', function (e) {

            let type = $(this).closest('.import-item-wrap').data('type');

            if($(this).attr('for').substr(-3) !== 'off'){
                $(this).closest('.import-item-wrap').addClass('checkes');
                if( type !== 'default'){
                    $('.import-item-wrap[data-type="'+ type +'"]').addClass('checkes');
                }
            }else{
                $(this).closest('.import-item-wrap').removeClass('checkes');
                if( type !== 'default'){
                    $('.import-item-wrap[data-type="'+ type +'"]').removeClass('checkes');
                }
            }
        });
	}


    $(window).on('load', function () {
        check_import_time();
        recheck_import_time();
        importItemSwitch();
    });


    $(function() {
		$('.custom-steps').hide();
    } );


	$('.custom-steps a.next').on('click', function () {

		$('.envato_default_content[data-directory]').hide();
		$('.custom-steps a.prev').show();
	});
	$('.custom-steps a.prev:not(.disable)').on('click', function () {
		$('.envato_default_content[data-directory]').hide();
	});

	$('.custom-steps a.prev.disable').on('click', function (e) {
		e.preventDefault();
	});

	// callbacks from form button clicks.
	var callbacks = {
		install_plugins: function(btn){
			var plugins = new PluginManager();
			plugins.init(btn);
		},
		install_content: function(btn){
			var content = new ContentManager();
			content.init(btn);
		}
	};

	function window_loaded(){
		// init button clicks:
		$('.button-next').on( 'click', function(e) {

			var loading_button = dtbaker_loading_button(this);
			if(!loading_button){
				return false;
			}
			if($(this).data('callback') && typeof callbacks[$(this).data('callback')] != 'undefined'){
				// we have to process a callback before continue with form submission
				callbacks[$(this).data('callback')](this);
				return false;
			}else{
				return true;
			}
		});
		$('.button-upload').on( 'click', function(e) {
			e.preventDefault();
			renderMediaUploader();
		});
	}

	function PluginManager(){

		var complete;
		var items_completed = 0;
		var current_item = '';
		var $current_node;
		var current_item_hash = '';

		function ajax_callback(response){


			if($current_node){
				if(!$current_node.data('done_item')){
					items_completed++;
					$current_node.data('done_item',1);
				}
				$current_node.find('.spinner').css('visibility','hidden');
			}

			if(typeof response == 'object' && typeof response.message != 'undefined'){
				$current_node.find('span').text(response.message);
				if(typeof response.url != 'undefined'){
					// we have an ajax url action to perform.

					if(response.hash == current_item_hash){
						$current_node.find('span').text("failed");
						find_next();
					}else {
						current_item_hash = response.hash;

						jQuery.post(response.url, response, function(response2) {
							process_current();

							$current_node.find('span').text(response.message + envato_setup_params.verify_text);
						}).fail(ajax_callback);
					}

				}else if(typeof response.done != 'undefined'){
					// finished processing this plugin, move onto next
					find_next();
				}else{
					// error processing this plugin
					find_next();
				}
			}else{
				// error - try again with next plugin
				var $items = $('tr.envato_default_content');

				if(items_completed < $items.length){
					$current_node.find('span').text("ajax error");
				} else {
					$current_node.find('span').text("Success");
				}
				find_next();

			}
		}
		function process_current(){
			if(current_item){
				// query our ajax handler to get the ajax to send to TGM
				// if we don't get a reply we can assume everything worked and continue onto the next one.
				jQuery.post(envato_setup_params.ajaxurl, {
					action: 'envato_setup_plugins',
					wpnonce: envato_setup_params.wpnonce,
					slug: current_item
				}, ajax_callback).fail(ajax_callback);
			}
		}
		function find_next(){
			var do_next = false;
			if($current_node){
				if(!$current_node.data('done_item')){
					items_completed++;
					$current_node.data('done_item',1);
				}
				$current_node.find('.spinner').css('visibility','hidden');
			}
			var $li = $('.aheto-required-plugins--list li');
			$li.each(function(){
				if(current_item == '' || do_next){
					current_item = $(this).data('slug');
					$current_node = $(this);
					process_current();
					do_next = false;
				}else if($(this).data('slug') == current_item){
					do_next = true;
				}
			});
			if(items_completed >= $li.length){
				// finished all plugins!
				complete();
			}
		}

		return {
			init: function(btn){
				$('.aheto-required-plugins--list').addClass('installing');
				complete = function(){
					window.location.href=btn.href;
				};
				find_next();
			}
		}
	}

	function ContentManager(){

		var complete;
		var items_completed = 0;
		var current_item = '';
		var file_url = '';
		var $current_node;
		var current_item_hash = '';

		function ajax_callback(response) {

			console.dir(response);

			if($current_node){
				if(!$current_node.data('done_item')){
					items_completed++;
					$current_node.data('done_item',1);
				}
				$current_node.find('.spinner').css('visibility','hidden');
			}

			if(typeof response == 'object' && typeof response.message != 'undefined'){
				$current_node.find('span').html('<i class="loader"></i>');
				if(typeof response.url != 'undefined'){
					// we have an ajax url action to perform.
					if(response.hash == current_item_hash){
						$current_node.find('span').text("failed");
						find_next();
					}else {

						current_item_hash = response.hash;
						jQuery.post(response.url, response, ajax_callback).fail(ajax_callback); // recuurrssionnnnn
					}
				}else if(typeof response.done != 'undefined'){
					// finished processing this plugin, move onto next
					let dataType = $current_node.data('type');

					if(dataType === 'default'){
                        $current_node.find('span').html('<i class="dashicons dashicons-yes"></i><b>Done</b>');
					}else{
                        let dataTypeAll = $('.import-item-wrap[data-type="'+ dataType +'"]').length;
						let lastTypeContent = $('.import-item-wrap[data-type="'+ dataType +'"]').eq(dataTypeAll - 1).data('content');

						if( $current_node.data('content') === lastTypeContent){
                            $('.import-item-wrap[data-type="'+ dataType +'"]:first-of-type span').html('<i class="dashicons dashicons-yes"></i><b>Done</b>');
						}
					}
					find_next();
				}else{
					// error processing this plugin
					find_next();
				}
			}else{
				// error - try again with next plugin
				var $items = $('tr.envato_default_content');
				if(items_completed < $items.length){
					$current_node.find('span').text("ajax error");
				} else {
					$current_node.find('span').html('<i class="dashicons dashicons-yes"></i><b>Done</b>');
				}
				find_next();
			}
		}

		function process_current(){

			if(current_item){
				var $check = $current_node.find('input[value="on"]');
				// var file_url =current_item
				var file_url = $current_node.attr('data-file_url');

				if($check.is(':checked')) {
					// process htis one!
					jQuery.post(envato_setup_params.ajaxurl, {
						action: 'envato_setup_content',
						wpnonce: envato_setup_params.wpnonce,
						// type:  getCookie('importType'),
						file_url: file_url,
						content: current_item
					}, ajax_callback).fail(ajax_callback);
				}else{
					$current_node.find('span').text("Skipping");
					setTimeout(find_next,300);
				}
			}
		}
		function find_next(){
			var do_next = false;
			if($current_node){
				if(!$current_node.data('done_item')){
					items_completed++;
					$current_node.data('done_item',1);
				}
				$current_node.find('.spinner').css('visibility','hidden');
			}

			// var $items = $('div.envato_default_content');
			var $items = $('.envato_default_content.import-item-wrap.checkes');
			// var $enabled_items = $('.item.active[data-checked="true"] li.envato_default_content input:checked');

			$items.each(function(){
				if (current_item == '' || do_next) {
					current_item = $(this).data('content');
					file_url = $(this).data('file_url');
					$current_node = $(this);
					process_current();
					do_next = false;
				} else if ($(this).data('content') == current_item) {
					do_next = true;
				}
			});
			if(items_completed >= $items.length){
				// finished all items!
				complete();
			}
		}

		return {
			init: function(btn){
				$('.aheto-import-theme-data').addClass('installing');
				$('.aheto-import-theme-data').find('input').prop("disabled", true);
				complete = function(){
					$(".install-text").text('Success').css('color', 'green').css('font-weight', 'bold');
					$(".button-next").text('Done');
					setInterval( window.location.href=btn.href, 16000);
				};
				find_next();
			}
		}
	}

	/**
	 * Callback function for the 'click' event of the 'Set Footer Image'
	 * anchor in its meta box.
	 *
	 * Displays the media uploader for selecting an image.
	 *
	 * @since 0.1.0
	 */
	function renderMediaUploader() {
		'use strict';

		var file_frame, attachment;

		if ( undefined !== file_frame ) {
			file_frame.open();
			return;
		}

		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Upload Logo',//jQuery( this ).data( 'uploader_title' ),
			button: {
				text: 'Select Logo' //jQuery( this ).data( 'uploader_button_text' )
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();

			jQuery('.site-logo').attr('src',attachment.url);
			jQuery('#new_logo_id').val(attachment.id);
			// Do something with attachment.id and/or attachment.url here
		});
		// Now display the actual file_frame
		file_frame.open();

	}

	function dtbaker_loading_button(btn){

		var $button = jQuery(btn);
		if($button.data('done-loading') == 'yes')return false;
		var existing_text = $button.text();
		var existing_width = $button.outerWidth();
		var loading_text = "..........----";
		var completed = false;

		$button.css('width',existing_width);
		$button.addClass('dtbaker_loading_button_current');
		var _modifier = $button.is('input') || $button.is('button') ? 'val' : 'text';
		$button[_modifier](loading_text);
		//$button.attr('disabled',true);
		$button.data('done-loading','yes');

		var anim_index = [0,1,2];

		// animate the text indent
		function moo() {
			if (completed)return;
			var current_text = '';
			// increase each index up to the loading length
			for(var i = 0; i < anim_index.length; i++){
				anim_index[i] = anim_index[i]+1;
				if(anim_index[i] >= loading_text.length)anim_index[i] = 0;
				current_text += loading_text.charAt(anim_index[i]);
			}
			$button[_modifier](current_text);
			setTimeout(function(){ moo();},60);
		}

		moo();

		return {
			done: function(){
				completed = true;
				$button[_modifier](existing_text);
				$button.removeClass('dtbaker_loading_button_current');
				$button.attr('disabled',false);
			}
		}

	}

	return {
		init: function(){
			t = this;
			$(window_loaded);
		},
		callback: function(func){

		}
	}

})(jQuery);


EnvatoWizard.init();
