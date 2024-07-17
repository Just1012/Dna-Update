@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
@endpush
@section('title')
    Add New Program
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create New Program</h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn" href="{{ route('program.index') }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('program.updateProgram', ['id' => $id->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title Ar</label>
                                                <input value="{{ $id->title_ar }}" type="text" class="form-control" name="title_ar"
                                                    placeholder="Title Ar" id="titleArInput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Title En</label>
                                                <input value="{{ $id->title_en }}" type="text" class="form-control" name="title_en"
                                                    placeholder="Title En" id="titleEnInput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Description Ar</label>
                                                <textarea style="height:100px" class="form-control" name="description_ar" placeholder="Description Ar">{{ $id->description_ar }}</textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="titleEnTextarea" class="form-label">Description En</label>
                                                <textarea style="height:100px" class="form-control" name="description_en" placeholder="Description En">{{ $id->description_en }}</textarea>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="address1ControlTextarea" class="form-label">Image</label>
                                                <input type="file" class="form-control" name="image"
                                                    id="address1ControlTextarea">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="firstNameinput" class="form-label">Min-Meals</label>
                                                <input value="{{ $id->min_meals }}" type="number" class="form-control" name="min_meals"
                                                    placeholder="Title En" id="firstNameinput">
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fw-semibold">Menus</h6>
                                                <select class="js-example-basic-multiple" id="categories" name="menu_id" required>
                                                    <optgroup label="Menu">
                                                        <option value="" disabled>-- Select Menu --</option>
                                                        @foreach ($menu as $val)
                                                            <option value="{{ $val->id }}"
                                                                {{ (old('menu_id', $id->menu_id) == $val->id) ? 'selected' : '' }}>
                                                                {{ App::getLocale() == 'ar' ? $val->title_ar : $val->title_en }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                            <label>
                                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $id->is_featured ?? 0) == 1 ? 'checked' : '' }}>
                                                Mark as Featured
                                            </label>
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-success mt-2">Update</button>
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
