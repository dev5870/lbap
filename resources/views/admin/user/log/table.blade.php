<table class="my-0 table table-striped">
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
