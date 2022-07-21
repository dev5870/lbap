<table class="my-0 table table-striped">
    <thead>
    <tr>
        <th>@sortablelink('title',  __('title.id'))</th>
        <th>{{ __('title.status') }}</th>
        <th>{{ __('title.payment.type') }}</th>
        <th>{{ __('title.payment.method') }}</th>
        <th>{{ __('title.payment.full_amount') }}</th>
        <th>{{ __('title.payment.amount') }}</th>
        <th>{{ __('title.payment.commission_amount') }}</th>
        <th>@sortablelink('paid_at',  __('title.paid_at'))</th>
        <th>@sortablelink('created_at',  __('title.created_at'))</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if(isset($user))
        @foreach ($user->payments as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ \App\Enums\PaymentStatus::$list[$item->status] }}</td>
                <td>{{ $item->type->name }}</td>
                <td>{{ \App\Enums\PaymentMethod::$list[$item->method] }}</td>
                <td>{{ $item->full_amount }}</td>
                <td>{{ $item->amount }}</td>
                <td>{{ $item->commission_amount }}</td>
                <td>{{ $item->paid_at }}</td>
                <td>{{ $item->created_at }}</td>
                <td class="text-center">
                    <a href="{{ Route('admin.payment.edit', $item) }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather align-middle me-2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
