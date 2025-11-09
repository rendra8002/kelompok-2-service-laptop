<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
      
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-user">
                <img alt="image" class="rounded-circle" src="{{ asset('storage/' . Auth::user()->photo) }}"
                    style="width: 50px; height: 50px;">
                <div class="d-sm-none d-lg-inline-block">
                    Hi, {{ Auth::user()->name }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">
                    Logged in {{ Auth::user()->last_login_at?->diffForHumans() ?? 'Never' }}
                </div>
                <a href="{{ route('user.show', Auth::user()->id) }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>

                <!-- Logout yang benar -->
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>

                <!-- Form logout tersembunyi -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>


    </ul>
</nav>
<style>
    .rounded-circle {
        border: 3px solid #e5e5e5;
    }
</style>
