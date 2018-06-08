@extends('main', ['body_class' => 'fixed-sn light-blue-skin'])

@section('title', '| Blog')

@section('content')

<div id="st-container" class="st-container">
	@include('partials._nav')
	<div id="header" class="carousel white-text kb_elastic animate_text kb_wrapper" data-ride="carousel" data-interval="6000" data-pause="hover">
		<ol class="carousel-indicators">
			@foreach($posts as $index=>$post)
			@if($index < 3)
			<li data-target="#header" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
			@endif
			@endforeach
		</ol>
		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			@foreach($posts as $index=>$post)
			<div class="carousel-item {{ $index == 0 ? 'active' : '' }} view hm-black-light">
				<!--Caption-->
				<img src="{{ $post["image"] }}" alt="slider {{ $index }}" />
				<div class="carousel-caption caption-2">
					<div class="animated fadeInDown">
					<h2 class="h2-responsive text-capitalize">{{ $language === 'fr' ? $post["title"] : ($post["title_eng"] ? $post["title_eng"]  : $post["title"]) }}</h2>
						<a class="btn btn-mdb waves-effect" href="{{ route('blog.single', $post->slug) }}" data-translate="read-text">Lire la suite</a>
					</div>
				</div>
				<!--Caption-->
			</div>
            @endforeach
		</div>
		<a class="left carousel-control kb_control_left" href="#header" role="button" data-slide="prev">
			<span class="icon-prev" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control kb_control_right" href="#header" role="button" data-slide="next">
			<span class="icon-next" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
 	<div class="container">

		<div class="row">
		
			<div class="col-xl-8 col-md-12">
				@if($filter)
				<h2 class="main-heading mb-0"><span data-translate="browsing-text">Parcourir</span> : <strong class="text-capitalize">{{ $filter }}</strong></h2>
				@endif
				<!--Section: Blog v.3-->
				<section class="section extra-margins">
					@foreach($posts as $post)
					<div class="row wow fadeIn" data-wow-delay="0.3s">

						<!--First column-->
						<div class="col-md-5 mb-5">
							<!--Featured image-->
							<div class="view overlay hm-white-slight">
							<img src="{{ $post["thumbnail"] }}"/>
								<a href="{{ route('blog.single', $post->slug) }}">
									<div class="mask"></div>
								</a>
							</div>
							<div class="text-center blog-social-icons mt-3 font-thin">
								<!--Facebook-->
								<a class="icons-sm fb-ic"><i class="fa fa-facebook"></i><span class="text-muted">0</span></a>
								<!--Google-->
								<a class="icons-sm tw-ic"><i class="fa fa-google-plus"></i><span class="text-muted">0</span></a>
								<!--Comments-->
								<a class="icons-sm comm-ic" href="{{ route('blog.single', $post->slug) }}#comments"><i class="fa fa-comments"></i><span class="text-muted"> <span class="disqus-comment-count" data-disqus-url="{{ route('blog.single', $post->slug) }}"></span></span></a>
							</div>
						</div>
						<!--/First column-->

						<!--Second column-->
						<div class="col-md-7 mb-5">
							<!--Excerpt-->
							<a href="{{ route('blog.category', replaceAccents(strtolower(str_replace(" ", "-", $language === 'fr' ? $post["name_fr"] : ($post["name_eng"] ? $post["name_eng"]  : $post["name_fr"])))))  }}" class="light-blue-text"><h5 class="text-capitalize"> {{ ucfirst(strtolower(str_replace("-", "", $language === 'fr' ? $post["name_fr"] : ($post["name_eng"] ? $post["name_eng"]  : $post["name_fr"])))) }}</h5></a>
							<a href="{{ route('blog.single', $post->slug) }}"><h4 class="text-capitalize">{{ $language === 'fr' ? $post["title"] : ($post["title_eng"] ? $post["title_eng"]  : $post["title"]) }}</h4></a>
							<p>{!! ($language === 'fr' ? $post["excerpt"] : ($post["excerpt_eng"] ? $post["excerpt_eng"]  : $post["excerpt"])) ? ($language === 'fr' ? $post["excerpt"] : ($post["excerpt_eng"] ? $post["excerpt_eng"]  : $post["excerpt"])) : substr(strip_tags($language === 'fr' ? $post["body"] : ($post["body_eng"] ? $post["body_eng"]  : $post["body"])), 0, 150) . (strlen(strip_tags($language === 'fr' ? $post["body"] : ($post["body_eng"] ? $post["body_eng"]  : $post["body"]))) > 250 ? "..." : "") !!}</p>

							<p><span data-translate="by-author">par</span> <a href="{{ route('blog.author', strtolower($post["last_name"]) ) }}"><strong>{{ ucfirst($post["first_name"]) . ' ' . strtoupper($post["last_name"]) }}</strong></a>, {{ strftime('%e %b %Y', strtotime($post["created_at"])) }}</p>
							<a class="btn btn-outline-grey waves-effect" href="{{ route('blog.single', $post->slug) }}" data-translate="read-text">Lire la suite</a>
						</div>
						<!--/Second column-->
					</div>
					@endforeach
				</section>
				<!--/Section: Blog v.3-->

				<!--Pagination dark grey-->
				<nav class="wow fadeIn text-center" data-wow-delay="0.3s">
					{!! $posts->links() !!}
				</nav>
				<!--/.Pagination dark grey-->
			</div>
			<div class="col-xl-4 col-md-12">
				@php
				$archives = [];
				$previous_date = 0;
				$previous_dates = [];
				$mois_nombre = 0;
				$articles_mois = 0;
				$mois_nom = [];
				$categories = [];
				$categories_nom = [];
				$aucune_categorie_similaire = 0;
				foreach($posts_sidebar as $index=>$post){
					$aucune_categorie_similaire = 0;
					if($index == 0) array_push($categories_nom, ($language === 'fr' ? $post["name_fr"] : ($post["name_eng"] ? $post["name_eng"]  : $post["name_fr"])));
					for ($u = 0; $u < count($categories_nom); $u++) {
						if ($categories_nom[$u] == ($language === 'fr' ? $post["name_fr"] : ($post["name_eng"] ? $post["name_eng"]  : $post["name_fr"]))) {
							$aucune_categorie_similaire++;
						}
					}
					if ($aucune_categorie_similaire === 0) {
						array_push($categories_nom, ($language === 'fr' ? $post["name_fr"] : ($post["name_eng"] ? $post["name_eng"]  : $post["name_fr"])));
					}
					$categories[$index][0] = $language === 'fr' ? $post["name_fr"] : ($post["name_eng"] ? $post["name_eng"]  : $post["name_fr"]);
					if (strtotime(date('Ym', strtotime($post["created_at"]))) !== $previous_date && $index !== 0) {
						$mois_nombre++;
						$articles_mois = 0;
					}
					$categories[$index][0] = $language === 'fr' ? $post["name_fr"] : ($post["name_eng"] ? $post["name_eng"]  : $post["name_fr"]);
					$mois_nom[$mois_nombre] = strtotime($post["created_at"]);
					$archives[$mois_nombre][$articles_mois] = "1";
					$articles_mois++;
					$previous_date = strtotime(date('Ym', strtotime($post["created_at"])));
					$previous_dates[$index] = $previous_date;
				}
				@endphp
				<section class="section widget-content wow fadeIn" data-wow-delay="0.3s">
					<nav class="navbar navbar-dark sidebar-heading cyan darken-2">
						<div class="flex-center w-100">
							<p class="white-text" data-translate="categories">Catégories</p>
						</div>
					</nav>
				</section>
				<!--Author card-->
				<section class="archive section widget-content wow fadeIn">

					<!--First row-->
					<div class="row">

						<!--First column-->
						<div class="col-md-12 text-center">

							<!--List-->
							<ul class='list-unstyled mb-3'>
								@foreach($categories_nom as $index=>$categorie)
								@php
								$categorie_similaire = 0;
								foreach($categories as $category) {
									if ($category[0] === $categorie) {
										$categorie_similaire++;
									}
                				}
								@endphp
								<li>
									<h5 class="text-capitalize">
										<a href="{{ route('blog.category', replaceAccents(strtolower(str_replace(" ", "-", $categorie)))) }}">{{ ucfirst($categorie) . ' (' . $categorie_similaire }})
										</a>
									</h5>
								</li>
								@endforeach
							</ul>
							<!--List-->

						</div>
						<!--First column-->

					</div>
					<!--/First row-->

				</section>
				<!--/Author card-->
				<section class="section widget-content wow fadeIn" data-wow-delay="0.3s">
					<nav class="navbar navbar-dark sidebar-heading cyan darken-2">
						<div class="flex-center  w-100">
							<p class="white-text" data-translate="recent-posts">Articles récents</p>
						</div>
					</nav>
				</section>
				<!--Recent posts-->
				<section class="section widget-content">
					@foreach($posts_sidebar as $index=>$post)
						@if($index < 3)
						<div class="single-post wow fadeIn" data-wow-delay="0.3s">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="view overlay hm-white-slight">
                                        <img src="{{ $post["thumbnail"] }}"/>
                                        <a href="{{ route('blog.single', $post->slug) }}">
                                            <div class="mask"></div>
                                        </a>
                                    </div>
                                    <div class="post-data featured">
                                        <p><i class="fa fa-clock-o"></i> {{ strftime('%e %b %Y', strtotime($post["created_at"])) }}</p>
                                        <a href="{{ route('blog.single', $post->slug) }}#comments"><i class="fa fa-comments-o"></i> <span class="disqus-comment-count" data-disqus-url="{{ route('blog.single', $post->slug) }}"></span></a>
                                    </div>
                                    <h6><a href="{{ route('blog.single', $post->slug) }}">{{ $language === 'fr' ? $post["title"] : ($post["title_eng"] ? $post["title_eng"]  : $post["title"]) }}</a></h6>
                                </div>
                            </div>
	                    </div>
                        @endif
                    @endforeach
				</section>
				<!--/Recent posts-->

				<section class="section widget-content wow fadeIn" data-wow-delay="0.3s">
					<nav class="navbar navbar-dark sidebar-heading cyan darken-2">
						<div class="flex-center  w-100">
							<p class="white-text" data-translate="tags-text">Mots clés</p>
						</div>
					</nav>
				</section>

				<!--Newsletter-->
				<section class="section widget-content wow fadeIn mb-4" data-wow-delay="0.3s">

					<!--First row-->
					<div class="row">
						<!--First column-->
						<div class="col-md-12">

							<!--Form without header-->
							<div class="card">
								<div class="card-block">
									<ul class="d-inline-block list-inline">
										@foreach($tags as $tag)
										<li class="list-inline-item"><a class="badge badge-primary" href="{{ route('blog.tag', replaceAccents(strtolower(str_replace(" ", "-", $language === 'fr' ? $tag["name"] : ($tag["name_eng"] ? $tag["name_eng"]  : $tag["name"]))))) }}">{{ $language === 'fr' ? $tag["name"] : ($tag["name_eng"] ? $tag["name_eng"]  : $tag["name"]) }}</a>
										</li>
										@endforeach
									</ul>
								</div>
							</div>
							<!--/Form without header-->

						</div>
						<!--/First column-->
					</div>
					<!--/First row-->

				</section>
				<!--/Newsletter-->


				<section class="section widget-content wow fadeIn" data-wow-delay="0.3s">
					<nav class="navbar navbar-dark sidebar-heading cyan darken-2">
						<div class="flex-center  w-100">
							<p class="white-text">Archive</p>
						</div>
					</nav>
				</section>

				<!--Archive-->
				<section class="archive wow fadeIn" data-wow-delay="0.3s">

					<!--First row-->
					<div class="row">

						<!--First column-->
						<div class="col-md-12 text-center">
							<!--List-->
							<ul class="list-unstyled">
								@foreach($mois_nom as $index=>$mois)
								<li>
									<h5 class="text-capitalize">
										<a href="{{ route('blog.archive', [date('Y', $mois), date('m', $mois)] ) }}">{{ strftime('%B %Y', $mois) . ' (' . count($archives[$index]) }})</a>
									</h5>
								</li>
								@endforeach
							</ul>
							<!--List-->

						</div>
						<!--First column-->

					</div>
					<!--/First row-->

				</section>
				<!--/Archive-->
			</div>
		</div>
	</div>
	@include('partials._footer')
</div>

@endsection

@section('scripts')
{!! Html::script('//willdetiege.disqus.com/count.js') !!}
{!! Html::script('/js/general.js') !!}
{!! Html::script('/js/homepage.js') !!}
{!! Html::script('/js/blog.js') !!}

<script type="text/javascript">
	$(document).ready(function () {

		new WOW().init();
		/* $('.main').perfectScrollbar({suppressScrollX:true});*/
	});
</script>
@endsection