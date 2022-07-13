<nav class="navbar-bg navbar navbar-expand navbar-light">
    <span class="sidebar-toggle d-flex"><i class="hamburger align-self-center"></i></span>
    @foreach($notifications as $notification)
        @if($notification->status === \App\Enums\NotificationStatus::ACTIVE)
            <div class="alert alert-{{ \App\Enums\NotificationType::$list[$notification->type] }}"
                 style="margin-bottom: 0px; padding: 5px;" role="alert">
                <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="bell"
                     class="svg-inline--fa fa-bell fa-w-14 fa-fw " role="img" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 448 512">
                    <path fill="currentColor"
                          d="M439.39 362.29c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71zM67.53 368c21.22-27.97 44.42-74.33 44.53-159.42 0-.2-.06-.38-.06-.58 0-61.86 50.14-112 112-112s112 50.14 112 112c0 .2-.06.38-.06.58.11 85.1 23.31 131.46 44.53 159.42H67.53zM224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64z"></path>
                </svg>
                <span>{{ $notification->text }}</span>
            </div>
        @endif
    @endforeach
    <div class="navbar-collapse collapse">
        <div class="navbar-align navbar-nav">
            <div class="nav-item dropdown">
                <span class="d-none d-sm-inline-block">
                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false" id="logout"
                       data-bs-toggle="dropdown">
                        <img src="{{ $file ?? asset('assets/img/logo.png') }}" alt="username"
                             class="avatar img-fluid rounded-circle me-1">
                        <span class="text-dark">{{ Auth::user()->email }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                        <form id="logout-form" action="{{ Route('user.logout') }}" method="POST">
                            @csrf
                            <button data-rr-ui-dropdown-item="" class="dropdown-item" type="submit" tabindex="0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather align-middle me-2"><path
                                        d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline
                                        points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9"
                                                                                   y2="12"></line></svg>
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
