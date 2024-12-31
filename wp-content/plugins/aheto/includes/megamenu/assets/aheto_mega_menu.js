/**
 * This file holds the main javascript functions needed to improve the aheto mega menu backend
 */
(function($) {
    let aheto_mega_menu = {
        recalcTimeout: false,

        recalc : function() {
            let menuItems = $('.menu-item','#menu-to-edit');

            menuItems.each(function(i) {
                let item = $(this),
                    megaMenuCheckbox = $('.menu-item-aheto-megamenu', this);

                if(!item.is('.menu-item-depth-0')) {
                    let checkItem = menuItems.filter(':eq('+(i-1)+')');
                    if(checkItem.is('.aheto_mega_active')) {
                        item.addClass('aheto_mega_active');
                        megaMenuCheckbox.attr('checked','checked');
                    } else {
                        item.removeClass('aheto_mega_active');
                        megaMenuCheckbox.attr('checked','');
                    }
                }
            });
        },

        //clone of the jqery menu-item function that calls a different ajax admin action so we can insert our own walker
        addItemToMenu : function(menuItem, processMethod, callback) {
            let menu = $('#menu').val(),
                nonce = $('#menu-settings-column-nonce').val();

            processMethod = processMethod || function(){};
            callback = callback || function(){};

            let params = {
                'action': 'aheto_ajax_switch_menu_walker',
                'menu': menu,
                'menu-settings-column-nonce': nonce,
                'menu-item': menuItem
            };

            $.post( ajaxurl, params, function(menuMarkup) {
                let ins = $('#menu-instructions');
                processMethod(menuMarkup, params);
                if( ! ins.hasClass('menu-instructions-inactive') && ins.siblings().length )
                    ins.addClass('menu-instructions-inactive');
                callback();
            });
        }

    };



    $(function() {
        $(document).on('click', '.menu-item-aheto-megamenu,#menu-to-edit', function() {
            let checkbox = $(this),
                container = checkbox.parents('.menu-item:eq(0)');

            if(checkbox.is(':checked')) {
                container.addClass('aheto_mega_active');
            } else {
                container.removeClass('aheto_mega_active');
            }

            //check if anything in the dom needs to be changed to reflect the (de)activation of the mega menu
            aheto_mega_menu.recalc();

        });

        $(document).on('mouseup', '.menu-item-bar', function(event) {
            if(!$(event.target).is('a')) {
                clearTimeout(aheto_mega_menu.recalcTimeout);
                aheto_mega_menu.recalcTimeout = setTimeout(aheto_mega_menu.recalc, 500);
            }
        });

        aheto_mega_menu.recalc();
        if( typeof wpNavMenu !== 'undefined') {
            wpNavMenu.addItemToMenu = aheto_mega_menu.addItemToMenu;
        }
    });


})(jQuery);
