@extends('layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.user.many') }}</h3>
        </div>
        <div class="topButton withSearch">
            <form class="input-group shadow-sm search input-group-navbar" action="" method="get">
                <input
                    type="text"
                    name="email"
                    value="{{ request('email') }}"
                    class="form-control"
                    placeholder="{{ __('title.email') }}"
                    aria-label="{{ __('title.email') }}"
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
                            <th>@sortablelink('id', __('title.id'))</th>
                            <th>@sortablelink('email', __('title.email'))</th>
                            <th>@sortablelink('created_at', __('title.created_at'))</th>
                            <th>{{ __('title.user.role') }}</th>
                            <th>{{ __('title.status') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td class="roles-col">
                                @foreach ($item->roles()->get() as $role)
                                <span class="badge {{ $role->id === 1 ? 'bg-success' : 'bg-primary' }}">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ \App\Enums\UserStatus::$list[$item->status] }}</td>
                            <td class="text-center">
                                <a href="{{ Route('admin.user.edit', $item) }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather align-middle me-2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $users->appends(request()->query())->links('includes.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
