@extends('cabinet.layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 row">
        <div class="d-none d-sm-block col-auto"><h3>{{ __('cabinet.index.title') }}</h3></div>
    </div>

    <div class="row">
        <div class="d-flex col-xl col-md-6">
            <div class="flex-fill card">
                <div class=" py-4 card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $allUser }}</h3>
                            <p class="mb-2">{{ __('title.user.total_users') }}</p>
                            <div class="mb-0">
                                @if($lastDay)
                                    <span class="badge-soft-success me-2 badge">+{{ $lastDay }}</span>
                                @else
                                    <span>{{ $lastDay }}</span>
                                @endif
                                <span class="text-muted">{{ __('title.user.last_day') }}</span>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="feather align-middle me-2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex col-xl col-md-6">
            <div class="flex-fill card">
                <div class=" py-4 card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $allAddresses }}</h3>
                            <p class="mb-2">{{ __('title.address.total') }}</p>
                            <div class="mb-0">
                                @if($lastDayAddresses)
                                    <span class="badge-soft-success me-2 badge">+{{ $lastDayAddresses }}</span>
                                @else
                                    <span>{{ $lastDayAddresses }}</span>
                                @endif
                                <span class="text-muted">{{ __('title.user.last_day') }}</span>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="feather align-middle me-2">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex col-xl col-md-6">
            <div class="flex-fill card">
                <div class=" py-4 card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $allPayment }}</h3>
                            <p class="mb-2">{{ __('title.payment.total') }}</p>
                            <div class="mb-0">
                                @if($lastDayContents)
                                    <span class="badge-soft-success me-2 badge">+{{ $lastDayContents }}</span>
                                @else
                                    <span>{{ $lastDayContents }}</span>
                                @endif
                                <span class="text-muted">{{ __('title.user.last_day') }}</span>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="align-middle text-success">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex col-xl col-md-6">
            <div class="flex-fill card">
                <div class=" py-4 card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $allContents }}</h3>
                            <p class="mb-2">{{ __('title.content.total') }}</p>
                            <div class="mb-0">
                                @if($lastDayContents)
                                    <span class="badge-soft-success me-2 badge">+{{ $lastDayContents }}</span>
                                @else
                                    <span>{{ $lastDayContents }}</span>
                                @endif
                                <span class="text-muted">{{ __('title.user.last_day') }}</span>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="feather align-middle me-2">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex-fill w-100 card">
        <div class="card-header">
            <div class="mb-0 card-title h5" tag="h5">{{ __('title.user.last_logins') }}</div>
        </div>
        <div class="flex-fill w-100 card">
            @include('admin.user.log.table')
        </div>
    </div>
    <div class="flex-fill w-100 card">
        <div class="card-header">
            <div class="mb-0 card-title h5" tag="h5">{{ __('title.user.latest') }}</div>
        </div>
        <div class="flex-fill w-100 card">
            @include('admin.user.table')
        </div>
    </div>
@endsection
