@extends('layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.menu.payments') }}</h3>
        </div>
        <div class="topButton">
            <a href="{{ Route('admin.payment.index') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-chevron-left align-middle me-2"
                    >
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    {{ __('title.btn.return') }}
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="mb-0 card-title h5" tag="h5">{{ __('title.payment.update') }}</div>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ Route('admin.payment.update', $payment) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="inputName">{{ __('title.user_id') }}</label>
                                            <input name="user_id" placeholder="{{ __('title.user_id') }}"
                                                   type="text" id="inputName" class="form-control"
                                                   value="{{ $payment->user_id }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('title.payment.full_amount') }}</label>
                                            <input name="full_amount" placeholder="{{ __('title.payment.full_amount') }}"
                                                   type="text" id="inputName" class="form-control"
                                                   value="{{ $payment->full_amount }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('title.payment.amount') }}</label>
                                            <input name="amount" placeholder="{{ __('title.payment.amount') }}"
                                                   type="text" id="inputName" class="form-control"
                                                   value="{{ $payment->amount }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('title.payment.commission_amount') }}</label>
                                            <input name="commission_amount" placeholder="{{ __('title.payment.commission_amount') }}"
                                                   type="text" id="inputName" class="form-control"
                                                   value="{{ $payment->commission_amount }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                @if($payment->status === \App\Enums\PaymentStatus::CREATE)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('title.status') }}</label>
                                                {!! Form::select('status', \App\Enums\PaymentStatus::$list, $payment->status, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">{{ __('title.status') }}</label>
                                                <input name="status" placeholder="{{ __('title.status') }}"
                                                       type="text" id="inputName" class="form-control"
                                                       value="{{ \App\Enums\PaymentStatus::$list[$payment->status] }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if($payment->status === \App\Enums\PaymentStatus::CREATE)
                        <button type="submit" class="btn btn-primary">
                            {{ __('title.btn.update') }}
                        </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
