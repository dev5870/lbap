@extends('cabinet.layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.menu.payments') }}</h3>
        </div>
        <div class="topButton">
            <a href="{{ Route('cabinet.payment.create') }}">
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
    <div class="flex-fill w-100 card table-responsive users">
        <table class="my-0 table table-striped users">
            <thead>
            <tr>
                <th>{{ __('title.status') }}</th>
                <th>{{ __('title.notification.type') }}</th>
                <th>{{ __('title.payment.full_amount') }}</th>
                <th>{{ __('title.payment.amount') }}</th>
                <th>{{ __('title.payment.commission_amount') }}</th>
                <th>@sortablelink('paid_at',  __('title.paid_at'))</th>
                <th>@sortablelink('created_at',  __('title.created_at'))</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($payments as $item)
                <tr>
                    <td>{{ \App\Enums\PaymentStatus::$list[$item->status] }}</td>
                    <td>{{ $item->type->name }}</td>
                    <td>{{ $item->full_amount }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ $item->commission_amount }}</td>
                    <td>{{ $item->paid_at }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginationBlock">
        {{ $payments->appends(request()->query())->links('cabinet.includes.pagination') }}
    </div>
@endsection
