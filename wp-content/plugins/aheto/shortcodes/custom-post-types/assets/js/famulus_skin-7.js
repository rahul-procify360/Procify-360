;(function ($, window, document, undefined) {
    "use strict";
    
    /*
    * Replace end of Post title in span
    */
    if($('.js-postTitle').length) {
        $('.js-postTitle').each(function () {
            var str = $(this).text();
            var array = str.split(" ");
            var lastword = '';
            for (var $i = Math.round((array.length)/2) ; $i <= array.length - 1 ; $i++){
                lastword += ' '+array[$i];
            }
            var fix = str.replace(lastword, "<span>"+lastword+"</span>");
            $(this).html(fix);
        });
    }



})(jQuery, window, document);