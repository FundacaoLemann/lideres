(function($) {
  	"use strict";

  	function call_image_field() {
		// Function Upload Media
		$('.image-upload-button').click(function (e) {
			var el = $(this).parent();
			var button = $(this);
			e.preventDefault();
			var uploader = wp.media({
				title : button.data('upload-title'),
				button : {
					text : button.data('upload-button')
				},
				multiple : false
			})
			.on('select', function () {
				var selection = uploader.state().get('selection');
				var attachment = selection.first().toJSON();
				$('input[type=text]', el).val(attachment.url);
				$('input[type=hidden]', el).val(attachment.id).trigger('change');
				if (!el.hasClass('upload_file')) {
					if ($('img', el).length > 0) {
						$('.image-preview', el).attr('src', attachment.url);
					} else {
						$('<img src="'+ attachment.url +'" class="image-preview">').insertBefore($(':last-child', el));
						$('.image-clear-button', el).attr('style', 'display:inline-block');
					}
				}
			})
			.open();
		});
	}

	function call_video_field() {
		// Function Upload Media
		$('.video-upload-button').click(function (e) {
			var el = $(this).parent();
			var button = $(this);
			e.preventDefault();
			var uploader = wp.media({
				title : button.data('upload-title'),
				button : {
					text : button.data('upload-button')
				},
				multiple : false
			})
			.on('select', function () {
				var selection = uploader.state().get('selection');
				var attachment = selection.first().toJSON();
				$('input[type=text]', el).val(attachment.url);
				if (!el.hasClass('upload_file')) {
					$('.video-clear-button', el).attr('style', 'display:inline-block');
				}
			})
			.open();
		});
	}



  	// Document Ready
  	$(document).ready( function() {

	  	// Clear Buttons
	  	$('.image-clear-button').click( function (e) {
	  		$(this).siblings('input[type=text]').val(null);
	  		$(this).siblings('input[type=hidden]').val(null).trigger('change');
	  		$(this).siblings('.image-preview').remove();
	  		e.preventDefault();
	  	});

	  	// Clear Buttons
	  	$('.video-clear-button').click( function (e) {
	  		$(this).siblings('input[type=text]').val(null);
	  		e.preventDefault();
	  	});

	  	// Tabs
	  	//var tabber = new HashTabber();
	  	//tabber.run();



  		// Color Picker
  		$('.color-picker').wpColorPicker();

  		// Panels Height
  		var list_height = 100;
  		$('#class-settings-wrapper > ul > li[role*=tab]').each(function () {
  			list_height += $(this).outerHeight();
  		});

  		// Image Field
  		call_image_field();
  		call_video_field();



  	});

})(jQuery);


function rudrSwitchTab(rudr_tab_id, rudr_tab_content) {
  // first of all we get all tab content blocks (I think the best way to get them by class names)
  var x = document.getElementsByClassName("tabcontent");
  var i;
  for (i = 0; i < x.length; i++) {
    x[i].style.display = 'none'; // hide all tab content
  }
  document.getElementById(rudr_tab_content).style.display = 'block'; // display the content of the tab we need

  // now we get all tab menu items by class names (use the next code only if you need to highlight current tab)
  var x = document.getElementsByClassName("tabmenu");

  var i;
  for (i = 0; i < x.length; i++) {
    x[i].parentElement.className = '';
  }
  document.getElementById(rudr_tab_id).parentElement.className = 'active';
}
