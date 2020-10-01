!function(e,t){"function"==typeof define&&define.amd?define([],function(){return t(e)}):"object"==typeof exports?module.exports=t(e):e.SmoothScroll=t(e)}("undefined"!=typeof global?global:"undefined"!=typeof window?window:this,function(e){"use strict";var t="querySelector"in document&&"addEventListener"in e&&"requestAnimationFrame"in e&&"closest"in e.Element.prototype,n={ignore:"[data-scroll-ignore]",header:null,speed:500,offset:0,easing:"easeInOutCubic",customEasing:null,before:function(){},after:function(){}},o=function(){for(var e={},t=0,n=arguments.length,o=function(t){for(var n in t)t.hasOwnProperty(n)&&(e[n]=t[n])};n>t;t++){var a=arguments[t];o(a)}return e},a=function(t){return parseInt(e.getComputedStyle(t).height,10)},r=function(e){"#"===e.charAt(0)&&(e=e.substr(1));for(var t,n=String(e),o=n.length,a=-1,r="",i=n.charCodeAt(0);++a<o;){if(t=n.charCodeAt(a),0===t)throw new InvalidCharacterError("Invalid character: the input contains U+0000.");r+=t>=1&&31>=t||127==t||0===a&&t>=48&&57>=t||1===a&&t>=48&&57>=t&&45===i?"\\"+t.toString(16)+" ":t>=128||45===t||95===t||t>=48&&57>=t||t>=65&&90>=t||t>=97&&122>=t?n.charAt(a):"\\"+n.charAt(a)}return"#"+r},i=function(e,t){var n;return"easeInQuad"===e.easing&&(n=t*t),"easeOutQuad"===e.easing&&(n=t*(2-t)),"easeInOutQuad"===e.easing&&(n=.5>t?2*t*t:-1+(4-2*t)*t),"easeInCubic"===e.easing&&(n=t*t*t),"easeOutCubic"===e.easing&&(n=--t*t*t+1),"easeInOutCubic"===e.easing&&(n=.5>t?4*t*t*t:(t-1)*(2*t-2)*(2*t-2)+1),"easeInQuart"===e.easing&&(n=t*t*t*t),"easeOutQuart"===e.easing&&(n=1- --t*t*t*t),"easeInOutQuart"===e.easing&&(n=.5>t?8*t*t*t*t:1-8*--t*t*t*t),"easeInQuint"===e.easing&&(n=t*t*t*t*t),"easeOutQuint"===e.easing&&(n=1+--t*t*t*t*t),"easeInOutQuint"===e.easing&&(n=.5>t?16*t*t*t*t*t:1+16*--t*t*t*t*t),e.customEasing&&(n=e.customEasing(t)),n||t},u=function(){return Math.max(document.body.scrollHeight,document.documentElement.scrollHeight,document.body.offsetHeight,document.documentElement.offsetHeight,document.body.clientHeight,document.documentElement.clientHeight)},c=function(e,t,n){var o=0;if(e.offsetParent)do o+=e.offsetTop,e=e.offsetParent;while(e);return o=Math.max(o-t-n,0)},s=function(e){return e?a(e)+e.offsetTop:0},l=function(t,n,o){o||(t.focus(),document.activeElement.id!==t.id&&(t.setAttribute("tabindex","-1"),t.focus(),t.style.outline="none"),e.scrollTo(0,n))},f=function(t){return"matchMedia"in e&&e.matchMedia("(prefers-reduced-motion)").matches?!0:!1},d=function(a,d){var m,h,g,p,v,b,y,S={};S.cancelScroll=function(){cancelAnimationFrame(y)},S.animateScroll=function(t,a,r){var f=o(m||n,r||{}),d="[object Number]"===Object.prototype.toString.call(t)?!0:!1,h=d||!t.tagName?null:t;if(d||h){var g=e.pageYOffset;f.header&&!p&&(p=document.querySelector(f.header)),v||(v=s(p));var b,y,E,I=d?t:c(h,v,parseInt("function"==typeof f.offset?f.offset():f.offset,10)),O=I-g,A=u(),C=0,w=function(n,o){var r=e.pageYOffset;return n==o||r==o||(o>g&&e.innerHeight+r)>=A?(S.cancelScroll(),l(t,o,d),f.after(t,a),b=null,!0):void 0},Q=function(t){b||(b=t),C+=t-b,y=C/parseInt(f.speed,10),y=y>1?1:y,E=g+O*i(f,y),e.scrollTo(0,Math.floor(E)),w(E,I)||(e.requestAnimationFrame(Q),b=t)};0===e.pageYOffset&&e.scrollTo(0,0),f.before(t,a),S.cancelScroll(),e.requestAnimationFrame(Q)}};var E=function(e){h&&(S.animateScroll(h,g),h=null,g=null)},I=function(t){if(!f(m)&&0===t.button&&!t.metaKey&&!t.ctrlKey&&(g=t.target.closest(a),g&&"a"===g.tagName.toLowerCase()&&!t.target.closest(m.ignore)&&g.hostname===e.location.hostname&&g.pathname===e.location.pathname&&/#/.test(g.href))){var n;try{n=r(decodeURIComponent(g.hash))}catch(o){n=r(g.hash)}if("#"===n){t.preventDefault(),h=document.body;var i=h.id?h.id:"smooth-scroll-top";return h.setAttribute("data-scroll-id",i),h.id="",void(e.location.hash.substring(1)===i?E():e.location.hash=i)}h=document.querySelector(n),h&&(h.setAttribute("data-scroll-id",h.id),h.id="",g.hash===e.location.hash&&(t.preventDefault(),E()),setTimeout(function(){h.id=h.getAttribute("data-scroll-id")},25))}},O=function(e){b||(b=setTimeout(function(){b=null,v=s(p)},66))};return S.destroy=function(){m&&(document.removeEventListener("click",I,!1),e.removeEventListener("resize",O,!1),S.cancelScroll(),m=null,h=null,g=null,p=null,v=null,b=null,y=null)},S.init=function(a){t&&(S.destroy(),m=o(n,a||{}),p=m.header?document.querySelector(m.header):null,v=s(p),document.addEventListener("click",I,!1),e.addEventListener("hashchange",E,!1),p&&e.addEventListener("resize",O,!1))},S.init(d),S};return d});

;(function(e,t,n,r){e.fn.doubleTapToGo=function(r){if(!("ontouchstart"in t)&&!navigator.msMaxTouchPoints&&!navigator.userAgent.toLowerCase().match(/windows phone os 7/i))return false;this.each(function(){var t=false;e(this).on("click",function(n){var r=e(this);if(r[0]!=t[0]){n.preventDefault();t=r}});e(n).on("click touchstart MSPointerDown",function(n){var r=true,i=e(n.target).parents();for(var s=0;s<i.length;s++)if(i[s]==t[0])r=false;if(r)t=false})});return this}})(jQuery,window,document);

(function($){

	"use strict";

	function collapsibleAjax(obj,display) {

		if ( obj.remove === false ) {

			var ajax_data = {
				action: 'shopkit_section_session',
				section: obj.name,
				visibility: display
			};

			$.ajax({
				type: 'POST',
				url: shopkit.ajaxurl,
				data: ajax_data,
				success: function(response) {
				},
				error: function() {
					alert(shopkit.locale.ajax_error);
				}
			});

		}

	}

	if ( typeof shopkit.collapsibles != 'undefined' ) {

		$.each( shopkit.collapsibles, function(i, obj) {

			$(document).on('click', '.shopkit-'+obj.slug+'-dismiss', function() {

				$('.shopkit-'+obj.slug+'-trigger').toggleClass('shopkit-active').toggleClass('shopkit-notactive');

				$('#'+obj.name+'_section .shopkit-inner-wrapper').slideUp(200, function() {
					$('#'+obj.name+'_section').slideUp(200, function() {
						$('.shopkit-'+obj.slug+'-trigger').remove();
					});
				});

				collapsibleAjax(obj,'notshown');

				return false;

			});

			if ( obj.remove === false ) {

				$(window).load( function() {

					if ( $('.shopkit-'+obj.slug+'-trigger').length>0 ) {

						if ( $('#'+obj.name+'_section .shopkit-inner-wrapper').is(':visible') ) {
							$('.shopkit-'+obj.slug+'-trigger.shopkit-active').removeClass('shopkit-active').addClass('shopkit-notactive');
						}
						else {
							$('.shopkit-'+obj.slug+'-trigger.shopkit-notactive').removeClass('shopkit-notactive').addClass('shopkit-active');
						}
					}
				});
			}

			$(document).on('click', '.shopkit-'+obj.slug+'-trigger', function() {

				if ( $('#'+obj.name+'_section .shopkit-inner-wrapper').is(':visible') ) {

					$('.shopkit-'+obj.slug+'-trigger').removeClass('shopkit-notactive').addClass('shopkit-active');

					collapsibleAjax(obj,'notshown');

				}
				else {

					$('.shopkit-'+obj.slug+'-trigger').removeClass('shopkit-active').addClass('shopkit-notactive');

					collapsibleAjax(obj,'shown');

				}

				$('#'+obj.name+'_section .shopkit-inner-wrapper').toggleClass('shopkit-hasextended').slideToggle(200);

				var body = $('body');
				var sticky = $(this).closest('.shopkit-header.shopkit-sticky');

				if( sticky.length>0 ) {
					if ( sticky.hasClass('shopkit-add-scroll') ) {
						body.removeClass('shopkit-remove-scroll');
						sticky.removeClass('shopkit-add-scroll').removeClass('shopkit-maxheight-limit');
					}
					else {

						setTimeout( function() {

							if ( sticky.hasScrollBar() ) {
								body.addClass('shopkit-remove-scroll');
								sticky.addClass('shopkit-add-scroll').addClass('shopkit-maxheight-limit');
							}

						}, 205 );
					}

				}

				return false;

			});

		});

	}

	$.fn.hasScrollBar = function() {
		return this.height() > $(window).height();
	}

	var scroll = new SmoothScroll('a[href*="#"]:not([href="#"])');

	$('.shopkit-menu > ul.menu').each( function() {
		var selected = $(this).find('.current-menu-item');
		if ( selected.length>0 ) {
			$(this).next().find('select').find('option[value="'+selected.find('a:first').attr('href')+'"]').prop('selected', true).attr('selected','selected');
		}
	} );

	$('.shopkit-menu li:has(ul)').doubleTapToGo();

	$(document).on( 'submit', '.shopkit-search-form', function() {

		if ( $(this).find('input[name="s"]').val() == '' ) {
			$(this).find('input[name="s"]').focus();
			return false;
		}

	});

	$('.shopkit-menu .shopkit-menu-style-multi-column > ul > li > a').each( function() {
		$(this).replaceWith('<span class="shopkit-menu-style-multi-column-title">' + $(this).html() +'</span>');
	});

	$('.shopkit-menu img.shopkit-menu-bg').each( function() {

		var curr_bg_src = $(this).attr('src');
		var curr_bg_pos = $(this).attr('data-background-position');
		curr_bg_pos = curr_bg_pos.split('-');

		var curr_bg_prnt = $(this).parent();
		var curr_bg = $(this).next().next();

		curr_bg_prnt.addClass('shopkit-menu-bg-active');

		curr_bg.css({
			'background-image':'url('+curr_bg_src+')'
		});

		if ( curr_bg_pos[0] == 'left' ) {
			if ( shopkit.options.rtl === true ) {
				curr_bg.css({
					'padding-right':'120px',
					'background-position':'right center',
					'background-repeat':'no-repeat'
				});
			}
			else {
				curr_bg.css({
					'padding-left':'120px',
					'background-position':'left center',
					'background-repeat':'no-repeat'
				});
			}

		}
		else if ( curr_bg_pos[0] == 'right' ) {
			if ( shopkit.options.rtl === true ) {
				curr_bg.css({
					'padding-left':'120px',
					'background-position':'left center',
					'background-repeat':'no-repeat'
				});
			}
			else {
				curr_bg.css({
					'padding-right':'120px',
					'background-position':'right center',
					'background-repeat':'no-repeat'
				});
			}
		}
		else if ( curr_bg_pos[0] == 'pattern' || curr_bg_pos[0] == 'full' ) {
			if ( shopkit.options.rtl === true ) {
				curr_bg.css({
					'padding-left':'120px',
					'background-position':'center center'
				});
			}
			else {
				curr_bg.css({
					'padding-right':'120px',
					'background-position':'center center'
				});
			}
		}


		if ( curr_bg_pos[1] == 'portraid' ) {
			curr_bg.css({
				'background-size':'auto 100%'
			});
		}
		else if ( curr_bg_pos[1] == 'landscape' ) {
			curr_bg.css({
				'background-size':'100% auto'
			});
		}
		else if ( curr_bg_pos[1] == 'repeat' ) {
			curr_bg.css({
				'background-repeat':'repeat'
			});
		}
		else if ( curr_bg_pos[1] == 'width' ) {
			curr_bg.css({
				'background-size':'cover'
			});
		}
		$(this).remove();

	});

	var shopkit_ajax = 'not_active';

	function shopkit_ajax_call( el_action, el_id ) {

		var ajax_data = {
			action: el_action,
			product_id: el_id
		};

		return $.ajax({
			type: 'POST',
			url: shopkit.ajaxurl,
			data: ajax_data,
			success: function(response) {
				if (response) {
					shopkit_ajax = 'notactive';
				}
			},
			error: function() {
				alert(shopkit.locale.ajax_error);
				shopkit_ajax = 'notactive';
			}
		});

	}

	$(document).on( 'click', '.shopkit-quickview-button', function() {

		if ( $('.shopkit-quickview').length>0 ) {
			return false;
		}

		if ( shopkit_ajax == 'active' ) {
			return false;
		}

		var curr = $(this);
		curr.addClass('shopkit-active');
		shopkit_ajax = 'active';

		$.when( shopkit_ajax_call( 'shopkit_quickview', curr.data('quickview-id') ) ).done( function(response) {
			response = $(response);
			response.hide();
			$('.shopkit-main').append(response);
			if ( response.find('.product-type-variable').length>0 ) {
				if ( typeof wc_add_to_cart_params == 'undefined' ){
					var wc_add_to_cart_variation_params = shopkit.add_to_cart_variation;
				}
				$.loadScript(shopkit.quickview.src, function(){
					var loaded = true;
					response.find('.variations_form').wc_variation_form();
				});
			}
			sort_bgs();
			response.fadeIn(200);
		});

		return false;
	});

	$.loadScript = function (url, callback) {
		$.ajax({
			url: url,
			dataType: 'script',
			success: callback,
			async: false
		});
	};

	$(document).on( 'click', '.shopkit-quickview-close', function() {

		$(this).parent().fadeOut(200, function() {
			$('.shopkit-quickview-button.shopkit-active').removeClass('shopkit-active');
			$(this).remove();
		});

	});

	$(document).on( 'click', '.shopkit-cart-icon', function() {

		/*if ( $(this).closest('.shopkit-notsticky').length==0 ) {*/
			$(this).next().clone().insertAfter('#wrapper').addClass('shopkit-extract');
			$('.shopkit-cart-wrapper.shopkit-extract').find('.shopkit-cart:first').fadeIn(200).toggleClass('shopkit-active');
		/*}
		else {
			$(this).next().find('.shopkit-cart:first').fadeIn(200).toggleClass('shopkit-active');
		}*/

		return false;

	});

	$(document).on( 'click', '.shopkit-woo-cart-close', function() {

		/*if ( $(this).closest('.shopkit-notsticky').length==0 ) {*/
			$('.shopkit-cart-wrapper.shopkit-extract').find('.shopkit-cart:first').toggleClass('shopkit-active').fadeOut(200);
			setTimeout( function() {
				$('.shopkit-cart-wrapper.shopkit-extract').remove();
			}, 200 );
		/*}
		else {
			$(this).parent().toggleClass('shopkit-active').fadeOut(200);
		}*/

		return false;

		

	});

	$(document).on( 'click', '.shopkit-login-icon', function() {

		//$(this).next().toggleClass('shopkit-active').fadeIn(200).find('input[type="text"]:first').focus();

		$(this).next().clone().insertAfter('#wrapper').addClass('shopkit-extract');
		$('.shopkit-login.shopkit-extract').toggleClass('shopkit-active').fadeIn(200).find('input[type="text"]:first').focus();

		return false;

	});

	$(document).on( 'click', '.shopkit-login-close', function() {

		//$(this).parent().toggleClass('shopkit-active').fadeOut(200);

			$('.shopkit-login.shopkit-extract').toggleClass('shopkit-active').fadeOut(200);
			setTimeout( function() {
				$('.shopkit-login.shopkit-extract').remove();
			}, 200 );

		return false;

	});


	function sort_bgs() {
		$('.shopkit-woo-bg').each( function(i, obj) {
			$(this).closest('.shopkit-loop-image-inner').css({'background' : 'url('+$(this).attr('data-url')+') center center'});
			$(this).remove();
		} );
	}
	sort_bgs();

	$(document.body).on( 'post-load', function() {
		sort_bgs();
	});

	function fix_wc_cart() {
		setTimeout( function() {
			var count = parseInt( $('.shopkit-summary-items:first').text(), 10 ) > 0 ? parseInt( $('.shopkit-summary-items:first').text(), 10 ) :0;
			$('.shopkit-cart-icon span').html(count);
		}, 250 );
	}

	$(document).on( 'wc_fragments_refreshed', function() {
		fix_wc_cart();
	});

	$(document).on( 'added_to_cart', function(e,b,c) {
		fix_wc_cart();
		if ( $(e.currentTarget.activeElement).is('.add_to_cart_button') === true || $(e.currentTarget.activeElement).is('.single_add_to_cart_button') === true ) {
			if ( $(e.currentTarget.activeElement).parent().find('.go_to_chekout').length<1 ) {
				if ( $(e.currentTarget.activeElement).next().is('.added_to_cart') ) {
					$(e.currentTarget.activeElement).next().after($(shopkit.locale.checkout));
				}
				else {
					$(e.currentTarget.activeElement).after($(shopkit.locale.checkout));
				}
			}
		}
	});

	if( typeof shopkit.options.sticky_header != 'undefined' && shopkit.options.sticky_header == 'on' ) {

		$(document).ready( function() {
			$('#header').addClass('shopkit-notsticky').clone().insertAfter('#header').addClass('shopkit-sticky-prepare').removeClass('shopkit-notsticky');

			var stickyTop = parseInt( shopkit.options.sticky_top, 10 );
			var stickyAnim = parseInt( shopkit.options.sticky_anim, 10 );
			var stickyNotSticky = $('.shopkit-notsticky');
			var stickyPrepared = $('.shopkit-sticky-prepare');

			admin_bar();
			stick_it();

			function admin_bar() {
				var adminBar = $('#wpadminbar');
				var val = 0;

				if ( adminBar.length!=0&&adminBar.css('position')!='absolute' ) {
					val = $('#wpadminbar').height();
				}

				stickyPrepared.css({top:val});
			}

			function stick_it() {
				stickyPrepared.css({transition:'transform '+stickyAnim+'ms'});

				var didScrollOne = false;

				setInterval( function() {
					if ( didScrollOne ) {
						didScrollOne = false;
						sticky_header();
					}
				}, 250 );

				$(document).on({
					'scroll': function() {
						didScrollOne = true;
					}
				});
			}

			function sticky_header() {

				if ( stickyPrepared.find('.shopkit-hasextended').length==0 ) {

					if ( $(window).scrollTop() > stickyTop ) {
						if ( !stickyPrepared.hasClass('shopkit-sticky') ) {
							stickyNotSticky.css({visibility:'hidden'});
							stickyPrepared.addClass('shopkit-sticky').css({transform:'translate(0)'});
						}
					}
					else {
						if ( stickyPrepared.hasClass('shopkit-sticky') ) {
							stickyNotSticky.removeAttr('style');
							stickyPrepared.css({transform:'translate(0,-'+(stickyPrepared.height()+50)+'px)'});
							setTimeout( function() {
								stickyPrepared.removeClass('shopkit-sticky');
							}, stickyAnim );
						}
					}

				}

			}

			$(window).resize( function() {
				admin_bar();
			} );

		} );

	}

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(String(email).toLowerCase());
	}

/*	$(document).on( 'submit', '#commentform', function() {
		return false;
	} );
*/
	$(document).on( 'click', '#respond #submit', function() {

		var fMissing = false;
		var objs = [ 'comment', 'author', 'email' ];

		$.each( objs, function(i,obj) {

			if ( $('#'+obj).length>0 ) {
				var val = $('#'+obj).val().toString();
				var missing = false;
				if ( obj == 'email' && !validateEmail(val) ) {
					fMissing = true;
					missing = true;
				}
				if ( val.replace(/\s/g,'') == '' ) {
					fMissing = true;
					missing = true;
				}
				if ( missing ) {
					$('#'+obj).addClass('shopkit-missing-input');
					setTimeout( function() {
						$('#'+obj).removeClass('shopkit-missing-input');
					}, 2500 );
				}
			}
		} );

		if ( fMissing ) {
			return false;
		}

	} );

})(jQuery);