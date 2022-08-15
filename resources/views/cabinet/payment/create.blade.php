@extends('cabinet.layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.payment.payment') }}</h3>
        </div>
        <div class="topButton">
            <a href="{{ Route('cabinet.payment.index') }}">
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
                    <div class="mb-0 card-title h5" tag="h5">{{ __('title.payment.create_new') }}</div>
                </div>
                <div class="card-body">
                    <p>
                        <span style="font-weight: bold">{{ __('title.payment.description.question') }}</span><br>
                        {{ __('title.payment.description.payment') }}<br>
                        {{ __('title.payment.description.wallet', ['wallet' => $user->address->address]) }}<br>
                        {{ __('title.payment.description.info') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
