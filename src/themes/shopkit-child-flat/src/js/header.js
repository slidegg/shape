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
});
