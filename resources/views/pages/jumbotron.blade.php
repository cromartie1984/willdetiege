<div class="jumbotron">
	<h1>{{ $title }}</h1>
	<p class="lead">{{ $description }}</p>
	@if (isset($button))
	<p><a class="btn btn-primary btn-lg" href="#" role="button">{{ $button }}</a></p>
	@endif
	
</div>