
; (function ($, window, document, undefined) {
  'use strict';

    $(window).on('load', function () {
      $('.aheto-cpt-article--ewo_skin-2 .aheto-cpt-article__inner').hover(
        function () {
          $(this).find('.aheto-cpt-article__excerpt').slideDown(200);
        },
        function () {
          $(this).find('.aheto-cpt-article__excerpt').slideUp(200);
        }
      );
    });

})(jQuery, window, document);