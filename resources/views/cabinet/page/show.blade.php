@extends('cabinet.layouts.default', ['title' => $page->title])
@section('content')
    <div class="mb-2 mb-xl-3 d-flex justify-content-between">
        <div class="">
            <h3>{{ $page->title }}</h3>
        </div>
    </div>
    <div class="flex-fill w-100 card table-responsive users">
        <p style="margin: 8px;">
            {{ $page->text }}
        </p>
    </div>
@endsection
