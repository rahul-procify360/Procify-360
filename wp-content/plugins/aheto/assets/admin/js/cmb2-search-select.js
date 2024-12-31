( function( $ ) {

    'use strict';

    // Document Ready
    $( () => {

        $('.cmb-type-search-select select').each(function () {
            var select = $(this);


            select.select2({
                width: '100%',
                closeOnSelect: true
            });

        })
   });



}( jQuery ) );
