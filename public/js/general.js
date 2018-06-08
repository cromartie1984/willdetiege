function error_text(field_error, field_id) {

    if (field_error) {
        if (!$("input[name=" + field_id + "]").hasClass("invalid") || !$("textarea[name=" + field_id + "]").hasClass("invalid")) {
            $("label[for=" + field_id + "]").attr({"data-error": field_error});
            $("input[name=" + field_id + "], textarea[name=" + field_id + "]").addClass("invalid");
        }
        else
        {
            $("label[for=" + field_id + "]").attr({"data-error": field_error});
        }
        return (1);
    }
    else
    {
        $("input[name=" + field_id + "],textarea[name=" + field_id + "]").removeClass("invalid");
        return (0);
    }

}

function click_effect() {

    function mobilecheck() {
        var check = false;
        (function (a) {
            if (/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4)))
                check = true
        })(navigator.userAgent || navigator.vendor || window.opera);
        return check;
    }

    var support = {animations: Modernizr.cssanimations},
    animEndEventNames = {'WebkitAnimation': 'webkitAnimationEnd', 'OAnimation': 'oAnimationEnd', 'msAnimation': 'MSAnimationEnd', 'animation': 'animationend'},
    animEndEventName = animEndEventNames[ Modernizr.prefixed('animation') ],
            onEndAnimation = function (el, callback) {
                var onEndCallbackFn = function (ev) {
                    if (support.animations) {
                        if (ev.target != this)
                            return;
                        this.removeEventListener(animEndEventName, onEndCallbackFn);
                    }
                    if (callback && typeof callback === 'function') {
                        callback.call();
                    }
                };
                if (support.animations) {
                    el.addEventListener(animEndEventName, onEndCallbackFn);
                }
                else {
                    onEndCallbackFn();
                }
            },
            eventtype = mobilecheck() ? 'touchstart' : 'click';

    [].slice.call(document.querySelectorAll('.cbutton')).forEach(function (el) {
        el.addEventListener(eventtype, function (ev) {
            classie.add(el, 'cbutton--click');
            onEndAnimation(classie.has(el, 'cbutton--complex') ? el.querySelector('.cbutton__helper') : el, function () {
                classie.remove(el, 'cbutton--click');
            });
        });
    });

}

function remove_error(field_id) {
    $("input[name=" + field_id + "],textarea[name=" + field_id + "]").removeClass("invalid");
    return (0);
}

function blobToDataURL(blob, callback) {
    var a = new FileReader();
    a.onload = function (e) {
        callback(e.target.result);
    };
    a.readAsDataURL(blob);
}

function reset_avatar(imageCrop) {
    imageCrop ? imageCrop.croppie('destroy') : '';
    $(".cancel_avatar i").removeClass("fa-ban").addClass("fa-trash");
    $('.avatar_image').removeClass("cr-original-image").addClass("img-fluid mx-auto d-block");
    $(".rotate_left").addClass("hidden-xs-up");
    $(".avatar_overlay .view.overlay").append($(".avatar_overlay .view.overlay > div").html());
    $(".avatar_overlay .view.overlay > div").remove();
}

function reset_image(imageCrop) {
    imageCrop ? imageCrop.croppie('destroy') : '';
    
    $('.avatar_image').removeClass("cr-original-image").addClass("img-fluid mx-auto d-block");
    $(".image_overlay .view.overlay").prepend($(".image_overlay .view.overlay > div").html());
    $(".image_overlay .view.overlay > div").remove();
}

function initCrop() {
    var imageCrop = $('.avatar_image').croppie({
        enableExif: true,
        enableOrientation: true,
        enableZoom: true,
        enforceBoundary: true,
        mouseWheelZoom: true,
        showZoomer: true,
        /*customClass: "wowy",*/
        viewport: {
            width: 250,
            height: 250,
            type: 'square'/*circle*/
        }/*,
         boundary: {
         width: 300,
         height: 300
         }*/
    });
    return(imageCrop);
}

function initCropImage(width, height,type, enable_resize) {
    var imageCrop = $('.avatar_image').croppie({
        enableExif: true,
        enableOrientation: true,
        enableZoom: true,
        enforceBoundary: true,
        mouseWheelZoom: true,
        showZoomer: true,
	enableResize: enable_resize,
        /*customClass: "wowy",*/
        viewport: {
            width: width,
            height: height,
            type: type/*circle*/
        }/*,
         boundary: {
         width: "100%",
         height: "100%"
         }*/
    });
    return(imageCrop);
}

$(document).ready(function () {


    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $(".scrolling-navbar").addClass("top-nav-collapse");
        } else {
            $(".scrolling-navbar").removeClass("top-nav-collapse");
        }

    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 125) {
            $('#backtotop').fadeIn();
        } else {
            $('#backtotop').fadeOut();
        }
    });

    $('a[data-scroll="true"]').click(function (e) {
        var scroll_target = $(this).data('id');
        var scroll_trigger = $(this).data('scroll');

        if (scroll_trigger === true && scroll_target !== undefined) {
            e.preventDefault();

            $('html, body').animate({
                scrollTop: $(scroll_target).offset().top - 50
            }, 1000);
        }

    });

    $('.navbar-toggler').on('click', function (event) {
        event.preventDefault();
        $("body").append('<div class="sidenav-overlay" ></div>');
        $("body").addClass('st-effect-1');
        setTimeout(function () {
            $("body").addClass('st-menu-open');
        }, 25);

    });

    $('body').on('click', '.sidenav-overlay', function (event) {
        event.preventDefault();
        $(".sidenav-overlay").remove();
        $("body").removeClass('st-effect-1');
        setTimeout(function () {
            $("body").removeClass('st-menu-open');
        }, 25);
    });



});
