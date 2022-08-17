@extends('cabinet.layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 row">
        <div class="d-none d-sm-block col-auto"><h3>{{ __('cabinet.index.title') }}</h3></div>
    </div>

    <div class="flex-fill w-100 card">
        <div class="card-header">
            <div class="mb-0 card-title h5" tag="h5">{{ __('title.user.last_logins') }}</div>
        </div>
        <div class="flex-fill w-100 card">
            @include('cabinet.user.log.table')
        </div>
    </div>
    <div class="flex-fill w-100 card">
        <div class="card-header">
            <div class="mb-0 card-title h5" tag="h5">{{ __('cabinet.index.latest_news') }}</div>
        </div>
        <div class="flex-fill w-100 card">
            @include('cabinet.content.table')
        </div>
    </div>
@endsection
