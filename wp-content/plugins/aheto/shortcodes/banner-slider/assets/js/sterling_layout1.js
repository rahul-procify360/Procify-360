; (function ($, window, document, undefined) {
  'use strict';

  function sterling_banner_slider_height() {

    if ($('.sterling-full-min-height-js').length) {

      const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
      let adminBarH = $('body.admin-bar').length ? 32 : 0;
      let headerH = header.length ? header.outerHeight() : 0;

      $('.sterling-full-min-height-js').css('min-height', $(window).innerHeight() - headerH - adminBarH);
      console.log('work');
    }
  }

  $(window).on('load resize orientationchange', function () {

    sterling_banner_slider_height();

  });

  if (window.elementorFrontend) {
    sterling_banner_slider_height();
  }
})(jQuery, window, document);