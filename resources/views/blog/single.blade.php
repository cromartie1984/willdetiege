@extends('main')

@section('title', "| " . htmlspecialchars($post->title))

@section('content')

<div id="st-container" class="st-container">
	@include('partials._nav')
	<div class="image_blog_cover parallax" id="header" style="background-image: url({{$post->image }})">
		@if($post->video)
		<div class="text-intro text-center">
			<a href="//www.youtube.com/watch?v={{$post->video }}" data-lity class="popup-youtube text-center">
				<div></div>
			</a>
		</div>
		@endif
	</div>
	<div class="container">

		<div class="row">
			<div class="col-md-12 mb-2 section-blog-fw">


                    <div class="jumbotron wow fadeIn" data-wow-delay="0.3s">
                        <div class="blog-text text-center">

                            <!-- Post data -->
                            <a href="{{ route('blog.category', replaceAccents($language === 'fr' ? $post["name_fr"] : ($post["name_eng"] ? $post["name_eng"]  : $post["name_fr"]))) }}" class="amber-text"><h4>{{ $language === 'fr' ? $post["name_fr"] : ($post["name_eng"] ? $post["name_eng"]  : $post["name_fr"]) }}</h4></a>

                            <h1 class="text-capitalize">{{ $language === 'fr' ? $post["title"] : ($post["title_eng"] ? $post["title_eng"]  : $post["title"]) }}</h1>

                            <h5><span data-translate="by-author">Par</span><a href="{{ route('blog.author', $post['last_name']) }}" class="black-text"> {{ ucfirst($post["first_name"]) . ' ' . strtoupper($post['last_name']) }}</a>, {{ strftime('%e %B %Y', strtotime($post["created_at"])) }}</h5>

                        </div>
                        <!--Social shares-->
                        <div class="social-counters">
                            <!--Facebook-->
                            <a class="btn btn-fb" href="http://www.facebook.com/sharer.php?u={{ route('blog.single', $post->slug) }}" target="_blank">
                                <i class="fa fa-facebook left"></i>
                                <span class="hidden-md-down ">Facebook</span>
                            </a>
                            <span class="counter">0</span>

                            <!--Google+-->
                            <a class="btn btn-gplus" href="https://plus.google.com/share?url={{ route('blog.single', $post->slug) }}" target="_blank">
                                <i class="fa fa-google-plus left"></i>
                                <span class="hidden-md-down">Google+</span>
                            </a>
                            <span class="counter">0</span>

                            <!--Comments-->
                            <a class="btn btn-mdb" href="{{ route('blog.single', $post->slug) }}#comments">
                                <i class="fa fa-comments-o left"></i>
                                <span class="hidden-md-down">Comments</span>
                            </a>
                            <span class="counter disqus-comment-count" data-disqus-url="{{ route('blog.single', $post->slug) }}"></span>

                        </div>
                        <!--/.Social shares-->

                    </div>
                </div>
                <div class="col-md-12">
                    <section class="section article-section">

                        <!--First row-->
                        <div class="row">

                            <div class="col-md-12">

                                <div class="article-text wow fadeIn" data-wow-delay="0.3s">

                                    {!! $language === 'fr' ? $post->body : ($post->body_eng ? $post->body_eng  : $post->body) !!}
									<div class="clearfix"></div>
                                </div>
                                
                                <div class="d-inline-block text-capitalize"><span data-translate="tags-text">Mots clés</span> : </div>
                                <ul class="d-inline-block list-inline">
                                @foreach($post->tags as $tag)
                                    <li class="list-inline-item">
                                    	<a class="badge badge-primary" href="{{ route('blog.tag', replaceAccents(strtolower(str_replace(" ", "-", ($language === 'fr' ? $tag->name : ($tag->name_eng ? $tag->name_eng  : $tag->name)))))) }}">{{ $language === 'fr' ? $tag->name : ($tag->name_eng ? $tag->name_eng  : $tag->name) }}</a>
                                    </li>
                                @endforeach
                                </ul>

                                <hr class="wow fadeIn" data-wow-delay="0.3s">

                                    <div class="text-center wow fadeIn mt-1" data-wow-delay="0.3s">
                                        <h3 class="h3-responsive" data-translate="share-text">Voulez-vous partager ?</h3>
                                        <!--Facebook-->
                                        <a href="http://www.facebook.com/sharer.php?u={{ route('blog.single', $post->slug) }}" target="_blank" class="btn-floating btn-small btn-fb"><i class="fa fa-facebook"> </i></a>
                                        <!--Twitter-->
                                        <a href="https://twitter.com/share?url={{ route('blog.single', $post->slug) }}&amp;text=Simple%20Share%20Buttons&amp;hashtags=vault51" target="_blank" class="btn-floating btn-small btn-tw"><i class="fa fa-twitter"> </i></a>
                                        <!--Google +-->
                                        <a href="https://plus.google.com/share?url={{ route('blog.single', $post->slug) }}" target="_blank" class="btn-floating btn-small btn-gplus"><i class="fa fa-google-plus"> </i></a>
                                    </div>

                            </div>

                        </div>
                        <!--/First row-->

                    </section>
                    <section class="mb-4 wow fadeIn" data-wow-delay="0.3s">
                        <!--Author box-->
                        <div class="author-box blog-author-box">

                            <div class="row">

                                <!--Avatar-->
                                <div class="col-sm-3 col-xs-12">
                                    <div class="view overlay hm-white-slight">
                                        <img src="/blog_ressources/avatar/{{ $post["avatar"] }}" class="img-fluid rounded-circle z-depth-2"/>
                                        <a>
                                            <div class="mask"></div>
                                        </a>
                                    </div>
                                </div>

                                <!--Author Data-->
                                <div class=" col-xs-12 col-sm-9">

                                    <h4><strong>{{ ucfirst($post["first_name"]) . ' ' . strtoupper($post['last_name']) }}</strong></h4>

                                    <div class="personal-sm">

                                        <a class="email-ic" href="{{ route('blog.author', strtolower($post['last_name'])) }}"><i class="fa fa-home fa-2x"></i></a>
                                        @if($post['facebook'])
                                        <a href="{{ $post["facebook"] }}" target="_blank" class="fb-ic"><i class="fa fa-facebook fa-2x"> </i></a>
                                        @endif
                                        @if($post['twitter'])
                                        <a href="{{ $post["twitter"] }}" target="_blank" class="fb-ic"><i class="fa fa-twitter fa-2x"> </i></a>
                                        @endif
                                        @if($post['google'])
                                        <a href="{{ $post["google"] }}" target="_blank" class="fb-ic"><i class="fa fa-google-plus fa-2x"> </i></a>
                                        @endif
                                        @if($post['show_email'])
                                        <a class="email-ic" href="mailto:{{ $post["email"] }}"><i class="fa fa-envelope-o fa-2x"> </i></a>
                                        @endif
                                    </div>
                                    @if($post['website'])
                                    <a href="{{ $post["website"] }}" target="_blank"><h4>{{ $post["website"] }}</h4></a>
                                    @endif
                                    <p>{{ $language === 'fr' ? $post->description : ($post->description_eng ? $post->description_eng  : $post->description)  }}</p>
                                </div>

                            </div>
                        </div>
                        <!--/.Author box-->
                    </section>
                    <section class="wow fadeIn" data-wow-delay="0.3s">

                        <!--First row-->
                        <div class="row">

                            <!--First column-->
                            <div class="col-md-6">

                                <!--Prev post-->
                                <div class="prev-next-post">

                                    <a href="{{ $previous_post["slug"] }}" class="waves-effect waves-light">

                                        <!--Image-->
                                        <img src="{{ $previous_post["thumbnail"] }}"/>

                                        <!--Mask-->
                                        <div class="overlay">

                                            <!--Title-->
                                            <div class="title-text">
                                                <p><i class="float-left fa fa-angle-left"></i>{{ $language === 'fr' ? $previous_post["title"] : ($previous_post["title_eng"] ? $previous_post["title_eng"]  : $previous_post["title"]) }}</p>
                                            </div>

                                        </div>
                                        <!--/.Mask-->

                                    </a>

                                </div>
                                <!--/.Prev post-->

                            </div>
                            <!--/.First column-->

                            <!--Second column-->
                            <div class="col-md-6">

                                <!--Next post-->
                                <div class="prev-next-post">
                                    <a href="{{ $next_post["slug"] }}" class="waves-effect waves-light">

                                        <!--Image-->
                                        <img src="{{ $next_post["thumbnail"] }}"/>

                                        <!--Mask-->
                                        <div class="overlay">

                                            <!--Title-->
                                            <div class="title-text">
                                                <p><i class="float-right fa fa-angle-right"></i>{{ $language === 'fr' ? $next_post["title"] : ($next_post["title_eng"] ? $next_post["title_eng"]  : $next_post["title"]) }}</p>
                                            </div>

                                        </div>
                                        <!--/.Mask-->

                                    </a>

                                </div>
                                <!--/.Next post-->

                            </div>
                            <!--/.Second column-->

                        </div>
                        <!--First row-->

                    </section>

                    <section class="related-posts-carousel wow fadeIn" data-wow-delay="0.3s">

                        <div class="row">

                            <div class="col-md-12">

                                <h2 class="text-center" data-translate="related-text">articles similaires</h2>

                                <!--Carousel Wrapper-->
                                <div id="articles-similaires" class="carousel slide carousel-multi-item" data-ride="carousel">

                                    <!--Indicators-->
                                    <ol class="carousel-indicators">
                                    	@foreach($similar_posts as $index=>$similar_post)
                                    	@if($index + 1 % 3 === 0)
 										<li data-target="#articles-similaires" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                                    	@endif
                                        @endforeach
                                    </ol>
                                    <!--/.Indicators-->

                                    <!--Slides-->
                                    <div class="carousel-inner" role="listbox">
                                    <!--<div class="carousel-item active">-->
                                    	<div class="row">

	                                    	@foreach($similar_posts as $similar_post)
	                                    	<div class="col-md-4">
	                                    		<!-- Card -->
	                                    		<div class="card">
	                                    			<!-- Card image -->
	                                    			<div class="view hm-white-slight">
	                                    				<img class="img-fluid" src="{{ $similar_post->thumbnail }}" alt="Card image cap">
	                                    				<a href="{{ route('blog.single', $similar_post->slug) }}">
	                                    					<div class="mask"></div>
	                                    				</a>
	                                    			</div>

	                                    			<!-- Card content -->
	                                    			<div class="card-block">
	                                    				<!-- Title -->
	                                    				<a class="card-text" href="{{ route('blog.single', $similar_post->slug) }}">{{ $language === 'fr' ? $similar_post["title"] : ($similar_post["title_eng"] ? $similar_post["title_eng"]  : $similar_post["title"]) }}</a>
	                                    			</div>

	                                    			<!-- Card footer -->
	                                    			<div class="card-data">
	                                    				<ul class="pl-2 pt-2">
	                                    					<li><p>{{ strftime('%x', strtotime($similar_post["created_at"])) }}</p></li>
	                                    					<li><a class="pr-2" href="{{ route('blog.single', $similar_post->slug) }}#comments"><i class="fa fa-comments-o"></i><span class="disqus-comment-count" data-disqus-url="{{ route('blog.single', $similar_post->slug) }}"></span></a></li>
	                                    				</ul>
	                                    			</div>

	                                    		</div>
	                                    		<!--/ Card -->
	                                    	</div>
	                                        @endforeach
                                        </div>
                                    </div>
                                    <!--/.Slides-->

                                </div>
                                <!--/.Carousel Wrapper-->

                            </div>

                        </div>

                    </section>

                </div>
                <div class="col-md-12" id="comments">
                    <div id="disqus_thread"></div>
                    <script>
                        (function () {
                            var d = document, s = d.createElement("script");
                            s.src = "//willdetiege.disqus.com/embed.js";
                            s.setAttribute("data-timestamp", +new Date());
                            (d.head || d.body).appendChild(s);
                        })();
                    </script>
                    <noscript>Merci d&#39;activer le JavaScript pour voir les <a href="https://disqus.com/?ref_noscript" rel="nofollow">commentaires fournis par Disqus.</a></noscript>
                </div>

			</div>
	</div>


	@include('partials._footer')
</div>

<!-- <img src="{{asset('/images/' . $post->image)}}" width="800" height="400" />-->

@endsection

@section('scripts')
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/salvattore/1.0.9/salvattore.min.js') !!}
{!! Html::script('//willdetiege.disqus.com/count.js') !!}
{!! Html::script('https://production-assets.codepen.io/assets/embed/ei.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.4/js.cookie.min.js') !!}
{!! Html::script('/js/jquery.photoswipe-global.min.js') !!}
{!! Html::script('/js/jqueryTranslator.min.js') !!}
{!! Html::script('/js/general.js') !!}
{!! Html::script('/js/homepage.js') !!}
{!! Html::script('/js/blog.js') !!}
<script type="text/javascript">
	$(document).ready(function () {

		new WOW().init();

		$(window).scroll(function () {
			if ($(this).scrollTop() > 300) {
				$(".nav-growpop").fadeIn();
			} else {
				$(".nav-growpop").fadeOut();
			}
		});

		/* $('.main').perfectScrollbar({suppressScrollX:true});*/
	});
</script>
@endsection