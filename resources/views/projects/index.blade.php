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
                            <p class="card-text">{{ $language === 'fr' ? $project["excerpt"] : ($project["excerpt_eng"] ? $project["excerpt_eng"]  : $project["excerpt"]) }}</p>
                            <a href="/projects/{{ $project["url"] }}" class="btn btn-outline-default waves-effect pull-right" data-translate="project-access">Accéder au projet</a>
                        </div>
                        <!--/.Card content-->
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="fixed-action-btn smooth-scroll" id="backtotop">
      <a data-id="#header" data-scroll="true" class="btn-floating btn-large back-to-top">
        <i class="fa fa-arrow-up"></i>
      </a>
    </div>
    @include('partials._footer')
</div>
<!--/ Main container-->
@endsection

@section('scripts')
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.4/js.cookie.min.js') !!}
{!! Html::script('/js/general.js') !!}
{!! Html::script('/js/homepage.js') !!}
@endsection