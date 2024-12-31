( function( $ ) {


    $('.aheto_skin_name').on('change', function (e) {
        e.preventDefault();

        var skin_id = $(this).attr('data-skin_id'),
            skin_name = $(this).val();

        $.ajax({
            url: ajax.url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'change_skin_name',
                skin_id: skin_id,
                skin_name: skin_name
            },
            success: function(data) {
                $('#aheto-skin-generator_options').prepend(data);
            }

        });
    });

}( jQuery ) );