(function ($) {
    // Document Ready
    $(function () {
        var optionaPanel = {

            init: function () {
                this.search()

                $('.button-create-new').on('click', function (event) {
                    event.preventDefault()

                    $('#submit-cmb').trigger('click')
                })
            },

            search: function () {
                var self = this,
                    wrapper = $('.aheto-wrap-settings'),
                    searchOpts = wrapper.find('.aheto-search-options'),
                    input = searchOpts.find('input'),
                    panels = $('.cmb2-panel'),
                    container = $('.cmb2-panel-container'),
                    tabWrapper = container.find('>.cmb2-tabs-navigation'),
                    timer

                container.find('>.aheto-tabs-content').prepend('<div class="aheto-setting-search-empty">No results found.</div>')
                searchOpts.on('click', '.clear-search', function (event) {
                    event.preventDefault()
                    input.val('')
                    input.trigger('input')
                })

                input.on('input', function () {

                    if ('' === input.val()) {
                        wrapper.removeClass('searching')
                        panels.hide()
                        self.clearSearch(container, tabWrapper)
                        return false
                    }

                    clearTimeout(timer)
                    timer = setTimeout(function () {
                        wrapper.addClass('searching')
                        panels.show()
                        self.searchOptions(input.val().toLowerCase(), wrapper)
                    }, 200)
                })
            },

            searchOptions: function (query, container) {
                var self = this
                $('.cmb-row').hide().each(function () {
                    var row = $(this)

                    if (row.hasClass('cmb-type-title')) {
                        row.hide()
                    } else if (row.text().trim().toLowerCase().includes(query)) {
                        row.show()
                    }
                })

                var visibleRows = $('.cmb-row:visible')

                if (0 === visibleRows.length) {
                    container.addClass('search-no-results')
                } else {
                    container.removeClass('search-no-results')
                    visibleRows.each(function () {
                        $(this).find('input, select').each(function () {
                            $('span[data-field="' + $(this).attr('name') + '"]').each(function () {
                                self.loopDependencies($(this).closest('.cmb-dependency'))
                            })
                        })
                    })
                }
            },

            clearSearch: function (container, wrapper) {
                var target = localStorage.getItem(container.attr('id')),
                    nav = $('>a', wrapper),
                    self = this

                if (null === target) {
                    nav.eq(0).trigger('click')
                } else {
                    target = $('a[href=' + target + ']', wrapper)
                    if (target.length) {
                        target.trigger('click')
                    } else {
                        nav.eq(0).trigger('click')
                    }
                }

                $('.cmb-row').show()
                $('.cmb-dependency', '.cmb-form, .aheto-metabox-wrap').each(function () {
                    self.loopDependencies($(this))
                })
            }
        }

        optionaPanel.init();

        $('.cmb2-colorpicker, .color-picker').on('click', function (event) {
            $('.cmb2-colorpicker, .color-picker').iris('hide');
            $(this).iris('show');
            return false;
        });

		$(window).on('load', function () {
			if ($('.aheto_page_aheto-skin-generator').length ) {
				$(document).on('click', '.cmb2-tabs-content',function (e) {
					if (!$(e.target).is(".cmb2-colorpicker, .iris-picker, .iris-picker-inner") && $(e.target).closest('.cmb2-tabs-content')) {
						$('.cmb2-colorpicker').iris('hide');
					}
				});
			}
		});


        /*
         Filter
     */
        let arrayFilter = ['setting-panel-typography', 'setting-panel-buttons'];
        for (let i = 0; i < arrayFilter.length; i++) {
            const block = $('#' + arrayFilter[i])
            block.find('.js-filter').on('click', function () {
                block.find('.js-filter').removeClass('active');
                $(this).addClass('active');
                var $typographiItem = $(this).attr('data-filter');

                if ($typographiItem == 'all') {
                    block.find('.js-filterable').show();
                } else {
                    block.find('.js-filterable').hide();
                    block.find('.js-filterable[data-filter=' + $typographiItem + ']').show();
                }
            });
        }
        if ($("#setting-panel-blocks").length) {
            $('.close-js').on('click', function () {
                $(this).closest('.cmb2-id-info').remove();
            });
        }

        let allFonts = [];

		const event = new Event('input', {
			bubbles: false,
			cancelable: true,
		});
		const eventClick = new Event('click', {
			bubbles: false,
			cancelable: true,
		});

        function panel_skins() {
            const headingItem = document.querySelectorAll('.setting-panel-headings__item');
            [...headingItem].forEach((elem) => {
                let $fontFamilyValue = elem.querySelector('.select2-selection__rendered').getAttribute('title');
                if ($fontFamilyValue !== '') {
                    if (allFonts.indexOf($fontFamilyValue) === -1) {
                        allFonts.push($fontFamilyValue);
                    }
                }
            });

        }

        function panel_buttons() {

            //create object with elements
            let btnArray = [];

            var btn = $("#setting-panel-buttons .cmb-nested.cmb-field-list.cmb-repeatable-group");
            [...btn].forEach((item) => {
                btnArray.push([item.id.split("_repeat")[0], {}]);
            });

            let btnObj = Object.fromEntries(btnArray);

            for (let i = 0; i < btnArray.length; i++) {
                let a = btnArray[i][0] + '_0_';
                let items = $(`input[id*= ${a}], select[id*= ${a}]`);
                let array = [];
                [...items].forEach((item) => {
                    array.push([item.id, $("#" + item.id).val()]);
                });
                let object = Object.fromEntries(array);
                btnObj[btnArray[i][0]] = object;
            }

            //update element btn
            updateStyleBtn(btnObj.button, btnObj.button_primary, 'button', 'button_primary', '#button_primary');

            function updateStyleBtn(objKey, objChangeKey, option, option2, opnionChange) {
                for (const item in objKey) {
                    const b = item.split(option)[1];
                    let a = option2 + b;
                    if (!btnObj.button_primary[item] && objChangeKey[a] === objKey[item] || objChangeKey[a] === '' || objChangeKey[a] === null) {
                        objChangeKey[a] = objKey[item];
                        $(opnionChange + b).val(objKey[item]);
                        $(opnionChange + b).trigger('change');
                    }
                }
            }

            for (let item in btnObj.button) {
                const b = item.split('button')[1];
                let c = 'button_primary' + b;
                let allButtons = ['button_dark', 'button_light'];
                let a;
                let buttonItem;

                for (let index = 0, len = allButtons.length; index < len; ++index) {
                    buttonItem = allButtons[index];
                    a = buttonItem + '' + b;

                    if (btnObj[buttonItem][a] === '' || btnObj[buttonItem][a] === null || btnObj[buttonItem][a] === '#') {
                        btnObj[buttonItem][a] = btnObj.button_primary[c];
                        $('#' + buttonItem + '' + b).val(btnObj.button_primary[c]).trigger('change');
                    }
                }
            }

            let allButtons = ['button_primary_large', 'button_primary_small', 'button_dark_large', 'button_dark_small', 'button_light_large', 'button_light_small'];
            let allInlineButtons = ['button_inline', 'button_inline_dark', 'button_inline_light'];
            let allMainButtons = ['button_primary', 'button_dark', 'button_light'];
            let allVideoButtons = ['button_video', 'button_video_large', 'button_video_small'];

            for (let index = 0, len = allButtons.length; index < len; ++index) {
                buttonsChangeTypography(allButtons[index]);
            }
            for (let i = 0, len = allMainButtons.length; i < len; ++i) {
                buttonsMainChangeTypography(allInlineButtons[i], allMainButtons[i]);
            }

            function buttonsChangeTypography(button) {

                for (let item of Object.keys(btnObj[button])) {

                    let b = item.split('_0_')[1];

                    let buttonMain = button.replace('_large', '');
                    buttonMain = buttonMain.replace('_small', '');
                    let itemMain = item.replace('_large', '');
                    itemMain = item.replace('_small', '');

                    let a = button + '_0_' + b;

                    if (!btnObj[button][item] && btnObj[button][a] === btnObj[buttonMain][item] || btnObj[button][a] === '' || btnObj[button][a] === '#' || btnObj[button][a] === null) {
                        btnObj[button][a] = btnObj[buttonMain][item];
                        $('#' + button + '_0_' + b).val(btnObj[buttonMain][item]).trigger('change');
                    }

                    $('#' + a).change(function () {
                        btnObj[button][a] = $(this).val();
                    });

                }


            }

            function buttonsMainChangeTypography(inlineButton, mainButton) {

                for (let item of Object.keys(btnObj[mainButton])) {

                    let b = item.split('_0_')[1];

                    let large = '#' + mainButton + '_large_0_' + b;
                    let small = '#' + mainButton + '_small_0_' + b;
                    let itemBackground = mainButton + '_0_background';
                    let itemBackgroundHover = mainButton + '_0_background_hover';

                    $('#' + item).change(function () {

                        let value = $(this).val();

                        if (btnObj[mainButton][item] === btnObj[mainButton + '_large'][mainButton + '_large_0_' + b]) {
                            btnObj[mainButton + '_large'][mainButton + '_large_0_' + b] = value;
                            $(large).val(value).trigger('change');
                        }

                        if (btnObj[mainButton][item] === btnObj[mainButton + '_small'][mainButton + '_small_0_' + b]) {
                            btnObj[mainButton + '_small'][mainButton + '_small_0_' + b] = value;
                            $(small).val(value).trigger('change');
                        }

                        if (item === itemBackground && btnObj[mainButton][item] === btnObj[inlineButton][inlineButton + '_0_font_color']) {
                            btnObj[inlineButton][inlineButton + '_0_font_color'] = value;
                            $('#' + inlineButton + '_0_font_color').val(value).trigger('change');
                        }

                        if (item === itemBackgroundHover && btnObj[mainButton][item] === btnObj[inlineButton][inlineButton + '_0_font_color_hover']) {
                            btnObj[inlineButton][inlineButton + '_0_font_color_hover'] = value;
                            $('#' + inlineButton + '_0_font_color_hover').val(value).trigger('change');
                        }

                        if (item === 'button_primary_0_background') {
                            $(this).closest('#setting-panel-buttons').find('#button_video_repeat .title-js').css({
                                "background-color": $(this).val(),
                            });
                            $(this).closest('#setting-panel-buttons').find('#button_video_large_repeat .title-js').css({
                                "background-color": $(this).val(),
                            });
                            $(this).closest('#setting-panel-buttons').find('#button_video_small_repeat .title-js').css({
                                "background-color": $(this).val(),
                            });
                        }
                        if (item === 'button_primary_0_color') {
                            $(this).closest('#setting-panel-buttons').find('#button_video_repeat .title-js').css({
                                "color": $(this).val(),
                            });
                            $(this).closest('#setting-panel-buttons').find('#button_video_large_repeat .title-js').css({
                                "color": $(this).val(),
                            });
                            $(this).closest('#setting-panel-buttons').find('#button_video_small_repeat .title-js').css({
                                "color": $(this).val(),
                            });
                        }

                        btnObj[mainButton][item] = value;


                    });


                }


            }

            for (const item in btnObj.button_inline) {

                let allInlineButtons = ['button_inline_dark', 'button_inline_light'];
                let allInlineBtn = ['button_inline', 'button_inline_dark', 'button_inline_light'];

                const key = item.split('button_inline')[1];

                for (let i = 0, len = allInlineButtons.length; i < len; ++i) {

                    let boxBtn = allInlineButtons[i].replace('_inline', '');

                    let btnKey = allInlineButtons[i] + key;

                    if (btnObj[allInlineButtons[i]][btnKey] === '' || btnObj[allInlineButtons[i]][btnKey] === null || btnObj[allInlineButtons[i]][btnKey] === '#') {
                        btnObj[allInlineButtons[i]][btnKey] = btnObj.button_inline[item];
                        $('#' + allInlineButtons[i] + '' + key).val(btnObj.button_inline[item]).trigger('change');

                    }

                    $('#' + btnKey).change(function () {
                        btnObj[allInlineButtons[i]][btnKey] = $(this).val();
                    });

                    $('#' + item).change(function () {
                        let value = $(this).val();
                        let inlBtn = '#' + allInlineButtons[i] + key;
                        if (btnObj.button_inline[item] === btnObj[allInlineButtons[i]][allInlineButtons[i] + key]) {
                            btnObj[allInlineButtons[i]][allInlineButtons[i] + key] = value;
                            $(inlBtn).val(value).trigger('change');
                        }
                        btnObj.button_inline[item] = value;
                    });

                    if (btnObj[[allInlineButtons[i]]]) {
                        if (btnObj[allInlineButtons[i]][allInlineButtons[i] + '_0_font_color'] === '#') {
                            btnObj[allInlineButtons[i]][allInlineButtons[i] + '_0_font_color'] = btnObj[boxBtn][boxBtn + '_0_background'];
                            $('#' + allInlineButtons[i] + '_0_font_color').val(btnObj[boxBtn][boxBtn + '_0_background']).trigger('change');
                        }
                        if (btnObj[allInlineButtons[i]][allInlineButtons[i] + '_0_font_color_hover'] === '#') {
                            btnObj[allInlineButtons[i]][allInlineButtons[i] + '_0_font_color_hover'] = btnObj[boxBtn][boxBtn + '_0_background_hover'];
                            $('#' + allInlineButtons[i] + '_0_font_color_hover').val(btnObj[boxBtn][boxBtn + '_0_background_hover']).trigger('change');
                        }

                        $('#' + allInlineButtons[i] + '_0_font_color').on("change paste keyup", function () {
                            $(this).closest('.cmb-type-group').find('.title-js').css({"color": $(this).val()});
                            btnObj[allInlineButtons[i]][allInlineButtons[i] + '_0_font_color'] = $(this).val();
                        });
                        $('#' + allInlineButtons[i] + '_0_font_color_hover').on("change paste keyup", function () {
                            btnObj[allInlineButtons[i]][allInlineButtons[i] + '_0_font_color_hover'] = $(this).val();
                        });
                    }


                }

                if (btnObj.button_inline) {
                    if (btnObj.button_inline.button_inline_0_font_color === '#') {
                        btnObj.button_inline.button_inline_0_font_color = btnObj.button_primary.button_primary_0_background
                        $(button_inline_0_font_color).val(btnObj.button_primary.button_primary_0_background);
                        $(button_inline_0_font_color).closest('.cmb-type-group').find('.title-js').css({"color": btnObj.button_primary.button_primary_0_background});
                        $(button_inline_0_font_color).trigger('change');
                    }
                    if (btnObj.button_inline.button_inline_0_font_color_hover === '#') {
                        btnObj.button_inline.button_inline_0_font_color_hover = btnObj.button_primary.button_primary_0_background_hover
                        $(button_inline_0_font_color_hover).val(btnObj.button_primary.button_primary_0_background_hover);
                        $(button_inline_0_font_color_hover).trigger('change');
                    }

                    $(button_inline_0_font_color).on("change paste keyup", function () {
                        $(this).closest('.cmb-type-group').find('.title-js').css({"color": $(this).val()});
                        btnObj.button_inline.button_inline_0_font_color = $(this).val();
                    });
                    $(button_inline_0_font_color_hover).on("change paste keyup", function () {
                        btnObj.button_inline.button_inline_0_font_color_hover = $(this).val();
                    });
                }

                for (let i = 0, len = allInlineBtn.length; i < len; ++i) {

                    if (btnObj[allInlineBtn[i]]) {
                        $('#' + allInlineBtn[i] + '_0_font_color').closest('.cmb-row.cmb-repeat-group-wrap').find('.title-js').hover(function () {
                            $(this).css("color", btnObj[allInlineBtn[i]][allInlineBtn[i] + '_0_font_color_hover']);
                        }, function () {
                            $(this).css("color", btnObj[allInlineBtn[i]][allInlineBtn[i] + '_0_font_color']);
                        });
                    }

                    if (btnObj[allInlineBtn[i]] && btnObj[allInlineBtn[i]][allInlineBtn[i] + '_0_font_color'] !== '#') {
                        $('#' + [allInlineBtn[i]] + '_0_font_color').closest('.cmb-type-group').find('.title-js').css({"color": btnObj[allInlineBtn[i]][allInlineBtn[i] + '_0_font_color']});
                    }

                }

            }

            if (btnObj.button_video) {

                for (let i = 0, len = allVideoButtons.length; i < len; ++i) {

                    $('#' + allVideoButtons[i] + '_0_btn_size').closest('.cmb-row.cmb-repeat-group-wrap').find('.title-js').css({
                        "color": btnObj.button_primary.button_primary_0_color,
                        "background-color": btnObj.button_primary.button_primary_0_background,
                        "width": btnObj[allVideoButtons[i]][allVideoButtons[i] + '_0_btn_size'],
                        "height": btnObj[allVideoButtons[i]][allVideoButtons[i] + '_0_btn_size'],
                        "display": "flex",
                        "justify-content": "center",
                        "align-items": "center",
                        "border-radius": "50%"
                    });

                    $('#' + allVideoButtons[i] + '_0_btn_size').on("input", function () {
                        btnObj[allVideoButtons[i]][allVideoButtons[i] + '_0_btn_size'] = $(this).val();
                        $(this).closest('.cmb-row.cmb-repeat-group-wrap').find('.title-js').css({
                            "width": btnObj[allVideoButtons[i]][allVideoButtons[i] + '_0_btn_size'],
                            "height": btnObj[allVideoButtons[i]][allVideoButtons[i] + '_0_btn_size'],
                        });
                    });
                    $('#' + allVideoButtons[i] + '_0_font_size').on("input", function () {
                        btnObj[allVideoButtons[i]][allVideoButtons[i] + '_0_font_size'] = $(this).val();
                        $(this).closest('.cmb-row.cmb-repeat-group-wrap').find('.title-js').css({
                            "font-size": btnObj[allVideoButtons[i]][allVideoButtons[i] + '_0_font_size'],
                        });
                    });

                }

            }

            const btnStyling = document.querySelector('#setting-panel-buttons');
            if (btnStyling) {
                const btnItem = btnStyling.querySelectorAll('.cmb-row.cmb-repeat-group-wrap');

                const responsiveDesktop = btnStyling.querySelector('.typography-responsive .icon-desktop-js');
                const responsiveTablet = btnStyling.querySelector('.typography-responsive .icon-tablet-js');
                const responsiveMobile = btnStyling.querySelector('.typography-responsive .icon-mobile-js');
				const buttonsPanel = document.querySelector('#setting-panel-buttons');

                if (responsiveDesktop) {
                    responsiveDesktop.classList.add('active');
                    responsiveDesktop.addEventListener("click", showDTM.bind(null, 'desktop'));
                }
                if (responsiveTablet) {
                    responsiveTablet.addEventListener("click", showDTM.bind(null, 'tablet'));
                }
                if (responsiveMobile) {
                    responsiveMobile.addEventListener("click", showDTM.bind(null, 'mobile'));
                }


				[...btnItem].forEach((elem) => {
					[...elem.querySelectorAll(".fa-desktop")].forEach((el) => {
						el.addEventListener('click', (e) => {
							if(!buttonsPanel.querySelector('.typography-responsive .icon-desktop-js').classList.contains('active') && e.isTrusted) {
								buttonsPanel.querySelector('.typography-responsive .icon-desktop-js').click();
							}
						});
					});
					[...elem.querySelectorAll(".fa-tablet-alt")].forEach((el) => {
						el.addEventListener('click', (e) => {
							if(!buttonsPanel.querySelector('.typography-responsive .icon-tablet-js').classList.contains('active') && e.isTrusted) {
								buttonsPanel.querySelector('.typography-responsive .icon-tablet-js').click();
							}
						});
					});
					[...elem.querySelectorAll(".fa-mobile-alt")].forEach((el) => {
						el.addEventListener('click', (e) => {
							if(!buttonsPanel.querySelector('.typography-responsive .icon-mobile-js').classList.contains('active') && e.isTrusted) {
								buttonsPanel.querySelector('.typography-responsive .icon-mobile-js').click();
							}
						});
					});
				});

                function showDTM(tab = '') {

                    let responsiveItem = document.querySelectorAll('.' + tab);
                    let responsiveIcon;
                    let responsiveItemSub;
                    let responsiveItemInputs = '';
                    const responsiveTabs = ['desktop', 'tablet', 'mobile'];
                    let responsiveBreak = tab !== 'desktop' ? tab + '-alt' : tab;

                    if ('desktop' !== tab) {
                        responsiveItemInputs = tab + '_';
                    }


                    [...btnItem].forEach((elem) => {

                        let btnPaddingVertical = elem.querySelector('input[id*="_0_' + responsiveItemInputs + 'padding_vertical"]');
						let btnPaddingHorizontal = elem.querySelector('input[id*="_0_' + responsiveItemInputs + 'padding_horizontal"]');
						let btnPaddingUnits = elem.querySelector('select[id*="_0_' + responsiveItemInputs + 'padding_units"]');
						let title = elem.querySelector('.title-js');

						const allItems = elem.querySelectorAll(".fa-" + responsiveBreak);
						const input = elem.querySelectorAll('.has-responsive-input .cmb2-text-small');
						[...allItems].forEach((item) => {

							if(!item.classList.contains('active') ){
								item.dispatchEvent(eventClick);
							}

						});

						[...input].forEach((item) => {
							item.dispatchEvent(event);
						});

                        buttonSize(btnPaddingVertical, btnPaddingUnits, 'paddingTop', 'paddingBottom', title);
                        buttonSize(btnPaddingHorizontal, btnPaddingUnits, 'paddingLeft', 'paddingRight', title);
                        UpdateUnit(btnPaddingUnits, btnPaddingVertical, btnPaddingHorizontal, title);
                    });

                    for (let index = 0, len = responsiveTabs.length; index < len; ++index) {

                        responsiveIcon = btnStyling.querySelector('.typography-responsive .icon-' + responsiveTabs[index] + '-js');

                        if (responsiveTabs[index] !== tab) {

                            responsiveIcon.classList.remove('active');

                            responsiveItemSub = document.querySelectorAll('.' + responsiveTabs[index]);

                            [...responsiveItemSub].forEach((item) => {
                                if (item) {
                                    item.closest('.cmb-row.cmb-type-spacing').style.display = 'none';
                                }
                            });

                        }

                    }

                    btnStyling.querySelector('.typography-responsive .icon-' + tab + '-js').classList.add('active');

                    [...responsiveItem].forEach((item) => {
                        if (item) {
                            item.closest('.cmb-row.cmb-type-spacing').style.display = 'block';
                        }
                    });

                }

                function buttonSize(btnSizeСhange, btnSizeUnits, styleValueTop, styleValueBottom, example) {
                    if (btnSizeСhange) {
                        if (btnSizeСhange.value !== '') {
                            example.style[styleValueTop] = btnSizeСhange.value + btnSizeUnits.value;
                            example.style[styleValueBottom] = btnSizeСhange.value + btnSizeUnits.value;
                        } else {
                            example.style[styleValueTop] = '0';
                            example.style[styleValueBottom] = '0';
                        }
                        btnSizeСhange.addEventListener('input', (e) => updateButtonSize(e, btnSizeUnits, styleValueTop, styleValueBottom, example));
                    }

                }

                function UpdateUnit(unit, horizontal, vertical, example) {
                    if (unit) {
                        unit.onchange = function () {
                            example.style.paddingLeft = horizontal.value + unit.value;
                            example.style.paddingRight = horizontal.value + unit.value;
                            example.style.paddingTop = vertical.value + unit.value;
                            example.style.paddingBottom = vertical.value + unit.value;
                        }
                    }
                }

                function updateButtonSize(e, btnSizeUnits, styleValueTop, styleValueBottom, example) {
                    if (e.target.value !== '') {
                        example.style[styleValueTop] = e.target.value + btnSizeUnits.value;
                        example.style[styleValueBottom] = e.target.value + btnSizeUnits.value;
                    } else {
                        example.style[styleValueTop] = '0';
                        example.style[styleValueBottom] = '0';
                    }
                }

                showDTM('desktop');
                [...btnItem].forEach((elem) => {
                    if (elem) {
                        let btnFontFamily = elem.querySelector('select[id*="_font_font_family"]');
                        let btnFontWeight = elem.querySelector('select[id*="_0_font_font_weight"]');
						let btnFontSize = (elem.querySelector('input[id*="_0_font_font_size"]') !== null) ?  elem.querySelector('input[id*="_0_font_font_size"]').closest('.col').lastChild : '';
						let btnLineHeight = (elem.querySelector('input[id*="_0_font_line_height"]') !== null) ?  elem.querySelector('input[id*="_0_font_line_height"]').closest('.col').lastChild : '';
						let btnLetterSpasing = (elem.querySelector('input[id*="_0_font_letter_spacing"]') !== null) ?  elem.querySelector('input[id*="_0_font_letter_spacing"]').closest('.col').lastChild : '';
                        let btnBorderRadius = elem.querySelector('input[id*="_border_radius"]');
                        const titleInfo = elem.querySelector('.typography-info__shot');
                        let btnFontFamilyValue;
                        const title = elem.querySelector('.title-js');
                        const titleAll = elem.querySelectorAll('.title-js');
                        let fontFlag = false;
                        let weightFlag = false;
                        let sizeFlag = false;
                        let lineHeightFlag = false;
                        let letterSpasingFlag = false;

                        btnFont(btnFontSize, 'fontSize', 'font-size', title);
                        btnFont(btnLetterSpasing, 'letterSpacing', 'letter-spacing', title);
                        btnFont(btnLineHeight, 'lineHeight', 'line-height', title);
                        btnRadius(btnBorderRadius, 'borderRadius', 'border-radius');

                        updateFontWeight(btnFontWeight, title);
                        if (btnFontFamily) {
                            if (btnFontFamily.value !== '') {
                                btnFontFamilyValue = btnFontFamily.value.split(',');
                                if (allFonts.indexOf(btnFontFamilyValue.toString()) === -1) {
                                    allFonts.push(btnFontFamilyValue.toString());
                                }
                                [...titleAll].forEach((item) => {
                                    item.style.fontFamily = btnFontFamilyValue;
                                });
                                if (btnFontFamily.value !== '') {
                                    createElement('font-family', btnFontFamily.value);
                                    fontFlag = true;
                                }
                            }
                            btnFontFamily.onchange = function () {
                                btnFontFamilyValue = elem.querySelector('.select2-selection__rendered').getAttribute('title') ? elem.querySelector('.select2-selection__rendered').getAttribute('title').split(',') : '';
                                if (btnFontFamilyValue !== '') {
                                    [...titleAll].forEach((item) => {
                                        item.style.fontFamily = btnFontFamilyValue;
                                    });
                                    if (allFonts.indexOf(btnFontFamilyValue.toString()) === -1) {
                                        allFonts.push(btnFontFamilyValue.toString());
                                    }
                                    getFontFamily();
                                } else {
                                    [...titleAll].forEach((item) => {
                                        item.style.fontFamily = '';
                                    });

                                }
                                if (fontFlag !== true) {
                                    createElement('font-family', btnFontFamily.value);
                                } else {
                                    updateElement('font-family', btnFontFamily.value);
                                }
                                if (btnFontFamilyValue == '') {
                                    remuveElement('font-family')
                                }
                            }
                        }

                        function updateFontWeight(btnFontWeight, title) {

                            if (btnFontWeight) {
                                if (btnFontWeight.value !== '') {
                                    title.style.fontWeight = parseFloat(btnFontWeight.value);
                                    createElement('font-weight', btnFontWeight.value);
                                    weightFlag = true;
                                }
                                btnFontWeight.onchange = function () {
                                    title.style.fontWeight = parseFloat(this.value);
                                    if (weightFlag !== true) {
                                        createElement('font-weight', btnFontWeight.value);
                                    } else {
                                        updateElement('font-weight', btnFontWeight.value);
                                    }
                                    if (btnFontWeight.value == '') {
                                        remuveElement('font-weight')
                                    }
                                }
                            }
                        }

                        function btnFont(btnFontStyle, btnCssStyle, btnClass, example) {

                            if (btnFontStyle && btnFontStyle.value !== '') {
                                example.style[btnCssStyle] = btnFontStyle.value;
                            }
                            if (btnFontStyle) {
                                btnFontStyle.addEventListener('input', (e) => updateBtnFont(e, btnFontStyle, btnCssStyle, example));
                            }
                        }

                        function updateBtnFont(e, btnFontStyle, btnCssStyle, example) {
                            if (btnFontStyle.value !== '') {
                                example.style[btnCssStyle] = btnFontStyle.value;

                            } else {
                                example.style[btnCssStyle] = '';
                            }
                        }

                        function btnRadius(btnFontStyle, btnCssStyle, btnClass) {
                            if (btnFontStyle && btnFontStyle.value !== '') {
                                [...titleAll].forEach((item) => {
                                    item.style[btnCssStyle] = parseFloat(btnFontStyle.value) + 'px';
                                });
                            }
                            if (btnFontStyle) {
                                btnFontStyle.addEventListener('input', (e) => updatebtnRadius(e, btnFontStyle, btnCssStyle, btnClass));
                            }

                        }

                        function updatebtnRadius(e, btnFontStyle, btnCssStyle) {
                            if (btnFontStyle.value !== '') {
                                [...titleAll].forEach((item) => {
                                    item.style[btnCssStyle] = parseFloat(btnFontStyle.value) + 'px';
                                });
                            } else {
                                [...titleAll].forEach((item) => {
                                    item.style[btnCssStyle] = '';
                                });
                            }
                        }


                        if (btnFontSize.length) {

                            if (btnFontSize.value !== '') {
                                createElement('font-size', btnFontSize.value);
                                sizeFlag = true;
                            }
                            btnFontSize.onchange = function () {
                                if (sizeFlag !== true) {
                                    createElement('font-size', btnFontSize.value);
                                } else {
                                    updateElement('font-size', btnFontSize.value);
                                }
                                if (btnFontSize.value == '') {
                                    remuveElement('font-size')
                                }
                            }
                        }


                        if (btnLineHeight.length) {
                            if (btnLineHeight.value !== '') {
                                createElement('line-height', btnLineHeight.value);
                                lineHeightFlag = true;
                            }
                            btnLineHeight.onchange = function () {
                                if (btnLineHeight.value !== '') {
                                    if (lineHeightFlag !== true) {
                                        createElement('line-height', btnLineHeight.value);
                                    } else {
                                        updateElement('line-height', btnLineHeight.value);
                                    }
                                }
                                if (btnLineHeight.value == '') {
                                    remuveElement('line-height')
                                }
                            }
                        }
                        if (btnLetterSpasing.length) {
                            if (btnLetterSpasing.value !== '') {
                                createElement('letter-spacing', btnLetterSpasing.value);
                                letterSpasingFlag = true;
                            }
                            btnLetterSpasing.onchange = function () {
                                if (btnLetterSpasing.value !== '') {
                                    if (letterSpasingFlag !== true) {
                                        createElement('letter-spacing', btnLetterSpasing.value);
                                    } else {
                                        updateElement('letter-spacing', btnLetterSpasing.value);
                                    }
                                }
                                if (btnLetterSpasing.value == '') {
                                    remuveElement('letter-spacing')
                                }
                            }
                        }


                        function createElement(style, value) {
                            let infoFontFamily = document.createElement("span");
                            infoFontFamily.classList.add(style);
                            infoFontFamily.innerHTML = value;
                            titleInfo.append(infoFontFamily);
                        }

                        function updateElement(style, value) {
                            elem.querySelector('.' + style).innerHTML = value;
                        }

                        function remuveElement(style) {
                            titleInfo.querySelector('.' + style).remove();
                        }

                    }
                });

                $("#setting-panel-buttons .cmb-row.cmb-repeat-group-wrap").each(function () {
                    let colorBtn = $(this).find("input[id*='_0_color']");
                    let colorBtnValue = colorBtn.val();
                    let backgroundBtn = $(this).find("input[id*='_0_background']");
                    let backgroundBtnValue = backgroundBtn.val();
                    let colorBtnHover = $(this).find("input[id*='_0_color_hover']").val();
                    let backgroundBtnHover = $(this).find("input[id*='_background_hover']").val();

                    const boxShadowV = $(this).find("input[id*='_0_box_shadow_voffset']");
                    const boxShadowH = $(this).find("input[id*='_0_box_shadow_hoffset']");
                    const boxShadowB = $(this).find("input[id*='_0_box_shadow_blur']");
                    const boxShadowS = $(this).find("input[id*='_0_box_shadow_spread']");
                    const boxShadowC = $(this).find("input[id*='_0_box_shadow_color']");
                    const boxShadowI = $(this).find("select[id*='_0_box_shadow_inset']");

                    const borderW = $(this).find("input[id*='_0_border_all']");
                    const borderS = $(this).find("select[id*='_0_border_style']");
                    const borderC = $(this).find("input[id*='_0_border_color']");
                    const borderH = $(this).find("input[id*='_0_border_hover']");

                    if (borderW.length) {
                        const getValueBorder = () => {
                            borderWidth = borderW.val();
                            borderStyle = borderS.val();
                            borderColor = borderC.val();
                            borderHover = borderH.val();
                        }
                        getValueBorder();


                        const setBorder = () => {
                            if (borderWidth.length && borderStyle.length && borderStyle !== 'none') {
                                $(this).find('.title-js').css('border', borderWidth + ' ' + borderStyle + (borderC && borderColor !== '#' ? ' ' + borderColor : ''));
                                $(this).find('.example-js').css('border', borderWidth + ' ' + borderStyle + (borderC && borderColor !== '#' ? ' ' + borderColor : ''));
                            } else {
                                $(this).find('.title-js').css('border', 'none');
                                $(this).find('.example-js').css('border', 'none');
                            }

                        }

                        setBorder();

                        $(this).find('.title-js').hover(function () {
                            $(this).css("border-color", borderHover);
                        }, function () {
                            $(this).css("border-color", borderColor);
                        });
                        $(this).find('.example-js').hover(function () {
                            $(this).css("border-color", borderHover);
                        }, function () {
                            $(this).css("border-color", borderColor);
                        });

                        const borders = [borderW, borderS, borderC, borderH];
                        borders.forEach(item => {
                            item.on('change', () => {
                                getValueBorder();
                                setBorder();
                            })
                        });
                    }
                    if (boxShadowV.length) {
                        const getValue = () => {
                            boxShadowVertival = boxShadowV.val();
                            boxShadowHorizontal = boxShadowH.val();
                            boxShadowBlur = boxShadowB.val();
                            boxShadowSpread = boxShadowS.val();
                            boxShadowColor = boxShadowC.val();
                            boxShadowInset = boxShadowI.val();
                        }
                        getValue();
                        const setShadow = () => {
                            if (boxShadowVertival.length && boxShadowHorizontal.length && boxShadowBlur.length && boxShadowSpread.length && boxShadowColor.length && boxShadowColor !== '#') {
                                $(this).find('.title-js').css('box-shadow', (boxShadowInset !== 'Outset' ? boxShadowInset + ' ' : '') + boxShadowHorizontal + ' ' + boxShadowVertival + ' ' + boxShadowBlur + ' ' + boxShadowSpread + ' ' + boxShadowColor);
                                $(this).find('.example-js').css('box-shadow', (boxShadowInset !== 'Outset' ? boxShadowInset + ' ' : '') + boxShadowHorizontal + ' ' + boxShadowVertival + ' ' + boxShadowBlur + ' ' + boxShadowSpread + ' ' + boxShadowColor);
                            } else {
                                $(this).find('.title-js').css('box-shadow', 'none');
                                $(this).find('.example-js').css('box-shadow', 'none');
                            }
                        }
                        setShadow();
                        const inputs = [boxShadowV, boxShadowH, boxShadowB, boxShadowS, boxShadowC, boxShadowI];
                        inputs.forEach(item => {
                            item.on('change', () => {
                                getValue();
                                setShadow();
                            })
                        });
                    }

                    if (backgroundBtn.length) {
                        $(this).find('.title-js').css("background-color", backgroundBtnValue);
                        $(this).find('.example-js').css("background-color", backgroundBtnValue);
                    }
                    if (colorBtn.length) {
                        $(this).find('.title-js').css("color", colorBtnValue);
                        $(this).find('.example-js').css("color", colorBtnValue);
                    }
                    $(this).find("input[id*='_0_background']").not("input[id*='_0_background_hover']").on("change paste keyup", function () {
                        $(this).closest('.cmb-type-group').find('.title-js').css({"background": $(this).val()});
                        $(this).closest('.cmb-type-group').find('.example-js').css({"background": $(this).val()});
                        return backgroundBtnValue = $(this).val();
                    });
                    $(this).find("input[id*='_0_color']").not("input[id*='_0_color_hover']").on("change paste keyup", function () {
                        $(this).closest('.cmb-type-group').find('.title-js').css({"color": $(this).val()});
                        $(this).closest('.cmb-type-group').find('.example-js').css({"color": $(this).val()});
                        return colorBtnValue = $(this).val();
                    });
                    $(this).find("input[id*='_0_background_hover']").on("change paste keyup", function () {
                        return backgroundBtnHover = $(this).val();
                    });
                    $(this).find("input[id*='_0_color_hover']").on("change paste keyup", function () {
                        return colorBtnHover = $(this).val();
                    });
                    $(this).find('.title-js').hover(function () {
                        $(this).css("background-color", backgroundBtnHover);
                        $(this).css("color", colorBtnHover);
                    }, function () {
                        $(this).css("background-color", backgroundBtnValue);
                        $(this).css("color", colorBtnValue);
                    });
                    $(this).find('.example-js').hover(function () {
                        $(this).css("background-color", backgroundBtnHover);
                        $(this).css("color", colorBtnHover);
                    }, function () {
                        $(this).css("background-color", backgroundBtnValue);
                        $(this).css("color", colorBtnValue);
                    });
                });
                const fontSkins = document.querySelectorAll('.skins__inner .font-family');
                [...fontSkins].forEach((elem) => {
                    if (allFonts.indexOf(elem.innerText) === -1) {
                        allFonts.push(elem.innerText);
                    }
                });
                getFontFamily();
            }
        }

        function panel_colors() {
            const defaultColors = document.querySelector('.default-color-js');

            for (const items in window.colors) {
                const colorItems = document.createElement("ul");
                colorItems.classList.add('default-color__items');
                colorItems.id = items.toString();
                defaultColors.append(colorItems);
                const colorItem = window.colors[items];
                for (const item in colorItem) {
                    const colorElement = document.createElement("li");
                    colorElement.classList.add('default-color__element');
                    colorItems.append(colorElement);
                    colorElement.style.backgroundColor = window.colors[items][item];
                }
                colorItems.addEventListener("click", (e) => updateColor(e, colorItem, colorItems));
            }

            let allColors = document.querySelectorAll('.default-color__items');

            function updateColor(e, colorItem, colorItems) {

                const colorElement = Object.keys(colorItem);
                [...allColors].forEach((item) => {
                    item.classList.remove("active");
                });
                colorItems.classList.add('active');

                for (const element  in colorElement) {
                    let a = colorElement[element];
                    let b = $('#' + a);
                    b.val(colorItem[a]);
                    b.trigger('change');
                }
            }

            for (const items in window.colors) {
                let colors = window.colors[items];
                let a = 0;
                for (const element in colors) {
                    if (window.colors[items][element] == $('#' + element).val()) {
                        a++
                    }
                }
                if (a === 8) {
                    $('#' + items).addClass('active');
                }

            }
        }

        function panel_typography() {

            // Responsive Tabs

            const heading = document.querySelector('#setting-panel-typography');
            const headingItem = document.querySelectorAll('.setting-panel-headings__item');
            if (heading) {
                const responsiveHeadingDesktop = heading.querySelector('.typography-responsive .icon-desktop-js');
                const responsiveHeadingTablet = heading.querySelector('.typography-responsive .icon-tablet-js');
                const responsiveHeadingMobile = heading.querySelector('.typography-responsive .icon-mobile-js');
                responsiveHeadingDesktop.classList.add('active');
                responsiveHeadingDesktop.addEventListener('click', () => {

                    if( !responsiveHeadingDesktop.classList.contains('active')) {

                        responsiveHeadingDesktop.classList.add('active');
                        responsiveHeadingTablet.classList.remove('active');
                        responsiveHeadingMobile.classList.remove('active');

                        [...headingItem].forEach((elem) => {

                            const allDesktop = elem.querySelectorAll(".fa-desktop");
                            const input = elem.querySelectorAll('.has-responsive-input .cmb2-text-small');
                            [...allDesktop].forEach((item) => {
                                item.dispatchEvent(eventClick);
                            });

                            [...input].forEach((item) => {
                                item.dispatchEvent(event);
                            });
                        });
                    }

                }, false);

                responsiveHeadingTablet.addEventListener('click', () => {
                    if( !responsiveHeadingTablet.classList.contains('active')){
                        responsiveHeadingDesktop.classList.remove('active');
                        responsiveHeadingMobile.classList.remove('active');
                        responsiveHeadingTablet.classList.add('active');
                        [...headingItem].forEach((elem) => {
                            const allTablet = elem.querySelectorAll(".fa-tablet-alt");
                            const input = elem.querySelectorAll('.has-responsive-input .cmb2-text-small');
                            [...allTablet].forEach((elem) => {
                                elem.dispatchEvent(eventClick);
                            });
                            [...input].forEach((item) => {
                                item.dispatchEvent(event);
                            });
                        });
                    }


                }, false);
                responsiveHeadingMobile.addEventListener('click', () => {
                    if( !responsiveHeadingMobile.classList.contains('active')) {
                        responsiveHeadingDesktop.classList.remove('active');
                        responsiveHeadingTablet.classList.remove('active');
                        responsiveHeadingMobile.classList.add('active');
                        [...headingItem].forEach((elem) => {
                            const allMobile = elem.querySelectorAll(".fa-mobile-alt");
                            const input = elem.querySelectorAll('.has-responsive-input .cmb2-text-small');
                            [...allMobile].forEach((elem) => {
                                elem.dispatchEvent(eventClick);
                            });
                            [...input].forEach((item) => {
                                item.dispatchEvent(event);
                            });
                        });
                    }
                }, false);


                [...headingItem].forEach((elem) => {

                    const allDesktop = elem.querySelectorAll(".fa-desktop");
                    const allTablet = elem.querySelectorAll(".fa-tablet-alt");
                    const allMobile = elem.querySelectorAll(".fa-mobile-alt");
                    const typoghraphy = elem.querySelector('.example-js');
                    const title = elem.querySelector('.title-js');
                    const titleInfo = elem.querySelector('.typography-info__shot');
                    const $fontFamily = elem.querySelector('select[id*="_font_family"]');
                    const $fontWeight = elem.querySelector('select[id*="_font_weight"]');
                    const $fontTransfotm = elem.querySelector('select[id*="_transform"]');
                    const $fontColor = elem.querySelector('.wp-color-result');
                    const $fontSize = elem.querySelector('input[id*="_font_size"]');
                    const responFontSize = elem.querySelector('input[id*="_font_size"]') ? elem.querySelector('input[id*="_font_size"]').closest('.col').lastChild : '';
                    const $lineHeight = elem.querySelector('input[id*="_line_height"]');
                    const responLineHeight = elem.querySelector('input[id*="_line_height"]') ? elem.querySelector('input[id*="_line_height"]').closest('.col').lastChild : '';
                    const $letterSpacing = elem.querySelector('input[id*="_letter_spacing"]');
                    const responLetterSpacing = elem.querySelector('input[id*="_letter_spacing"]') ? elem.querySelector('input[id*="_letter_spacing"]').closest('.col').lastChild : '';
                    let $fontFamilyValue = elem.querySelector('.select2-selection__rendered').getAttribute('title');
                    let $fontColorValue = window.getComputedStyle($fontColor, null).getPropertyValue("background-color");

                    if ($fontFamily) {
                        let $fontFamilyNewValue;
                        let createFont = false;
                        if ($fontFamilyValue !== null) {
                            $fontFamilyNewValue = $fontFamilyValue.split(',')[0];
                            if (($fontFamilyNewValue !== '')) {
                                let infoFontFamily = document.createElement("span");
                                infoFontFamily.classList.add('font-family');
                                infoFontFamily.innerHTML = $fontFamilyNewValue;
                                titleInfo.append(infoFontFamily);
                                createFont = true;
                            }
                        }
                        typoghraphy.style.fontFamily = $fontFamilyValue;
                        title.style.fontFamily = $fontFamilyValue;
                        if ($fontFamilyValue !== '') {
                            if (allFonts.indexOf($fontFamilyValue) === -1) {
                                allFonts.push($fontFamilyValue);
                            }
                        }
                        $fontFamily.onchange = function () {
                            $fontFamilyValue = elem.querySelector('.select2-selection__rendered').getAttribute('title');
                            if ($fontFamilyValue !== null) {
                                $fontFamilyNewValue = $fontFamilyValue.split(',')[0];
                                typoghraphy.style.fontFamily = $fontFamilyValue;
                                title.style.fontFamily = $fontFamilyValue;
                                if (($fontFamily.value !== '' && createFont !== true)) {
                                    let infoFontFamily = document.createElement("span");
                                    infoFontFamily.classList.add('font-family');
                                    infoFontFamily.innerHTML = $fontFamilyNewValue;
                                    titleInfo.append(infoFontFamily);
                                    createFont = true;
                                }
                                if ((createFont == true)) {
                                    elem.querySelector('.font-family').innerHTML = $fontFamilyNewValue;
                                }
                                if (($fontFamily.value == '')) {
                                    titleInfo.querySelector('.font-family').remove();
                                }
                                if (allFonts.indexOf($fontFamilyNewValue) === -1) {
                                    allFonts.push($fontFamilyNewValue);
                                }
                                getFontFamily()
                            }

                        }
                    }
                    if ($fontColor) {
                        typoghraphy.style.color = $fontColorValue;
                        title.style.color = $fontColorValue;
                    }
                    if ($fontWeight) {
                        typoghraphy.style.fontWeight = parseFloat($fontWeight.value);
                        title.style.fontWeight = parseFloat($fontWeight.value);
                        elem.querySelector('.font-weight').innerHTML = $fontWeight.value;
                        $fontWeight.onchange = function () {
                            typoghraphy.style.fontWeight = parseFloat(this.value);
                            title.style.fontWeight = parseFloat(this.value);
                            elem.querySelector('.font-weight').innerHTML = this.value;
                        }
                    }
                    if ($fontTransfotm) {
                        typoghraphy.style.textTransform = $fontTransfotm.value;
                        title.style.textTransform = $fontTransfotm.value;
                        $fontTransfotm.onchange = function () {
                            typoghraphy.style.textTransform = this.value;
                            title.style.textTransform = this.value;
                        }
                    }
                    if ($fontSize) {
                        responFontSize.addEventListener('input', updateFontSize);
                        if (responFontSize.value !== '') {
                            let fontSize = responFontSize.value.indexOf('px') !== -1 ? responFontSize.value : responFontSize.value.indexOf('em') !== -1 ? responFontSize.value : responFontSize.value.indexOf('rem') !== -1 ? responFontSize.value : responFontSize.value + 'px';
                            typoghraphy.style.fontSize = fontSize;
                            title.style.fontSize = fontSize;
                            let infoFontSize = document.createElement("span");
                            infoFontSize.classList.add('font-size');
                            infoFontSize.innerHTML = fontSize;
                            titleInfo.append(infoFontSize);
                            if (responFontSize.value == '') {
                                infoFontSize.remove();
                            }
                        }
                    }
                    if ($lineHeight) {
                        if (responLineHeight !== null) {
                            typoghraphy.style.lineHeight = responLineHeight.value;
                            title.style.lineHeight = responLineHeight.value;
                            responLineHeight.addEventListener('input', updateLineHeight);

                            if (responLineHeight.value !== '') {
                                let infoLineHeight = document.createElement("span");
                                infoLineHeight.classList.add('line-height');
                                infoLineHeight.innerHTML = responLineHeight.value;
                                titleInfo.append(infoLineHeight);
                                if (responLineHeight.value == '') {
                                    infoLineHeight.remove();
                                }
                            }
                        }
                    }
                    if ($letterSpacing) {
                        typoghraphy.style.letterSpacing = $letterSpacing.value;
                        title.style.letterSpacing = $letterSpacing.value;
                        responLetterSpacing.addEventListener('input', updateLetterSpacing);
                    }

                    [...allDesktop].forEach((elem) => {
                        elem.addEventListener('click', () => {
                            responsiveHeadingDesktop.click();
                        });
                    });
                    [...allTablet].forEach((elem) => {
                        elem.addEventListener('click', () => {
                            responsiveHeadingTablet.click();
                        });
                    });

                    [...allMobile].forEach((elem) => {
                        elem.addEventListener('click', () => {
                            responsiveHeadingMobile.click();
                        });
                    });


                    elem.querySelector('.typography-open-js').addEventListener('click', function () {
                        elem.classList.add('active');
                    });
                    elem.querySelector('.typography-close-js').addEventListener('click', function () {
                        elem.classList.remove('active');
                    });

                    function updateFontSize() {
                        if (responFontSize.value !== '') {
                            let fontSize = responFontSize.value.indexOf('px') !== -1 ? responFontSize.value : responFontSize.value.indexOf('em') !== -1 ? responFontSize.value : responFontSize.value.indexOf('rem') !== -1 ? responFontSize.value : responFontSize.value + 'px';
                            typoghraphy.style.fontSize = fontSize;
                            title.style.fontSize = fontSize;
                            if (titleInfo.querySelector('.font-size')) {
                                titleInfo.querySelector('.font-size').remove();
                            }
                            let infoFontSize = document.createElement("span");
                            infoFontSize.classList.add('font-size');
                            infoFontSize.innerHTML = fontSize;
                            titleInfo.append(infoFontSize);
                        }
                        if (responFontSize.value == '' && titleInfo.querySelector('.font-size')) {
                            titleInfo.querySelector('.font-size').remove();
                        }
                    }

                    function updateLineHeight() {
                        typoghraphy.style.lineHeight = responLineHeight.value;
                        title.style.lineHeight = responLineHeight.value;
                        if (responLineHeight.value !== '') {
                            if (titleInfo.querySelector('.line-height')) {
                                titleInfo.querySelector('.line-height').remove();
                            }
                            let infoLineHeight = document.createElement("span");
                            infoLineHeight.classList.add('line-height');
                            infoLineHeight.innerHTML = responLineHeight.value;
                            titleInfo.append(infoLineHeight);

                        }
                        if (responLineHeight.value == '' && titleInfo.querySelector('.line-height')) {
                            titleInfo.querySelector('.line-height').remove();
                        }
                    }

                    function updateLetterSpacing(e) {
                        typoghraphy.style.letterSpacing = parseFloat(e.target.value) + 'px';
                        title.style.letterSpacing = parseFloat(e.target.value) + 'px';
                    }

                    $("input[id*='_color']").not("input[id*='_color_hover']").on("change paste keyup", function () {
                        $(this).closest('.cmb-td').find('.example-js').css({"color": $(this).val()});
                        $(this).closest('.cmb-td').find('.title-js').css({"color": $(this).val()});
                    });


                });

            }

            // Headings Typography

            var oldValue = $('#headings_font_family').val();
            var oldValueFontWeight = $('#headings_font_weight').val();
            var oldValueFontColor = $("#headings_color").val();

            if (oldValue !== '') {
                var value = $('#headings_font_family').val();
                for (let i = 1; i < 7; i++) {
                    let x = $('#heading' + i + '_font_family')
                    if (x.val() === '') {
                        x.val(value);
                        x.trigger('change');
                    }
                }
            }
            $('#headings_font_family').change(function () {
                var value = $(this).val();
                for (let i = 1; i < 7; i++) {
                    let x = $('#heading' + i + '_font_family')
                    if (x.val() === '' || x.val() == oldValue) {
                        x.val(value);
                        x.trigger('change');
                    }
                }
                oldValue = $(this).val();

            });

            if (oldValueFontWeight !== '') {
                let valueFontWeight = $('#headings_font_weight').val();
                for (let i = 1; i < 7; i++) {
                    let x = $('#heading' + i + '_font_weight');
                    if (x.val() === null || x.val() == oldValueFontWeight) {
                        x.val(valueFontWeight);
                        x.trigger('change');
                    }
                }
            }
            $('#headings_font_weight').change(function () {
                let valueFontWeight = $(this).val();
                for (let i = 1; i < 7; i++) {
                    let x = $('#heading' + i + '_font_weight')
                    if (x.val() === '' || x.val() == oldValueFontWeight) {
                        x.val(valueFontWeight);
                        x.trigger('change');
                    }
                }
                oldValueFontWeight = $(this).val();

            });

            if (oldValueFontColor !== '#' && oldValueFontColor !== '') {
                let value = $("#headings_color").val();
                for (let i = 1; i < 7; i++) {
                    let x = $('#heading' + i + '_color')
                    if (x.val() === '' || x.val() === '#' || x.val() == oldValueFontColor) {
                        x.val(value);
                        x.trigger('change');
                    }

                }
            }
            $("#headings_color").on("change paste keyup", function () {
                let value = $(this).val();
                for (let i = 1; i < 7; i++) {
                    let x = $('#heading' + i + '_color')
                    if (x.val() === '' || x.val() === '#' || x.val() == oldValueFontColor) {
                        x.val(value);
                        x.trigger('change');
                    }

                }
                oldValueFontColor = $(this).val();
            });


            /*
          Typography Blockquote
      */
            let blockquoteArray = [];

            var blockquote = $("#setting-panel-typography .cmb-nested.cmb-field-list.cmb-repeatable-group");
            [...blockquote].forEach((item) => {
                blockquoteArray.push([item.id.split("_repeat")[0], {}]);
            });

            let blockquoteObj = Object.fromEntries(blockquoteArray);

            for (let i = 0; i < blockquoteArray.length; i++) {
                let a = blockquoteArray[i][0] + '_0_';
                let items = $(`input[id*= ${a}], select[id*= ${a}]`);
                let array = [];
                [...items].forEach((item) => {
                    array.push([item.id, $("#" + item.id).val()]);
                });
                let object = Object.fromEntries(array);
                blockquoteObj[blockquoteArray[i][0]] = object;
            }
            for (const item in blockquoteObj) {
                for (const element in blockquoteObj[item]) {
                    const a = $("#" + element);
                    const indexOfElement = element.indexOf('0');
                    const c = element.slice(0, (indexOfElement - 1));
                    const titleInfoQuote = a.closest('.cmb-field-list.cmb-repeatable-group').find('.typography-info__shot.quote');
                    const titleInfoAuthor = a.closest('.cmb-field-list.cmb-repeatable-group').find('.typography-info__shot.author');
                    const type = element.split(c + '_0_')[1].split('_')[0];
                    const block = a.closest('.cmb-repeat-group-wrap.cmb-type-group').find('.example-blockquote .' + type);
                    const blockExample = a.closest('.cmb-repeat-group-wrap.cmb-type-group').find('.example-js');
                    const style = element.split(c + '_0_' + type + '_')[1];
                    let styleCss = style.replace('_', '-');
                    let value = a.val()
                    if (value !== '' || value === '#') {
                        if (styleCss === 'transform') {
                            styleCss = 'text-transform'
                        }
                        block.css(styleCss, value);
                        if (type.indexOf('quote') !== -1) {
                            blockExample.css(styleCss, value);
                        }
                        if (styleCss === 'font-family' && allFonts.indexOf(value) === -1) {
                            allFonts.push(value);
                            getFontFamily();
                        }
                        if (styleCss === 'font-family' || styleCss === 'font-weight' || styleCss === 'font-size' || styleCss === 'line-height' || styleCss === 'letter-spacing') {
                            if (type.indexOf('quote') !== -1) {
                                blockquoteObj[item]['quote_' + styleCss] = true;
                                let infoFontFamily = document.createElement("span");
                                infoFontFamily.classList.add(styleCss);
                                infoFontFamily.innerHTML = value;
                                titleInfoQuote.append(infoFontFamily);
                            } else if (type.indexOf('author') !== -1) {
                                blockquoteObj[item]['author_' + styleCss] = true;
                                let infoFontFamily = document.createElement("span");
                                infoFontFamily.classList.add(styleCss);
                                infoFontFamily.innerHTML = value;
                                titleInfoAuthor.append(infoFontFamily);
                            }
                        }

                    }
                    $(a).on("change input", function () {
                        value = $(this).val();
                        if (value !== '' || value === '#') {
                            if (styleCss === 'transform') {
                                styleCss = 'text-transform'
                            }
                            block.css(styleCss, value);
                            if (type.indexOf('quote') !== -1) {
                                blockExample.css(styleCss, value);
                            }
                            if (styleCss === 'font-family' && allFonts.indexOf(value) === -1) {
                                allFonts.push(value);
                                getFontFamily();
                            }
                            if (styleCss === 'font-weight' && value.indexOf('i') !== -1) {
                                block.css(styleCss, parseFloat(value));
                                block.css('font-style', 'italic');
                            } else {
                                block.css('font-style', '');
                            }
                            if (styleCss === 'font-family' || styleCss === 'font-weight' || styleCss === 'font-size' || styleCss === 'line-height' || styleCss === 'letter-spacing') {
                                if (type.indexOf('quote') !== -1 && blockquoteObj[item]['quote_' + styleCss] !== true) {
                                    blockquoteObj[item]['quote_' + styleCss] = true;
                                    let infoFontFamily = document.createElement("span");
                                    infoFontFamily.classList.add(styleCss);
                                    infoFontFamily.innerHTML = value;
                                    titleInfoQuote.append(infoFontFamily);
                                } else if (type.indexOf('quote') !== -1 && blockquoteObj[item]['quote_' + styleCss] == true) {
                                    $(this).closest('.cmb-row.cmb-repeat-group-wrap').find('.typography-info__shot.quote .' + styleCss)[0].innerHTML = value;
                                }
                                if (type.indexOf('author') !== -1 && blockquoteObj[item]['author_' + styleCss] !== true) {
                                    blockquoteObj[item]['author_' + styleCss] = true;
                                    let infoFontFamily = document.createElement("span");
                                    infoFontFamily.classList.add(styleCss);
                                    infoFontFamily.innerHTML = value;
                                    titleInfoAuthor.append(infoFontFamily);
                                } else if (type.indexOf('author') !== -1 && blockquoteObj[item]['author_' + styleCss] == true) {
                                    $(this).closest('.cmb-row.cmb-repeat-group-wrap').find('.typography-info__shot.author .' + styleCss)[0].innerHTML = value;
                                }
                            }
                        } else {
                            block.css(styleCss, '');
                        }
                    });
                }
            }
        }

        function panel_form() {
            let formArray = [];
            var form = $("#setting-panel-form .cmb-nested.cmb-field-list.cmb-repeatable-group");
            [...form].forEach((item) => {
                formArray.push([item.id.split("_repeat")[0], {}]);
            });


            for (let i = 0; i < formArray.length; i++) {
                let a = formArray[i][0] + '_0_';

                let items = $(`input[id*= ${a}], select[id*= ${a}]`);
                let array = [];
                [...items].forEach((item) => {
                    array.push([item.id, $("#" + item.id).val()]);
                });
                let object = Object.fromEntries(array);
                formArray[formArray[i][0]] = object;
                for (const item in object) {
                    const a = $("#" + item);
                    const titleInfo = a.closest('.cmb-field-list.cmb-repeatable-group').find('.typography-info__shot');
                    let value = a.val();
                    const block = a.closest('.cmb-repeat-group-wrap.cmb-type-group').find('.cmb-type-form__block .input-style');
                    const indexOfElement = item.indexOf('0');
                    const c = item.slice(0, (indexOfElement - 1));
                    const type = item.split(c + '_0_')[1].split('_')[0];
                    const style = item.split(c + '_0_' + type + '_')[1];
                    if (item.indexOf('font') !== -1 && value !== '') {
                        let styleCss = style.replace('_', '-');
                        if (styleCss === 'transform') {
                            styleCss = 'text-transform'
                        }
                        if (styleCss === 'font-family' && allFonts.indexOf(value) === -1) {
                            allFonts.push(value);
                            getFontFamily();
                        }
                        if (styleCss !== 'color') {
                            createElement(styleCss, value, titleInfo);
                        }
                        object[styleCss] = true;
                        object[item] = value;
                        block.css(styleCss, value);
                    } else if (item.indexOf('height') !== -1 && value !== '') {
                        block.css('height', value);
                    } else if (item.indexOf('width') !== -1 && value !== '') {
                        block.css('width', value);
                    } else if (item.indexOf('padding') !== -1 && value !== '') {
                        if (style === 'vertical') {
                            let units = item.split('vertical')[0] + 'units';
                            block.css('padding-top', value + $('#' + units).val());
                            block.css('padding-bottom', value + $('#' + units).val());
                        }
                        if (style === 'horizontal') {
                            let units = item.split('horizontal')[0] + 'units';
                            block.css('padding-left', value + $('#' + units).val());
                            block.css('padding-right', value + $('#' + units).val());
                        }
                    } else if (item.indexOf('background') !== -1 && value !== '') {
                        block.css('background', value);
                    } else if (item.indexOf('border') !== -1 && value !== '' || value !== '#' || value !== 'none') {
                        if (style === 'all') {
                            block.css('border-width', value);
                        } else if (style === 'style') {
                            block.css('border-style', value);
                        } else if (style === 'color') {
                            block.css('border-color', value);
                        } else if (style === 'radius') {
                            block.css('border-radius', value);
                        }
                    }
                    $(a).on("change input", function () {
                        value = $(this).val();
                        if (item.indexOf('font') !== -1 && value !== '') {
                            let styleCss = style.replace('_', '-');
                            object.a = value;
                            if (styleCss === 'transform') {
                                styleCss = 'text-transform'
                            }
                            if (object[styleCss] === true) {
                                if (styleCss !== 'color') {
                                    updateElement(styleCss, value, titleInfo);
                                }
                            }
                            else {
                                if (styleCss !== 'color') {
                                    createElement(styleCss, value, titleInfo);
                                    object[styleCss] = true;
                                }
                            }
                            block.css(styleCss, value);
                            if (styleCss === 'font-family' && allFonts.indexOf(value) === -1) {
                                allFonts.push(value);
                                getFontFamily();
                            }
                        } else if (item.indexOf('height') !== -1 && value !== '') {
                            block.css('height', value);
                        } else if (item.indexOf('width') !== -1 && value !== '') {
                            block.css('width', value);
                        } else if (item.indexOf('padding') !== -1 && value !== '') {
                            if (style === 'vertical') {
                                let units = item.split('vertical')[0] + 'units';
                                block.css('padding-top', value + $('#' + units).val());
                                block.css('padding-bottom', value + $('#' + units).val());
                            }
                            if (style === 'horizontal') {
                                let units = item.split('horizontal')[0] + 'units';
                                block.css('padding-left', value + $('#' + units).val());
                                block.css('padding-right', value + $('#' + units).val());
                            }
                        } else if (item.indexOf('border') !== -1 && value !== '' || value !== '#' || value !== 'none') {
                            if (style === 'all') {
                                block.css('border-width', value);
                            } else if (style === 'style') {
                                block.css('border-style', value);
                            } else if (style === 'color') {
                                block.css('border-color', value);
                            } else if (style === 'radius') {
                                block.css('border-radius', value);
                            }
                        }
                    });

                }

            }

            function createElement(style, value, titleInfo) {
                let infoFontFamily = document.createElement("span");
                infoFontFamily.classList.add(style);
                infoFontFamily.innerHTML = value;
                titleInfo.append(infoFontFamily);
            }

            function updateElement(style, value, titleInfo) {
                titleInfo.find('.' + style).text(value);
            }

            $("#setting-panel-form .cmb-row.cmb-repeat-group-wrap").each(function () {
                const boxShadowV = $(this).find("input[id*='_0_box_shadow_voffset']");
                const boxShadowH = $(this).find("input[id*='_0_box_shadow_hoffset']");
                const boxShadowB = $(this).find("input[id*='_0_box_shadow_blur']");
                const boxShadowS = $(this).find("input[id*='_0_box_shadow_spread']");
                const boxShadowC = $(this).find("input[id*='_0_box_shadow_color']");
                const boxShadowI = $(this).find("select[id*='_0_box_shadow_inset']");
                if (boxShadowV.length) {
                    const getValue = () => {
                        boxShadowVertival = boxShadowV.val();
                        boxShadowHorizontal = boxShadowH.val();
                        boxShadowBlur = boxShadowB.val();
                        boxShadowSpread = boxShadowS.val();
                        boxShadowColor = boxShadowC.val();
                        boxShadowInset = boxShadowI.val();
                    }
                    getValue();
                    const setShadow = () => {
                        if (boxShadowVertival.length && boxShadowHorizontal.length && boxShadowBlur.length && boxShadowSpread.length && boxShadowColor.length && boxShadowColor !== '#') {
                            $(this).find('.input-style').css('box-shadow', (boxShadowInset !== 'Outset' ? boxShadowInset + ' ' : '') + boxShadowHorizontal + ' ' + boxShadowVertival + ' ' + boxShadowBlur + ' ' + boxShadowSpread + ' ' + boxShadowColor);
                        } else {
                            $(this).find('.input-style').css('box-shadow', 'none', '!important');
                        }
                    }
                    setShadow();
                    const inputs = [boxShadowV, boxShadowH, boxShadowB, boxShadowS, boxShadowC, boxShadowI];
                    inputs.forEach(item => {
                        item.on('change', () => {
                            getValue();
                            setShadow();
                        })
                    });
                }

                $("input[id*='_0_background']").on("change paste keyup", function () {
                    $(this).closest('.cmb-repeat-group-wrap.cmb-type-group').find('.cmb-type-form__block .input-style').css({"background": $(this).val()});
                });
                let borderHover = $(this).find("input[id*='_0_border_hover']");
                let borderColor = $(this).find("input[id*='_0_border_color']");

                let borderHoverVal = $(this).find("input[id*='_0_border_hover']").val();
                let borderColorVal = $(this).find("input[id*='_0_border_color']").val();

                let placeholderColorVal = $(this).find("input[id*='_0_color_placeholder']").val();
                let placeholderId = $(this).find("input[id*='_0_color_placeholder']").attr('id');
                let placeholder = $(this).find("input[id*='_0_color_placeholder']");


                if (placeholderId !== undefined) {
                    placeholderId = placeholderId.split('_0_color_placeholder')[0];
                    change_placeholder_color("#" + placeholderId + "_repeat .input-style::placeholder", placeholderColorVal);
                }

                placeholder.on("change paste keyup", function () {
                    let placeholderColorVal = $(this).val();
                    if (placeholderId !== undefined) {
                        placeholderId = placeholderId.split('_0_color_placeholder')[0];
                        change_placeholder_color("#" + placeholderId + "_repeat .input-style::placeholder", placeholderColorVal);
                    }
                });
                borderHover.on("change paste keyup", function () {
                    borderHoverVal = $(this).val();
                });
                borderColor.on("change paste keyup", function () {
                    borderColorVal = $(this).val();
                });

                $(this).find('.input-style').hover(function () {
                    $(this).css("border-color", borderHoverVal);
                }, function () {
                    $(this).css("border-color", borderColorVal);
                });

                function change_placeholder_color(target_class, color_choice) {
                    $("body").append("<style>" + target_class + "{color:" + color_choice + "}</style>")
                }

            });
        }


        $(".skins__nav-icon-js").click(function () {
            $(this).toggleClass("active");
        });


        $(".skins__open-popup-js").click(function (e) {
            e.stopPropagation();
            var div = $(this).closest(".skins__block").find(".skins__popup-js");

            div.css({
                "display": "flex",
            });
            $(this).closest(".skins__blocks").addClass("active");

        });
        $('.skins__blocks').click(function (e) {
            e.stopPropagation();
            if (e.target && !e.target.closest('.skins__popup-js')) {
                $(this).find('.skins__popup-js').fadeOut(300);
                $(this).closest(".skins__blocks").removeClass("active");
            }
        });


        $(".typography-open-js").click(function (e) {
            e.stopPropagation();
            var div = $(this).closest(".cmb-row.cmb-repeat-group-wrap").find(".cmb-row.cmb-repeatable-grouping");

            div.css({
                "display": "flex",
            });
            $(this).closest(".cmb-row.cmb-repeat-group-wrap").addClass("active");

        });
        $('.cmb-row.cmb-repeat-group-wrap').click(function (e) {
            e.stopPropagation();
            if (e.target && !e.target.closest('.cmb-row.cmb-repeatable-grouping') || e.target.closest('.typography-close-js')) {
                $(this).find('.cmb-row.cmb-repeatable-grouping').hide();
                $(this).removeClass("active");
            }
        });


        function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }

        /*
            connection font family
        */
        function getFontFamily() {

            let oldFonts = allFonts;

            let skinFonts = getCookie('AhetoSkinsFonts');

            skinFonts = skinFonts.split("%2C");

            if($('#setting-panel-container-aheto-skin-generator_options .cmb2-tabs-navigation a:first-of-type').hasClass('active')){
                allFonts = skinFonts;
            }

            allFonts = allFonts.filter(function (e) {
                return e
            });

            $('#google-font-script').length ? $('#google-font-script').remove() : '';
            $('link[href*="http://fonts.googleapis.com/css?family="]').length ? $('link[href*="http://fonts.googleapis.com/css?family="]').remove() : '';


            WebFontConfig = {
                google: {
                    families: allFonts,
                }
            };

            (function (d) {

                if ($('script[src="//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"]').length) {
                    $('script[src="//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"]').remove();
                }

                var wf = d.createElement('script'), s = d.scripts[0];
                wf.src = '//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
                wf.async = true;
                s.parentNode.insertBefore(wf, s);

            })(document);


        }


        $('.js-anchor-link').click(function (e) {
            e.preventDefault();
            var target = $($(this).attr('href'));
            if (target.length) {
                var scrollTo = target.offset().top;
                $('body, html').animate({scrollTop: scrollTo - 40 + 'px'}, 800);
            }
        });

        var currentLocation = window.location.href.split("=");
        $("#" + currentLocation[2]).addClass('active_skin');

        function loadJs() {
            if ($('a[href="#setting-panel-buttons"]').length && $('a[href="#setting-panel-buttons"]').hasClass('active')) {
                setTimeout(panel_buttons, 0);
            } else if ($('a[href="#setting-panel-colors"]').length && $('a[href="#setting-panel-colors"]').hasClass('active')) {
                setTimeout(panel_colors, 0);
            } else if ($('a[href="#setting-panel-typography"]').length && $('a[href="#setting-panel-typography"]').hasClass('active')) {
                setTimeout(panel_typography, 0);
            } else if ($('a[href="#setting-panel-form"]').length && $('a[href="#setting-panel-form"]').hasClass('active')) {
                setTimeout(panel_form, 0);
            } else if ($('a[href="#setting-panel-skins"]').length && $('a[href="#setting-panel-skins"]').hasClass('active')) {
                setTimeout(panel_skins, 0);
            }
        }

        loadJs();

        window.onload = function() {
			if ($('.aheto-option-sidebar-nav a[title="Design"]').length && $('.aheto-option-sidebar-nav a[title="Design"]').hasClass('active')) {
				getFontFamily();
			}
        }

        $('.cmb2-tabs-navigation a[href^="#setting-panel-"]').click(function (e) {

            if (!$(this).hasClass('load')) {
                loadJs();
                $(this).addClass('load');
            }

        });
    })

}(jQuery))
