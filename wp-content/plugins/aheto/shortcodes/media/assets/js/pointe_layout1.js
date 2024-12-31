;(function ($, window, document, undefined) {
    "use strict";
    function boxed_grid_with_filter(){
        if($('.aheto_media__pointe .boxed-grid-gallery-wrap .aheto_media__pointe__gallery').length || $('.aheto_media__pointe .masonry-filter-gallery-wrap .aheto_media__pointe__gallery').length){

            $('.aheto_media__pointe .boxed-grid-gallery-wrap, .aheto_media__pointe .masonry-filter-gallery-wrap').each(function () {
                var element = $(this);
                var $container = element.find('.aheto_media__pointe__gallery');

                $container.isotope({
                    itemSelector: '.item',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.item'

                    }
                });


                // filter items when filter link is clicked
                element.find('.boxed-grid-filters button').on('click', function() {
                    var selector = $(this).attr('data-media');
                    element.find('.boxed-grid-filters button').removeClass('is-checked');
                    $(this).addClass('is-checked');
                    $container.isotope({
                        filter: selector
                    });
                });


                // filter items when filter link is clicked
                element.find('.masonry-filters button').on('click', function() {
                    var selector = $(this).attr('data-media');
                    element.find('.masonry-filters button').removeClass('is-checked');
                    $(this).addClass('is-checked');
                    $container.isotope({
                        filter: selector
                    });
                });

                $('.aheto_media__pointe__gallery').magnificPopup({
                    delegate: 'a:visible',
                    type: 'image',
                    gallery: {
                        enabled: true
                    },
                    removalDelay: 500,
                    callbacks: {
                        beforeOpen: function() {
                            this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                            this.st.mainClass = this.st.el.attr('data-effect');
                        }
                    },
                    closeOnContentClick: true,
                    midClick: true
                });


            });
        }

    }


    $(window).on('load', function () {
        boxed_grid_with_filter();
    });


})(jQuery, window, document);

