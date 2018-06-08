@extends('main')

@section('title', '| Projects')

@section('content')

@include('partials._nav')

<div id="st-container" class="st-container">
    <div class="section section-header" id="header">
        <div class="parallax filter filter-color-black" style="background-image:url(/img/portfolio-1920x1280.jpg)">
            <div class="container">
                <div class="content">
                    <h1>Portfolio</h1>
                    <div class="separator-container">
                        <div class="separator line-separator">♦</div>
                    </div>
                    <h5>
                        Ici, vous trouverez l'ensemble de mes projets.
                    </h5>
                </div>
            </div>
        </div>
        <a href="" data-scroll="true" data-id="#firstSection" class="scroll-arrow hidden-xs hidden-sm">
            <i class="fa fa-angle-down text-center"></i>
        </a>
    </div>
    <div class="section" id="firstSection">
        <div class="container">
            <div class="row">
                @foreach($projects as $project)
                <div class="col-sm-6">
                    <div class="card">
                        <!--Card image-->
                        <div class="view overlay hm-white-slight">
                            <img src="{{ $project["cover_img"] }}" class="img-fluid" alt="">
                            <a href="/projects/{{ $project["cover_img"] }}">
                                <div class="mask"></div>
                            </a>
                        </div>
                        <!--Card content-->
                        <div class="card-block">
                            <!--Title-->
                            <h4 class="card-title">{{ $project["title"] }}</h4>
                            <!--Text-->
                            <p class="card-text">{{ $language === 'fr' ? $project["excerpt"] : $project["excerpt_eng"] ? $project["excerpt_eng"]  : $project["excerpt"] }}</p>
                            <a href="/projects/{{ $project["url"] }}" class="btn btn-outline-default waves-effect pull-right" data-translate="project-access">Accéder au projet</a>
                        </div>
                        <!--/.Card content-->
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('partials._footer')
</div>
<!--/ Main container-->
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery_lazyload/1.9.7/jquery.lazyload.min.js"></script>
<script>
    $(document).ready(function () {

        var grid_images = $('.pages-website');

        grid_images.imagesLoaded().progress(function () {
            $('.pages-website').isotope({
                /* options*/
                itemSelector: '.grid-item',
                isFitWidth: true
            });
            grid_images.isotope({filter: '*'});
        });

        // filter items on button click
        $('.filters').on('click', 'button', function () {
            var filterValue = $(this).attr('data-filter');
            grid_images.isotope({filter: filterValue});
        });

        var slideSelector = '.grid-item .img-fluid', options = {bgOpacity: 0.8},
        events = {
            close: function () {

            }
        };

        $("img.lazy").lazyload({
            effect: "fadeIn"
        });

        $('.pages-website').photoSwipe(slideSelector, options, events);
    });
</script>
@endsection