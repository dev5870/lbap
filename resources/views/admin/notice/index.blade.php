@extends('layouts.default', ['title' => __('title.menu.notices')])
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.menu.notices') }}</h3>
        </div>
    </div>
    <div class="flex-fill w-100 card table-responsive users">
        <table class="my-0 table table-striped users">
            <thead>
            <tr>
                <th>@sortablelink('id', __('title.id'))</th>
                <th>{{ __('title.content.title') }}</th>
                <th>{{ __('title.notice.description') }}</th>
                <th>{{ __('title.created_at') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($notices as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginationBlock">
        {{ $notices->appends(request()->query())->links('includes.pagination') }}
    </div>
@endsection
