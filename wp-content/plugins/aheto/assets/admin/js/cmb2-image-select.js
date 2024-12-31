( function( $ ) {

    'use strict';


    function formatState (state) {
        if (!state.id) {
            return state.text;
        }


        if(state.element.value !== '0' && state.text.includes('src=')){
            var $state = $(
                '<span><img src="' + state.text.split('title=')[0].split('src=')[1] + '" class="img-select" /></span>'
            );
        }else{
            var $state = $(
                '<span>' + state.text + '</span>'
            );
        }

        return $state;
    }


    // Document Ready
    $( () => {
        $('.cmb-type-image-select select').each(function () {
            $(this).select2({
                width: '100%',
                minimumResultsForSearch: -1,
                templateResult: formatState,
                templateSelection: function (option) {
                    if (option.id.length > 0 ) {

                        if(option.text.includes('src=')){
                            return option.text.split('title=')[1];
                        }else{
                            return option.text;
                        }

                    } else {
                        return option.text;
                    }
                },
                closeOnSelect: true
            });
        })
   });



}( jQuery ) );
