<table class="my-0 table table-striped">
    <thead>
    <tr>
        <th>{{ __('title.user_id') }}</th>
        <th>{{ __('title.created_at') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($user->referrals as $item)
        <tr>
            <td>{{ $item->referral_id }}</td>
            <td>{{ $item->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
