@extends('cabinet.layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ $content->title }}</h3>
        </div>
        <div class="topButton">
            <a href="{{ Route('cabinet.content.index') }}">
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
    <div class="flex-fill w-100 card table-responsive users">
        <p style="margin: 8px;">
            <img src="{{ $content->file ? '/storage/' . $item->file?->file_name : asset('assets/img/default.jpg')}}" style="width: 30% !important; float: left; margin-right: 10px;           " alt="">

            {{ $content->text }}
        </p>
    </div>
    <div>
        {{ $content->delayed_time_publication }}
    </div>
@endsection
