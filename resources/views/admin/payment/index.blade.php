@extends('layouts.default', ['title' => __('title.menu.payments')])
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.menu.payments') }}</h3>
        </div>
        <div class="topButton">
            <a href="{{ Route('admin.payment.create') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-plus align-middle me-2"
                    >
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    {{ __('title.btn.create') }}
                </button>
            </a>
        </div>
    </div>
    <div class="filters row">
        <div class="col-12 col-md-6 col-xl-4 col-xxl-3">
            <form class="input-group shadow-sm search input-group-navbar" action="" method="get">
                <input
                    type="text"
                    name="user"
                    value="{{ request('title') }}"
                    class="form-control"
                    placeholder="{{ __('title.user_id') }}"
                    aria-label="{{ __('title.user_id') }}"
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
    <div class="flex-fill w-100 card table-responsive users">
        <table class="my-0 table table-striped users">
            <thead>
            <tr>
                <th>@sortablelink('title',  __('title.id'))</th>
                <th>{{ __('title.user_id') }}</th>
                <th>{{ __('title.status') }}</th>
                <th>{{ __('title.payment.type') }}</th>
                <th>{{ __('title.payment.method') }}</th>
                <th>{{ __('title.payment.full_amount') }}</th>
                <th>{{ __('title.payment.amount') }}</th>
                <th>{{ __('title.payment.commission_amount') }}</th>
                <th>@sortablelink('paid_at',  __('title.paid_at'))</th>
                <th>@sortablelink('created_at',  __('title.created_at'))</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($payments as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><a href="{{ Route('admin.user.edit', $item->user_id) }}">{{ $item->user_id }}</a></td>
                    <td>{{ \App\Enums\PaymentStatus::$list[$item->status] }}</td>
                    <td>{{ $item->type->name }}</td>
                    <td>{{ \App\Enums\PaymentMethod::$list[$item->method] }}</td>
                    <td>{{ $item->full_amount }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ $item->commission_amount }}</td>
                    <td>{{ $item->paid_at }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td class="text-center">
                        <a href="{{ Route('admin.payment.edit', $item) }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather align-middle me-2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginationBlock">
        {{ $payments->appends(request()->query())->links('includes.pagination') }}
    </div>
@endsection
