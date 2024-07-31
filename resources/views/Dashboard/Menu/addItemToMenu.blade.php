@extends('layouts.web')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
@endpush
@section('title')
Create New Items For Menu {{ App::getLocale() == 'ar' ? $menu->title_ar : $menu->title_en }}
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="col-md-9 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Create New Items For Menu {{ App::getLocale() == 'ar' ? $menu->title_ar : $menu->title_en }}
                        </h4>
                        <div class="card-body ">
                            <div class="listjs-table" id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <div>
                                            <a class="btn btn-success add-btn" id="create-btn"
                                                href="{{ route('menuItem.index',$menu->id) }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                                <form  action="{{ route('menuItem.storeItem') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <input name="menu_id" type="hidden" value="{{ $menu->id }}">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="form-label">Categories</h6>
                                                <select class="form-control" id="categories" name="category_id" onchange="toggleInput()">
                                                    <optgroup label="Stages">
                                                        <option value="" disabled selected>-- Select Category --</option>
                                                        @foreach ($category as $cate)
                                                        <option value="{{ $cate->id }}">
                                                            {{ App::getLocale() == 'ar' ? $cate->title_ar : $cate->title_en }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-semibold">Items</h6>
                                            <select class=" js-example-disabled-multi"  multiple="multiple" id="items" name="items[]" required>
                                                <!-- Options will be dynamically added here -->
                                            </select>
                                        </div>

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

                    var subcategoriesContainer = $('#items');
                    var subcategoriesUrl = "{{ route('menuItem.getItem', ['id' => ':categoryId']) }}";

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
                                    '<option value="" selected disabled>-- Select Item --</option>';
                                $.each(data, function(index, item) {

                                    subcategoriesSelect += '<option value="' + item.id +
                                        '"' + '>' +
                                        (
                                            {{ App::getLocale() == 'ar' ? 'item.title_ar' : 'item.title_en' }}
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
