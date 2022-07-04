<nav class="sidebar">
    <div class="simplebar-content-wrapper">
        <div class="simplebar-content">
            <a class="sidebar-brand" href="/">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20"
                     xml:space="preserve" fill="#2871e7">
                <path fill="#84aef2"
                      d="M19.4,4.1l-9-4C10.1,0,9.9,0,9.6,0.1l-9,4C0.2,4.2,0,4.6,0,5s0.2,0.8,0.6,0.9l9,4C9.7,10,9.9,10,10,10s0.3,0,0.4-0.1l9-4     C19.8,5.8,20,5.4,20,5S19.8,4.2,19.4,4.1z"></path>
                    <path
                        d="M10,15c-0.1,0-0.3,0-0.4-0.1l-9-4c-0.5-0.2-0.7-0.8-0.5-1.3c0.2-0.5,0.8-0.7,1.3-0.5l8.6,3.8l8.6-3.8c0.5-0.2,1.1,0,1.3,0.5     c0.2,0.5,0,1.1-0.5,1.3l-9,4C10.3,15,10.1,15,10,15z"></path>
                    <path
                        d="M10,20c-0.1,0-0.3,0-0.4-0.1l-9-4c-0.5-0.2-0.7-0.8-0.5-1.3c0.2-0.5,0.8-0.7,1.3-0.5l8.6,3.8l8.6-3.8c0.5-0.2,1.1,0,1.3,0.5     c0.2,0.5,0,1.1-0.5,1.3l-9,4C10.3,20,10.1,20,10,20z"></path>
            </svg>
                <span class="align-middle">{{ $settings->site_name }}</span>
            </a>
            <ul class="sidebar-nav">
                <li class="sidebar-item" id="hamburger">
                    <a depth="0" activeclassname="active" class="sidebar-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-menu align-middle me-2">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                        <span class="align-middle" depth="0">{{ __('title.menu.collapse_menu') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a depth="0" activeclassname="active" class="sidebar-link" href="{{ Route('admin.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather align-middle">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                            <line x1="9" y1="21" x2="9" y2="9"></line>
                        </svg>
                        <span class="align-middle" depth="0">{{ __('title.main.title') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
                    <a depth="0" activeclassname="active" class="sidebar-link"
                       href="{{ Route('admin.content.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather align-middle me-2">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                        <span class="align-middle" depth="0">{{ __('title.content.many') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.address.*') ? 'active' : '' }}">
                    <a depth="0" activeclassname="active" class="sidebar-link"
                       href="{{ Route('admin.address.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather align-middle me-2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                        <span class="align-middle" depth="0">{{ __('title.menu.addresses') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    <a class="sidebar-link collapsed" data-bs-toggle="collapse" aria-expanded="true" depth="0"
                       href="#user">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather align-middle me-2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="align-middle" depth="0">{{ __('title.menu.users') }}</span>
                        <div></div>
                    </a>

                    <ul id="user" class="sidebar-dropdown list-unstyled collapse">
                        <li class="sidebar-item">
                            <a depth="1" activeclassname="active"
                               class="sidebar-link {{ request()->routeIs('admin.user.index') ? 'active' : '' }}"
                               href="{{ Route('admin.user.index') }}">
                                <span class="align-middle" depth="1">{{ __('title.menu.user_list') }}</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a depth="1" activeclassname="active"
                               class="sidebar-link {{ request()->routeIs('admin.user.log') ? 'active' : '' }}"
                               href="{{ Route('admin.user.log') }}">
                                <span class="align-middle" depth="1">{{ __('title.menu.user_logs') }}</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a depth="1" activeclassname="active"
                               class="sidebar-link {{ request()->routeIs('admin.referral') ? 'active' : '' }}"
                               href="{{ Route('admin.referral') }}">
                                <span class="align-middle" depth="1">{{ __('title.menu.user_referrals') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.payment.*') ? 'active' : '' }}">
                    <a depth="0" activeclassname="active" class="sidebar-link"
                       href="{{ Route('admin.payment.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather align-middle me-2">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                        <span class="align-middle" depth="0">{{ __('title.menu.payments') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.transaction.*') ? 'active' : '' }}">
                    <a depth="0" activeclassname="active" class="sidebar-link"
                       href="{{ Route('admin.transaction') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather align-middle me-2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <span class="align-middle" depth="0">{{ __('title.menu.transactions') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.file') ? 'active' : '' }}">
                    <a depth="0" activeclassname="active" class="sidebar-link" href="{{ Route('admin.file') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather align-middle me-2">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                        <span class="align-middle" depth="0">{{ __('title.menu.files') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.notice.*') ? 'active' : '' }}">
                    <a depth="0" activeclassname="active" class="sidebar-link" href="{{ Route('admin.notice') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather align-middle me-2">
                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                            <polyline points="13 2 13 9 20 9"></polyline>
                        </svg>
                        <span class="align-middle" depth="0">{{ __('title.menu.notices') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <a class="sidebar-link collapsed" data-bs-toggle="collapse" aria-expanded="true" depth="0"
                       href="#settings">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather align-middle me-2">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                        <span class="align-middle" depth="0">{{ __('title.menu.settings') }}</span>
                        <div></div>
                    </a>

                    <ul id="settings" class="sidebar-dropdown list-unstyled collapse">
                        <li class="sidebar-item">
                            <a depth="1" activeclassname="active"
                               class="sidebar-link {{ request()->routeIs('admin.settings.general.*') ? 'active' : '' }}"
                               href="{{ Route('admin.settings.index') }}">
                                <span class="align-middle" depth="1">{{ __('title.menu.general') }}</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a depth="1" activeclassname="active"
                               class="sidebar-link {{ request()->routeIs('admin.notification.*') ? 'active' : '' }}"
                               href="{{ Route('admin.notification.index') }}">
                                <span class="align-middle" depth="1">{{ __('title.menu.notification') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <hr>
                <li class="sidebar-item {{ request()->routeIs('cabinet.index') ? 'active' : '' }}">
                    <a depth="0" activeclassname="active" class="sidebar-link"
                       href="{{ Route('cabinet.index') }}">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-double-right"
                             class="svg-inline--fa fa-angle-double-right fa-w-14 fa-fw align-middle me-2" role="img"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor"
                                  d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34zm192-34l-136-136c-9.4-9.4-24.6-9.4-33.9 0l-22.6 22.6c-9.4 9.4-9.4 24.6 0 33.9l96.4 96.4-96.4 96.4c-9.4 9.4-9.4 24.6 0 33.9l22.6 22.6c9.4 9.4 24.6 9.4 33.9 0l136-136c9.4-9.2 9.4-24.4 0-33.8z"></path>
                        </svg>
                        <span class="align-middle" depth="0">{{ __('title.menu.cabinet') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
