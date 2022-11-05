@extends('cabinet.layouts.default', ['title' => __('cabinet.profile.title')])
@section('content')
    <div class="p-0 container-fluid">
        <h1 class="h3 mb-3">
            {{ __('cabinet.profile.title') }}
        </h1>
        <div class="row">
            <div class="col-xl-3 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="mb-0 card-title h5">
                            {{ __('cabinet.profile.details') }}
                        </div>
                    </div>
                    <div class="text-center card-body">
                        <img src="{{ $file ?? asset('assets/img/logo.png') }}" alt="user"
                             class="img-fluid rounded-circle mb-2" width="128" height="128">
                        <div class="mb-0 card-title h5">
                            {{ $profile->username }}
                        </div>
                        <div class="text-muted mb-2">
                            {{ $profile->about }}
                        </div>
                        <div style="display: none">
                            <button type="button" class="me-1 btn btn-primary btn-sm">
                                {{ __('cabinet.profile.add_favorite') }}
                            </button>
                            <button type="button" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                {{ __('cabinet.profile.message') }}
                            </button>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="card-title h5">
                            {{ __('cabinet.profile.skills') }}
                        </div>
                        @foreach(explode(',', $profile->skill) as $item)
                            <span class="me-2 my-1 badge bg-primary">
                                {{ $item }}
                            </span>
                        @endforeach
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="card-title h5">
                            {{ __('cabinet.profile.city') }}
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="me-1">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                {{ __('cabinet.profile.lives') }} {{ $profile->city }}</li>
                        </ul>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="card-title h5">
                            {{ __('cabinet.profile.tg') }}
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-1">
                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="globe"
                                     class="svg-inline--fa fa-globe fa-w-16 fa-fw me-1" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
                                    <path fill="currentColor"
                                          d="M336.5 160C322 70.7 287.8 8 248 8s-74 62.7-88.5 152h177zM152 256c0 22.2 1.2 43.5 3.3 64h185.3c2.1-20.5 3.3-41.8 3.3-64s-1.2-43.5-3.3-64H155.3c-2.1 20.5-3.3 41.8-3.3 64zm324.7-96c-28.6-67.9-86.5-120.4-158-141.6 24.4 33.8 41.2 84.7 50 141.6h108zM177.2 18.4C105.8 39.6 47.8 92.1 19.3 160h108c8.7-56.9 25.5-107.8 49.9-141.6zM487.4 192H372.7c2.1 21 3.3 42.5 3.3 64s-1.2 43-3.3 64h114.6c5.5-20.5 8.6-41.8 8.6-64s-3.1-43.5-8.5-64zM120 256c0-21.5 1.2-43 3.3-64H8.6C3.2 212.5 0 233.8 0 256s3.2 43.5 8.6 64h114.6c-2-21-3.2-42.5-3.2-64zm39.5 96c14.5 89.3 48.7 152 88.5 152s74-62.7 88.5-152h-177zm159.3 141.6c71.4-21.2 129.4-73.7 158-141.6h-108c-8.8 56.9-25.6 107.8-50 141.6zM19.3 352c28.6 67.9 86.5 120.4 158 141.6-24.4-33.8-41.2-84.7-50-141.6h-108z"></path>
                                </svg>
                                {{ $profile->telegram }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="mb-0 card-title h5">
                            {{ __('cabinet.profile.description') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="{{ $file ?? asset('assets/img/logo.png') }}" alt="user"
                                 class="rounded-circle me-2" width="36" height="36">
                            <div class="flex-grow-1">
                                <strong>{{ $profile->username }}</strong>
                                {{ __('cabinet.profile.info_2') }}
                                <br>
                                <div class="border text-sm text-muted p-2 mt-1">
                                    {{ $profile->description }}
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="mb-0 card-title h5">
                            {{ __('cabinet.profile.activity') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <strong>{{ __('cabinet.profile.date_registration') }}</strong>
                                {{ $profile->user->created_at }}
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <strong>{{ __('cabinet.profile.last_login') }}</strong>
                                @if(isset($profile->user->activity) && now() < $profile->user->activity->last_activity->addMinutes(10))
                                    <span style="color: green">online</span>
                                @elseif(isset($profile->user->activity))
                                    {{ $profile->user->activity->last_activity }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
