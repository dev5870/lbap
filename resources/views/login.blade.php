@extends('layouts.auth')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title h5" tag="h5">
                        {{ __('title.login.title') }} or <a href="{{ Route('registration.create') }}">{{ __('title.registration.title') }}</a>
                    </div>
                    @include('includes.alerts')
                    <form method="POST" action="{{ Route('login.store') }}" class="">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('title.input.email') }}</label>
                            <input name="email" placeholder="Email" type="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('title.input.password') }}</label>
                            <input name="password" placeholder="Password" type="password" class="form-control">
                        </div>
                        @if(request()->has('mfa'))
                            <div class="mb-3">
                                <label class="form-label">{{ __('title.input.code') }}</label>
                                <input name="code" placeholder="8888" type="number" class="form-control">
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">{{ __('title.btn.submit') }}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
