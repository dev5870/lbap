@extends('cabinet.layouts.default')
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
                    @if($item->file)
                        <img class="card-img" width="100%" src="/storage/{{ $item->file->file_name }}"
                             alt="Card image cap">
                    @else
                        <img class="card-img" width="100%" src="/storage/"
                             alt="Card image cap">
                    @endif
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
