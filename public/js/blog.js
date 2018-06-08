$(document).ready(function () {


    $(".close-dock").click(function () {
        $(".slide-dock").addClass("slide-dock-off");
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {

            $(".slide-dock").addClass("slide-dock-on");
        }
        else
        {
            $(".slide-dock").removeClass("slide-dock-on");
        }

    });

    var slideSelector = 'img', options = {bgOpacity: 0.8},
    events = {
        close: function () {
            /*console.log('closed');*/
        }
    };

    $('.article-text').photoSwipe(slideSelector, options, events);


    /*Carousel bottle-------------------*/

    if ($(".article-text .component").length > 0) {
        var support = {animations: Modernizr.cssanimations},
        animEndEventNames = {
            'WebkitAnimation': 'webkitAnimationEnd',
            'OAnimation': 'oAnimationEnd',
            'msAnimation': 'MSAnimationEnd',
            'animation': 'animationend'
        },
        // animation end event name
        animEndEventName = animEndEventNames[ Modernizr.prefixed('animation') ],
                component = document.getElementById('component'),
                items = component.querySelector('ul.itemwrap').children,
                current = 0,
                itemsCount = items.length,
                nav = component.querySelector('nav'),
                navNext = nav.querySelector('.component .next'),
                navPrev = nav.querySelector('.component .prev');


        function carousel_bottle() {
            navNext.addEventListener('click', function (ev) {
                ev.preventDefault();

                navigate('next');


            });
            navPrev.addEventListener('click', function (ev) {
                ev.preventDefault();
                navigate('prev');
            });
        }

        function navigate(dir) {

            var currentItem = items[ current ];

            if (dir === 'next') {
                current = current < itemsCount - 1 ? current + 1 : 0;
            }
            else if (dir === 'prev') {
                current = current > 0 ? current - 1 : itemsCount - 1;
            }

            var nextItem = items[ current ];

            var onEndAnimationCurrentItem = function () {
                this.removeEventListener(animEndEventName, onEndAnimationCurrentItem);
                classie.removeClass(this, 'current');
                classie.removeClass(this, dir === 'next' ? 'navOutNext' : 'navOutPrev');
            }

            var onEndAnimationNextItem = function () {
                this.removeEventListener(animEndEventName, onEndAnimationNextItem);
                classie.addClass(this, 'current');
                classie.removeClass(this, dir === 'next' ? 'navInNext' : 'navInPrev');
            }

            if (support.animations) {
                currentItem.addEventListener(animEndEventName, onEndAnimationCurrentItem);
                nextItem.addEventListener(animEndEventName, onEndAnimationNextItem);
            }
            else {
                onEndAnimationCurrentItem();
                onEndAnimationNextItem();
            }

            classie.addClass(currentItem, dir === 'next' ? 'navOutNext' : 'navOutPrev');
            classie.addClass(nextItem, dir === 'next' ? 'navInNext' : 'navInPrev');
        }


        carousel_bottle();
    }


});

