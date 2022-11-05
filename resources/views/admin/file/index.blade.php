@extends('layouts.default', ['title' => __('title.menu.files')])
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.menu.files') }}</h3>
        </div>
        <div class="topButton withSearch">
            <form class="input-group shadow-sm search input-group-navbar" action="" method="get">
                <input
                    type="text"
                    name="id"
                    value="{{ request('id') }}"
                    class="form-control"
                    placeholder="{{ __('title.id') }}"
                    aria-label="{{ __('title.id') }}"
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
                            <th></th>
                            <th>@sortablelink('fileable_id', __('title.file.fileable_id'))</th>
                            <th>{{ __('title.file.name') }}</th>
                            <th>{{ __('title.file.fileable_type') }}</th>
                            <th>@sortablelink('created_at', __('title.created_at'))</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($files as $item)
                        <tr>
                            <td><img src="/storage/{{ $item->file_name }}" style="width: 30px"></td>
                            @if($item->fileable_type == 'App\Models\User')
                                <td><a href="{{ Route('admin.user.edit', $item->fileable_id) }}">{{ $item->user->id }}</a></td>
                            @else
                                <td><a href="{{ Route('admin.content.edit', $item->fileable_id) }}">{{ $item->content->id }}</a></td>
                            @endif
                            <td>{{ $item->file_name }}</td>
                            <td>{{ $item->fileable_type }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td class="text-center">
                                <a data-bs-toggle="modal" data-bs-target="#deleteModal_{{ $item->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather align-middle me-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                            </td>
                        </tr>
                        @include('includes.delete-modal', ['id' => 'deleteModal_'.$item->id, 'action' => Route('admin.user.removeFile', $item)])
                        @endforeach
                        </tbody>
                    </table>
                    {{ $files->appends(request()->query())->links('includes.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
