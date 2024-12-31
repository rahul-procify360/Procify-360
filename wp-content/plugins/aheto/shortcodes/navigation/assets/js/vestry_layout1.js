; (function ($, window, document, undefined) {
    "use strict";

    const $WIN = $(window),
        $mainHeader = $('.main-header--vestry.main-header-js'),
        $topMenu = $('.main-header--vestry.main-header-js ul'),
        $menuItems = $topMenu.find("a"),
        topMenuHeight = $('.aheto-header').outerHeight() + 50

    let lastId,
        $winHeight = $WIN.height(),
        isBlocked = false,
        hasPassiveEvents = false;

    if (typeof window !== 'undefined') {
        const passiveTestOptions = {
            get passive() {
                hasPassiveEvents = true;
                return undefined;
            }
        };
        window.addEventListener('testPassive', null, passiveTestOptions);
        window.removeEventListener('testPassive', null, passiveTestOptions);
    }
    document.addEventListener('touchmove', function (e) {
        if (isBlocked && mobFullHeight < $winHeight) {
            e.preventDefault();
        } else if (isBlocked && !e.target.closest('.js-mob-menu')) {
            e.preventDefault();
        }
    }, hasPassiveEvents ? {
        passive: false
    } : undefined);

    /**
     * Check if home page
     */

    const isHome = $('body').hasClass('home') ? true : false;

    /**
     * Set up custon namespace to prevent Elementor default ScrollToId
     * Custom scroll to target section
     */

    $menuItems.on('click.djoNav', function (e) {
        const href = $(this).get(0).getAttribute('href');

        if (href.indexOf('#') >= 0) {
            e.preventDefault();
        }

        if (!isHome) {
            const targetID = $(this).data('id') ? $(this).data('id') : '';
            //save in localstorage Id of target section
            localStorage.setItem('blockID', targetID);
        }

        scrollTo(href);
    });

    /**
     * Scrool to Id function
     */

    function scrollTo(id) {
        //check if the url is realy ID
        if (id.indexOf("#") >= 0) {
            const offsetTop = $(id).length ? $(id).offset().top - topMenuHeight + 1 : 0;

            if (offsetTop) {
                $('html, body').stop().animate({
                    scrollTop: offsetTop
                }, 350);
            }
        }
    }
    $(window).scroll(function () {
    	if( $('.aheto-header--fixed .main-header--vestry').length){
			if ($(this).scrollTop() > 10) {
				$('.aheto-header--fixed').addClass('vestry-header-scroll');
			} else {
				$('.aheto-header--fixed').removeClass('vestry-header-scroll');
			}
		}

    });

    /**
     * Prevent other events on main nav items(if namespace != to created  before)
     */

    $WIN.on("load", () => {
        //get target section ID
        if (localStorage.getItem('blockID')) {
            const targetID = localStorage.getItem('blockID');
            scrollTo(targetID);
            localStorage.removeItem('blockID');
        }

        setTimeout(() => {
            const $doc = $(document),
                $events = $menuItems.length ? $._data($doc[0], "events") : null;
            if ($events) {
                for (let i = $events.click.length - 1; i >= 0; i--) {
                    const handler = $events.click[i];
                    if (handler && handler.namespace != "djoNav" && handler.selector === 'a[href*="#"]') {
                        $doc.off("click", handler.handler);
                    }
                }
            }
        }, 300);
    });


    /**
     * Change links for inner pages
     */

    if (!isHome) {
        const homeUrl = $('.main-header--vestry .main-header__logo > a').attr('href');
        const linksArr = $mainHeader.find('.menu-item > a');

        linksArr.each(function () {
            const thisUrl = $(this).attr('href');

            //check if this link to ID
            if (thisUrl.indexOf("#") >= 0) {
                const newUrl = homeUrl;

                //save target id in data-atrribute
                $(this).attr('data-id', thisUrl);
                //set url to home page instead of ID
                $(this).attr('href', newUrl);
            }
        });
    }

})(jQuery, window, document);
