<table class="my-0 table table-striped">
    <thead>
    <tr>
{{--        <th class="d-none d-md-table-cell"></th>--}}
        <th class="d-none d-md-table-cell">{{ __('title.id') }}</th>
        <th class="d-none d-md-table-cell">{{ __('title.email') }}</th>
        <th class="d-none d-xl-table-cell">{{ __('title.created_at') }}</th>
        <th class="d-none d-md-table-cell">{{ __('title.user.role') }}</th>
        <th class="text-center">{{ __('title.action') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $item)
        <tr>
{{--            <td><img src="{{ $item->files()->latest('created_at')->first()?->fileLink() ?? asset('assets/img/logo.png') }}" width="32" height="32" class="rounded-circle my-n1" alt="Avatar"></td>--}}
            <td>{{ $item->id }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->created_at }}</td>
            <td class="roles-col">
                @foreach ($item->roles()->get() as $role)
                    <span class="badge {{ $role->id === 1 ? 'bg-success' : 'bg-primary' }}">{{ $role->name }}</span>
                @endforeach
            </td>
            <td class="text-center">
                <a href="{{ Route('admin.user.edit', $item) }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather align-middle me-2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                <a data-bs-toggle="modal" data-bs-target="#deleteModal_{{ $item->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather align-middle me-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
            </td>
        </tr>
        @include('includes.delete-modal', ['id' => 'deleteModal_'.$item->id, 'action' => Route('admin.user.destroy', $item)])
    @endforeach
    </tbody>
</table>
