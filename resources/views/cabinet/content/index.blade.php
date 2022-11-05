@extends('cabinet.layouts.default', ['title' => __('title.content.many')])
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ __('title.content.many') }}</h3>
        </div>
    </div>
    <div class="row">
        @foreach ($contents as $item)
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <img src="{{ $item->file ? '/storage/' . $item->file?->file_name : asset('assets/img/default.jpg')}}" style="width: 100%" alt="">
                    <div class="card-header">
                        <div class="mb-0 card-title h5">{{ $item->title }}</div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            {{ $item->preview }}
                        </p>
                        <a class="card-link" href="{{ Route('cabinet.content.show', $item) }}">
                            {{ __('cabinet.content.read') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="paginationBlock">
        {{ $contents->appends(request()->query())->links('includes.pagination') }}
    </div>
@endsection
