@extends('layouts.default', ['title' => __('title.statistic.finance_statistics')])
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.statistic.finance_statistics') }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title h5">
                        {{ __('title.statistic.general') }}
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('title.statistic.name') }}</th>
                        <th>{{ __('title.statistic.value') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ __('title.statistic.total_user_balance') }}</td>
                        <td>{{ $totalUserBalance }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('title.statistic.full_amount_top_up') }}</td>
                        <td>{{ $totalPaymentTopUpSum }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('title.statistic.full_amount_withdraw') }}</td>
                        <td>{{ $totalPaymentWithdrawSum }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('title.statistic.diff_balance') }}</td>
                        <td>{{ $balanceDifference }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title h5">
                        {{ __('title.statistic.commission') }}
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('title.statistic.name') }}</th>
                        <th>{{ __('title.statistic.value') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ __('title.statistic.total_commission') }}</td>
                        <td>{{ $totalCommission->value }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('title.statistic.total_referral_payments') }}</td>
                        <td>{{ $totalReferralPayments }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title h5">
                        {{ __('title.statistic.payments') }}
                    </div>
                    <h6 class="card-subtitle text-muted">
                        {{ __('title.statistic.info_1') }}
                    </h6>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('title.statistic.date') }}</th>
                            <th>{{ __('title.payment.full_amount') }}</th>
                            <th>{{ __('title.payment.amount') }}</th>
                            <th>{{ __('title.statistic.commission_amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statistics as $item)
                            <tr>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->full_amount }}</td>
                                <td>{{ $item->amount }}</td>
                                <td>{{ $item->commission_amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="paginationBlock">
        {{ $statistics->appends(request()->query())->links('includes.pagination') }}
    </div>
@endsection
