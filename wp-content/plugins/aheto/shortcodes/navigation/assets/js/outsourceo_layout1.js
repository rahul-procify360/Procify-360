;(function ($, window, document, undefined) {

    let $megaMenuBlock = $('.sub-menu.mega-menu');

    if ( $megaMenuBlock.length ) {

        $megaMenuBlock.each(function () {

        	if($('.menu-home-page-container').length){
				let $megaMenuItem = $(this).closest('.menu-item--mega-menu');

				if($megaMenuItem.length){
					let $megaMenuItemPosition = $megaMenuItem.offset().left - $('.menu-home-page-container').offset().left + 15;

					$(this).append('<span class="mega-menu-arrow"></span>');

					$(this).find('.mega-menu-arrow').css({
						'left' : ( $megaMenuItemPosition + 30 )
					})
				}
			}
        })
    }

})(jQuery, window, document);
