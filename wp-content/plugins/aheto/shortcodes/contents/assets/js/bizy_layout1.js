;(function ($, window, document, undefined) {
    "use strict";

    function bizy_breakpoint() {
       if( $('.aheto-contents--bizy-creative').length){
           $('.aheto-contents--bizy-creative').each(function () {
               let breakpoint = $(this).data('breakpoint');

               if($(window).width() <= breakpoint ){
                   $(this).addClass('bizy-mob-version');
               }else{
                   $(this).removeClass('bizy-mob-version');
               }

           });
       }
    }

    $(window).on('load resize orientationchange', function () {
        bizy_breakpoint();
    });


})(jQuery, window, document);