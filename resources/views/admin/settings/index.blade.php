@extends('layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.menu.general') }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        <form class="" method="POST" action="{{ Route('admin.settings.general') }}" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <dt class="">{{ __('title.settings.site') }}</dt>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('title.site_name') }}</label>
                                        <input name="site_name" class="form-control" value="{{ $settings->site_name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('title.settings.registration_method') }}</label>
                                        {!! Form::select('registration_method', \App\Enums\RegistrationMethod::$list, $settings->registration_method, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ __('title.btn.update') }}
                            </button>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection
