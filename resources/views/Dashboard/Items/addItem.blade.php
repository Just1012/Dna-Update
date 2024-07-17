@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
@endpush
@section('title')
    Create New Item
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create New Item</h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>

                                        </div>
                                    </div>
                                    <form action="{{ route('item.storeItem') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label">Title Ar</label>
                                                    <input value="{{ old('title_ar') }}" type="text" class="form-control" name="title_ar"
                                                        placeholder="Title Ar" id="firstNameinput">
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label">Title En</label>
                                                    <input value="{{ old('title_en') }}" type="text" class="form-control" name="title_en"
                                                        placeholder="Title En" id="firstNameinput">
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="titleEnTextarea" class="form-label">Description Ar</label>
                                                    <textarea class="form-control" name="description_ar" placeholder="Description Ar" rows="4"   id="myeditorinstance">{{ old('description_ar') }}</textarea>
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="titleEnTextarea" class="form-label">Description En</label>
                                                    <textarea class="form-control" name="description_en" placeholder="Description En" rows="4"   id="myeditorinstance">{{ old('description_en') }}</textarea>
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <h6 class="fw-semibold">Categories</h6>
                                                    <select class="js-example-basic-multiple" id="categories"
                                                        onchange="toggleInput()" name="category_id">
                                                        <optgroup label="Stages">
                                                            <option value="" disabled selected>Select Category
                                                            </option>
                                                            @foreach ($category as $cate)
                                                                <option value="{{ $cate->id }}">
                                                                    {{ App::getLocale() == 'ar' ? $cate->title_ar : $cate->title_en }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-md-4" id="subsubcategories-container">
                                                <h6 class="fw-semibold">Sub Category</h6>
                                                <select  class="js-example-basic-multiple"
                                                    id="subcat" name="subCategory_id" onchange="subSubCategory1()">
                                                </select>
                                            </div>

                                            <div class="col-md-4" id="subcategories-container">
                                                <h6 class="fw-semibold">Sub Sub Category</h6>
                                                <select class="js-example-basic-multiple" id="subsubcat"
                                                    name="subSubCategory_id">
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="address1ControlTextarea" class="form-label">Image</label>
                                                    <input type="file" class="form-control" name="image"
                                                        id="address1ControlTextarea">
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

        <script>

            function toggleInput() {
                var select = document.getElementById("categories");
                var categoryId = select.value;

                var subcategoriesContainer = $('#subcat');
                var subcategoriesUrl = "{{ route('item.getSubCategory', ['id' => ':categoryId']) }}";

                // Replace :categoryId with the actual category ID
                subcategoriesUrl = subcategoriesUrl.replace(':categoryId', categoryId);

                $.ajax({
                    url: subcategoriesUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Clear previous subcategories
                        subcategoriesContainer.empty();
                        // Append new subcategories dropdown if there are subcategories
                        if (data && data.length > 0) {
                            var subcategoriesSelect = '';
                            subcategoriesSelect +=
                                '<option value="" selected disabled>-- Select Sub Category --</option>';
                            $.each(data, function(index, subcategory) {

                                subcategoriesSelect += '<option value="' + subcategory.id +
                                    '"' + '>' +
                                    (
                                        {{ App::getLocale() == 'ar' ? 'subcategory.title_ar' : 'subcategory.title_en' }}
                                    ) +
                                    '</option>';
                            });


                            subcategoriesContainer.append(subcategoriesSelect);
                            // Bind change event using delegation

                        }
                    },
                    error: function(xhr, status, error) {
                        // Optionally display an error message to the user
                    }
                });
            }

            function subSubCategory1() {
                var select = document.getElementById("subcat");
                var subcategoryId = select.value;
                var subcategoriesContainer = $('#subsubcat');
                var subcategoriesUrl = "{{ route('item.getSubSubCategory', ['id' => ':subcategoryId']) }}";
                // Replace :categoryId with the actual category ID
                subcategoriesUrl = subcategoriesUrl.replace(':subcategoryId', subcategoryId);

                $.ajax({
                    url: subcategoriesUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Clear previous subcategories
                        subcategoriesContainer.empty();
                        // Append new subcategories dropdown if there are subcategories
                        if (data && data.length > 0) {
                            var subcategoriesSelect = '';
                            subcategoriesSelect +=
                                '<option value="" selected disabled>-- Select Sub Sub Category --</option>';
                            $.each(data, function(index, subcategory) {

                                subcategoriesSelect += '<option value="' + subcategory.id +
                                    '"' + '>' +
                                    (
                                        {{ App::getLocale() == 'ar' ? 'subcategory.title_ar' : 'subcategory.title_en' }}
                                    ) +
                                    '</option>';
                            });


                            subcategoriesContainer.append(subcategoriesSelect);
                            // Bind change event using delegation

                        }
                    },
                    error: function(xhr, status, error) {
                        // Optionally display an error message to the user
                    }
                });
            }

        </script>

    @endpush
