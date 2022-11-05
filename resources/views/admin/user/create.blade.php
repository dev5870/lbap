@extends('layouts.default', ['title' => __('title.user.add')])
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.user.create') }}</h3>
        </div>
        <div class="topButton">
            <a href="{{ Route('admin.user.index') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-chevron-left align-middle me-2"
                    >
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    {{ __('title.btn.return') }}
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="mb-0 card-title h5" tag="h5">{{ __('title.user.add') }}</div>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ Route('admin.user.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="inputName">{{ __('title.input.email') }}</label>
                                            <input name="email" placeholder="{{ __('title.input.email') }}"
                                                   type="text" id="inputName" class="form-control"
                                                   value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="inputName">{{ __('title.input.password') }}</label>
                                            <input name="password" placeholder="{{ __('title.input.password') }}"
                                                   type="password" id="inputName" class="form-control"
                                                   value="{{ old('password') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="inputName">{{ __('title.input.repeat_password') }}</label>
                                            <input name="password_confirmation" placeholder="{{ __('title.input.repeat_password') }}"
                                                   type="password" id="inputName" class="form-control"
                                                   value="{{ old('repeat_password') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="inputName">{{ __('title.tg') }}</label>
                                            <input name="telegram" placeholder="{{ __('title.tg') }}"
                                                   type="text" id="inputName" class="form-control"
                                                   value="{{ old('telegram') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="inputName">{{ __('title.user.referrer') }}</label>
                                            <input name="referrer" placeholder="{{ __('title.user.referrer') }}"
                                                   type="text" id="inputName" class="form-control"
                                                   value="{{ old('referrer') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('title.user.comment') }}</label>
                                            <textarea name="comment" placeholder="{{ __('title.user.comment') }}"
                                                      class="form-control" rows="5">{{ old('comment') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            {{ __('title.btn.create') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
