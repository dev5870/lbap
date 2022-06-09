@extends('cabinet.layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('cabinet.log.my') }}</h3>
        </div>
    </div>
    <div class="row users">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table class="mb-0 table users">
                        <thead>
                        <tr>
                            <th>{{ __('title.ip') }}</th>
                            <th>{{ __('title.user_agent') }}</th>
                            <th>@sortablelink('created_at', __('title.created_at'))</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($logs as $item)
                        <tr>
                            <td>{{ $item->ip }}</td>
                            <td>{{ $item->user_agent }}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $logs->appends(request()->query())->links('cabinet.includes.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
