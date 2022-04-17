@extends('layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.user.title') }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="mb-0 card-title h5" tag="h5">{{ __('title.user.update') }}</div>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ Route('admin.user.update', $user) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input name="email" placeholder="Email" type="email" class="form-control" value="{{ $user->email }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('title.user.role') }}</label>
                                            <select class="roles form-control" multiple="multiple" name="roles[]">
                                                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                                <option class="form-control" value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('title.lang') }}</label>
                                            <select name="language" class="form-select" required>
                                                @foreach(__('title.language.all') as $key => $language)
                                                    <option value="{{ $key }}" {{ $user->language === $key ? 'selected' : '' }}>{{ $language }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
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
