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
