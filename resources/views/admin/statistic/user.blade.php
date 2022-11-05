@extends('layouts.default', ['title' => __('title.statistic.user_statistics')])
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.statistic.user_statistics') }}</h3>
        </div>
    </div>
    <div class="flex-fill w-100 card table-responsive users">
        <table class="my-0 table table-striped users">
            <thead>
            <tr>
                <th>{{ __('title.statistic.date') }}</th>
                <th>{{ __('title.statistic.total') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($statistics as $item)
                <tr>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginationBlock">
        {{ $statistics->appends(request()->query())->links('includes.pagination') }}
    </div>
@endsection
