@extends('cabinet.layouts.default')
@section('content')
    <div class="p-0 container-fluid">
        <h1 class="h3 mb-3">
            {{ __('cabinet.menu.edit') }}
        </h1>
        <form class="" method="POST" action="{{ Route('cabinet.user.security.update') }}">
            <div class="row">
                <div class="col-xl-3 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="mb-0 card-title h5">Profile Details</div>
                        </div>
                        <div class="text-center card-body">
                            <img src="{{ $file ?? asset('assets/img/logo.png') }}" alt="user"
                                 class="img-fluid rounded-circle mb-2" width="128" height="128">
                            <div class="mb-0 card-title h5">
                                <input name="username" value="" placeholder="Stacie Hall" style="width: 120px">
                            </div>
                            <div class="text-muted mb-2">
                                <input name="about" value="" placeholder="Lead Developer" style="width: 120px">
                            </div>
                        </div>
                        <hr class="my-0">
                        <div class="card-body">
                            <div class="card-title h5">Skills</div>
                            <textarea name="skill" value="" placeholder="Separated by commas"
                                      style="width: 170px"></textarea>
                        </div>
                        <hr class="my-0">
                        <div class="card-body">
                            <div class="card-title h5">About</div>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="me-1">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    <input name="city" value="" placeholder="Lives in ..." style="width: 120px">
                            </ul>
                        </div>
                        <hr class="my-0">
                        <div class="card-body">
                            <div class="card-title h5">Telegram</div>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                         data-icon="location-arrow"
                                         class="svg-inline--fa fa-location-arrow fa-w-16 fa-fw align-middle me-2"
                                         role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor"
                                              d="M444.52 3.52L28.74 195.42c-47.97 22.39-31.98 92.75 19.19 92.75h175.91v175.91c0 51.17 70.36 67.17 92.75 19.19l191.9-415.78c15.99-38.39-25.59-79.97-63.97-63.97z"></path>
                                    </svg>
                                    <input name="telegram" value="" placeholder="@your_tg" style="width: 120px">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="mb-0 card-title h5">Description</div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <img src="{{ $file ?? asset('assets/img/logo.png') }}" alt="user" class="rounded-circle me-2" width="36" height="36">
                                <div class="flex-grow-1">
                                    <strong>username</strong>
                                    tell us about yourself, your services and products
                                    <br>
                                    <div class="border text-sm text-muted p-2 mt-1">
                                        <textarea name="skill" value="" placeholder="tell us about yourself" style="width: 565px"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-grid">
                                <button type="button" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
