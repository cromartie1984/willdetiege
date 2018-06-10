<header>
  <nav class="navbar navbar-dark navbar-toggleable-md fixed-top scrolling-navbar">
      <!-- SideNav slide-out button -->
    <div class="float-left">
        <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
    </div>
    <!-- Breadcrumb-->
    <div class="breadcrumb-dn mr-auto">
        <p>{{ $pagetitle }}</p>
    </div>

    <ul class="nav navbar-nav nav-flex-icons ml-auto">
      <li class="nav-item">
        <a class="nav-link waves-effect waves-light" type="button" aria-haspopup="true" aria-expanded="false" data-scroll="true" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </li>
    </ul>
  </nav>
 
</header>
<nav class="st-menu st-effect-1" id="menu-1">
    <div class="user-box">
        <img src="/blog_ressources/avatar/{{ Auth::user()->avatar }}" class="img-fluid rounded-circle">
        <ul class="collapsible list-unstyled">
        <!--<p class="user text-xs-center">Jane Doe</p>-->
            <li data-toggle="collapse" data-target="#account" class="collapsed">
                <a class="collapsible-header waves-effect arrow-r text-xs-center" href="#">
                    <span class="text-capitalize">{{ ucfirst(Auth::user()->first_name) . ' ' . strtoupper(Auth::user()->last_name)}}</span> <i class="fa fa-angle-down rotate-icon"></i>
                </a>
            </li>
            <ul class="sub-menu collapse list-unstyled" id="account">
                <li><a href="{{ route('admin.account') }}" class="waves-effect">Edit Account</a>
                </li>
            </ul>
        </ul>
    </div>

    <ul class="collapsible collapsible-accordion list-unstyled">
        <li data-toggle="collapse" data-target="#dasboards" class="collapsed">
            <a class="collapsible-header waves-effect arrow-r" href="#">
                <i class="fa fa-dashboard fa-lg"></i> Tableau de bord <i class="fa fa-angle-down rotate-icon"></i>
            </a>
        </li>
        <ul class="sub-menu collapse list-unstyled" id="dasboards">
            <li><a href="{{ route('admin') }}" class="waves-effect">Analytics</a>
            </li>
        </ul>

        <li data-toggle="collapse" data-target="#blog" class="collapsed">
            <a class="collapsible-header waves-effect arrow-r" href="#">
                <i class="fa fa-globe fa-lg"></i> Blog <i class="fa fa-angle-down rotate-icon"></i>
            </a>
        </li>
        <ul class="sub-menu collapse list-unstyled" id="blog">
            <li>
                <a href="{{ route('admin.posts') }}" class="waves-effect">Overview</a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}" class="waves-effect">Create a copyrighter</a>
            </li>
            <li>
                <a href="{{ route('admin.categories') }}" class="waves-effect">Create/Edit a category</a>
            </li>
            <li>
                <a href="{{ route('admin.tags') }}" class="waves-effect">Create/Edit a tag</a>
            </li>
        </ul>
        <li>
            <a href="{{ route('admin.contacts') }}" class="waves-effect"><i class="fa fa-phone fa-lg"></i> Contacts</a>
        </li>
        <li>
            <a href="{{ route('admin.timelines') }}" class="waves-effect"><i class="fa fa-calendar fa-lg"></i> Web Timeline</a>
        </li>
    </ul>

    <div class="sidenav-bg mask-slight"></div>
</nav>