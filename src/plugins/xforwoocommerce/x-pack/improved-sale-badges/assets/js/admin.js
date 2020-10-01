(function($){

	"use strict";

	if (!Element.prototype.matches) {
		Element.prototype.matches = Element.prototype.msMatchesSelector ||
		Element.prototype.webkitMatchesSelector;
	}

	var int;

	$(document).on( 'svx-fields-on-screen-improved_badges', function() {
		clearInterval(int);
		int = setInterval( function() {
			check_int();
		}, 250 );
	} );

	function check_int() {
		if ( $('.isb_preview').length > 0 ) {
			clearInterval(int);
			call_isb();
		}
		else if ( $('.svx-option-wrapper').length>0 ) {
			clearInterval(int);
		}
		
	}

	$(document).on( 'change', '#svx-settings-wrapper', function(e) {
		if ( e.target && e.target.matches('.svx-change') ) {
			if ( $('#wcmn_isb_presets-list').length>0 || $('#wc_settings_isb_preview-option').length>0 ) {
				call_isb();
			}
		}
	} );


	function call_isb() {

		$('.isb_preview').each( function(i,e) {
			e = $(e);
			if ( e.closest('.svx-option-list-item').length>0 ) {
				var s = e.closest('.svx-option-list-item');
			}
			else {
				var s = $('#svx-settings-wrapper');
			}

			var p = [];
			s.find('select,textarea').each( function(n,m) {
				p.push($(m).val());
			} );

			var data = {
				action: 'isb_respond',
				data: {
					'isb_style': p[0],
					'isb_color': p[1],
					'isb_position': p[2],
					'isb_special': p[3],
					'isb_special_text': p[4]
				}
			};

			$.when( call_ajax( data ) ).done( function(response) {
				$('#isb-preview-wrap').remove();
				e.after('<div id="isb-preview-wrap" class="isb-preview-wrap">'+response+'</div>');
			});

			return false;

		} );

	}

	function call_ajax(data) {
		return $.ajax({
			type: 'POST',
			url: isb.ajax,
			data: data,
			success: function(response) {

			},
			error: function() {
				alert('Error!');
			}
		});
	}

	function u(e) {
		return typeof e == 'undefined' ? false : e;
	}

	$(document).on( 'svx-wcmn_isb_overrides-load', function(e,f) {

		svx.settings['_wcmn_featured_badge'].val = u(f.val.featured)!==false?f.val.featured:'';

		if ( u(f.val.new) ) {
			svx.settings['_wcmn_expire_in'].val = u(f.val.new.days)!==false?f.val.new.days:'';
			svx.settings['_wcmn_expire_in_preset'].val = u(f.val.new.preset)!==false?f.val.new.preset:'';
		}
		else {
			svx.settings['_wcmn_expire_in'].val = '';
			svx.settings['_wcmn_expire_in_preset'].val = '';
		}

		svx.settings['_wcmn_tags'].val = [];
		svx.settings['_wcmn_categories'].val = [];

		var c=0;
		$.each( f.val.product_tag, function(i,g) {
			svx.settings['_wcmn_tags'].val[c] = {
				name:u(g.name)!==false?g.name:'Not set',
				term:u(g.term)!==false?g.term:i,
				preset:u(g.preset)!==false?g.preset:g,
			}
			c++;
		} );

		c=0;
		$.each( f.val.product_cat, function(i,g) {
			svx.settings['_wcmn_categories'].val[typeof g.order!=='undefined'?g.order:c] = {
				name:u(g.name)!==false?g.name:g,
				term:u(g.term)!==false?g.term:i,
				preset:u(g.preset)!==false?g.preset:g,
			}
			c++;
		} );

	} );

	function check_preset(e) {
		var t = false;
		if ( u(svx.settings.wcmn_isb_presets.val) ) {
			$.each( svx.settings.wcmn_isb_presets.val, function(i,f) {
				if ( u(f.name) && e == sanitize_title(f.name) ) {
					t = e;
				}
			} );
		}
		return t;

	}

	$(document).on( 'svx-wcmn_isb_overrides-save', function(e,f) {

		var r = {};
		svx.skips = [];

		svx.skips.push('_wcmn_featured_badge');
		svx.skips.push('_wcmn_expire_in');
		svx.skips.push('_wcmn_expire_in_preset');
		svx.skips.push('_wcmn_tags');
		svx.skips.push('_wcmn_categories');

		r.featured = check_preset(svx.settings['_wcmn_featured_badge'].val);
		r.new = {};
		r.new.days = svx.settings['_wcmn_expire_in'].val;
		r.new.preset = check_preset(svx.settings['_wcmn_expire_in_preset'].val);

		r.product_tag = {};
		r.product_cat = {};

		var c=0;
		$.each( svx.settings['_wcmn_tags'].val, function(i,g) {
			r.product_tag[c] = {
				name:u(g.name)?g.name:'Not set',
				term:u(g.term),
				preset:u(g.preset)?check_preset(g.preset):false,
				order:c
			}
			c++;
		} );

		var c=0;
		$.each( svx.settings['_wcmn_categories'].val, function(i,g) {
			r.product_cat[u(g.term)] = {
				name:u(g.name)?g.name:'Not set',
				term:u(g.term),
				preset:u(g.preset)?check_preset(g.preset):false,
				order:c
			}
			c++;
		} );

		f.save_val = r;

	} );

	$(document).on( 'svx-wcmn_isb_presets-load', function(e,f) {

		var r = [];
		var w = {};

		var c=0;
		$.each( f.val, function(i,b) {

			r[c] = {
				name:u(b)
			};

			w[i] = u(b);

			c++;

		});

		f.val = r;
		svx.presets = w;

	} );

	$(document).on( 'svx-wcmn_isb_presets-save', function(e,f) {

		var r = {};
		svx.solids = {};

		$.each( f.val, function(i,b) {
			if ( u(b.name) === false || b.name == '' ) {
				b.name = 'Not set';
			}

			r[sanitize_title(b.name)] = b.name;
			if ( Object.keys(b).length>1 ) {
				svx.solids['_wcmn_isb_preset_'+sanitize_title(b.name)] = {
					val: b,
					autoload: 'solid'
				};
			}
			else if ( svx.utility_mode ) {
				svx.solids['_wcmn_isb_preset_'+sanitize_title(b.name)] = {};
			}
		});

		f.save_val = r;

	} );

	function sanitize_title(s) {
		if ( u(s) ) {
			s = s.toString().replace(/^\s+|\s+$/g, '');
			s = s.toLowerCase();

			var from = "ąàáäâèéëêęìíïîłòóöôùúüûñńçěšśčřžźżýúůďťňćđ·/_,:;#";
			var to   = "aaaaaeeeeeiiiiloooouuuunncesscrzzzyuudtncd-------";

			for (var i=0, l=from.length ; i<l ; i++)
			{
				s = s.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
			}

			s = s.replace('.', '-')
				.replace(/[^a-z0-9 -]/g, '')
				.replace(/\s+/g, '-')
				.replace(/-+/g, '-');
		}
		else {
			s = '';
		}

		return s;
	}

	$(document).on('change', '#isb_tab select[id^="wc_settings_isb"], #isb_tab textarea', function() {
		call_isb_single();
	});
 
	function call_isb_single() {

		var data = {
			action: 'isb_respond',
			data: {
				'isb_style': $('#wc_settings_isb_style').val(),
				'isb_color': $('#wc_settings_isb_color').val(),
				'isb_position': $('#wc_settings_isb_position').val(),
				'isb_special': $('#wc_settings_isb_special').val(),
				'isb_special_text': $('#wc_settings_isb_special_text').val()
			}
		};

		if ( $('#wc_settings_isb_preset').length>0 ) {
			data.data.isb_preset = $('#wc_settings_isb_preset').val();
		}

		$.when( call_ajax( data ) ).done( function(response) {
			$('#isb_preview').empty().append(response);
		});

		return false;

	}

	function toggleIsbTab() {
		if ( $('#wc_settings_isb_preset').val() == '' ) {
			$('.form-field.isb_no_preset').show();
		}
		else {
			$('.form-field.isb_no_preset').hide();
		}
	}

	if ( $('#isb_tab').length>0 ) {
		$(document).ready(function() {
			toggleIsbTab();
		});
		$(document).on('change', $('#wc_settings_isb_preset'), function() {
			toggleIsbTab();
		});
	}


})(jQuery);