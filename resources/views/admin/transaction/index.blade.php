@extends('layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.menu.transactions') }}</h3>
        </div>
    </div>
    <div class="flex-fill w-100 card table-responsive users">
        <table class="my-0 table table-striped users">
            <thead>
            <tr>
                <th>@sortablelink('id',  __('title.id'))</th>
                <th>{{ __('title.payment.id') }}</th>
                <th>{{ __('title.payment.type') }}</th>
                <th>{{ __('title.payment.method') }}</th>
                <th>{{ __('title.payment.full_amount') }}</th>
                <th>{{ __('title.payment.amount') }}</th>
                <th>{{ __('title.payment.commission_amount') }}</th>
                <th>{{ __('title.transaction.new_balance') }}</th>
                <th>{{ __('title.transaction.old_balance') }}</th>
                <th>@sortablelink('created_at',  __('title.created_at'))</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><a href="{{ Route('admin.payment.edit', $item->payment_id) }}">{{ $item->payment_id }}</a></td>
                    <td>{{ $item->payment->type->name }}</td>
                    <td>{{ \App\Enums\PaymentMethod::$list[$item->payment->method] }}</td>
                    <td>{{ $item->full_amount }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ $item->commission_amount }}</td>
                    <td>{{ $item->new_balance }}</td>
                    <td>{{ $item->old_balance }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginationBlock">
        {{ $transactions->appends(request()->query())->links('includes.pagination') }}
    </div>
@endsection
