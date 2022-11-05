@extends('layouts.default', ['title' => __('title.user.referrals')])
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.user.referrals') }}</h3>
        </div>
        <div class="topButton withSearch">
            <form class="input-group shadow-sm search input-group-navbar" action="" method="get">
                <input
                    type="text"
                    name="email"
                    value="{{ request('email') }}"
                    class="form-control"
                    placeholder="{{ __('title.referrer_email') }}"
                    aria-label="{{ __('title.referrer_email') }}"
                >
                <button class="btn" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-search align-middle"
                    >
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <div class="row users">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table class="mb-0 table users">
                        <thead>
                        <tr>
                            <th>@sortablelink('user_id', __('title.user.referrer'))</th>
                            <th>@sortablelink('referral_id', __('title.user.referral'))</th>
                            <th>{{ __('title.created_at') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($referrals as $item)
                        <tr>
                            <td><a href="{{ Route('admin.user.edit', $item->user_id) }}">{{ $item->user->email }}</a></td>
                            <td><a href="{{ Route('admin.user.edit', $item->referral_id) }}">{{ $item->referral_id }}</a></td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $referrals->appends(request()->query())->links('includes.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
