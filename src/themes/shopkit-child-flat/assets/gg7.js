jQuery(function ($) {
  $('#gg7-checkout-field-selectors').livequery(function () {
    // var $checkout_fields = '#checkout_fields#';
    var checkout_field_selectors = $.parseJSON($(this).text());
    var $checkout_field_elements = $([]);

    $.each(checkout_field_selectors, function (scenario, selector) {
      $checkout_field_elements = $checkout_field_elements.add($(selector));
    });
    $checkout_field_elements
      .filter('.hidden')
      .css({ display: 'none' })
      .removeClass('hidden');

    var $document_type = $('#document_type');
    var $shipping_method = $('input.shipping_method');
    var $shipping_address = $('#ship-to-different-address-checkbox');

    var fields_toggle = _.debounce(function () {
      var shipping_is_local = ($shipping_method.filter(':checked').val() + '').indexOf('local_pickup') === 0;
      var scenarios = {
        invoice: $document_type.val() === 'invoice',
        billing_address: !shipping_is_local,
        shipping_address: !shipping_is_local && $shipping_address.is(':checked')
      };
      var $hide = $checkout_field_elements;
      $.each(scenarios, function (scenario, is_active) {
        if (is_active) {
          $hide = $hide.not(checkout_field_selectors[scenario]);
        }
      });

      $hide.slideUp();
      $checkout_field_elements.not($hide).slideDown();

      // return false;//prevent woocommerce js hide of different shipping address
    }, 100);

    $shipping_address.on('change', fields_toggle);
    $document_type.on('change', fields_toggle);
    $shipping_method.on('change', function () {
      fields_toggle();

      $.each($shipping_method, function () {
        var $this = $(this);
        var $description = $this.closest('li').find('.shipping-description');
        $this.is(':checked') ? $description.slideDown() : $description.slideUp();
      });
    }).trigger('change');

    var $window = $(window);
    var $order_review = $('#gg7-review-order');
    var $parent = $order_review.closest('.row');
    $parent
      .addClass('clearfix')
      .css({ position: 'relative' });
    $window.on('resize', _.debounce(function () {
      if ($window.width() > 991) {
        if (!$order_review.data('isSticky')) {
          $order_review
            .stick_in_parent({
              offset_top: 140,//fixme
              parent: $parent
            })
            .data('isSticky', true);
        }
      } else {
        if ($order_review.data('isSticky')) {
          $order_review.trigger('sticky_kit:detach');
        }
      }
    }, 100)).trigger('resize');
  });
});
;
jQuery(function ($) {
  var $body = $('body');
  var $window = $(window);
  $window.on('scroll', _.debounce(function () {
    if ($window.scrollTop() > 20) {
      $body.addClass('gg7-sticky-header');
    } else {
      $body.removeClass('gg7-sticky-header');
    }
  }, 10));

  // // mobile login
  // var $mobileLogin = $('#login-logout-mobile');
  // var $mobileLoginA = $mobileLogin.find('> a');
  // $mobileLogin.on('mouseenter click', function (e) {
  //   if (!$mobileLogin.hasClass('hover')) {
  //     $mobileLogin.addClass('hover');
  //     e.preventDefault();
  //     return false;
  //   }
  // });
  // $mobileLogin.on('mouseleave', function () {
  //   $mobileLogin.removeClass('hover');
  // });
  //
  // $mobileLoginA.on('click', function (e) {
  //   if ($window.width() < 768 && $mobileLogin.hasClass('hover')) {
  //     $mobileLogin.removeClass('hover');
  //     e.preventDefault();
  //     return false;
  //   }
  // });
  // $body.on('click', function (e) {
  //   if ($window.width() < 768 && $mobileLogin.hasClass('hover') && $(e.target).closest('#login-logout-mobile').length === 0) {
  //     console.log('ha');
  //     $mobileLogin.removeClass('hover');
  //     e.preventDefault();
  //     return false;
  //   }
  // });
});
;
jQuery(function ($) {
  // /**
  //  * @param  $element jQuery
  //  * @param  eventName String
  //  * @return void
  //  */
  // function promoteLastEvent ($element, eventName) {
  //   var events = jQuery._data($element.get(0), 'events'),
  //     eventNameEvents = events[eventName],
  //     lastEvent = eventNameEvents.pop();
  //   eventNameEvents.splice(1, 0, lastEvent);
  // }
  //
  // var $inputs = $('.prdctfltr_checkboxes input');
  //
  // $inputs.on('change', function (e) {
  //   console.log(this);
  //
  //   e.stopPropagation();
  //   return false;
  // });
  // promoteLastEvent($inputs, 'change');
});
;
jQuery(function ($) {
  $('.price_slider_wrapper').livequery(function () {
    var $wrapper = $(this);
    var $form = $wrapper.closest('form');
    $wrapper.addClass('js');
    $(document.body).on('price_slider_change', function (a, b, c) {
      console.log($form);
      $form.trigger('submit');
    });
  })
});
;
// (function ($) {
//   $(document).ajaxComplete(function (e, r) {
//     var count = _.get(r, 'responseJSON.count');
//     console.log(count);
//     if (count) {
//       $('.woocommerce-result-count').replaceWith($(count));
//       console.log('done');
//     }
//   });
// })(jQuery);
