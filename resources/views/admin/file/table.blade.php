<table class="my-0 table table-striped">
    <thead>
    <tr>
        <th></th>
        <th>{{ __('title.file.name') }}</th>
        <th>{{ __('title.file.description') }}</th>
        <th>@sortablelink('created_at', __('title.created_at'))</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($user))
            @foreach ($user->files as $item)
                <tr>
                    <td><img src="/storage/{{ $item->file_name }}" style="width: 30px"></td>
                    <td><a href="/storage/{{ $item->file_name }}" target="_blank">{{ $item->file_name }}</a></td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
            @endforeach
        @elseif($content->file)
            <tr>
                <td><img src="/storage/{{ $content->file->file_name }}" style="width: 30px"></td>
                <td><a href="/storage/{{ $content->file->file_name }}" target="_blank">{{ $content->file->file_name }}</a></td>
                <td>{{ $content->file->description }}</td>
                <td>{{ $content->file->created_at }}</td>
            </tr>
        @endif
    </tbody>
</table>
