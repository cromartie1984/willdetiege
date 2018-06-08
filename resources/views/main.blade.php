<!DOCTYPE html>
<html lang="en">

	<head>
	  @include('partials._head')
	</head>

	<body @unless(empty($body_class)) class="{{$body_class}}" @endunless>

	  
	    @yield('content')

	  @include('partials._javascript')

	  @yield('scripts')

	</body>

</html>