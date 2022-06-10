@extends('cabinet.layouts.default')
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ $content->title }}</h3>
        </div>
    </div>
    <div class="flex-fill w-100 card table-responsive users">
        {{ $content->text }}
    </div>
    <div>
        {{ $content->delayed_time_publication }}
    </div>
@endsection
