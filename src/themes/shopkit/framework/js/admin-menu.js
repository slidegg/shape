(function($){

	"use strict";

	$(document).on('click', '.shopkit-menu-bg-upload' , function() {
		var $el = $(this);
		var upload = $el.prev().find("input"), frame;
		frame = wp.media({
			title: $el.data('choose'),
		button: {
				text: $el.data('update'),
				close: false
			}
		});
		frame.on( 'select', function() {
			var attachment = frame.state().get('selection').first();
			frame.close();

			upload.val(attachment.attributes.url);
		});
		frame.open();
	});

	function add_options() {
		var ids = [];
		var obj = $('#menu-to-edit > li.menu-item-depth-0:not(.shopkit-registered)');
		$.each( obj, function() {
			$(this).addClass('shopkit-registered');
			var id = $(this).attr('id').substr(10);
			ids.push(id);
		});

		if ( typeof ids[0] != 'undefined' ) {
			shopkit_ajax = 'active';

			$.when( shopkit_ajax_call( 'shopkit_menu_support', ids ) ).done( function(response) {

				if ( response != 0 ) {
					$.each( response, function(id, opt) {
						$('#menu-to-edit > li.menu-item-depth-0.shopkit-registered[id="menu-item-'+id+'"] .field-move').before(opt);
					});
				}

			});
		}

	}
	add_options();

	var shopkit_ajax = 'not_active';

	function shopkit_ajax_call( el_action, el_id ) {

		var ajax_data = {
			action: el_action,
			shopkit_menu: el_id
		};

		return $.post(shopkit.ajaxurl, ajax_data, function(response) {
			if (response) {
				shopkit_ajax = 'notactive';
			}
			else {
				alert('Error!');
				shopkit_ajax = 'notactive';
			}

		});

	}

	$(document).ajaxComplete( function(event, xhr, settings) {
		if ( typeof event.currentTarget.activeElement != 'undefined' && $(event.currentTarget.activeElement).is('.submit-add-to-menu') ) {
			add_options();
		}
	});

	$('#menu-to-edit').on( 'sortstop', function() {
		setTimeout( function() {
			var check = $('#menu-to-edit > li.shopkit-registered:not(.menu-item-depth-0)');
			$.each( check, function(){
				$(this).removeClass('shopkit-registered');
				$(this).find('.shopkit-menu-style, .shopkit-menu-bg, .shopkit-menu-bg-pos').remove();
			});
			add_options();
		}, 200 );
	});

})(jQuery);