            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">Stisla</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">St</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Main</li>
                        <li class="{{ request()->is('/') || request()->is('home') ? 'active' : '' }}">
                            <a class="nav-link" href="/">
                                <i class="fas fa-home"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        </li>
                        <li><a class="nav-link" href="{{ route('services.index') }}"><i class="fas fa-laptop-code"></i> <span>Page
                                    Services</span></a></li>
                                    
                        <li class="menu-header">Master</li>
                        <li class="dropdown {{ request()->is('user*') || request()->is('laptop*') || request()->is('serviceitem*') ? 'active' : '' }}"
                            id="menu-layout">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                                <i class="fas fa-columns"></i> <span>Layout</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{ request()->is('user*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('user.index') }}">User</a>
                                </li>
                                <li class="{{ request()->is('laptop*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('laptop.index') }}">Laptop</a>
                                </li>
                                <li class="{{ request()->is('serviceitem*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('serviceitem.index') }}">Service Item</a>
                                </li>
                            </ul>
                        </li>

                    </ul>

                    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                            <i class="fab fa-github"></i> Documentation
                        </a>
                    </div>
                </aside>
            </div>
