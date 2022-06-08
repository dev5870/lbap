<table class="my-0 table table-striped">
    <thead>
    <tr>
        <th class="d-none d-md-table-cell">{{ __('cabinet.content.title') }}</th>
        <th class="d-none d-xl-table-cell">{{ __('cabinet.content.preview') }}</th>
        <th class="text-center">{{ __('cabinet.content.show') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($lastContents as $item)
        <tr>
            <td>{{ $item->title }}</td>
            <td>{{ $item->preview }}</td>
            <td class="text-center">
                <a href="{{ Route('admin.user.edit', $item) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather align-middle me-2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
