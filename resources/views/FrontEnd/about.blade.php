@extends('layouts.front')
@section('title', $pageName)

@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@section('content')
    @include('layouts.ex_front.header')

    <div class="all_programs p-5 "  style="margin: 40px 0px; ">
        <div class="container">
        <!-- Displaying dynamic 'about' content -->
        {!! $data->about !!}
        </div>
    </div>
@endsection
