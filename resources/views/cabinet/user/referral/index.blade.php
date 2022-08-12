@extends('cabinet.layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.user.referrals') }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title h5">
                        {{ __('cabinet.referral.statistics') }}
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
                        <td>{{ __('cabinet.referral.total_amount') }}</td>
                        <td>{{ $totalPaidAmount }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('cabinet.referral.total_referrals') }}</td>
                        <td>{{ $totalReferrals }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title h5">
                        {{ __('cabinet.referral.info') }}
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
                        <td>{{ __('cabinet.referral.link') }}</td>
                        <td>{{ $link }}</td>
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
                        {{ __('cabinet.referral.list') }}
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('title.referral_uuid') }}</th>
                        <th>{{ __('title.created_at') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($referrals as $item)
                        <tr>
                            <td>{{ $item->params->user_uuid }}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="paginationBlock">
        {{ $referrals->appends(request()->query())->links('includes.pagination') }}
    </div>
@endsection
