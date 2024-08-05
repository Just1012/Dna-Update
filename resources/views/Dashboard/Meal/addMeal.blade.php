@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
@endpush
@section('title')
    Create New Meal
@endsection
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create New Meal</h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('meal.index') }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('meal.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title Ar</label>
                                                <input type="text" class="form-control" name="title_ar"
                                                    placeholder="Title Ar" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title En</label>
                                                <input type="text" class="form-control" name="title_en"
                                                    placeholder="Title En" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Type</h6>
                                                <select class="js-example-basic-multiple" name="type">
                                                        <option selected disabled>-- Select Meal Type --</option>
                                                        <option value="1">Main</option>
                                                        <option value="0">Sub</option>
                                                </select>

                                            </div>
                                        </div><!--end col-->



                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Calories Ar</label>
                                                <input type="text" class="form-control" name="calories_ar"
                                                    placeholder="Calories Ar" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Calories En</label>
                                                <input type="text" class="form-control" name="calories_en"
                                                    placeholder="Calories En" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->


                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div><!--end col-->
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
