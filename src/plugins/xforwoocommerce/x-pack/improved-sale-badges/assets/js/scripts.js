(function($){
"use strict";

	$(document).ajaxComplete( function() {
		isb_register();
	});

	$(document).on( 'change', 'input[name=variation_id]', function() {

		var currPrnt = $(this).closest('.type-product');

		currPrnt.find('.isb_variable').hide();

		if ( $(this).val() == '' ) {
			currPrnt.find('.isb_variable[data-id=0]').show();
		}
		else {
			currPrnt.find('.isb_variable[data-id='+$(this).val()+']').show();
		}

	});

	function isb_register() {

		$('.isb_variable_group:not(.isb_registered)').each( function() {

			$(this).addClass('isb_registered');

			var curr = $(this).closest('.type-product').find('input[name=variation_id]').val();

			if ( curr !== '' ) {
				$(this).find('.isb_variable[data-id='+curr+']').show();
			}
			else {
				$(this).find('.isb_variable[data-id=0]').show();
			}

		});

		$('.isb_scheduled_sale:not(.isb_registered)').each( function() {

			$(this).addClass('isb_registered');

			var curr = $(this).find('span.isb_scheduled_time');

			if ( curr.text() == '' ) {
				return;
			}

			var timestamp = curr.text() - isb.time;

			function component(x, v) {
				return Math.floor(x / v);
			}

			var $div = curr;

			function do_it() {
					timestamp--;

				var days    = component(timestamp, 24 * 60 * 60),
					hours   = component(timestamp,      60 * 60) % 24,
					minutes = component(timestamp,           60) % 60,
					seconds = component(timestamp,            1) % 60;

				if ( curr.hasClass('isb_scheduled_compact') ) {
					$div.html( ( days !== 0 ? days + '<span>'+isb.localization.d+'</span>' : '' ) + hours + ':' + minutes + ':' + seconds);
				}
				else {
					$div.html( ( days !== 0 ? days + ' '+isb.localization.days+', ' : '' ) + hours + ':' + minutes + ':' + seconds);
				}
				if ( days == 0 ) {
					curr.addClass('isb_no_date');
				}

			}
			do_it();
			setInterval(function() {
				do_it();
			}, 1000);

		});

	}

	isb_register();

})(jQuery);