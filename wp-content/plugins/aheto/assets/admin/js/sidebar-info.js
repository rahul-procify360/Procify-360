( function( $ ) {



    function system_info_position(){
        if($(window).width() > 991){
            var info_header = $('.aheto-system-info-header').clone();
            $('.aheto-option-body .aheto-system-info-header').hide();
            $('.aheto-option-header').append(info_header);
        }
        else{
            $('.aheto-system-info-header').hide();
            $('.aheto-option-body .aheto-system-info-header').show();
        }
    }

    $( () => {

        if($('.aheto-system-info-header').length){
            system_info_position();
        }


    });

    $(window).on('resize', function () {
        if($('.aheto-system-info-header').length){
            system_info_position();
        }
    });

    $(window).on('load', function () {
        $('.aheto-preloader').addClass('active');
    });


}( jQuery ) );
