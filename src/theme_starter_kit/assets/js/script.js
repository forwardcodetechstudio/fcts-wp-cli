(function ($) {
    $(document).ready(function ($) {

        let a = 0; // for counter on scroll

        $(window).scroll(function () {
            // --- sticky header START ---
            if ($(this).scrollTop() > 72) {
                $('.header').addClass('_js-sticky');
            } else {
                $('.header').removeClass('_js-sticky');
            }
            // --- sticky header END ---
            // --- counter on scroll START ---
            if ($('.stats').length) {

                let oTop = $('.stats').offset().top - window.innerHeight;
                if (a == 0 && $(window).scrollTop() > oTop) {
                    $('.stats-value').each(function () {
                        let $this = $(this),
                            countTo = $this.attr('data-count');
                        $({
                            countNum: $this.text()
                        }).animate({
                            countNum: countTo
                        },
                            {
                                duration: 2000,
                                easing: 'swing',
                                step: function () {
                                    $this.text(Math.floor(this.countNum));
                                },
                                complete: function () {
                                    $this.text(this.countNum);
                                }
                            });
                    });
                    a = 1;
                }
            }
            // --- counter on scroll END ---
        });

        // --- mobile menu START ---
        // include required header.js file or insert content from .js file here
        let menuBtn = $('.menu-trigger'),
            mobMenu = $('.navbar'),
            mobHeader = $('.header'),
            body = $('body');

        function toggleMobileMenu() {
            menuBtn.toggleClass('_js-active');
            mobMenu.toggleClass('_js-open');
            mobMenu.find('.dropdown').removeClass('_js-open');
            mobMenu.find('.dropdown-menu').slideUp();
            mobHeader.toggleClass('_js-menu-open');
            body.toggleClass('_js-overflow-hidden');
        }

        menuBtn.on('click', () => {
            toggleMobileMenu()
        });

        /* dropdowns in mobile menu START */
        let goMobile = 1200;//set resolution when header goes mobile view

        $('.dropdown').on('click', (e) => {
            if ($(window).width() < goMobile) {
                let aim = $(e.target),
                    aimFP = $(e.target).parent('.dropdown'),
                    aimMP = $(e.target).closest('.navbar');

                if (aim.hasClass("dropdown")) {

                    aimMP.find('.dropdown').not(aim).removeClass('_js-open')
                    aimMP.not(aim.children('.dropdown-menu').eq(0)).find('.dropdown-menu').slideUp()

                    if (aim.hasClass("_js-open")) {
                        aim.removeClass('_js-open');
                        aim.children('ul').eq(0).slideUp();
                    } else {
                        aim.addClass('_js-open');
                        aim.children('ul').eq(0).slideDown();
                    }
                } else if (aimFP) {

                    aimMP.find('.dropdown').not(aimFP).removeClass('_js-open')
                    aimMP.not(aim.next('.dropdown-menu').eq(0)).find('.dropdown-menu').slideUp()

                    if (aimFP.hasClass("_js-open")) {
                        aimFP.removeClass('_js-open');
                        aimFP.children('ul').eq(0).slideUp();
                    } else {
                        aimFP.addClass('_js-open');
                        aimFP.children('ul').eq(0).slideDown();
                    }
                }
            }
        });
        /* dropdowns in mobile menu END */
        //         $.getScript("js/js-header-2.js");
        // $.getScript("js/js-header-3.js");
        // --- mobile menu END ---

        // smooth scroll on page
        $('a[href*="#"]').on('click', function (e) {

            if (mobMenu.hasClass('_js-open')) {
                toggleMobileMenu()
            }

            let targetitem = $(this).attr('href');
            let headerheight = 70;

            if (targetitem.indexOf('#') > -1) {
                if (targetitem.match("^#")) {
                    e.preventDefault();
                    scrolltotarget(targetitem, headerheight);
                } else {
                    let aim = targetitem.split('#')[1];
                    scrolltotarget('#' + aim, headerheight);
                }
            }
        });


        // scroll to function
        function scrolltotarget(target, offset) {
            $('body, html').animate({
                scrollTop: $(target).offset().top - offset,
            }, 800);
        }

        // --- ACCORDION START ---
        if ($('.selector-contents-wrapper').length) {

            /* open the pack of accordions to relevant theme END */

            $('.toggle').on('click', function (e) {
                let isOpen = 0;
                let $this = $(this);
                let globalWrap = $(this).closest('.content-show-hide');

                if ($this.hasClass('_js-open')) {
                    isOpen = 1
                }

                globalWrap.find('.toggle').removeClass('_js-open');
                globalWrap.find('.selector-content li').removeClass('_js-open');
                globalWrap.find('.inner').slideUp(350);

                if (isOpen === 1) {
                    $this.removeClass('_js-open');
                    $this.parent().removeClass('_js-open');
                    $this.next().slideUp(350);
                } else {
                    $this.parent().addClass('_js-open');
                    $this.addClass('_js-open');
                    $this.next().slideToggle(350);
                }
            });
        }
        // --- ACCORDION END ---

        //sliders

        if ($('.gallery-1').length) {
            if ($('.gallery-1').children().length > 1) {
                $('.gallery-1').slick({
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: false,
                    autoplay: true,
                    autoplaySpeed: 3000,
                })
            }
        }

        if ($('.gallery-2').length) {
            if ($('.gallery-2').children().length > 1) {
                $('.gallery-2').slick({
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                arrows: false,
                            },
                        },
                    ]
                })
            }
        }

        if ($('.gallery-3').length) {
            if ($('.gallery-3').children().length > 1) {
                $('.gallery-3').slick({
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 3000,
                })
            }
        }

        if ($('.blog-slider').length) {
            if ($('.blog-slider').children().length > 1) {
                $('.blog-slider').slick({
                    infinite: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 2,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1,
                            },
                        },
                    ]
                })
            }
        }

        if ($('.blog-related-slider').length) {
            if ($('.blog-related-slider').children().length > 1) {
                $slider = $('.blog-related-slider').slick({
                    infinite: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 2,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1,
                            },
                        },
                    ]
                })
            }
            var slideCount = $slider.slick("getSlick").slideCount;
            console.log(slideCount)
            if (window.innerWidth > 1200) {
                if (slideCount < 4)
                    $slider.find(".slick-dots").addClass('d-none');
            }
            if (window.innerWidth > 768) {
                if (slideCount < 3)
                    $slider.find(".slick-dots").addClass('d-none');
            }
            else {
                if (slideCount < 2)
                    $slider.find(".slick-dots").addClass('d-none');
            }
        }

        if ($('.testimonials-slider-2').length) {
            if ($('.testimonials-slider-2').children().length > 1) {
                $('.testimonials-slider-2').slick({
                    infinite: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 2,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1,
                            },
                        },
                    ]
                })
            }
        }

        if ($('.testimonials-slider-3').length) {
            if ($('.testimonials-slider-3').children().length > 1) {
                $('.testimonials-slider-3').slick({
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: true,
                    // autoplay: true,
                    // autoplaySpeed: 3000,
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 1,
                                arrows: false,
                            },
                        },

                    ]
                })
            }
        }
        $(window).scroll(function () {
            if ($(window).scrollTop() > 300) {
                $(".sticky-icon").addClass("active");
            } else {
                $(".sticky-icon").removeClass("active");
            }
        });
    });
})(jQuery);