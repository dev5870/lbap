@extends('cabinet.layouts.default')
@section('content')
    <div class="p-0 container-fluid">
        <h1 class="h3 mb-3">
            {{ __('cabinet.menu.security') }}
        </h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if($telegram)
                                    {{ __('cabinet.security.info_2') }}
                                @else
                                    {{ __('cabinet.security.info_1') }} <br>
                                    <a href="{{ env('TELEGRAM_BOT_URL') }}" target="_blank">{{ env('TELEGRAM_BOT_NAME') }}</a>
                                    ({{ __('cabinet.security.secret_key') }} {{ Auth::user()->secret_key }})
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="" method="POST" action="{{ Route('cabinet.user.security.update') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="mfa" id="mfa" class="form-check-input" {{ $params->mfa == 1 ? 'checked' : '' }}>
                                            <label title="" for="mfa" class="form-check-label">
                                                {{ __('cabinet.security.mfa') }}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="login_notify" id="login_notify" class="form-check-input" {{ $params->login_notify == 1 ? 'checked' : '' }}>
                                            <label title="" for="login_notify" class="form-check-label">
                                                {{ __('cabinet.security.login_notify') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" {{ $telegram ? '' : 'disabled' }}>
                                {{ __('title.btn.update') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
