

$(document).ready(function () {


    $('.owl-carousel').on('changed.owl.carousel', function(event) {
        let text = $(this).find('.owl-item:eq('+event.item.index+') span').text();
        if (text){
            $('#item-box_articul').text(text)
        }
    });

    $('.info-items_item').click(function () {
        $(this).closest('.info-items').find('.info-items_item').removeClass('active');
        $(this).addClass('active');
        var html = $(this).find('.info-items_item__text__stages').html();

        $('#info-bot_text').html(html)
    })


    //перемещение блоков в мобильной версии в корзине
    // $(window).on('load resize', function () {
    //     $('.basked-left_item').each(function (key, item) {
    //         $(this).find('.basked-left_item__cont').after($(this).find('.basked-left_item__qty'));
    //     })
    //     if ($(window).width() <= '700') {
    //         // $('.basked-left_item__qty').appendTo($('.basked-left_item__bottom'));
    //         $('.basked-left_item').each(function (key, item) {
    //             let qty = $(this).find('.basked-left_item__qty');
    //             let bottom = $(this).find('.basked-left_item__bottom');
    //             qty.appendTo(bottom);
    //         })
    //     }
    //
    //     if ($(window).width() <= '1100') {
    //         $('.basked-right__cont').appendTo($('.basked .container'));
    //     } else {
    //         $('.basked-right__cont').appendTo($('.basked-cont'));
    //     }
    // });

    //фиксация блока цены в корзине
    $(window).scroll(function () {
        if ($(".basked-right").length > 0) {

            var if_fixsed_block = $(".basked-left").offset().top;
            if ($(window).width() >= '1100') {
                if ($(this).scrollTop() + 70 >= if_fixsed_block) {
                    $(".basked-right").removeClass("default").addClass("fixed");
                }
                else if ($(this).scrollTop() + 70 <= if_fixsed_block && $(".basked-right").hasClass("fixed")) {
                    $(".basked-right").removeClass("fixed").addClass("default");

                }
            }
        }
    });

    $('#num').animate({ num: 90 - 3/* - начало */ }, {
        duration: 5000,
        step: function (num){
            this.innerHTML = (num + 3).toFixed(2) + '%'
        }
    });

    //Изменить слайдер при клике
    var carousel = $('#sync1');

    $('.active_slider').click(function () {
        $('.projects_items').toggleClass('act');
        $('.projects_slide').slideToggle();

        var click = $(this).attr('data-id_slider');
        console.log(click)

        setTimeout(function () {
            carousel.trigger('to.owl.carousel', [click]);
        }, 100);
    })


    //увеличение фотографии товара
    if ($(".lightgallery").length) {
        $('#sync1').lightGallery({
            selector: '.item-box'
        });
    }

    (function () {

        var parent = document.querySelector(".range-slider");
        if (!parent) return;

        var
            rangeS = parent.querySelectorAll("input[type=range]"),
            numberS = parent.querySelectorAll("input[type=number]");

        rangeS.forEach(function (el) {
            el.oninput = function () {
                var slide1 = parseFloat(rangeS[0].value),
                    slide2 = parseFloat(rangeS[1].value);

                if (slide1 > slide2) {
                    [slide1, slide2] = [slide2, slide1];
                }

                numberS[0].value = slide1;
                numberS[1].value = slide2;
            }
        });

        numberS.forEach(function (el) {
            el.oninput = function () {
                var number1 = parseFloat(numberS[0].value),
                    number2 = parseFloat(numberS[1].value);

                if (number1 > number2) {
                    var tmp = number1;
                    numberS[0].value = number2;
                    numberS[1].value = tmp;
                }

                rangeS[0].value = number1;
                rangeS[1].value = number2;

            }
        });

    })();

    $('.filter-left_item__title').click(function () {
        $(this).siblings('ul').slideToggle().closest('.filter-left_item').toggleClass('active');
    });
    $('.filter-mob').click(function () {
        $('.filter-left').slideToggle();
        show_blackout();
    });

    //приклеплять блок при скроле
    var menu = $(".header");
    var menu_fixed_el = $(".header-nav").offset().top;
    $(window).scroll(function () {
        if ($(window).width() >= '1000') {
            if ($(this).scrollTop() > menu_fixed_el && menu.hasClass("default")) {
                menu.removeClass("default").addClass("fixed");
            } else if ($(this).scrollTop() <= menu_fixed_el && menu.hasClass("fixed")) {
                menu.removeClass("fixed").addClass("default");
            }
        }

    });

    //прикреплять цену товара при скроле


    fixedPrice()
    $(window).scroll(function () {
        fixedPrice()
    });

    function fixedPrice(){
        if ($(".cart-content").length > 0) {
            var if_fixsed_block = $(".calculator-bot_cont").offset().top;

            if ($(window).width() >= '1000') {
                if ($(this).scrollTop() + $(this).height() - 80 >= if_fixsed_block && $(".calculator-bot").hasClass("fixed")) {
                    $(".calculator-bot").removeClass("fixed").addClass("default");
                } else if ($(this).scrollTop() + $(this).height() - 80 <= if_fixsed_block) {
                    $(".calculator-bot").removeClass("default").addClass("fixed");
                }
            }else {
                $(".calculator-bot").removeClass("default").addClass("fixed");
            }
        }
    }


    function searchToggle(obj, evt) {
        var container = $(obj).closest('.search-wrapper');
        if (!container.hasClass('active')) {
            container.addClass('active');
            evt.preventDefault();
        } else if (container.hasClass('active') && $(obj).closest('.input-holder').length == 0) {
            container.removeClass('active');
            // clear input
            container.find('.search-input').val('');
        }
    }

    // $('.search-wrapper').addClass('active');

    $('.search-icon, .close').click(function (e) {
        searchToggle(this, e)
    });


    if ($(window).width() <= '1000') {
        $(".new-items").owlCarousel({
            items: 1,
            loop: true,
            smartSpeed: 1000,
            autoWidth: false,
            margin: 20,
            nav: true,
            autoplay: 1,
            autoplaySpeed: 3000,
            autoplayTimeout: 4000,
            navText: ['', ''],
            itemsDesktop: true,
            itemsDesktopSmall: true,
            itemsTablet: true,
            itemsMobile: true,
            responsiveClass: true,
            lazyLoad: true,
            dots: true,
            center: false,
        });
    }


    if ($(window).width() <= '1000') {
        $(".hits-items1").owlCarousel({
            items: 4,
            loop: true,
            smartSpeed: 1000,
            autoWidth: false,
            margin: 20,
            nav: true,
            autoplay: 0,
            autoplaySpeed: 3000,
            autoplayTimeout: 4000,
            autoHeight: false,
            navText: ['', ''],
            itemsDesktop: true,
            itemsDesktopSmall: true,
            itemsTablet: true,
            itemsMobile: true,
            responsiveClass: true,
            lazyLoad: true,
            dots: true,
            center: false,
            responsive: {
                200: {
                    items: 1,
                },
                500: {
                    items: 2
                },
                650: {
                    items: 3
                }
            }
        });
    }

    if ($(window).width() <= '750') {
        $(".info-items1").owlCarousel({
            items: 4,
            loop: true,
            smartSpeed: 1000,
            autoWidth: false,
            margin: 10,
            nav: true,
            autoplay: 1,
            autoplaySpeed: 3000,
            autoplayTimeout: 4000,
            navText: ['', ''],
            itemsDesktop: true,
            itemsDesktopSmall: true,
            itemsTablet: true,
            itemsMobile: true,
            responsiveClass: true,
            lazyLoad: true,
            dots: false,
            center: false,
            responsive: {
                200: {
                    items: 2,
                },
                400: {
                    items: 3
                },
                550: {
                    items: 4
                }
            }
        });
    }

    $(".slitems-cont").owlCarousel({
        items: 5,
        loop: true,
        smartSpeed: 1000,
        autoWidth: false,
        margin: 5,
        nav: true,
        autoplay: 1,
        autoplaySpeed: 3000,
        autoplayTimeout: 4000,
        navText: ['<div class="slider-control slider-control-left"><i class="fa fa-angle-left"></i></div>', '<div class="slider-control slider-control-right"><i class="fa fa-angle-right"></i></div>'],
        itemsDesktop: true,
        itemsDesktopSmall: true,
        itemsTablet: true,
        itemsMobile: true,
        responsiveClass: true,
        lazyLoad: true,
        center: false,
        lazyLoad: true,
        responsive: {
            250: {
                items: 2,
                margin: 10,
            },
            550: {
                items: 3,

            },
            1100: {
                items: 5
            }
        }

    });

    //открытие мадальных окон через data-modal

    $('.open-modal').click(function (e) {
        e.preventDefault();
        var date = $(this).attr('data-modal');
        $('body').find('.' + date).addClass('mymodal--active')
    });


    $('.header-line_left__mob').click(function () {
        $('.header-cont').toggleClass('active');
        $('.header-menu').slideToggle('');
    });

    if ($(window).width() <= '1000') {

        $('.header-menu > ul > li > a').click(function (e) {

            var ul = $(this).siblings('ul');
            if (ul.length > 0){
                e.preventDefault();
                if ($(this).parent().children('ul').length){
                    // $('.header-menu > ul > li > ul').slideToggle();
                    $(this).siblings('ul').slideToggle();
                }
            }
        });
    }

    $("#file").change(function () {
        var size = Math.round(this.files[0].size / 1024); // размер в байтах
        var name = this.files[0].name;
        $('.mymodal2-file_right__name').text(name);
        $('.mymodal2-file_right__size').text(size + 'кб');
    });

    // $('.reviews-butt_img, .cart-bottom_button').click(function(){
    //     $('.mymodal1').addClass('mymodal--active');
    // });

    $(document).mouseup(function (e) {

        var div = $(".mymodal-content");
        if (!div.is(e.target) && div.has(e.target).length === 0) {
            $('.mymodal').removeClass('mymodal--active');
        }
    });

    $('.header-menu_but, .header-button').on("click", function () {
        $('.header-menu_cont').slideToggle();
    });


    $('.works-left_mobbutton').on("click", function () {
        $('.works-left').toggleClass('works-left--active');
        show_blackout();
    });

    if ($(window).width() <= '500') {
        $(".index_banmen__banner img").attr("src", "../img/banner_m.png");
    }

    $(".hits-items_item__slider11").owlCarousel({
        items: 1,
        loop: true,
        autoplay: 1,
        autoplaySpeed: 3000,
        autoplayTimeout: 4000,
        margin: 10,
        nav: true,
        autoplay: false,
        navText: ['', '<div class="slider-control slider-control-right"><i class="fa fa-angle-right"></i></div>'],
        itemsDesktop: true,
        itemsDesktopSmall: true,
        itemsTablet: true,
        itemsMobile: true,
        responsiveClass: true,
        lazyLoad: true,
        center: false,
        dots: false,

    });

    $(".slider-items").owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 1000,
        autoWidth: false,
        margin: 10,
        nav: true,
        autoplay: 1,
        autoplaySpeed: 4000,
        autoplayTimeout: 6000,
        navText: ['', ''],
        itemsDesktop: true,
        itemsDesktopSmall: true,
        itemsTablet: true,
        itemsMobile: true,
        responsiveClass: true,
        lazyLoad: true,
        center: false,
        dots: false,


    });

    /*Слайдер карточки товара*/

    var sync1 = $("#sync1");
    var sync2 = $("#sync2");
    var slidesPerPage = 5;
    var syncedSecondary = true;

    sync1
        .owlCarousel({
            items: 1,
            slideSpeed: 2000,
            nav: false,
            autoplay: false,
            dots: false,
            loop: false,
            responsiveRefreshRate: 200,
            navText: [
                '<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>',
                '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'
            ]
        })
        .on("changed.owl.carousel", syncPosition);

    sync2
        .on("initialized.owl.carousel", function () {
            sync2
                .find(".owl-item")
                .eq(0)
                .addClass("current");
        })
        .owlCarousel({
            items: slidesPerPage,
            dots: false,
            nav: true,
            smartSpeed: 200,
            slideSpeed: 500,
            margin: 3,
            slideBy: slidesPerPage,
            responsiveRefreshRate: 100,
            responsive: {
                0: {
                    items: 3
                },
                350: {
                    items: 4
                },
                400: {
                    items: 5
                },
                550: {
                    items: 6
                }
            }
        })
        .on("changed.owl.carousel", syncPosition2);

    function syncPosition(el) {
        //if you set loop to false, you have to restore this next line
        //var current = el.item.index;

        //if you disable loop you have to comment this block
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }

        //end block

        sync2
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
        var onscreen = sync2.find(".owl-item.active").length - 1;
        var start = sync2
            .find(".owl-item.active")
            .first()
            .index();
        var end = sync2
            .find(".owl-item.active")
            .last()
            .index();

        // if (current > end) {
        //     sync2.data("owl.carousel").to(current, 100, true);
        // }
        // if (current < start) {
        //     sync2.data("owl.carousel").to(current - onscreen, 100, true);
        // }
    }

    function syncPosition2(el) {
        if (syncedSecondary) {
            var number = el.item.index;
            sync1.data("owl.carousel").to(number, 100, true);
        }
    }

    sync2.on("click", ".owl-item", function (e) {
        e.preventDefault();
        var number = $(this).index();
        sync1.data("owl.carousel").to(number, 300, true);
    });

    /*Слайдер карточки товара*/


    function show_blackout() {
        $('.blackout').toggleClass('blackout-active');
    }


    $(".carousel3").owlCarousel({
        items: 3,
        loop: true,
        smartSpeed: 1000,
        autoWidth: false,
        margin: 10,
        nav: true,
        autoplay: false,
        navText: ['<div class="slider-control slider-control-left"></div>', '<div class="slider-control slider-control-right"></div>'],
        itemsDesktop: true,
        itemsDesktopSmall: true,
        itemsTablet: true,
        itemsMobile: true,
        responsiveClass: true,
        lazyLoad: true,
        center: false,
        responsive: {
            0: {
                items: 1,
            },
            500: {
                items: 2
            },
            900: {
                items: 3
            }
        }
    });

    $(".carousel4").owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 1000,
        autoWidth: false,
        margin: 10,
        nav: true,
        autoplay: false,
        navText: ['<div class="slider-control slider-control-left"></div>', '<div class="slider-control slider-control-right"></div>'],
        itemsDesktop: true,
        itemsDesktopSmall: true,
        itemsTablet: true,
        itemsMobile: true,
        responsiveClass: true,
        lazyLoad: true,
        center: false,
    });

    $('.podbor__items__item__title').click(function () {
        $(this).toggleClass('rotate').siblings('ul').slideToggle();
    });
});


