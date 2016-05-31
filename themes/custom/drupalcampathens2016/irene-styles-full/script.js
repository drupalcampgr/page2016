(function($){

$(window).scroll(function() {
  if ($('.header--home').length) {
    if ($(this).scrollTop() > $('.intro').height()) {
      $('header').addClass('is-scrolled');
    } else {
      $('header').removeClass('is-scrolled');
    }
  } else {
    if ($(this).scrollTop() > 85) {
      $('header').addClass('is-scrolled');
    } else {
      $('header').removeClass('is-scrolled');
    }
  }
});

})(jQuery);
