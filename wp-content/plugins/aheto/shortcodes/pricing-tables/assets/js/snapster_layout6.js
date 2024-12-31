jQuery(function ($) {

    $(() => {

        if (typeof window.snapsterPricelist === 'undefined') {
            window.snapsterPricelist = function () {

                if ($('.aheto-pricing-tables__pricelist-value').length && $('.aheto-pricing-tables__pricelist-total').length) {
                    let currency = $('.aheto-pricing-tables--snapster .aheto-pricing-tables__currency').first().text(),
                        total = $('.aheto-pricing-tables__pricelist-total');

                    total.addClass('active');
                    total.find('.aheto-pricing-tables__currency').text(currency);
                    total.find('.aheto-pricing-tables__price').text('0');
                }


                if ($('.aheto-pricing-tables--snapster').length) {
                    $('.aheto-pricing-tables--snapster .aheto-pricing-tables__wrap').on('click', function () {

                        $(this).toggleClass('active');
                        let value = 0, thisPrice,
                            currency = $('.aheto-pricing-tables__currency').first().text(),
                            name = $(this).find('input[type="radio"]').attr('name');

                        if ($(this).hasClass('active')) {
                            $(this).find('input[type="radio"]').prop("checked", true);

                        } else {
                            $(this).find('input[type="radio"]').prop("checked", false);
                        }

                        $('input[name="' + name + '"]').closest('.aheto-pricing-tables__wrap').not(this).removeClass('active');

                        $('.aheto-pricing-tables--snapster .aheto-pricing-tables__wrap.active').each(function () {
                            thisPrice = +$(this).find('input[type="radio"]').attr('value');
                            value = value + thisPrice;
                            thisPrice = 0;
                        });

                        let price = currency + value;

                        if ($('.aheto-pricing-tables__pricelist-total').length) {
                            $('.aheto-pricing-tables__pricelist-total').find('.aheto-pricing-tables__price').text(value);
                        }

                        if ($('.aheto-pricing-tables__send-email').length) {
                            $('.aheto-pricing-tables__send-email').attr('data-price', price);
                        }

                    });
                }
            };

            snapsterPricelist();
        }
    });

});
