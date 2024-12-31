jQuery(function ($) {

    $(() => {

        if (typeof window.snapsterPricelistForm === 'undefined') {
            window.snapsterPricelistForm = function () {


                if($('.aheto-pricing-tables__send-email input[type="checkbox"]').length){
                    if($('.aheto-pricing-tables__email input[type="checkbox"]').prop("checked") == true){
                        $('.aheto-pricing-tables__send-email').find('input[type="submit"]').removeAttr('disabled');
                    } else{
                        $('.aheto-pricing-tables__send-email').find('input[type="submit"]').attr('disabled',true);
                    }

                    $('.aheto-pricing-tables__send-email input[type="checkbox"]').on('change', function () {
                        if($(this).prop("checked") == true){
                            $(this).closest('.aheto-pricing-tables__send-email').find('input[type="submit"]').removeAttr('disabled');
                        } else{
                            $(this).closest('.aheto-pricing-tables__send-email').find('input[type="submit"]').attr('disabled',true);
                        }
                    })
                }

            };

            snapsterPricelistForm();
        }

        if (typeof window.snapsterPricelistFormSend === 'undefined') {

            window.snapsterPricelistFormSend = function () {

                if (window.get) {
                    $('#aheto-pricing-tables__pricelistform .aheto-pricing-tables__close').on('click', function (e) {
                        $('#aheto-pricing-tables__pricelistform').find('.aheto-pricing-tables__send-popup').removeClass('active');
                        // $('.main-wrapper').removeClass('active-wrapper');
                    });
                    $('#aheto-pricing-tables__pricelistform').submit( function (e) {

                        e.preventDefault();

                        let wrapp_elements = $(this).closest('.aheto-pricing-tables__send-email'),
                            mail_to = wrapp_elements.attr('data-mail'),
                            placeholder = wrapp_elements.find('textarea[name="snapster_message"]').attr('placeholder'),
                            price = wrapp_elements.attr('data-price'),
                            packages = [],
                            packagesString;


                        $('.aheto-pricing-tables--snapster .aheto-pricing-tables__wrap.active').each(function (index ) {
                            let dataTitle = $(this).find('.aheto-pricing-tables__pricelist-value').attr('data-price-title'),
                                dataPrice = $(this).find('.aheto-pricing-tables__pricelist-value').attr('data-price-value');

                            packages[index] = dataTitle + '=' + dataPrice;

                        });

                        if(packages.length > 0){
                            packagesString = packages.join('&');
                        }

                        let form = $(this).serialize();

                        $.ajax({
                            type: "POST",
                            url: get.ajaxurl,
                            data: {
                                'action': 'aheto_pricing_tables',
                                'mail_to': mail_to,
                                'price': price,
                                'packages': packagesString,
                                'placeholder': placeholder,
                                form: form
                            },
                            beforeSend: function() {
                                $(".aheto-pricing-tables__price-send-loader").addClass('active');
                            },
                            success: function() {
                                $(".aheto-pricing-tables__price-send-loader").removeClass('active');
                            }
                        }).done(function($data) {
                            wrapp_elements.find('.aheto-pricing-tables__send-popup').addClass('active');

                            if ( $data !== 'error') {
                                wrapp_elements.find('.aheto-pricing-tables__done').show();
                                wrapp_elements.find('.aheto-pricing-tables__error').hide();
                                if(packages.length > 0){
                                    wrapp_elements.find('.aheto-pricing-tables__pdf-wrap').attr('href', $data ).show();
                                }

                            } else {
                                wrapp_elements.find('.aheto-pricing-tables__done').hide();
                                wrapp_elements.find('.aheto-pricing-tables__popup-title').hide();
                                wrapp_elements.find('.aheto-pricing-tables__error').show();
                            }

                            wrapp_elements.find('input:not([type="submit"]), textarea').val('');
                        });
                    });
                }


            };

            $(window).on('load', function () {
                snapsterPricelistFormSend();
            });
        }










    });

});
