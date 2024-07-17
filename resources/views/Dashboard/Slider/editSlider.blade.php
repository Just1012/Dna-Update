@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
@endpush
@section('title')
    Edit Slider
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Slider</h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('slider.index') }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('slider.update', ['id' => $id->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="address1ControlTextarea" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="image" id="address1ControlTextarea">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Type</h6>
                                                <select class="js-example-basic-multiple" name="type">
                                                    <option disabled>-- Select Slider Type --</option>
                                                    <option value="1" @if($id->type == '1') selected @endif>Main</option>
                                                    <option value="0" @if($id->type == '0') selected @endif>Sub</option>
                                                </select>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title Ar</label>
                                                <input type="text" class="form-control" name="title_ar" placeholder="Title Ar" value="{{ $id->title_ar }}" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title En</label>
                                                <input type="text" class="form-control" name="title_en" placeholder="Title En" value="{{ $id->title_en }}" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Description Ar</label>
                                                <textarea class="form-control" name="description_ar" placeholder="Description Ar" id="myeditorinstance">{{ $id->description_ar }}</textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Description En</label>
                                                <textarea class="form-control" name="description_en" placeholder="Description En" id="myeditorinstance">{{ $id->description_en }}</textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Slider URL</label>
                                                <input type="text" class="form-control" name="link" placeholder="ex : https://www.example.com" value="{{ $id->link }}" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Slider Btn Text</label>
                                                <input type="text" class="form-control" name="link_btn" placeholder="Slider Btn Text" value="{{ $id->link_btn }}" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="colorInput1" class="form-label">Btn Text Color</label>
                                                <input type="color" class="form-control" name="link_btn_color" value="{{ $id->link_btn_color }}" id="colorInput1">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="colorInput2" class="form-label">Btn Background Color</label>
                                                <input type="color" class="form-control" name="link_btn_bg" value="{{ $id->link_btn_bg }}" id="colorInput2">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div><!--end col-->
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
