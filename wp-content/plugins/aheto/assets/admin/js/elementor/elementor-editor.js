/*eslint no-undef:0*/
(function ($) {

    $(window).on('elementor/frontend/init', function () {

        // SWIPER HANDLER
        function initSwiperHandler($scope) {
            initSwiper($scope.find('.swiper-container'))
        }

        const swiperTargets = [
            'aheto_banner-slider.default',
            'aheto_features-slider.default',
            'aheto_features.default',
            'aheto_team.default',
            'aheto_testimonials.default',
            'aheto_media.default',
            'aheto_team.default',
            'aheto_custom-post-types.default',
        ]

        swiperTargets.forEach((el) => {
            // elementorFrontend.hooks.addAction('frontend/element_ready/' + el, initSwiperHandler);
        })

        // CHANGE IMAGE TO BG HANDLER
        function changeImgToBgHandler($scope) {
            changeImgToBg($scope.find('.js-bg'));
        }

        function lazyLoadImgHandler($scope) {
            lazyLoadImg($scope.find('img[data-lazy-src]'));
        }

        elementorFrontend.hooks.addAction('frontend/element_ready/global', changeImgToBgHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/global', lazyLoadImgHandler);


        // Accordion
        elementorFrontend.hooks.addAction('frontend/element_ready/aheto_contents.default', accordionHandler);

        function accordionHandler($scope) {
            $scope.find('.js-accordion').on('click', function () {
                $(this).toggleClass('active').next().slideToggle('fast');
            })
        }

        const audioTargets = [
            'aheto_custom-post-types.default',
        ];

        function initAudioElements($scope) {
            initAudio($scope.find('.js-audio'));
        }

        audioTargets.forEach((el) => {
            elementorFrontend.hooks.addAction('frontend/element_ready/' + el, initAudioElements);
        })


		const navigationTargets = [
			'aheto_navigation.default',
		];

		function initMenuElements($scope) {
			initMenu();
		}

		$(window).on('load', function(){
			initMenuElements();
		});

		navigationTargets.forEach((el) => {
			elementorFrontend.hooks.addAction('frontend/element_ready/' + el, initMenuElements);
		})

    })
}(jQuery))
