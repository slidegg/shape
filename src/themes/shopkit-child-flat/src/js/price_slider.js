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
