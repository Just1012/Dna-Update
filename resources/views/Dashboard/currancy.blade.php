@extends('layouts.web')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
@endpush
@section('title')
Currency
@endsection
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="col-md-9 mx-auto">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title mb-0">Currency</h4>
                    <div class="card-body ">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-3">

                            </div>
                            <form action="{{ route('Currency.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name"
                                            value="{{ $data ? $data->name : '' }}" placeholder="name" id="firstNameinput">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label">Symbol AR</label>
                                            <input type="text" class="form-control" name="symble_ar"
                                               value="{{ $data ? $data->symble_ar : '' }}" placeholder="Symbol AR"
                                                id="firstNameinput">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label">Symbol EN</label>
                                            <input type="text" class="form-control" name="symble_en"
                                                  value="{{ $data ? $data->symble_en : '' }}" placeholder="Symbol EN"
                                                id="firstNameinput">
                                        </div>
                                    </div>
                                    <!--end col-->



                                    <div class="col-lg-12">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">{{$data?
                                                'Update':'Save'}}</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                            </form>
                        </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>
@endpush
