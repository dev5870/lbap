@extends('layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.content.title') }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="mb-0 card-title h5" tag="h5">{{ __('title.add') }}</div>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ Route('admin.content.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="inputName">{{ __('title.title') }}</label>
                                            <input name="title" placeholder="{{ __('title.title') }}"
                                                   type="text" id="inputName" class="form-control"
                                                   value="{{ old('title') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="inputName">
                                                {{ __('title.type') }}
                                            </label>

                                            {!! Form::select('type_id', \App\Enums\ContentType::$list, 1, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('title.anons') }}</label>
                                            <textarea name="anons" placeholder="{{ __('title.anons') }}"
                                                      class="form-control" rows="5">{{ old('anons') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('title.full_text') }}</label>
                                            <textarea name="full_text" placeholder="{{ __('title.full_text') }}"
                                                      class="form-control" rows="15">{{ old('full_text') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            {{ __('title.btn.create') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
