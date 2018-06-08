@extends('main')

@section('title', '| ' . $project["title"])

@section('content')

@include('partials._nav')

<div id="st-container" class="st-container">
    <div class="section section-header" id="header">
        <div class="parallax filter filter-color-black" style="background-image:url({{ $project["cover_img"] }})">
            <div class="container">
                <div class="content">
                <h1  class="text-capitalize">{{ $project["title"] }}</h1>
                    <div class="separator-container">
                        <div class="separator line-separator">♦</div>
                    </div>
                    <h5>{{ $language === 'fr' ? $project["excerpt"] : ($project["excerpt_eng"] ? $project["excerpt_eng"]  : $project["excerpt"]) }}</h5>
                </div>
            </div>
        </div>
        <a href="" data-scroll="true" data-id="#firstSection" class="scroll-arrow hidden-xs hidden-sm">
            <i class="fa fa-angle-down text-center"></i>
        </a>
    </div>
    <div class="section" id="firstSection">
        <div class="container text-center">
            <h2>{{ $project["title"] }}</h2>
            <div class="separator separator-danger">♦</div>
            @if($project["website_url"])
            <h3>Adresse du site : <a href="{{ $project['website_url'] }}" target="_blank" class="text-center">{{ $project["url"] }}</a></h3>
            @endif
            {!! $language === 'fr' ? $project["description"] : ($project["description_eng"] ? $project["description_eng"]  : $project["description"]) !!}
        </div>
    </div>
    @include('partials._footer')
</div>
<!--/ Main container-->
@endsection
@section('scripts')
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery_lazyload/1.9.7/jquery.lazyload.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.3/imagesloaded.pkgd.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.4/isotope.pkgd.min.js') !!}
{!! Html::script('/js/jquery.photoswipe-global.min.js') !!}
{!! Html::script('/js/general.js') !!}
{!! Html::script('/js/homepage.js') !!}
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