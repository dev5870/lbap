@extends('layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.menu.addresses') }}</h3>
        </div>
        <div class="topButton">
            <a href="{{ Route('admin.address.create') }}">
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
                <th>@sortablelink('id',  __('title.id'))</th>
                <th>{{ __('title.address.title') }}</th>
                <th>{{ __('title.user_id') }}</th>
                <th>{{ __('title.payment_system.title') }}</th>
                <th>@sortablelink('created_at',  __('title.created_at'))</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($addresses as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->address }}</td>
                    @if($item->user_id)
                        <td><a href="{{ Route('admin.user.edit', $item->user_id) }}">{{ $item->user_id }}</a></td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $item->paymentSystem->name }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginationBlock">
        {{ $addresses->appends(request()->query())->links('includes.pagination') }}
    </div>
@endsection
