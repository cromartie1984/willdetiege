<!DOCTYPE html>
<html lang="en">

<head>
  @include('partials._head')
</head>

<body class="{{ Request::is('/') ? 'fixed-sn light-blue-skin' : (Request::is('admin') || Request::is('admin/posts') ? 'fixed-sn slight-blue-skin' : '')}}">

  
    @yield('content')

  @include('partials._javascript')

  @yield('scripts')

</body>

</html>