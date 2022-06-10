@extends('cabinet.layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.content.many') }}</h3>
        </div>
    </div>
    <div class="flex-fill w-100 card table-responsive users">
        <table class="my-0 table table-striped users">
            <thead>
            <tr>
                <th>{{ __('title.content.title') }}</th>
                <th>{{ __('title.content.preview') }}</th>
                <th>@sortablelink('created_at',  __('title.created_at'))</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($contents as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->preview }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td class="text-center">
                        <a href="{{ Route('cabinet.content.show', $item) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather align-middle me-2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginationBlock">
        {{ $contents->appends(request()->query())->links('includes.pagination') }}
    </div>
@endsection
