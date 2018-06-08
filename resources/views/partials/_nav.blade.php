<header>
  <nav class="navbar navbar-dark navbar-toggleable-md fixed-top scrolling-navbar cyan darken-2">
      <!-- Brand and toggle get grouped for better mobile display -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav1" aria-controls="navbarNav1" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
      </button>
    <div class="container">
      <a class="navbar-brand" href="/">
        Willdetiege
      </a>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="navbar-collapse collapse" id="navbarNav">
        <ul class="nav navbar-nav mr-auto smooth-scroll">
          <li class="nav-item {{ Request::is('/') ? "active" : ""}}"><a class="nav-link waves-effect waves-light" href="/" data-id="#header" data-scroll="true" data-translate="home-menu">Accueil</a></li>
          <li class="nav-item {{ Request::is('blog') ? "active" : ""}}"><a class="nav-link waves-effect waves-light" href="/blog" data-translate="blog-menu">Blog</a></li>
          <li class="nav-item {{ Request::is('projects') ? "active" : ""}}"><a class="nav-link waves-effect waves-light" href="/projects" data-translate="portfolio-menu">Projects</a></li>
          <li class="nav-item {{ Request::is('contact') ? "active" : ""}}"><a class="nav-link waves-effect waves-light" href="/contact" data-scroll="true" data-id="#contact">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav smooth-scroll navbar-right">
          @if (!Auth::guest())
          <li class="nav-item">
            <a class="nav-link waves-effect waves-light" href="{{ route('admin') }}">Admin</a>
          </li>
          @else
          <li class="nav-item {{ Request::is('/login') ? "active" : ""}}">
            <a class="nav-link waves-effect waves-light" href="{{ route('login') }}">Login</a>
          </li>
          @endif

        </ul>
      </div>
      <div class="float-right">
        <select class="language-picker js-states form-control" data-size="5" id="language" style="width: 150px">
          <option value="fr">Français</option>
          <option value="en">English</option>
        </select>
      </div>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
  </nav>
  <nav class="st-menu st-effect-1" id="menu-1">
      <ul class="collapsible collapsible-accordion">
          <li>
              <a href="/index" class="waves-effect arrow-r">
                  <i class="fa fa-home fa-lg"></i> <span data-translate="home-menu">Accueil</span>
              </a>
          </li>
          <li>
              <a class="waves-effect arrow-r" href="/portfolio">
                  <i class="fa fa-book fa-lg"></i> Portfolio
              </a>
          </li>
          <li>
              <a class="waves-effect arrow-r" href="/blog">
                  <i class="fa fa-rss fa-lg"></i> Blog
              </a>
          </li>
      </ul>
      <div class="sidenav-bg mask-slight"></div>
  </nav>
</header>