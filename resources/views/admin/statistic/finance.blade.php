@extends('layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.statistic.finance') }}</h3>
        </div>
    </div>
    <div class="flex-fill w-100 card table-responsive users">
        <table class="my-0 table table-striped users">
            <thead>
            <tr>
                <th>{{ __('title.statistic.date') }}</th>
                <th>{{ __('title.statistic.full_amount_top_up') }}</th>
                <th>{{ __('title.statistic.full_amount_withdraw') }}</th>
                <th>{{ __('title.statistic.amount_top_up') }}</th>
                <th>{{ __('title.statistic.amount_withdraw') }}</th>
                <th>{{ __('title.statistic.commission_amount') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($statistics as $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->full_amount_top_up }}</td>
                    <td>{{ $item->full_amount_withdraw }}</td>
                    <td>{{ $item->amount_top_up }}</td>
                    <td>{{ $item->amount_withdraw }}</td>
                    <td>{{ $item->commission_amount }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginationBlock">
        {{ $statistics->appends(request()->query())->links('includes.pagination') }}
    </div>
@endsection
