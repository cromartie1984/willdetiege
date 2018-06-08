@extends('main', ['body_class' => 'fixed-sn light-blue-skin'])

@section('stylesheets')
<!-- Style for lightbox plugin     -->
{{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/photoswipe.min.css')}}
<!-- Style for lightbox plugin     -->
{{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.1/default-skin/default-skin.min.css')}}
@endsection

@section('title','| Homepage')

@section('content')

<div id="st-container" class="st-container">
    
@include('partials._nav')

<div class="section section-header" id="header">
  <div class="parallax filter filter-color-black" style="background-image:url('/img/vault_42-1920x1080.jpg')">

    <div class="container">
      <div class="content">
        <h1 class="cd-headline slide">
          <span data-translate="i-am">Je suis</span><br/>
          <span class="cd-words-wrapper">
            <b class="is-visible">Guillaume DETIEGE</b>
            <b data-translate="job-1">Développeur WEB</b>
            <b data-translate="job-2">Passionné</b>
          </span>
        </h1>
        <div class="separator-container">
          <div class="separator line-separator">♦</div>
        </div>
      </div>
    </div>
  </div>
  <a href="" data-scroll="true" data-id="#about" class="scroll-arrow hidden-xs hidden-sm">
    <i class="fa fa-angle-down text-center"></i>
  </a>
</div>

<div class="section" id="about">
  <div class="container">
    <div class="title-area">
      <h2>Introduction</h2>
      <div class="separator separator-danger">♦</div>
      <p class="description">
        <span data-translate="presentation">Je m'appelle Guillaume DETIEGE, Je suis un développeur Web d'Annecy. 
          Je suis passionné d'apprendre tout ce qui touche au web. Vous pouvez</span>
          <a href="portfolio" target="_blank" data-translate="see-portfolio">consulter mon portfolio</a> 
          <span data-translate="or-me">ou me</span> <a href="" data-scroll="true" data-id="#contact" data-translate="contact-link">contacter</a>.
        </p>
        <p class="description" data-translate="introduction">
          J'ai travaillé sur divers projets. Je suis en train d'améliorer le site attractive.events.
        </p>
      </div>
    </div>

    <div class="parallax parallax-small" style="background-image: url('img/vault_42_1-1920x1280.jpg')"></div>
  </div>

  <div class="section section-our-projects section-our-projects-fluid">

    <div class="title-area">
      <h2 data-translate="projects-title">Mes Projets</h2>
      <div class="separator separator-danger">♦</div>
      <p class="description" data-translate="projects-description">
        De l'application web au site e-commerce.
      </p>
    </div>

    <div class="container-fluid">
      <div class="row">
        @foreach($projects as $project)
        <div class="col-sm-6">
          <div class="project">
            <img src="{{ $project["cover_img"] }}" />
            <a class="over-area" href="projects/{{ $project["url"] }}">
              <div class="content">
                <label class="badge pink">{{ $language === 'fr' ? $project["category"] : ($project["category_eng"] ? $project["category_eng"]  : $project["category"]) }}</label>
                <h3>{{ $project["title"] }}</h3>
                <p>{{ $language === 'fr' ? $project["excerpt"] : ($project["excerpt_eng"] ? $project["excerpt_eng"]  : $project["excerpt"]) }}</p>
              </div>
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="section section-card-blog">
    <div class="container">
      <div class="title-area">
        <h5 class="grey-text" data-translate="blog-sub-title">Ne manquez pas</h5>
        <h2 data-translate="blog-title">Mes derniers articles de blog</h2>
        <div class="separator separator-danger">♦</div>
        <p class="description" data-translate="blog-description">
          Chaque semaine, j'écris un article de blog sur un sujet particulier (développement, cinéma, tv, ...). 
          Tous ces articles vous permettront de mieux me connaître.
        </p>
      </div>

      <div class="row grid" >
        @foreach($posts as $post)
        <div class="col-sm-4 blog-item">
          <div class="card card-blog">
            <a href="{{ $post["slug"] }}" class="header">
              <img src="{{ $post["thumbnail"] }}" class="image-header">
            </a>
            <div class="content">
              <div class="circle-black">
                <div class="circle">
                  <div class="date-wrapper">
                    <span class="month">{{ strftime('%h', strtotime($post["created_at"])) }}</span>
                    <span class="date">{{ strftime('%d', strtotime($post["created_at"])) }}</span>
                  </div>
                </div>
              </div>
              <a href="{{ $post["slug"] }}" class="card-title">
                <h3>{{ $post["title"] }}</h3>
              </a>
              <div class="line-divider line-danger"></div>
              <h6 class="card-category orange-text">{{ $language === 'fr' ? $post["name_fr"] : ($post["name_eng"] ? $post["name_eng"]  : $post["name_fr"]) }}</h6>
              <p class="text-description grey-text">{!! $post["excerpt"] ? $post["excerpt"] : substr(strip_tags($post["body"]), 0, 100) . (strlen(strip_tags($post["body"])) > 100 ? "..." : "") !!}</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container">
      <div class="title-area">
        <h2 data-translate="timeline-text" class="text-capitalize">chronologie web</h2>
        <div class="separator separator-danger">♦</div>
      </div>
      <ul class="timeline">
        @php
        $previous_year = '';
        $previous_timeline_position = '';
        $timeline_position = '';
        @endphp
        @foreach($timelines as $timeline)
        @php
        $start_year = strftime('%Y', strtotime($timeline["start_date"]));
        $start_date = strftime('%B %Y', strtotime($timeline["start_date"]));
        $end_date = $timeline["end_date"] ? strftime('%B %Y', strtotime($timeline["end_date"])) : '';

        if($start_year !== $previous_year && $previous_year !== ''){
          $timeline_position = $previous_timeline_position === '' ? ' class=timeline-inverted' : '';
        }else{
          $timeline_position = $previous_timeline_position;
        }

        $date = $end_date ? $start_date . ' - ' . $end_date : $start_date;
        $previous_year = $start_year;
        $previous_timeline_position = $timeline_position;
        @endphp
        <li {{ $timeline_position }}>
          <div class="timeline-badge {{ $timeline["badge_color"] }}"><i class="fa {{ $timeline["badge_icon"] }}" aria-hidden="true"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">{{ $language === 'fr' ? $timeline["title"] : ($timeline["title_eng"] ? $timeline["title_eng"]  : $timeline["title"]) }}</h4>
              <p><small class="text-muted text-capitalize"><i class="fa fa-calendar"></i> {{ $date }}</small></p>
            </div>
            <div class="timeline-body">{!! $language === 'fr' ? $timeline["content"] : ($timeline["content_eng"] ? $timeline["content_eng"]  : $timeline["content"]) !!}</div>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
  </div>

  <div class="section section-contact-form" id="contact">

    <div id="contactUsMap" class="map"></div>

    <div class="card card-contact card-raised">
      <form role="form" method="post" action="contact-process">
        <div class="header header-raised header-rose text-center">
          <h4 class="card-title text-xs-center">Contactez-moi</h4>
        </div>
        <div class="content">
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="info info-horizontal">
                  <div class="icon icon-rose">
                    <i class="material-icons">phone</i>
                  </div>
                  <div class="description">
                    <h5 class="info-title" data-translate="phone-text">Appelez-moi</h5>
                    <p> Guillaume DETIEGE<br>
                      <img class="img-fluid php_image adresse_email" src="create_image.php?text=06 66 23 83 60&type_contact=telephone&color_bg=white"/>
                      <span data-translate="horaires-text">Mon - Fri, 8:00-22:00</span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info info-horizontal">
                  <div class="icon icon-rose">
                    <i class="material-icons">pin_drop</i>
                  </div>
                  <div class="description">
                    <h5 class="info-title" data-translate="write-text">Écrivez-moi</h5>
                    <p> 74 allée des Cyclamens<br>
                      74 320 Sévrier<br>
                      France
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="md-form">
                  <i class="fa fa-user prefix"></i>
                  <input type="text" name="name" id="name" class="form-control">
                  <label for="name" data-translate="nom-text">Votre nom</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="md-form">
                  <i class="fa fa-envelope-o prefix"></i>
                  <input type="text" name="email" id="email" class="form-control">
                  <label for="email" data-translate="email-text">Votre adresse email</label>
                </div>
              </div>
            </div>


            <div class="md-form">
              <i class="fa fa-pencil prefix"></i>
              <textarea type="message" name="message" id="message" class="md-textarea"></textarea>
              <label for="message" data-error="Un message est obligatoire" data-translate="message-text">Ecrivez votre message ici</label>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="g-recaptcha" data-sitekey="6Lfu9xoUAAAAADN_G4okq-NZZLPRBOVsGHb-pfeb"></div>
                <div id="error-captcha" class="text-danger"></div>
              </div>
              <div class="col-md-6">
                <button type="submit" class="btn btn-pink pull-right" data-translate="send-text">Envoyer</button>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>

    <div class="fixed-action-btn smooth-scroll" id="backtotop">
      <a data-id="#header" data-scroll="true" class="btn-floating btn-large back-to-top">
        <i class="fa fa-arrow-up"></i>
      </a>
    </div>

    @include('partials._footer')
</div>
    
@endsection

@section('scripts')
{!! Html::script('https://www.google.com/recaptcha/api.js') !!}
{!! Html::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyDCCg8xUHCcSyv63K7EHgvoeqDGJ9UHH40') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.3/imagesloaded.pkgd.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.4/isotope.pkgd.min.js') !!}
<!-- UI JS file // lightbox plugin -->
{!! Html::script('/js/jquery.photoswipe-global.min.js') !!}
<!-- Corrige le problème du polyfill pour IE -->
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/es6-promise/4.1.1/es6-promise.min.js') !!}
<!---Sweet Alert -->
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.0/sweetalert2.min.js') !!}
{!! Html::script('/js/general.js') !!}
{!! Html::script('/js/homepage.js') !!}
<script>
  $(document).ready(function () {

    var grid_images = $('.grid').isotope({
      /* options*/
      itemSelector: '.blog-item',
      isFitWidth: true
    });


    grid_images.isotope({filter: '*'});



    var lat = 45.8652666;
    var long = 6.1415404;

    var centerLong = long - 0.025;

    var myLatlng = new google.maps.LatLng(lat, long);
    var centerPosition = new google.maps.LatLng(lat, centerLong);
    var mapOptions = {
      zoom: 14,
      center: centerPosition,
      styles:
      [{"featureType": "water", "stylers": [{"saturation": 43}, {"lightness": -11}, {"hue": "#0088ff"}]}, {"featureType": "road", "elementType": "geometry.fill", "stylers": [{"hue": "#ff0000"}, {"saturation": -100}, {"lightness": 99}]}, {"featureType": "road", "elementType": "geometry.stroke", "stylers": [{"color": "#808080"}, {"lightness": 54}]}, {"featureType": "landscape.man_made", "elementType": "geometry.fill", "stylers": [{"color": "#ece2d9"}]}, {"featureType": "poi.park", "elementType": "geometry.fill", "stylers": [{"color": "#ccdca1"}]}, {"featureType": "road", "elementType": "labels.text.fill", "stylers": [{"color": "#767676"}]}, {"featureType": "road", "elementType": "labels.text.stroke", "stylers": [{"color": "#ffffff"}]}, {"featureType": "poi", "stylers": [{"visibility": "off"}]}, {"featureType": "landscape.natural", "elementType": "geometry.fill", "stylers": [{"visibility": "on"}, {"color": "#b8cb93"}]}, {"featureType": "poi.park", "stylers": [{"visibility": "on"}]}, {"featureType": "poi.sports_complex", "stylers": [{"visibility": "on"}]}, {"featureType": "poi.medical", "stylers": [{"visibility": "on"}]}, {"featureType": "poi.business", "stylers": [{"visibility": "simplified"}]}],
                  scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
                }
                var map = new google.maps.Map(document.getElementById("contactUsMap"), mapOptions);

                var marker = new google.maps.Marker({
                  position: myLatlng, title: "Hello World!"
                });
                marker.setMap(map);

                var slideSelector = 'img', options = {bgOpacity: 0.8},
                events = {
                  close: function () {
                    /*console.log('closed');*/
                  }
                };

                $('.timeline-body').photoSwipe(slideSelector, options, events);



                var nombre_erreur = 0;

                $("form").submit(function (event) {


                  event.preventDefault();
                  nombre_erreur = 0;
                  $("#error-captcha").html("");
                  nombre_erreur += ($("input[name=name]").val()).trim() === '' ? error_text("Un nom est obligatoire.", "name") : remove_error("name");
                  nombre_erreur += ($("input[name=email]").val()).trim() === '' ? error_text("Une adresse e-mail est obligatoire.", "email") : remove_error("email");
                  nombre_erreur += ($("textarea[name=message]").val()).trim() === '' ? error_text("Un message est obligatoire.", "message") : remove_error("message");
                  if (nombre_erreur === 0) {
                    $.ajax({
                      type: 'POST',
                      url: $("form").attr("action"),
                      data: $("form").serialize(),
                      dataType: 'json',
                      encode: true
                    })
                    .done(function (data) {
                      if (!data.success) {
                        error_text(data.errors.email, "email");
                        data.errors.recaptcha ? $("#error-captcha").html(data.errors.recaptcha) : '';
                      }
                      else
                      {
                        remove_error("email");
                        remove_error("name");
                        remove_error("message");
                        $("#error-captcha").html("");

                        swal({
                          title: 'Demande de contact',
                          text: 'Votre demande de prise en contact a bien été prise en compte !',
                          type: 'success'
                        }).then(function () {
                          $("input[name=name]").val("");
                          $("input[name=email]").val("");
                          $("textarea[name=message]").val("");
                          grecaptcha.reset();
                        });
                      }

                    })
                    .fail(function (data) {

                    });
                  }
                });

                /*animated slideInDown*/
                /*$('#yourElement').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', doSomething);*/


              //set animation timing
              var animationDelay = 2500,
                      //loading bar effect
                      barAnimationDelay = 3800,
                      barWaiting = barAnimationDelay - 3000, //3000 is the duration of the transition on the loading bar - set in the scss/css file
                      //letters effect
                      lettersDelay = 50,
                      //type effect
                      typeLettersDelay = 150,
                      selectionDuration = 500,
                      typeAnimationDelay = selectionDuration + 800,
                      //clip effect 
                      revealDuration = 600,
                      revealAnimationDelay = 1500;

                      initHeadline();


                      function initHeadline() {
                  //insert <i> element for each letter of a changing word
                  singleLetters($('.cd-headline.letters').find('b'));
                  //initialise headline animation
                  animateHeadline($('.cd-headline'));
                }

                function singleLetters($words) {
                  $words.each(function () {
                    var word = $(this),
                    letters = word.text().split(''),
                    selected = word.hasClass('is-visible');
                    for (i in letters) {
                      if (word.parents('.rotate-2').length > 0)
                        letters[i] = '<em>' + letters[i] + '</em>';
                      letters[i] = (selected) ? '<i class="in">' + letters[i] + '</i>' : '<i>' + letters[i] + '</i>';
                    }
                    var newLetters = letters.join('');
                    word.html(newLetters).css('opacity', 1);
                  });
                }

                function animateHeadline($headlines) {
                  var duration = animationDelay;
                  $headlines.each(function () {
                    var headline = $(this);

                    if (headline.hasClass('loading-bar')) {
                      duration = barAnimationDelay;
                      setTimeout(function () {
                        headline.find('.cd-words-wrapper').addClass('is-loading')
                      }, barWaiting);
                    } else if (headline.hasClass('clip')) {
                      var spanWrapper = headline.find('.cd-words-wrapper'),
                      newWidth = spanWrapper.width() + 10
                      spanWrapper.css('width', newWidth);
                    } else if (!headline.hasClass('type')) {
                          //assign to .cd-words-wrapper the width of its longest word
                          var words = headline.find('.cd-words-wrapper b'),
                          width = 0;
                          words.each(function () {
                            var wordWidth = $(this).width();
                            if (wordWidth > width)
                              width = wordWidth;
                          });
                          headline.find('.cd-words-wrapper').css('width', width);
                        }
                        ;

                      //trigger animation
                      setTimeout(function () {
                        hideWord(headline.find('.is-visible').eq(0))
                      }, duration);
                    });
                }

                function hideWord($word) {
                  var nextWord = takeNext($word);

                  if ($word.parents('.cd-headline').hasClass('type')) {
                    var parentSpan = $word.parent('.cd-words-wrapper');
                    parentSpan.addClass('selected').removeClass('waiting');
                    setTimeout(function () {
                      parentSpan.removeClass('selected');
                      $word.removeClass('is-visible').addClass('is-hidden').children('i').removeClass('in').addClass('out');
                    }, selectionDuration);
                    setTimeout(function () {
                      showWord(nextWord, typeLettersDelay)
                    }, typeAnimationDelay);

                  } else if ($word.parents('.cd-headline').hasClass('letters')) {
                    var bool = ($word.children('i').length >= nextWord.children('i').length) ? true : false;
                    hideLetter($word.find('i').eq(0), $word, bool, lettersDelay);
                    showLetter(nextWord.find('i').eq(0), nextWord, bool, lettersDelay);

                  } else if ($word.parents('.cd-headline').hasClass('clip')) {
                    $word.parents('.cd-words-wrapper').animate({width: '2px'}, revealDuration, function () {
                      switchWord($word, nextWord);
                      showWord(nextWord);
                    });

                  } else if ($word.parents('.cd-headline').hasClass('loading-bar')) {
                    $word.parents('.cd-words-wrapper').removeClass('is-loading');
                    switchWord($word, nextWord);
                    setTimeout(function () {
                      hideWord(nextWord)
                    }, barAnimationDelay);
                    setTimeout(function () {
                      $word.parents('.cd-words-wrapper').addClass('is-loading')
                    }, barWaiting);

                  } else {
                    switchWord($word, nextWord);
                    setTimeout(function () {
                      hideWord(nextWord)
                    }, animationDelay);
                  }
                }

                function showWord($word, $duration) {
                  if ($word.parents('.cd-headline').hasClass('type')) {
                    showLetter($word.find('i').eq(0), $word, false, $duration);
                    $word.addClass('is-visible').removeClass('is-hidden');

                  } else if ($word.parents('.cd-headline').hasClass('clip')) {
                    $word.parents('.cd-words-wrapper').animate({'width': $word.width() + 10}, revealDuration, function () {
                      setTimeout(function () {
                        hideWord($word)
                      }, revealAnimationDelay);
                    });
                  }
                }

                function hideLetter($letter, $word, $bool, $duration) {
                  $letter.removeClass('in').addClass('out');

                  if (!$letter.is(':last-child')) {
                    setTimeout(function () {
                      hideLetter($letter.next(), $word, $bool, $duration);
                    }, $duration);
                  } else if ($bool) {
                    setTimeout(function () {
                      hideWord(takeNext($word))
                    }, animationDelay);
                  }

                  if ($letter.is(':last-child') && $('html').hasClass('no-csstransitions')) {
                    var nextWord = takeNext($word);
                    switchWord($word, nextWord);
                  }
                }

                function showLetter($letter, $word, $bool, $duration) {
                  $letter.addClass('in').removeClass('out');

                  if (!$letter.is(':last-child')) {
                    setTimeout(function () {
                      showLetter($letter.next(), $word, $bool, $duration);
                    }, $duration);
                  } else {
                    if ($word.parents('.cd-headline').hasClass('type')) {
                      setTimeout(function () {
                        $word.parents('.cd-words-wrapper').addClass('waiting');
                      }, 200);
                    }
                    if (!$bool) {
                      setTimeout(function () {
                        hideWord($word)
                      }, animationDelay)
                    }
                  }
                }

                function takeNext($word) {
                  return (!$word.is(':last-child')) ? $word.next() : $word.parent().children().eq(0);
                }

                function switchWord($oldWord, $newWord) {
                  $oldWord.removeClass('is-visible').addClass('is-hidden');
                  $newWord.removeClass('is-hidden').addClass('is-visible');
                }


              });
  </script>

@endsection