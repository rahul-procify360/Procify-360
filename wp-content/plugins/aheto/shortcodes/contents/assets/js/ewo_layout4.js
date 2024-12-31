;(function ($, window, document, undefined) {
    "use strict";
    const $isotope = $('.aheto-gallery-brands--ewo-isotope .aheto-gallery-brands__content');

    $(() => {

        // ISOTOPE FILTER
        $('.aheto-gallery-brands--ewo-link[data-gallery-brands-filter]').on('click', function (e) {
            e.preventDefault();

            const $this = $(this);

            const filterValue = $this.attr('data-gallery-brands-filter');

            $isotope.isotope({
                filter: '.' + filterValue
            });
        });

        $(window).on('load', function () {
            initIsotope();
            initialFiltering();
        })

        // Magnific Popup gallery
		if ($('.aheto-gallery-brands__content').length) {
			$('.aheto-gallery-brands__content').magnificPopup({
				delegate: '.aheto-gallery-brands__box:visible a',
				type: 'image',
				gallery: {
					enabled: true
				},
				removalDelay: 500,
				callbacks: {
					beforeOpen: function () {
						this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
						this.st.mainClass = this.st.el.attr('data-effect');
					}
				},
				closeOnContentClick: true,
				midClick: true
			});
		}
    });

    function initIsotope() {
        if ($isotope.length) {
            $isotope.each(function () {
                $(this).isotope({
                    itemSelector: '.js-isotope-box',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.js-isotope-box',
                        "gutter": 23,
                    }
                })
            });
        }
    }

    function initialFiltering() {
		if ($isotope.length) {
			let $firstFilterValue = $('[data-gallery-brands-filter]').first().attr('data-gallery-brands-filter');

			$isotope.isotope({
				filter: '.' + $firstFilterValue
			});
		}
    }

    if (window.elementorFrontend) {
        initIsotope();
        initialFiltering();
    }
})(jQuery, window, document);
