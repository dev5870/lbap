<nav class="navbar-bg navbar navbar-expand navbar-light">
    <span class="sidebar-toggle d-flex"><i class="hamburger align-self-center"></i></span>
    <div class="navbar-collapse collapse">
        <div class="navbar-align navbar-nav">
            <div class="nav-item dropdown">
                <span class="d-none d-sm-inline-block">
                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false" id="logout" data-bs-toggle="dropdown">
                        <img src="{{ $file ?? asset('assets/img/logo.png') }}" alt="username" class="avatar img-fluid rounded-circle me-1">
                        <span class="text-dark">user_email</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                        <form id="logout-form" action="" method="POST">
                            @csrf
                            <button data-rr-ui-dropdown-item="" class="dropdown-item" type="submit" tabindex="0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather align-middle me-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                {{ __('title.btn.logout') }}
                            </button>
                        </form>
                        </li>
                    </ul>
                </span>
            </div>
        </div>
    </div>
</nav>
